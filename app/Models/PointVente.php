<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointVente extends Model
{
    protected $primaryKey ='pointVente_id';

    protected $fillable =[
        'pointVente_id',
        'nomPointVente',
        'telephonePointVente',
        'adressePointVente',
        'logo',
        'localite_id'
    ];

    public function localite()
        {
            return $this->belongsTo(Localite::class,'localite_id');
        }
}
