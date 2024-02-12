<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Ingredient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function orderDetail($id, $date){
        $clientsForForm = Client::all();
        $ingredientForForm = Ingredient::find($id);
        $clients =  DB::table('ingredient_orders')
        ->where('date', $date)
        ->where('ingredient_id', $id)
        ->join('clients','ingredient_orders.clients_id','=','clients.id')
        ->rightJoin('clients_ingredients', 'clients.id', "=", "clients_ingredients.clients_id")
        ->where('clients_ingredients.ingredients_id', $id)
        ->select('clients.*',  'ingredient_orders.*', 'clients_ingredients.*')
        ->get();
        
        return view('orders.detail', compact('clients','ingredientForForm', 'clientsForForm'));
    }

    public function save(Request $request){
        
        $clientIds = $request->clientId;
        $ingredientId = $request->ingredientId;
        $amounts = $request->persons;
        $date = $request->date;
        // dd($request);
        $cups = $request->category ?? "";
        $amountPerPerson = $request->amountPerPerson;

        if($request->delete){
            $id = (int)$request->delete;
            $client = Client::find($id);
            $ingredient = Ingredient::find($ingredientId);
            $ingredient->clientsOrders()->detach($id);
            return redirect()->to('orders/'.$ingredientId.'-'.$date);

        }

        $totalAmount = array_map(function($app, $amount) {
            return $app * $amount;
        }, $amountPerPerson, $amounts);
        
        
            $ingredient = Ingredient::find($ingredientId);
            for ($i=0; $i < count($clientIds); $i++) { 
                if($ingredient->clientsOrders()->wherePivot('clients_id',$clientIds[$i])->exists()){
                
                    $ingredient->clientsOrders()->detach($clientIds[$i],['persons' => $amounts[$i], 'date' => $request->date, 'totalAmount' => $totalAmount[$i], 'cups' => $cups[$i]]);
        
                }
                $ingredient->clientsOrders()->attach($clientIds[$i],['persons' => $amounts[$i], 'date' => $request->date, 'totalAmount' => $totalAmount[$i], 'cups' => $cups[$i]]);
            }
        
      
       
        
        

        return redirect()->to('orders/'.$ingredientId.'-'.$date);
    }

    public function create(Request $request){
        $clientId = $request->client;
        $ingredientId = $request->ingredient;
        $category = $request->categories;
        $date = $request->date;


        $ingredient = Ingredient::find($ingredientId);

        if($category){
            $categorizedClients = Client::where('category', $category)->get();
            foreach ($categorizedClients as $client) {
                $ingredient->clientsOrders()->attach($client->id, ['date' => $request->date]);

            }
        } else{
            $ingredient->clientsOrders()->attach($clientId, ['date' => $request->date]);
        }

        return redirect()->to('orders/'.$ingredientId.'-'.$date);
    }

    public function search(Request $request){
        $clients = Client::all()->sortDesc();
        $ingredients = Ingredient::all()->sortDesc();
        
        $orderSearch = Ingredient::whereHas('clientsOrders', function($query) use($request){
            $query->where('ingredient_orders.date','like','%'.$request->search.'%');
        })->get();
        
    
        // $totalAmounts = Ingredient::whereHas('clientsOrders', function($query) use($request){
        //     $query->where('ingredient_orders.ingredient_id', )
        // })
        
        return view('orders.search', compact('clients', 'ingredients', 'orderSearch'));
         
    }

    public function copy(Request $request){
        $ingredient = Ingredient::find($request->ingredientId);
        $orderSearch = $ingredient->clientsOrders()->wherePivot('date', $request->currentDate)->wherePivot('ingredient_id', $request->ingredientId)
        ->get();

    }

    public function searchAmounts(Request $request){
        
        $currentClient = Client::find($request->client);
        $clientsIngredients = $currentClient->ingredientOrders()->where('date', $request->currentDate)->get();

        return view('orders.client-amount', compact('clientsIngredients', 'currentClient'));
    }

    public function delete(Request $request){
        $id = $request->id;
        $date = $request->date;
        $client = Ingredient::find($id);
        dd($client);
        $client->clientsOrders()->where('date', $date)->detach();

        return redirect()->to('orders/');
    }
    public function deleteById(Request $request){

    }
}
