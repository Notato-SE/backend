<?php

namespace App\Http\Requests\Randomizer;

use App\Traits\RandomizerRepository;
use Illuminate\Foundation\Http\FormRequest;

class RandomizerRequestSave extends FormRequest
{
    use RandomizerRepository;
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
        $newRule = ["name" => "required|string"];
        return array_merge($this->randomRule($this->input('random_type')), $newRule);
    }
}
