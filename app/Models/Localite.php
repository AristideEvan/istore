<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Localite extends Model
{

    protected $primaryKey='localite_id';

    protected $fillable = [
        'codeLocalite',
        'libelleLocalite',
        'localiteParent_id',
        'typeLocalite_id',
    ];

    public function parentLocalite()
        {
            return $this->belongsTo(Localite::class,'localiteParent_id');
        }

    public function typeLocalite()
        {
            return $this->belongsTo(TypeLocalite::class,'typeLocalite_id');
        }
    public function fils()
    {
        return $this->hasMany(Localite::class,'localiteParent_id');
    }

    public function __toString()
    {
        return $this->libelleTypeLocalite;
    }

}
