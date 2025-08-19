<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteComptantCredit extends Model
{
    protected $primaryKey ='vente_id';

    protected $fillable =[
        'vente_id',
        'dateVente',
        'numRecuVente',
        'mtTotalVente',
        'mtRemiseVente',
        'mtTvaVente',
        'mtNetVente'
    ];

    public function ligneVente_typeVente(){
        return $this->hasOneThrough(TypeVente::class,
                                  LigneVente::class
                                ,'vente_id'
                                ,'typeVente_id'
                                ,'vente_id'
                                ,'typeVente_id'
                    );
    }

    public function ligneVente_client(){
        return $this->hasOneThrough(Client::class,
                            LigneVente::class
                            ,'vente_id'
                            ,'client_id'
                            ,'vente_id'
                            ,'client_id'
                        );
    }

    public function ligneVente_article(){
        return $this->hasOneThrough(
                        Article::class
                        ,LigneVente::class
                        ,'vente_id'
                        ,'article_id'
                        ,'vente_id'
                        ,'article_id'

        );
    }

    public function ligneVente_vente(){
        return $this->hasOne(VenteComptantCredit::class,
                    'vente_id');
    }
}
