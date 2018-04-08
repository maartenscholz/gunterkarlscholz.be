<?php

namespace Gks\Infrastructure\Persistence\Neo4j;

use Gks\Domain\Works\Images\Image;
use Gks\Domain\Works\Images\ImageId;
use Gks\Domain\Works\Images\ImageRepository;
use GraphAware\Common\Type\Node;
use GraphAware\Neo4j\Client\Client;

class Neo4jImageRepository implements ImageRepository
{
    /**
     * @var Client
     */
    private $db;

    /**
     * @param Client $db
     */
    public function __construct(Client $db)
    {
        $this->db = $db;
    }

    /**
     * @param Node $imageNode
     *
     * @return Image
     */
    protected function hydrateItem(Node $imageNode)
    {
        return new Image(
            ImageId::fromString($imageNode->get('id')),
            $imageNode->value('filename', ''),
            $imageNode->get('path')
        );
    }

    /**
     * @param ImageId $imageId
     *
     * @return Image
     */
    public function findById(ImageId $imageId)
    {
        $result = $this->db->run("MATCH (image:Image {id:'$imageId'}) RETURN image");

        return $this->hydrateItem($result->firstRecord()->nodeValue('image'));
    }

    /**
     * @param ImageId $imageId
     *
     * @return void
     */
    public function remove(ImageId $imageId)
    {
        $this->db->run("MATCH (image:Image {id:'$imageId'})-[rel:WORK_IMAGE]-() DELETE image, rel");
    }
}
