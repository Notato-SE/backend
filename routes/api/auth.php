<?php

use Illuminate\Support\Facades\Route;


$controller = "Auth\\AuthController";
Route::post("/login", "$controller@login");
Route::post("/sign-up", "$controller@signup");
Route::post("/refresh-token", "$controller@refreshToken");
Route::get("/forgot-password", "$controller@forgotPasswordCreate");
Route::post("/forgot-password", "$controller@forgotPassword");

Route::group(['middleware' => 'auth:api'], function () {
    $controller = "Auth\\AuthController";
    Route::put("/update-profile", "$controller@updateProfile");
    Route::put("/change-password", "$controller@changePassword");
    Route::get("/profile", "$controller@profile");
    // Route::delete("/delete-account", "$controller@deleteAccount");
});
