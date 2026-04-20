<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Habit;
use App\Models\Meal;
use App\Models\AiInsight;
use App\Services\ClaudeService;
use Illuminate\Console\Command;

class GenerateWeeklyInsights extends Command
{
    protected $signature   = 'insights:generate-weekly';
    protected $description = 'Generate weekly AI coaching insights for all active users';

    public function handle(ClaudeService $claude): void
    {
        $from = now()->subDays(7);

        User::all()->each(function (User $user) use ($claude, $from) {
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

            if (empty($meals) && empty($habits)) return;

            $content = $claude->generateWeeklyInsight($meals, $habits);
            AiInsight::create(['user_id' => $user->id, 'type' => 'weekly_summary', 'content' => $content]);
            $this->info("Generated insight for {$user->email}");
        });
    }
}
