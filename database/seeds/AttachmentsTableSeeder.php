<?php

use Illuminate\Database\Seeder;

class AttachmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $articles = App\Article::all();
        $markets = App\Market::all();
        $products = App\Product::all();

        if (! File::isDirectory(attachments_path())) {
            File::makeDirectory(attachments_path(), 775, true);
        }

        File::cleanDirectory(attachments_path());

        // public/files/.gitignore 파일이 있어야 커밋할 때 빈 디렉터리를 유지할 수 있다.
        File::put(attachments_path('.gitignore'), "*\n!.gitignore");

        $this->command->error(
            'Downloading ' . ($articles->count()+$markets->count()+$products->count()) . ' images from lorempixel. It takes time...'
        );

        $articles->each(function ($article) use ($faker) {
            $path = $faker->image(attachments_path());
            $filename = File::basename($path);
            $bytes = File::size($path);
            $mime = File::mimeType($path);

            $this->command->warn("File saved: {$filename}");

            $article->attachments()->save(
                factory(App\Attachment::class)->make(compact('filename', 'bytes', 'mime'))
            );
        });

        $products->each(function ($product) use ($faker) {
            $path = $faker->image(attachments_path());
            $filename = File::basename($path);
            $bytes = File::size($path);
            $mime = File::mimeType($path);

            $this->command->warn("File saved: {$filename}");

            $product->attachments()->save(
                factory(App\Attachment::class)->make(compact('filename', 'bytes', 'mime'))
            );

            $product->ad_img_id = $product->attachments->first()->id;
            $product->save();

        });

        $markets->each(function ($market) use ($faker) {
            $path = $faker->image(attachments_path());
            $filename = File::basename($path);
            $bytes = File::size($path);
            $mime = File::mimeType($path);

            $this->command->warn("File saved: {$filename}");

            $market->attachments()->save(
                factory(App\Attachment::class)->make(compact('filename', 'bytes', 'mime'))
            );

            $market->ad_img_id = $market->attachments->first()->id;
            $market->save();

        });

        $this->command->info('Seeded: attachments table');
    }
}
