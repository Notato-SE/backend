<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    $controller = "Randomizer\\RandomizerController";
    Route::post("/randomizer", "$controller@random");
    Route::post("/randomizer/save", "$controller@save");
    Route::get("randomizer/me", "$controller@getUserSavedList");
    Route::get("randomizer", "$controller@getRandomResults");
    Route::get("randomizer/{randomizer}", "$controller@getRandomResultByID");
    Route::get("randomizer/export/{id}", "$controller@export")->name('randomizer.export');
});
