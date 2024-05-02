<?php

namespace App\Http\Requests;

use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchFormRequest extends FormRequest
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
            'search' => ['string', 'nullable'],
        ];
    }

    /**
     * Gestion des erreur lorsque la validation echoue
     **/

     public function failedValidation(ValidationValidator $validator)
     {
         throw new HttpResponseException(response()->json([
             'success' => false,
             'error' => true,
             'Message' => 'Erreur de validation',
             'errorsList' => $validator->errors(),
         ],));
     }
}
