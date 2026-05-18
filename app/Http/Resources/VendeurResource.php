<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendeurResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'nom_boutique' => $this->nom_boutique,
            'statut' => $this->statut,
            'user' => new UserResource($this->whenLoaded('user')),
            'produits_count' => $this->whenCounted('produits'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
