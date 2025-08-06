<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    protected $primaryKey ='statut_id';

    protected $fillable =[
        'statut_id',
        'libelleStatut',
    ];
}
