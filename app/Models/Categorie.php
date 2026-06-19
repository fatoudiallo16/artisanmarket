<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status'
    ];

    protected static function booted(): void
    {
        static::creating(function (Categorie $categorie) {
            if (Schema::hasColumn($categorie->getTable(), 'slug') && blank($categorie->slug)) {
                $categorie->slug = static::uniqueSlug($categorie->name ?? 'categorie');
            }
        });
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
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
