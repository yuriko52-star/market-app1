<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'content' =>'良好',
        ];
        DB::table('conditions')->insert($data);
        $data = [
            'content' =>'目立った傷や汚れなし',
        ];
        DB::table('conditions')->insert($data);
        $data = [
            'content' =>'やや傷や汚れあり',
        ];
        DB::table('conditions')->insert($data);
        $data = [
            'content' =>'状態が悪い',
        ];
        DB::table('conditions')->insert($data);
    }
}
