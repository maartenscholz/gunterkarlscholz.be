<?php

namespace Gks\Domain\Works;

use Gks\Infrastructure\ValueObjects\Dimension;
use Gks\Infrastructure\ValueObjects\NonZeroUnsignedInteger;
use Gks\Domain\Works\Images\Image;
use Gks\Domain\Works\Images\ImageId;
use GraphAware\Common\Type\Node;
use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\Client\Result\ResultCollection;

class Neo4jWorksRepository implements WorksRepository
{
    /**
     * @var Client
     */
    private $db;

    /**
     * Neo4jWorksRepository constructor.
     *
     * @param Client $db
     */
    public function __construct(Client $db)
    {
        $this->db = $db;
    }

    /**
     * @param Node $workNode
     * @param array|Node[] $imageNodes
     *
     * @return Work
     */
    protected function hydrateItem(Node $workNode, array $imageNodes)
    {
        $titleData = [];
        $titles = $this->getTitleData($workNode);

        foreach ($titles as $key => $title) {
            $keyParts = explode('_', $key);
            array_shift($keyParts);

            $titleData[implode('_', $keyParts)] = $title;
        }

        $workId = WorkId::fromString($workNode->get('id'));
        $type = new Type($workNode->get('type'));
        $title = new Title($titleData);
        $dimension = null;

        if ($workNode->containsKey('width') && $workNode->containsKey('width')) {
            $dimension = new Dimension(
                new NonZeroUnsignedInteger($workNode->get('width')),
                new NonZeroUnsignedInteger($workNode->get('height'))
            );
        }

        $work = new Work($workId, $type, $title, $dimension);

        foreach ($imageNodes as $imageNode) {
            $work->addImage(new Image(ImageId::fromString($imageNode->get('id')), $imageNode->get('path')));
        }

        return $work;
    }

    /**
     * @param ResultCollection $result
     *
     * @return array|Work[]
     */
    protected function hydrateCollection(ResultCollection $result)
    {
        return array_map([$this, 'hydrateItem'], $result->records());
    }

    /**
     * @param ResultCollection $results
     * @param bool $multiple
     *
     * @return array|Work[]|Work
     */
    protected function parseResults(ResultCollection $results, $multiple = false)
    {
        $entities = [];
        $imageNodes = [];

        foreach ($results->get('images')->records() as $imageRecord) {
            $imageNodes[] = $imageRecord->nodeValue('image');
        }

        foreach ($results->get('works')->records() as $workRecord) {
            $entities[] = $this->hydrateItem($workRecord->nodeValue('work'), $imageNodes);
        }

        return $multiple ? $entities : $entities[0];
    }

    /**
     * @param Node $workNode
     *
     * @return array
     */
    protected function getTitleData(Node $workNode)
    {
        return array_filter($workNode->values(), function ($key) {
            return preg_match('/title_*/', $key);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param Work $work
     *
     * @return void
     */
    public function add(Work $work)
    {
        $stack = $this->db->stack();

        $titleData = [];
        $workData = [
            'id' => $work->getWorkId()->getValue(),
            'type' => $work->getType()->getValue(),
        ];

        foreach ($work->getTitle()->getValues() as $language => $title) {
            $titleData['title_'.$language] = $title;
        }

        $workData = array_merge($workData, $titleData);

        $workData['width'] = $work->getDimension() ? $work->getDimension()->getWidth()->getValue() : null;
        $workData['height'] = $work->getDimension() ? $work->getDimension()->getHeight()->getValue() : null;

        $stack->push(
            'MERGE (work:Work {id:"'.$work->getWorkId()->getValue().'"}) SET work += {work}',
            ['work' => $workData]
        );

        if (!empty($work->getImages())) {
            foreach ($work->getImages() as $image) {
                $stack->push(
                    'MERGE (image:Image {id:"'.$image->getImageId().'"}) SET image += {image}',
                    ['image' => [
                        'id' => $image->getImageId()->getValue(),
                        'path' => $image->getPath(),
                    ]]
                );

                $stack->push(
                    'MATCH (image:Image {id:"'.$image->getImageId().'"}), (work:Work {id:"'.$work->getWorkId().'"})
                    CREATE UNIQUE (work)-[r:WORK_IMAGE]->(image)'
                );
            }
        }

        $this->db->runStack($stack);
    }

    /**
     * @param WorkId $workId
     *
     * @return void
     */
    public function remove(WorkId $workId)
    {
        $this->db->run("MATCH (work:Work {id:'$workId'}) DELETE work");
    }

    /**
     * @param WorkId $workId
     *
     * @return Work
     */
    public function findById(WorkId $workId)
    {
        $stack = $this->db->stack();

        $stack->push("MATCH (work:Work {id:'$workId'}) RETURN work", [], 'works');
        $stack->push("MATCH (work:Work {id:'$workId'})-[r:WORK_IMAGE]->(image:Image) RETURN image", [], 'images');

        $results = $this->db->runStack($stack);

        return $this->parseResults($results);
    }

    /**
     * @return array|Work[]
     */
    public function all()
    {
        $stack = $this->db->stack();

        $stack->push('MATCH (work:Work) RETURN work ORDER BY work.title_nl_BE', [], 'works');
        $stack->push('MATCH (image:Image) RETURN image', [], 'images');

        $results = $this->db->runStack($stack);

        return $this->parseResults($results, true);
    }
}
