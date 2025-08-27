<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInfosRequest extends FormRequest
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
            'name' => 'required|string|alpha|min:3',
            'email' => 'required|email|min:5',
            'password' => 'required|string|min:5'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'L\'identifiant ne doit pas être vide.',
            'email.required' => 'L\'email ne doit pas être vide.',
            'password.required' => 'Le mot de passe ne doit pas être vide.',
            'name.unique' => 'Identifiant non disponible.',
            'email.unique' => 'Email non disponible.',
            'name.alpha' => 'L\'identifiant ne peut contenir que des lettres.',
            'email.email' => 'Format d\'email invalide.',
            'name.min' => 'L\'identifiant doit contenir au moins :min caractères.',
            'email.min' => 'L\'email doit contenir au moins :min caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.'
        ];
    }
}
