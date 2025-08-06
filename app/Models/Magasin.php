<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $primaryKey ='magasin_id';

    protected $fillage = [
        'magasin_id',
        'nomMagasin',
        'capacite',
    ];
}
