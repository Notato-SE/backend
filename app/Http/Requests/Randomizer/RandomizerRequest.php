<?php

namespace App\Http\Requests\Randomizer;

use App\Enums\RandomizerType;
use App\Models\Randomizer\Randomizer;
use Illuminate\Foundation\Http\FormRequest;

class RandomizerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getCustomRules($this->input('random_type'));
    }
    public function getCustomRules($input)
    {
        $rules = [];
        switch($input)
        {
            case RandomizerType::Picker:
                $rules = [
                 "inputs" => "required|array",
                 "random_type" => "required|integer",
                 "results" => "array"
                ];
                break;
            case RandomizerType::GroupPicker:
                $rules = [
                 "inputs" => "required|array",
                 "group_num" => "required|integer",
                 "random_type" => "required|integer",
                 "results" => "array"
                ];
                break;
            case RandomizerType::CustomPicker:
                $rules = [
                   "inputs" => "required|array",
                   "list_num" => "required|integer",
                   "duplicated" => "required|boolean",
                   "random_type" => "required|integer",
                   "results" => "array"
                ];
                break;
        }
        return $rules;
    }
}
