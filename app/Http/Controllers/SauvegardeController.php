<?php

namespace App\Http\Controllers;

//use Faker\Core\File;
use App\Models\Sauvegarde;
use Illuminate\Http\Request;
use Illuminate\Process\Exceptions\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Process;
use Symfony\Component\Process\Process;
//use Symfony\Component\Process\Process as ProcessProcess;

class SauvegardeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $msgSuccess ='Sauvegarde effectuée avec succès';

    public function __construct()
    {
       $this->middleware('auth');
        
    }

    public function index($rub, $srub)
    {
     // Récupération de toutes les sauvegardes en base de données
     $sauvegardes = Sauvegarde::orderBy('created_at', 'DESC')->get();
     $backups = [];
            foreach ($sauvegardes as $sauvegarde) {
                $fullPath = storage_path('app/backups/' . $sauvegarde->cheminFichier . '/' . $sauvegarde->nomFichier);
                if (File::exists($fullPath)) {
                    $backups[] = [
                        'sauvegarde_id' => $sauvegarde->sauvegarde_id, 
                        'nomFichier' => $sauvegarde->nomFichier,
                        'chemin'     => $sauvegarde->cheminFichier,
                        'taille'     => File::size($fullPath),
                        'date'       => $sauvegarde->created_at->format('d/m/Y H:i:s'),
                    ];
                } else {  // cas ou un fichier n'existe pas 
                    $backups[] = [
                        'sauvegarde_id' => $sauvegarde->sauvegarde_id,
                        'nomFichier' => $sauvegarde->nomFichier,
                        'chemin'     => $sauvegarde->cheminFichier,
                        'taille'     => 0,
                        'date'       => $sauvegarde->created_at->format('d/m/Y H:i:s'),
                        'manquant'   => true,
                    ];
                }
            }
            return view('sauvegarde.index')->with([
                'backups'       => $backups,
                'sauvegardes'   => $sauvegardes,
                'rub'           => $rub,
                'srub'          => $srub,
                'controler'     => $this,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('sauvegarde.create')->with([
                        'rub'       => $rub,
                        'srub'      => $srub,
                        'controler' => $this,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'format' => ['required', 'in:sql,tar'],
        ]);
    
        $format = $request->input('format');
    
        // Générer automatiquement un nom de fichier et un dossier
        $timestamp = date('Ymd_His');
        $fileName = 'backup_' . $timestamp . '.' . $format;
        $folderName = date('Ymd'); 
        $storagePath = storage_path('app/backups/' . $folderName);
    
        // Créer le dossier si nécessaire
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0777, true);
        }
    
        $filePath = $storagePath . '/' . $fileName;
    
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
    
        $command = [
            'pg_dump',
            '-h', $dbHost,
            '-p', $dbPort,
            '-U', $dbUser,
            '-F', $format === 'sql' ? 'p' : 't', // 'p' pour sql (plain), 't' pour tar
            '-f', $filePath,
            '--column-inserts',
            $dbName
        ];
    
        DB::beginTransaction();
        try {
            // Exécuter pg_dump
            $process = new Process($command, base_path(), ['PGPASSWORD' => $dbPass]);
            $process->mustRun();
    
            // Enregistrer l'info de la sauvegarde en base
            $sauvegarde = new Sauvegarde();
            $sauvegarde->nomFichier = $fileName;
            $sauvegarde->cheminFichier = $folderName; 
            $sauvegarde->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur inattendue : ' . $e->getMessage());
        }
            return redirect('sauvegarde/' . $request->input('rub') . '/' . $request->input('srub')) ->with('success', $this->msgSuccess);
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
    public function destroy($id)
    {
            // Recherche de la sauvegarde
            $sauvegarde = Sauvegarde::find($id);

            if (!$sauvegarde) {
                return back()->with('error', 'Sauvegarde introuvable.');
            }

            // Construire le chemin complet vers le fichier
            $fullPath = storage_path('app/backups/' . $sauvegarde->cheminFichier . '/' . $sauvegarde->nomFichier);

            DB::beginTransaction();
            try {
                    // Supprimer le fichier si il existe
                    if (File::exists($fullPath)) {
                        File::delete($fullPath);
                    }
                    // Supprimer l'enregistrement de la base de données
                    $sauvegarde->delete();
                    DB::commit();    
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
            } 
            return redirect('sauvegarde/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);

    }
}
