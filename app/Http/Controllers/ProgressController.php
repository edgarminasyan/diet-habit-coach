<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Meal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgressController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $from = now()->subDays(30);

        $caloriesByDay = Meal::where('user_id', $user->id)
            ->where('logged_at', '>=', $from)
            ->with('items')
            ->get()
            ->groupBy(fn($m) => $m->logged_at->toDateString())
            ->map(fn($meals) => [
                'calories' => round($meals->sum(fn($m) => $m->items->sum('calories'))),
                'meals'    => $meals->count(),
            ]);

        $habitCompletion = Habit::where('user_id', $user->id)
            ->where('is_active', true)
            ->get()
            ->map(fn($h) => [
                'name'            => $h->name,
                'completion_rate' => round($h->logs()->where('logged_date', '>=', $from->toDateString())->where('completed', true)->count() / 30 * 100),
                'streak'          => $h->streak,
            ]);

        return Inertia::render('Progress/Index', [
            'calories_by_day'  => $caloriesByDay,
            'habit_completion' => $habitCompletion,
            'calorie_goal'     => $user->daily_calorie_goal,
        ]);
    }
}
