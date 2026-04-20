<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    protected $fillable = ['user_id','name','meal_type','notes','logged_at'];
    protected $casts = ['logged_at' => 'datetime'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function items(): HasMany { return $this->hasMany(MealItem::class); }

    public function getTotalCaloriesAttribute(): float { return $this->items->sum('calories'); }
    public function getTotalProteinAttribute(): float  { return $this->items->sum('protein'); }
    public function getTotalCarbsAttribute(): float    { return $this->items->sum('carbs'); }
    public function getTotalFatAttribute(): float      { return $this->items->sum('fat'); }
}
