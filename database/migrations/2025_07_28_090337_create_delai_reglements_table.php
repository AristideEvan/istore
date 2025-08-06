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
        Schema::create('delai_reglements', function (Blueprint $table) {
            $table->id('delaiReglement_id');
            $table->integer('nbreJours')->unique();
            $table->double('mtPenalite')->unique();
            $table->boolean('delaiActif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delai_reglements');
    }
};
