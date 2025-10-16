<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\CenterNoteController;
use App\Http\Controllers\CenterDocumentController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProfessionalNoteController;
use App\Http\Controllers\ProfessionalDocumentController;
use App\Http\Controllers\ProjectCommissionController;
use App\Http\Controllers\ProjectCommissionNoteController;
use App\Http\Controllers\ProjectCommissionDocumentController;
use App\Http\Controllers\MaterialAssignmentController;
use App\Http\Controllers\MaterialAssignmentNoteController;
use App\Http\Controllers\MaterialAssignmentDocumentController;
use Illuminate\Support\Facades\Route;

/* ------------------------ LOGIN ------------------------ */
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'show'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});

/* ------------------------ LOGOUT ------------------------ */
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/* ------------------------ HOME ------------------------ */
Route::middleware('auth')->get('/home', function () {
    return view('app');
})->name('home');

/* ------------------------ CENTERS ------------------------ */
Route::middleware('auth')->get('/center_form', [CenterController::class, "create"])->name("center_form");
Route::middleware('auth')->post('/center_add', [CenterController::class, "store"])->name("center_add");
Route::middleware('auth')->get('/centers_list', [CenterController::class, "index"])->name("centers_list");
Route::middleware('auth')->get('/centers_desactivated_list', [CenterController::class, "index_desactivatedCenters"])->name("centers_desactivated_list");
Route::middleware('auth')->get('/center/activate/{center}', [CenterController::class, 'activateStatus'])->name('center_activate');
Route::middleware('auth')->get('/center/desactivate/{center}', [CenterController::class, 'desactivateStatus'])->name('center_desactivate');
Route::middleware('auth')->post('/center/{center}', [CenterController::class, "update"])->name("center_update");
Route::middleware('auth')->get('/center/center_edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
Route::middleware('auth')->get('/center_show/{id}', [CenterController::class, "show"])->name("center_show");
Route::middleware('auth')->get('/centers/downloadCSV/{status}', [CenterController::class, 'downloadCSV'])->name('centers.downloadCSV');

/* Center Notes */
Route::middleware('auth')->post('/center/{center}/notes', [CenterNoteController::class, 'store'])->name('center_note_add');
Route::middleware('auth')->put('/center/notes/{note}', [CenterNoteController::class, 'update'])->name('center_note_update');
Route::middleware('auth')->delete('/center/notes/{note}', [CenterNoteController::class, 'destroy'])->name('center_note_delete');

/* Center Documents */
Route::middleware('auth')->post('/center/{center}/documents', [CenterDocumentController::class, 'store'])->name('center_document_add');
Route::middleware('auth')->delete('/center/documents/{document}', [CenterDocumentController::class, 'destroy'])->name('center_document_delete');
Route::middleware('auth')->get('/center/documents/{document}/download', [CenterDocumentController::class, 'download'])->name('center_document_download');

/* ------------------------ PROFESSIONALS ------------------------ */
Route::middleware('auth')->get('/professional_form', [ProfessionalController::class, "create"])->name("professional_form");
Route::middleware('auth')->post('/professional_add', [ProfessionalController::class, "store"])->name("professional_add");
Route::middleware('auth')->get('/professionals_list', [ProfessionalController::class, "index"])->name("professionals_list");
Route::middleware('auth')->get('/professionals_desactivated_list', [ProfessionalController::class, "index_desactivatedCenters"])->name("professionals_desactivated_list");
Route::middleware('auth')->get('/professional/activate/{professional_id}', [ProfessionalController::class, 'activateStatus'])->name('professional_activate');
Route::middleware('auth')->get('/professional/desactivate/{professional_id}', [ProfessionalController::class, 'desactivateStatus'])->name('professional_desactivate');
Route::middleware('auth')->post('/professional_update/{id}', [ProfessionalController::class, "update"])->name("professional_update");
Route::middleware('auth')->get('/professional_edit/{id}', [ProfessionalController::class, "edit"])->name("professional_edit");
Route::middleware('auth')->get('/professional_show/{id}', [ProfessionalController::class, "show"])->name("professional_show");
Route::middleware('auth')->get('/professionals/downloadCSV/material-assignments', [ProfessionalController::class, 'downloadCSVMaterialAssignments'])->name('professionals.downloadCSV.materialAssignments');
Route::middleware('auth')->get('/professionals/downloadCSV/{status}', [ProfessionalController::class, 'downloadCSV'])->name('professionals.downloadCSV');

/* Professional Notes */
Route::middleware('auth')->post('/professional/{professional}/notes', [ProfessionalNoteController::class, 'store'])->name('professional_note_add');
Route::middleware('auth')->put('/professional/notes/{note}', [ProfessionalNoteController::class, 'update'])->name('professional_note_update');
Route::middleware('auth')->delete('/professional/notes/{note}', [ProfessionalNoteController::class, 'destroy'])->name('professional_note_delete');

/* Professional Documents */
Route::middleware('auth')->post('/professional/{professional}/documents', [ProfessionalDocumentController::class, 'store'])->name('professional_document_add');
Route::middleware('auth')->delete('/professional/documents/{document}', [ProfessionalDocumentController::class, 'destroy'])->name('professional_document_delete');
Route::middleware('auth')->get('/professional/documents/{document}/download', [ProfessionalDocumentController::class, 'download'])->name('professional_document_download');

/* ------------------------ PROJECT COMMISSIONS ------------------------ */
Route::middleware('auth')->get('/projectcommission_form', [ProjectCommissionController::class, "create"])->name("projectcommission_form");
Route::middleware('auth')->post('/projectcommission_add', [ProjectCommissionController::class, "store"])->name("projectcommission_add");
Route::middleware('auth')->get('/projectcommissions_list', [ProjectCommissionController::class, "index"])->name("projectcommissions_list");
Route::middleware('auth')->get('/projectcommissions_desactivated_list', [ProjectCommissionController::class, "indexDesactivated"])->name("projectcommissions_desactivated_list");
Route::middleware('auth')->get('/projectcommission/activate/{projectCommission}', [ProjectCommissionController::class, 'activateStatus'])->name('projectcommission_activate');
Route::middleware('auth')->get('/projectcommission/desactivate/{projectCommission}', [ProjectCommissionController::class, 'desactivateStatus'])->name('projectcommission_desactivate');
Route::middleware('auth')->post('/projectcommission/{projectCommission}', [ProjectCommissionController::class, "update"])->name("projectcommission_update");
Route::middleware('auth')->get('/projectcommission/edit/{projectCommission}', [ProjectCommissionController::class, 'edit'])->name('projectcommission_edit');
Route::middleware('auth')->get('/projectcommission/show/{projectCommission}', [ProjectCommissionController::class, 'show'])->name('projectcommission_show');
Route::middleware('auth')->get('/projectcommissions/downloadCSV/{status}', [ProjectCommissionController::class, 'downloadCSV'])->name('projectcommissions.downloadCSV');

/* Project Commission Notes */
Route::middleware('auth')->post('/projectcommission/{projectCommission}/notes', [ProjectCommissionNoteController::class, 'store'])->name('projectcommission_note_add');
Route::middleware('auth')->put('/projectcommission/notes/{note}', [ProjectCommissionNoteController::class, 'update'])->name('projectcommission_note_update');
Route::middleware('auth')->delete('/projectcommission/notes/{note}', [ProjectCommissionNoteController::class, 'destroy'])->name('projectcommission_note_delete');

/* Project Commission Documents */
Route::middleware('auth')->post('/projectcommission/{projectCommission}/documents', [ProjectCommissionDocumentController::class, 'store'])->name('projectcommission_document_add');
Route::middleware('auth')->delete('/projectcommission/documents/{document}', [ProjectCommissionDocumentController::class, 'destroy'])->name('projectcommission_document_delete');
Route::middleware('auth')->get('/projectcommission/documents/{document}/download', [ProjectCommissionDocumentController::class, 'download'])->name('projectcommission_document_download');

/* ------------------------ MATERIAL ASSIGNMENTS ------------------------ */
Route::middleware('auth')->get('/materialassignments/list', [MaterialAssignmentController::class, 'index'])->name('materialassignments_list');
Route::middleware('auth')->get('/materialassignment/form', [MaterialAssignmentController::class, 'create'])->name('materialassignment_form');
Route::middleware('auth')->post('/materialassignment/store', [MaterialAssignmentController::class, 'store'])->name('materialassignment_store');
Route::middleware('auth')->get('/materialassignment/show/{materialAssignment}', [MaterialAssignmentController::class, 'show'])->name('materialassignment_show');
Route::middleware('auth')->get('/materialassignment/edit/{materialAssignment}', [MaterialAssignmentController::class, 'edit'])->name('materialassignment_edit');
Route::middleware('auth')->put('/materialassignment/update/{materialAssignment}', [MaterialAssignmentController::class, 'update'])->name('materialassignment_update');
Route::middleware('auth')->delete('/materialassignment/delete/{materialAssignment}', [MaterialAssignmentController::class, 'destroy'])->name('materialassignment_delete');
Route::middleware('auth')->get('/materialassignment/downloadCSV', [MaterialAssignmentController::class, 'downloadCSV'])->name('materialassignment_downloadCSV');

/* Material Assignment Notes */
Route::middleware('auth')->post('/materialassignment/{materialAssignment}/notes', [MaterialAssignmentNoteController::class, 'store'])->name('materialassignment_note_add');
Route::middleware('auth')->put('/materialassignment/notes/{note}', [MaterialAssignmentNoteController::class, 'update'])->name('materialassignment_note_update');
Route::middleware('auth')->delete('/materialassignment/notes/{note}', [MaterialAssignmentNoteController::class, 'destroy'])->name('materialassignment_note_delete');

/* Material Assignment Documents */
Route::middleware('auth')->post('/materialassignment/{materialAssignment}/documents', [MaterialAssignmentDocumentController::class, 'store'])->name('materialassignment_document_add');
Route::middleware('auth')->delete('/materialassignment/documents/{document}', [MaterialAssignmentDocumentController::class, 'destroy'])->name('materialassignment_document_delete');
Route::middleware('auth')->get('/materialassignment/documents/{document}/download', [MaterialAssignmentDocumentController::class, 'download'])->name('materialassignment_document_download');
