<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\Meal;
use App\Models\MealItem;
use App\Services\ClaudeService;
use App\Services\OpenFoodFactsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $meals = Meal::where('user_id', $request->user()->id)
            ->with('items.foodItem')
            ->orderByDesc('logged_at')
            ->paginate(20);

        return Inertia::render('Meals/Index', ['meals' => $meals]);
    }

    public function create()
    {
        return Inertia::render('Meals/Create');
    }

    public function store(Request $request, ClaudeService $claude, OpenFoodFactsService $foodsService)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'meal_type'              => 'required|in:breakfast,lunch,dinner,snack',
            'logged_at'              => 'required|date',
            'items'                  => 'required|array|min:1',
            'items.*.method'         => 'required|in:search,ai',
            'items.*.food_item_id'   => 'nullable|exists:food_items,id',
            'items.*.description'    => 'nullable|string|max:500',
            'items.*.quantity_grams' => 'nullable|numeric|min:1',
        ]);

        $meal = Meal::create([
            'user_id'   => $request->user()->id,
            'name'      => $validated['name'],
            'meal_type' => $validated['meal_type'],
            'logged_at' => $validated['logged_at'],
        ]);

        foreach ($validated['items'] as $item) {
            if ($item['method'] === 'search' && ! empty($item['food_item_id'])) {
                $food      = FoodItem::findOrFail($item['food_item_id']);
                $nutrition = $food->calculateNutrition((float) $item['quantity_grams']);
                MealItem::create(array_merge(['meal_id' => $meal->id, 'food_item_id' => $food->id, 'quantity_grams' => $item['quantity_grams'], 'estimation_method' => 'search'], $nutrition));
            } else {
                $est = $claude->estimateMealNutrition($item['description']);
                MealItem::create([
                    'meal_id'           => $meal->id,
                    'description'       => $item['description'],
                    'calories'          => $est['calories'] ?? 0,
                    'protein'           => $est['protein_g'] ?? 0,
                    'carbs'             => $est['carbs_g'] ?? 0,
                    'fat'               => $est['fat_g'] ?? 0,
                    'estimation_method' => 'ai',
                ]);
            }
        }

        return redirect()->route('meals.index');
    }

    public function destroy(Meal $meal, Request $request)
    {
        abort_if($meal->user_id !== $request->user()->id, 403);
        $meal->delete();
        return back();
    }

    public function searchFood(Request $request, OpenFoodFactsService $foodsService)
    {
        $request->validate(['q' => 'required|string|min:2']);
        $results = $foodsService->search($request->q);
        foreach ($results as $item) {
            if (! empty($item['off_id'])) $foodsService->findOrCreate($item);
        }
        // Attach local DB ids
        return response()->json(array_map(function ($item) {
            $local = FoodItem::where('off_id', $item['off_id'])->first();
            return array_merge($item, ['id' => $local?->id]);
        }, $results));
    }
}
