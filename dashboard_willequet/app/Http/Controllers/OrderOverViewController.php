<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderOverViewController extends Controller
{
    public function index(){
        $ingredients = Ingredient::all()->groupBy('name');

        return view('orderOverview.index', compact('ingredients'));
    }

    public function search(Request $request){
        
        $date = $request->search;

        $carbonDate = Carbon::parse($date);

        $firstdayOfWeek = $carbonDate->startOfWeek()->format('Y-n-d');

        $lastdayOfWeek = $carbonDate->endOfWeek()->format('Y-n-d');

        $orderOverview = DB::table('ingredient_orders')
        ->whereBetween('date',[$firstdayOfWeek, $lastdayOfWeek])
        ->join('ingredients', 'ingredient_orders.ingredient_id', '=', 'ingredients.id')
        ->select('ingredients.*','ingredient_orders.*', DB::raw('SUM(totalAmount) as totalAmount'))
        ->groupBy('ingredient_orders.ingredient_id')
        ->orderBy('ingredients.name')
        ->get();


        return view('orderOverview.search', compact('orderOverview', 'firstdayOfWeek'));
         
    }
}
