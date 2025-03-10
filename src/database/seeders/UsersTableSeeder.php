<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        ];
        DB::table('users')->insert($data);
         $data = [
            'name' => '徳川家康',
            'email'=> 'hurudanuki@gmail.com',
            'password' => Hash::make('ponponpon'),
        ];
        DB::table('users')->insert($data);
        DB::table('users')->insert($data);
         $data = [
            'name' => 'セネカ',
            'email'=> 'seneka@roma.com',
            'password' => Hash::make('senekaseneka'),
        ];
        DB::table('users')->insert($data);
    }
}
