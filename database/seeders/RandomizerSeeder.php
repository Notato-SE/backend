<?php

namespace Database\Seeders;

use App\Models\Randomizer\Randomizer;
use App\Models\User;
use App\Traits\RandomizerRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class RandomizerSeeder extends Seeder
{
    use RandomizerRepository;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "inputs" => ['a', 'b', 'c'],
                "name" => "Testing 1",
                "random_type" => 1,
            ],
            [
                "inputs" => ['aa', 'bb', 'cc'],
                "name" => "Testing 2",
                "random_type" => 1,
            ],
            [
                "inputs" => ['a1', 'b1', 'c1'],
                "name" => "Testing 3",
                "group_num" => 2,
                "random_type" => 2,
            ],
            [
                "inputs" => ['a2', 'b2', 'c2'],
                "name" => "Testing 4",
                "group_num" => 1,
                "random_type" => 2,
            ],
            [
                "inputs" => ['a3', 'b3', 'c3'],
                "name" => "Testing 5",
                "list_num" => 2,
                "duplicated" => 1,
                "random_type" => 3,
            ],
            [
                "inputs" => ['a4', 'b4', 'c4'],
                "name" => "Testing 6",
                "list_num" => 1,
                "duplicated" => 1,
                "random_type" => 3,
            ],
            [
                "inputs" => ['a5', 'b5', 'c5'],
                "name" => "Testing 7",
                "list_num" => 2,
                "duplicated" => 0,
                "random_type" => 3,
            ],
            [
                "inputs" => ['a6', 'b6', 'c6'],
                "name" => "Testing 8",
                "list_num" => 1,
                "duplicated" => 0,
                "random_type" => 3,
            ],
        ];

        foreach (User::get() as $user) {
            foreach ($datas as $data) {
                $data['user_id'] = $user->id;
                $data['results'] = $this->getRandomResult($data);

                $data['inputs'] = Arr::except($data, ['results', 'user_id', 'random_type', 'name']);
                $data['inputs'] = json_encode($data['inputs']);
                $data['results'] = json_encode($data['results']);
                Randomizer::create(Arr::only($data, ['results', 'user_id', 'random_type', 'name', 'inputs']));
            }
        }
    }
}
