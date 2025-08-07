<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExplorerCarteController;
use App\Http\Controllers\InitController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DelaiReglementController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocaliteController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\ModeAchatController;
use App\Http\Controllers\ModeReglementController;
use App\Http\Controllers\PointVenteController;
use App\Http\Controllers\PrixController;
use App\Http\Controllers\RavitaillementController;
use App\Http\Controllers\RemiseController;
use App\Http\Controllers\StatutController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TaxeController;
use App\Http\Controllers\TypeArticleController;
use App\Http\Controllers\TypeClientController;
use App\Http\Controllers\TypeFournisseurController;
use App\Http\Controllers\TypeLocaliteController;
use App\Http\Controllers\TypeVenteController;

 Route::get('/', function () {
    return view('welcome');
});
// //Definition de la route Explorer
//  Route::get('/explorer', [ExplorerCarteController::class, 'explorer']);


// Route type de localité
Route::resource('typeLocalites', TypeLocaliteController::class);
Route::get('typeLocalites/{rub}/{srub}', [TypeLocaliteController::class, 'index']);
Route::get('typeLocalites/create/{rub}/{srub}', [TypeLocaliteController::class, 'create']);
Route::get('typeLocalites/{id}/edit/{rub}/{srub}', [TypeLocaliteController::class, 'edit']);


//Route localite
Route::resource('localites',LocaliteController::class);
Route::get('localites/{rub}/{srub}', [LocaliteController::class, 'index']);
Route::get('localites/create/{rub}/{srub}', [LocaliteController::class, 'create']);
Route::get('localites/{id}/edit/{rub}/{srub}', [LocaliteController::class, 'edit']);

###############DEFINITION DES ROUTE POtypeLocaliteLibelleUR LA GESTION TYPE NIVEAU##########################################################################

//Inituser
Route::get('/inituser/{identifiant}', [InitController::class, 'initUser']); 
//Route::get('/inituser/{identifiant}', [InitController::class, 'initUser'])->name('init.user');

//Inituser
//Route::get('/inituser/{identifiant}', [InitController::class, 'initUser'])->name('init.user');

// //Inituser
// Route::get('/inituser/{identifiant}', [InitController::class, 'initUser']); 

// ###############DEFINITION DES ROUTE POUR LA GESTION STATUT##########################################################################
// Route::resource('statut',StatutController::class);
// Route::get('statut/index',[StatutController::class,'index']);
// Route::get('statut/create',[StatutController::class,'create']);
// Route::get('statut/edit/{id}',[StatutController::class,'edit']);

// //Ressource
// Route::resource('typeSeuils',TypeSeuilController::class);
// Route::get('typeSeuils/{rub}/{srub}', [TypeSeuilController::class, 'index']);
// Route::get('typeSeuils/create/{rub}/{srub}', [TypeSeuilController::class, 'create']);
// Route::get('typeSeuils/{id}/edit/{rub}/{srub}', [TypeSeuilController::class, 'edit']);

// //typeEntiteEftps
// Route::resource('typeEntiteEftps', TypeEntiteEftpController::class);
// Route::get('typeEntiteEftps/{rub}/{srub}', [TypeEntiteEftpController::class, 'index']);
// Route::get('typeEntiteEftps/create/{rub}/{srub}', [TypeEntiteEftpController::class, 'create']);
// Route::get('typeEntiteEftps/{id}/edit/{rub}/{srub}', [TypeEntiteEftpController::class, 'edit']);

// //niveaux
// Route::resource('niveaux', NiveauController::class);
// Route::get('niveaux/{rub}/{srub}', [NiveauController::class, 'index']);
// Route::get('niveaux/create/{rub}/{srub}', [NiveauController::class, 'create']);
// Route::get('niveaux/{id}/edit/{rub}/{srub}', [NiveauController::class, 'edit']);

// //typeSociologique
// Route::resource('typeSociologique',TypeSociologiqueController::class);
// Route::resource('uniteMesure',UniteMesureController::class);
// Route::resource('thematique',ThematiqueController::class);

// Route::resource('typeEntiteEftps', TypeEntiteEftpController::class);

