<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère un CRUD complet : modèle, migration, contrôleur, vues, et route.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));      // Ex: Article
        $nameLower = Str::snake($name);                    // Ex: article
        $namePlural = Str::plural($nameLower);             // Ex: articles

        // 1. Modèle + Migration
        $this->call('make:model', ['name' => $name, '-m' => true]);

        // 2. Contrôleur
        $this->call('make:controller', [
            'name' => "{$name}Controller",
            '--resource' => true
        ]);

        // 3. Vues Blade CRUD
        $viewPath = resource_path("views/{$nameLower}");
        File::ensureDirectoryExists($viewPath);
        $views = ['index', 'create', 'edit', 'show'];

        foreach ($views as $view) {
            $file = "{$viewPath}/{$view}.blade.php";
            if (!File::exists($file)) {
                File::put($file, "<!-- Vue $view pour $name -->");
                $this->info("Vue créée : $file");
            }
        }

        // 4. Route Resource
        $routesPath = base_path('routes/web.php');
        $routeEntry = "Route::resource('$namePlural', \\App\\Http\\Controllers\\{$name}Controller::class);";

        if (!Str::contains(File::get($routesPath), $routeEntry)) {
            File::append($routesPath, "\n" . $routeEntry);
            $this->info("Route ajoutée à web.php : $routeEntry");
        }

        $this->info("✅ CRUD pour $name généré avec succès !");
    }
}
