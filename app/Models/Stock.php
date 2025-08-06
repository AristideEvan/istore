<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $primaryKey ='stock_id';

    protected $fillable =[
        'stock_id',
        'qteInitial',
        'qteRavi',
        'qteRestant',
        'pointVente_id',
        'article_id'
    ];

    public function article()
        {
            return $this->belongsTo(Article::class,'article_id');
        }

   public function TypeArticle()
        {
            return $this->belongsTo(TypeArticle::class,'typeArticle_id');
        }   
          
   public function magasin()
        {
            return $this->belongsTo(Magasin::class,'magasin_id');
        }  
        
        public function pointVente()
        {
            return $this->belongsTo(PointVente::class, 'pointVente_id');
        }

}
