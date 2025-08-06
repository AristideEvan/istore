<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ravitaillement extends Model
{
    protected $primaryKey='ravi_id';

    protected $fillable =[
        'ravi_id',
        'dateRavi',
        'qteRavi',
        'prixAchatRavi',
        'pointVente_id',
        'article_id',
        'fournisseur_id',
        'modeAchat_id',
        'magasin_id'
    ];

    public function article()
        {
            return $this->belongsTo(Article::class,'article_id');
        }
    
    public function fournisseur()
        {
            return $this->belongsTo(Fournisseur::class,'fournisseur_id');
        }
    
    public function modeAchat()
        {
            return $this->belongsTo(ModeAchat::class,'modeAchat_id');
        }  

    public function magasin()
        {
            return $this->belongsTo(Magasin::class,'magasin_id');
        }  
    
    public function pointVente()
        {
            return $this->belongsTo(PointVente::class,'pointVente_id');
        }      
}
