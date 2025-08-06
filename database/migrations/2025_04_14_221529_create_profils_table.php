<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id('profil_id');
            $table->string('nomProfil')->unique();
            $table->timestamps();
        });
        DB::insert('INSERT INTO public.profils (profil_id, "nomProfil", created_at, updated_at) VALUES (?, ?, ?, ?)',[1, 'Root', NULL, NULL]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
