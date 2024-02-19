<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginUserResuest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'succes' => false,
            'Error' => true,
            'message' => 'Erreur de validation',
            'errorList' => $validator->errors()
        ]));
    }
    public function messages()
    {
        return [
            'email.required' => 'Une adresse mail doit ètre fourni',
            'email.email' => ' adresse email invalide',
            'email.exists' => ' adresse email n\'existe pas',
            'password.required' => 'Le mot de passe est requis'
        ];
    }
}
