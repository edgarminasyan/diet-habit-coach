<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealItem extends Model
{
    protected $fillable = [
        'meal_id','food_item_id','description',
        'quantity_grams','calories','protein','carbs','fat','estimation_method',
    ];

    protected $casts = [
        'calories' => 'float', 'protein' => 'float',
        'carbs' => 'float', 'fat' => 'float',
    ];

    public function meal(): BelongsTo { return $this->belongsTo(Meal::class); }
    public function foodItem(): BelongsTo { return $this->belongsTo(FoodItem::class); }
}
