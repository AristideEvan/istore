<?php

namespace App\Http\Controllers;

use App\Models\ModeReglement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeReglementController extends Controller
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
      $datas=ModeReglement::orderby('created_at','desc')->get();;
      return view('mode_reglement.index')->with(['datas'=>$datas,
                                                  'controler'=>$this,
                                                  'rub'=>$rub,
                                                  'srub'=>$srub]);   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub,$srub)
    {
        return view('mode_reglement.create')->with(['rub'=>$rub,
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
                'libelleModeReglement' => ['required', 'string','max:255'],
             ]);
            $modeReglement= new ModeReglement();
            $modeReglement->libelleModeReglement=$request->libelleModeReglement;
            $modeReglement->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('modeReglements/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
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
        $data=ModeReglement::find($id);
        return view ('mode_reglement.edit')->with(['data'=>$data,
                                                  'rub'=>$rub,
                                                  'srub'=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'libelleModeReglement' => ['required', 'string','max:255'],
             ]);
            $modeReglement= ModeReglement::find($id);
            $modeReglement->libelleModeReglement=$request->libelleModeReglement;
            $modeReglement->save();
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('modeReglements/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $data=ModeReglement::find($id);
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
