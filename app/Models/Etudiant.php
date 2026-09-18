<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etudiant extends Model
{
    protected $table = 'etudiant';

    protected $primaryKey = 'matricule';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'id_promotion', 'id_promotion');
    }

    public function homologations(): HasMany
    {
        return $this->hasMany(Homologuer::class, 'matricule', 'matricule');
    }

    public function getNomCompletAttribute(): string
    {
        return trim($this->nom.' '.($this->postnom ?? '').' '.($this->prenom ?? ''));
    }

    public function getInitialesAttribute(): string
    {
        $nom = $this->nom ?? '';
        $postnom = $this->postnom ?? '';

        return strtoupper(mb_substr($nom, 0, 1).mb_substr($postnom, 0, 1));
    }
}