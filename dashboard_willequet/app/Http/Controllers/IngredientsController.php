<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientsRequest;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IngredientsController extends Controller
{
    public function index(){
        $ingredients = Ingredient::paginate(25);
        return view('ingredients.index', [
            'ingredients' => $ingredients
        ]);
    }

    public function create(IngredientsRequest $request){
        Ingredient::create($request->all());

        return Redirect::route('ingredients.index');
    }

    public function update(IngredientsRequest $request, $id){

        $ingredient = Ingredient::find($id);
        
        $ingredient->fill($request->all());
        $ingredient->save();

        return Redirect::route('ingredients.index');
    }

    public function destroy($id){
        $ingredient = Ingredient::find($id);
        $ingredient->delete();
        
        return Redirect::route('ingredients.index');
    }

    public function search(Request $request){
        $ingredientSearch = Ingredient::where('name','like','%'.$request->search.'%')->get();
    
            return view('ingredients.search', [
                'ingredientSearch' => $ingredientSearch
            ]);
         
    }
}
