<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AmountsController extends Controller
{
    public function index(){
        $clients = Client::all()->sortDesc();
        return view('amounts.index', compact('clients'));
    }

    public function indexDetail($id){
        $client = Client::find($id);
        $assignedIngredients = $client->ingredients()->get();
        $ingredients = Ingredient::all()->union($assignedIngredients)->sortDesc();

        // remove assigned ingredients from all ingredients list 
        $unassignedIngredients= $ingredients->diff($assignedIngredients);

        return view('amounts.detail', compact('client', 'assignedIngredients', 'unassignedIngredients'));
    }

    public function assign(Request $request){
        $clientId = $request->clientId;
        $ingredientId = $request->ingredientId;
        $comment = $request->comment;

       
        $client = Client::find($clientId);
        if($client->ingredients()->wherePivot('ingredients_id',$ingredientId)->exists()){
            $client->ingredients()->detach($ingredientId, ['amount' => $request->amount, 'comment' => $comment ?? ""]);
        }
        $client->ingredients()->attach($ingredientId, ['amount' => $request->amount, 'comment' => $comment ?? ""]);

        return redirect()->to('amounts/'.$clientId);

        
    }

    public function search(Request $request){
        $client = Client::find($request->clientId);

        $ingredientSearch = Ingredient::where('name','like','%'.$request->search.'%')->get();
    
            return view('amounts.search', [
                'ingredientSearch' => $ingredientSearch,
                'client' => $client
            ]);
         
    }
    public function searchClient(Request $request){

        $clientSearch = Client::where('name','like','%'.$request->search.'%')->get();
    
            return view('amounts.search-client', [
                'clientSearch' => $clientSearch,
            ]);
         
    }
}