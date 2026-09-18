<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnneeAcad extends Model
{
    protected $table = 'anneeacad';

    protected $primaryKey = 'id_anneeacad';

    protected $guarded = [];

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(
            Promotion::class,
            'concerner',
            'id_anneeacad',
            'id_promotion'
        );
    }

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class, 'id_anneeacad', 'id_anneeacad');
    }
}