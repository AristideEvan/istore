<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Magasin;
use App\Models\TypeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $msgSuccess ="Opération effectuée avec succès";

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index($rub,$srub)
    {
        $data_magasin= Magasin::orderBy('nomMagasin','asc')->get();
        $data_typeArticle =TypeArticle::orderBy('libelleTypeArticle','asc')->get();
        $datas = Article::with('typeArticle')
        ->orderBy('libelleArticle','asc')
        ->get();
        
        $datas = $datas->sortBy(function ($article) {
        return $article->typeArticle->libelleTypeArticle ?? '';
             })->values();
        return view('prix.index', [
            'datas'             => $datas,
            'data_magasin'      => $data_magasin,
            'data_typeArticle'      => $data_typeArticle,
            'controler'         => $this,
            'rub'               => $rub,
            'srub'              => $srub
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $data= Article::find($id);
        return view('prix.edit')->with([
                    'controler'=>$this,
                    'data'=>$data,
                    'rub'=>$rub,
                    'srub'=>$srub
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'prixUnitaire' =>['required','number'],
        ]);
        
        DB::beginTransaction();
        try{
            $article= Article::find($id);
            $article->prixUnitaire=$request->prixUnitaire;
            $article->pointVente_id=1;
            $article->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('prixes/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
