<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
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
            'email' =>'required|email',
            'password' =>Password::min(8)
                // ->mixedCase()
                // ->symbols()
                ->numbers(),
        ];
    }

       public function messages(): array
    {
        return [
            // 'email.email' => "email non valide",
            // 'email.required' => "email est requis",
            // 'password.min' => "Au moins 8 caractères",
            // 'password.mixed' => "Au mooins 1 caracter majusculet et 1 caractère minuscules",
            // 'password.symbols' => "Au moins un caractère spécial",
            // 'password.numbers' => "Au moins un chiffre"
        ];
    }
}