// //TypeStructure
// Route::resource('typeStructure',TypeStructureController::class);
// Route::get('typeStructure/{rub}/{srub}', [TypeStructureController::class, 'index']);
// Route::get('typeStructure/create/{rub}/{srub}', [TypeStructureController::class, 'create']);
// Route::get('typeStructure/{id}/edit/{rub}/{srub}', [TypeStructureController::class, 'edit']);

// //TypeIndicateur
// Route::resource('typeIndicateur',TypeIndicateurController::class);
// Route::get('typeIndicateur/{rub}/{srub}', [TypeIndicateurController::class, 'index']);
// Route::get('typeIndicateur/create/{rub}/{srub}', [TypeIndicateurController::class, 'create']);
// Route::get('typeIndicateur/{id}/edit/{rub}/{srub}', [TypeIndicateurController::class, 'edit']);

// //Indicateur
// Route::resource('indicateur',IndicateurController::class);
// Route::get('indicateur/{rub}/{srub}', [IndicateurController::class, 'index']);
// Route::get('indicateur/create/{rub}/{srub}', [IndicateurController::class, 'create']);
// Route::get('indicateur/{id}/edit/{rub}/{srub}', [IndicateurController::class, 'edit']);

// //Metier
// Route::resource('metier',MetierController::class);
// Route::get('metier/{rub}/{srub}', [MetierController::class, 'index']);
// Route::get('metier/create/{rub}/{srub}', [MetierController::class, 'create']);
// Route::get('metier/{id}/edit/{rub}/{srub}', [MetierController::class, 'edit']);

// //Seuil
// Route::resource('seuil',SeuilController::class);
// Route::get('seuil/{rub}/{srub}', [SeuilController::class, 'index']);
// Route::get('seuil/create/{rub}/{srub}', [SeuilController::class, 'create']);
// Route::get('seuil/{id}/edit/{rub}/{srub}', [SeuilController::class, 'edit']);
// Route::get('seuil/{id}/show/{rub}/{srub}',[SeuilController::class,'show']);





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//action
require __DIR__.'/auth.php';
Route::resource('action', ActionController::class);
Route::get('action/{rub}/{srub}', [ActionController::class, 'index']);
Route::get('action/create/{rub}/{srub}', [ActionController::class, 'create']);
Route::get('action/{id}/edit/{rub}/{srub}', [ActionController::class, 'edit']);

//menu
Route::resource('menu', MenuController::class);
Route::post('menu', [MenuController::class, 'store'])->name('menu.store');
Route::get('menu/{rub}/{srub}', [MenuController::class, 'index']);
Route::get('menu/create/{rub}/{srub}', [MenuController::class, 'create']);
Route::get('menu/{id}/edit/{rub}/{srub}', [MenuController::class, 'edit']);

// //profil
Route::resource('profil', ProfilController::class);
Route::get('profil/{rub}/{srub}', [ProfilController::class, 'index']);
Route::get('profil/create/{rub}/{srub}', [ProfilController::class, 'create']);
Route::get('profil/{id}/edit/{rub}/{srub}', [ProfilController::class, 'edit']);

// //user
Route::resource('user', UserController::class);
Route::get('user/{rub}/{srub}', [UserController::class, 'index']);
Route::get('user/create/{rub}/{srub}', [UserController::class, 'create']);
Route::get('user/{id}/edit/{rub}/{srub}', [UserController::class, 'edit']);
Route::get('comptenonactif/{rub}/{srub}', [UserController::class, 'compteNonValide']);
Route::get('comptenonactif', [UserController::class, 'comptenonactif'])->name('comptenonactif');
Route::post('changerEtatCompte/{id}', [UserController::class, 'changerEtatCompte']);
Route::get('changerEtatCompte', [UserController::class, 'changerEtatCompte'])->name('changerEtatCompte');
Route::get('/editPass/{iduser}/{rub}/{srub}', [UserController::class, 'editPass']);
Route::post('saveEditPass/{id}', [UserController::class, 'saveEditPass']);

