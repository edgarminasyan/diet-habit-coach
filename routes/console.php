<?php

use Illuminate\Support\Facades\Schedule;

// Weekly insights — every Sunday at 8am
Schedule::command('insights:generate-weekly')->weeklyOn(0, '08:00');
