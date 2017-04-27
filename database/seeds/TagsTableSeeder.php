<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taggables')->truncate();
        App\Tag::truncate();

        $tags = config('project.tags');

        foreach ($tags as $where => $wtags) {
            foreach ($wtags as $slug => $name) {
                App\Tag::create([
                        'type' => $where,
                        'name' => $name,
                        'slug' => str_slug($slug) ]
                );
//                $type = null;
//                switch ($where) {
//                    case 'articles' :
//                        $type = \App\Article::class;
//                        break;
//                    case 'markets' :
//                        $type = \App\Market::class;
//                        break;
//                    case 'products' :
//                        $type = \App\Product::class;
//                        break;
//                }
//                if (!is_null($type)) {
//
//                }

            }
        }
        $this->command->info('Seeded: tags table');
    }
}
