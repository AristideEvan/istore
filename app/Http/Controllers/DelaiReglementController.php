<?php

namespace App\Http\Controllers;

use App\Models\DelaiReglement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelaiReglementController extends Controller
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
        $datas=DelaiReglement::orderby('created_at','desc')->get();;
        return view('delai_reglement.index')->with(['datas'=>$datas,
                                                  'controler'=>$this,
                                                  'rub'=>$rub,
                                                  'srub'=>$srub]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub,$srub)
    {
        return view('delai_reglement.create')->with(['rub'=>$rub,
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
                'nbreJours' => 'required',
                'mtPenalite' => 'required',
                'delaiActif',
             ]);
            $delaiReglement= new DelaiReglement();
            $delaiReglement->nbreJours=$request->nbreJours;
            $delaiReglement->mtPenalite=$request->mtPenalite;
            $delaiReglement->delaiActif=$request->delaiActif;
            $delaiReglement->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('delaiReglements/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]); 
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
        $data=DelaiReglement::find($id);
        return view ('delai_reglement.edit')->with(['data'=>$data,
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
                'nbreJours' => 'required',
                'mtPenalite' => 'required',
                'delaiActif',
             ]);
            $delaiReglement= DelaiReglement::find($id);
            $delaiReglement->nbreJours=$request->nbreJours;
            $delaiReglement->mtPenalite=$request->mtPenalite;
            $delaiReglement->delaiActif=$request->delaiActif;
            //$delaiReglement->delaiActif = $request->has('delaiActif');
            $delaiReglement->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('delaiReglements/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]); 
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data=DelaiReglement::find($id);
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
