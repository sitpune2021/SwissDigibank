<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Run daily at 00:10 AM
Schedule::command('rd:auto-credit-interest')->dailyAt('00:10');
// ->everyMinute();
