<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::all();
        return view('clients.index', [
            'clients' => $clients
        ]);
    }

    public function create(){
        
    }

    public function update(ClientRequest $request, Client $clients, $id){

        if($id){
            $clients = Client::find($id);
        }
        
        $clients->fill($request->all());
        $clients->save();

        return Redirect::route('clients.index');
    }

    public function destroy($id){
        $client = Client::find($id);
        $client->delete();
        
        return Redirect::route('clients.index');
    }
}
