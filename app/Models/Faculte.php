<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculte extends Model
{
    protected $table = 'faculte';

    protected $primaryKey = 'id_faculte';

    protected $guarded = [];

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class, 'id_faculte', 'id_faculte');
    }

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class, 'id_faculte', 'id_faculte');
    }

    public function etudiants()
    {
        return $this->hasManyThrough(
            Etudiant::class,
            Promotion::class,
            'id_faculte',
            'id_promotion',
            'id_faculte',
            'id_promotion'
        );
    }
}