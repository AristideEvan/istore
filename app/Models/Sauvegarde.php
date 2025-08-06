<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sauvegarde extends Model
{
    protected $primaryKey = 'sauvegarde_id';

    protected $fillable = [
        'nomFichier',
        'cheminFichier',
    ];
}
