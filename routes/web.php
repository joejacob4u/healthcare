<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/logout', 'HomeController@logout');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('prospects/register', 'RegistrationController@index');
Route::post('prospects/register', 'RegistrationController@create');

Route::get('forgot/password', 'UsersController@forgotView');
Route::post('forgot/password', 'UsersController@sendTempPassword');

Route::post('dropzone/upload', 'DropzoneController@upload');
Route::post('dropzone/delete', 'DropzoneController@delete');
Route::post('dropzone/populate', 'DropzoneController@populate');


Route::get('contractors/login', 'ContractorAuthController@login');
Route::post('contractors/login', 'ContractorAuthController@authenticate');

Route::get('contractor/prequalify', 'ContractorPrequalifyController@index');
Route::get('contractor/prequalify/apply/{id}', 'ContractorPrequalifyController@create');
Route::get('contractor/prequalify/download/{id}', 'ContractorPrequalifyController@download');
Route::post('contractor/prequalify/upload', 'ContractorPrequalifyController@upload');
Route::post('contractor/prequalify/apply', 'ContractorPrequalifyController@apply');

Route::get('projects', 'Project\ProjectController@index');
Route::get('projects/general/add', 'Project\ProjectController@createGeneral');
Route::get('projects/general/edit/{project_id}', 'Project\ProjectController@editGeneral');
Route::post('projects/general/edit/{project_id}', 'Project\ProjectController@saveGeneral');
Route::post('projects/con/edit/{project_id}', 'Project\ProjectController@saveCON');
Route::post('projects/financial/edit/{project_id}', 'Project\ProjectController@saveFinancial');
Route::post('projects/ranking-questions/edit/{project_id}', 'Project\ProjectController@saveRankingQuestions');
Route::post('projects/equipment/edit/{project_id}', 'Project\ProjectController@saveEquipment');
Route::post('projects/accreditation/edit/{project_id}', 'Project\ProjectController@saveAccreditation');
Route::post('projects/leadership/edit/{project_id}', 'Project\ProjectController@saveLeadership');
Route::post('projects/administration/edit/{project_id}', 'Project\ProjectController@saveAdministration');


Route::get('workflows/financial-category-codes', 'Workflow\FinancialCategoryCodeController@index');
Route::get('workflows/financial-category-codes/add', 'Workflow\FinancialCategoryCodeController@create');
Route::post('workflows/financial-category-codes/add', 'Workflow\FinancialCategoryCodeController@store');
Route::get('workflows/financial-category-codes/edit/{financial_category_code}', 'Workflow\FinancialCategoryCodeController@edit');
Route::post('workflows/financial-category-codes/edit/{financial_category_code}', 'Workflow\FinancialCategoryCodeController@save');
Route::post('workflows/financial-category-codes/delete', 'Workflow\FinancialCategoryCodeController@delete');

Route::get('workflows/business-units', 'Workflow\BusinessUnitController@index');
Route::get('workflows/business-units/add', 'Workflow\BusinessUnitController@create');
Route::post('workflows/business-units/add', 'Workflow\BusinessUnitController@store');
Route::get('workflows/business-units/edit/{business_unit}', 'Workflow\BusinessUnitController@edit');
Route::post('workflows/business-units/edit/{business_unit}', 'Workflow\BusinessUnitController@save');
Route::post('workflows/business-units/delete', 'Workflow\BusinessUnitController@delete');

Route::get('workflows/accreditation-compliance-leaders', 'Workflow\AccreditationComplianceLeaderController@index');
Route::get('workflows/accreditation-compliance-leaders/add', 'Workflow\AccreditationComplianceLeaderController@create');
Route::post('workflows/accreditation-compliance-leaders/add', 'Workflow\AccreditationComplianceLeaderController@store');
Route::get('workflows/accreditation-compliance-leaders/edit/{accreditation_compliance_leader}', 'Workflow\AccreditationComplianceLeaderController@edit');
Route::post('workflows/accreditation-compliance-leaders/edit/{accreditation_compliance_leader}', 'Workflow\AccreditationComplianceLeaderController@save');
Route::post('workflows/accreditation-compliance-leaders/delete', 'Workflow\AccreditationComplianceLeaderController@delete');

