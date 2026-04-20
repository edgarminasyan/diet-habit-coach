<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
    protected $fillable = ['user_id','name','description','reminder_time','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function logs(): HasMany { return $this->hasMany(HabitLog::class); }

    public function isCompletedToday(): bool
    {
        return $this->logs()->whereDate('logged_date', today())->where('completed', true)->exists();
    }

    public function getStreakAttribute(): int
    {
        $streak = 0;
        $date = today();
        while ($this->logs()->whereDate('logged_date', $date)->where('completed', true)->exists()) {
            $streak++;
            $date = $date->copy()->subDay();
        }
        return $streak;
    }
}
