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
        Schema::create('profilmenus', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id');
            $table->integer('profil_id'); //id de profil qui vient d'être créé
            $table->unique(['menu_id','profil_id']);
            
            $table->foreign('menu_id')->references('menu_id')->on('menus')->onUpdate('cascade');
            $table->foreign('profil_id')->references('profil_id')->on('profils')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profilmenus');
    }
};
