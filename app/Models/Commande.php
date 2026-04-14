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
        return $this->hasMany(Lignecommande::class, 'commmande_id');
    }
}
