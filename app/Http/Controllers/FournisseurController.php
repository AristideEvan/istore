<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\TypeFournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FournisseurController extends Controller
{
    private $msgSuccess ="Opération effectuée avec succès";
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
       $this->middleware('auth');
    }
    public function index($rub,$srub)
    {
        $datas = Fournisseur:: With([
            'typeFournisseur',
        ])->get();
            return view('fournisseur.index', [
                'datas'     => $datas,
                'controler' => $this,
                'rub'       => $rub,
                'srub'      => $srub,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create($rub,$srub)
    {
        $data_typeFournisseur = TypeFournisseur::orderBy('libelleTypeFournisseur','asc')->get();
        return view ('fournisseur.create')->with(['controler'=>$this,
                                                    "data_typeFournisseur"=>$data_typeFournisseur,
                                                    "rub"=>$rub,
                                                    "srub"=>$srub]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomFournisseur' =>['required','string','max:255'],
            'telephoneFournisseur'=>['required','string','max:255'],
            'adresseFournisseur'=>['nullable','string','max:255'],
            'emailFournisseur' => ['nullable', 'email', 'max:255'],
            'numeroIdentifiant' => ['nullable', 'string', 'max:255'],
            'typeFournisseur_id'=>['required']
        ]);
        
        DB::beginTransaction();
        try{
            $fournisseur= new Fournisseur();
            $fournisseur->nomFournisseur=$request->nomFournisseur;
            $fournisseur->telephoneFournisseur=$request->telephoneFournisseur;
            $fournisseur->adresseFournisseur=$request->adresseFournisseur;
            $fournisseur->emailFournisseur=$request->emailFournisseur;
            $fournisseur->numeroIdentifiant=$request->numeroIdentifiant;
            $fournisseur->typeFournisseur_id=$request->typeFournisseur_id;
            $fournisseur->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('fournisseurs/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
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
        $data= Fournisseur::find($id);
        $data_typeFournisseur = TypeFournisseur::orderBy('libelleTypeFournisseur','asc')->get();
        return view ('fournisseur.edit')->with(['controler'=>$this,
                                                    "data"=>$data,
                                                    "data_typeFournisseur"=>$data_typeFournisseur,
                                                    "rub"=>$rub,
                                                    "srub"=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
         $request->validate([
            'nomFournisseur' =>['required','string','max:255'],
            'telephoneFournisseur'=>['required','string','max:255'],
            'adresseFournisseur'=>['nullable','string','max:255'],
            'emailFournisseur' => ['nullable', 'email', 'max:255'],
            'numeroIdentifiant' => ['nullable', 'string', 'max:255'],
            'typeFournisseur_id'=>['required']
        ]);
        
        DB::beginTransaction();
        try{
            $fournisseur= Fournisseur::find($id);
            $fournisseur->nomFournisseur=$request->nomFournisseur;
            $fournisseur->telephoneFournisseur=$request->telephoneFournisseur;
            $fournisseur->adresseFournisseur=$request->adresseFournisseur;
            $fournisseur->emailFournisseur=$request->emailFournisseur;
            $fournisseur->numeroIdentifiant=$request->numeroIdentifiant;
            $fournisseur->typeFournisseur_id=$request->typeFournisseur_id;
            $fournisseur->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('fournisseurs/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data=Fournisseur::find($id);
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
}
