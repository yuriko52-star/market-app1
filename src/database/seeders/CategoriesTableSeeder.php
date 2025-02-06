<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'ファッション',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => '家電',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'インテリア',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'レディース',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'メンズ',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'コスメ',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => '本',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'ゲーム',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'スポーツ',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'キッチン',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'ハンドメイド',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'アクセサリー',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'おもちゃ',
        ];
        DB::table('categories')->insert($data);
         $data = [
            'name' => 'ベビー・キッズ',
        ];
        DB::table('categories')->insert($data);
    }
}
