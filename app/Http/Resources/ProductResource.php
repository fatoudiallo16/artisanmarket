<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => (float) $this->prix,
            'stock' => $this->stock,
            'categorie' => new CategorieResource($this->whenLoaded('categorie')),
            'vendeur' => new VendeurResource($this->whenLoaded('vendeur')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
