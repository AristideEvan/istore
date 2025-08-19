<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneVente extends Model
{
    protected $primaryKey ='ligneVente_id';

    protected $fillable =[
        'ligneVente_id',
        'qteVente',
        'prixVente',
        'mtHtVente',
        'article_id',
        'client_id',
        'typeVente_id',
        'vente_id'
    ];
    
    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function article(){
        return $this->belongsTo(Article::class,'article_id');
    }

    public function typeVente(){
       return $this->belongsTo(TypeVente::class,'typeVente_id');
    }

    public function vente(){
        return $this->belongsTo(VenteComptantCredit::class,'vente_id');
    }
}
