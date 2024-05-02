<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePostRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'title.required' => 'Titre requis',
            'title.min' => 'Min 3 caractère',
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
