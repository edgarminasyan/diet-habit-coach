<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_item_id')->nullable()->constrained()->nullOnDelete();
            $table->string('description')->nullable();
            $table->float('quantity_grams')->nullable();
            $table->float('calories');
            $table->float('protein')->default(0);
            $table->float('carbs')->default(0);
            $table->float('fat')->default(0);
            $table->enum('estimation_method', ['search','ai'])->default('ai');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('meal_items'); }
};
