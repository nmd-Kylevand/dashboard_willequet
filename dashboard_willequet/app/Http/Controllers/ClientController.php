<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::all();
        return view('clients.index', [
            'clients' => $clients
        ]);
    }

    public function update(ClientRequest $request, Client $clients){
        $clients->fill($request->all());
        $clients->save();

        return redirect()->route('clients.index');
    }
}
