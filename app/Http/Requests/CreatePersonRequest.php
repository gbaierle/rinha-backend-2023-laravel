<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePersonRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'apelido' => ['required', 'unique:person,nick', 'string', 'max:32'],
            'nascimento' => ['required', 'date_format:Y-m-d'],
            'stack' => ['sometimes', 'array', 'nullable'],
            'stack.*' => ['string', 'max:32']
        ];
    }
}
