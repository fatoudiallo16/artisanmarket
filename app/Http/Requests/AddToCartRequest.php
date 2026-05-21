<?php

namespace App\Http\Requests;

use App\Models\Lignepanier;
use App\Models\Panier;
use App\Models\Produit;
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

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $produit = Produit::find($this->input('produit_id'));
            if (!$produit) {
                return;
            }

            $quantite = (int) ($this->input('quantite') ?? 1);
            $panier = Panier::where('user_id', $this->user()->id)->first();
            $existing = 0;

            if ($panier) {
                $existing = (int) Lignepanier::where('panier_id', $panier->id)
                    ->where('produit_id', $produit->id)
                    ->value('quantite');
            }

            if ($produit->stock < $existing + $quantite) {
                $validator->errors()->add(
                    'quantite',
                    "Stock insuffisant (disponible : {$produit->stock})."
                );
            }
        });
    }
}
