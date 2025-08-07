<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ligne_ventes', function (Blueprint $table) {
            $table->id('ligneVente_id');
            $table->double('qteVente');
            $table->double('prixVente');
            $table->double('mtHtVente');

            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('typeVente_id');
            $table->unsignedBigInteger('vente_id');

            $table->foreign('article_id')
                ->references('article_id')->on('articles')
                ->onUpdate('cascade');
            
            $table->foreign('client_id')
                ->references('client_id')->on('clients')
                ->onUpdate('cascade');    

            $table->foreign('typeVente_id')
                ->references('typeVente_id')->on('type_ventes')
                ->onUpdate('cascade');

            $table->foreign('vente_id')
                ->references('vente_id')->on('vente_comptant_credits')
                ->onUpdate('cascade');
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_ventes');
    }
};