Route::get('workflows/administrative-leaders', 'Workflow\AdministrativeLeaderController@index');
Route::get('workflows/administrative-leaders/add', 'Workflow\AdministrativeLeaderController@create');
Route::post('workflows/administrative-leaders/add', 'Workflow\AdministrativeLeaderController@store');
Route::get('workflows/administrative-leaders/edit/{administrative_leader}', 'Workflow\AdministrativeLeaderController@edit');
Route::post('workflows/administrative-leaders/edit/{administrative_leader}', 'Workflow\AdministrativeLeaderController@save');
Route::post('workflows/administrative-leaders/delete', 'Workflow\AdministrativeLeaderController@delete');

Route::get('workflows/approval-level-leaders', 'Workflow\ApprovalLevelLeaderController@index');
Route::get('workflows/approval-level-leaders/add', 'Workflow\ApprovalLevelLeaderController@create');
Route::post('workflows/approval-level-leaders/add', 'Workflow\ApprovalLevelLeaderController@store');
Route::get('workflows/approval-level-leaders/edit/{approval_level_leader}', 'Workflow\ApprovalLevelLeaderController@edit');
Route::post('workflows/approval-level-leaders/edit/{approval_level_leader}', 'Workflow\ApprovalLevelLeaderController@save');
Route::post('workflows/approval-level-leaders/delete', 'Workflow\ApprovalLevelLeaderController@delete');


Route::post('projects/general/store', 'Project\ProjectController@storeGeneral');
Route::post('project/fetch/sites', 'Project\ProjectController@fetchSites');
Route::post('project/fetch/buildings', 'Project\ProjectController@fetchBuildings');


Route::get('project/ranking-questions', 'Project\RankingQuestionController@index');
Route::post('project/ranking-questions/add', 'Project\RankingQuestionController@create');
Route::post('project/ranking-questions/edit', 'Project\RankingQuestionController@save');
Route::post('project/ranking-questions/delete', 'Project\RankingQuestionController@delete');
Route::get('project/ranking-questions/{question_id}/answers', 'Project\RankingAnswerController@index');
Route::post('project/ranking-questions/answers/add', 'Project\RankingAnswerController@create');
Route::post('project/ranking-questions/answers/edit', 'Project\RankingAnswerController@save');
Route::post('project/ranking-questions/answers/delete', 'Project\RankingAnswerController@delete');

Route::get('accreditation/dashboard', 'Accreditation\AccreditationDashboardController@index');



Route::get('system-admin/accreditation', 'Accreditation\AccreditationController@index');
Route::post('system-admin/accreditation/set-building', 'Accreditation\AccreditationController@setBuilding');
Route::post('system-admin/accreditation/accr-requirements', 'Accreditation\AccreditationController@fetchAccrRequirements');
Route::post('system-admin/accreditation/fetch/sites', 'Accreditation\AccreditationController@fetchSites');
Route::post('system-admin/accreditation/fetch/buildings', 'Accreditation\AccreditationController@fetchBuildings');
Route::post('system-admin/accreditation/fetch/accreditation', 'Accreditation\AccreditationController@fetchAccreditations');
Route::post('system-admin/accreditation/fetch/accreditation_requirements', 'Accreditation\AccreditationController@fetchAccreditationRequirements');

Route::get('system-admin/accreditation/eop/{eop_id}/submission_dates', 'Accreditation\EOPSubmissionDateController@index');
Route::post('system-admin/accreditation/eop/{eop_id}/submission_date', 'Accreditation\EOPSubmissionDateController@store');
Route::post('system-admin/accreditation/eop/{eop_id}/submission_date/delete', 'Accreditation\EOPSubmissionDateController@destroy');

