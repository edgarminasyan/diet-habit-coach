<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use Illuminate\Database\Seeder;

class FoodItemSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            // Proteins
            ['name' => 'Chicken Breast (cooked)', 'brand' => null, 'calories_per_100g' => 165, 'protein_per_100g' => 31, 'carbs_per_100g' => 0, 'fat_per_100g' => 3.6, 'source' => 'manual'],
            ['name' => 'Salmon (baked)', 'brand' => null, 'calories_per_100g' => 206, 'protein_per_100g' => 20, 'carbs_per_100g' => 0, 'fat_per_100g' => 13, 'source' => 'manual'],
            ['name' => 'Eggs (whole)', 'brand' => null, 'calories_per_100g' => 155, 'protein_per_100g' => 13, 'carbs_per_100g' => 1.1, 'fat_per_100g' => 11, 'source' => 'manual'],
            ['name' => 'Greek Yogurt (0% fat)', 'brand' => 'Fage', 'calories_per_100g' => 59, 'protein_per_100g' => 10, 'carbs_per_100g' => 3.6, 'fat_per_100g' => 0.4, 'source' => 'manual'],
            ['name' => 'Cottage Cheese', 'brand' => null, 'calories_per_100g' => 98, 'protein_per_100g' => 11, 'carbs_per_100g' => 3.4, 'fat_per_100g' => 4.3, 'source' => 'manual'],
            ['name' => 'Tuna (canned in water)', 'brand' => null, 'calories_per_100g' => 116, 'protein_per_100g' => 26, 'carbs_per_100g' => 0, 'fat_per_100g' => 1, 'source' => 'manual'],
            ['name' => 'Turkey Breast (deli)', 'brand' => null, 'calories_per_100g' => 104, 'protein_per_100g' => 18, 'carbs_per_100g' => 1.7, 'fat_per_100g' => 2.7, 'source' => 'manual'],
            ['name' => 'Beef (lean ground, 90%)', 'brand' => null, 'calories_per_100g' => 215, 'protein_per_100g' => 26, 'carbs_per_100g' => 0, 'fat_per_100g' => 12, 'source' => 'manual'],
            // Carbs / Grains
            ['name' => 'Oats (rolled, dry)', 'brand' => null, 'calories_per_100g' => 389, 'protein_per_100g' => 17, 'carbs_per_100g' => 66, 'fat_per_100g' => 7, 'source' => 'manual'],
            ['name' => 'Brown Rice (cooked)', 'brand' => null, 'calories_per_100g' => 112, 'protein_per_100g' => 2.6, 'carbs_per_100g' => 24, 'fat_per_100g' => 0.9, 'source' => 'manual'],
            ['name' => 'White Rice (cooked)', 'brand' => null, 'calories_per_100g' => 130, 'protein_per_100g' => 2.7, 'carbs_per_100g' => 28, 'fat_per_100g' => 0.3, 'source' => 'manual'],
            ['name' => 'Whole Wheat Bread', 'brand' => null, 'calories_per_100g' => 247, 'protein_per_100g' => 13, 'carbs_per_100g' => 41, 'fat_per_100g' => 3.4, 'source' => 'manual'],
            ['name' => 'Sweet Potato (baked)', 'brand' => null, 'calories_per_100g' => 90, 'protein_per_100g' => 2, 'carbs_per_100g' => 21, 'fat_per_100g' => 0.1, 'source' => 'manual'],
            ['name' => 'Quinoa (cooked)', 'brand' => null, 'calories_per_100g' => 120, 'protein_per_100g' => 4.4, 'carbs_per_100g' => 22, 'fat_per_100g' => 1.9, 'source' => 'manual'],
            ['name' => 'Pasta (cooked)', 'brand' => null, 'calories_per_100g' => 158, 'protein_per_100g' => 5.8, 'carbs_per_100g' => 31, 'fat_per_100g' => 0.9, 'source' => 'manual'],
            // Vegetables
            ['name' => 'Broccoli (raw)', 'brand' => null, 'calories_per_100g' => 34, 'protein_per_100g' => 2.8, 'carbs_per_100g' => 7, 'fat_per_100g' => 0.4, 'source' => 'manual'],
            ['name' => 'Spinach (raw)', 'brand' => null, 'calories_per_100g' => 23, 'protein_per_100g' => 2.9, 'carbs_per_100g' => 3.6, 'fat_per_100g' => 0.4, 'source' => 'manual'],
            ['name' => 'Mixed Salad Greens', 'brand' => null, 'calories_per_100g' => 17, 'protein_per_100g' => 1.8, 'carbs_per_100g' => 2.2, 'fat_per_100g' => 0.2, 'source' => 'manual'],
            ['name' => 'Bell Pepper (red)', 'brand' => null, 'calories_per_100g' => 31, 'protein_per_100g' => 1, 'carbs_per_100g' => 6, 'fat_per_100g' => 0.3, 'source' => 'manual'],
            ['name' => 'Cucumber', 'brand' => null, 'calories_per_100g' => 16, 'protein_per_100g' => 0.7, 'carbs_per_100g' => 3.6, 'fat_per_100g' => 0.1, 'source' => 'manual'],
            // Fruits
            ['name' => 'Banana', 'brand' => null, 'calories_per_100g' => 89, 'protein_per_100g' => 1.1, 'carbs_per_100g' => 23, 'fat_per_100g' => 0.3, 'source' => 'manual'],
            ['name' => 'Apple', 'brand' => null, 'calories_per_100g' => 52, 'protein_per_100g' => 0.3, 'carbs_per_100g' => 14, 'fat_per_100g' => 0.2, 'source' => 'manual'],
            ['name' => 'Blueberries', 'brand' => null, 'calories_per_100g' => 57, 'protein_per_100g' => 0.7, 'carbs_per_100g' => 14, 'fat_per_100g' => 0.3, 'source' => 'manual'],
            ['name' => 'Strawberries', 'brand' => null, 'calories_per_100g' => 32, 'protein_per_100g' => 0.7, 'carbs_per_100g' => 7.7, 'fat_per_100g' => 0.3, 'source' => 'manual'],
            ['name' => 'Orange', 'brand' => null, 'calories_per_100g' => 47, 'protein_per_100g' => 0.9, 'carbs_per_100g' => 12, 'fat_per_100g' => 0.1, 'source' => 'manual'],
            // Fats / Nuts
            ['name' => 'Avocado', 'brand' => null, 'calories_per_100g' => 160, 'protein_per_100g' => 2, 'carbs_per_100g' => 9, 'fat_per_100g' => 15, 'source' => 'manual'],
            ['name' => 'Almonds', 'brand' => null, 'calories_per_100g' => 579, 'protein_per_100g' => 21, 'carbs_per_100g' => 22, 'fat_per_100g' => 50, 'source' => 'manual'],
            ['name' => 'Peanut Butter (natural)', 'brand' => null, 'calories_per_100g' => 598, 'protein_per_100g' => 25, 'carbs_per_100g' => 20, 'fat_per_100g' => 51, 'source' => 'manual'],
            ['name' => 'Olive Oil', 'brand' => null, 'calories_per_100g' => 884, 'protein_per_100g' => 0, 'carbs_per_100g' => 0, 'fat_per_100g' => 100, 'source' => 'manual'],
            // Dairy
            ['name' => 'Whole Milk', 'brand' => null, 'calories_per_100g' => 61, 'protein_per_100g' => 3.2, 'carbs_per_100g' => 4.8, 'fat_per_100g' => 3.3, 'source' => 'manual'],
            ['name' => 'Cheddar Cheese', 'brand' => null, 'calories_per_100g' => 402, 'protein_per_100g' => 25, 'carbs_per_100g' => 1.3, 'fat_per_100g' => 33, 'source' => 'manual'],
            // Packaged
            ['name' => 'Protein Bar', 'brand' => 'Quest', 'calories_per_100g' => 370, 'protein_per_100g' => 41, 'carbs_per_100g' => 47, 'fat_per_100g' => 9, 'source' => 'manual'],
            ['name' => 'Granola', 'brand' => "Nature's Path", 'calories_per_100g' => 471, 'protein_per_100g' => 10, 'carbs_per_100g' => 68, 'fat_per_100g' => 18, 'source' => 'manual'],
        ];

        foreach ($foods as $food) {
            FoodItem::firstOrCreate(['name' => $food['name'], 'brand' => $food['brand']], $food);
        }
    }
}
