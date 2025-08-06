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
        Schema::create('actionmenus', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id');
            $table->integer('action_id');
            $table->timestamps();
            $table->unique(['menu_id','action_id']);
            $table->foreign('menu_id')->references('menu_id')->on('menus')->onUpdate('cascade');
            $table->foreign('action_id')->references('action_id')->on('actions')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actionmenus');
    }
};
