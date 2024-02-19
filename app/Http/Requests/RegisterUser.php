<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUser extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'succes' => false,
            'staus_code' => 422,
            'Error' => true,
            'message' => 'Erreur de validation',
            'errorList' => $validator->errors()
        ]));
    }
    public function messages()
    {
        return [
            'name.required' => 'Un nom doit ètre fourni',
            'email.required' => 'Une adresse mail doit ètre fourni',
            'email.unique' => 'Cette adresse email existe deja',
            'password.required' => 'Le mot de passe est requis'

        ];
    }
}
