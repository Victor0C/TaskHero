<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assuming authorization logic here
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|integer|in:0,1',
            ];
        }

        if ($method == 'PUT' || $method == 'PATCH') {
            return [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $this->route('user'),
                'password' => 'sometimes|required|string|min:6',
                'role' => 'sometimes|required|integer|in:0,1',
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
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field cannot exceed 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
            'role.required' => 'The role field is required.',
            'role.integer' => 'The role must be an integer.',
            'role.in' => 'The role must be either 0 or 1.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
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