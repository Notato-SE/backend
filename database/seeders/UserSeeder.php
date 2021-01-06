<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "first_name" => "Vichea",
                "last_name" => "Heng",
                "email" => "vheng@paragoniu.edu.kh",
            ],
            [
                "first_name" => "Bunnarith",
                "last_name" => "Heang",
                "email" => "bheang@paragoniu.edu.kh",
            ],
            [
                "first_name" => "Sovath",
                "last_name" => "Chean",
                "email" => "schean@paragoniu.edu.kh",
            ],
            [
                "first_name" => "Seakmeng",
                "last_name" => "Chheang",
                "email" => "schheang4@paragoniu.edu.kh",
            ],
        ];

        foreach ($users as $user) {
            $user['password'] = bcrypt("password");
            User::create($user);
        }
    }
}
