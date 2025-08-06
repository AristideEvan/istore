<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    protected $primaryKey ='taxe_id';

    protected $fillable = [
        'taxe_id',
        'tauxTva',
    ];
}
