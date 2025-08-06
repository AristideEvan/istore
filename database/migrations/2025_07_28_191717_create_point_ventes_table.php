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
        Schema::create('point_ventes', function (Blueprint $table) {
            $table->id('pointVente_id');
            $table->string('nomPointVente')->unique();
            $table->string('telephonePointVente')->unique();
            $table->string('adressePointVente')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedBigInteger('localite_id');
            $table->foreign('localite_id')
                  ->references('localite_id')->on('localites')
                  ->onUpdate('cascade');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_ventes');
    }
};
