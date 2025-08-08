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

    public function articles(){
        return $this->hasMany(Article::class,'typeArticle_id');
    }
}
