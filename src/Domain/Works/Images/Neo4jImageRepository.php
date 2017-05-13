<?php

namespace Gks\Domain\Works\Images;

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
     * @param ImageId $imageId
     *
     * @return void
     */
    public function remove(ImageId $imageId)
    {
        $this->db->run("MATCH (image:Image {id:'$imageId'})-[rel:WORK_IMAGE]-() DELETE image, rel");
    }
}
