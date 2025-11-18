<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('orders.new', function ($user) {
    return $user != null;
});