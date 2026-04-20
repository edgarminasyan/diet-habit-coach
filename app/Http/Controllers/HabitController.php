<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HabitController extends Controller
{
    public function index(Request $request)
    {
        $habits = Habit::where('user_id', $request->user()->id)
            ->where('is_active', true)
            ->get()
            ->map(fn($h) => [
                'id'          => $h->id,
                'name'        => $h->name,
                'description' => $h->description,
                'completed'   => $h->isCompletedToday(),
                'streak'      => $h->streak,
            ]);

        return Inertia::render('Habits/Index', ['habits' => $habits]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:500',
            'reminder_time' => 'nullable|date_format:H:i',
        ]);
        Habit::create(['user_id' => $request->user()->id] + $validated);
        return back();
    }

    public function destroy(Habit $habit, Request $request)
    {
        abort_if($habit->user_id !== $request->user()->id, 403);
        $habit->update(['is_active' => false]);
        return back();
    }

    public function log(Habit $habit, Request $request)
    {
        abort_if($habit->user_id !== $request->user()->id, 403);
        HabitLog::updateOrCreate(
            ['habit_id' => $habit->id, 'logged_date' => today()],
            ['user_id' => $request->user()->id, 'completed' => true]
        );
        return back();
    }

    public function unlog(Habit $habit, Request $request)
    {
        abort_if($habit->user_id !== $request->user()->id, 403);
        HabitLog::where('habit_id', $habit->id)->whereDate('logged_date', today())->delete();
        return back();
    }
}
