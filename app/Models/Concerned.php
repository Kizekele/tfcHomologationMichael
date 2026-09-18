<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concerned extends Model
{
    protected $table = 'concerner';

    protected $primaryKey = 'id_promotion';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];
}