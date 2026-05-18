<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $table = 'annonces';

    protected $fillable = [
        'titre',
        'contenu',
        'image',
        'date_publication',
        'user_id',
    ];

    // Relation : une annonce appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

