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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            
            $table->string('numeroCompte')->unique()->nullable();
            $table->string('nomClient');
            $table->string('prenomClient')->nullable();
            $table->string('telephoneClient');
            $table->string('emailClient')->nullable();
            $table->string('adresseClient')->nullable();
            $table->string('numeroIdentifiant')->nullable();
            $table->unsignedBigInteger('typeClient_id');

            $table->foreign('typeClient_id')
                ->references('typeClient_id')->on('type_clients')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