Route::get('system-admin/accreditation/eop/{eop_id}/submission_date/{submission_date_id}/documents', 'Accreditation\EOPDocumentController@index');
Route::get('system-admin/accreditation/eop/{eop_id}/submission_date/{submission_date_id}/documents/create', 'Accreditation\EOPDocumentController@create');
Route::post('system-admin/accreditation/eop/submission_date/documents', 'Accreditation\EOPDocumentController@store');
Route::get('system-admin/accreditation/eop/{eop_id}/submission_date/{submission_date_id}/documents/{document_id}/edit', 'Accreditation\EOPDocumentController@edit');
Route::post('system-admin/accreditation/eop/document/verify', 'Accreditation\EOPDocumentController@verify');
Route::post('system-admin/dashboard/documents/fetch/report', 'Accreditation\AccreditationDashboardController@hcoDocumentsReport');
Route::post('system-admin/dashboard/documents/fetch/action-plan', 'Accreditation\AccreditationDashboardController@documentsActionPlan');



Route::post('system-admin/accreditation/eop/document/baseline-date', 'Accreditation\AccreditationController@saveBaselineDate');
Route::get('system-admin/accreditation/{accreditation_id}/accreditation_requirement/{accreditation_requirement_id}', 'Accreditation\AccreditationController@fetchStandardLabels');

Route::get('system-admin/findings/action-plan', 'Accreditation\EOPStatusController@actionPlanIndex');
Route::post('system-admin/findings/action-plan', 'Accreditation\EOPStatusController@getActionPlan');
Route::post('system-admin/findings/fetch/report', 'Accreditation\AccreditationDashboardController@hcoFindings');
Route::get('system-admin/findings/export', 'Accreditation\EOPStatusController@exportToCSV');
Route::get('system-admin/findings/export/hco', 'Accreditation\EOPStatusController@exportHCOToCSV');
Route::get('system-admin/accreditation/eop/status/{eop_id}', 'Accreditation\EOPStatusController@index');
Route::get('system-admin/accreditation/eop/status/{eop_id}/finding/add', 'Accreditation\EOPStatusController@addFinding');
Route::post('system-admin/accreditation/eop/status/{eop_id}/finding/add', 'Accreditation\EOPStatusController@createFinding');
Route::post('system-admin/accreditation/eop/status/fetch/rooms', 'Accreditation\EOPStatusController@fetchRooms');
Route::get('system-admin/accreditation/eop/status/{eop_id}/finding/edit/{finding_id}', 'Accreditation\EOPStatusController@editFinding');
Route::post('system-admin/accreditation/eop/status/{eop_id}/finding/edit/{finding_id}', 'Accreditation\EOPStatusController@saveFinding');
Route::get('system-admin/accreditation/eop/status/{eop_id}/finding/{finding_id}', 'Accreditation\EOPStatusController@viewFinding');
Route::post('system-admin/accreditation/eop/status/{eop_id}/finding/comment/add', 'Accreditation\EOPStatusController@createComment');

// Healthsystem management routes

Route::get('healthsystem', 'Admin\HealthsystemController@index');
Route::get('healthsystem/add', 'Admin\HealthsystemController@add');
Route::post('healthsystem/add', 'Admin\HealthsystemController@create');
Route::get('healthsystem/edit/{id}', 'Admin\HealthsystemController@edit');
Route::post('healthsystem/edit/{id}', 'Admin\HealthsystemController@save');
Route::post('healthsystem/delete', 'Admin\HealthsystemController@delete');

Route::get('healthsystem/{healthsystem_id}/hco', 'Admin\HCOController@index');
Route::get('healthsystem/{healthsystem_id}/hco/add', 'Admin\HCOController@add');
Route::post('healthsystem/{healthsystem_id}/hco/add', 'Admin\HCOController@create');
Route::get('healthsystem/{healthsystem_id}/hco/edit/{id}', 'Admin\HCOController@edit');
Route::post('healthsystem/{healthsystem_id}/hco/edit/{id}', 'Admin\HCOController@save');
Route::post('healthsystem/hco/delete', 'Admin\HCOController@delete');

