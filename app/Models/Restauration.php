<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restauration extends Model
{
    protected $primaryKey='restauration_id';

    protected $fillable =[
      'nomFichier',
      'cheminFichier',
    ];
}
