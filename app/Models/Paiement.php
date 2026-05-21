<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'montant',
        'date_paiement',
        'mode_paiement',
        'statut',
        'commande_id',
        'numero_facture',
        'facture_pdf',
    ];

    protected function casts(): array
    {
        return [
            'date_paiement' => 'datetime',
            'montant' => 'decimal:2',
        ];
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}
