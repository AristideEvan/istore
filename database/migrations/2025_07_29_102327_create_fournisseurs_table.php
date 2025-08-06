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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id('fournisseur_id');
            $table->string('nomFournisseur');
            $table->string('telephoneFournisseur')->unique();
            $table->string('adresseFournisseur')->nullable();
            $table->string('emailFournisseur')->nullable();
            $table->string('numeroIdentifiant')->nullable();
            $table->unsignedBigInteger('typeFournisseur_id');
            $table->foreign('typeFournisseur_id')
                  ->references('typeFournisseur_id')->on('type_fournisseurs')
                  ->onUpdate('cascade');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
};
