<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderLineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'commande_id' => $this->commande_id,
            'produit_id' => $this->produit_id,
            'quantite' => $this->quantite,
            'prix_unitaire' => (float) $this->prix_unitaire,
            'produit' => new ProductResource($this->whenLoaded('produit')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
