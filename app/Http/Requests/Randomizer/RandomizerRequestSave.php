<?php

namespace App\Http\Requests\Randomizer;

use App\Traits\RandomizerRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;


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
        if($this->input('random_type') == null)
            throw ValidationException::withMessages(["random_type" => "random_type is required."]);
        return array_merge($this->randomRule($this->input('random_type')), $newRule);
    }
}