// //Route pour les types sociologiques
// Route::resource('typeSociologique',TypeSociologiqueController::class);
// Route::get('typeSociologique/{rub}/{srub}',[TypeSociologiqueController::class,'index']);
// Route::get('typeSociologique/create/{rub}/{srub}', [TypeSociologiqueController::class, 'create']);
// Route::get('typeSociologique/{id}/edit/{rub}/{srub}', [TypeSociologiqueController::class, 'edit']);

// //Route pour les unités de mesure
// Route::resource('uniteMesure',UniteMesureController::class);
// Route::get('uniteMesure/{rub}/{srub}',[UniteMesureController::class,'index']);
// Route::get('uniteMesure/create/{rub}/{srub}', [UniteMesureController::class, 'create']);
// Route::get('uniteMesure/{id}/edit/{rub}/{srub}', [UniteMesureController::class, 'edit']);

// //Route pour les thématique
// Route::resource('thematique',ThematiqueController::class);
// Route::get('thematique/{rub}/{srub}',[ThematiqueController::class,'index']);
// Route::get('thematique/create/{rub}/{srub}', [ThematiqueController::class, 'create']);
// Route::get('thematique/{id}/edit/{rub}/{srub}', [ThematiqueController::class, 'edit']);

// //Route::get('/setVisibleMenu/{idmenu}', [AjaxController::class, 'setVisibleMenu']);
// ############### DEFINITION DES ROUTE POUR LA GESTION DES NIVEAU ##########################################################################
// Route::resource('typeNiveau',TypeNiveauController::class);
// Route::get('typeNiveau/{rub}/{srub}',[TypeNiveauController::class,'index']);
// Route::get('typeNiveau/create/{rub}/{srub}',[TypeNiveauController::class,'create']);
// Route::get('typeNiveau/{id}/edit/{rub}/{srub}',[TypeNiveauController::class,'edit']);

// ############### DEFINITION DES ROUTE POUR LA GESTION DES STATUT ##########################################################################
// Route::resource('statut',StatutController::class);
// Route::get('statut/{rub}/{srub}',[StatutController::class,'index']);
// Route::get('statut/create/{rub}/{srub}',[StatutController::class,'create']);
// Route::get('statut/{id}/edit/{rub}/{srub}',[StatutController::class,'edit']);

// ############### DEFINITION DES ROUTE POUR LA GESTION DES PERIODICITE ##########################################################################
// Route::resource('periodicite',PeriodiciteController::class);
// Route::get('periodicite/{rub}/{srub}',[PeriodiciteController::class,'index']);
// Route::get('periodicite/create/{rub}/{srub}',[PeriodiciteController::class,'create']);
// Route::get('periodicite/{id}/edit/{rub}/{srub}',[PeriodiciteController::class,'edit']);



// //Ressource
// Route::resource('typeSeuils',TypeSeuilController::class);
// Route::resource('typeSociologique',TypeSociologiqueController::class);
// Route::resource('uniteMesure',UniteMesureController::class);
// Route::resource('thematique',ThematiqueController::class);


// //TypeStructure
// Route::resource('typeStructure',TypeStructureController::class);
// Route::get('typeStructure/{rub}/{srub}', [TypeStructureController::class, 'index']);
// Route::get('typeStructure/create/{rub}/{srub}', [TypeStructureController::class, 'create']);
// Route::get('typeStructure/{id}/edit/{rub}/{srub}', [TypeStructureController::class, 'edit']);

// //TypeIndicateur
// Route::resource('typeIndicateur',TypeIndicateurController::class);
// Route::get('typeIndicateur/{rub}/{srub}', [TypeIndicateurController::class, 'index']);
// Route::get('typeIndicateur/create/{rub}/{srub}', [TypeIndicateurController::class, 'create']);
// Route::get('typeIndicateur/{id}/edit/{rub}/{srub}', [TypeIndicateurController::class, 'edit']);

// //Metier
// Route::resource('metier',MetierController::class);
// Route::get('metier/{rub}/{srub}', [MetierController::class, 'index']);
// Route::get('metier/create/{rub}/{srub}', [MetierController::class, 'create']);
// Route::get('metier/{id}/edit/{rub}/{srub}', [MetierController::class, 'edit']);

