<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacation extends Model
{
    protected $table = 'vacation';

    protected $primaryKey = 'id_vacation';

    protected $guarded = [];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'date',
    ];

    public function inspecteur(): BelongsTo
    {
        return $this->belongsTo(Inspecteur::class, 'matricule_inspecteur', 'matricule_inspecteur');
    }

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class, 'id_mission', 'id_mission');
    }

    public function scopePayees($query)
    {
        return $query->whereNotNull('date_paiement');
    }

    public function scopeImpayees($query)
    {
        return $query->whereNull('date_paiement');
    }
}