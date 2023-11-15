<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredient_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id')->unsigned();
            $table->unsignedBigInteger('clients_id')->unsigned();

            $table->foreign('ingredient_id')->references('id')
                ->on('ingredients')->onDelete('cascade');
            $table->foreign('clients_id')->references('id')
                ->on('clients')->onDelete('cascade');
            
            $table->float('amountPerPerson')->nullable();
            $table->float('persons')->nullable();
            $table->float('totalAmount')->nullable();
            $table->string('cups')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_orders');
    }
};
