<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'user_id' => 1,
            'condition_id'=> 1,
            'name' => '腕時計',
            'img_url' =>  '/storage/images/Armani+Mens+Clock.jpg',
            'price' => '15000',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 1,
            'condition_id'=> 2,
            'name' => 'HDD',
            'img_url' =>  '/storage/images/HDD+Hard+Disk.jpg',
            'price' => '5000',
            'description' => '高速で信頼性の高いハードディスク',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 1,
            'condition_id'=> 3,
            'name' => '玉ねぎ3束',
            'img_url' =>  '/storage/images/iLoveIMG+d.jpg',
            'price' => '300',
            'description' => '新鮮な玉ねぎ3束のセット',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 1,
            'condition_id'=> 4,
            'name' => '革靴',
            'img_url' =>  '/storage/images/Leather+Shoes+Product+Photo.jpg',
            'price' => '4000',
            'description' => 'クラシックなデザインの革靴',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 1,
            'condition_id'=> 1,
            'name' => 'ノートPC',
            'img_url' =>  '/storage/images/Living+Room+Laptop.jpg',
            'price' => '45000',
            'description' => '高性能なノートパソコン',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 2,
            'condition_id'=> 2,
            'name' => 'マイク',
            'img_url' =>  '/storage/images/Music+Mic+4632231.jpg',
            'price' => '8000',
            'description' => '高音質のレコーディング用マイク',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 2,
            'condition_id'=> 3,
            'name' => 'ショルダーバッグ',
            'img_url' =>  '/storage/images/Purse+fashion+pocket.jpg',
            'price' => '3500',
            'description' => 'おしゃれなショルダーバッグ',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 2,
            'condition_id'=> 4,
            'name' => 'タンブラー',
            'img_url' =>  '/storage/images/Tumbler+souvenir.jpg',
            'price' => '500',
            'description' => '使いやすいタンブラー',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 2,
            'condition_id'=> 1,
            'name' => 'コーヒーミル',
            'img_url' =>  '/storage/images/Waitress+with+Coffee+Grinder.jpg',
            'price' => '4000',
            'description' => '手動のコーヒーミル',

        ];
        DB::table('items')->insert($data);
          $data = [
            'user_id' => 2,
            'condition_id'=> 2,
            'name' => 'メイクセット',
            'img_url' =>  '/storage/images/make_up_set.jpg',
            'price' => '2500',
            'description' => '便利なメイクアップセット',

        ];
        DB::table('items')->insert($data);
    }
}
