<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presenter extends Model
{
    protected $table = 'presenter';

    protected $primaryKey = 'matricule_agent';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'date_presentation' => 'date',
    ];
}