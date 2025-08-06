<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\File;

class MakeCrudViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-crud-views {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer les fichiers Blade de base pour un CRUD';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $views = ['index', 'create', 'edit', 'show'];

        $path = resource_path('views/' . str_replace('.', '/', $name));

        File::ensureDirectoryExists($path);

        foreach ($views as $view) {
            $fullPath = "$path/$view.blade.php";
            if (!File::exists($fullPath)) {
                File::put($fullPath, "<!-- Vue $view de $name -->");
                $this->info("✔️  Créé : $fullPath");
            } else {
                $this->warn("⚠️  Existe déjà : $fullPath");
            }
        }

        $this->info("✅ Vues CRUD créées dans $path");
    }
}
