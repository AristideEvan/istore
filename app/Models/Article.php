<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $primaryKey ='article_id';

    protected $fillable =[
        'article_id',
        'libelleArticle',
        'descriptionArticle',
        'uniteMesure',
        'couleur',
        'poids',
        'datePeremption',
        'prixUnitaire',
        'typeArticle_id',
        'pointVente_id'
    ];

    public function typeArticle()
        {
            return $this->belongsTo(TypeArticle::class,'typeArticle_id');
        }
    
        
}