// //Seuil
// Route::resource('seuil',SeuilController::class);
// Route::get('seuil/{rub}/{srub}', [SeuilController::class, 'index']);
// Route::get('seuil/create/{rub}/{srub}', [SeuilController::class, 'create']);
// Route::get('seuil/{id}/edit/{rub}/{srub}', [SeuilController::class, 'edit']);


// //eftpEntites
// Route::resource('eftpEntites', EftpEntiteController::class);
// Route::get('eftpEntites/{rub}/{srub}', [EftpEntiteController::class, 'index']);
// Route::get('eftpEntites/create/{rub}/{srub}', [EftpEntiteController::class, 'create']);
// Route::get('eftpEntites/{id}/edit/{rub}/{srub}', [EftpEntiteController::class, 'edit']);

// //Type Niveau
// Route::resource('typeNiveau', TypeNiveauController::class);
// Route::get('typeNiveau/{rub}/{srub}', [TypeNiveauController::class, 'index']);
// Route::get('typeNiveau/create/{rub}/{srub}', [TypeNiveauController::class, 'create']);
// Route::get('typeNiveau/{id}/edit/{rub}/{srub}', [TypeNiveauController::class, 'edit']);

// //ImportLocalite
// Route::get('/importLocalite',[LocaliteController::class,'formImport']);
// Route::get('/importStructure',[StructureController::class,'formImport']);


// // LoadSharpe
// Route::post('/loadShape',[LocaliteController::class,'uploadShapefile'])->name("loadShape");
// Route::post('/loadStructureXlsx',[StructureController::class,'import'])->name("loadStructureXlsx");

// //Route situation
// Route::resource('situation',SituationController::class);
// Route::get('situation/{rub}/{srub}', [SituationController::class, 'index']);
// Route::get('situation/create/{rub}/{srub}', [SituationController::class, 'create']);
// Route::get('situation/{id}/edit/{rub}/{srub}', [SituationController::class, 'edit']);

// //Route offre
// Route::resource('offre',OffreController::class);
// Route::get('offre/{rub}/{srub}', [OffreController::class, 'index']);
// Route::get('offre/create/{rub}/{srub}', [OffreController::class, 'create']);
// Route::get('offre/{id}/edit/{rub}/{srub}', [OffreController::class, 'edit']);

// //CARTE
// //Seuil
// Route::resource('carte',CarteController::class);
// Route::get('carte/{rub}/{srub}', [CarteController::class, 'index']);
// Route::get('carte/create/{rub}/{srub}', [CarteController::class, 'create']);
// Route::get('carte/{id}/edit/{rub}/{srub}', [CarteController::class, 'edit']);
// Route::post('/getFiltreleaflet', [CarteController::class, 'getFiltreleaflet'])->name('getFiltreleaflet');
// Route::get('/geojson/structures', [CarteController::class, 'structuresGeojson']);
// Route::get('/geojson/regions', [CarteController::class, 'regionsGeojson']);
// Route::get('/geojson/province', [CarteController::class, 'provincesGeojson']);
// Route::get('/geojson/commune', [CarteController::class, 'communeGeojson']);
// Route::get('/geojson/village', [CarteController::class, 'villageGeojson']);
// Route::get('/geojson/centroids', [CarteController::class, 'centroidsGeojson']);
// Route::get('/structures-geojson', [CarteController::class, 'structuresGeojson']);
// Route::post('/getLocaliteFils', [CarteController::class, 'getLocaliteFils'])->name('getLocaliteFils');

// //CARTE SANS AUTHENTIFICATION
// Route::post('/getFiltreleafletExplorer', [ExplorerCarteController::class, 'getFiltreleaflet'])->name('getFiltreleafletExplorer');
// Route::get('/geojson/structuresExplorer', [ExplorerCarteController::class, 'structuresGeojson']);
// Route::get('/geojson/regionsExplorer', [ExplorerCarteController::class, 'regionsGeojson']);
// Route::get('/geojson/provinceExplorer', [ExplorerCarteController::class, 'provincesGeojson']);
// Route::get('/geojson/communeExplorer', [ExplorerCarteController::class, 'communeGeojson']);
// Route::get('/geojson/villageExplorer', [ExplorerCarteController::class, 'villageGeojson']);
// Route::get('/geojson/centroidsExplorer', [ExplorerCarteController::class, 'centroidsGeojson']);
// Route::get('/structures-geojsonExplorer', [ExplorerCarteController::class, 'structuresGeojson']);
// Route::post('/getLocaliteFilsExplorer', [ExplorerCarteController::class, 'getLocaliteFils'])->name('getLocaliteFilsExplorer');





