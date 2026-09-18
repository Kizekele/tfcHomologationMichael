<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mission extends Model
{
    protected $table = 'mission';

    protected $primaryKey = 'id_mission';

    protected $guarded = [];

    protected $casts = [
        'date_lettre' => 'date',
        'periode_debut' => 'date',
        'periode_fin' => 'date',
    ];

    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'id_equipe', 'id_equipe');
    }

    public function faculte(): BelongsTo
    {
        return $this->belongsTo(Faculte::class, 'id_faculte', 'id_faculte');
    }

    public function anneeAcad(): BelongsTo
    {
        return $this->belongsTo(AnneeAcad::class, 'id_anneeacad', 'id_anneeacad');
    }

    public function vacations(): HasMany
    {
        return $this->hasMany(Vacation::class, 'id_mission', 'id_mission');
    }

    public function homologations(): HasMany
    {
        return $this->hasMany(Homologuer::class, 'id_mission', 'id_mission');
    }

    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(
            Agent::class,
            'presenter',
            'id_mission',
            'matricule_agent'
        )->withPivot('date_presentation');
    }

    public function scopeActives($query)
    {
        return $query->where('periode_fin', '>=', now()->toDateString());
    }
}