<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateDescriptionColumnsToText extends AbstractMigration
{
    public function change(): void
    {
        $this->table('works')
            ->changeColumn('description_nl_be', 'text')
            ->changeColumn('description_en_us', 'text')
            ->changeColumn('description_de_de', 'text')
            ->changeColumn('description_fr_fr', 'text')
            ->save();
    }
}
