<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'commande_id' => $this->commande_id,
            'montant' => (float) $this->montant,
            'mode_paiement' => $this->mode_paiement,
            'statut' => $this->statut,
            'date_paiement' => $this->date_paiement,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
