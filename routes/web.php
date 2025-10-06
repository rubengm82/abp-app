<?php

use App\Http\Controllers\CenterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* ROUTES FOR CENTER REGISTRATION FORMS */
Route::get('/center_form', [CenterController::class, "create"])->name("center_form");
Route::post('/center_add', [CenterController::class, "store"])->name("center_add");

