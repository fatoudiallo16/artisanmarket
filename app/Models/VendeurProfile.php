<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendeurProfile extends Model
{
    protected $fillable = ['user_id', 'nom_boutique', 'description_boutique', 'telephone', 'adresse'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
