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
        Schema::create('vente_comptant_credits', function (Blueprint $table) {
            $table->id('vente_id');
            $table->date('dateVente');
            $table->string('numRecuVente')->nullable()->unique();
            $table->double('mtTotalVente');
            $table->double('mtRemiseVente');
            $table->double('mtTvaVente');
            $table->double('mtNetVente');

            $table->unsignedBigInteger('modeReglement_id');
            $table->unsignedBigInteger('taxe_id');
            $table->unsignedBigInteger('remise_id');
            $table->unsignedBigInteger('delaiReglement_id');

            $table->foreign('modeReglement_id')
                ->references('modeReglement_id')->on('mode_reglements')
                ->onUpdate('cascade');

            $table->foreign('taxe_id')
                ->references('taxe_id')->on('taxes')
                ->onUpdate('cascade'); 
            
            $table->foreign('remise_id')
                ->references('remise_id')->on('remises')
                ->onUpdate('cascade'); 

            $table->foreign('delaiReglement_id')
                ->references('delaiReglement_id')->on('delai_reglements')
                ->onUpdate('cascade');       

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vente_comptant_credits');
    }
};
