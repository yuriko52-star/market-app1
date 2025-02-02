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
    }
}
