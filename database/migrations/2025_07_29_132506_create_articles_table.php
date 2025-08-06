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
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->string('libelleArticle')->unique();
            $table->string('descriptionArticle')->nullable();
            $table->string('uniteMesure')->nullable();
            $table->string('couleur')->nullable();
            $table->string('poids')->nullable();
            $table->date('datePeremption')->nullable();
            $table->double('prixUnitaire')->nullable();
            $table->double('stockAlerte')->nullable();
            $table->unsignedBigInteger('typeArticle_id');
            $table->foreign('typeArticle_id')
                  ->references('typeArticle_id')->on('type_articles')
                  ->onUpdate('cascade');  
            $table->unsignedBigInteger('pointVente_id');
            $table->foreign('pointVente_id')
                  ->references('pointVente_id')->on('point_ventes')
                  ->onUpdate('cascade');        

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
