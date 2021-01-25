<?php

namespace App\Traits;

use App\Enums\RandomizerType;

/**
 * 
 */
trait RandomizerRepository
{
    public function picker(array $arr, int $num)
    {
        array_random($arr, $num);
        return array_rand(array_flip($arr), $num);
    }

    public function group_picker(array $arr, int $group_num)
    {
        shuffle($arr);

        return array_chunk($arr, ceil(count($arr) / $group_num));
    }

    public function random_order(array $arr, int $qty, bool $duplicate = false)
    {
        $newArray = array();

        if ($duplicate) {
            for ($i = 0; $i < $qty; ++$i) {
                $newArray[$i] = $arr[rand(0, count($arr) - 1)];
            }
        } else {
            $newArray = array_rand(array_flip($arr), $qty);
        }

        return $newArray;
    }
    public function getRandomResult($data)
    {
        $randomType = $data['random_type'];
        $result = array();
        switch($randomType)
        {
            case RandomizerType::Picker:
                 $result = $this->picker($data['inputs'], 1);
                 break;
            case RandomizerType::GroupPicker:
                 $result = $this->group_picker($data['inputs'], $data['group_num']);
                break;
            case RandomizerType::CustomPicker:
                $result = $this->random_order($data['inputs'], $data['list_num'], $data['duplicated']);
                break;
        }

        return $result;
    }
}
