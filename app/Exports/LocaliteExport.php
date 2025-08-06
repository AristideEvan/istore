<?php

namespace App\Exports;

use App\Models\Indicateur;
use App\Models\Localite;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LocaliteExport implements FromArray,WithHeadings,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Localite::all();
    // }
    
    private $localite;
    private $indicateurs;
    private $annee;

    public function __construct($localite_id, $thematique_id, $annee)
    {
        $this->localite = Localite::find($localite_id);
        $this->indicateurs = Indicateur::where('thematique_id', $thematique_id)->get();
        $this->annee = $annee;
    }


    //construction du canevas

    public function array(): array
    {
        $rows = [];

        foreach ($this->indicateurs as $indicateur) {
            $rows[] = [
                $this->localite->localiteLibelle,
                $indicateur->indicateurLibelle,
                $this->annee,
                '' // valeur vide
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Localite', 'Indicateur', 'Annee', 'Valeur'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Ligne 1 = entête
        ];
    }

}