Route::get('healthsystem/users', 'Admin\UsersController@index');
Route::get('healthsystem/users/add', 'Admin\UsersController@create');
Route::post('healthsystem/users/add', 'Admin\UsersController@store');
Route::get('healthsystem/users/edit/{id}', 'Admin\UsersController@edit');
Route::post('healthsystem/users/edit/{id}', 'Admin\UsersController@save');
Route::post('healthsystem/users/delete', 'Admin\UsersController@delete');

Route::get('healthsystem/prospects', 'Admin\ProspectsController@index');
Route::get('healthsystem/prospects/details/{id}', 'Admin\ProspectsController@details');



Route::get('hco/{hco_id}/sites', 'Admin\SiteController@index');
Route::get('hco/{hco_id}/sites/add', 'Admin\SiteController@add');
Route::post('hco/{hco_id}/sites/add', 'Admin\SiteController@create');
Route::get('hco/{hco_id}/sites/edit/{id}', 'Admin\SiteController@edit');
Route::post('hco/{hco_id}/sites/edit/{id}', 'Admin\SiteController@save');
Route::post('hco/sites/delete', 'Admin\SiteController@delete');

Route::get('sites/{site_id}/buildings', 'Admin\BuildingController@index');
Route::get('sites/{site_id}/buildings/add', 'Admin\BuildingController@add');
Route::post('sites/{site_id}/buildings/add', 'Admin\BuildingController@create');
Route::get('sites/{site_id}/buildings/edit/{id}', 'Admin\BuildingController@edit');
Route::post('sites/{site_id}/buildings/edit/{id}', 'Admin\BuildingController@save');
Route::post('sites/buildings/delete', 'Admin\BuildingController@delete');
Route::post('sites/buildings/upload/images', 'Admin\BuildingController@uploadImages');
Route::post('sites/buildings/images/fetch', 'Admin\BuildingController@fetchImages');

Route::get('sites/{site_id}/buildings/{building_id}/departments', 'Admin\DepartmentsController@index');
Route::get('buildings/{building_id}/departments/add', 'Admin\DepartmentsController@add');
Route::post('buildings/{building_id}/departments/add', 'Admin\DepartmentsController@store');
Route::get('buildings/{building_id}/departments/{department_id}/edit', 'Admin\DepartmentsController@edit');
Route::post('buildings/{building_id}/departments/{department_id}/edit', 'Admin\DepartmentsController@save');
Route::post('departments/delete', 'Admin\DepartmentsController@delete');

Route::get('buildings/{building_id}/departments/{department_id}/rooms', 'Admin\RoomController@index');
Route::get('departments/{department_id}/rooms/create', 'Admin\RoomController@create');
Route::post('departments/{department_id}/rooms/create', 'Admin\RoomController@store');
Route::get('departments/{department_id}/rooms/{room_id}/edit', 'Admin\RoomController@edit');
Route::post('departments/{department_id}/rooms/{room_id}/edit', 'Admin\RoomController@update');
Route::post('rooms/delete', 'Admin\RoomController@destroy');


//end Healthsystem management routes

//Maintenance routes

Route::get('admin/maintenance/trades', 'Maintenance\TradeController@index');
Route::post('admin/maintenance/trades', 'Maintenance\TradeController@store');
Route::post('admin/maintenance/trades/delete', 'Maintenance\TradeController@delete');

Route::get('admin/maintenance/trades/{trade_id}/problems', 'Maintenance\ProblemsController@index');
Route::post('admin/maintenance/trades/{trade_id}/problems', 'Maintenance\ProblemsController@store');
Route::post('admin/maintenance/problems/delete', 'Maintenance\ProblemsController@delete');

Route::get('admin/maintenance/categories', 'Maintenance\CategoriesController@index');
Route::post('admin/maintenance/categories', 'Maintenance\CategoriesController@store');
Route::post('admin/maintenance/categories/delete', 'Maintenance\CategoriesController@delete');

