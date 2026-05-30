<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendeur extends Model
{
    protected $fillable = ['user_id', 'id_utilisateur', 'statut', 'name', 'nom_boutique'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'vendeur_id');
    }

    public function profile()
    {
        return $this->hasOne(VendeurProfile::class, 'user_id', 'user_id');
    }

    public function isActive(): bool
    {
        return $this->statut === 'approuve';
    }
}
