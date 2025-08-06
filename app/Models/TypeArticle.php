<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeArticle extends Model
{
    protected $primaryKey= 'typeArticle_id';

    protected $fillable = [
        'typeArticle',
        'libelleTypeArticle',
    ];
}
