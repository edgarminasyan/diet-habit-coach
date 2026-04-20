<?php

namespace App\Services;

use Anthropic\Anthropic;

class ClaudeService
{
    private $client;

    public function __construct()
    {
        $this->client = Anthropic::client(config('services.anthropic.key'));
    }

    public function estimateMealNutrition(string $description): array
    {
        $response = $this->client->messages()->create([
            'model' => 'claude-haiku-4-5-20251001',
            'max_tokens' => 300,
            'system' => 'You are a nutritionist AI. Respond ONLY with a valid JSON object: {"name":"...","calories":0,"protein_g":0,"carbs_g":0,"fat_g":0}. No other text.',
            'messages' => [['role' => 'user', 'content' => "Estimate nutrition for: {$description}"]],
        ]);

        return json_decode($response->content[0]->text, true) ?? [
            'name' => $description, 'calories' => 0,
            'protein_g' => 0, 'carbs_g' => 0, 'fat_g' => 0,
        ];
    }

    public function generateWeeklyInsight(array $meals, array $habits): string
    {
        $mealSummary  = collect($meals)->map(fn($m) => "{$m['name']}: {$m['calories']} kcal")->implode(', ');
        $habitSummary = collect($habits)->map(fn($h) => "{$h['name']}: {$h['completion_rate']}%")->implode(', ');

        $response = $this->client->messages()->create([
            'model' => 'claude-sonnet-4-6',
            'max_tokens' => 600,
            'system' => 'You are a supportive diet and habit coach. Give concise, actionable, encouraging weekly insights in 3-4 sentences.',
            'messages' => [['role' => 'user', 'content' => "Meals this week: {$mealSummary}. Habits: {$habitSummary}. Give insights and suggestions."]],
        ]);

        return $response->content[0]->text;
    }

    public function detectPatterns(array $mealHistory): string
    {
        $summary = collect($mealHistory)
            ->map(fn($d) => "{$d['date']}: {$d['total_calories']} kcal, {$d['meal_count']} meals")
            ->implode("\n");

        $response = $this->client->messages()->create([
            'model' => 'claude-haiku-4-5-20251001',
            'max_tokens' => 400,
            'system' => 'You are a diet coach. Identify eating patterns in 2-3 sentences. Be concise and supportive.',
            'messages' => [['role' => 'user', 'content' => "Analyze these eating patterns:\n{$summary}"]],
        ]);

        return $response->content[0]->text;
    }
}
