<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    private $msgerror='Impossible de supprimer cet élément car il est utilisé!';
    private $operation='Opération effectuée avec succès';
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
    public function index($rub, $srub)
    {
        //dd(session('menus'));
        $actions=Action::orderby('created_at','desc')->get();
        return view('action.index')->with(['actions'=>$actions,'controler'=>$this,"rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub, $srub)
    {
        return view('action.create')->with(["rub"=>$rub,"srub"=>$srub]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'action' => ['required', 'string'],
        ]);

        $action = new Action();
        $action->nomAction=$request->input('action');
        try {
            $action->save();
        } catch (\Throwable $th) {
            $msgerror = $th->getMessage();
            return back()->with(['error'=>$this->msgerror]);
        }
        return redirect('action/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
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
    public function edit($id,$rub = null, $srub=null)
    {
        $action=Action::find($id);
        return view('action.edit')->with(['action'=>$action,"rub"=>$rub,"srub"=>$srub]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'action' => ['required', 'string'],
        ]);

        $action = Action::find($id);
        $action->nomAction=$request->input('action');
        $action->save();

        return redirect('action/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->operation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $action=Action::find($id);
        $action->delete();
        return back()->with(['success'=>$this->operation]);
        //return redirect('action/'.$request['rub'].'/'.$request['srub']);
    }
}
