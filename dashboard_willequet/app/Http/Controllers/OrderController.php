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
    public function index()
    {
        $clients = Client::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        // $orders = Client::with('ingredientOrders')->get();
        $orders = Ingredient::has('clientsOrders')->get();

        return view(
            'orders.index',
            compact('clients', 'ingredients', 'orders')
        );
    }

    

    
    public function orderDetail($id, $date)
{
    // Retrieve the ingredient and clients for the form
    $clientsForForm = Client::orderBy('id')->get(); // Order by 'id' to ensure consistency
    $ingredientForForm = Ingredient::find($id);

    // Retrieve clients and their orders
    $clients = DB::table('ingredient_orders')
        ->where('date', $date)
        ->where('ingredient_id', $id)
        ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
        ->rightJoin(
            'clients_ingredients',
            'clients.id',
            '=',
            'clients_ingredients.clients_id'
        )
        ->where('clients_ingredients.ingredients_id', $id)
        ->select(
            'clients.*',
            'ingredient_orders.*',
            'clients_ingredients.*',
            'ingredient_orders.id AS ingrID',

        )
        ->orderByRaw(
            "
    CASE 
        WHEN clients.color = '#7D7D7D' THEN 1
        WHEN clients.color = '#45CEE6' THEN 2
        WHEN clients.color = '#6FE21B' THEN 3
        WHEN clients.color = '#4A7937' THEN 4
        WHEN clients.color = '#E655CA' THEN 5
        WHEN clients.color = '#C93434' THEN 6
        WHEN clients.color = '#F7FAFC' THEN 7
        WHEN clients.color = '#E89A17' THEN 8
        WHEN clients.color = '#E7F05A' THEN 9
        ELSE 10
    END
    "
        )
        ->orderBy('clients.name', 'asc')

        ->orderBy('clients.id', 'asc') // Ensure consistent ordering by client ID
        ->orderBy('ingredient_orders.created_at', 'asc')
        ->get();

    // Step 1: Count occurrences of each client name within the same ingredient
    $nameCounts = [];
    foreach ($clients as $client) {
        // Create a unique key based on the client's name and ingredient ID
        $key =
            $client->ingredient_id .
            '|' .
            preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

        if (!isset($nameCounts[$key])) {
            $nameCounts[$key] = 0;
        }
        $nameCounts[$key]++;
    }

    // Step 2: Append the correct suffixes within the same ingredient
    $currentNameCount = [];
    foreach ($clients as $client) {
        // Create a unique key based on the client's name and ingredient ID
        $key =
            $client->ingredient_id .
            '|' .
            preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

        // Initialize or increment the current count for this name within the same ingredient
        if (!isset($currentNameCount[$key])) {
            $currentNameCount[$key] = 1;
        } else {
            $currentNameCount[$key]++;
        }

        // Only apply suffixes if there are duplicates within the same ingredient
        if ($nameCounts[$key] > 1) {
            $client->name =
                preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name) .
                ' (' .
                $currentNameCount[$key] .
                '/' .
                $nameCounts[$key] .
                ')';
        }
    }

    // Apply the same duplicate name handling for clientsForForm
    $clientsForFormArray = $clientsForForm->toArray();
    $nameCountsForForm = array_count_values(
        array_column($clientsForFormArray, 'name')
    );
    $currentNameCountForForm = [];

    foreach ($clientsForForm as $client) {
        $name = $client->name;

        if (!isset($currentNameCountForForm[$name])) {
            $currentNameCountForForm[$name] = 1;
        } else {
            $currentNameCountForForm[$name]++;
        }

        if ($nameCountsForForm[$name] > 1) {
            $client->name =
                $name .
                ' (' .
                $currentNameCountForForm[$name] .
                '/' .
                $nameCountsForForm[$name] .
                ')';
        } else {
            $client->name = $name;
        }
    }

    // Handle duplicate names for orderSearchEtiq
    $orderSearchEtiq = DB::table('ingredient_orders')
        ->where('date', $date)
        ->where('ingredient_id', $id)
        ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
        ->join(
            'ingredients',
            'ingredient_orders.ingredient_id',
            '=',
            'ingredients.id'
        )
        ->rightJoin('clients_ingredients', function ($join) {
            $join->on(
                'ingredient_orders.clients_id',
                '=',
                'clients_ingredients.clients_id'
            );
            $join->on(
                'ingredient_orders.ingredient_id',
                '=',
                'clients_ingredients.ingredients_id'
            );
        })
        ->select(
            'clients.name',
            'clients.color',
            'ingredients.name AS ingredientName',
            'ingredient_orders.persons',
            'ingredient_orders.date',
            'clients_ingredients.comment',
            'ingredient_orders.totalAmount',
            'ingredient_orders.cups',
            'clients_ingredients.amount',
            'ingredient_orders.persons'
        )
        ->orderBy('ingredientName', 'asc')
        ->orderByRaw(
            "
            CASE 
                WHEN clients.color = '#7D7D7D' THEN 1
                WHEN clients.color = '#45CEE6' THEN 2
                WHEN clients.color = '#6FE21B' THEN 3
                WHEN clients.color = '#4A7937' THEN 4
                WHEN clients.color = '#E655CA' THEN 5
                WHEN clients.color = '#C93434' THEN 6
                WHEN clients.color = '#F7FAFC' THEN 7
                WHEN clients.color = '#E89A17' THEN 8
                WHEN clients.color = '#E7F05A' THEN 9
                ELSE 10
            END
            "
        )
        ->orderBy('clients.name', 'asc')
        ->get();

    // Step 1: Count all occurrences of each client name (ignoring any suffixes)
    $nameCounts = [];
    foreach ($orderSearchEtiq as $client) {
        // Strip any existing suffix from client name
        $baseName = preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

        if (!isset($nameCounts[$baseName])) {
            $nameCounts[$baseName] = 0;
        }
        $nameCounts[$baseName]++;
    }

    // Step 2: Append the correct suffixes
    $currentNameCount = [];
    foreach ($orderSearchEtiq as $client) {
        // Strip any existing suffix from client name
        $baseName = preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

        // Initialize the current count for each name
        if (!isset($currentNameCount[$baseName])) {
            $currentNameCount[$baseName] = 1;
        } else {
            $currentNameCount[$baseName]++;
        }

        // Only apply suffixes if there are duplicates
        if ($nameCounts[$baseName] > 1) {
            $client->name =
                $baseName .
                ' (' .
                $currentNameCount[$baseName] .
                '/' .
                $nameCounts[$baseName] .
                ')';
        }
    }

    return view(
        'orders.detail',
        compact(
            'clients',
            'ingredientForForm',
            'clientsForForm',
            'orderSearchEtiq'
        )
    );
}

    public function save(Request $request)
    {
        $clientIds = $request->clientId;
        $ingredientId = $request->ingredientId;
        $amounts = $request->persons;
        $date = $request->date;
        $ingredientOrdersId = $request->ingredientOrders;
        $cups = $request->category ?? '';
        $amountPerPerson = $request->amountPerPerson;
        if ($request->delete) {
            $id = (int) $request->delete;
            $ingredient = Ingredient::find($ingredientId);
            DB::table('ingredient_orders')->delete($id);
            return redirect()->to('orders/' . $ingredientId . '-' . $date);
        }

        $totalAmount = array_map(
            function ($app, $amount) {
                return $app * $amount;
            },
            $amountPerPerson,
            $amounts
        );

        $ingredient = Ingredient::find($ingredientId);
        for ($i = 0; $i < count($clientIds); $i++) {
            $ingredient->clientsOrders()->wherePivot('id', $ingredientOrdersId[$i])->wherePivot('date', $date)->update([
                'persons' => $amounts[$i],
                'date' => $request->date,
                'totalAmount' => $totalAmount[$i],
                'cups' => $cups[$i],
            ]);
        }

        return redirect()->to('orders/' . $ingredientId . '-' . $date);
    }

    public function saveMultiple(Request $request)
    {
        $clientIds = $request->clientId; // Array of client IDs
        $ingredientArr = $request->ingredientId; // Array of arrays of ingredient IDs
        $amounts = $request->persons ?? []; // Array of arrays of people
        $amountPerPerson = $request->amountPerPerson;
        $ingredientOrdersId = $request->ingOrdId;

        $date = $request->date;
        $cups = $request->cups;
        $totalAmount = array_map(
            function ($app, $amount) {
                return $app * $amount;
            },
            $amountPerPerson,
            $amounts
        );

        // creates duplicates fix issue
        for ($i = 0; $i < count($ingredientArr); $i++) {
            $ingredient = Ingredient::find($ingredientArr[$i]);
            $ingredient->clientsOrders()->wherePivot('id', $ingredientOrdersId[$i])->wherePivot('date', $date)->update([
                'persons' => $amounts[$i],
                'date' => $request->date,
                'totalAmount' => $totalAmount[$i],
                'cups' => $cups[$i],
            ]);
            // $ingredient->clientsOrders()->updateExistingPivot($clientIds[$i],['persons' => $amounts[$i], 'date' => $request->date, 'totalAmount' => $totalAmount[$i], 'cups' => $cups[$i] ]);
        }

        return redirect()->back();
    }

    


    public function create(Request $request)
    {
        $clientId = $request->client;
        $ingredientId = $request->ingredient;
        $category = $request->categories;
        $date = $request->date;

        $client = Client::with('ingredients')->find($clientId);
        $ingredient = Ingredient::find($ingredientId);
        $clientIngr = $ingredient->clients()->get();
        $clientsCurrentDate = $ingredient
            ->clientsOrders()
            ->wherePivot('date', $date)
            ->get();

        // Handle category-specific logic if a category is provided
        if ($category) {
            $categorizedClients = Client::where('category', $category)->get();
            foreach ($categorizedClients as $client) {
                if ($clientIngr->contains('name', $client->name)) {
                    $ingredient
                        ->clientsOrders()
                        ->attach($client->id, ['date' => $date]);
                }
            }
        } else {

         

            if ($clientIngr->contains('name', $client->name)) {
                $ingredient
                    ->clientsOrders()
                    ->attach($clientId, ['date' => $date]);
                return redirect()->to('orders/' . $ingredientId . '-' . $date);
            } else {
                return redirect()
                    ->to('orders/' . $ingredientId . '-' . $date)
                    ->withErrors([
                        'msg' =>
                            'De geselecteerde klant heeft nog geen gemiddeld aantal voor dit ingrediënt, gelieve dit eerst toe te voegen.',
                    ]);
            }
        }

        // Redirect to the orders page
        return redirect()->to('orders/' . $ingredientId . '-' . $date);
    }

    public function search(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $clientsForCreate = Client::orderBy('name')->groupBy('name')->get();

// Process client names to add suffixes for duplicates across all ingredients
$nameCounts = [];
$currentNameCount = [];

// Step 1: Count occurrences of each client name across all ingredients
foreach ($clients as $client) {
    // Strip any existing suffix from client name
    $baseName = preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

    if (!isset($nameCounts[$baseName])) {
        $nameCounts[$baseName] = 0;
    }
    $nameCounts[$baseName]++;
}

// Step 2: Append the correct suffixes
foreach ($clients as $client) {
    // Strip any existing suffix from client name
    $baseName = preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

    // Initialize or increment the current count for this name
    if (!isset($currentNameCount[$baseName])) {
        $currentNameCount[$baseName] = 1;
    } else {
        $currentNameCount[$baseName]++;
    }

    // Apply suffixes only if there are duplicates
    if ($nameCounts[$baseName] > 1) {
        $client->name = $baseName . " (" . $currentNameCount[$baseName] . "/" . $nameCounts[$baseName] . ")";
    }
}




        $ingredients = Ingredient::orderBy('name')->get();
        $filteredClients = [];

        $orderSearch = Client::whereHas('ingredientOrders', function (
            $query
        ) use ($request) {
            $query->where('date', '=', $request->search);
        })->get();

        // Step 1: Query to get all clients for each ingredient
        $results = DB::table('ingredient_orders')
            ->where('ingredient_orders.date', $request->search)
            ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
            ->join(
                'ingredients',
                'ingredient_orders.ingredient_id',
                '=',
                'ingredients.id'
            )
            ->rightJoin('clients_ingredients', function ($join) {
                $join
                    ->on(
                        'ingredient_orders.clients_id',
                        '=',
                        'clients_ingredients.clients_id'
                    )
                    ->on(
                        'ingredient_orders.ingredient_id',
                        '=',
                        'clients_ingredients.ingredients_id'
                    );
            })
            ->select(
                'clients.name',
                'clients.color',
                'ingredients.id',
                'ingredients.name AS ingredientName',
                'ingredient_orders.id AS ingrOrdID',
                'ingredient_orders.persons',
                'ingredient_orders.date',
                'clients_ingredients.comment',
                'ingredient_orders.totalAmount',
                'ingredient_orders.cups',
                'clients_ingredients.amount',
                'ingredient_orders.persons'
            )
            ->orderBy('ingredientName', 'asc')
            ->orderByRaw(
                "
        CASE 
            WHEN clients.color = '#7D7D7D' THEN 1
            WHEN clients.color = '#45CEE6' THEN 2
            WHEN clients.color = '#6FE21B' THEN 3
            WHEN clients.color = '#4A7937' THEN 4
            WHEN clients.color = '#E655CA' THEN 5
            WHEN clients.color = '#C93434' THEN 6
            WHEN clients.color = '#F7FAFC' THEN 7
            WHEN clients.color = '#E89A17' THEN 8
            WHEN clients.color = '#E7F05A' THEN 9
            ELSE 10
        END
        "
            )
            ->orderBy('clients.name', 'asc')
            ->get();

        // Step 2: Group by ingredientName
        $groupedResults = $results->groupBy('ingredientName');

        // Step 3: Format the results
        $formattedResults = $groupedResults->map(function (
            $clients,
            $ingredientName
        ) {
            $totalPersons = $clients->sum(function ($client) {
                return $client->persons ?: 0; // Treat null as 0
            });

            $totalAmount = $clients->sum(function ($client) {
                return $client->totalAmount ?: 0; // Treat null as 0
            });

            // Step 1: Count occurrences of each client name within the group
            $nameCounts = [];
            foreach ($clients as $client) {
                // Strip any existing suffix from client name
                $baseName = preg_replace(
                    '/\s\(\d+\/\d+\)$/',
                    '',
                    $client->name
                );

                if (!isset($nameCounts[$baseName])) {
                    $nameCounts[$baseName] = 0;
                }
                $nameCounts[$baseName]++;
            }

            // Step 2: Append the correct suffixes
            $currentNameCount = [];
            foreach ($clients as $client) {
                // Strip any existing suffix from client name
                $baseName = preg_replace(
                    '/\s\(\d+\/\d+\)$/',
                    '',
                    $client->name
                );

                // Initialize or increment the current count for this name
                if (!isset($currentNameCount[$baseName])) {
                    $currentNameCount[$baseName] = 1;
                } else {
                    $currentNameCount[$baseName]++;
                }

                // Only apply suffixes if there are duplicates
                if ($nameCounts[$baseName] > 1) {
                    $client->name =
                        $baseName .
                        ' (' .
                        $currentNameCount[$baseName] .
                        '/' .
                        $nameCounts[$baseName] .
                        ')';
                }
            }

            // Transform comment to uppercase
            $clients->transform(function ($client) {
                $client->comment = strtoupper($client->comment);
                return $client;
            });

            return [
                'ingredientName' => $ingredientName,
                'clients' => $clients,
                'totalPersons' => $totalPersons,
                'totalAmount' => $totalAmount,
            ];
        });

        // Return the formatted results

        // $orderSearch = Ingredient::whereIn('id', $ingredientIds)->get();

        $orderSearchEtiq = DB::table('ingredient_orders')
            ->where('date', $request->search)
            ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
            ->join(
                'ingredients',
                'ingredient_orders.ingredient_id',
                '=',
                'ingredients.id'
            )
            ->rightJoin('clients_ingredients', function ($join) {
                $join->on(
                    'ingredient_orders.clients_id',
                    '=',
                    'clients_ingredients.clients_id'
                );
                $join->on(
                    'ingredient_orders.ingredient_id',
                    '=',
                    'clients_ingredients.ingredients_id'
                );
            })
            ->select(
                'clients.name',
                'clients.color',
                'ingredients.name AS ingredientName',
                'ingredient_orders.persons',
                'ingredient_orders.date',
                'clients_ingredients.comment',
                'ingredient_orders.totalAmount',
                'ingredient_orders.cups',
                'clients_ingredients.amount',
                'ingredient_orders.persons',
                'ingredient_orders.ingredient_id' // Include ingredient_id for grouping
            )
            ->orderBy('ingredientName', 'asc')
            ->orderByRaw(
                "
                CASE 
                    WHEN clients.color = '#7D7D7D' THEN 1
                    WHEN clients.color = '#45CEE6' THEN 2
                    WHEN clients.color = '#6FE21B' THEN 3
                    WHEN clients.color = '#4A7937' THEN 4
                    WHEN clients.color = '#E655CA' THEN 5
                    WHEN clients.color = '#C93434' THEN 6
                    WHEN clients.color = '#F7FAFC' THEN 7
                    WHEN clients.color = '#E89A17' THEN 8
                    WHEN clients.color = '#E7F05A' THEN 9
                    ELSE 10
                END
                "
            )
            ->orderBy('clients.name', 'asc')
            ->get();

        // Step 1: Count occurrences of each client name within the same ingredient
        $nameCounts = [];
        foreach ($orderSearchEtiq as $client) {
            // Create a unique key based on the client's name and ingredient ID
            $key =
                $client->ingredient_id .
                '|' .
                preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

            if (!isset($nameCounts[$key])) {
                $nameCounts[$key] = 0;
            }
            $nameCounts[$key]++;
        }

        // Step 2: Append the correct suffixes within the same ingredient
        $currentNameCount = [];
        foreach ($orderSearchEtiq as $client) {
            // Create a unique key based on the client's name and ingredient ID
            $key =
                $client->ingredient_id .
                '|' .
                preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

            // Initialize or increment the current count for this name within the same ingredient
            if (!isset($currentNameCount[$key])) {
                $currentNameCount[$key] = 1;
            } else {
                $currentNameCount[$key]++;
            }

            // Only apply suffixes if there are duplicates within the same ingredient
            if ($nameCounts[$key] > 1) {
                $client->name =
                    preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name) .
                    ' (' .
                    $currentNameCount[$key] .
                    '/' .
                    $nameCounts[$key] .
                    ')';
            }
        }

       

        return view(
            'orders.search',
            compact(
                'clients',
                'ingredients',
                'orderSearch',
                'orderSearchEtiq',
                'formattedResults',
                'clientsForCreate'
            )
        );
    }

    public function copy(Request $request)
    {
        $ingredient = Ingredient::find($request->ingredientId);
        $orderSearch = $ingredient
            ->clientsOrders()
            ->wherePivot('date', $request->currentDate)
            ->wherePivot('ingredient_id', $request->ingredientId)
            ->get();

        $newDate = $request->date;
        $currentDate = $request->currentDate;
        $data = $request->data;
        foreach ($orderSearch as $client) {
            $ingredient->clientsOrders()->attach($client->id, [
                'persons' => $client->pivot->persons,
                'cups' => $client->pivot->cups,
                'totalAmount' => $client->pivot->totalAmount,
                'date' => $newDate,
            ]);
        }
        return redirect()->back();
    }

   
    public function searchAmounts(Request $request)
    {
        $clients = DB::table('ingredient_orders')
            ->join('clients', 'ingredient_orders.clients_id', '=', 'clients.id')
            ->join(
                'ingredients',
                'ingredient_orders.ingredient_id',
                '=',
                'ingredients.id'
            )
            ->rightJoin('clients_ingredients', function ($join) {
                $join->on(
                    'ingredient_orders.clients_id',
                    '=',
                    'clients_ingredients.clients_id'
                );
                $join->on(
                    'ingredient_orders.ingredient_id',
                    '=',
                    'clients_ingredients.ingredients_id'
                );
            })
            ->where('ingredient_orders.date', $request->currentDate)
            ->where('clients.name', 'LIKE', "{$request->client}%")
            ->select(
                'clients.name',
                'ingredient_orders.clients_id',
                'clients_ingredients.ingredients_id',
                'clients.color',
                'ingredients.name AS ingredientName',
                'ingredient_orders.id AS ingrOrdID',
                'ingredient_orders.persons',
                'ingredient_orders.date',
                'clients_ingredients.comment',
                'ingredient_orders.totalAmount',
                'ingredient_orders.cups',
                'clients_ingredients.amount',
                'ingredient_orders.persons',
                'ingredient_orders.ingredient_id' // Include ingredient_id for grouping
            )
            ->orderBy('clients.color', 'asc')
            ->orderBy('clients.name', 'asc')
            ->get();

        // Process client names to add suffixes for duplicates within each ingredient
        $nameCounts = [];
        $currentNameCount = [];

        foreach ($clients as $client) {
            // Create a unique key based on the client's name and ingredient ID
            $key =
                $client->ingredient_id .
                '|' .
                preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

            // Count occurrences of the base name within the same ingredient
            if (!isset($nameCounts[$key])) {
                $nameCounts[$key] = 0;
            }
            $nameCounts[$key]++;
        }

        foreach ($clients as $client) {
            // Create a unique key based on the client's name and ingredient ID
            $key =
                $client->ingredient_id .
                '|' .
                preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name);

            // Increment current occurrence for the base name within the same ingredient
            if (!isset($currentNameCount[$key])) {
                $currentNameCount[$key] = 1;
            } else {
                $currentNameCount[$key]++;
            }

            // Only apply suffixes if there are duplicates within the same ingredient
            if ($nameCounts[$key] > 1) {
                $client->name =
                    preg_replace('/\s\(\d+\/\d+\)$/', '', $client->name) .
                    ' (' .
                    $currentNameCount[$key] .
                    '/' .
                    $nameCounts[$key] .
                    ')';
            }
        }

        return view('orders.client-amount', compact('clients'));
    }

    
    public function copyIndividual(Request $request)
{
    $currentDate = $request->currentDate;
    $ingredientId = $request->ingredientId;
    $ingredient = Ingredient::find($ingredientId);
    $newDate = $request->date;
    $client = Client::find($request->clientsCopy);

    $duplicates = $ingredient->clientsOrders()->where('clients_id', $client->id)->where('date', $currentDate)
    ->get();
    foreach ($duplicates as $duplicateClient) {
        // Fetch the specific ingredient order for the duplicate client
        
            // Attach the order to the new date for the ingredient
            $ingredient->clientsOrders()->attach($duplicateClient->id, [
                'persons' => $duplicateClient->pivot->persons,
                'cups' => $duplicateClient->pivot->cups,
                'totalAmount' => $duplicateClient->pivot->totalAmount,
                'date' => $newDate,
            ]);
        
    }

    return redirect()->back();
}


    public function delete(Request $request)
    {
        $id = $request->id;
        $date = $request->date;
        $client = Ingredient::find($id);
        // dd($client->clientsOrders()->where('date', $date)->get());
        DB::table('ingredient_orders')
            ->where('ingredient_id', $id)
            ->where('date', $date)
            ->delete();
        return redirect()->to('orders/');
    }
}
