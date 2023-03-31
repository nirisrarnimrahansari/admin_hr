<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// // */

Route::get('send-mail', function () {
   
    $details = [
        'title' => 'Mail from abssoftech.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    \Mail::to('nimrah271999@gmail.com')->send(new \App\Mail\MyTestMail($details));
   
    dd("Email is Sent.");
});



Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
		\UniSharp\LaravelFilemanager\Lfm::routes();
	});
	Route::get('/','App\Http\Controllers\HomeController@index', 'index')->name('home');
	Route::get("/media", function(){
		return View::make("pages.file_manager.file_manager");
	 })->name('media');
	Route::resource('/designation','App\Http\Controllers\DesignationController');
	Route::resource('/shift','App\Http\Controllers\ShiftController');
	Route::resource('/department','App\Http\Controllers\DepartmentController');
	Route::resource('/holiday','App\Http\Controllers\HolidayController');
	Route::resource('/employee','App\Http\Controllers\EmployeeController');
	Route::post('/employee/email','App\Http\Controllers\EmployeeController@email')->name('employee-email'); 
	Route::resource('/permission','App\Http\Controllers\PermissionController');
	Route::resource('/leave-management','App\Http\Controllers\LeaveManagementController');
	Route::post('/leave-management/updatetype/{id}','App\Http\Controllers\LeaveManagementController@updateType')->name('leave-management.updateType');
	Route::get('/calender/{month}/{year}/{employee}','App\Http\Controllers\LeaveManagementController@show', 'show')->name('calender');
	Route::post('/leave-management/import', 'App\Http\Controllers\LeaveManagementController@import')->name('import');  
	
	Route::resource('/generate-salary','App\Http\Controllers\GenerateSalaryController');
	Route::resource('/offer-letter','App\Http\Controllers\OfferLetterController');
	Route::resource('/email-format','App\Http\Controllers\EmailController');
	Route::post('/generate-salary/send-emailtoall','App\Http\Controllers\GenerateSalaryController@emailToAll')->name('send-selected-email');
	Route::get('/import-export/{month}/{year}/{subject_id}','App\Http\Controllers\ImportExportController@show', 'show')->name('import-export');
	
	Route::resource('/leave-status','App\Http\Controllers\LeaveStatusController');
	Route::resource('/user-role','App\Http\Controllers\UserRoleController');
	Route::resource('/user-permission','App\Http\Controllers\UserPermissionController');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	
});

