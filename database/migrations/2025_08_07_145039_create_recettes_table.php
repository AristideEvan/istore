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
        Schema::create('recettes', function (Blueprint $table) {
            $table->id('recette_id');
            $table->date('dateRecette');
            $table->double('mtRecette');

            $table->unsignedBigInteger('vente_id');
            $table->unsignedBigInteger('reglement_id');

            $table->foreign('vente_id')
                ->references('vente_id')->on('vente_comptant_credits')
                ->onUpdate('cascade');

            $table->foreign('reglement_id')
                ->references('reglement_id')->on('reglements')
                ->onUpdate('cascade'); 
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recettes');
    }
};
