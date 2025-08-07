<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\TypeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    private $msgSuccess ="Opération effectuée avec succès";
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index($rub,$srub)
    {
        $datas = Client::with('typeClient')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('client.index', [
            'datas'     => $datas,
            'controler' => $this,
            'rub'       => $rub,
            'srub'      => $srub,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rub,$srub)
    {
        $data_typeClient= TypeClient::orderBy('libelleTypeClient','asc')->get();
        return view('client.create')->with([
                        'controler'=>$this,
                        'rub'=>$rub,
                        'srub'=>$srub,
                        'data_typeClient'=>$data_typeClient
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nomClient'    => ['required','string','max:255'],
                'prenomClient' => ['nullable','string','max:255'],
                'telephoneClient' => ['required','string','max:255'],
                'emailClient'        =>   ['nullable','email','max:255'],
                'adresseClient'=> ['nullable','string','max:255'],
                'typeClient_id'=> 'required'
             ]);

            //If libelleTypeClient === CLIENT CREDIT ELSE
            $typeClient = DB::table('type_clients')
                        ->where('typeClient_id',$request->typeClient_id) 
                        ->value('libelleTypeClient');

            if ($typeClient === 'CLIENT CREDIT'){
                $client= new Client();
                $numero= $this->genererNumeroCompte();
                $client->numeroCompte=$numero;
                $client->nomClient=$request->nomClient;
                $client->prenomClient=$request->prenomClient;
                $client->telephoneClient=$request->telephoneClient;
                $client->emailClient=$request->emailClient;
                $client->adresseClient=$request->adresseClient;
                $client->typeClient_id=$request->typeClient_id;
                $client->save();
            } else{ //Autre que CLIENT CREDIT
               
                $client= new Client();
                $client->nomClient=$request->nomClient;
                $client->prenomClient=$request->prenomClient;
                $client->telephoneClient=$request->telephoneClient;
                $client->emailClient=$request->emailClient;
                $client->adresseClient=$request->adresseClient;
                $client->typeClient_id=$request->typeClient_id;
                $client->save();
            }
            
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('clients/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
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
    public function edit($id,$rub,$srub)
    {
        $data = Client::find($id);
        $data_typeClient= TypeClient::orderBy('libelleTypeClient','asc')->get();
        return view('client.edit')->with([
                        'rub'=>$rub,
                        'srub'=>$srub,
                        'data'=>$data,
                        'data_typeClient'=>$data_typeClient
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nomClient'    => ['required','string','max:255'],
                'prenomClient' => ['nullable','string','max:255'],
                'telephoneClient' => ['required','string','max:255'],
                'emailClient'        =>   ['nullable','email','max:255'],
                'adresseClient'=> ['nullable','string','max:255'],
                'typeClient_id'=> 'required'
             ]);

            //If libelleTypeClient === CLIENT CREDIT ELSE
            $typeClient = DB::table('type_clients')
                        ->where('typeClient_id',$request->typeClient_id) 
                        ->value('libelleTypeClient');

            if ($typeClient === 'CLIENT CREDIT'){
                $client= Client::find($id);
                //$numero= $this->genererNumeroCompte();
                //$client->numeroCompte=$numero;
                $client->nomClient=$request->nomClient;
                $client->prenomClient=$request->prenomClient;
                $client->telephoneClient=$request->telephoneClient;
                $client->emailClient=$request->emailClient;
                $client->adresseClient=$request->adresseClient;
                $client->typeClient_id=$request->typeClient_id;
                $client->save();
            } else{ //Autre que CLIENT CREDIT
               
                $client= Client::find($id);
                $client->nomClient=$request->nomClient;
                $client->prenomClient=$request->prenomClient;
                $client->telephoneClient=$request->telephoneClient;
                $client->emailClient=$request->emailClient;
                $client->adresseClient=$request->adresseClient;
                $client->typeClient_id=$request->typeClient_id;
                $client->save();
            }
            
            DB::commit();
        }
        catch (\Exception $e) {
               DB::rollBack();
               $msgError = $e->getMessage();
               return back()->with(['error'=>$msgError]);
            }
         return redirect('clients/'.$request->input('rub').'/'.$request->input('srub'))->with(['success'=>$this->msgSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data=Client::find($id);
            $data->delete();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $msgError = $e->getMessage();
            return back()->with(['error'=>$msgError]);
        }
         return back()->with(['success'=>$this->msgSuccess]);
    }
    
}
