<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id('action_id');
            $table->string('nomAction');
            $table->unique('nomAction');
            $table->timestamps();
        });
        DB::insert('INSERT INTO public.actions ("nomAction", created_at, updated_at) VALUES (?, ?, ?)',['CREER', NULL, NULL]);
        DB::insert('INSERT INTO public.actions ("nomAction", created_at, updated_at) VALUES (?, ?, ?)',['MODIFIER', NULL, NULL]);
        DB::insert('INSERT INTO public.actions ("nomAction", created_at, updated_at) VALUES (?, ?, ?)',['SUPPRIMER', NULL, NULL]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