// //Ajax
Route::get('getFournisseurById/{id}', [AjaxController::class, 'getFournisseurById']);
Route::get('getMagasinById/{id}', [AjaxController::class, 'getMagasinById']);
Route::get('/getArticle/{data}', [AjaxController::class, 'getArticle']);
Route::get('getLoaderStockById/{id}', [AjaxController::class, 'getLoaderStockById']);


// Route::get('getLocaliteFils/{id}',[AjaxController::class,'getLocalitesFils']);
// Route::get('getStructure/{id}',[AjaxController::class,'getStructure']);
// Route::get('saisirDonneeIndicateur/{structure}/{thematique}/{annee}',[AjaxController::class,'getDonneeBaseSaisieStructure']);
// Route::get('donneeIndicateurSaisie/{structure}/{thematique}/{annee}',[AjaxController::class,'getDonneeSaisie']);


// Route::get('getLocalitesByParent/{id}', [AjaxController::class, 'getLocalitesByParent']);
// Route::get('getLocaliteByType/{id}', [AjaxController::class, 'getLocaliteByType']);
// Route::get('getDonneeBaseSaisie/{idLoc}/{thematique}/{annee}', [AjaxController::class, 'getDonneeBaseSaisie']);

// //Backups
// Route::resource('sauvegarde', SauvegardeController::class);
// Route::get('sauvegarde/{rub}/{srub}', [SauvegardeController::class, 'index']);
// Route::get('sauvegarde/create/{rub}/{srub}', [SauvegardeController::class, 'create']);

// //restaure
// Route::resource('restauration', RestaurationController::class);
// Route::get('restauration/{rub}/{srub}', [RestaurationController::class, 'index']);
// Route::get('restauration/create/{rub}/{srub}', [RestaurationController::class, 'create']);

// //Cycle
// Route::resource('cycle', CycleController::class);
// Route::get('cycle/{rub}/{srub}', [CycleController::class, 'index']);
// Route::get('cycle/create/{rub}/{srub}', [CycleController::class, 'create']);
// Route::get('cycle/{id}/edit/{rub}/{srub}', [CycleController::class, 'edit']);

// //StructureCycle
// Route::resource('structureCycle', StructureCycleController::class);
// Route::get('structureCycle/{rub}/{srub}', [StructureCycleController::class, 'index']);
// Route::get('structureCycle/create/{rub}/{srub}', [StructureCycleController::class, 'create']);
// Route::get('structureCycle/{id}/edit/{rub}/{srub}', [StructureCycleController::class, 'edit']);

// //Les valeurs des indicateurs des structures
// Route::resource('saisieValeurStructure', SaisieValeurStructureController::class);
// Route::get('saisieValeurStructure/{rub}/{srub}', [SaisieValeurStructureController::class, 'index']);
// Route::get('saisieValeurStructure/create/{rub}/{srub}', [SaisieValeurStructureController::class, 'create']);
// Route::get('saisieValeurStructure/{id}/edit/{rub}/{srub}', [SaisieValeurStructureController::class, 'edit']);
// Route::post('/saisie/valeur/indicateur/structure', [SaisieValeurStructureController::class, 'enregitrerIndividuel']);
// Route::post('/update/valeur/indicateur/structure', [SaisieValeurStructureController::class, 'modifier']);
// Route::post('/importValeurIndicateurStructure',[SaisieValeurStructureController::class,'import']);

