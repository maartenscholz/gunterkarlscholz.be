<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateWorksTables extends AbstractMigration
{
    public function change(): void
    {
        $this->table('works', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string')
            ->addColumn('type', 'string')
            ->addColumn('title_nl_be', 'string')
            ->addColumn('title_en_us', 'string')
            ->addColumn('title_de_de', 'string')
            ->addColumn('title_fr_fr', 'string')
            ->addColumn('description_nl_be', 'string')
            ->addColumn('description_en_us', 'string')
            ->addColumn('description_de_de', 'string')
            ->addColumn('description_fr_fr', 'string')
            ->addColumn('width', 'integer', ['null' => true])
            ->addColumn('height', 'integer', ['null' => true])
            ->create();

        $this->table('work_images', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string')
            ->addColumn('work_id', 'string')
            ->addColumn('filename', 'string')
            ->addColumn('path', 'string')
            ->create();
    }
}
