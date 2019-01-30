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

/**
 * Rutas típicas de autentificación de la app.
 * reemplazando: Auth::routes();
 */
Route::group(['namespace' => 'Auth'], function () {
    Route::group(['middleware' => 'guest'], function () {

        // Rutas de Autentificación...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');

        // Rutas de Registro... 
        if (config('frontend.registration_open')) {
            Route::get('registro', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register');
        }
    });
    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::post('app', 'RouteController@dataForTemplate');
Route::get('logging/{id}', 'RouteController@initSession');

/**
 * Requieren autentificación.
 */
Route::group(['middleware' => ['auth', 'onlyAjax']], function () {

    /**
     * Admin, Acceso para usuarios con privilegios.
     * "/admin/*"
     */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin::'], function () {

        // Users Routes...
        Route::resource('users', 'UsersController')->except(['create', 'edit']);
        Route::post('get-data-users', 'UsersController@dataForRegister');

        // Roles Routes...
        Route::resource('roles', 'RolesController')->except(['create', 'edit']);
        Route::post('get-data-roles', 'RolesController@dataForRegister');

        // Permissions Routes...
        Route::resource('permissions', 'PermissionsController')->only(['index', 'show', 'update']);

    });

    Route::group(['prefix' => '/', 'namespace' => 'Dashboard', 'as' => 'Dashboard::'], function () {
        Route::get('profile', 'ProfileController@show');
        Route::post('change-pass', 'ProfileController@editPassword');
        Route::post('update-user', 'ProfileController@editUser');
    });

    Route::group(['namespace' => 'Course', 'as' => 'Course::'], function () {

        // Courses Routes...
        Route::resource('courses', 'CourseController')->except(['create', 'edit']);
        Route::post('get-data-course', 'CourseController@dataForRegister');

        // Inscriptions Routes...
        Route::resource('inscriptions', 'InscriptionsController')->only(['index', 'store', 'destroy']);
        Route::post('get-data-inscription', 'InscriptionsController@dataForRegister');

        // Assistance Control Routes...
        Route::resource('assistance', 'AssistanceControlController')->only(['index', 'store', 'update']);
        Route::post('get-data-assistance', 'AssistanceControlController@dataForRegister');

        // Notify Routes...
        Route::resource('notify', 'NotifyController')->except(['create', 'edit']);

        // Companies Routes...
        Route::resource('company', 'CompanyController')->except(['create', 'edit']);

    });

    Route::post('get-data-pay-teacher', 'ReportsController@dataTopdf_pay');

    Route::post('admin/app', 'RouteController@canPermission');

});

/*
* Reports
*/
Route::get('pdf-inscription/{course_id}/{user_id}', 'ReportsController@pdf_inscription');
Route::get('pdf-course-inscription/{user_id}', 'ReportsController@pdf_course_inscription');
Route::get('pdf-assistance/{course_id}/{user_id}', 'ReportsController@assistance');
Route::get('pdf-course-teacher/{user_id}', 'ReportsController@pdf_course_teacher');
Route::get('pdf-pay-teacher/{user_id}', 'ReportsController@pdf_pay_teacher');

Route::get('{any?}', 'RouteController@index')->where('any', '.*');
