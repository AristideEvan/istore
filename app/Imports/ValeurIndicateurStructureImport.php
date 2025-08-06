<?php
namespace App\Imports;

use App\Models\Structure;
use App\Models\Indicateur;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ValeurIndicateurStructure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ValeurIndicateurStructureImport implements ToModel,WithHeadingRow{

    private $rows = 0;
    
    public function model(array $row)
    {
       
        if($row['structure']!='' && $row['indicateur']!='' && $row['annee']!='' && $row['valeur']!=''){
            $donneedebase = new ValeurIndicateurStructure();
            
            $donneedebase->annee=$row['annee'];
            $donneedebase->valeur=$row['valeur'];
            $donneedebase->structure_id=($this->getStructure($row['structure'],$row)!=null)?$this->getStructure($row['structure'],$row)->structure_id:null;
            $donneedebase->indicateur_id=($this->getIndicateur($row['indicateur'],$row)!=null)?$this->getIndicateur($row['indicateur'],$row)->indicateur_id:null;
            $donneedebase->save();
            ++$this->rows;
        }else{
            return null;
        }
    }

    private function normalize($value)
    {
        return Str::slug(strtolower(trim($value)), ''); // Ex: " Hôpital Général " => "hopitalgeneral"
    }

    private function getStructure($row)
    {
        if(trim($row) === null || trim($row) === ''){
            return null;
        }else{
            $normalizedInput = $this->normalize($row);
            $structure = Structure::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->structureLibelle) === $normalizedInput;
            });

            return $structure;
        }
        
    }

    private function getIndicateur($row)
    {
        if(trim($row) === null || trim($row) === ''){
            return null;
        }else{
            $normalizedInput = $this->normalize($row);
            $indicateur = Indicateur::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->indicateurLibelle) === $normalizedInput;
            });

            return $indicateur;
        }
        
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}