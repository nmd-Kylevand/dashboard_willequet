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
        $clients = Client::all()->sortDesc();
        return view('clients.index', [
            'clients' => $clients
        ]);
    }

    public function create(ClientRequest $request){
        Client::create($request->all());
        return Redirect::route('clients.index');
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

    public function search(Request $request){
        $clientsSearch = Client::where('name','like','%'.$request->search.'%')
            ->orWhere('address','like','%'.$request->search.'%')
            ->orWhere('email','like','%'.$request->search.'%')
            ->orWhere('telephone','like','%'.$request->search.'%')
            ->orWhere('type','like','%'.$request->search.'%')
            ->get();
    
            return view('clients.search', [
                'clientsSearch' => $clientsSearch
            ]);
         
    }
        
}
