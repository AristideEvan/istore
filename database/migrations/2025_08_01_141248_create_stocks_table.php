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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('stock_id');
            $table->double('qteInitial');
            $table->double('qteRavi');
            $table->double('qteRestant');
            $table->unsignedBigInteger('pointVente_id');
            $table->unsignedBigInteger('article_id');

            $table->foreign('pointVente_id')
                ->references('pointVente_id')->on('point_ventes')
                ->onUpdate('cascade');

            $table->foreign('article_id')
                ->references('article_id')->on('articles')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
