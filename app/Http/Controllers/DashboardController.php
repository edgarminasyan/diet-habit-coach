<?php

namespace App\Http\Controllers;

use App\Models\AiInsight;
use App\Models\Habit;
use App\Models\Meal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user  = $request->user();
        $today = today();

        $todayMeals = Meal::where('user_id', $user->id)
            ->whereDate('logged_at', $today)
            ->with('items')
            ->get();

        $habits = Habit::where('user_id', $user->id)
            ->where('is_active', true)
            ->get()
            ->map(fn($h) => [
                'id'        => $h->id,
                'name'      => $h->name,
                'completed' => $h->isCompletedToday(),
                'streak'    => $h->streak,
            ]);

        return Inertia::render('Dashboard', [
            'today' => [
                'calories'   => round($todayMeals->sum(fn($m) => $m->items->sum('calories'))),
                'protein'    => round($todayMeals->sum(fn($m) => $m->items->sum('protein')), 1),
                'carbs'      => round($todayMeals->sum(fn($m) => $m->items->sum('carbs')), 1),
                'fat'        => round($todayMeals->sum(fn($m) => $m->items->sum('fat')), 1),
                'meal_count' => $todayMeals->count(),
            ],
            'calorie_goal'    => $user->daily_calorie_goal,
            'habits'          => $habits,
            'unread_insights' => AiInsight::where('user_id', $user->id)->whereNull('read_at')->count(),
        ]);
    }
}
