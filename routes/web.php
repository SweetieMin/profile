<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

//Route test
Route::view('/examble-page','examble-page');
Route::view('/examble-auth','examble-auth');

//Route Admin

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::controller(AuthController::class)->group(function(){
            Route::get('/login','loginForm')->name('login');
            Route::post('/login','loginHandler')->name('login_handler');
            Route::get('/fotgot-password','forgotForm')->name('forgot');
            Route::post('/send-password-reset-link','sendPasswordResetLink')->name('send_password_reset_link');
            Route::get('/password/reset/{token}','resetForm')->name('reseet_password_form');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::controller(AdminController::class)->group(function(){
            Route::get('/dashboard','adminDashboard')->name('dashboard');
            Route::post('/logout','logoutHandler')->name('logout');
        });
    });

});
