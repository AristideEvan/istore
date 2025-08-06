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
        Schema::create('profilmenuactions', function (Blueprint $table) {
            $table->id();
            $table->integer('profil_id');
            $table->integer('menu_id');
            $table->integer('action_id');
            $table->unique(['profil_id','menu_id','action_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profilmenuactions');
    }
};
