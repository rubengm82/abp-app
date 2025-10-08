<?php

use App\Http\Controllers\CenterController;
use App\Http\Controllers\ProfessionalController;
use Illuminate\Support\Facades\Route;


/* ROUTES APP */
Route::get('/home', function () {
    return view('app');
})->name('home');


/* ROUTES LOGIN */
Route::get('/', function () {
    return view('login');
})->name('login');


/* ROUTES FOR CENTER REGISTRATION FORMS */
Route::get('/center_form', [CenterController::class, "create"])->name("center_form");
Route::post('/center_add', [CenterController::class, "store"])->name("center_add");
Route::get('/center/desactivate/{center}', [CenterController::class, 'desactivateStatus'])->name('center_desactivate');
Route::get('/center/activate/{center}', [CenterController::class, 'activateStatus'])->name('center_activate');
// Route::get('/center/center_edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
Route::get('/centers_list', [CenterController::class, "index"])->name("centers_list");
Route::get('/centers_desactivated_list', [CenterController::class, "index_desactivatedCenters"])->name("centers_desactivated_list");

/* ROUTES FOR PROFESSIONAL REGISTRATION FORMS */
Route::get('/professional_form', [ProfessionalController::class, "create"])->name("professional_form");
Route::post('/professional_add', [ProfessionalController::class, "store"])->name("professional_add");
