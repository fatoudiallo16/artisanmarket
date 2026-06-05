<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['montant', 'date_paiement', 'mode_paiement', 'statut', 'commande_id'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}
