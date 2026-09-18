<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspecteur extends Model
{
    protected $table = 'inspecteur';

    protected $primaryKey = 'matricule_inspecteur';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function equipes(): BelongsToMany
    {
        return $this->belongsToMany(
            Equipe::class,
            'composer',
            'matricule_inspecteur',
            'id_equipe'
        )->withPivot('role');
    }

    public function vacations(): HasMany
    {
        return $this->hasMany(Vacation::class, 'matricule_inspecteur', 'matricule_inspecteur');
    }
}