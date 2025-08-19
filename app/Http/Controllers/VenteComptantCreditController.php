<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\LigneVente;
use App\Models\ModeReglement;
use App\Models\Recette;
use App\Models\Remise;
use App\Models\Taxe;
use App\Models\TypeArticle;
use App\Models\TypeClient;
use App\Models\TypeVente;
use App\Models\VenteComptantCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenteComptantCreditController extends Controller
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
        $datas = VenteComptantCredit::with( 'ligneVente_vente',
                                            'ligneVente_typeVente',
                                            'ligneVente_client.typeClient',
                                            'ligneVente_article')
                ->orderBy('created_at','DESC')                            
                ->get();
        return view('vente_comptant_credit.index', [
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
        $data_typeClient=TypeClient::orderBy('libelleTypeClient')->get();
        $data_typeVente = TypeVente::orderBy('libelleTypeVente')->get();
        $data_typeArticle= TypeArticle::orderBy('libelleTypeArticle')->get();
        $data_article= Article::orderBy('libelleArticle','asc')->get();
        $data_remise= Remise::orderBy('tauxRemise','asc')->get();
        $data_taxe= Taxe::orderBy('tauxTva','asc')->get();
        $data_modeReglement= ModeReglement::orderBy('libelleModeReglement','asc')->get();
        return view('vente_comptant_credit.create')->with([ 
             'controler'            =>$this,
             'rub'                  =>$rub,
             'srub'                 =>$srub,
             'data_typeClient'      =>$data_typeClient,
             'data_typeVente'       =>$data_typeVente,
             'data_typeArticle'     =>$data_typeArticle,
             'data_article'         =>$data_article,
             'data_remise'          =>$data_remise,
             'data_taxe'            =>$data_taxe,
             'data_modeReglement'   =>$data_modeReglement
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd(request());
        DB::beginTransaction();
        try {
            $request->validate([
                //vente comptant ou Ventecredit
                'dateVente' => ['required','date'],
                'numRecuVente'=> ['nullable','string','max:255'],
                'mtTotalVente'=> ['required','numeric'],
                'mtRemiseVente' => ['required','numeric'],
                'mtTvaVente' => ['required','numeric'],
                'mtNetVente' => ['required','numeric'],
                'modeReglement_id' => 'nullable',
                'reference' => ['nullable','string','max:255'],
                'taxe_id' => ['required','numeric'],
                'remise_id' => ['required','numeric'],
                'delaiReglement_id' => 'nullable',

                //lignes de vente
                'qteVente' =>['required','numeric'],
                'prixVente' =>['nullable','numeric'],
                'mtHtVente'=>['required','numeric'],
                'article_id'=>['required'],
                'client_id'=>['required'],
                'typeVente_id'=>['required'],
                
                //recettes
                'reglement_id' => 'nullable'

             ]);

            //IF TYPECLIENT === CLIENT CREDIT
            $typeClient = DB::table('type_clients')
                        ->where('typeClient_id',$request->typeClient_id) 
                        ->value('libelleTypeClient');

            if ($typeClient === 'CLIENT CREDIT'){
                $clientCred= new VenteComptantCredit();
               
            } else{ // CLIENT COMPTANT
               
                //table vente comptant
                $clientComp= new VenteComptantCredit();
                $clientComp->dateVente=$request->dateVente;
                $clientComp->numRecuVente=$request->numRecuVente;
                $clientComp->mtTotalVente=$request->mtTotalVente;
                $clientComp->mtRemiseVente=$request->mtRemiseVente;
                $clientComp->mtTvaVente=$request->mtTvaVente;
                $clientComp->mtNetVente=$request->mtNetVente;
                $clientComp->modeReglement_id=$request->modeReglement_id;
                $clientComp->reference=$request->reference;
                $clientComp->taxe_id=$request->taxe_id;
                $clientComp->remise_id=$request->remise_id;
                $clientComp->save();

                //table ligne vente comptant
                $ligneComp = new LigneVente();
                $ligneComp->qteVente= $request->qteVente;
                $ligneComp->prixVente= $request->prixVente;
                $ligneComp->mtHtVente= $request->mtHtVente;
                $ligneComp->article_id= $request->article_id;
                $ligneComp->client_id= $request->client_id;
                $ligneComp->typeVente_id= $request->typeVente_id;
                //recuperer id de vente_id à partir de la table vente_comptant_credits
                $venteCompId = DB::table('vente_comptant_credits')
                                ->orderBy('vente_id','DESC')
                                ->value('vente_id'); 
                $ligneComp->vente_id= $venteCompId;
                $ligneComp->save();

                //table recette
                $recette =new Recette();
                $recette->dateRecette= $request->dateVente;
                $recette->mtRecette= $request->mtNetVente;
                $recette->vente_id= $venteCompId;
                $recette->save();
            }  
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('venteComptantCredits/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
