<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\Meal;
use App\Models\MealItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@dietcoach.com')->first();
        if (! $user) {
            return;
        }

        $fi = FoodItem::pluck('id', 'name');

        $mealPlans = [
            // [days_ago, meal_type, name, [[food_name, grams], ...]]
            [14, 'breakfast', 'Oatmeal with Berries', [['Oats (rolled, dry)', 80], ['Blueberries', 60], ['Whole Milk', 120]]],
            [14, 'lunch',     'Chicken & Rice Bowl', [['Chicken Breast (cooked)', 180], ['Brown Rice (cooked)', 200], ['Broccoli (raw)', 100]]],
            [14, 'dinner',    'Salmon with Sweet Potato', [['Salmon (baked)', 200], ['Sweet Potato (baked)', 180], ['Spinach (raw)', 80]]],
            [14, 'snack',     'Greek Yogurt & Almonds', [['Greek Yogurt (0% fat)', 150], ['Almonds', 25]]],

            [13, 'breakfast', 'Scrambled Eggs on Toast', [['Eggs (whole)', 150], ['Whole Wheat Bread', 60]]],
            [13, 'lunch',     'Tuna Salad', [['Tuna (canned in water)', 140], ['Mixed Salad Greens', 80], ['Cucumber', 60], ['Avocado', 50]]],
            [13, 'dinner',    'Beef Stir Fry', [['Beef (lean ground, 90%)', 200], ['White Rice (cooked)', 180], ['Bell Pepper (red)', 100], ['Broccoli (raw)', 80]]],
            [13, 'snack',     'Protein Bar', [['Protein Bar', 60]]],

            [12, 'breakfast', 'Banana Oatmeal', [['Oats (rolled, dry)', 70], ['Banana', 120], ['Peanut Butter (natural)', 20]]],
            [12, 'lunch',     'Turkey Wrap', [['Turkey Breast (deli)', 120], ['Whole Wheat Bread', 80], ['Mixed Salad Greens', 40], ['Bell Pepper (red)', 60]]],
            [12, 'dinner',    'Pasta with Ground Beef', [['Pasta (cooked)', 220], ['Beef (lean ground, 90%)', 150], ['Spinach (raw)', 60]]],
            [12, 'snack',     'Apple & Peanut Butter', [['Apple', 180], ['Peanut Butter (natural)', 30]]],

            [11, 'breakfast', 'Greek Yogurt Parfait', [['Greek Yogurt (0% fat)', 200], ['Granola', 40], ['Strawberries', 80]]],
            [11, 'lunch',     'Quinoa Bowl', [['Quinoa (cooked)', 200], ['Chicken Breast (cooked)', 150], ['Avocado', 60], ['Spinach (raw)', 60]]],
            [11, 'dinner',    'Baked Salmon & Greens', [['Salmon (baked)', 220], ['Mixed Salad Greens', 100], ['Cucumber', 80]]],
            [11, 'snack',     'Cottage Cheese', [['Cottage Cheese', 150], ['Blueberries', 50]]],

            [10, 'breakfast', 'Eggs & Avocado Toast', [['Eggs (whole)', 150], ['Whole Wheat Bread', 80], ['Avocado', 70]]],
            [10, 'lunch',     'Chicken Salad', [['Chicken Breast (cooked)', 160], ['Mixed Salad Greens', 100], ['Bell Pepper (red)', 80], ['Olive Oil', 10]]],
            [10, 'dinner',    'Ground Beef & Sweet Potato', [['Beef (lean ground, 90%)', 200], ['Sweet Potato (baked)', 200], ['Broccoli (raw)', 100]]],
            [10, 'snack',     'Mixed Nuts & Fruit', [['Almonds', 30], ['Orange', 130]]],

            [9, 'breakfast', 'Overnight Oats', [['Oats (rolled, dry)', 80], ['Greek Yogurt (0% fat)', 100], ['Strawberries', 80]]],
            [9, 'lunch',     'Tuna Pasta Salad', [['Tuna (canned in water)', 120], ['Pasta (cooked)', 150], ['Cucumber', 60], ['Bell Pepper (red)', 60]]],
            [9, 'dinner',    'Chicken Rice Bowl', [['Chicken Breast (cooked)', 200], ['White Rice (cooked)', 200], ['Spinach (raw)', 80]]],
            [9, 'snack',     'Banana & Peanut Butter', [['Banana', 120], ['Peanut Butter (natural)', 20]]],

            [8, 'breakfast', 'Protein Shake & Granola', [['Greek Yogurt (0% fat)', 200], ['Granola', 50], ['Blueberries', 80]]],
            [8, 'lunch',     'Turkey & Quinoa Bowl', [['Turkey Breast (deli)', 130], ['Quinoa (cooked)', 180], ['Mixed Salad Greens', 80]]],
            [8, 'dinner',    'Salmon Pasta', [['Salmon (baked)', 180], ['Pasta (cooked)', 200], ['Spinach (raw)', 60]]],
            [8, 'snack',     'Cheese & Apple', [['Cheddar Cheese', 40], ['Apple', 150]]],

            [7, 'breakfast', 'Classic Scramble', [['Eggs (whole)', 180], ['Bell Pepper (red)', 60], ['Cheddar Cheese', 30]]],
            [7, 'lunch',     'Big Salad', [['Mixed Salad Greens', 120], ['Chicken Breast (cooked)', 150], ['Avocado', 70], ['Cucumber', 80]]],
            [7, 'dinner',    'Beef & Brown Rice', [['Beef (lean ground, 90%)', 200], ['Brown Rice (cooked)', 200], ['Broccoli (raw)', 120]]],
            [7, 'snack',     'Cottage Cheese & Berries', [['Cottage Cheese', 150], ['Strawberries', 80]]],

            [6, 'breakfast', 'Banana Pancake Oats', [['Oats (rolled, dry)', 90], ['Banana', 100], ['Eggs (whole)', 100]]],
            [6, 'lunch',     'Chicken & Avocado Wrap', [['Chicken Breast (cooked)', 160], ['Whole Wheat Bread', 80], ['Avocado', 60], ['Mixed Salad Greens', 40]]],
            [6, 'dinner',    'Sweet Potato & Salmon', [['Salmon (baked)', 200], ['Sweet Potato (baked)', 200]]],
            [6, 'snack',     'Greek Yogurt & Granola', [['Greek Yogurt (0% fat)', 170], ['Granola', 40]]],

            [5, 'breakfast', 'Egg White Omelette', [['Eggs (whole)', 200], ['Spinach (raw)', 60], ['Bell Pepper (red)', 70]]],
            [5, 'lunch',     'Rice & Turkey Bowl', [['White Rice (cooked)', 180], ['Turkey Breast (deli)', 140], ['Broccoli (raw)', 100]]],
            [5, 'dinner',    'Quinoa & Chicken Stir Fry', [['Quinoa (cooked)', 200], ['Chicken Breast (cooked)', 180], ['Bell Pepper (red)', 80], ['Spinach (raw)', 60]]],
            [5, 'snack',     'Almonds & Blueberries', [['Almonds', 30], ['Blueberries', 80]]],

            [4, 'breakfast', 'Oatmeal with Banana', [['Oats (rolled, dry)', 80], ['Banana', 120], ['Whole Milk', 100]]],
            [4, 'lunch',     'Tuna & Avocado Bowl', [['Tuna (canned in water)', 140], ['Avocado', 80], ['Mixed Salad Greens', 80], ['Brown Rice (cooked)', 150]]],
            [4, 'dinner',    'Pasta Bolognese', [['Pasta (cooked)', 240], ['Beef (lean ground, 90%)', 180], ['Spinach (raw)', 60]]],
            [4, 'snack',     'Protein Bar & Orange', [['Protein Bar', 60], ['Orange', 130]]],

            [3, 'breakfast', 'Yogurt & Berry Bowl', [['Greek Yogurt (0% fat)', 200], ['Blueberries', 80], ['Strawberries', 60], ['Granola', 30]]],
            [3, 'lunch',     'Chicken & Veggie Rice', [['Chicken Breast (cooked)', 180], ['Brown Rice (cooked)', 180], ['Broccoli (raw)', 100], ['Bell Pepper (red)', 60]]],
            [3, 'dinner',    'Salmon & Quinoa', [['Salmon (baked)', 200], ['Quinoa (cooked)', 180], ['Mixed Salad Greens', 80]]],
            [3, 'snack',     'Peanut Butter Toast', [['Whole Wheat Bread', 60], ['Peanut Butter (natural)', 30]]],

            [2, 'breakfast', 'Scrambled Eggs & Toast', [['Eggs (whole)', 150], ['Whole Wheat Bread', 70], ['Avocado', 50]]],
            [2, 'lunch',     'Turkey Pasta Salad', [['Turkey Breast (deli)', 120], ['Pasta (cooked)', 160], ['Cucumber', 70], ['Mixed Salad Greens', 60]]],
            [2, 'dinner',    'Beef & Sweet Potato Bowl', [['Beef (lean ground, 90%)', 200], ['Sweet Potato (baked)', 200], ['Spinach (raw)', 80]]],
            [2, 'snack',     'Cottage Cheese & Apple', [['Cottage Cheese', 150], ['Apple', 160]]],

            [1, 'breakfast', 'Morning Oats', [['Oats (rolled, dry)', 80], ['Blueberries', 80], ['Greek Yogurt (0% fat)', 100]]],
            [1, 'lunch',     'Chicken Caesar Salad', [['Chicken Breast (cooked)', 180], ['Mixed Salad Greens', 120], ['Cheddar Cheese', 30], ['Olive Oil', 10]]],
            [1, 'dinner',    'Salmon Stir Fry', [['Salmon (baked)', 200], ['Broccoli (raw)', 120], ['White Rice (cooked)', 180]]],
            [1, 'snack',     'Almonds & Banana', [['Almonds', 25], ['Banana', 120]]],
        ];

        $mealHours = ['breakfast' => 7, 'lunch' => 12, 'dinner' => 19, 'snack' => 15];

        foreach ($mealPlans as [$daysAgo, $type, $name, $items]) {
            $loggedAt = now()->subDays($daysAgo)->setHour($mealHours[$type])->setMinute(0)->setSecond(0);

            $meal = Meal::create([
                'user_id'   => $user->id,
                'name'      => $name,
                'meal_type' => $type,
                'logged_at' => $loggedAt,
            ]);

            foreach ($items as [$foodName, $grams]) {
                $foodId = $fi[$foodName] ?? null;
                if (! $foodId) {
                    continue;
                }
                $food = FoodItem::find($foodId);
                $ratio = $grams / 100;

                MealItem::create([
                    'meal_id'           => $meal->id,
                    'food_item_id'      => $foodId,
                    'description'       => $foodName,
                    'quantity_grams'    => $grams,
                    'calories'          => round($food->calories_per_100g * $ratio, 1),
                    'protein'           => round($food->protein_per_100g * $ratio, 1),
                    'carbs'             => round($food->carbs_per_100g * $ratio, 1),
                    'fat'               => round($food->fat_per_100g * $ratio, 1),
                    'estimation_method' => 'search',
                ]);
            }
        }
    }
}
