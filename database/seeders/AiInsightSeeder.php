<?php

namespace Database\Seeders;

use App\Models\AiInsight;
use App\Models\User;
use Illuminate\Database\Seeder;

class AiInsightSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@dietcoach.com')->first();
        if (! $user) {
            return;
        }

        $insights = [
            [
                'type'       => 'pattern',
                'content'    => 'You consistently hit your protein goal on days you log a lunch containing chicken or tuna. Consider making high-protein lunches your anchor meal.',
                'created_at' => now()->subDays(12),
                'read_at'    => now()->subDays(11),
            ],
            [
                'type'       => 'suggestion',
                'content'    => 'Your vegetable intake drops on evenings when you have pasta for dinner. Try adding a side of spinach or broccoli to keep your fibre up.',
                'created_at' => now()->subDays(10),
                'read_at'    => now()->subDays(9),
            ],
            [
                'type'       => 'weekly_summary',
                'content'    => "Week 1 summary: You logged 27 out of 28 meals and completed 88% of your habits. Average daily intake was 1,980 kcal — just under your 2,000 kcal goal. Great consistency!",
                'created_at' => now()->subDays(7),
                'read_at'    => now()->subDays(6),
            ],
            [
                'type'       => 'pattern',
                'content'    => 'You tend to miss your "Sleep by 11pm" habit on Fridays and Saturdays. This correlates with higher calorie snacking the following morning.',
                'created_at' => now()->subDays(5),
                'read_at'    => now()->subDays(4),
            ],
            [
                'type'       => 'suggestion',
                'content'    => 'Your fat intake exceeds your daily goal on days you have salmon for both lunch and dinner. Consider swapping one serving with chicken breast to stay within range.',
                'created_at' => now()->subDays(3),
                'read_at'    => null,
            ],
            [
                'type'       => 'weekly_summary',
                'content'    => "Week 2 summary: 28/28 meals logged — perfect streak! Average daily intake: 2,050 kcal. Protein averaged 148 g/day, above your 140 g goal. Habit completion: 91%. Keep it up!",
                'created_at' => now()->subDays(1),
                'read_at'    => null,
            ],
        ];

        foreach ($insights as $data) {
            AiInsight::create(array_merge($data, ['user_id' => $user->id]));
        }
    }
}
