<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'loss',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'clients_ingredients', 'ingredients_id', 'clients_id')->withPivot('amount')->withTimestamps();
    }

    public function clientsOrders()
    {
        return $this->belongsToMany(Client::class, 'ingredient_orders', 'ingredient_id', 'clients_id')->withPivot('date', 'amountPerPerson', 'persons', 'totalAmount', 'cups')->withTimestamps();
    }
}
