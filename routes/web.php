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
Route::get('/centers_list', [CenterController::class, "index"])->name("centers_list");
Route::get('/centers_desactivated_list', [CenterController::class, "index_desactivatedCenters"])->name("centers_desactivated_list");
Route::get('/center/activate/{center}', [CenterController::class, 'activateStatus'])->name('center_activate');
Route::get('/center/desactivate/{center}', [CenterController::class, 'desactivateStatus'])->name('center_desactivate');
// Route::get('/center/center_edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
Route::get('/centers/downloadCSV/{status}', [CenterController::class, 'downloadCSV'])->name('centers.downloadCSV');

/* ROUTES FOR PROFESSIONAL REGISTRATION FORMS */
Route::get('/professional_form', [ProfessionalController::class, "create"])->name("professional_form");
Route::post('/professional_add', [ProfessionalController::class, "store"])->name("professional_add");
Route::get('/professionals_list', [ProfessionalController::class, "index"])->name("professionals_list");
Route::get('/professionals_desactivated_list', [ProfessionalController::class, "index_desactivatedCenters"])->name("professionals_desactivated_list");

Route::get('/professional/activate/{professional_id}', [ProfessionalController::class, 'activateStatus'])->name('professional_activate');
Route::get('/professional/desactivate/{professional_id}', [ProfessionalController::class, 'desactivateStatus'])->name('professional_desactivate');

Route::post('/professional_update/{id}', [ProfessionalController::class, "update"])->name("professional_update");
Route::get('/professional_edit/{id}', [ProfessionalController::class, "edit"])->name("professional_edit");
Route::get('/professionals/downloadCSV/{status}', [ProfessionalController::class, 'downloadCSV'])->name('professionals.downloadCSV');
Route::get('/professionals/downloadCSVlockers', [ProfessionalController::class, 'downloadCSVlockers'])->name('professionals.downloadCSVlockers');


// Routes for uniform records
Route::get('/uniform_records_list', [UniformRecordController::class, "index"])->name("uniform_records_list");

Route::post('/uniform_record_update/{id}', [UniformRecordController::class, "update"])->name("uniform_record_update");
Route::get('/uniform_record_edit/{id}', [UniformRecordController::class, "edit"])->name("uniform_record_edit");
Route::get('/uniform_records/downloadCSV', [UniformRecordController::class, 'downloadCSV'])->name('uniform_records.downloadCSV');