<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'produit_id' => ['required', 'exists:produits,id'],
            'quantite' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
