<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string|max:255",
            "body" => "required|string",
            "tags" => "array",
            "tags. *" => "string|min:3"
        ];
    }

    // custom error messages
    public function messages(){
        return[
            'title.required' => "You must enter title",
            'title.min' => 'Minumum of :min characters is accepted',
            'title.string' => 'Must be a string',
        ];
    }
}
