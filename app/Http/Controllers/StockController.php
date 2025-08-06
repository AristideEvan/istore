<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($rub,$srub)
    {
        $data_magasin= Magasin::orderBy('nomMagasin','asc')->get();
        $datas = Stock::with('article.typeArticle')->get();
        $datas = $datas->sortBy([
            ['article.typeArticle.libelleTypeArticle', 'asc'],
            ['article.libelleArticle', 'asc'],
        ])->values();  
            return view('stock.index', [
                'datas' => $datas,
                'data_magasin'=>$data_magasin,
                'controler' => $this,
                'rub' => $rub,
                'srub' => $srub,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
