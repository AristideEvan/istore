<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeReglement extends Model
{
    protected $primaryKey ='modeReglement_id';

    protected $fillable = [
        'modeReglement_id',
        'libelleModeReglement'
    ];
}
