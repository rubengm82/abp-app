<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProjectCommissionController;
use App\Http\Controllers\MaterialAssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EvaluationsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* ------------------------ LOGIN ------------------------ */
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'show'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});

/* ------------------------ LOGOUT ------------------------ */
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/logout', function () {
    if (Auth::check()) {
        // If the user is logged in, simply redirect to home without logging out
        return redirect()->route('home');
    }
    // If the user is not logged in, redirect to login
    return redirect()->route('login');
});

/* ------------------------ HOME ------------------------ */
Route::middleware('auth')->get('/home', function () {
    return view('app');
})->name('home');

/* ------------------------ CENTERS ------------------------ */
Route::middleware('auth')->get('/center/form', [CenterController::class, "create"])->name("center_form");
Route::middleware('auth')->post('/center/add', [CenterController::class, "store"])->name("center_add");
Route::middleware('auth')->get('/centers/list', [CenterController::class, "index"])->name("centers_list");
Route::middleware('auth')->get('/centers/desactivated/list', [CenterController::class, "index_desactivatedCenters"])->name("centers_desactivated_list");
Route::middleware('auth')->patch('/center/activate/{center}', [CenterController::class, 'activateStatus'])->name('center_activate');
Route::middleware('auth')->patch('/center/desactivate/{center}', [CenterController::class, 'desactivateStatus'])->name('center_desactivate');
Route::middleware('auth')->post('/center/{center}', [CenterController::class, "update"])->name("center_update");
Route::middleware('auth')->get('/center/center_edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
Route::middleware('auth')->get('/center/show/{id}', [CenterController::class, "show"])->name("center_show");
Route::middleware('auth')->get('/centers/downloadCSV/{status}', [CenterController::class, 'downloadCSV'])->name('centers.downloadCSV');

/* Center Notes */
Route::middleware('auth')->post('/center/notes/{center}', [CenterController::class, 'center_note_add'])->name('center_note_add');
Route::middleware('auth')->put('/center/notes/{note}', [CenterController::class, 'center_note_update'])->name('center_note_update');
Route::middleware('auth')->delete('/center/notes/{note}', [CenterController::class, 'center_note_delete'])->name('center_note_delete');

/* Center Documents */
Route::middleware('auth')->post('/center/documents/{center}', [CenterController::class, 'center_document_add'])->name('center_document_add');
Route::middleware('auth')->delete('/center/documents/{document}', [CenterController::class, 'center_document_delete'])->name('center_document_delete');
Route::middleware('auth')->get('/center/documents/download/{document}', [CenterController::class, 'center_document_download'])->name('center_document_download');

/* ------------------------ PROFESSIONALS ------------------------ */
Route::middleware('auth')->get('/professional/form', [ProfessionalController::class, "create"])->name("professional_form");
Route::middleware('auth')->post('/professional/add', [ProfessionalController::class, "store"])->name("professional_add");
Route::middleware('auth')->get('/professionals/list', [ProfessionalController::class, "index"])->name("professionals_list");
Route::middleware('auth')->get('/professionals/desactivated/list', [ProfessionalController::class, "index_desactivatedProfessionals"])->name("professionals_desactivated_list");
Route::middleware('auth')->patch('/professional/activate/{professional_id}', [ProfessionalController::class, 'activateStatus'])->name('professional_activate');
Route::middleware('auth')->patch('/professional/desactivate/{professional_id}', [ProfessionalController::class, 'desactivateStatus'])->name('professional_desactivate');
Route::middleware('auth')->post('/professional/update/{id}', [ProfessionalController::class, "update"])->name("professional_update");
Route::middleware('auth')->get('/professional/edit/{id}', [ProfessionalController::class, "edit"])->name("professional_edit");
Route::middleware('auth')->get('/professional/show/{id}', [ProfessionalController::class, "show"])->name("professional_show");
Route::middleware('auth')->get('/professionals/downloadCSV/material_assignments', [ProfessionalController::class, 'downloadCSVMaterialAssignments'])->name('professionals.downloadCSV.materialAssignments');
Route::middleware('auth')->get('/professionals/downloadCSV/{status}', [ProfessionalController::class, 'downloadCSV'])->name('professionals.downloadCSV');

/* Professional Notes */
Route::middleware('auth')->post('/professional/{professional}/notes', [ProfessionalController::class, 'professional_note_add'])->name('professional_note_add');
Route::middleware('auth')->put('/professional/notes/{note}', [ProfessionalController::class, 'professional_note_update'])->name('professional_note_update');
Route::middleware('auth')->delete('/professional/notes/{note}', [ProfessionalController::class, 'professional_note_delete'])->name('professional_note_delete');

/* Professional Documents */
Route::middleware('auth')->post('/professional/documents/{professional}', [ProfessionalController::class, 'professional_document_add'])->name('professional_document_add');
Route::middleware('auth')->delete('/professional/documents/{document}', [ProfessionalController::class, 'professional_document_delete'])->name('professional_document_delete');
Route::middleware('auth')->get('/professional/documents/download/{document}', [ProfessionalController::class, 'professional_document_download'])->name('professional_document_download');

/* Professional| EVALUATIONS */
Route::middleware('auth')->get('/professionals/evaluations/list', [EvaluationsController::class, "index"])->name("professional_evaluations_list");
Route::middleware('auth')->get('/professionals/evaluations/quiz/form', [EvaluationsController::class, "create"])->name("professional_evaluations_quiz_form");
Route::middleware('auth')->get('/professionals/evaluations/quiz/show/{professionalEvaluated}/{professionalEvaluator}/{evaluation}', [EvaluationsController::class, "show"])->name("professional_evaluation_quiz_show");
Route::middleware('auth')->post('/professionals/evaluations/quiz/add', [EvaluationsController::class, "store"])->name("professional_evaluations_add");
Route::middleware('auth')->get('/professionals/evaluations/downloadCSV/', [EvaluationsController::class, 'downloadCSV'])->name('professional_evaluations.downloadCSV');
Route::middleware('auth')->get('/professionals/evaluations/quiz/downloadCSV/{evaluation_uuid}', [EvaluationsController::class, 'downloadCSV_professional_evaluated'])->name('professional_evaluation_quiz_downloadCSV');
Route::middleware('auth')->delete('/professionals/evaluations/delete', [EvaluationsController::class, 'destroy'])->name('professional_evaluations_delete');

/* ------------------------ PROJECT COMMISSIONS ------------------------ */
Route::middleware('auth')->get('/projectcommission/form', [ProjectCommissionController::class, "create"])->name("projectcommission_form");
Route::middleware('auth')->post('/projectcommission/add', [ProjectCommissionController::class, "store"])->name("projectcommission_add");
Route::middleware('auth')->get('/projectcommissions/list', [ProjectCommissionController::class, "index"])->name("projectcommissions_list");
Route::middleware('auth')->get('/projectcommissions/desactivated/list', [ProjectCommissionController::class, "indexDesactivated"])->name("projectcommissions_desactivated_list");
Route::middleware('auth')->patch('/projectcommission/activate/{projectCommission}', [ProjectCommissionController::class, 'activateStatus'])->name('projectcommission_activate');
Route::middleware('auth')->patch('/projectcommission/desactivate/{projectCommission}', [ProjectCommissionController::class, 'desactivateStatus'])->name('projectcommission_desactivate');
Route::middleware('auth')->post('/projectcommission/{projectCommission}', [ProjectCommissionController::class, "update"])->name("projectcommission_update");
Route::middleware('auth')->get('/projectcommission/edit/{projectCommission}', [ProjectCommissionController::class, 'edit'])->name('projectcommission_edit');
Route::middleware('auth')->get('/projectcommission/show/{projectCommission}', [ProjectCommissionController::class, 'show'])->name('projectcommission_show');
Route::middleware('auth')->get('/projectcommissions/downloadCSV/{status}', [ProjectCommissionController::class, 'downloadCSV'])->name('projectcommissions.downloadCSV');

/* Project Commission Notes */
Route::middleware('auth')->post('/projectcommission/notes/{projectCommission}', [ProjectCommissionController::class, 'projectcommission_note_add'])->name('projectcommission_note_add');
Route::middleware('auth')->put('/projectcommission/notes/{note}', [ProjectCommissionController::class, 'projectcommission_note_update'])->name('projectcommission_note_update');
Route::middleware('auth')->delete('/projectcommission/notes/{note}', [ProjectCommissionController::class, 'projectcommission_note_delete'])->name('projectcommission_note_delete');

/* Project Commission Documents */
Route::middleware('auth')->post('/projectcommission/documents/{projectCommission}', [ProjectCommissionController::class, 'projectcommission_document_add'])->name('projectcommission_document_add');
Route::middleware('auth')->delete('/projectcommission/documents/{document}', [ProjectCommissionController::class, 'projectcommission_document_delete'])->name('projectcommission_document_delete');
Route::middleware('auth')->get('/projectcommission/documents/download/{document}', [ProjectCommissionController::class, 'projectcommission_document_download'])->name('projectcommission_document_download');

/* Project Commission Professional Assignments */
Route::middleware('auth')->get('/projectcommission/assign-professionals/{projectCommission}', [ProjectCommissionController::class, 'assignProfessionals'])->name('projectcommission_assign_professionals');
Route::middleware('auth')->post('/projectcommission/update-professional-assignments/{projectCommission}', [ProjectCommissionController::class, 'updateProfessionalAssignments'])->name('projectcommission_update_professional_assignments');
Route::middleware('auth')->get('/projectcommission/downloadCSV-professionals/{projectCommission}', [ProjectCommissionController::class, 'downloadCSVProfessionals'])->name('projectcommission_downloadCSV_professionals');

/* Course Professional Assignments */
Route::middleware('auth')->get('/course/assign-professionals/{course}', [CourseController::class, 'assignProfessionals'])->name('course_assign_professionals');
Route::middleware('auth')->post('/course/update-professional-assignments/{course}', [CourseController::class, 'updateProfessionalAssignments'])->name('course_update_professional_assignments');
Route::middleware('auth')->get('/course/downloadCSV-professionals/{course}', [CourseController::class, 'downloadCSVProfessionals'])->name('course_downloadCSV_professionals');

/* ------------------------ MATERIAL ASSIGNMENTS ------------------------ */
Route::middleware('auth')->get('/materialassignments/list', [MaterialAssignmentController::class, 'index'])->name('materialassignments_list');
Route::middleware('auth')->get('/materialassignment/form', [MaterialAssignmentController::class, 'create'])->name('materialassignment_form');
Route::middleware('auth')->post('/materialassignment/add', [MaterialAssignmentController::class, 'store'])->name('materialassignment_add');
Route::middleware('auth')->get('/materialassignment/show/{materialAssignment}', [MaterialAssignmentController::class, 'show'])->name('materialassignment_show');
Route::middleware('auth')->get('/materialassignment/edit/{materialAssignment}', [MaterialAssignmentController::class, 'edit'])->name('materialassignment_edit');
Route::middleware('auth')->put('/materialassignment/update/{materialAssignment}', [MaterialAssignmentController::class, 'update'])->name('materialassignment_update');
Route::middleware('auth')->delete('/materialassignment/delete/{materialAssignment}', [MaterialAssignmentController::class, 'destroy'])->name('materialassignment_delete');
Route::middleware('auth')->get('/materialassignment/downloadCSV', [MaterialAssignmentController::class, 'downloadCSV'])->name('materialassignment_downloadCSV');

/* Material Assignment Notes */
Route::middleware('auth')->post('/materialassignment/notes/{materialAssignment}', [MaterialAssignmentController::class, 'materialassignment_note_add'])->name('materialassignment_note_add');
Route::middleware('auth')->put('/materialassignment/notes/{note}', [MaterialAssignmentController::class, 'materialassignment_note_update'])->name('materialassignment_note_update');
Route::middleware('auth')->delete('/materialassignment/notes/{note}', [MaterialAssignmentController::class, 'materialassignment_note_delete'])->name('materialassignment_note_delete');

/* Material Assignment Documents */
Route::middleware('auth')->post('/materialassignment/documents/{materialAssignment}', [MaterialAssignmentController::class, 'materialassignment_document_add'])->name('materialassignment_document_add');
Route::middleware('auth')->delete('/materialassignment/documents/{document}', [MaterialAssignmentController::class, 'materialassignment_document_delete'])->name('materialassignment_document_delete');
Route::middleware('auth')->get('/materialassignment/documents/download/{document}', [MaterialAssignmentController::class, 'materialassignment_document_download'])->name('materialassignment_document_download');

/* ------------------------ COURSES ------------------------ */
Route::middleware('auth')->get('/courses/list', [CourseController::class, 'index'])->name('courses_list');
Route::middleware('auth')->get('/courses/show/{course}', [CourseController::class, 'show'])->name('course_show');
Route::middleware('auth')->delete('/courses/course/{course}', [CourseController::class, 'destroy'])->name('course_delete');
Route::middleware('auth')->get('/courses/form/', [CourseController::class, 'create'])->name('course_form');
Route::middleware('auth')->post('/courses/add', [CourseController::class, "store"])->name("course_add");
Route::middleware('auth')->get('/courses/edit/{course}', [CourseController::class, 'edit'])->name('course_edit');
Route::middleware('auth')->put('/courses/update/{course}', [CourseController::class, 'update'])->name('course_update');
Route::middleware('auth')->get('/courses/downloadCSV', [CourseController::class, 'downloadCSV'])->name('courses_downloadCSV');

/* Material Assignment Notes */
Route::middleware('auth')->post('/courses/notes/{course}', [CourseController::class, 'course_note_add'])->name('course_note_add');
Route::middleware('auth')->put('/courses/notes/{note}', [CourseController::class, 'course_note_update'])->name('course_note_update');
Route::middleware('auth')->delete('/courses/notes/{note}', [CourseController::class, 'course_note_delete'])->name('course_note_delete');

/* Material Assignment Documents */
Route::middleware('auth')->post('/courses/documents/{course}', [CourseController::class, 'course_document_add'])->name('course_document_add');
Route::middleware('auth')->delete('/courses/documents/{document}', [CourseController::class, 'course_document_delete'])->name('course_document_delete');
Route::middleware('auth')->get('/courses/documents/download/{document}', [CourseController::class, 'course_document_download'])->name('course_document_download');