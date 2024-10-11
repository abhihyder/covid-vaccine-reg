<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Schedule the reminder command to run every day at 9 PM
Schedule::call(function () {
    Artisan::call('schedule:send-reminder');
})->dailyAt('21:00');
