<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['nom', 'description', 'prix', 'stock', 'vendeur_id', 'categorie_id'];

    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class, 'vendeur_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
}
