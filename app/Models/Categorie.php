<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status'
    ];

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