// //SaisieDonneesLocalite
// Route::resource('saisieValeurIndicateurLocalite', ValeurIndicateurLocaliteController::class);
// Route::get('saisieValeurIndicateurLocalite/{rub}/{srub}', [ValeurIndicateurLocaliteController::class, 'index']);
// Route::get('saisieValeurIndicateurLocalite/create/{rub}/{srub}', [ValeurIndicateurLocaliteController::class, 'create']);
// Route::get('saisieValeurIndicateurLocalite/{id}/edit/{rub}/{srub}', [ValeurIndicateurLocaliteController::class, 'edit']);

// //enregistrer individuelle
// Route::post('saisieValeurIndicateurLocaliteIndivuelle', [ValeurIndicateurLocaliteController::class, 'enregistrerIndividuel'])->name('enregistrerIndividuel');

// //enregistrer Tout
// Route::post('saisieValeurIndicateurLocaliteTout', [ValeurIndicateurLocaliteController::class, 'toutEnregistrer'])->name('toutEnregistrer');

// //Export 
// Route::get('/export_valeurs_indicateur_localite/{localite_id}/{thematique_id}/{annee}', function ($localite_id, $datas_thematique, $anneeCourante) {
//     $date = new DateTime('UTC');
//     $dat = $date->format('d-m-Y-H-i-s');
//     return Excel::download(new LocaliteExport($localite_id, $datas_thematique, $anneeCourante), 'canevas_import_valeur_indicateur_localite_'.$dat.'.xlsx');
// });

// //Import
// Route::post('/importValeurIndicateurLocalite',[ValeurIndicateurLocaliteController::class,'import']);


 
// Route type de fournisseur
Route::resource('typeFournisseurs', TypeFournisseurController::class);
Route::get('typeFournisseurs/{rub}/{srub}', [TypeFournisseurController::class, 'index']);
Route::get('typeFournisseurs/create/{rub}/{srub}', [TypeFournisseurController::class, 'create']);
Route::get('typeFournisseurs/{id}/edit/{rub}/{srub}', [TypeFournisseurController::class, 'edit']);

//Route type article
Route::resource('typeArticles', TypeArticleController::class);
Route::get('typeArticles/{rub}/{srub}', [TypeArticleController::class, 'index']);
Route::get('typeArticles/create/{rub}/{srub}', [TypeArticleController::class, 'create']);
Route::get('typeArticles/{id}/edit/{rub}/{srub}', [TypeArticleController::class, 'edit']);

//Route mode achat
Route::resource('modeAchats', ModeAchatController::class);
Route::get('modeAchats/{rub}/{srub}', [ModeAchatController::class, 'index']);
Route::get('modeAchats/create/{rub}/{srub}', [ModeAchatController::class, 'create']);
Route::get('modeAchats/{id}/edit/{rub}/{srub}', [ModeAchatController::class, 'edit']);

//Route type client
Route::resource('typeClients', TypeClientController::class);
Route::get('typeClients/{rub}/{srub}', [TypeClientController::class, 'index']);
Route::get('typeClients/create/{rub}/{srub}', [TypeClientController::class, 'create']);
Route::get('typeClients/{id}/edit/{rub}/{srub}', [TypeClientController::class, 'edit']);

//Route mode reglement
Route::resource('modeReglements', ModeReglementController::class);
Route::get('modeReglements/{rub}/{srub}', [ModeReglementController::class, 'index']);
Route::get('modeReglements/create/{rub}/{srub}', [ModeReglementController::class, 'create']);
Route::get('modeReglements/{id}/edit/{rub}/{srub}', [ModeReglementController::class, 'edit']);

//Route taxe
Route::resource('taxes', TaxeController::class);
Route::get('taxes/{rub}/{srub}', [TaxeController::class, 'index']);
Route::get('taxes/create/{rub}/{srub}', [TaxeController::class, 'create']);
Route::get('taxes/{id}/edit/{rub}/{srub}', [TaxeController::class, 'edit']);

//Route remise
Route::resource('remises', RemiseController::class);
Route::get('remises/{rub}/{srub}', [RemiseController::class, 'index']);
Route::get('remises/create/{rub}/{srub}', [RemiseController::class, 'create']);
Route::get('remises/{id}/edit/{rub}/{srub}', [RemiseController::class, 'edit']);

