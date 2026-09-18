<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    protected $table = 'promotion';

    protected $primaryKey = 'id_promotion';

    protected $guarded = [];

    public function faculte(): BelongsTo
    {
        return $this->belongsTo(Faculte::class, 'id_faculte', 'id_faculte');
    }

    public function etudiants(): HasMany
    {
        return $this->hasMany(Etudiant::class, 'id_promotion', 'id_promotion');
    }

    public function annees(): BelongsToMany
    {
        return $this->belongsToMany(
            AnneeAcad::class,
            'concerner',
            'id_promotion',
            'id_anneeacad'
        );
    }
}