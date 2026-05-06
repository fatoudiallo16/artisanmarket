<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    protected $fillable = ['user_id', 'telephone', 'adresse', 'ville', 'pays'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
