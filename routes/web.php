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
    Route::middleware([])->group(function () {
        Route::controller(AuthController::class)->group(function(){
            Route::get('/login','loginForm')->name('login');
            Route::post('/login','loginHandler')->name('login_handler');
            Route::get('/fotgot-password','forgotForm')->name('forgot');    
        });
    });

    Route::middleware([])->group(function () {
        Route::controller(AdminController::class)->group(function(){
            Route::get('/dashboard','adminDashboard')->name('dashboard');
        });
    });

});
