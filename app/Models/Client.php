<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey ='client_id';

    protected $fillable =[
        'client_id',
        'numeroCompte',
        'nomClient',
        'prenomClient',
        'telephoneClient',
        'emailClient',
        'adresseClient',
        'typeClient_id'
    ];

    public function typeClient(){
        return $this->belongsTo(TypeClient::class,'typeClient_id');
    }
}
