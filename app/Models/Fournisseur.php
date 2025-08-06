<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $primaryKey ='fournisseur_id';

    protected $fillable =[
        'fournisseur_id',
        'nomFournisseur',
        'telephoneFournisseur',
        'adresseFournisseur',
        'emailFournisseur',
        'numeroIdentifiant',
        'typeFournisseur_id'

    ];

    public function typeFournisseur()
        {
            return $this->belongsTo(TypeFournisseur::class,'typeFournisseur_id');
        }
}
