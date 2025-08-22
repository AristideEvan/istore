<?php

namespace App\Http\Controllers;


use App\Models\Fournisseur;
use App\Models\Indicateur;
use App\Models\Localite;
use App\Models\Magasin;
use App\Models\ModeAchat;
use App\Models\TypeArticle;
use App\Models\TypeLocalite;
use App\Models\TypeStructure;
use App\Models\ValeurIndicateurStructure;

use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{

    // public function getLocalitesFils($parentId){
    //     $parent=Localite::find($parentId);
    //     $fils = $parent->fils()->orderBy('localiteLibelle', 'asc')->get();
    //     if(count($fils)>0){
    //         echo '<option value=""></option>';
    //         foreach($fils as $fil){
    //             echo '<option  value="'.$fil->localite_id.'">'.$fil->localiteLibelle.'</option>';
    //         }
    //     }else{
    //         echo '<option value="">Aucune province trouvée</option>';
    //     }
    // }


    public function getLocaliteByType($type){
        // $typeLocalite = TypeLocalite::find($type);
        // $localites = $typeLocalite->localites()->orderBy('localiteLibelle', 'ASC')->get();
        // if(count($localites)>0){
        //     echo '<option value=""></option>';
        //     foreach($localites as $fil){
        //         echo '<option  value="'.$fil->localite_id.'">'.$fil->localiteLibelle.'</option>';
        //     }
        // }else{
        //     echo '<option value="">Aucune '.$typeLocalite->typeLocaliteLibelle.' trouvée</option>';
        // }
    }

     //afficher le telephone et le numero identifiant du fournisseur en fonction du id de ce dernier

    public function getFournisseurById($id){
        $fournisseur = Fournisseur::find($id);
        if ($fournisseur) {
            return response()->json([
                'telephone' => $fournisseur->telephoneFournisseur,
                'numero' => $fournisseur->numeroIdentifiant
            ]);
        } else {
            return response()->json(['error' => 'Nom fournisseur non trouvé'], 404);
        }
    }

    public function getMagasinById($id){
        $magasin = Magasin::find($id);
        if ($magasin) {
            return response()->json([
                'capacite' => $magasin->capacite,
            ]);
        } else {
            return response()->json(['error' => 'Capacité non trouvée'], 404);
        }
    }
    //afficher quantite restante & prix unitaire en fonction de l'article
    public function getQteRestantById($id){
        $stock_prix= DB::table('stocks AS s')
                ->join('articles AS a','s.article_id','=','a.article_id')
                ->where('s.article_id','=',$id)
                ->select('s.qteRestant','a.prixUnitaire')
                ->first();
                if ($stock_prix!==null){
                    return response()->json([
                        'quantiteRest' =>$stock_prix-> qteRestant,
                        'prixUnit'=> $stock_prix->prixUnitaire
                    ]);
                }else{
                     return response()->json(['error' => 'Quantité restante ou prix unitaire non trouvée'], 404);
                }
    }

    //afficher les articles restants en fonction du magasin selectionné
    public function getInfoMagasinById($id){
        if ($id!=="tout"){
             $infoStock= DB::table('stocks AS s')
                    ->join('articles AS a','s.article_id','=','a.article_id')
                    ->join('type_articles AS ta','a.typeArticle_id','=','ta.typeArticle_id')
                    ->join('ravitaillements AS r','a.article_id','=','r.article_id')
                    ->join('magasins AS m','r.magasin_id','=','m.magasin_id')
                    ->where('r.magasin_id','=',$id)
                    ->distinct()
                    ->select('ta.libelleTypeArticle','a.libelleArticle','s.qteRestant')
                    ->get();
        }else{
                     $infoStock= DB::table('stocks AS s')
                    ->join('articles AS a','s.article_id','=','a.article_id')
                    ->join('type_articles AS ta','a.typeArticle_id','=','ta.typeArticle_id')
                    ->join('ravitaillements AS r','a.article_id','=','r.article_id')
                    ->join('magasins AS m','r.magasin_id','=','m.magasin_id')
                    ->distinct()
                    ->select('ta.libelleTypeArticle','a.libelleArticle','s.qteRestant')
                    ->get();
        }
                    if($infoStock->isNotEmpty()){
                        return response()->json($infoStock);
                    }else{
                        return response()->json(['error' => 'Aucune donnée'], 404);
                    }
    }

    //afficher un article en fonction d'un type article choisi formulaire : ravitaillement
    public function getTypeArticleById($id,$data){
        $typeArticle = TypeArticle::find($id);
        //$items = $typeArticle->articles()-> ->orderBy('libelleArticle', 'ASC')->get();
        $items = DB::select('SELECT * FROM articles WHERE "typeArticle_id"='.$id.' AND article_id NOT IN ('.$data.')');
        if(count($items)>0){
            echo '<option value=""></option>';
            foreach($items as $pere){
                echo '<option  value="'.$pere->article_id.'">'.$pere->libelleArticle.'</option>';
            }
        }else{
            echo '<option value="">Aucune '.$typeArticle->libelleArticle.' trouvée</option>';
        }
    }

    public function getLoaderStockById($id){
        $datas = DB::select(
        'SELECT ta."libelleTypeArticle", a."libelleArticle", s."qteRestant"
         FROM ravitaillements r
         JOIN stocks s ON r."article_id" = s."article_id"
         JOIN articles a ON s."article_id" = a."article_id"
         JOIN type_articles ta ON a."typeArticle_id" = ta."typeArticle_id"
         WHERE r."magasin_id" = :id',
            ['id' => $id]
        );
            if (empty($datas)) {
                return response()->json(['error' => 'Aucun stock trouvé pour ce magasin.'], 404);
            }
            return response()->json($datas);
            
    }

    //afficher les identites d'un client en fonction de son type client
    public function getInfoClientByTypeId($id){
        $nom= DB::table('clients AS c')
                ->join('type_clients AS tc','c.typeClient_id','=','tc.typeClient_id')
                ->where('tc.typeClient_id','=',$id)
                ->select('c.client_id','c.nomClient','c.prenomClient','c.telephoneClient')
                ->get();
              if ($nom->isNotEmpty()){
                 return response()->json($nom);
              }else{
                return response()->json(['error' => 'Aucune donnée'], 404);
              } 
    }

    //fonction qui permet de ne pas repeter 2 fois un article dans la liste deroulante. formulaire : Ravitaillement
    public function getArticle($data){
        $data_modeAchat = ModeAchat::orderBy('libelleModeAchat','asc')->get();
        $articles=DB::select('SELECT * FROM articles WHERE article_id NOT IN ('.$data.')');
        $key = $this->genererNom();
        return view('ravitaillement.formArticle')->with([
            'data_modeAchat'=>$data_modeAchat,
            'data_article'=>$articles,
            'key'=>$key
        ]);
    }

    //afficher article en fonction du type article formulaire : vente_comptant_credit
    public function getTypeArticleByArticle($id){
        $data_typeArticle= TypeArticle::orderBy('libelleTypeArticle','ASC')->get();
        $articles = DB::select('SELECT * FROM articles WHERE article_id NOT IN ('.$id.')');
        $key =$this->genererNom();
        return view('vente_comptant_credit.formArticle')->with([
                        'data_typeArticle' => $data_typeArticle,
                        'data_article'     => $articles,
                        'key'              => $key
        ]);
    }

    

    // public function getStructure($typeStructureId){
    //     $typeStructure=TypeStructure::find($typeStructureId);
    //     $structures = $typeStructure->structure()->orderBy('structureLibelle', 'asc')->get();
    //     if(count($structures)>0){
    //         echo '<option value=""></option>';
    //         foreach($structures as $structure){
    //             echo '<option  value="'.$structure->structure_id.'">'.$structure->structureLibelle.'</option>';
    //         }
    //     }else{
    //         echo '<option value="">Aucune structure trouvée</option>';
    //     }
    // }
    



    //afficher la liste des indicateurs qui ne sont pas dans la table valeur_indicateur_localites
    // public function getDonneeBaseSaisie($idLoc,$idThematique,$anneeCollect){
    //     $donneesNonSaisie=DB::select('SELECT * from indicateurs  where thematique_id='.$idThematique.' AND indicateur_id NOT IN (SELECT indicateur_id FROM valeur_indicateur_localites WHERE localite_id='.$idLoc.' AND annee='.$anneeCollect.')');
    //             return view('valeur_indicateur_localite.donneesNonSaisie')->with([
    //                                                                              "datas"=>$donneesNonSaisie,
    //                                                                              "idLoc"=>$idLoc,
    //                                                                              "idThematique"=>$idThematique,
    //                                                                              "anneeCollect"=>$anneeCollect
    //                                                                             ]);
    // } 

   

    // public function getDonneeBaseSaisieStructure($structure_id,$thematique_id,$annee){      
    //     // Récupère les IDs des indicateurs déjà saisis
    //     $idsDejaSaisis = ValeurIndicateurStructure::where('structure_id', $structure_id)
    //         ->where('annee', $annee)
    //         ->pluck('indicateur_id');

    //     // Récupère les indicateurs de la thématique qui ne sont pas encore saisis
    //     $indicateursNonSaisis = Indicateur::where('thematique_id', $thematique_id)
    //         ->whereNotIn('indicateur_id', $idsDejaSaisis)
    //         ->get();

    //    return view('valeur_indicateur_structure.donneeNonSaisie')->with([
    //     "datas"=>$indicateursNonSaisis,
    //     "structure_id"=>$structure_id,
    //     "thematique_id"=>$thematique_id,
    //     "annee"=>$annee
    //    ]);
        
    // }

    // public function getDonneeSaisie($structure_id, $thematique_id, $annee) {
    //     $donneesNonSaisie = ValeurIndicateurStructure::with('indicateur')
    //         ->where('structure_id', $structure_id)
    //         ->where('annee', $annee)
    //         ->whereHas('indicateur', function ($query) use ($thematique_id) {
    //             $query->where('thematique_id', $thematique_id);
    //         })
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //         return view('valeur_indicateur_structure.donneeSaisie')->with([
    //             "datas" => $donneesNonSaisie,
    //             "structure_id" => $structure_id,
    //             "thematique_id" => $thematique_id,
    //             "annee" => $annee
    //         ]);
    //     }
    
}
