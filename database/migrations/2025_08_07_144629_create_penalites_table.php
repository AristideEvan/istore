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
        Schema::create('penalites', function (Blueprint $table) {
            $table->id('penalite_id');
            $table->date('datePenalite');
            $table->double('mtPenaliteRegle');

            $table->unsignedBigInteger('reglement_id');
            
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
        Schema::dropIfExists('penalites');
    }
};
