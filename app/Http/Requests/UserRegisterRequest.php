<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:3'],
        ];
    }

    /**
     * Get the validation error messages
     *
     **/

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis',
            'email.required' => 'Email requis',
            'email.unique' => 'Email exite déjà',
            'password.required' => 'Mot de passe requis',
            'password.min' => 'Le mot de passe doit contenir au moins 3 caractère',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'message' => 'Erreur de validation',
            'errorsList' => $validator->errors( ),
        ]));
    }
}
