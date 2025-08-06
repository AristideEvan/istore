<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\TypeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
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
        $datas = Article::with('typeArticle')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('article.index', [
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
        $data_typeArticle = TypeArticle::orderBy('libelleTypeArticle','asc')->get();
        return view ('article.create')->with(['controler'=>$this,
                                              "data_typeArticle"=>$data_typeArticle,
                                              "rub"=>$rub,
                                              "srub"=>$srub]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelleArticle' =>['required','string','max:255'],
            'descriptionArticle'=>['nullable','string','max:255'],
            'uniteMesure'=>['nullable','string','max:255'],
            'couleur' => ['nullable', 'string', 'max:255'],
            'poids' => ['nullable', 'string', 'max:255'],
            'stockAlerte'=> ['nullable', 'numeric'],
            'datePeremption'=>['nullable','date'],
            'typeArticle_id'=>['required'],
            //'pointVente_id'=>['required']
        ]);
        
        DB::beginTransaction();
        try{
            $article= new Article();
            $article->libelleArticle=$request->libelleArticle;
            $article->descriptionArticle=$request->descriptionArticle;
            $article->uniteMesure=$request->uniteMesure;
            $article->couleur=$request->couleur;
            $article->poids=$request->poids;
            $article->stockAlerte=$request->stockAlerte;
            $article->datePeremption=$request->datePeremption;
            $article->typeArticle_id=$request->typeArticle_id;
            $article->pointVente_id=1;
               //dd($article);
            $article->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('articles/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
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
        $data_typeArticle = TypeArticle::orderBy('libelleTypeArticle','asc')->get();
        return view ('article.edit')->with(['controler'=>$this,
                                                    "data"=>$data,
                                                    "data_typeArticle"=>$data_typeArticle,
                                                    "rub"=>$rub,
                                                    "srub"=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'libelleArticle' =>['required','string','max:255'],
            'descriptionArticle'=>['nullable','string','max:255'],
            'uniteMesure'=>['nullable','string','max:255'],
            'couleur' => ['nullable', 'string', 'max:255'],
            'stockAlerte'=> ['nullable', 'numeric'],
            'poids' => ['nullable', 'string', 'max:255'],
            'datePeremption'=>['nullable','date'],
            'typeArticle_id'=>['required'],
            //'pointVente_id'=>['required']
        ]);
        
        DB::beginTransaction();
        try{
            $article= Article::find($id);
            $article->libelleArticle=$request->libelleArticle;
            $article->descriptionArticle=$request->descriptionArticle;
            $article->uniteMesure=$request->uniteMesure;
            $article->couleur=$request->couleur;
            $article->poids=$request->poids;
            $article->stockAlerte=$request->stockAlerte;
            $article->datePeremption=$request->datePeremption;
            $article->typeArticle_id=$request->typeArticle_id;
            $article->pointVente_id=1;
            $article->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('articles/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $data=Article::find($id);
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
