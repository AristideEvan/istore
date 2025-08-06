<?php

namespace App\Http\Controllers;

use App\Models\TypeFournisseur;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TypeFournisseurController extends Controller
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
        $datas=TypeFournisseur::orderby('created_at','desc')->get();;
        return view('type_fournisseur.index')->with(['datas'=>$datas,
                                                  'controler'=>$this,
                                                  'rub'=>$rub,
                                                  'srub'=>$srub]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub,$srub)
    {
         return view('type_fournisseur.create')->with(['rub'=>$rub,
                                                   'srub'=>$srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'libelleTypeFournisseur' => ['required', 'string','max:255'],
             ]);
            $typeFournisseur= new TypeFournisseur();
            $typeFournisseur->libelleTypeFournisseur=$request->libelleTypeFournisseur;
            $typeFournisseur->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('typeFournisseurs/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
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
        $data=TypeFournisseur::find($id);
        return view ('type_fournisseur.edit')->with(['data'=>$data,
                                                  'rub'=>$rub,
                                                  'srub'=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'libelleTypeFournisseur' => ['required', 'string','max:255'],
             ]);
            $typeFournisseur= TypeFournisseur::find($id);
            $typeFournisseur->libelleTypeFournisseur=$request->libelleTypeFournisseur;
            $typeFournisseur->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('typeFournisseurs/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $data=TypeFournisseur::find($id);
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
