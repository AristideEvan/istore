<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $primaryKey ='recette_id';

    protected $fillable =[
        'recette_id',
        'dateRecette',
        'mtRecette',
        'vente_id',
        'reglement_id'
    ];
}
