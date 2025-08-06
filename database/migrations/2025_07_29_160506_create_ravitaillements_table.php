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
            Schema::create('ravitaillements', function (Blueprint $table) {
            $table->id('ravi_id');
            $table->date('dateRavi');
            $table->double('qteRavi');
            $table->double('prixAchatRavi')->nullable();
            $table->unsignedBigInteger('pointVente_id');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('fournisseur_id');
            $table->unsignedBigInteger('modeAchat_id');
            $table->unsignedBigInteger('magasin_id');

            // Clés étrangères individuelles
            $table->foreign('pointVente_id')
                ->references('pointVente_id')->on('point_ventes')
                ->onUpdate('cascade');

            $table->foreign('article_id')
                ->references('article_id')->on('articles')
                ->onUpdate('cascade');
            
            $table->foreign('fournisseur_id')
                  ->references('fournisseur_id')->on('fournisseurs')
                  ->onUpdate('cascade'); 
            
            $table->foreign('modeAchat_id')
                  ->references('modeAchat_id')->on('mode_achats')
                  ->onUpdate('cascade');
                  
            $table->foreign('magasin_id')
                  ->references('magasin_id')->on('magasins')
                  ->onUpdate('cascade');
            //$table->unique(['pointVente_id', 'article_id', 'dateRavi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ravitaillements');
    }
};
