<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\HomeController as ControllerAdmin;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Site\HomeController as ControllerSite;
use Illuminate\Auth\Notifications\ResetPassword;

Route::prefix('/')->group(function(){
    Route::get('/', [ControllerSite::class, 'index'])->name('site.index');
    
  
});



Route::prefix('painel')->group(function(){
    Route::get('/', [ControllerAdmin::class, 'index'])->name('painel.index');
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('loginPost');

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('registerPost');

    Route::get('/password/reset', [RegisterController::class, 'resetPassword']);

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('users', [UserController::class,'index'])->name('users');

    Route::resources([
        'users' => UserController::class
    ]);

    Route::resources([
        'pages' => PageController::class
    ]);

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile/save', [ProfileController::class, 'save'])->name('profile.save');

    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::put('settings/save', [SettingController::class, 'save'])->name('settings.save');
    
});



    
Route::fallback(function(){
    return redirect()->route('site.index');
});



// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
