<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnnonceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasRole('vendeur');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
