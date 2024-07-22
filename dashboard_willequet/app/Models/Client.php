<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use \Bkwld\Cloner\Cloneable;
    use HasFactory;
    protected $fillable = [
        'color',
        'name',
        'address',
        'type',
        'averageAmount',
        'email',
        'telephone',
        'category'
    ];

    protected $cloneable_relations = ['ingredients'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'clients_ingredients', 'clients_id', 'ingredients_id')->withPivot('amount','comment')->withTimestamps();
    }

    public function ingredientOrders(){
        return $this->belongsToMany(Ingredient::class, 'ingredient_orders', 'clients_id', 'ingredient_id')->withPivot('date', 'amountPerPerson', 'persons', 'totalAmount', 'cups')->withTimestamps();
    }
}
