<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('news', function ($user) {
    return true;
});

Broadcast::channel('users', function ($user) {
    return true;
});
