<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lignecommande extends Model
{
    protected $fillable = ['quantite', 'prix_unitaire', 'commande_id', 'produit_id'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
    
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }


}
