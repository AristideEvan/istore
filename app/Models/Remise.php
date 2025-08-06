<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remise extends Model
{
    protected $primaryKey='remise_id';

    protected $fillable =[
        'remise_id',
        'libelleRemise',
    ];
}
