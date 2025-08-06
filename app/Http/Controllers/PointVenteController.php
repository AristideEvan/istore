<?php

namespace App\Http\Controllers;

use App\Models\Localite;
use App\Models\PointVente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointVenteController extends Controller
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
      $datas = PointVente:: With([
            'localite',
        ])->get();
            return view('point_vente.index', [
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
        $data_localite = Localite::orderBy('libelleLocalite','asc')->get();
        return view ('point_vente.create')->with(['controler'=>$this,
                                                    "data_localite"=>$data_localite,
                                                    "rub"=>$rub,
                                                    "srub"=>$srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomPointVente' =>['required','string','max:255'],
            'telephonePointVente'=>['required','string','max:255'],
            'adressePointVente'=>['nullable','string','max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'localite_id'=>['required']
        ]);
        
        DB::beginTransaction();
        try{
            $pointVente= new PointVente();
            $pointVente->nomPointVente=$request->nomPointVente;
            $pointVente->telephonePointVente=$request->telephonePointVente;
            $pointVente->adressePointVente=$request->adressePointVente;
            $pointVente->logo=$request->logo;
            $pointVente->localite_id=$request->localite_id;
            $pointVente->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('pointVentes/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
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
        $data= PointVente::find($id);
        $data_localite = Localite::orderBy('libelleLocalite','asc')->get();
        return view ('point_vente.create')->with(['controler'=>$this,
                                                    "data"=>$data,
                                                    "data_localite"=>$data_localite,
                                                    "rub"=>$rub,
                                                    "srub"=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'nomPointvente' =>['required','string','max:255'],
            'telephonePointVente'=>['required','string','max:255'],
            'adressePointVente',
            'logo'=>['nullable', 'file', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // max en Ko
            'localite_id'=>'required'
        ]);
        dd($request->all());

        DB::beginTransaction();
        try{
            $pointVente= PointVente::find($id);
            $pointVente->nomPointvente=$request->nomPointvente;
            $pointVente->telephonePointVente=$request->telephonePointVente;
            $pointVente->adressePointVente=$request->adressePointVente;
            $pointVente->logo=$request->logo;
            $pointVente->localite_id=$request->localite_id;
            $$pointVente->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('pointVentes/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data=PointVente::find($id);
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
