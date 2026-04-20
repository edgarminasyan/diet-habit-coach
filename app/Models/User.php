<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'timezone', 'daily_calorie_goal',
        'daily_protein_goal', 'daily_carbs_goal', 'daily_fat_goal',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function meals(): HasMany { return $this->hasMany(Meal::class); }
    public function habits(): HasMany { return $this->hasMany(Habit::class); }
    public function insights(): HasMany { return $this->hasMany(AiInsight::class); }
}
