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
        Schema::create('reglements', function (Blueprint $table) {
            $table->id('reglement_id');
            $table->date('dateReglement');
            $table->string('numRecuRegle');
            $table->double('mtRegleInitial');
            $table->double('mtRegleVerse');
            $table->double('mtRegleRestant');

            $table->unsignedBigInteger('modeReglement_id');
            
            $table->foreign('modeReglement_id')
                ->references('modeReglement_id')->on('mode_reglements')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reglements');
    }
};
