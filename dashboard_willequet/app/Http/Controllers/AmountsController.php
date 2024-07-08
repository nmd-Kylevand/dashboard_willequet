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
        $ingredients = Ingredient::orderBy('name')->get();
        $assignedIngredients = $client->ingredients()->get();

        // remove assigned ingredients from all ingredients list 
        // $unassignedIngredients= $ingredients->diff($assignedIngredients);
        
        $allIngredients = $ingredients->merge($assignedIngredients)->paginate(50);
        return view('amounts.detail', compact('client', 'assignedIngredients',  'allIngredients'));
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

        // return redirect()->to('amounts/'.$clientId);
        return redirect()->back();
        
    }

    public function search(Request $request){
        $client = Client::find($request->clientId);
        $ingredients = Ingredient::orderBy('name')->where('name','like','%'.$request->search.'%')->get();

        $assignedIngredients = $client->ingredients()->where('name','like','%'.$request->search.'%')->get();
        // $ingredientSearch = Ingredient::where('name','like','%'.$request->search.'%')->get();
        $allIngredients = $ingredients->merge($assignedIngredients)->paginate(50);

            return view('amounts.search', [
                'ingredientSearch' => $allIngredients,
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
