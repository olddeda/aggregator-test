<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('news:source:parse')->hourly();
Schedule::command('auth:code:expires')->everyMinute();
