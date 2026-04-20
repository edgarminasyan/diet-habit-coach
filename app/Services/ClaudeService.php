<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ClaudeService
{
    private string $baseUrl = 'https://api.anthropic.com/v1';

    private function post(string $model, string $system, string $userMessage, int $maxTokens = 500): string
    {
        $response = Http::withHeaders([
            'x-api-key'         => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->post("{$this->baseUrl}/messages", [
            'model'      => $model,
            'max_tokens' => $maxTokens,
            'system'     => $system,
            'messages'   => [['role' => 'user', 'content' => $userMessage]],
        ]);

        return $response->json('content.0.text', '');
    }

    public function estimateMealNutrition(string $description): array
    {
        $text = $this->post(
            'claude-haiku-4-5-20251001',
            'You are a nutritionist AI. Respond ONLY with a valid JSON object: {"name":"...","calories":0,"protein_g":0,"carbs_g":0,"fat_g":0}. No other text.',
            "Estimate nutrition for: {$description}",
            300
        );

        return json_decode($text, true) ?? [
            'name' => $description, 'calories' => 0,
            'protein_g' => 0, 'carbs_g' => 0, 'fat_g' => 0,
        ];
    }

    public function generateWeeklyInsight(array $meals, array $habits): string
    {
        $mealSummary  = collect($meals)->map(fn($m) => "{$m['name']}: {$m['calories']} kcal")->implode(', ');
        $habitSummary = collect($habits)->map(fn($h) => "{$h['name']}: {$h['completion_rate']}%")->implode(', ');

        return $this->post(
            'claude-sonnet-4-6',
            'You are a supportive diet and habit coach. Give concise, actionable, encouraging weekly insights in 3-4 sentences.',
            "Meals this week: {$mealSummary}. Habits: {$habitSummary}. Give insights and suggestions.",
            600
        );
    }

    public function detectPatterns(array $mealHistory): string
    {
        $summary = collect($mealHistory)
            ->map(fn($d) => "{$d['date']}: {$d['total_calories']} kcal, {$d['meal_count']} meals")
            ->implode("\n");

        return $this->post(
            'claude-haiku-4-5-20251001',
            'You are a diet coach. Identify eating patterns in 2-3 sentences. Be concise and supportive.',
            "Analyze these eating patterns:\n{$summary}",
            400
        );
    }
}
