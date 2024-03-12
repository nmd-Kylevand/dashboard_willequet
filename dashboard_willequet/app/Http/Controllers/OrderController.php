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
        $clients = Client::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

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
        ->groupBy('clients.name')
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

    public function saveMultiple(Request $request){
        $client = Client::find($request->clientId);
        $ingredientArr = $request->ingredientId;
        $amounts = $request->persons;
        $date = $request->date;
        $cups = $request->category;
        for($counter = 0; $counter < count($ingredientArr); $counter++){
            DB::table('ingredient_orders')
                ->where('clients_id', $request->clientId)
                ->where('ingredient_id', $ingredientArr[$counter])
                ->update(['persons' => $amounts[$counter]]);
        }
       

        return redirect()->back();

    }

    public function create(Request $request){
        $clientId = $request->client;
        $ingredientId = $request->ingredient;
        $category = $request->categories;
        $date = $request->date;

        $client = Client::find($clientId);
        
        $ingredient = Ingredient::find($ingredientId);
        $clientIngr = $ingredient->clients()->get();
      

            if($category){
                $categorizedClients = Client::where('category', $category)->get();
                foreach ($categorizedClients as $client) {
                    if($clientIngr->contains('name',$client->name)){
                      $ingredient->clientsOrders()->attach($client->id, ['date' => $request->date]);
                    }
                }
            } else{
                if($clientIngr->contains('name',$client->name)){
                    $ingredient->clientsOrders()->attach($clientId, ['date' => $request->date]);
                    return redirect()->to('orders/'.$ingredientId.'-'.$date);
                }else{
                    return redirect()->to('orders/'.$ingredientId.'-'.$date)->withErrors(['msg' => 'De geselecteerde klant heeft nog geen gemiddeld aantal voor dit ingrediënt, gelieve dit eerst toe te voegen.']);
        
                };    
            }
            return redirect()->to('orders/'.$ingredientId.'-'.$date);

    
        }
        
    

    public function search(Request $request){
        $clients = Client::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        
        $orderSearch = Ingredient::whereHas('clientsOrders', function($query) use($request){
            $query->where('ingredient_orders.date','like','%'.$request->search.'%');
        })
        ->get();

        $orderSearchEtiq = DB::table('ingredient_orders')
        ->where('date', $request->search)
        ->join('clients','ingredient_orders.clients_id','=','clients.id')
        ->join('ingredients', 'ingredient_orders.ingredient_id', '=', 'ingredients.id')
        ->rightJoin('clients_ingredients', function($join){
            $join->on('ingredient_orders.clients_id', '=', 'clients_ingredients.clients_id');
            $join->on('ingredient_orders.ingredient_id', '=', 'clients_ingredients.ingredients_id');
        })
        ->select('clients.name', 'clients.color', 'ingredients.name AS ingredientName', 'ingredient_orders.persons', 'ingredient_orders.date', 'clients_ingredients.comment')
        ->get();

        // dd($orderSearchEtiq);
        
        
        // $totalAmounts = Ingredient::whereHas('clientsOrders', function($query) use($request){
        //     $query->where('ingredient_orders.ingredient_id', )
        // })
        
        return view('orders.search', compact('clients', 'ingredients', 'orderSearch', 'orderSearchEtiq'));
         
    }

    public function copy(Request $request){
        $ingredient = Ingredient::find($request->ingredientId);
        $orderSearch = $ingredient->clientsOrders()->wherePivot('date', $request->currentDate)->wherePivot('ingredient_id', $request->ingredientId)
        ->get();
        $newDate = $request->date;
        $currentDate = $request->currentDate;
        foreach ($orderSearch as $client) {
            $ingredient->clientsOrders()->attach($client->id, ['date' => $newDate]);

        }
        return redirect()->back();

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
        $client->clientsOrders()->where('date', $date)->detach();

        return redirect()->to('orders/');
    }
}
