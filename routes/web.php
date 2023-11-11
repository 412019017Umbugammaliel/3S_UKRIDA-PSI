<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserloginController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome',);
// });

Route::get('/', [WelcomeController::class, 'index']);

Route::controller(authController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('forgotpassword', 'forgotPassword')->name('password.forgot');
    // Route::post('forgotpassword', 'sendPasswordResetLink')->name('password.forgot.post');

    route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware(['web', 'admin'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rute-rute untuk pengguna admin
    Route::prefix('userdata')->group(function () {
        // Rute-rute CRUD untuk pengguna
        Route::get('', [UserController::class, 'index'])->name('userdata');
        Route::get('create', [UserController::class, 'create'])->name('userdata.create');
        Route::post('store', [UserController::class, 'store'])->name('userdata.store');
        Route::get('{id}', [UserController::class, 'show'])->name('userdata.show');

        Route::get('{id}/edit', [UserController::class, 'edit'])->name('userdata.edit');
        Route::put('{id}', [UserController::class, 'update'])->name('userdata.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('userdata.destroy');
    });

    // Rute untuk profil admin
    Route::get('/profile', [authController::class, 'profile'])->name('profile');
    Route::put('/profile', [authController::class, 'updateProfile'])->name('updateprofile');
    Route::put('/profile/updatepassword', [authController::class, 'updatePassword'])->name('updatepassword');

    // Rute-rute untuk Pagecontent
    Route::prefix('pagecontent')->middleware(['auth', 'admin'])->group(function () {
        Route::get('', [ContentController::class, 'index'])->name('pagecontent');
        Route::get('create', [ContentController::class, 'create'])->name('pagecontent.create');
        Route::post('store', [ContentController::class, 'store'])->name('pagecontent.store');
        Route::get('{id}', [ContentController::class, 'show'])->name('pagecontent.show');



        Route::get('{id}/edit', [ContentController::class, 'edit'])->name('pagecontent.edit');
        // Perbarui rute 'updatecontent' dengan menggunakan metode PUT.
        Route::put('updatecontent/{id}', [ContentController::class, 'updatecontent'])->name('pagecontent.updatecontent');
        Route::delete('{id}', [ContentController::class, 'destroy'])->name('pagecontent.destroy');
    });


    // Rute-rute untuk Pageevent
    Route::prefix('pageevent')->group(function () {
        Route::get('', [EventController::class, 'index'])->name('pageevent');
        Route::get('create', [EventController::class, 'create'])->name('pageevent.create');
        Route::post('store', [EventController::class, 'store'])->name('pageevent.store');
        Route::get('{id}', [EventController::class, 'show'])->name('pageevent.show');

        Route::get('{id}/edit', [EventController::class, 'edit'])->name('pageevent.edit');
        Route::put('updateevent/{id}', [EventController::class, 'updateevent'])->name('pageevent.updateevent');
        Route::delete('{id}', [EventController::class, 'destroy'])->name('pageevent.destroy');
    });

    //Rute-rute untuk page category
    Route::prefix('pagecategory')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('pagecategory');
        Route::get('create', [CategoryController::class, 'create'])->name('pagecategory.create');
        Route::post('store', [CategoryController::class, 'store'])->name('pagecategory.store');
        Route::get('{id_category}', [CategoryController::class, 'show'])->name('category.show');

        Route::get('{id_category}/edit', [CategoryController::class, 'edit'])->name('pagecategory.edit');
        Route::put('updatecategory/{id_category}', [CategoryController::class, 'updatecategory'])->name('pagecategory.updatecategory');
        Route::delete('{id_category}', [CategoryController::class, 'destroy'])->name('pagecategory.destroy');

    });

    //Rute-rute untuk page question
    Route::prefix('pagequestion')->group(function () {
        Route::get('', [QuestionController::class, 'index'])->name('pagequestion');
        Route::get('create', [QuestionController::class, 'create'])->name('pagequestion.create');
    });
});

// Rute "userlogin" hanya dapat diakses oleh pengguna "User" (tidak perlu middleware)
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('userlogin', function () {
        return view('userlogin.index');
    })->name('userlogin');

    Route::get('/userlogin', [UserloginController::class, 'index'])->name('userlogin');
});

Route::middleware(['web', 'counselor'])->group(function () {
    Route::get('counselorlogin', function () {
        return view('counselorlogin.index');
    })->name('counselorlogin');
});