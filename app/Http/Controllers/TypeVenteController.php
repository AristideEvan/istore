<?php

namespace App\Http\Controllers;

use App\Models\TypeVente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeVenteController extends Controller
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
        $datas=TypeVente::orderby('created_at','desc')->get();;
        return view('type_vente.index')->with(['datas'=>$datas,
                                                  'controler'=>$this,
                                                  'rub'=>$rub,
                                                  'srub'=>$srub]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub,$srub)
    {
        return view('type_vente.create')->with(['rub'=>$rub,
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
                'libelleTypeVente' => ['required', 'string','max:255'],
             ]);
            $typeVente= new TypeVente();
            $typeVente->libelleTypeVente=$request->libelleTypeVente;
            $typeVente->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('typeVentes/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
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
        $data=TypeVente::find($id);
        return view ('type_vente.edit')->with(['data'=>$data,
                                                  'rub'=>$rub,
                                                  'srub'=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'libelleTypeVente' => ['required', 'string','max:255'],
             ]);
            $typeVente= TypeVente::find($id);
            $typeVente->libelleTypeVente=$request->libelleTypeVente;
            $typeVente->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('typeVentes/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data=TypeVente::find($id);
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
