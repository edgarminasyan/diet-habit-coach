<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\FoodItem;

class OpenFoodFactsService
{
    private string $baseUrl = 'https://world.openfoodfacts.org';

    public function search(string $query, int $limit = 10): array
    {
        $response = Http::timeout(6)->get("{$this->baseUrl}/cgi/search.pl", [
            'search_terms' => $query,
            'search_simple' => 1,
            'action' => 'process',
            'json' => 1,
            'page_size' => $limit,
            'fields' => 'id,product_name,brands,nutriments',
        ]);

        if (! $response->ok()) return [];

        return collect($response->json('products', []))
            ->filter(fn($p) => ! empty($p['product_name']) && isset($p['nutriments']['energy-kcal_100g']))
            ->map(fn($p) => [
                'off_id'            => $p['id'] ?? null,
                'name'              => $p['product_name'],
                'brand'             => $p['brands'] ?? null,
                'calories_per_100g' => round($p['nutriments']['energy-kcal_100g'] ?? 0, 1),
                'protein_per_100g'  => round($p['nutriments']['proteins_100g'] ?? 0, 1),
                'carbs_per_100g'    => round($p['nutriments']['carbohydrates_100g'] ?? 0, 1),
                'fat_per_100g'      => round($p['nutriments']['fat_100g'] ?? 0, 1),
            ])
            ->values()
            ->toArray();
    }

    public function findOrCreate(array $data): FoodItem
    {
        return FoodItem::firstOrCreate(
            ['off_id' => $data['off_id']],
            array_merge($data, ['source' => 'openfoodfacts'])
        );
    }
}
