<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendeurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'statut' => ['sometimes', 'in:en_attente,approuve,suspendu,rejete'],
            'name' => ['sometimes', 'string', 'max:255'],
            'nom_boutique' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
