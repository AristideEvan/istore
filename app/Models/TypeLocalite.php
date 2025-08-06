<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeLocalite extends Model
{
    protected $primaryKey ='typeLocalite_id';

    protected $fillable =[
        'typeLocalite_id',
        'libelleTypeLocalite'
    ];

}
