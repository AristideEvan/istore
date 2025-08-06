<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeLocalite;
use App\Models\TypeSociologique;
use App\Models\Localite;
use App\Models\Polygone;
use Illuminate\Support\Facades\DB;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;

class LocaliteController extends Controller
{

    private $msgError ="Une erreur s'est produite";
    private $msgSuccess ="Opération effectuée avec succès";
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
       $this->middleware('auth');

    }

    public function index($rub, $srub)
    {
        $datas = Localite:: With([
            'parentLocalite',
            'typeLocalite',
        ])->get();
            return view('localite.index', [
                'datas'     => $datas,
                'controler' => $this,
                'rub'       => $rub,
                'srub'      => $srub,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        $data_localite = Localite::orderBy('libelleLocalite','asc')->get();
        $data_typeLocalite = TypeLocalite::orderBy('libelleTypeLocalite','asc')->get();
        return view ('localite.create')->with(['controler'=>$this,
                                    "data_localite"=>$data_localite,
                                    "data_typeLocalite"=>$data_typeLocalite,
                                    "rub"=>$rub,
                                    "srub"=>$srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codeLocalite',
            'libelleLocalite'=>['required','string','max:255'],
            'typeLocalite_id'=>'required',
            'localiteParent_id',
        ]);
        DB::beginTransaction();
        try{
            $localite= new Localite();
            $localite->localiteParent_id=$request->localiteParent_id;
            $localite->codeLocalite=$request->codeLocalite;
            $localite->libelleLocalite=$request->libelleLocalite;
            $localite->typeLocalite_id=$request->typeLocalite_id;
            $localite->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('localites/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
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
    public function edit($id,$rub,$srub)
    {
        $data=Localite::find($id);
        $data_typeLocalite=TypeLocalite::orderBy('libelleTypeLocalite')->get();
        return view ('localite.edit')->with(['data'=>$data,
                                              'data_typeLocalite'=>$data_typeLocalite,
                                              'controler'=>$this,
                                              'rub'=>$rub,
                                              'srub'=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       DB::beginTransaction();
        try{
            $request->validate([
               'codeLocalite',
               'libelleLocalite'=>['required','string','max:255'],
               'typeLocalite_id'=>'required',
               'localiteParent_id',
            ]);

            $localite=Localite::find($id);
            $localite->localiteParent_id=$request->localiteParent_id;
            $localite->codeLocalite=$request->codeLocalite;
            $localite->libelleLocalite=$request->libelleLocalite;
            $localite->typeLocalite_id=$request->typeLocalite_id;
            $localite->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $msgError= $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('localites/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $data=Localite::find($id);
            $data->delete();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
         return back()->with(['success'=>$this->msgSuccess]);
    }

    // public function formImport(){
    //     $data_typeLocalite = TypeLocalite::orderBy('typeLocaliteLibelle','asc')->get();
    //     return view('localite.importModal')->with(['data_typeLocalite'=>$data_typeLocalite]);
    // }

    // public function uploadShapefile(Request $request)
    // {
    //     $request->validate([
    //         'select_file' => 'required|file|mimes:zip',
    //         'typeLocalite_id' => 'required'
    //     ]);

    //     $filename = $this->genererNom(20);
    //     // Stocker le fichier ZIP
    //     $path = $request->file('select_file')->storeAs(
    //         'shapefiles/uploads', $filename,'public');
    //     $typeLocalite = $request->input('typeLocalite_id');

    //     // Extraire le ZIP
    //     $zip = new \ZipArchive;
    //     $zipPath = storage_path('app/public/' .$path);
    //     $extractTo = storage_path('app/shapefiles/tmp_' . time());
    //     //mkdir($extractTo);
    //     if (!is_dir($extractTo)) {
    //         mkdir($extractTo, 0777, true);
    //         chmod($extractTo, 0777);
    //     }
    //     $res =$zip->open($zipPath);
    //     //dd($zip->open($zipPath));
    //     if ($res === TRUE) {
    //         $zip->extractTo($extractTo);
    //         $zip->close();
    //         //return response()->json(['message' => 'Fichier extrait avec succès.']);
    //     }else {
    //         // Gérer les erreurs connues
    //         $errors = [
    //             \ZipArchive::ER_NOZIP => 'Le fichier n\'est pas une archive ZIP valide.',
    //             \ZipArchive::ER_INCONS => 'Archive ZIP corrompue.',
    //             \ZipArchive::ER_CRC => 'Erreur de CRC dans l\'archive.',
    //         ];
    //         $message =$errors[$res] ?? 'Erreur inconnue (code : ' .$res . ')';
    //         return back()->with('error', $message);
    //     }
    //         // Trouver le fichier .shp
    //         $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($extractTo));
    //         $files = $this->scanDirectoryRecursively($extractTo);
    //         $shpFile = collect($files)->first(fn($file) => str_ends_with($file, '.shp'));
           
    //     if (!$shpFile) {
    //         return back()->with('error', 'Fichier .shp introuvable.');
    //     }
    //     //$shpPath =$this->getDossier($rii);
    //     //dd($shpFile." et ".$shpPath);
    //     $i=0;
    //     try {
    //         $Shapefile = new ShapefileReader($shpFile);
    //         while ($Geometry = $Shapefile->fetchRecord()){
    //             if ($Geometry->isDeleted()) {
    //                 continue;
    //             }
    //             $data =$Geometry->getDataArray();
    //             $wkt =$Geometry->getWKT();
    //             $parent = "";
    //             $nomLoc = "";
    //             $typeSocio = "";
    //             if($typeLocalite==2){
    //                 if (isset($data['NOM_REGION'])) {
    //                     $parent = $data['NOM_REGION'];
    //                 }
    //             }else if($typeLocalite==3){
    //                 if (isset($data['NOM_PROVIN'])) {
    //                     $parent = $data['NOM_PROVIN'];
    //                 }
    //             }

    //             if(isset($data['NOM'])) {
    //                 $nomLoc = $data['NOM'];
    //             }

    //             if(isset($data['VILLE'])) {
    //                 $typeSocio = $data['VILLE'];
    //             }
    //             //dd($data);
    //             $i++;
    //             $centroid = DB::select("SELECT ST_Centroid(ST_GeomFromText('$wkt',4326)) AS centroid");
    //             $geom = DB::select("SELECT ST_GeomFromText('$wkt', 4326) AS geom");
               
    //             try{
    //                 $localite = new Localite();
    //                 $localite->typeLocalite_id = $typeLocalite;
    //                 $localite->parentLocalite_id = $this->getParent($parent);
    //                 $localite->localiteLibelle = $nomLoc;
    //                 $localite->typeLocalite_id = $typeLocalite;
    //                 $localite->typeSociologique_id = $this->getTypeSociologie($typeSocio);
    //                 $localite->centroid = $centroid[0]->centroid;
    //                 $localite->save();
    //                 $polygone = new Polygone();
    //                 $polygone->localite_id=$localite->localite_id;
    //                 $polygone->geom = $geom[0]->geom;
    //                 $polygone->save();
    //             }catch(\Exception $e){
    //                 $msgError =$e->getMessage();
    //                 return back()->with(['error'=>$msgError]);
    //             }
    //         }
    //         return back()->with('success', 'Shapefile importé avec succès.');
    //     } catch (ShapefileException $e) {
    //         return back()->with('error', 'Erreur lors de la lecture du shapefile : ' .$e->getMessage());
    //     }
    // }


    // public function getParent($nomLocalite){
    //     if($nomLocalite!=""){
    //         $localite_id = Localite::where('localiteLibelle',$nomLocalite)->first()->localite_id;
    //     }else{
    //         $localite_id = null;
    //     }
    //     return $localite_id;
    // }
     
    


    // public function getTypeSociologie($libelle){
    //     if($libelle!=""){
    //         //$type_id = TypeSociologique::where('typeSociologiqueLibelle',$libelle)->first()->typeLocalite_id;
    //         if($libelle=="Commune rurale"){
    //             $type_id = 2;
    //         }else if($libelle=="Commune urbaine"){
    //             $type_id = 1;
    //         }
    //         }else{
    //         $type_id = null;
    //     }
    //     return $type_id;
    // }
}
