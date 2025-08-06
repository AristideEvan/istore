<?php

namespace App\Http\Controllers;

use App\Models\Client;
use DateTime;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use ZipArchive;

abstract class Controller extends BaseController
{
    public function parametre($rub, $srub)
    {
        return (array_key_exists(1, session('menus')[$rub][1][$srub])) ? session('menus')[$rub][1][$srub][1] : [];
    }
    public function parametre_exists($rub, $srub, $param)
    {
        return (in_array($param, $this->parametre($rub, $srub))) ? true : false;
    }
    public function newFormButton($rub, $srub, $lien)
    {
        $vue = '';
        $route = 'route';
        //dd(session('menus'));
        if (array_key_exists(1, session('menus')[$rub][1][$srub]) && in_array("CREER", session('menus')[$rub][1][$srub][1])) {
            $vue .= '<a href="' . $route($lien) . '/' . $rub . '/' . $srub . '">';
            $vue .= '<input value="Nouveau" type="button" class="btn btn-primary btnEnregistrer" style="float:right">';
            $vue .= '</a>';
        }
        return $vue;
    }
    public function crudheader($rub, $srub)
    {
        $head = '';
        if (array_key_exists(1, session('menus')[$rub][1][$srub])) {
            if (in_array("MODIFIER", session('menus')[$rub][1][$srub][1])) {
                $head .= '<th class="sorting_disabled"></th>';
            }
            if (in_array("SUPPRIMER", session('menus')[$rub][1][$srub][1])) {
                $head .= '<th class="sorting_disabled"></th>';
            }
            if (in_array("DETAILS", session('menus')[$rub][1][$srub][1])) {
                $head .= '<th class="sorting_disabled"></th>';
            }
        }
        return $head;
    }
    public function crudbody($rub, $srub, $route, $lienm, $liens, $id, $liend = null)
    {
        //public function crudbody($rub,$srub,$route,$lienm,$liens,$id,$type=null){
        $body = '';
        if (array_key_exists(1, session('menus')[$rub][1][$srub])) {
            if (array_key_exists(1, session('menus')[$rub][1][$srub])) {
                if (in_array("MODIFIER", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td title="' . __("Modifier") . '" style="text-align: right" class="actionTd">';
                    if ($id != "") {
                         $body .= '<a href=" ' . $route($lienm, $id) . '/' . $rub . '/' . $srub . '" > <i class="fas fa-pencil-alt" style="color: #060" ></i></a>';
                    }
                    //$body .= '<a href=" '.$route($lienm,$id).'/'.$rub.'/'.$srub.'" >  <i class="fas fa-pencil-alt" style="color: #060" ></i></a>';
                    $body .= '</td>';
                }
                if (in_array("SUPPRIMER", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td title="' . __("Supprimer") . '" style="text-align: right" class="actionTd">';
                    //$body .= '<a href="#" id="'.$route($liens,$id).'?type='.$type.'& rub='.$rub.'& srub='.$srub.'"';
                    if ($id != "") {
                        $body .= '<a  href="#" id="' . $route($liens, $id) .'"';
                        $body .= 'onclick="confirmDelete(this.id,function() { location.reload(); });return false;"> <i class="fas fa-trash-alt" style="color: #F00" ></i> </a>';
                    }
                    $body .= '</td>';
                }
                if (in_array("ACTIVER_DESACTIVER", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td style="text-align: right" class="actionTd">';
                    $body .= '<a  href="#" id="' . $route($liens, $id) . '?rub=' . $rub . '& srub=' . $srub . '"';
                    $body .= 'onclick="Activer(this.id);return false;"> <i class="fas fa-trash-alt" style="color: #F00" ></i> </a>';
                    $body .= '</td>';
                }
                if (in_array("DETAILS", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td title="' . __("Details") . '" style="text-align: right" class="actionTd">';
                    if ($id != "") {
                        $body .= '<a href="' . $route($liens, $id) . '/show/' . $rub . '/' . $srub . '" > <i class="fas fa-eye" style="color: #060" ></i></a>'; 
                        //$body .= '<a href="' . $route($liens, $id) . '/show/' . $rub . '/' . $srub . '" data-toggle="modal" data-target="#modalSeuil_'.$id.'" > <i class="fas fa-eye" style="color: #060" ></i></a>';
                    }
                    $body .= '</td>';
                }
            }
        }
        return $body;
    }


    public function crudbodyAlt($rub, $srub, $route, $lienm, $liens, $id)
    {
        $body = '';
        if (array_key_exists(1, session('menus')[$rub][1][$srub])) {
            if (array_key_exists(1, session('menus')[$rub][1][$srub])) {
                if (in_array("MODIFIER", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td style="text-align: right" class="actionTd">';
                    $body .= '<a  href="#" id="' . $route($lienm, $id) . '/' . $rub . '/' . $srub . '"';
                    $body .= 'onclick="getModification(this.id,\'zoneSaisie\');"> <i class="fas fa-pencil-alt" style="color: #060" ></i> </a>';
                    $body .= '</td>';
                }
                if (in_array("SUPPRIMER", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td style="text-align: right" class="actionTd">';
                    $body .= '<a  href="#" id="' . $route($liens, $id) . '?rub=' . $rub . '& srub=' . $srub . '"';
                    $body .= 'onclick="confirmDelete(this.id,function() { location.reload(); });"> <i class="fas fa-trash-alt" style="color: #F00" ></i> </a>';
                    $body .= '</td>';
                }

                if (in_array("ACTIVER_DESACTIVER", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td style="text-align: right" class="actionTd">';
                    $body .= '<a  href="#" id="' . $route($liens, $id) . '?rub=' . $rub . '& srub=' . $srub . '"';
                    $body .= 'onclick="Activer(this.id);"> <i class="fas fa-trash-alt" style="color: #F00" ></i> </a>';
                    $body .= '</td>';
                }
            }
        }
        return $body;
    }


    public function newFormButtonDropdown($rub, $srub, $lien)
    {
        $vue = '';
        $route = 'route';
        if (array_key_exists(1, session('menus')[$rub][1][$srub]) && in_array("CREER", session('menus')[$rub][1][$srub][1])) {

            $vue .= '<div class="dropdown pull-right">';
            $vue .=    '<button class="btn btn-primary btnEnregistrer dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $vue .=        'Ajouter';
            $vue .=    '</button>';
            $vue .=    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            $vue .=        '<div class="dropdown-divider"></div>';
            $vue .=            '<a class="dropdown-item" href="' . $route($lien) . '/reg/' . $rub . '/' . $srub . '">Région</a>';
            $vue .=        '<div class="dropdown-divider"></div>';
            $vue .=            '<a class="dropdown-item" href="' . $route($lien) . '/prov/' . $rub . '/' . $srub . '">Province</a>';
            $vue .=        '<div class="dropdown-divider"></div>';
            $vue .=            '<a class="dropdown-item" href="' . $route($lien) . '/com/' . $rub . '/' . $srub . '">Commune</a>';
            $vue .=        '<div class="dropdown-divider"></div>';
            $vue .=            '<a class="dropdown-item" href="' . $route($lien) . '/vil/' . $rub . '/' . $srub . '">Ville/village</a>';
            $vue .=        '<div class="dropdown-divider"></div>';
            $vue .=    '</div>';
            $vue .= '</div>';
        }
        return $vue;
    }


    public function enleveAccent($chaine)
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $chaine = str_replace($search, $replace, $chaine);
        return trim($chaine);
    }

    public function creerUneChaineDonneDeBase($chaine)
    {
        $text = $this->enleveAccent($chaine);
        $chaine = preg_replace("#[^A-Z0-9]#i", "", $text);
        return $chaine;
    }

    public function slug($chaine)
    {
        $text = $this->enleveAccent($chaine);
        $chaine = preg_replace("#[^A-Z0-9]#i", "", $text);
        return strtolower($chaine);
    }

    public function verifierSupp($table, $element_id, $valeur_id)
    {
        $flag = 0;
        $verification = DB::select('select * from ' . $table . ' where ' . $element_id . '= ? AND deleted_at IS NULL', [$valeur_id]);
        if (count($verification) > 0) {
            $flag = 1;
        }
        return $flag;
    }

    public function dateToInteger($date)
    {
        $date = ($date instanceof \DateTime) ? $date : new \DateTime($date);
        return $date->getTimestamp();
    }

    public function integerToDate($integer)
    {
        $date = new DateTime();
        return $date->setTimestamp($integer)->format('d-m-Y');
    }

    public function dateToFormat($date)
    {
        $date = ($date instanceof \DateTime) ? $date : new \DateTime($date);
        $integer =  $date->getTimestamp();
        return $date->setTimestamp($integer)->format('d-m-Y');
    }


    public function genererNom(
        $length = 10,
        $bChLower = true,
        $bChUpper = true,
        $bChNumber = true,
        $bChEscape = false,
        $bChSimpleSpecial = false,
        $bChExtSpecial = false,
        $bChHigh = false
    ) {
        $chars = array(
            'escape' => array('min' => 0, 'max' => 31),
            'simpleSpecial' => array('min' => 32, 'max' => 47),
            'number' => array('min' => 48, 'max' => 57),
            'extSpecial1' => array('min' => 58, 'max' => 64),
            'upper' => array('min' => 65, 'max' => 90),
            'extSpecial2' => array('min' => 91, 'max' => 96),
            'lower' => array('min' => 97, 'max' => 122),
            'extSpecial3' => array('min' => 123, 'max' => 126),
            'high' => array('min' => 127, 'max' => 255),
        );

        $charsForThisPassword = array();
        if ($bChLower) $charsForThisPassword[] = $chars['lower'];
        if ($bChUpper) $charsForThisPassword[] = $chars['upper'];
        if ($bChEscape) $charsForThisPassword[] = $chars['escape'];
        if ($bChSimpleSpecial) $charsForThisPassword[] = $chars['simpleSpecial'];
        if ($bChHigh) $charsForThisPassword[] = $chars['high'];
        if ($bChNumber) $charsForThisPassword[] = $chars['number'];
        if ($bChExtSpecial) {
            $charsForThisPassword[] = $chars['extSpecial1'];
            $charsForThisPassword[] = $chars['extSpecial2'];
            $charsForThisPassword[] = $chars['extSpecial3'];
        }

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $alt = mt_rand(0, count($charsForThisPassword) - 1);
            $password .= chr(mt_rand($charsForThisPassword[$alt]['min'], $charsForThisPassword[$alt]['max']));
        }
        return $password;
    }

    public function suppFichier($nomFichier)
    {

        if (PHP_OS == "Linux") {
            $cheminRest = storage_path() . '/app/public/' . $nomFichier;
        } else {
            $nom = str_replace("/", "\\", $nomFichier);
            $cheminRest = storage_path() . '\\app\public\\' . $nom;
        }

        if (file_exists($cheminRest)) {
            unlink($cheminRest);
        }
    }

    public function compresserDossier($racine)
    {

        $this->suppFichier($racine . '.zip');

        if (PHP_OS == "Linux") {
            $cheminDossier = storage_path() . '/app/public/' . $racine;
        } else {
            $racineRenommer = str_replace("/", "\\", $racine);
            $cheminDossier = storage_path() . '\\app\public\\' . $racineRenommer;
        }
        $pathdir = $cheminDossier . '/';
        $racinezip = $cheminDossier . ".zip";
        $zip = new ZipArchive;
        if ($zip->open($racinezip, ZipArchive::CREATE) === TRUE) {
            $dir = opendir($pathdir);
            while ($fichier = readdir($dir)) {
                if (is_file($pathdir . $fichier)) {
                    $zip->addFile($pathdir . $fichier, $fichier);
                }
            }
            $zip->close();
        }
    }

    public function convertUtf8($string)
    {
        return mb_convert_encoding($string, "UTF-8");
    }

    /**
     * fonction pour générer la coordonnées géographique
     */
    public static function geomConvert($long, $lat)
    {
        $convert = DB::select("SELECT ST_GeomFromText('POINT($long $lat)',4326) as geom;");
        return $convert[0]->geom;
    }

    public function crudbodyDropDown($rub, $srub, $route, $lienm, $liens, $id)
    {
        $body = '';
        if (array_key_exists(1, session('menus')[$rub][1][$srub])) {
            if (array_key_exists(1, session('menus')[$rub][1][$srub])) {
                if (in_array("Modifier", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td class="dropdown">';
                    $body .=    '<i id="btnModif" title="Modifier" style="cursor:pointer" class="dropdown-toggle fa fa-pencil-square-o styleedit" data-toggle="dropdown"></i>';
                    $body .=    '<ul class="dropdown-menu">';
                    $body .=        '<li><hr class="dropdown-divider"></hr></li> ';
                    $body .=        '<li><a class="dropdown-item" href="' . $route($lienm, $id) . '/blocGen/' . $rub . '/' . $srub . '">Infos générales</a></li>';
                    $body .=        '<li><hr class="dropdown-divider"></hr></li> ';
                    $body .=        '<li><a class="dropdown-item" href="' . $route($lienm, $id) . '/blocLoc/' . $rub . '/' . $srub . '">Localités</a></li>';
                    $body .=        '<li><hr class="dropdown-divider"></hr></li> ';
                    $body .=        '<li><a class="dropdown-item" href="' . $route($lienm, $id) . '/blocInv/' . $rub . '/' . $srub . '">Invitations</a></li>';
                    $body .=        '<li><hr class="dropdown-divider"></hr></li> ';
                    //$body .=        '<li><a class="dropdown-item" href="'.$route($lienm,$id).'/vil/'.$rub.'/'.$srub.'">Ville/village</a></li>';
                    //$body .=        '<li><hr class="dropdown-divider"></hr></li> ';
                    $body .=    '</ul>';
                    $body .= '</td>';
                }
                if (in_array("Supprimer", session('menus')[$rub][1][$srub][1])) {
                    $body .= '<td style="text-align: right">';
                    $body .= '<a  href="#" title="Supprimer" id="' . $route($liens, $id) . '?rub=' . $rub . '& srub=' . $srub . '"';
                    $body .= 'onclick="Supprimer(this.id,\'\');return false;"> <i class="fa fa-trash styledelete" ></i> </a>';
                    $body .= '</td>';
                }
            }
        }
        return $body;
    }

    protected function saveImages($request, $model, $field = 'images', $folder = 'images')
    {
        if ($request->hasFile($field)) {
            foreach ($request->file($field) as $image) {
                $path = $image->store($folder, 'public');
                $filename = $this->sanitizeFilename($image->getClientOriginalName());
                $model->images()->create(
                    [
                        'path' => $path,
                        'nom' => $filename
                    ]
                );
            }
        }
    }

    public function importExportButton($rub,$srub,$lien,$idModal){
        $vue = '';
        //$route = 'route';
        if(array_key_exists(1,session('menus')[$rub][1][$srub]) && in_array("IMPORT_EXPORT",session('menus')[$rub][1][$srub][1])){
            $vue .= '<div class="dropdown pull-right" style="margin-left:10px">';
            $vue .= '    <button class="btn btn-primary btnEnregistrer dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $vue .= '        Données';
            $vue .= '    </button>';
            $vue .= '    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            $vue .= '        <div class="dropdown-divider"></div>';
            $vue .= '            <a class="dropdown-item" id="/'.$lien.'" href="#" onclick="popUp(this.id,\''.$idModal.'\');">Importer</a>';
            $vue .= '        <div class="dropdown-divider"></div>';
            $vue .= '            <a class="dropdown-item" href="#">Exporter</a>';
            $vue .= '        <div class="dropdown-divider"></div>';
            $vue .= '    </div>';
            $vue .= '</div>';
        }
        return $vue;
    }

    public function scanDirectoryRecursively($dir){
        $result = [];
        foreach (scandir($dir) as $file) {
            if ($file === '.' ||$file === '..') continue;
            $path =$dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $result = array_merge($result, $this->scanDirectoryRecursively($path));
            }else{
                $result[] = $path;
            }
        }
        return $result;
    }

    public function getDossier($files){
        foreach ($files as $file){
            if (!$file->isDir() && str_ends_with($file->getFilename(), '.shp')){
                $shpPath = $file->getPath(); // Chemin du dossier contenant le fichier .shp
            break;
            }
        }
        return $shpPath;
    }

    public function genererNumeroCompte()
        {
          $lastNumeroCompte= Client::whereNotNull('numeroCompte')
                        ->orderBy('numeroCompte','DESC')
                        ->value('numeroCompte');
          $annee= date('y');
          if ($lastNumeroCompte) {
              $lastSequence = (int)substr($lastNumeroCompte, 0, 4);
              $newNumero = $lastSequence + 1;
          }else{
            $newNumero=1;
          }
           return str_pad($newNumero, 4, '0', STR_PAD_LEFT) . $annee;            
        }
 

}
