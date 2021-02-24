<?php

namespace App\Http\Requests\Randomizer;

use App\Enums\RandomizerType;
use App\Models\Randomizer\Randomizer;
use App\Traits\RandomizerRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;


class RandomizerRequest extends FormRequest
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
        if($this->input('random_type') == null)
            throw ValidationException::withMessages(["random_type" => "random_type is required."]);
       return $this->randomRule($this->input('random_type'));
    }
}
