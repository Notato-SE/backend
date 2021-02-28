<?php

namespace App\Traits;

use App\Enums\RandomizerType;
use App\Exports\RandomizerExport;
use Maatwebsite\Excel\Concerns\ToArray;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * 
 */
trait RandomizerRepository
{
    public function picker(array $arr, int $num)
    {
        array_random($arr, $num);
        return array(array_rand(array_flip($arr), $num));
    }

    public function group_picker(array $arr, int $group_num)
    {
        shuffle($arr);
        $num = count($arr);

        for ($i = 0; $i < $group_num; ++$i) {
            $group_index = ceil(($num - $i) / $group_num);
            if (!empty($arr)) {
                $members = array_rand(array_flip($arr), $group_index);
                $group_result[] = ($group_index > 1) ? $members : array($members);
                if ($group_index > 1) {
                    foreach ($members as $member) {
                        array_splice($arr, array_search($member, $arr), 1);
                    }
                } else {
                    array_splice($arr, array_search($members, $arr), 1);
                }
            } else {
                break;
            }
        }

        return $group_result;
    }

    public function random_order(array $arr, int $qty, bool $duplicate = false)
    {
        $newArray = array();

        if (count($arr) < $qty) throw new BadRequestException("The size of list must be bigger than or equal to the number.");

        if ($duplicate) {
            for ($i = 0; $i < $qty; ++$i) {
                $newArray[$i] = $arr[rand(0, count($arr) - 1)];
            }
        } else {
            $newArray = array_rand(array_flip($arr), $qty);

            if (!is_array($newArray)) $newArray = array($newArray);
        }

        return $newArray;
    }
    public function getRandomResult($data)
    {
        $randomType = $data['random_type'];
        $result = array();
        switch ($randomType) {
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
    public function exportRandomGroup($totalGroup): array
    {
        foreach ($totalGroup as $group) {
            $groupList[] = array_merge(array(array_search($group, $totalGroup) + 1), $group);
        }

        return $groupList;
    }

    public function exportOrderList($totalOrder)
    {
        foreach ($totalOrder as $order) {
            $orderList[] = array(((array_search($order, $totalOrder)) + 1), $order);
        }
        return $orderList;
    }
    public function exportRandomizer($data)
    {
        $value = json_decode($data->results);
        $randomType = $data['random_type'];
        switch ($randomType) {
            case RandomizerType::GroupPicker:
                $result = $this->exportRandomGroup($value);
                break;
            case RandomizerType::CustomPicker:
                $result = $this->exportOrderList($value);
                break;
            default:
                break;
        }
        return $result;
    }
    public function exportHeading($data): string
    {
        $randomType = $data['random_type'];
        switch ($randomType) {
            case RandomizerType::GroupPicker:
                $result = "Group No";
                break;
            case RandomizerType::CustomPicker:
                $result = "Order No";
                break;
        }
        return $result;
    }
    public function randomRule(int $randomType)
    {
        $rules = [];
        switch ($randomType) {
            case RandomizerType::Picker:
                $rules = [
                    "inputs" => "required|array",
                    "random_type" => "required|integer",
                    "results" => "nullable|array"
                ];
                break;
            case RandomizerType::GroupPicker:
                $rules = [
                    "inputs" => "required|array",
                    "group_num" => "required|integer|min:0",
                    "random_type" => "required|integer",
                    "results" => "nullable|array"
                ];
                break;
            case RandomizerType::CustomPicker:
                $rules = [
                    "inputs" => "required|array",
                    "list_num" => "required|integer|min:0",
                    "duplicated" => "required|boolean",
                    "random_type" => "required|integer",
                    "results" => "nullable|array"
                ];
                break;
        }
        return $rules;
    }
}
