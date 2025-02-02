<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'user_id'=> 1,
            'img_url'=>  '/storage/images/IMG_1307.jpeg',
            'post_code'=>'490-3152',
            'address' =>'愛知県清須市駅前4丁目3-2',
            'building' => '清須城',
        ];
        DB::table('profiles')->insert($data);
    }
}
