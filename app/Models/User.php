<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
        public function role()
        {
        return $this->belongsTo(Role::class, 'role_id');
        }
        public function commandes()
        {
            return $this->hasMany(Commande::class, 'user_id');
        }   
        public function panier()
        {
            return $this->hasOne(Panier::class, 'user_id');
        }
        public function vendeur()
        {
            return $this->hasOne(Vendeur::class, 'user_id' );
        }
        public function clientProfile()
        {
            return $this->hasOne(ClientProfile::class, 'user_id');
        }
        public function vendeurProfile()
        {
            return $this->hasOne(VendeurProfile::class, 'user_id');
        }
        public function adminProfile()
        {
            return $this->hasOne(AdminProfile::class, 'user_id');
        }

        public function favoris()
        {
            return $this->belongsToMany(Produit::class, 'favoris')->withTimestamps();
        }

        public function avis()
        {
            return $this->hasMany(Avis::class, 'user_id');
        }

        public function hasRole(string ...$roles): bool
        {
            return $this->role !== null && in_array($this->role->nom_role, $roles, true);
        }

        public function syncProfileByRole(): void
        {
            if (!$this->role) {
                return;
            }

            if ($this->role->nom_role === 'client') {
                $this->clientProfile()->firstOrCreate([]);
                return;
            }

            if ($this->role->nom_role === 'vendeur') {
                $this->vendeurProfile()->firstOrCreate(
                    ['user_id' => $this->id],
                    ['nom_boutique' => 'Boutique '.$this->name]
                );
                return;
            }

            if ($this->role->nom_role === 'admin') {
                $this->adminProfile()->firstOrCreate([]);
            }
        }

}
