<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Homologuer extends Model
{
    protected $table = 'homologuer';

    protected $primaryKey = 'matricule';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'date_avis' => 'date',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class, 'matricule', 'matricule');
    }

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class, 'id_mission', 'id_mission');
    }
}