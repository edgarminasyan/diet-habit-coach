<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = [
        'off_id','name','brand',
        'calories_per_100g','protein_per_100g','carbs_per_100g','fat_per_100g','source',
    ];

    public function calculateNutrition(float $grams): array
    {
        $f = $grams / 100;
        return [
            'calories' => round($this->calories_per_100g * $f, 1),
            'protein'  => round($this->protein_per_100g * $f, 1),
            'carbs'    => round($this->carbs_per_100g * $f, 1),
            'fat'      => round($this->fat_per_100g * $f, 1),
        ];
    }
}
