<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelaiReglement extends Model
{
    protected $primaryKey='delaiReglement_id';

    protected $fillable =[
        'delaiReglement_id',
        'nbreJours',
        'mtPenalite',
        'delaiActif'
    ];

    protected $attributes = [
        'delaiActif' => true,
    ];
}
