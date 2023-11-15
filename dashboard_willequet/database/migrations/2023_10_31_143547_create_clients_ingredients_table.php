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
        Schema::create('clients_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clients_id')->unsigned();
            $table->unsignedBigInteger('ingredients_id')->unsigned();

            $table->foreign('clients_id')->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('ingredients_id')->references('id')
                ->on('ingredients')->onDelete('cascade');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_ingredients');
    }
};
