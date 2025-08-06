<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeClient extends Model
{
    protected $primaryKey='typeClient_id';

    protected $fillable = [
        'typeClient_id',
        'libelleTypeClient'
    ];
}
