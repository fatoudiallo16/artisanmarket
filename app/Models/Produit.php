<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'stock',
        'slug',
        'image',
        'status',
        'vendeur_id',
        'categorie_id',
    ];

    protected $appends = ['image_url'];

    protected static function booted(): void
    {
        static::creating(function (Produit $produit) {
            if (Schema::hasColumn($produit->getTable(), 'slug') && blank($produit->slug)) {
                $produit->slug = static::uniqueSlug($produit->nom);
            }
        });
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return \App\Support\ProduitVisual::fallbackImageUrl($this);
    }

    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class, 'vendeur_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    
    public function lignecommandes()
    {
        return $this->hasMany(Lignecommande::class, 'produit_id');
    }
    
    public function lignepaniers()
    {
        return $this->hasMany(Lignepanier::class, 'produit_id');
    }

    private static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
