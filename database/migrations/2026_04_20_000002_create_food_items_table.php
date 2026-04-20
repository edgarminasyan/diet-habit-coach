<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->string('off_id')->nullable()->index();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->float('calories_per_100g')->default(0);
            $table->float('protein_per_100g')->default(0);
            $table->float('carbs_per_100g')->default(0);
            $table->float('fat_per_100g')->default(0);
            $table->string('source')->default('openfoodfacts');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('food_items'); }
};
