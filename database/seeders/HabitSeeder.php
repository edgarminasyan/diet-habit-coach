<?php

namespace Database\Seeders;

use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class HabitSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@dietcoach.com')->first();
        if (! $user) {
            return;
        }

        $habits = [
            ['name' => 'Drink 2L of water', 'description' => 'Stay properly hydrated throughout the day', 'reminder_time' => '08:00'],
            ['name' => 'Morning walk (20 min)', 'description' => 'Light movement to start the day', 'reminder_time' => '07:00'],
            ['name' => 'No sugar after 8pm', 'description' => 'Avoid late-night sweets and desserts', 'reminder_time' => '20:00'],
            ['name' => 'Log all meals', 'description' => 'Track every meal including snacks', 'reminder_time' => '21:00'],
            ['name' => 'Eat 5 portions of veg/fruit', 'description' => 'Ensure adequate micronutrient intake', 'reminder_time' => '17:00'],
            ['name' => 'No alcohol', 'description' => 'Alcohol-free week challenge', 'reminder_time' => null],
            ['name' => 'Sleep by 11pm', 'description' => 'Consistent sleep schedule for recovery', 'reminder_time' => '22:30'],
        ];

        $createdHabits = [];
        foreach ($habits as $habitData) {
            $habit = Habit::create(array_merge($habitData, ['user_id' => $user->id, 'is_active' => true]));
            $createdHabits[] = $habit;
        }

        // Completion patterns (realistic): mostly consistent with occasional misses
        // habit index => [days_ago => completed]
        $completionPatterns = [
            0 => [14=>1,13=>1,12=>1,11=>0,10=>1,9=>1,8=>1,7=>1,6=>1,5=>0,4=>1,3=>1,2=>1,1=>1], // water: 1 miss
            1 => [14=>1,13=>1,12=>0,11=>1,10=>1,9=>0,8=>1,7=>1,6=>1,5=>1,4=>0,3=>1,2=>1,1=>1], // morning walk: 3 misses
            2 => [14=>1,13=>0,12=>1,11=>1,10=>1,9=>1,8=>1,7=>0,6=>1,5=>1,4=>1,3=>1,2=>0,1=>1], // no sugar: 3 misses
            3 => [14=>1,13=>1,12=>1,11=>1,10=>1,9=>1,8=>1,7=>1,6=>1,5=>1,4=>1,3=>1,2=>1,1=>1], // log meals: perfect
            4 => [14=>1,13=>0,12=>1,11=>1,10=>0,9=>1,8=>1,7=>1,6=>0,5=>1,4=>1,3=>1,2=>1,1=>1], // 5 portions: 3 misses
            5 => [14=>1,13=>1,12=>1,11=>1,10=>1,9=>1,8=>0,7=>1,6=>1,5=>1,4=>1,3=>1,2=>1,1=>1], // no alcohol: 1 miss
            6 => [14=>0,13=>1,12=>1,11=>1,10=>0,9=>1,8=>1,7=>1,6=>0,5=>1,4=>1,3=>0,2=>1,1=>1], // sleep: 4 misses
        ];

        foreach ($createdHabits as $i => $habit) {
            $pattern = $completionPatterns[$i] ?? [];
            foreach ($pattern as $daysAgo => $completed) {
                HabitLog::create([
                    'habit_id'    => $habit->id,
                    'user_id'     => $user->id,
                    'logged_date' => now()->subDays($daysAgo)->toDateString(),
                    'completed'   => (bool) $completed,
                ]);
            }
        }
    }
}
