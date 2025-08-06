<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeVente extends Model
{
    protected $primaryKey ='typeVente_id';

    protected $fillable =[
        'typeVente_id',
        'libelleTypeVente'
    ];
}
