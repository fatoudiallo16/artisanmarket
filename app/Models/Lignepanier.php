<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lignepanier extends Model
{
    protected $fillable = ['quantite', 'prix_unitaire', 'panier_id', 'produit_id'];

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'panier_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
