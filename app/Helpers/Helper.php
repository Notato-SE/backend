<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists("curAuth")) {
    function curAuth()
    {
        return Auth::user();
    }
}
