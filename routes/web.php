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

use Illuminate\Support\Facades\Route;

// Route Language
Route::get('/en', 'LanguageController@english')->name('english');
Route::get('/th', 'LanguageController@thailand')->name('thailand');
Route::get('/km', 'LanguageController@khmer')->name('khmer');

Route::group(['middleware' => 'web', 'namespace' => 'Auth'], function () {

//    Auth::routes();
    /*
    * login
    */
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', 'LoginController@login');
    /*
    * Logout
    */
    Route::post('logout', 'LoginController@logout')->name('logout');
    /*
    * Register
    */
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');
    /*
    * Password
    */
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');
    /*
    * Verify Password
    */
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');

});

Route::group(['middleware' => 'auth'], function () {

    /*
     * Home URL
     */
    Route::get('/', 'HomeController@index')->name('home');
    /*
     * Route Role
     */
    Route::resource('/role', 'RoleController');
    Route::get('role/{role_id}/users', 'RoleController@user')->name('role.users');
    Route::get('roles/export', 'RoleController@export')->name('role.export');
    /*
     * Route User
     */
    Route::resource('/user', 'UserController');
    Route::get('user/profile/{id}','UserController@profile')->name('user.profile');
    Route::post('password/change', 'UserController@changePassword')->name('user.update.password');
    Route::post('profile/data', 'UserController@updateAbout')->name('user.change.about');
    /*
     * Route Category
     */
    Route::resource('/categories', 'CategoryController');
    Route::delete('/delete','CategoryController@deleteAll')->name('category.deleteAll');
    Route::get('category/export', 'CategoryController@exportCategory')->name('categories.export');
    Route::post('category/import', 'CategoryController@import')->name('categories.import');
    Route::get('category/pdf','CategoryController@pdf')->name('categories.pdf');
    /*
     * Route Brand
    */
    Route::resource('/brands', 'BrandController');
    Route::get('brand/export', 'BrandController@exportBrand')->name('brands.export');
    Route::post('brand/import', 'BrandController@import')->name('brands.import');
    /*
     * Route Models
    */
    Route::resource('/models', 'ModelsController');
    Route::get('model/export', 'ModelsController@export')->name('models.export');
    Route::post('model/import', 'ModelsController@import')->name('models.import');
    /*
     * Route Location
    */
    Route::resource('/locations', 'LocationController');
    Route::get('location/export', 'LocationController@export')->name('locations.export');
    Route::post('location/import', 'LocationController@import')->name('locations.import');
    /*
     * Route Status
    */
    Route::resource('/statuses', 'StatusController');
    Route::get('status/export', 'StatusController@export')->name('statuses.export');
    Route::post('status/import', 'StatusController@import')->name('statuses.import');
    /*
     * Route Status
    */
    Route::resource('/costcenters', 'CostCenterController');
    Route::get('costcenter/export', 'CostCenterController@export')->name('costcenters.export');
    Route::post('costcenter/import', 'CostCenterController@import')->name('costcenters.import');
    /*
     * Route Status
    */
    Route::resource('/assets', 'AssetController');
    Route::get('assets/detail/{id}', 'AssetController@viewDetail')->name('assets.view.detail');
    Route::get('asset/export', 'AssetController@exportAsset')->name('assets.export');
    Route::post('asset/import', 'AssetController@import')->name('assets.import');
    /*
     * Route Computer
    */
    Route::resource('/computers', 'ComputerController');
    Route::get('/computers/detail/{id}','ComputerController@computerDetail')->name('computers.detail');
    Route::get('/computer/export', 'ComputerController@exportComputer')->name('computers.export');
    /*
     * Report Manager Report
     */
    Route::group(['prefix'=>'report'],function (){
        Route::get('assets/active','AssetController@view_report_active')->name('assets.report.active');
    });

});

