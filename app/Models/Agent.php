<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agent extends Authenticatable
{
    use Notifiable;

    protected $table = 'agent';

    protected $primaryKey = 'matricule_agent';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function presentations(): HasMany
    {
        return $this->hasMany(Presenter::class, 'matricule_agent', 'matricule_agent');
    }

    public function getNomCompletAttribute(): string
    {
        return $this->nom_agent;
    }

    public function getInitialesAttribute(): string
    {
        $parts = preg_split('/\s+/', trim((string) $this->nom_agent));

        return mb_strtoupper(mb_substr($parts[0] ?? '', 0, 1).mb_substr($parts[1] ?? '', 0, 1));
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}
