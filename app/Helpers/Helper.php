<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

if (!function_exists("curAuth")) {
    function curAuth()
    {
        return Auth::user();
    }
}

if (!function_exists("array_random")) {
    function array_random(array $arr, int $num)
    {
        if ($num < 1 || $num > count($arr)) {
            throw new OutOfBoundsException();
        }

        return $arr;
    }
}

if (!function_exists('throwAuthExp')) {
    function throwAuthExp($msg = null)
    {
        throw new AuthorizationException($msg);
    }
}
