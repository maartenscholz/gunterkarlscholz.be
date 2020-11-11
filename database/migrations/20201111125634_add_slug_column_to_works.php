<?php

declare(strict_types=1);

use Cocur\Slugify\Slugify;
use Phinx\Migration\AbstractMigration;

final class AddSlugColumnToWorks extends AbstractMigration
{
    public function change(): void
    {
        $this->table('works')
            ->addColumn('slug', 'string', ['after' => 'id'])
            ->update();

        $slugify = new Slugify();

        $works = $this->query('select * from works');

        foreach ($works as $work) {
            $slug = $slugify->slugify($work['title_nl_be']);

            $this->execute('update works set slug = "'.$slug.'" where id = "'.$work['id'].'"');
        }
    }
}
