<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipe extends Model
{
    protected $table = 'equipe';

    protected $primaryKey = 'id_equipe';

    protected $guarded = [];

    public function inspecteurs(): BelongsToMany
    {
        return $this->belongsToMany(
            Inspecteur::class,
            'composer',
            'id_equipe',
            'matricule_inspecteur'
        )->withPivot('role');
    }

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class, 'id_equipe', 'id_equipe');
    }
}