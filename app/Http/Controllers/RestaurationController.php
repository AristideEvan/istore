<?php

namespace App\Http\Controllers;

use App\Models\Restauration;
use App\Models\Sauvegarde;
//use Faker\Provider\File;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Process\Exceptions\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

class RestaurationController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    private $msgSuccess ='Restauration effectuée avec succès';

    public function __construct()
    {
       $this->middleware('auth');
        
    }

    public function index($rub, $srub)
    {
        $restaure = Restauration::orderBy('created_at', 'DESC')->get();
        $restaurations = [];

        foreach ($restaure as $restauration) {
            $fullPath = storage_path('app/backups/' . $restauration->cheminFichier . '/' . $restauration->nomFichier);

            if (File::exists($fullPath)) {
                $restaurations[] = [
                    'restauration_id' => $restauration->restauration_id,
                    'nomFichier'    => $restauration->nomFichier,
                    'chemin'        => $restauration->cheminFichier,
                    'date'          => $restauration->created_at->format('d/m/Y H:i:s'),
                ];
            }
        }
        return view('restauration.index')->with([
                                                            'restaurations'       => $restaurations,
                                                            'rub'                 => $rub,
                                                            'srub'                => $srub,
                                                            'controler'           => $this,
                                                        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        $sauvegardes = Sauvegarde::orderBy('created_at', 'DESC')->get();
        return view('restauration.create')->with([
                                                            'sauvegardes'   => $sauvegardes,
                                                            'rub'           => $rub,
                                                            'srub'          => $srub,
                                                            'controler'     => $this,
                                                         ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sauvegarde_id' => 'required|exists:sauvegardes,sauvegarde_id',
        ]);
    
        $sauvegarde = Sauvegarde::find($request->sauvegarde_id);
        $filePath = storage_path('app/backups/' . $sauvegarde->cheminFichier . '/' . $sauvegarde->nomFichier);
    
        if (!File::exists($filePath)) {
            return back()->with('error', 'Fichier de sauvegarde introuvable.');
        }
    
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
    
        $format = pathinfo($sauvegarde->nomFichier, PATHINFO_EXTENSION);
        $tablesExclues = ['users', 'migrations', 'restaurations', 'sauvegardes','actionmenus',
                          'actions','cache', 'cache_locks','failed_jobs','job_batches','jobs',
                          'localites','menus','password_reset_tokens','profilmenuactions','profilmenus',
                          'profils','sessions','spatial_ref_sys','type_localites','polygones'];

        //$tablesExclues = ['users', 'migrations', 'restaurations', 'sauvegardes','spatial_ref_sys'];
                          //dd($tablesExclues);
        DB::beginTransaction();
        try {
            set_time_limit(600); // ou plus si besoin
            ini_set('max_execution_time', 600);
    
            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            //dd($tables);
            foreach ($tables as $table) {
                if (!in_array($table->tablename, $tablesExclues)) {
                    // DB::statement("DROP TABLE IF EXISTS {$table->tablename} CASCADE");
                    DB::statement("TRUNCATE TABLE {$table->tablename} RESTART IDENTITY CASCADE");
                }
            }
            //dd(DB::statement("TRUNCATE TABLE {$table->tablename} RESTART IDENTITY CASCADE"));
            if ($format === 'sql') {
                $command = [
                    'psql',
                    '-h', $dbHost,
                    '-p', $dbPort,
                    '-U', $dbUser,
                    '-d', $dbName,
                    '-f', $filePath,
                ]; //psql -U "$DB_USER" -h "$DB_HOST" -p "$DB_PORT" -d "$DB_NAME" -f "$BACKUP_FILE"
            //dd($command);

            } elseif ($format === 'tar') {
                $command = [
                    'pg_restore',
                    '-h', $dbHost,
                    '-p', $dbPort,
                    '-U', $dbUser,
                    '-d', $dbName,
                     '--clean',
                     '--if-exists',
                    $filePath,
                ];
            } else {
                return back()->with('error', 'Format de fichier non pris en charge.');
            }
            $process = new Process($command, base_path(), ['PGPASSWORD' => $dbPass]);
            $process->setTimeout(60); 
            //dd($process);
            $process->mustRun();
            $restaure = new Restauration();
            $restaure->nomFichier = $sauvegarde->nomFichier;
            $restaure->cheminFichier = $sauvegarde->cheminFichier;
            //dd($restaure);
            $restaure->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la restauration : ' . $e->getMessage());
        }  
        return redirect('restauration/' . $request->rub . '/' . $request->srub)->with('success', 'Restauration terminée avec succès.');       
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            DB::beginTransaction();
        
            try {
                // Récupérer la restauration
                $restauration = Restauration::find($id);
        
                // Construire le chemin du fichier à supprimer
                $fullPath = storage_path('app/backups/' . $restauration->cheminFichier . '/' . $restauration->nomFichier);
        
                // Supprimer physiquement le fichier s'il existe
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
        
                // Supprimer l'enregistrement en base
                $restauration->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
            }
            return redirect('restauration/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
        }

}
