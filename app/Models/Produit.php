<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['nom', 'description', 'prix', 'stock', 'image', 'vendeur_id', 'categorie_id'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return \App\Support\ProduitVisual::fallbackImageUrl($this);
    }

    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class, 'vendeur_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    
    public function lignecommandes()
    {
        return $this->hasMany(Lignecommande::class, 'produit_id');
    }
    
    public function lignepaniers()
    {
        return $this->hasMany(Lignepanier::class, 'produit_id');
    }
}
