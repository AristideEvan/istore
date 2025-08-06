<?php

namespace App\Exports;

use App\Models\Structure;
use App\Models\Indicateur;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ValeurIndicateurStructuresExport implements FromArray, WithHeadings,WithStyles
{
    
    private $structure;
    private $indicateurs;
    private $annee;
    private $fileName = 'canevas_import_valeur_indicateur_structure.xlsx';

    public function __construct($structure_id, $thematique_id, $annee)
    {
        $this->structure = Structure::findOrFail($structure_id);
        $this->indicateurs = Indicateur::where('thematique_id', $thematique_id)->get();
        $this->annee = $annee;
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->indicateurs as $indicateur) {
            $rows[] = [
                $this->structure->structureLibelle,
                $indicateur->indicateurLibelle,
                $this->annee,
                '' // valeur vide
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Structure', 'Indicateur', 'Annee', 'Valeur'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Ligne 1 = entête
        ];
    }

    
}
