<?php
// utilisateur 
use Illuminate\Support\Facades\Auth;

function username()
{
    return Auth::user()->prenom . " " . Auth::user()->nom;
}
function useremail()
{
    return Auth::user()->email;
}
function userlogin()
{
    return Auth::user()->identifiant;
}
function usertelephone()
{
    return Auth::user()->telephone;
}
function userpassword()
{
    return Auth::user()->password;
}

function profil_id()
{
    return Auth::user()->profil_id;
}

// Menu 

function setMenuOpen($route)
{
    if (request()->route()->getName() === $route) {
        return "menu-open";
    }
    return "";
}

function root()
{
    $root = explode('/', request()->server('REQUEST_URI'))[1];
    return $root;
}

function root1($route = null)
{
    //$root = explode('/',request()->server('REQUEST_URI'))[1];
    return $route;
}

function getTemplate($rb, $srb)
{
    //dd(session('menus')[$rb][1][$srb][0]->template);
    $rub = explode('-', $rb);
    $srub = explode('-', $srb);
    //dd($srub);
    return (array_key_exists(1, $srub) && $srub[1] == 1) ? 'front' : 'template';
    //return session('menus')[$rub][1][$srub][0]->template;
}

function integerToDate($integer)
{
    $date = new DateTime();
    return $date->setTimestamp($integer)->format('d-m-Y');
}


function menuParent($rub,$srub){
    return session('menus')[$rub][0]->nomMenu;
}


