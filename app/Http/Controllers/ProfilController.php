<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Profil;
use App\Models\Profilmenu;
use App\Models\Profilmenuaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    private $msgerror='Impossible de supprimer cet élément!';
    private $operation='Opération éffectuée avec succès';
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     */
    public function index($rub,$srub)
    {
        $datas = Profil::orderBy('created_at','DESC')->get();
        return view('profil.index')->with(['datas'=>$datas,
                                                        'controler'=>$this,
                                                        "rub"=>$rub,
                                                        "srub"=>$srub]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub,$srub)
    {
        $tableau=[];
        $parentMenus=Menu::orderby('menu_id','ASC')->get();
        foreach($parentMenus as $parent){
            if($parent->parent_id==NULL){
                $tableau[$parent->menu_id][0]=$parent;
            }else{
                $tableau[$parent->parent_id][1][$parent->menu_id][0]=$parent;
                $actionMenu=DB::table('actions')
                    ->select('actions.*')
                    ->join('actionmenus','actionmenus.action_id','=','actions.action_id')
                    ->where('actionmenus.menu_id',$parent->menu_id)
                    ->get();
                $tableau[$parent->parent_id][1][$parent->menu_id][1]=$actionMenu;
            }
        }
        //dd($tableau);
        return view('profil.create')->with(['menus'=>$tableau,"rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profil=new Profil();
        $profil->nomProfil=$request->input('profil');
        $profil->save();
        $profilId=$profil->profil_id;

        $tableau=$request->input('menu');
        if(!empty($tableau)){
            foreach($tableau as $tab){
                $userMenu=new Profilmenu();
                $userMenu->menu_id=$tab;
                $userMenu->profil_id=$profilId;
                $userMenu->save();
                $actions=$request->input($tab);
                if(!empty($actions)){
                    foreach($actions as $actionid){
                        $actionUserMenu = new Profilmenuaction();
                        $actionUserMenu->profil_id= $profilId;
                        $actionUserMenu->action_id= $actionid;
                        $actionUserMenu->menu_id= $tab;
                        $actionUserMenu->save();
                    }
                }
            }
        }

        return redirect('profil/'.$request['rub'].'/'.$request['srub'])->with(['success'=>$this->operation]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$rub = null, $srub=null)
    {

        $tableauMenuComp=[];
        $tableauMenusProfil=[];
        $profil = Profil::find($id);

        $parentMenus=Menu::orderby('parent_id','DESC')->get();
        foreach($parentMenus as $parent){
            if($parent->parent_id==NULL){
                $tableauMenuComp[$parent->menu_id][0]=$parent;
                $tableauMenuComp[$parent->menu_id][1]=[];
            }else{
                $tableauMenuComp[$parent->parent_id][1][$parent->menu_id][0]=$parent;
                $actionMenu=DB::table('actions')
                    ->select('actions.*')
                    ->join('actionmenus','actionmenus.action_id','=','actions.action_id')
                    ->where('actionmenus.menu_id',$parent->menu_id)
                    ->get();
                $tableauMenuComp[$parent->parent_id][1][$parent->menu_id][1]=$actionMenu;
            }
        }

        $profilUsersParent=DB::table('menus')
            ->select('menus.*')
            ->join('profilmenus','profilmenus.menu_id','=','menus.menu_id')
            ->where('profilmenus.profil_id',$id)
            ->where('menus.parent_id', NULL)
            ->get();


        $profilUsers=DB::table('menus')
        ->select('menus.*')
        ->join('profilmenus','profilmenus.menu_id','=','menus.menu_id')
        ->where('profilmenus.profil_id',$id)
        //->where('menus.parent_id','<>', NULL)
        ->get();

            foreach($profilUsers as $parent){
                if($parent->parent_id==NULL){
                    $tableauMenusProfil[$parent->menu_id][0]=$parent;
                    $tableauMenusProfil[$parent->menu_id][1]=[];
                }else{
                    if(!array_key_exists($parent->parent_id,$tableauMenusProfil)){
                        $paren = Menu::find($parent->parent_id);
                        $tableauMenusProfil[$paren->menu_id][0]=$paren;
                    }
                    $tableauMenusProfil[$parent->parent_id][1][$parent->menu_id][0]=$parent;
                    $actionMenu=DB::table('actions')
                        ->select('actions.*')
                        ->join('profilmenuactions','profilmenuactions.action_id','=','actions.action_id')
                        ->where(['profilmenuactions.menu_id'=>$parent->menu_id,
                        'profilmenuactions.profil_id'=>$id])
                        ->get();
                    $actions=[];
                    foreach($actionMenu as $action){
                        $actions[] = $action->action_id;
                    }
                    $tableauMenusProfil[$parent->parent_id][1][$parent->menu_id][1]=$actions;
                }


            }

           //dd($tableauMenusProfil);
        return view('profil.edit')->with(['profil'=>$profil,'menusUser'=>$tableauMenusProfil,'menusComplet'=>$tableauMenuComp,"rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profil= Profil::find($id);
        $profil->nomProfil=$request->input('profil');
        $profil->save();
        $userId=$id;

        $tableau=$request->input('menu');
        DB::delete('delete from profilmenuactions where profil_id=?',[$userId]);
        DB::delete('delete from profilmenus where profil_id=?',[$userId]);

        if(!empty($tableau)){
            foreach($tableau as $tab){
                $userMenu=new Profilmenu();
                $userMenu->menu_id=$tab;
                $userMenu->profil_id=$userId;
                $userMenu->save();
                $actions=$request->input($tab);
                if(!empty($actions)){
                    foreach($actions as $actionid){
                        $actionUserMenu = new Profilmenuaction();
                        $actionUserMenu->profil_id= $userId;
                        $actionUserMenu->action_id= $actionid;
                        $actionUserMenu->menu_id= $tab;
                        $actionUserMenu->save();
                    }
                }
            }
        }
        return redirect('profil/'.$request['rub'].'/'.$request['srub'])->with(['success'=>$this->operation]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profil=Profil::find($id);
        DB::delete('delete from profilmenuactions where profil_id=?',[$id]);
        DB::delete('delete from profilmenus where profil_id=?',[$id]);
        $profil->delete();
        return redirect()->back()->with(['success'=>$this->operation]);
    }
}
