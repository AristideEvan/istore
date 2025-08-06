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
        Schema::create('menus', function (Blueprint $table) {
            $table->id('menu_id');
            $table->integer('parent_id')->nullable();
            $table->string('nomMenu')->nullable();
            $table->string('lien')->nullable();
            $table->string('interface')->nullable();
            $table->string('icon')->nullable();
            $table->integer('ordre')->nullable();
            $table->boolean('visible')->default(true);
            $table->unique('nomMenu');
            $table->timestamps();
        });

        DB::insert('INSERT INTO public.menus (menu_id, "parent_id", "nomMenu", lien,  created_at, updated_at, icon, ordre,interface,visible) VALUES (?, ?, ?, ?,?,?,?,?,?,?)',[1, NULL, 'Utilisateur', NULL, NULL, NULL, NULL,10,1,true]);
        DB::insert('INSERT INTO public.menus (menu_id, "parent_id", "nomMenu", lien,  created_at, updated_at, icon, ordre,interface,visible) VALUES (?, ?, ?, ?,?,?,?,?,?,?)',[2, 1, 'Profil', 'profil.index', NULL, NULL, NULL,12,1,true]);
        DB::insert('INSERT INTO public.menus (menu_id, "parent_id", "nomMenu", lien,  created_at, updated_at, icon, ordre,interface,visible) VALUES (?, ?, ?, ?,?,?,?,?,?,?)',[3, 1, 'Utilisateurs', 'user.index', NULL, NULL, NULL,14,1,true]);
        DB::insert('INSERT INTO public.menus (menu_id, "parent_id", "nomMenu", lien,  created_at, updated_at, icon, ordre,interface,visible) VALUES (?, ?, ?, ?,?,?,?,?,?,?)',[4, 1, 'Comptes non actif', 'comptenonactif', NULL, NULL, NULL,16,1,true]);
        DB::insert('INSERT INTO public.menus (menu_id, "parent_id", "nomMenu", lien,  created_at, updated_at, icon, ordre,interface,visible) VALUES (?, ?, ?, ?,?,?,?,?,?,?)',[5, NULL, 'Developpeur', NULL, NULL, NULL, NULL,20,1,true]);
        DB::insert('INSERT INTO public.menus (menu_id, "parent_id", "nomMenu", lien,  created_at, updated_at, icon, ordre,interface,visible) VALUES (?, ?, ?, ?,?,?,?,?,?,?)',[6, 5, 'Action', 'action.index', NULL, NULL, NULL,22,1,true]); 
        DB::insert('INSERT INTO public.menus (menu_id, "parent_id", "nomMenu", lien,  created_at, updated_at, icon, ordre,interface,visible) VALUES (?, ?, ?, ?,?,?,?,?,?,?)',[7, 5, 'Menus', 'menu.index', NULL, NULL, NULL,24,1,true]);
        
        DB::statement("SELECT pg_catalog.setval('public.menus_menu_id_seq', 7, true);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
