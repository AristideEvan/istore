<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeFournisseur extends Model
{
    protected $primaryKey='typeFournisseur_id';

    protected $fillable = [
        'typeFournisseur_id',
        'libelleTypeFournisseur'
    ];
}
