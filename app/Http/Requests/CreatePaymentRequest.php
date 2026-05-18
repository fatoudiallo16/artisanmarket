<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('client') || $this->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'commande_id' => ['required', 'exists:commandes,id'],
            'montant' => ['required', 'numeric', 'min:0.01'],
            'mode_paiement' => ['required', 'string', 'max:100'],
            'statut' => ['nullable', 'in:en_attente,paye,echoue,rembourse'],
        ];
    }
}
