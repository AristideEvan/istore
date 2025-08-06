<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Fournisseur;
use App\Models\Magasin;
use App\Models\ModeAchat;
use App\Models\Ravitaillement;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RavitaillementController extends Controller
{
    // declaration des variables 
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
        $datas = Ravitaillement::with('article','fournisseur','modeAchat','magasin')
        ->orderBy('dateRavi', 'desc')
        ->get();
        return view('ravitaillement.index', [
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
        $data_article = Article::orderBy('libelleArticle','asc')->get();
        $data_fournisseur = Fournisseur::orderBy('nomFournisseur','asc')->get();
        $data_modeAchat = ModeAchat::orderBy('libelleModeAchat','asc')->get();
        $data_magasin = Magasin::orderBy('nomMagasin','asc')->get();
        return view ('ravitaillement.create')->with(['controler'=>$this,
                                                    "data_article"=>$data_article,
                                                    "data_fournisseur"=>$data_fournisseur,
                                                    "data_modeAchat"=>$data_modeAchat,
                                                    "data_article"=>$data_article,
                                                    "data_magasin"=>$data_magasin,
                                                    "rub"=>$rub,
                                                    "srub"=>$srub]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dateRavi' =>['required','date'],
            'qteRavi' => ['required','array'],
            'prixAchatRavi' => ['nullable','array'],
            //'pointVente_id' => ['required'],
            'article_id' => ['required','array'],
            'fournisseur_id'=>['required'],
            'modeAchat_id'=>['required','array'],
            'magasin_id'=>['required']
        ]);
        
        DB::beginTransaction();
        try{
            //Save dans la table ravitaillement
            foreach($request->article_id as $index => $articleId) {
                    $qte = $request->qteRavi[$index];
                    $prix = $request->prixAchatRavi[$index];
                    $mode = $request->modeAchat_id[$index];

                    $ravi= new Ravitaillement();
                    $ravi->dateRavi=$request->dateRavi;
                    $ravi->qteRavi=$qte;
                    $ravi->prixAchatRavi=$prix;
                    $ravi->pointVente_id= 1;//$request->pointVente_id;
                    $ravi->article_id=$articleId;
                    $ravi->fournisseur_id=$request->fournisseur_id;
                    $ravi->modeAchat_id=$mode;
                    $ravi->magasin_id=$request->magasin_id;  
                    $ravi->save();

                    // Mise à jour du stock
                    $stock = Stock::where('article_id', $articleId)
                                ->where('pointVente_id', $ravi->pointVente_id)
                                ->first();

                    if ($stock) {
                        $stock->qteInitial = $stock->qteRestant;
                        $stock->qteRavi = $qte;
                        $stock->qteRestant = $stock->qteInitial + $qte;
                    } else {
                        $stock = new Stock();
                        $stock->article_id = $articleId;
                        $stock->pointVente_id = $ravi->pointVente_id;
                        $stock->qteInitial = 0;
                        $stock->qteRavi = $qte;
                        $stock->qteRestant = $qte;
                    }
                    $stock->save();
            }//fin foreach
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('ravitaillements/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
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
        $data= Ravitaillement::find($id);
        $data_article = Article::orderBy('libelleArticle','asc')->get();
        $data_fournisseur = Fournisseur::orderBy('nomFournisseur','asc')->get();
        $data_modeAchat = ModeAchat::orderBy('libelleModeAchat','asc')->get();
        $data_magasin = Magasin::orderBy('nomMagasin','asc')->get();
        return view ('ravitaillement.edit')->with(['controler'=>$this,
                                                    "data"=>$data,
                                                    "data_article"=>$data_article,
                                                    "data_fournisseur"=>$data_fournisseur,
                                                    "data_modeAchat"=>$data_modeAchat,
                                                    "data_article"=>$data_article,
                                                    "data_magasin"=>$data_magasin,
                                                    "rub"=>$rub,
                                                    "srub"=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $request->validate([
            'dateRavi' =>['required','date'],
            'qteRavi' => ['required', 'numeric', 'min:0'],
            'prixAchatRavi' => ['nullable', 'numeric', 'min:0'],
            //'pointVente_id' => ['required'],
            'article_id' => ['required'],
            'fournisseur_id'=>['required'],
            'modeAchat_id'=>['required'],
            'magasin_id'=>['required']
        ]);
        
        DB::beginTransaction();
        try{
            $ravi= Ravitaillement::find($id);
            $ravi->dateRavi=$request->dateRavi;
            $ravi->qteRavi=$request->qteRavi;
            $ravi->prixAchatRavi=$request->prixAchatRavi;
            //$ravi->pointVente_id=$request->pointVente_id;
            $ravi->article_id=$request->article_id;
            $ravi->fournisseur_id=$request->fournisseur_id;
            $ravi->modeAchat_id=$request->modeAchat_id;
            $ravi->magasin_id=$request->magasin_id;    
            $ravi->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
        return redirect('ravitaillements/'.request('rub').'/'.request('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $data=Ravitaillement::find($id);
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
