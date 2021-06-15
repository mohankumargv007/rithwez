<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'tag_name' => 'javascript',
                'status' => 1,
                'question_id' => 1
            ]
            , [
                'tag_name' => 'js',
                'status' => 1,
                'question_id' => 1
            ]
            , [
                'tag_name' => 'frontend',
                'status' => 1,
                'question_id' => 1
            ]
            , [
                'tag_name' => 'android',
                'status' => 1,
                'question_id' => 2
            ]
            , [
                'tag_name' => 'javascript',
                'status' => 1,
                'question_id' => 3
            ]
            , [
                'tag_name' => 'js',
                'status' => 1,
                'question_id' => 3
            ]
        ]);
    }
}
