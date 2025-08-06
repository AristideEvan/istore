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
        Schema::create('localites', function (Blueprint $table) {
            $table->id('localite_id');
            $table->string('codeLocalite')->nullable();
            $table->string('libelleLocalite');
            $table->unsignedBigInteger('localiteParent_id')->nullable();
            $table->foreign('localiteParent_id')
                  ->references('localite_id')->on('localites')
                  ->onUpdate('cascade');    
            $table->unsignedBigInteger('typeLocalite_id');
            $table->foreign('typeLocalite_id')
                    ->references('typeLocalite_id')->on('type_localites')
                    ->onUpdate('cascade'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localites');
    }
};
