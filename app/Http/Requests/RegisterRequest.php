<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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

            "name" => "required|min:3|max:10|alpha",
            "email" => "required|email|unique:users,email",
            "password" => ["required",
                            "min:8",
                            "regex:/[a-z]/",
                            "regex:/[A-Z]/",
                            "regex:/[0-9]/"
                            ],
            "confirm_password" => "same:password"

        ];
    }

    public function messages() {

        return [

            "name.required" => "Név elvárt!",
            "name.min" => "Túl kevés karakter!",
            "name.max" => "Túl hosszú név!",
            "name.alpha" => "Csak betűk lehetnek!",
            "email.required" => "Email elvárt!",
            "email.email" => "Nem valós email cím!",
            "email.unique" => "Email cím már létezik!",
            "password.required" => "Jelszó elvárt!",
            "password.min" => "Túl rövid jelszó!",
            "password.regex" => "Tartalmaznia kell kis- és nagybetűt és számot!",
            "confirm_password.same" => "Nem egyezik a két jelszó!"

        ];
    }

    public function failedValidation(Validator $validator){
        
        throw new HttpResponseException(response()->json([

            "success" => false,
            "message" => "Adatbeviteli hiba",
            "error" => $validator->errors()

        ]));
    }
}
