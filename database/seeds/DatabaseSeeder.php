<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sqlite = in_array(config('database.default'), ['sqlite', 'testing'], true);

        if (! $sqlite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        /* 태그 */
        $this->call(TagsTableSeeder::class);

        if (! app()->environment(['production'])) {
            // 운영 환경이 아닐 때만 나머지 시딩을 실행한다.
            $this->seedForDev();
        }

        if (! $sqlite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * Run the seeds which applicable only to development env.
     */
    private function seedForDev()
    {
        /* 초기화 */
        App\Article::truncate();
        App\Attachment::truncate();
        App\Comment::truncate();
        App\Market::truncate();
        App\Option::truncate();
        App\Product::truncate();
        App\Review::truncate();
        App\User::truncate();
        App\Vote::truncate();
        $this->command->info('Truncated: all tables');

        /* Main Seeding */
        $this->call(UsersTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(MarketsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);

        /* 변수 선언 */

        /* 아티클, 마켓, 프로덕트와 태그를 연결 */
        $this->call(TaggablesTableSeeder::class);

        /* 첨부파일 */
        $this->call(AttachmentsTableSeeder::class);

        /* 댓글 & 대댓글 */
        $this->call(CommentsTableSeeder::class);

        /* up % down 투표 */
        $this->call(VotesTableSeeder::class);

        /* 관심목록 */
        $this->call(MarkkablesTableSeeder::class);
    }


}
