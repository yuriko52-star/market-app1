<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            'name' => '織田信長',
            'email'=> 'nobu@gmail.com',
            'password' => Hash::make('nobunobunobu'),
            'email_verified_at' => Carbon::now(),
        ];
        DB::table('users')->insert($data);
         $data = [
            'name' => '徳川家康',
            'email'=> 'hurudanuki@gmail.com',
            'password' => Hash::make('ponponpon'),
            'email_verified_at' => Carbon::now(),
        ];
        DB::table('users')->insert($data);
       
         $data = [
            'name' => 'セネカ',
            'email'=> 'seneka@roma.com',
            'password' => Hash::make('senekaseneka'),
            // 'email_verified_at' => Carbon::now(),
        ];
        DB::table('users')->insert($data);
        
    }
}
