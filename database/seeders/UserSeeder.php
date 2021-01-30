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
                "full_name" => "Vichea Heng",
                "email" => "vheng@paragoniu.edu.kh",
            ],
            [
                "full_name" => "Bunnarith Heang",
                "email" => "bheang@paragoniu.edu.kh",
            ],
            [
                "full_name" => "Sovath Chean",
                "email" => "schean@paragoniu.edu.kh",
            ],
            [
                "full_name" => "Seakmeng Chheang",
                "email" => "schheang4@paragoniu.edu.kh",
            ],
        ];

        foreach ($users as $user) {
            $user['password'] = bcrypt("password");
            User::create($user);
        }
    }
}
