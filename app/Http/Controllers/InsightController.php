<?php

namespace App\Http\Controllers;

use App\Models\AiInsight;
use App\Models\Habit;
use App\Models\Meal;
use App\Services\ClaudeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InsightController extends Controller
{
    public function index(Request $request)
    {
        $insights = AiInsight::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return Inertia::render('Insights/Index', ['insights' => $insights]);
    }

    public function generate(Request $request, ClaudeService $claude)
    {
        $user = $request->user();
        $from = now()->subDays(7);

        $meals = Meal::where('user_id', $user->id)
            ->where('logged_at', '>=', $from)
            ->with('items')
            ->get()
            ->map(fn($m) => ['name' => $m->name, 'calories' => round($m->items->sum('calories'))])
            ->toArray();

        $habits = Habit::where('user_id', $user->id)
            ->where('is_active', true)
            ->get()
            ->map(fn($h) => [
                'name'            => $h->name,
                'completion_rate' => round($h->logs()->where('logged_date', '>=', $from->toDateString())->where('completed', true)->count() / 7 * 100),
            ])
            ->toArray();

        $content = $claude->generateWeeklyInsight($meals, $habits);

        AiInsight::create(['user_id' => $user->id, 'type' => 'weekly_summary', 'content' => $content]);

        return back();
    }

    public function markRead(AiInsight $insight, Request $request)
    {
        abort_if($insight->user_id !== $request->user()->id, 403);
        $insight->markAsRead();
        return back();
    }
}
