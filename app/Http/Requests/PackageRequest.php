<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PackageRequest extends FormRequest
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

            "package" => "required|max:15|min:2|unique:packages,package"
            
        ];
    }

    public function messages() {

        return [

            "package.required" => "A mező nem lehet üres!",
            "package.max" => "Maximum 15 karakter lehet!",
            "package.min" => "Minimum 2 karakter kell!",
            "package.unique" => "Ilyen már létezik!"

        ];
    }

    public function failedValidation( Validator $validator ) {

        throw new HttpResponseException( response()->json([

            "success" => false,
            "message" => "Adatbeviteli hiba!",
            "data" => $validator->errors()

        ]));
    }
}
