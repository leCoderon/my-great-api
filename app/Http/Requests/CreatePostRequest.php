<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePostRequest extends FormRequest
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
            'title' => ['required', 'min:3'],
        ];
    }

    /**
     * Personnalisation des messages d'erreur
     * */
    public function messages(): array
    {
        return [
            'title.required' => 'Le champ titre est requis',
            'title.min' => 'Le champ doit contenir au minimum 3 caractèrer',
        ];
    }


    /**
     * Gestion des erreur lorsque la validation echoue
     **/

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'Message' => 'Erreur de validation',
            'errorsList' => $validator->errors(),
        ],));
    }
}
