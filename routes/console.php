<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Automatically sync social media feeds (YouTube, X, Facebook, Instagram) every 30 minutes
Schedule::command('social:sync')->everyThirtyMinutes();
