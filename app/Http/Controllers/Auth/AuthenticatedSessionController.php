<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Indicateur;
use App\Models\Structure;
use App\Models\Thematique;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //dd("somda");
        $request->authenticate();
        $request->session()->regenerate();
        $this->userMenus($request);
        //Caclcul des nombre de indicateurs thematique et user
        $counts = [
        'users' => User::count(),
        //'indicateurs' => Indicateur::count(),
        //'structures' => Structure::count(),
        //'thematiques' => Thematique::count(),
        ];
        //Envoie des donnees dans la variable session couts
        session(['counts' => $counts]);
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function userMenus(Request $request){
        if ($request->hasSession()) {
            $request->session()->put('auth.password_confirmed_at', time());
            $tableau=[];
            $tableauFront=[];
            $menus=DB::table('menus')
                ->select('menus.*')
                ->selectRaw('\'template\' AS template')
                ->join('profilmenus','profilmenus.menu_id','=','menus.menu_id')
                ->where(['profilmenus.profil_id'=>Auth::user()->profil_id,'visible'=>true])
                ->whereIn('interface',[1,3])
                ->orderBy('ordre','ASC')
                ->get();
                foreach($menus as $parent){
                    if($parent->parent_id==NULL){
                        $tableau[$parent->menu_id][0]=$parent;
                    }else{
                        $tableau[$parent->parent_id][1][$parent->menu_id][0]=$parent;
                        $actionMenu=DB::table('actions')
                            ->select('actions.*')
                            ->join('profilmenuactions','profilmenuactions.action_id','=','actions.action_id')
                            ->where(['profilmenuactions.menu_id'=>$parent->menu_id,
                            'profilmenuactions.profil_id'=>Auth::user()->profil_id])
                            ->get();
                        $actions=[];
                        foreach($actionMenu as $action){
                            $actions[] = $action->nomAction;
                        }
                        $tableau[$parent->parent_id][1][$parent->menu_id][1]=$actions;
                    }
                }

            $menusFront=DB::table('menus')
                ->select('menus.*')
                ->selectRaw('\'front\' AS template')
                ->join('profilmenus','profilmenus.menu_id','=','menus.menu_id')
                ->where(['profilmenus.profil_id'=>Auth::user()->profil_id,'visible'=>true])
                ->whereIn('interface',[2,3])
                ->orderBy('ordre','ASC')
                ->get();
                foreach($menusFront as $parent){
                    if($parent->parent_id==NULL){
                        $tableauFront[$parent->menu_id][0]=$parent;
                    }else{
                        $tableauFront[$parent->parent_id][1][$parent->menu_id][0]=$parent;
                        $actionMenu=DB::table('actions')
                            ->select('actions.*')
                            ->join('profilmenuactions','profilmenuactions.action_id','=','actions.action_id')
                            ->where(['profilmenuactions.menu_id'=>$parent->menu_id,
                            'profilmenuactions.profil_id'=>Auth::user()->profil_id])
                            ->get();
                        $actions=[];
                        foreach($actionMenu as $action){
                            $actions[] = $action->nomAction;
                        }
                        $tableauFront[$parent->parent_id][1][$parent->menu_id][1]=$actions;
                    }
                }
            $user=User::find(Auth::user()->id);
            Session::put('menus', $tableau);
            Session::put('menusFront', $tableauFront);
            Session::put('user', $user);
        }
    }
}
