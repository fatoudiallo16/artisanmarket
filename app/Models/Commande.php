<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['statut', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lignecommandes()
    {
        return $this->hasMany(Lignecommande::class, 'commande_id');
    }
    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'commande_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'commande_id');
    }
    
}
