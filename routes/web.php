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

/* ------------------------ LOGIN ROUTES ------------------------ */
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'show'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});

/* ------------------------ LOGOUT ------------------------ */
// Logout con GET (no recomendado por Laravel por seguridad, pero funciona)
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/* ------------------------ RUTAS PROTEGIDAS ------------------------ */
Route::middleware('auth')->group(function () {

    /* HOME */
    Route::get('/home', function () {
        return view('app');
    })->name('home');

    /* ------------------------ CENTERS ------------------------ */
    Route::prefix('center')->group(function () {
        Route::get('/form', [CenterController::class, "create"])->name("center_form");
        Route::post('/add', [CenterController::class, "store"])->name("center_add");
        Route::get('/list', [CenterController::class, "index"])->name("centers_list");
        Route::get('/desactivated_list', [CenterController::class, "index_desactivatedCenters"])->name("centers_desactivated_list");
        Route::get('/activate/{center}', [CenterController::class, 'activateStatus'])->name('center_activate');
        Route::get('/desactivate/{center}', [CenterController::class, 'desactivateStatus'])->name('center_desactivate');
        Route::get('/edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
        Route::post('/update/{center}', [CenterController::class, "update"])->name("center_update");
        Route::get('/show/{center}', [CenterController::class, "show"])->name("center_show");
        Route::get('/downloadCSV/{status}', [CenterController::class, 'downloadCSV'])->name('centers.downloadCSV');

        // Notes
        Route::post('/{center}/notes', [CenterNoteController::class, 'store'])->name('center_note_add');
        Route::put('/notes/{note}', [CenterNoteController::class, 'update'])->name('center_note_update');
        Route::delete('/notes/{note}', [CenterNoteController::class, 'destroy'])->name('center_note_delete');

        // Documents
        Route::post('/{center}/documents', [CenterDocumentController::class, 'store'])->name('center_document_add');
        Route::delete('/documents/{document}', [CenterDocumentController::class, 'destroy'])->name('center_document_delete');
        Route::get('/documents/{document}/download', [CenterDocumentController::class, 'download'])->name('center_document_download');
    });

    /* ------------------------ PROFESSIONALS ------------------------ */
    Route::prefix('professional')->group(function () {
        Route::get('/form', [ProfessionalController::class, "create"])->name("professional_form");
        Route::post('/add', [ProfessionalController::class, "store"])->name("professional_add");
        Route::get('/list', [ProfessionalController::class, "index"])->name("professionals_list");
        Route::get('/desactivated_list', [ProfessionalController::class, "index_desactivatedCenters"])->name("professionals_desactivated_list");
        Route::get('/activate/{professional_id}', [ProfessionalController::class, 'activateStatus'])->name('professional_activate');
        Route::get('/desactivate/{professional_id}', [ProfessionalController::class, 'desactivateStatus'])->name('professional_desactivate');
        Route::get('/edit/{id}', [ProfessionalController::class, "edit"])->name("professional_edit");
        Route::post('/update/{id}', [ProfessionalController::class, "update"])->name("professional_update");
        Route::get('/show/{id}', [ProfessionalController::class, "show"])->name("professional_show");

        // CSV
        Route::get('/downloadCSV/{status}', [ProfessionalController::class, 'downloadCSV'])->name('professionals.downloadCSV');
        Route::get('/downloadCSV/material-assignments', [ProfessionalController::class, 'downloadCSVMaterialAssignments'])->name('professionals.downloadCSV.materialAssignments');

        // Notes
        Route::post('/{professional}/notes', [ProfessionalNoteController::class, 'store'])->name('professional_note_add');
        Route::put('/notes/{note}', [ProfessionalNoteController::class, 'update'])->name('professional_note_update');
        Route::delete('/notes/{note}', [ProfessionalNoteController::class, 'destroy'])->name('professional_note_delete');

        // Documents
        Route::post('/{professional}/documents', [ProfessionalDocumentController::class, 'store'])->name('professional_document_add');
        Route::delete('/documents/{document}', [ProfessionalDocumentController::class, 'destroy'])->name('professional_document_delete');
        Route::get('/documents/{document}/download', [ProfessionalDocumentController::class, 'download'])->name('professional_document_download');
    });

    /* ------------------------ PROJECT/COMMISSION ------------------------ */
    Route::prefix('projectcommission')->group(function () {
        Route::get('/form', [ProjectCommissionController::class, "create"])->name("projectcommission_form");
        Route::post('/add', [ProjectCommissionController::class, "store"])->name("projectcommission_add");
        Route::get('/list', [ProjectCommissionController::class, "index"])->name("projectcommissions_list");
        Route::get('/desactivated_list', [ProjectCommissionController::class, "indexDesactivated"])->name("projectcommissions_desactivated_list");
        Route::get('/activate/{projectCommission}', [ProjectCommissionController::class, 'activateStatus'])->name('projectcommission_activate');
        Route::get('/desactivate/{projectCommission}', [ProjectCommissionController::class, 'desactivateStatus'])->name('projectcommission_desactivate');
        Route::get('/edit/{projectCommission}', [ProjectCommissionController::class, 'edit'])->name('projectcommission_edit');
        Route::post('/update/{projectCommission}', [ProjectCommissionController::class, "update"])->name("projectcommission_update");
        Route::get('/show/{projectCommission}', [ProjectCommissionController::class, 'show'])->name('projectcommission_show');
        Route::get('/downloadCSV/{status}', [ProjectCommissionController::class, 'downloadCSV'])->name('projectcommissions.downloadCSV');

        // Notes
        Route::post('/{projectCommission}/notes', [ProjectCommissionNoteController::class, 'store'])->name('projectcommission_note_add');
        Route::put('/notes/{note}', [ProjectCommissionNoteController::class, 'update'])->name('projectcommission_note_update');
        Route::delete('/notes/{note}', [ProjectCommissionNoteController::class, 'destroy'])->name('projectcommission_note_delete');

        // Documents
        Route::post('/{projectCommission}/documents', [ProjectCommissionDocumentController::class, 'store'])->name('projectcommission_document_add');
        Route::delete('/documents/{document}', [ProjectCommissionDocumentController::class, 'destroy'])->name('projectcommission_document_delete');
        Route::get('/documents/{document}/download', [ProjectCommissionDocumentController::class, 'download'])->name('projectcommission_document_download');
    });

    /* ------------------------ MATERIAL ASSIGNMENTS ------------------------ */
    Route::prefix('materialassignment')->group(function () {
        Route::get('/list', [MaterialAssignmentController::class, 'index'])->name('materialassignments_list');
        Route::get('/form', [MaterialAssignmentController::class, 'create'])->name('materialassignment_form');
        Route::post('/store', [MaterialAssignmentController::class, 'store'])->name('materialassignment_store');
        Route::get('/show/{materialAssignment}', [MaterialAssignmentController::class, 'show'])->name('materialassignment_show');
        Route::get('/edit/{materialAssignment}', [MaterialAssignmentController::class, 'edit'])->name('materialassignment_edit');
        Route::put('/update/{materialAssignment}', [MaterialAssignmentController::class, 'update'])->name('materialassignment_update');
        Route::delete('/delete/{materialAssignment}', [MaterialAssignmentController::class, 'destroy'])->name('materialassignment_delete');
        Route::get('/downloadCSV', [MaterialAssignmentController::class, 'downloadCSV'])->name('materialassignment_downloadCSV');

        // Notes
        Route::post('/{materialAssignment}/notes', [MaterialAssignmentNoteController::class, 'store'])->name('materialassignment_note_add');
        Route::put('/notes/{note}', [MaterialAssignmentNoteController::class, 'update'])->name('materialassignment_note_update');
        Route::delete('/notes/{note}', [MaterialAssignmentNoteController::class, 'destroy'])->name('materialassignment_note_delete');

        // Documents
        Route::post('/{materialAssignment}/documents', [MaterialAssignmentDocumentController::class, 'store'])->name('materialassignment_document_add');
        Route::delete('/documents/{document}', [MaterialAssignmentDocumentController::class, 'destroy'])->name('materialassignment_document_delete');
        Route::get('/documents/{document}/download', [MaterialAssignmentDocumentController::class, 'download'])->name('materialassignment_document_download');
    });
});
