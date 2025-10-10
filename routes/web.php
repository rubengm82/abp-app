<?php

use App\Http\Controllers\CenterController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProjectCommissionController;
use App\Http\Controllers\ProjectCommissionNoteController;
use App\Http\Controllers\ProjectCommissionDocumentController;
use App\Http\Controllers\MaterialAssignmentController;
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
Route::post('/center/{center}', [CenterController::class, "update"])->name("center_update");
Route::get('/center/center_edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
Route::get('/center_show/{id}', [CenterController::class, "show"])->name("center_show");
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
Route::get('/professional_show/{id}', [ProfessionalController::class, "show"])->name("professional_show");
Route::get('/professionals/downloadCSV/material-assignments', [ProfessionalController::class, 'downloadCSVMaterialAssignments'])->name('professionals.downloadCSV.materialAssignments');
Route::get('/professionals/downloadCSV/{status}', [ProfessionalController::class, 'downloadCSV'])->name('professionals.downloadCSV');

/* ROUTES FOR PROJECT/COMMISSION REGISTRATION FORMS */
Route::get('/projectcommission_form', [ProjectCommissionController::class, "create"])->name("projectcommission_form");
Route::post('/projectcommission_add', [ProjectCommissionController::class, "store"])->name("projectcommission_add");
Route::get('/projectcommissions_list', [ProjectCommissionController::class, "index"])->name("projectcommissions_list");
Route::get('/projectcommissions_desactivated_list', [ProjectCommissionController::class, "indexDesactivated"])->name("projectcommissions_desactivated_list"); //REVISAR
Route::get('/projectcommission/activate/{projectCommission}', [ProjectCommissionController::class, 'activateStatus'])->name('projectcommission_activate'); //REVISAR
Route::get('/projectcommission/desactivate/{projectCommission}', [ProjectCommissionController::class, 'desactivateStatus'])->name('projectcommission_desactivate'); //REVISAR
Route::post('/projectcommission/{projectCommission}', [ProjectCommissionController::class, "update"])->name("projectcommission_update"); //REVISAR
Route::get('/projectcommission/show/{projectCommission}', [ProjectCommissionController::class, 'show'])->name('projectcommission_show');
Route::get('/projectcommission/edit/{projectCommission}', [ProjectCommissionController::class, 'edit'])->name('projectcommission_edit');
Route::get('/projectcommissions/downloadCSV/{status}', [ProjectCommissionController::class, 'downloadCSV'])->name('projectcommissions.downloadCSV');

/* ROUTES FOR PROJECT/COMMISSION NOTES REVISAR */ 
Route::post('/projectcommission/{projectCommission}/notes', [ProjectCommissionNoteController::class, 'store'])->name('projectcommission_note_add');
Route::put('/projectcommission/notes/{note}', [ProjectCommissionNoteController::class, 'update'])->name('projectcommission_note_update');
Route::delete('/projectcommission/notes/{note}', [ProjectCommissionNoteController::class, 'destroy'])->name('projectcommission_note_delete');

/* ROUTES FOR PROJECT/COMMISSION DOCUMENTS */ 
Route::post('/projectcommission/{projectCommission}/documents', [ProjectCommissionDocumentController::class, 'store'])->name('projectcommission_document_add');
Route::delete('/projectcommission/documents/{document}', [ProjectCommissionDocumentController::class, 'destroy'])->name('projectcommission_document_delete');
Route::get('/projectcommission/documents/{document}/download', [ProjectCommissionDocumentController::class, 'download'])->name('projectcommission_document_download');




/* ROUTES FOR MATERIAL ASSIGNMENTS */ 
Route::get('/materialassignments/list', [MaterialAssignmentController::class, 'index'])->name('materialassignments_list');
Route::get('/materialassignment/form', [MaterialAssignmentController::class, 'create'])->name('materialassignment_form');
Route::post('/materialassignment/store', [MaterialAssignmentController::class, 'store'])->name('materialassignment_store');
Route::get('/materialassignment/show/{materialAssignment}', [MaterialAssignmentController::class, 'show'])->name('materialassignment_show');
Route::get('/materialassignment/edit/{materialAssignment}', [MaterialAssignmentController::class, 'edit'])->name('materialassignment_edit');
Route::put('/materialassignment/update/{materialAssignment}', [MaterialAssignmentController::class, 'update'])->name('materialassignment_update');
Route::delete('/materialassignment/delete/{materialAssignment}', [MaterialAssignmentController::class, 'destroy'])->name('materialassignment_delete');
Route::get('/materialassignment/downloadCSV', [MaterialAssignmentController::class, 'downloadCSV'])->name('materialassignment_downloadCSV');

//TODO: Implement routes for uniform records
// Routes for uniform records
// Route::get('/uniform_records_list', [UniformRecordController::class, "index"])->name("uniform_records_list");

// Route::post('/uniform_record_update/{id}', [UniformRecordController::class, "update"])->name("uniform_record_update");
// Route::get('/uniform_record_edit/{id}', [UniformRecordController::class, "edit"])->name("uniform_record_edit");
// Route::get('/uniform_records/downloadCSV', [UniformRecordController::class, 'downloadCSV'])->name('uniform_records.downloadCSV');


