<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ComplementaryServiceController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProjectCommissionController;
use App\Http\Controllers\ExternalContactController;
use App\Http\Controllers\MaterialAssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EvaluationsController;
use App\Http\Controllers\HrIssueController;
use App\Http\Controllers\CourseAssignmentController;
use App\Http\Controllers\GeneralServiceController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\GlobalDocumentController;
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
Route::middleware('auth')->get('/center/edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
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
Route::middleware('auth')->get('/professionals/desactivated/list', [ProfessionalController::class, "index"])->defaults('status', 0)->name("professionals_desactivated_list");
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

/* ------------------------ HR ISSUES ------------------------ */
Route::middleware('auth')->get('/hr_issues/list', [HrIssueController::class, "index"])->name("hr_issues_list");
Route::middleware('auth')->get('/hr_issue/form', [HrIssueController::class, "create"])->name("hr_issue_form");
Route::middleware('auth')->post('/hr_issue/add', [HrIssueController::class, "store"])->name("hr_issue_add");
Route::middleware('auth')->get('/hr_issue/show/{id}', [HrIssueController::class, "show"])->name("hr_issue_show");
Route::middleware('auth')->get('/hr_issue/edit/{id}', [HrIssueController::class, "edit"])->name("hr_issue_edit");
Route::middleware('auth')->put('/hr_issue/update/{id}', [HrIssueController::class, "update"])->name("hr_issue_update");
Route::middleware('auth')->delete('/hr_issue/delete/{id}', [HrIssueController::class, "destroy"])->name("hr_issue_delete");

/* HR Issue Notes */
Route::middleware('auth')->post('/hr_issue/notes/{hrIssue}', [HrIssueController::class, 'hr_issue_note_add'])->name('hr_issue_note_add');
Route::middleware('auth')->put('/hr_issue/notes/{note}', [HrIssueController::class, 'hr_issue_note_update'])->name('hr_issue_note_update');
Route::middleware('auth')->delete('/hr_issue/notes/{note}', [HrIssueController::class, 'hr_issue_note_delete'])->name('hr_issue_note_delete');

/* HR Issue Documents */
Route::middleware('auth')->post('/hr_issue/documents/{hrIssue}', [HrIssueController::class, 'hr_issue_document_add'])->name('hr_issue_document_add');
Route::middleware('auth')->delete('/hr_issue/documents/{document}', [HrIssueController::class, 'hr_issue_document_delete'])->name('hr_issue_document_delete');
Route::middleware('auth')->get('/hr_issue/documents/download/{document}', [HrIssueController::class, 'hr_issue_document_download'])->name('hr_issue_document_download');

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

/* ------------------------ EXTERNAL CONTACTS ------------------------ */
Route::middleware('auth')->get('/externalcontact/form', [ExternalContactController::class, "create"])->name("externalcontact_form");
Route::middleware('auth')->post('/externalcontact/add', [ExternalContactController::class, "store"])->name("externalcontact_add");
Route::middleware('auth')->get('/externalcontacts/list', [ExternalContactController::class, "index"])->name("externalcontacts_list");
Route::middleware('auth')->post('/externalcontact/{externalContact}', [ExternalContactController::class, "update"])->name("externalcontact_update");
Route::middleware('auth')->get('/externalcontact/edit/{externalContact}', [ExternalContactController::class, 'edit'])->name('externalcontact_edit');
Route::middleware('auth')->get('/externalcontact/show/{externalContact}', [ExternalContactController::class, 'show'])->name('externalcontact_show');
Route::middleware('auth')->delete('/externalcontact/delete/{externalContact}', [ExternalContactController::class, 'destroy'])->name('externalcontact_delete');
Route::middleware('auth')->get('/externalcontacts/downloadCSV', [ExternalContactController::class, 'downloadCSV'])->name('externalcontacts.downloadCSV');

/* External Contact Notes */
Route::middleware('auth')->post('/externalcontact/notes/{externalContact}', [ExternalContactController::class, 'externalcontact_note_add'])->name('externalcontact_note_add');
Route::middleware('auth')->put('/externalcontact/notes/{note}', [ExternalContactController::class, 'externalcontact_note_update'])->name('externalcontact_note_update');
Route::middleware('auth')->delete('/externalcontact/notes/{note}', [ExternalContactController::class, 'externalcontact_note_delete'])->name('externalcontact_note_delete');

/* External Contact Documents */
Route::middleware('auth')->post('/externalcontact/documents/{externalContact}', [ExternalContactController::class, 'externalcontact_document_add'])->name('externalcontact_document_add');
Route::middleware('auth')->delete('/externalcontact/documents/{document}', [ExternalContactController::class, 'externalcontact_document_delete'])->name('externalcontact_document_delete');
Route::middleware('auth')->get('/externalcontact/documents/download/{document}', [ExternalContactController::class, 'externalcontact_document_download'])->name('externalcontact_document_download');

/* Course Professional Assignments */
Route::middleware('auth')->get('/course/assign_professionals/{course}', [CourseController::class, 'assignProfessionals'])->name('course_assign_professionals');
Route::middleware('auth')->post('/course/update_professional_assignments/{course}', [CourseController::class, 'updateProfessionalAssignments'])->name('course_update_professional_assignments');
Route::middleware('auth')->get('/course/downloadCSV_professionals/{course}', [CourseController::class, 'downloadCSVProfessionals'])->name('course_downloadCSV_professionals');

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
Route::middleware('auth')->patch('/course_assignment/certificate/{id}', [CourseAssignmentController::class, 'updateCertificate'])->name('course_assignment_update_certificate');

/* Material Assignment Notes */
Route::middleware('auth')->post('/courses/notes/{course}', [CourseController::class, 'course_note_add'])->name('course_note_add');
Route::middleware('auth')->put('/courses/notes/{note}', [CourseController::class, 'course_note_update'])->name('course_note_update');
Route::middleware('auth')->delete('/courses/notes/{note}', [CourseController::class, 'course_note_delete'])->name('course_note_delete');

/* Material Assignment Documents */
Route::middleware('auth')->post('/courses/documents/{course}', [CourseController::class, 'course_document_add'])->name('course_document_add');
Route::middleware('auth')->delete('/courses/documents/{document}', [CourseController::class, 'course_document_delete'])->name('course_document_delete');
Route::middleware('auth')->get('/courses/documents/download/{document}', [CourseController::class, 'course_document_download'])->name('course_document_download');

/* ------------------------ GENERAL SERVICES ------------------------ */
Route::middleware('auth')->get('/general_service/show/{service_type}', [GeneralServiceController::class, 'show'])->name('general_service_show');
Route::middleware('auth')->get('/general_service/edit/{service}', [GeneralServiceController::class, 'edit'])->name('general_service_edit');
Route::middleware('auth')->put('/general_service/update/{service}', [GeneralServiceController::class, 'update'])->name('general_service_update');

/* General Service Notes */
Route::middleware('auth')->post('/general_service/notes/{generalService}', [GeneralServiceController::class, 'general_service_note_add'])->name('general_service_note_add');
Route::middleware('auth')->put('/general_service/notes/{note}', [GeneralServiceController::class, 'general_service_note_update'])->name('general_service_note_update');
Route::middleware('auth')->delete('/general_service/notes/{note}', [GeneralServiceController::class, 'general_service_note_delete'])->name('general_service_note_delete');

/* General Service Documents */
Route::middleware('auth')->post('/general_service/documents/{generalService}', [GeneralServiceController::class, 'general_service_document_add'])->name('general_service_document_add');
Route::middleware('auth')->delete('/general_service/documents/{document}', [GeneralServiceController::class, 'general_service_document_delete'])->name('general_service_document_delete');
Route::middleware('auth')->get('/general_service/documents/download/{document}', [GeneralServiceController::class, 'general_service_document_download'])->name('general_service_document_download');

/* ------------------------ GLOBAL DOCUMENTS ------------------------ */
Route::middleware('auth')->get('/documents/list', [GlobalDocumentController::class, 'index'])->name('global_documents_list');
Route::middleware('auth')->get('/documents/download/{document}', [GlobalDocumentController::class, 'download'])->name('global_document_download');

/* ------------------------ MAINTENANCES ------------------------ */
Route::middleware('auth')->get('/maintenances/list', [MaintenanceController::class, 'index'])->name('maintenances_list');
Route::middleware('auth')->get('/maintenance/show/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenance_show');
Route::middleware('auth')->get('/maintenance/form/', [MaintenanceController::class, 'create'])->name('maintenance_form');
Route::middleware('auth')->get('/maintenance/edit/{maintenance}', [MaintenanceController::class, 'edit'])->name('maintenance_edit');
Route::middleware('auth')->post('/maintenance/add', [MaintenanceController::class, "store"])->name("maintenance_add");
Route::middleware('auth')->put('/maintenance/{maintenance}', [MaintenanceController::class, "update"])->name("maintenance_update");
Route::middleware('auth')->delete('/maintenance/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenance_delete');
Route::middleware('auth')->get('/maintenances/downloadCSV', [MaintenanceController::class, 'downloadCSV'])->name('maintenances_downloadCSV');

/* Maintenance Assignment Notes */
Route::middleware('auth')->post('/maintenances/notes/{maintenance}', [MaintenanceController::class, 'maintenance_note_add'])->name('maintenance_note_add');
Route::middleware('auth')->put('/maintenances/notes/{note}', [MaintenanceController::class, 'maintenance_note_update'])->name('maintenance_note_update');
Route::middleware('auth')->delete('/maintenances/notes/{note}', [MaintenanceController::class, 'maintenance_note_delete'])->name('maintenance_note_delete');

/* Maintenance Assignment Documents */
Route::middleware('auth')->post('/maintenances/documents/{maintenance}', [MaintenanceController::class, 'maintenance_document_add'])->name('maintenance_document_add');
Route::middleware('auth')->delete('/maintenances/documents/{document}', [MaintenanceController::class, 'maintenance_document_delete'])->name('maintenance_document_delete');
Route::middleware('auth')->get('/maintenances/documents/download/{document}', [MaintenanceController::class, 'maintenance_document_download'])->name('maintenance_document_download');
Route::middleware('auth')->get('/documents/list', [GlobalDocumentController::class, 'index'])->name('global_documents_list');
Route::middleware('auth')->get('/documents/download/{document}', [GlobalDocumentController::class, 'download'])->name('global_document_download');

/* ------------------------ COMPLEMENTARY SERVICES ------------------------ */
Route::middleware('auth')->get('/complementaryservices/list', [ComplementaryServiceController::class, 'index'])->name('complementaryservices_list');
Route::middleware('auth')->get('/complementaryservices/show/{complementaryService}', [ComplementaryServiceController::class, 'show'])->name('complementaryservice_show');
Route::middleware('auth')->get('/complementaryservices/edit/{complementaryService}', [ComplementaryServiceController::class, 'edit'])->name('complementaryservice_edit');
Route::middleware('auth')->delete('/complementaryservices/{complementaryService}', [ComplementaryServiceController::class, 'destroy'])->name('complementaryservice_delete');
Route::middleware('auth')->get('/complementaryservices/form/', [ComplementaryServiceController::class, 'create'])->name('complementaryservice_form');
Route::middleware('auth')->post('/complementaryservices/add', [ComplementaryServiceController::class, "store"])->name("complementaryservice_add");
Route::middleware('auth')->put('/complementaryservices/{complementaryService}', [ComplementaryServiceController::class, "update"])->name("complementaryservice_update");
Route::middleware('auth')->get('/complementaryservices/downloadCSV', [ComplementaryServiceController::class, 'downloadCSV'])->name('omplementaryservice_downloadCSV');

/* Complementary Services Notes */
Route::middleware('auth')->post('/complementaryservices/notes/{complementaryService}', [ComplementaryServiceController::class, 'complementaryservice_note_add'])->name('complementaryservices_note_add');
Route::middleware('auth')->put('/complementaryservices/notes/{note}', [ComplementaryServiceController::class, 'complementaryservice_note_update'])->name('complementaryservices_note_update');
Route::middleware('auth')->delete('/complementaryservices/notes/{note}', [ComplementaryServiceController::class, 'complementaryservice_note_delete'])->name('complementaryservices_note_delete');

/* Complementary Services Documents */
Route::middleware('auth')->post('/complementaryservices/documents/{complementaryService}', [ComplementaryServiceController::class, 'complementaryservice_document_add'])->name('complementaryservices_document_add');
Route::middleware('auth')->delete('/complementaryservices/documents/{document}', [ComplementaryServiceController::class, 'complementaryservice_document_delete'])->name('complementaryservices_document_delete');
Route::middleware('auth')->get('/complementaryservices/documents/download/{document}', [ComplementaryServiceController::class, 'complementaryservice_document_download'])->name('complementaryservices_document_download');
