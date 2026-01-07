<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:20'],
            'institution' => ['nullable', 'string', 'max:255'],
            'user_type' => ['nullable', Rule::in(['etudiant', 'chercheur', 'enseignant', 'autre'])],
            'grade' => ['nullable', Rule::in([
                'Etudiant Licence',
                'Etudiant Master',
                'Doctorant',
                'Assistant',
                'Maître de Conférences',
                'Professeur',
                'Prof Lycées et Collèges',
                'Chercheur',
                'Autre'
            ])],
            'education_level' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'research_interests' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
