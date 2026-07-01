<?php

namespace App\Models;

use App\Enums\VendeurStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendeur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'statut', 'name', 'nom_boutique'];

    protected function casts(): array
    {
        return [
            'statut' => VendeurStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'vendeur_id');
    }

    public function isActive(): bool
    {
        return $this->statut === VendeurStatus::APPROVED;
    }
}
