<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'login' => 'required|string|alpha|min:3',
            'password' => 'required|string|min:5'
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'L\'identifiant ne doit pas être vide.',
            'login.alpha' => 'L\'identifiant ne peut contenir que des lettres.',
            'login.min' => 'L\'identifiant doit contenir au moins :min caractères.',
            'password.required' => 'Le mot de passe ne doit pas être vide.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.'
        ];
    }
}
