<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permite que a solicitação seja autorizada.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'POST') {
            return [
                'user_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'expired_date' => 'required|date|after_or_equal:today',
            ];
        }

        if ($method == 'PUT' || $method == 'PATCH') {
            return [
                'title' => 'sometimes|required|string|max:255',
                'desc' => 'sometimes|string',
                'expired_date' => 'sometimes|date|after_or_equal:today',
                'done' => 'sometimes|boolean',
            ];
        }

        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.integer' => 'The user ID must be an integer.',
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'desc.required' => 'The description is required.',
            'desc.string' => 'The description must be a string.',
            'expired_date.required' => 'The expiration date is required.',
            'expired_date.date' => 'The expiration date must be a valid date.',
            'expired_date.after_or_equal' => 'The expiration date must be a date equal to or after today.',
            'done.boolean' => 'The done field must be true or false.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $errors,
        ], 422));
    }
}