Route::get('admin/maintenance/asset-categories', 'Maintenance\AssetCategoriesController@index');
Route::post('admin/maintenance/asset-categories', 'Maintenance\AssetCategoriesController@store');
Route::post('admin/maintenance/asset-categories/delete', 'Maintenance\AssetCategoriesController@delete');



Route::get('admin/maintenance/users', 'Maintenance\UsersController@index');
Route::get('admin/maintenance/users/add', 'Maintenance\UsersController@add');
Route::post('admin/maintenance/users/add', 'Maintenance\UsersController@store');
Route::get('admin/maintenance/users/edit/{id}', 'Maintenance\UsersController@edit');
Route::post('admin/maintenance/users/edit/{id}', 'Maintenance\UsersController@save');
Route::post('admin/maintenance/users/fetch/sites', 'Maintenance\UsersController@sites');
Route::post('admin/maintenance/users/fetch/buildings', 'Maintenance\UsersController@buildings');
Route::post('admin/maintenance/user/toggle_state', 'Maintenance\UsersController@toggleUserState');

Route::get('admin/maintenance/shifts', 'Maintenance\ShiftsController@index');
Route::get('admin/maintenance/shifts/add', 'Maintenance\ShiftsController@create');
Route::post('admin/maintenance/shifts/add', 'Maintenance\ShiftsController@store');
Route::get('admin/maintenance/shifts/edit/{id}', 'Maintenance\ShiftsController@edit');
Route::post('admin/maintenance/shifts/edit/{id}', 'Maintenance\ShiftsController@save');




















/***************************Admin Route groups*******************************/

Route::get('tjc_checklist/eops', 'Accreditation\TJCChecklistEOPController@index');
Route::get('tjc_checklist/added/eops', 'Accreditation\TJCChecklistEOPController@fetchChecklistEOPS');
Route::get('tjc_checklist/available/eops', 'Accreditation\TJCChecklistEOPController@fetchAvailableEOPS');
Route::get('tjc_checklist/fetch/standardlabels', 'Accreditation\TJCChecklistEOPController@fetchStandardLabels');
Route::post('tjc_checklist/eop/delete', 'Accreditation\TJCChecklistEOPController@delete');
Route::post('tjc_checklist/fetch/eops', 'Accreditation\TJCChecklistEOPController@fetchEOPS');
Route::post('tjc_checklist/eop/create', 'Accreditation\TJCChecklistEOPController@store');

Route::get('tjc_checklist', 'Accreditation\TJCChecklistController@index');
Route::post('tjc_checklist', 'Accreditation\TJCChecklistController@store');
Route::get('tjc_checklist/available', 'Accreditation\TJCChecklistController@available');
Route::get('tjc_checklist/added', 'Accreditation\TJCChecklistController@added');
Route::post('tjc_checklist/status/update', 'Accreditation\TJCChecklistController@update');
Route::post('tjc_checklist/delete', 'Accreditation\TJCChecklistController@delete');



/***************************Client Route groups*******************************/

Route::group(['middleware' => ['auth']], function () {
    Route::get('users', 'UsersController@index');
    Route::get('users/add', 'UsersController@create');
    Route::post('users/add', 'UsersController@store');
    Route::get('users/edit/{id}', 'UsersController@edit');
    Route::post('users/edit/{id}', 'UsersController@save');
    Route::post('users/delete', 'UsersController@delete');
    Route::post('user/password/temporary/check', 'UsersController@temporaryCheck');
    Route::post('user/password/temporary/change', 'UsersController@temporaryChange');

    Route::get('users/prospects', 'SystemProspectsController@index');
    Route::get('users/prospects/details', 'SystemProspectsController@details');
    Route::post('users/prospects/get-role', 'SystemProspectsController@getUserRole');
    Route::post('users/prospects/save-role', 'SystemProspectsController@setUserRole');


    Route::get('prequalify', 'PrequalifyController@index');
    Route::post('prequalify/configure', 'PrequalifyController@store');
    Route::get('prequalify/configure', 'PrequalifyController@create');
    Route::post('prequalify/upload', 'PrequalifyController@upload');
});




Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});
