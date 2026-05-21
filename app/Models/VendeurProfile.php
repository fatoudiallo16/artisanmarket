<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendeurProfile extends Model
{
    protected $fillable = ['user_id', 'nom_boutique', 'description_boutique', 'telephone', 'adresse', 'image'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
