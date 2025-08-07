<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteComptantCredit extends Model
{
    protected $primaryKey ='vente_id';

    protected $fillable =[
        'vente_id',
        'dateVente',
        'numRecuVente',
        'mtTotalVente',
        'mtRemiseVente',
        'mtTvaVente',
        'mtNetVente'
    ];
}
