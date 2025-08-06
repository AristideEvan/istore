<?php

namespace App\Imports;

use App\Models\Indicateur;
use App\Models\Localite;
use App\Models\TypeLocalite;
use App\Models\ValeurIndicateurLocalite;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;


ini_set('memory_limit', '1024M'); //augmenter de manière temporaire la memoire pour permet l'exécution de l'import

class LocaliteImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $rows = 0;
    
    public function model(array $row)
        {
            $libelleLocalite = trim($row['localite'] ?? '');

            if ($libelleLocalite === '') {
                return null;
            }

            $localite = $this->getLocalite($row);
            $indicateur = $this->getIndicateur($row);
            $annee = $this->getAnnee($row);
            $valeur = $this->getValue($row);

            if (!$localite || !$indicateur || $annee === null || $valeur === null) {
                Log::warning("Ligne ignorée : ", $row);
                return null;
            }

            ++$this->rows;
            $record = new ValeurIndicateurLocalite();
            $record->localite_id = $localite->localite_id;
            $record->indicateur_id = $indicateur->indicateur_id;
            $record->annee = $annee;
            $record->valeur = $valeur;
            $record->save();
        }


    ///Debut des fonctions
    private function getTypeLocalite($row)
    {
        if(trim($row['localite']) === null || trim($row['localite']) === ''){
            return null;
        }else{
            $normalizedInput = $this->normalize($row['localite']);
            $typeLocalite = TypeLocalite::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->typeLocaliteLibelle) === $normalizedInput;
            });
            return $typeLocalite;
        }
        
    }

    private function getLocalite($row)
        {
            $normalizedInput = $this->normalize($row['localite']);

            $localite = Localite::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->localiteLibelle) === $normalizedInput;
            });

            if (!$localite) {
                Log::warning("Localité non trouvée pour : " . $row['localite']);
            }

            return $localite;
    }


       ///indicateur
        private function getIndicateur($row){
        
            if (!isset($row['indicateur']) || trim($row['indicateur']) === '') {
                return null;
            }
            $normalizedInput = $this->normalize($row['indicateur']);
            $indicateur = Indicateur::all()->first(function ($item) use ($normalizedInput) {
                return $this->normalize($item->indicateurLibelle) === $normalizedInput;
            });

            return $indicateur;
        }
        
        ///annee
        private function getAnnee($row){
            if (!isset($row['annee']) || trim($row['annee']) === '') {
                return null;
            }

            return intval($row['annee']);
        }

        ///Valeur
        private function getValue($row){
            if (!isset($row['valeur'])) {
                return null;
            }
            $rawValue = trim($row['valeur']);
            if ($rawValue === '') {
                return null; // Valeur vide, rejetée
            }
            $normalizedValue = str_replace(',', '.', $rawValue);
            return (string) $normalizedValue;
        }

        ///
        private function normalize($value){
            return Str::slug(strtolower(trim($value)), ''); // Ex: " Hôpital Général " => "hopitalgeneral"
        }
       
        public function getRowCount():int{
            return $this->rows;
        }
    ///Fin des fonctions
}
