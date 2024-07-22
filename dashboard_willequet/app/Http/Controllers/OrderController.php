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
        ->orderBy('clients.color')
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
            $ingredient->clientsOrders()->wherePivot('date', $date)->detach($id);
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
        
    
        $clientIds = $request->clientId; // Array of client IDs
        $ingredientArr = $request->ingredientId; // Array of arrays of ingredient IDs
        $amounts = $request->persons; // Array of arrays of amounts
        $date = $request->date;

        for ($counter = 0; $counter < count($clientIds); $counter++) {
            $clientId = $clientIds[$counter];
            $ingredients = $ingredientArr[$counter];
            $persons = $amounts[$counter];
            for ($innerCounter = 0; $innerCounter < count($ingredientArr); $innerCounter++) {
                $ingredient = Ingredient::find($ingredients);

    
                // Check if an ingredient order exists for the given client and date
                $ingredientOrder = DB::table('ingredient_orders')
                    ->where('clients_id', $clientId)
                    ->where('ingredient_id', $ingredients[$innerCounter])
                    ->where('date', $date)
                    ->first();
    
                if ($ingredientOrder) {
                    // Update the existing ingredient order
                    $ingredients->clientsOrders()->attach($clientId,['persons' => $persons, 'date' => $request->date]);

                } 
                
            }
        }

        return redirect()->back();

    }

    
    public function create(Request $request) {
        $clientId = $request->client;
        $ingredientId = $request->ingredient;
        $category = $request->categories;
        $date = $request->date;
    
        $client = Client::with('ingredients')->find($clientId);
    

        $ingredient = Ingredient::find($ingredientId);
        $clientIngr = $ingredient->clients()->get();
        

        // Extract the base name without suffixes
        $originalName = preg_replace('/\s\(\d+\)$/', '', $client->name);
    
        // Fetch all clients with similar base names
        $similarClients = Client::where('name', 'LIKE', "$originalName%")->get();
    
        // Initialize the highest suffix to 1
        $highestSuffix = 2;
    
        // Iterate through similar client names to find the highest suffix
        foreach ($similarClients as $similarClient) {
            $name = $similarClient->name;
    
            // Check if the name is the original name
            if ($name == $originalName) {
                continue;
            }
    
            // Use regex to find the suffix in the form "clientName (X)"
            if (preg_match('/\((\d+)\)$/', $name, $matches)) {
                $suffix = (int)$matches[1];
                if ($suffix >= $highestSuffix) {
                    $highestSuffix = $suffix + 1;
                }
            }
        }
        
        if($client->name == $originalName){
            
                // Create the new client name for the duplicate
            $newClientName = $originalName . " ($highestSuffix)";
        
            // Duplicate the client and set the new name
            $duplicatedClient = $client->duplicate();
            $duplicatedClient->name = $newClientName;
        
            // Save the new duplicated client
            $duplicatedClient->save();
            $ingredient->clientsOrders()->attach($duplicatedClient->id, ['date' => $date]);

            return redirect()->to('orders/' . $ingredientId . '-' . $date);
        }
        // Create the new client name for the duplicate
        $newClientName = $originalName . " ($highestSuffix)";
    
        // Duplicate the client and set the new name
        $duplicatedClient = $client->duplicate();
        $duplicatedClient->name = $newClientName;

      
        // Save the new duplicated client
        $duplicatedClient->save();

        // Handle category-specific logic if a category is provided
        if ($category) {
            $categorizedClients = Client::where('category', $category)->get();
            foreach ($categorizedClients as $client) {
                if ($clientIngr->contains('name', $client->name)) {
                    $ingredient->clientsOrders()->attach($client->id, ['date' => $date]);
                }
            }
        } else {
            if ($clientIngr->contains('name', $client->name)) {
                $ingredient->clientsOrders()->attach($clientId, ['date' => $date]);
                return redirect()->to('orders/' . $ingredientId . '-' . $date);
            } else {
                return redirect()->to('orders/' . $ingredientId . '-' . $date)
                    ->withErrors(['msg' => 'De geselecteerde klant heeft nog geen gemiddeld aantal voor dit ingrediënt, gelieve dit eerst toe te voegen.']);
            }
        }
    
        // Redirect to the orders page
        return redirect()->to('orders/' . $ingredientId . '-' . $date);
    }
    
  
    
    
    

    public function search(Request $request){
        $clients = Client::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();
        $filteredClients = [];

        $orderSearch = Client::whereHas('ingredientOrders', function($query) use($request){
            $query->where('date','=',$request->search);
        })
        ->get();
       
        

// Step 1: Query to get all clients for each ingredient
$results = DB::table('ingredient_orders')
    ->where('ingredient_orders.date', $request->search)
    ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
    ->join('ingredients', 'ingredient_orders.ingredient_id', '=', 'ingredients.id')
    ->rightJoin('clients_ingredients', function ($join) {
        $join->on('ingredient_orders.clients_id', '=', 'clients_ingredients.clients_id')
             ->on('ingredient_orders.ingredient_id', '=', 'clients_ingredients.ingredients_id');
    })
    ->select(
        'clients.name',
        'clients.color',
        'ingredients.id',
        'ingredients.name AS ingredientName',
        'ingredient_orders.persons',
        'ingredient_orders.date',
        'clients_ingredients.comment',
        'ingredient_orders.totalAmount',
        'ingredient_orders.cups',
        'clients_ingredients.amount',
        'ingredient_orders.persons'
    )
    ->get();

// Step 2: Group by ingredientName
$groupedResults = $results->groupBy('ingredientName');

// Step 3: Format the results
$formattedResults = $groupedResults->map(function ($clients, $ingredientName) {
    $totalPersons = $clients->sum(function ($client) {
        return $client->persons ?: 0; // Treat null as 0
    });

    $totalAmount = $clients->sum(function ($client) {
        return $client->totalAmount ?: 0; // Treat null as 0
    });

      // Transform comment to uppercase
      $clients->transform(function ($client) {
        $client->comment = strtoupper($client->comment);
        return $client;
    });

    return [
        'ingredientName' => $ingredientName,
        'clients' => $clients,
        'totalPersons' => $totalPersons,
        'totalAmount' => $totalAmount
    ];
});

// Return the formatted results

// $orderSearch = Ingredient::whereIn('id', $ingredientIds)->get();
        
        // dd($orderSearch);
        $orderSearchEtiq = DB::table('ingredient_orders')
        ->where('date', $request->search)
        ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
        ->join('ingredients', 'ingredient_orders.ingredient_id', '=', 'ingredients.id')
        ->rightJoin('clients_ingredients', function($join) {
            $join->on('ingredient_orders.clients_id', '=', 'clients_ingredients.clients_id');
            $join->on('ingredient_orders.ingredient_id', '=', 'clients_ingredients.ingredients_id');
        })
        ->select('clients.name', 'clients.color', 'ingredients.name AS ingredientName', 'ingredient_orders.persons', 'ingredient_orders.date', 'clients_ingredients.comment', 'ingredient_orders.totalAmount', 'ingredient_orders.cups', 'clients_ingredients.amount', 'ingredient_orders.persons')
        ->orderByRaw("
            CASE 
                WHEN clients.color = '#F7FAFC' THEN 1
                WHEN clients.color = '#45CEE6' THEN 2
                WHEN clients.color = '#6FE21B' THEN 3
                WHEN clients.color = '#E655CA' THEN 4
                WHEN clients.color = '#C93434' THEN 5
                WHEN clients.color = '#E7F05A' THEN 6
                ELSE 7
            END
        ")
        ->orderBy('clients.name', 'asc')
        ->get();

        
        
        // $totalAmounts = Ingredient::whereHas('clientsOrders', function($query) use($request){
        //     $query->where('ingredient_orders.ingredient_id', )
        // })
        
        return view('orders.search', compact('clients', 'ingredients', 'orderSearch', 'orderSearchEtiq', 'formattedResults'));
         
    }

    public function copy(Request $request){
        $ingredient = Ingredient::find($request->ingredientId);
        $orderSearch = $ingredient->clientsOrders()->wherePivot('date', $request->currentDate)->wherePivot('ingredient_id', $request->ingredientId)
        ->get();
       
        $newDate = $request->date;
        $currentDate = $request->currentDate;
        $data = $request->data;
        foreach ($orderSearch as $client) {
            $ingredient->clientsOrders()->attach($client->id, ['persons' => $client->pivot->persons,'cups' => $client->pivot->cups,'totalAmount' => $client->pivot->totalAmount,'date' => $newDate]);
        }
        return redirect()->back();

    }

    public function searchAmounts(Request $request){
      
    $clients = DB::table('ingredient_orders')
    ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
    ->join('ingredients', 'ingredient_orders.ingredient_id', '=', 'ingredients.id')
    ->rightJoin('clients_ingredients', function($join) {
        $join->on('ingredient_orders.clients_id', '=', 'clients_ingredients.clients_id');
        $join->on('ingredient_orders.ingredient_id', '=', 'clients_ingredients.ingredients_id');
    })
    ->where('ingredient_orders.date', $request->currentDate)
    ->where('clients.name', 'LIKE', "{$request->client}%")
    ->select('clients.name', 'ingredient_orders.clients_id','clients_ingredients.ingredients_id', 'clients.color', 'ingredients.name AS ingredientName', 'ingredient_orders.persons', 'ingredient_orders.date', 'clients_ingredients.comment', 'ingredient_orders.totalAmount', 'ingredient_orders.cups', 'clients_ingredients.amount', 'ingredient_orders.persons')
    ->orderBy('clients.color', 'asc')
    ->orderBy('clients.name', 'asc')
    ->get();
        return view('orders.client-amount', compact('clients'));
    }

    public function delete(Request $request){
        $id = $request->id;
        $date = $request->date;
        $client = Ingredient::find($id);
        // dd($client->clientsOrders()->where('date', $date)->get());
        DB::table('ingredient_orders')->where('ingredient_id', $id)
        ->where('date', $date)->delete();
        return redirect()->to('orders/');
    }
}