//Route delai reglement
Route::resource('delaiReglements', DelaiReglementController::class);
Route::get('delaiReglements/{rub}/{srub}', [DelaiReglementController::class, 'index']);
Route::get('delaiReglements/create/{rub}/{srub}', [DelaiReglementController::class, 'create']);
Route::get('delaiReglements/{id}/edit/{rub}/{srub}', [DelaiReglementController::class, 'edit']);

//Route magasin
Route::resource('magasins', MagasinController::class);
Route::get('magasins/{rub}/{srub}', [MagasinController::class, 'index']);
Route::get('magasins/create/{rub}/{srub}', [MagasinController::class, 'create']);
Route::get('magasins/{id}/edit/{rub}/{srub}', [MagasinController::class, 'edit']);

//Route statut
Route::resource('statuts', StatutController::class);
Route::get('statuts/{rub}/{srub}', [StatutController::class, 'index']);
Route::get('statuts/create/{rub}/{srub}', [StatutController::class, 'create']);
Route::get('statuts/{id}/edit/{rub}/{srub}', [StatutController::class, 'edit']);

//Route type vente
Route::resource('typeVentes', TypeVenteController::class);
Route::get('typeVentes/{rub}/{srub}', [TypeVenteController::class, 'index']);
Route::get('typeVentes/create/{rub}/{srub}', [TypeVenteController::class, 'create']);
Route::get('typeVentes/{id}/edit/{rub}/{srub}', [TypeVenteController::class, 'edit']);

//Route point vente
Route::resource('pointVentes', PointVenteController::class);
Route::get('pointVentes/{rub}/{srub}', [PointVenteController::class, 'index']);
Route::get('pointVentes/create/{rub}/{srub}', [PointVenteController::class, 'create']);
Route::get('pointVentes/{id}/edit/{rub}/{srub}', [PointVenteController::class, 'edit']);

//Route fournisseur
Route::resource('fournisseurs', FournisseurController::class);
Route::get('fournisseurs/{rub}/{srub}', [FournisseurController::class, 'index']);
Route::get('fournisseurs/create/{rub}/{srub}', [FournisseurController::class, 'create']);
Route::get('fournisseurs/{id}/edit/{rub}/{srub}', [FournisseurController::class, 'edit']);

//Route article
Route::resource('articles', ArticleController::class);
Route::get('articles/{rub}/{srub}', [ArticleController::class, 'index']);
Route::get('articles/create/{rub}/{srub}', [ArticleController::class, 'create']);
Route::get('articles/{id}/edit/{rub}/{srub}', [ArticleController::class, 'edit']);

//Route ravitaillement
Route::resource('ravitaillements', RavitaillementController::class);
Route::get('ravitaillements/{rub}/{srub}', [RavitaillementController::class, 'index']);
Route::get('ravitaillements/create/{rub}/{srub}', [RavitaillementController::class, 'create']);
Route::get('ravitaillements/{id}/edit/{rub}/{srub}', [RavitaillementController::class, 'edit']);

//Route stock
Route::resource('stocks', StockController::class);
Route::get('stocks/{rub}/{srub}', [StockController::class, 'index']);

//Route prix
Route::resource('prixes', PrixController::class);
Route::get('prixes/{rub}/{srub}', [PrixController::class, 'index']);
//Route::get('prixes/create/{rub}/{srub}', [PrixController::class, 'create']);
Route::get('prixes/{id}/edit/{rub}/{srub}', [PrixController::class, 'edit']);

//Route client
Route::resource('clients', ClientController::class);
Route::get('clients/{rub}/{srub}', [ClientController::class, 'index']);
Route::get('clients/create/{rub}/{srub}', [ClientController::class, 'create']);
Route::get('clients/{id}/edit/{rub}/{srub}', [ClientController::class, 'edit']);
Route::resource('vente_comptant_credits', \App\Http\Controllers\VenteComptantCreditController::class);
Route::resource('recettes', \App\Http\Controllers\RecetteController::class);
Route::resource('reglements', \App\Http\Controllers\ReglementController::class);
Route::resource('penalites', \App\Http\Controllers\PenaliteController::class);
Route::resource('ligne_ventes', \App\Http\Controllers\LigneVenteController::class);