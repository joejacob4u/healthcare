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

Route::get('/welcome', function(){
  return view('welcome');
});

Route::get('prospects/register','RegistrationController@index');
Route::post('prospects/register','RegistrationController@create');

Route::get('forgot/password','UsersController@forgotView');
Route::post('forgot/password','UsersController@sendTempPassword');

Route::post('dropzone/upload','DropzoneController@upload');
Route::post('dropzone/delete','DropzoneController@delete');
Route::post('dropzone/populate','DropzoneController@populate');


Route::get('contractors/login','ContractorAuthController@login');
Route::post('contractors/login','ContractorAuthController@authenticate');

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

Route::get('system-admin/accreditation', 'Accreditation\AccreditationController@index');
Route::post('system-admin/accreditation/set-building', 'Accreditation\AccreditationController@setBuilding');
Route::post('system-admin/accreditation/accr-requirements', 'Accreditation\AccreditationController@fetchAccrRequirements');
Route::post('system-admin/accreditation/fetch/sites', 'Accreditation\AccreditationController@fetchSites');
Route::post('system-admin/accreditation/fetch/buildings', 'Accreditation\AccreditationController@fetchBuildings');
Route::post('system-admin/accreditation/fetch/accreditation', 'Accreditation\AccreditationController@fetchAccreditations');
Route::post('system-admin/accreditation/fetch/accreditation_requirements', 'Accreditation\AccreditationController@fetchAccreditationRequirements');
Route::get('system-admin/accreditation/eop/documentation/{eop_id}', 'Accreditation\AccreditationController@eopDocumentation');
Route::post('system-admin/accreditation/eop/document/upload', 'Accreditation\AccreditationController@uploadEOPDocument');
Route::get('system-admin/accreditation/{accreditation_id}/accreditation_requirement/{accreditation_requirement_id}', 'Accreditation\AccreditationController@fetchStandardLabels');

Route::get('system-admin/accreditation/eop/status/{eop_id}', 'Accreditation\EOPStatusController@index');
Route::get('system-admin/accreditation/eop/status/{eop_id}/finding/add', 'Accreditation\EOPStatusController@addFinding');
Route::post('system-admin/accreditation/eop/status/{eop_id}/finding/add', 'Accreditation\EOPStatusController@createFinding');










/***************************Admin Route groups*******************************/


/***************************Client Route groups*******************************/

Route::group(['middleware' => ['auth']], function ()
{
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
