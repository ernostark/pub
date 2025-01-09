<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TypeRequest extends FormRequest
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
            
            "type" => "required|min:2|max:20|regex:/^[\pL\s]+$/u|unique:types,type"

        ];
    }

    public function messages() {

        return [
            
            "type.required" => "Típus mező nem lehet üres!",
            "type.min" => "Minimum 2 karakter!",
            "type.max" => "Maximum 20 karakter!",
            "type.regex" => "Csak betűk lehetnek!",
            "type.unique" => "Ez a típus már létezik!"

        ];
    }

    public function failedValidation( Validator $validator ) {

        throw new HttpResponseException( response()->json([

            "success" => false,
            "error" => $validator->errors(),
            "message" => "Adatbeviteli hiba!"
            
        ]));
    }
}
