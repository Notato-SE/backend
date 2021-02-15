<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    $controller = "Randomizer\\RandomizerController";
    Route::post("/randomizer", "$controller@random");
    Route::post("/randomizer/save", "$controller@save");
    Route::get("randomizer", "$controller@getRandomResults");
    Route::get("randomizer/{id}", "$controller@getRandomResultByID");
});