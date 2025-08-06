<?php

namespace App\Imports;

use App\Models\Localite;
use App\Models\OffreEnseignement;
use App\Models\Situation;
use App\Models\Statut;
use App\Models\Structure;
//use App\Models\TypeStructure;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StructuresImport implements ToModel, WithHeadingRow
{

    private $rows = 0;
    private $rowsIndex = 0;
    private $rowLost = "";
    
    /**
     * @return array
     */
    /* public function rules(): array
    {
        return [
            'structure_libelle' => 'required|string|max:255',
            'structure_code' => 'required|string|max:255',
            'structure_type' => 'required|exists:type_structure,type_structure_id',
            'structure_statut' => 'required|exists:statut,statut_id',
            'structure_localite' => 'required|exists:localite,localite_id',
        ];
    } */

    /**
     * @return array
     */
    /* public function customValidationMessages()
    {
        return [
            'structure_libelle.required' => 'Le champ "Libellé" est requis.',
            'structure_code.required' => 'Le champ "Code" est requis.',
            // Add other custom messages as needed
        ];
    } */
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       //dd(request('typeStructure_id'));
       $typeStructure_id = request('typeStructure_id');
        $nomStructure = trim($row['nom_structure']);
        if($nomStructure === null || $nomStructure === ''){
            return null;
        }else{
            $structure = new Structure();
            $structure->structureLibelle = $nomStructure;
            $structure->acronymeStructure = $nomStructure;
            $structure->typeStructure_id = $typeStructure_id;//$this->getOrCreateTypeStructure($row)->typeStructure_id;
            $structure->parentStructure_id = ($this->getOrCreateStructure($row['ceb'],$row)!=null)?$this->getOrCreateStructure($row['ceb'],$row)->structure_id:null;
            $structure->statutStructure_id = ($this->getOrCreateStatut($row)!=null)?$this->getOrCreateStatut($row)->statutStructure_id:null;
            $structure->localite_id = ($this->getOrCreateLocalite($row)!=null)?$this->getOrCreateLocalite($row)->localite_id:null;
            $structure->situation_id = ($this->getOrCreateSituation($row)!=null)?$this->getOrCreateSituation($row)->situation_id:null;
            $structure->offreEnseignement_id = ($this->getOrCreateOffre($row)!=null)?$this->getOrCreateOffre($row)->offreEnseignement_id:null;
            $structure->longitude = $row['longitude'];
            $structure->latitude = $row['latitude'];
            $wtk = "POINT({$row['longitude']} {$row['latitude']})";
            $wtk = str_replace(',', '.', $wtk); // Remplace les virgules par des points
            $geom = DB::select("SELECT ST_GeomFromText('$wtk', 4326) AS geom");
            $structure->geom = $geom[0]->geom;
            $structure->save();
            ++$this->rows;
        }
    }

    private function normalize($value)
    {
        return Str::slug(strtolower(trim($value)), ''); // Ex: " Hôpital Général " => "hopitalgeneral"
    }

    private function getOrCreateLocalite($row){

        
        $normalizedInput = $this->normalize($row['village']);
        $libCom=$this->normalize($row['commune']);
        $liProv = $this->normalize($row['province']);

        $province = Localite::where('typeLocalite_id',2)->get()->first(function ($item) use ($liProv) {
            return $this->normalize($item->localiteLibelle) === $liProv;
        });
        //dd($libLoc);
        $commune = Localite::where(['typeLocalite_id'=>3,'parentLocalite_id'=>$province->localite_id])->get()->first(function ($item) use ($libCom) {
            return $this->normalize($item->localiteLibelle) === $libCom;
        });
        if(!$commune){
            $commune = $this->createCommune($row);
        }
        $localite = Localite::where(['typeLocalite_id'=>4,'parentLocalite_id'=>$commune->localite_id])->get()->first(function ($item) use ($normalizedInput) {
            return $this->normalize($item->localiteLibelle) === $normalizedInput;
        });
        //dd($localite);
        if (!$localite) {
            
            $wkt = "POINT({$row['longitude']} {$row['latitude']})";
            $wkt = str_replace(',', '.', $wkt); // Remplace les virgules par des points
            $geom = DB::select("SELECT ST_GeomFromText('$wkt', 4326) AS geom");

            $localite = new Localite();
            $localite->localiteLibelle = trim($row['village']);
            $localite->typeLocalite_id = 4;
            $localite->typeSociologique_id = 2;
            $localite->centroid = $geom[0]->geom;
            $localite->parentLocalite_id = $commune ? $commune->localite_id : null;
            $localite->save();
        }
        return $localite;
    }

    
    private function getOrCreateSituation($row)
    {
        if(trim($row['situation_actuelle']) === null || trim($row['situation_actuelle']) === ''){
            return null;
        }else{
            $normalizedInput = $this->normalize($row['situation_actuelle']);
            $situation = Situation::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->situationLibelle) === $normalizedInput;
            });

            if (!$situation) {
                $situation = new Situation();
                $situation->situationLibelle = trim($row['situation_actuelle']);
                $situation->save();
            }
            return $situation;
        }
        
    }

    private function getOrCreateStatut($row)
    {
        //dd($row['statut']);
        if(trim($row['statut']) === null || trim($row['statut']) === ''){
            return null;
        }else{
            $normalizedInput = $this->normalize($row['statut']);
            $statut = Statut::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->statutStructureLibelle) === $normalizedInput;
            });
            //dd($statut);
            if (!$statut) {
                $statut = new Statut();
                $statut->statutStructureLibelle = trim($row['statut']);
                $statut->save();
            }
            return $statut;
        }
    }

    private function getOrCreateOffre($row)
    {
        if(trim($row['type']) === null || trim($row['type']) === ''){
            return null;
        }else{
            $normalizedInput = $this->normalize($row['type']);
            $offre = OffreEnseignement::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->offreEnseignementLibelle) === $normalizedInput;
            });
            if (!$offre) {
                $offre = new OffreEnseignement();
                $offre->offreEnseignementLibelle = trim($row['type']);
                $offre->save();
            }
            return $offre;
        }
    }

    private function getOrCreateStructure($structureLibelle, $row)
    {
        //$structureLibelle = $row['nom_structure'];
        $normalizedInput = $this->normalize($structureLibelle);
        $structure = Structure::all()->first(function ($item) use ($normalizedInput) {
            return $this->normalize($item->structureLibelle) === $normalizedInput;
        });

        if (!$structure) {
            $structure = new Structure();
            $structure->structureLibelle = trim($structureLibelle);
            $structure->acronymeStructure = trim($structureLibelle);
            $structure->typeStructure_id = 3;
            //$structure->statutStructure_id = null;
            $libLoc = $this->normalize($row['commune']);
            $liProv = $this->normalize($row['province']);
            $province = Localite::where('typeLocalite_id',2)->get()->first(function ($item) use ($liProv) {
                return $this->normalize($item->localiteLibelle) === $liProv;
            });
            //dd($libLoc);
            $localite = Localite::where(['typeLocalite_id'=>3,'parentLocalite_id'=>$province->localite_id])->get()->first(function ($item) use ($libLoc) {
                return $this->normalize($item->localiteLibelle) === $libLoc;
            });
            if(!$localite){
               $localite = $this->createCommune($row);
            }
            $structure->localite_id = $localite->localite_id;
            $structure->save();
        }

        return $structure;
    }


    public function createCommune($row){
        $normalizedInput = $this->normalize($row['province']);
        $province = Localite::where('typeLocalite_id',2)->get()->first(function ($item) use ($normalizedInput) {
            return $this->normalize($item->localiteLibelle) === $normalizedInput;
        });
        $commune = new Localite();
        $commune->localiteLibelle = trim($row['commune']);
        $commune->typeLocalite_id = 3;
        $commune->typeSociologique_id = 1;
        $commune->centroid = null;
        $commune->parentLocalite_id = ($province)? $province->localite_id:null;
        $commune->save();

        return $commune;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getRowLost(): string
    {
        return $this->rowLost;
    }
}
