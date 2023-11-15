<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Ingredient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function index(){
        $clients = Client::all()->sortDesc();
        $ingredients = Ingredient::all()->sortDesc();

        // $orders = Client::with('ingredientOrders')->get();
        $orders = Ingredient::has('clientsOrders')->get();
        

        return view('orders.index', compact('clients', 'ingredients', 'orders'));
    }

    public function orderDetail($id){
        
        $clients = Ingredient::with('clientsOrders','clients')->where('id', $id)->get();
        // $amounts = Ingredient::with('clients')->where('id', $id)->get();

        // $clientsMerged = $clients->mergeRecursive($amounts);
        return view('orders.detail', compact('clients'));
    }

    public function save(Request $request){

        // dd($request);
        $clientId = $request->clientId;
        $ingredientId = $request->ingredientId;
        $amount = $request->persons;
        $date = $request->date;
        $ingredient = Ingredient::find($ingredientId);

        if($ingredient->clientsOrders()->wherePivot('clients_id',$clientId)->exists()){
            $ingredient->clientsOrders()->detach($clientId,['persons' => $amount, 'date' => $request->date]);

        }
        $ingredient->clientsOrders()->attach($clientId,['persons' => $amount, 'date' => $request->date]);
        

        return redirect()->to('orders/'.$ingredientId);
    }

    public function create(Request $request){
        $clientId = $request->client;
        $ingredientId = $request->ingredient;
        $category = $request->categories;

        $ingredient = Ingredient::find($ingredientId);

        if($category){
            $categorizedClients = Client::where('category', $category)->get();
            foreach ($categorizedClients as $client) {
                $ingredient->clientsOrders()->attach($client->id, ['date' => $request->date]);

            }
        } else{
            $ingredient->clientsOrders()->attach($clientId, ['date' => $request->date]);
        }

        

        return redirect()->back();
    }
    public function search(Request $request){
        $clients = Client::all()->sortDesc();
        $ingredients = Ingredient::all()->sortDesc();
        
        $orderSearch = Ingredient::whereHas('clientsOrders', function($query) use($request){
            $query->where('ingredient_orders.date','like','%'.$request->search.'%');
        })->get();
    
        return view('orders.search', compact('clients', 'ingredients', 'orderSearch'));
         
    }
}
