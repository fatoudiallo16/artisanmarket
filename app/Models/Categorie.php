<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom', 'nom_categorie'];

    public function getNomAttribute(): ?string
    {
        return $this->attributes['nom'] ?? $this->attributes['nom_categorie'] ?? null;
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
