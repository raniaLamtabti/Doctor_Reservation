<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UpworkController;

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

Route::get('/home', function () {
    return view('home');
});

Auth::routes();

Route::get('/index', [DoctorController::class, 'index'])->name('index');
Route::post('/find', [DoctorController::class, 'find'])->name('find');
Route::get('/show/{id}', [DoctorController::class, 'show'])->name('show');
Route::get('/apply', function () {
    return view('apply');
});
Route::post('/store', [DoctorController::class, 'store'])->name('storeDoctor');

Route::get('/blog', [ArticleController::class, 'index'])->name('index');
Route::get('/showArticle/{id}', [ArticleController::class, 'show'])->name('showArticle');

Route::prefix('user')->name('user.')->group(function(){

    Route::middleware(['guest:web'])->group(function(){
          Route::view('/login','dashboard.user.login')->name('login');
          Route::view('/register','dashboard.user.register')->name('register');
          Route::post('/create',[UserController::class,'create'])->name('create');
          Route::post('/check',[UserController::class,'check'])->name('check');
    });

    Route::middleware(['auth:web'])->group(function(){
          Route::view('/home','dashboard.user.home')->name('home');
          Route::post('/logout',[UserController::class,'logout'])->name('logout');
          Route::get('/add-new',[UserController::class,'add'])->name('add');
          Route::post('/createReservation', [ReservationController::class, 'store'])->name('createReservation');
          Route::put('/updateReservation/{id}', [ReservationController::class, 'update'])->name('updateReservation');
          Route::put('/cancelReservation/{id}', [ReservationController::class, 'cancel'])->name('cancelReservation');
          Route::post('/createComment', [CommentController::class, 'store'])->name('createComment');
          Route::get('/userEdit/{id}', [UserController::class, 'edit'])->name('editUser');
          Route::put('/userUpdate/{id}', [UserController::class, 'update'])->name('userUpdate');
          Route::put('/userPassword/{id}', [UserController::class, 'updatePassword'])->name('userPassword');
    });

});

Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin'])->group(function(){
          Route::view('/login','dashboard.admin.login')->name('login');
          Route::post('/check',[AdminController::class,'check'])->name('check');
    });

    Route::middleware(['auth:admin'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::put('/acceptDoctor/{id}', [DoctorController::class, 'accept'])->name('acceptDoctor');
        Route::put('/rejectDoctor/{id}', [DoctorController::class, 'reject'])->name('rejectDoctor');
        Route::get('/adminEdit/{id}', [AdminController::class, 'edit'])->name('editAdmin');
        Route::put('/adminUpdate/{id}', [AdminController::class, 'update'])->name('adminUpdate');
        Route::put('/adminPassword/{id}', [AdminController::class, 'updatePassword'])->name('adminPassword');
        Route::view('/blog','dashboard.admin.blog')->name('blog');
        Route::post('/articleCreate', [ArticleController::class, 'store'])->name('articleCreate');
        Route::put('/articleUpdate/{id}', [ArticleController::class, 'update'])->name('articleUpdate');
        Route::put('/articleLike/{id}', [ArticleController::class, 'like'])->name('articleLike');
        Route::delete('/articleDelete/{id}', [ArticleController::class, 'destroy'])->name('articleDelete');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
    });

});

Route::prefix('doctor')->name('doctor.')->group(function(){

       Route::middleware(['guest:doctor'])->group(function(){
            Route::view('/login','dashboard.doctor.login')->name('login');
            Route::view('/register','dashboard.doctor.register')->name('register');
            Route::post('/create',[DoctorController::class,'create'])->name('create');
            Route::post('/check',[DoctorController::class,'check'])->name('check');
       });

       Route::middleware(['auth:doctor'])->group(function(){
            Route::view('/home','dashboard.doctor.home')->name('home');
            Route::put('/doneReservation/{id}', [ReservationController::class, 'done'])->name('doneReservation');
            Route::put('/missedReservation/{id}', [ReservationController::class, 'missed'])->name('missedReservation');
            Route::get('/doctorEdit/{id}', [DoctorController::class, 'edit'])->name('editDoctor');
            Route::put('/doctorUpdate/{id}', [DoctorController::class, 'update'])->name('doctorUpdate');
            Route::put('/imageUpdate/{id}', [DoctorController::class, 'updateImage'])->name('imageUpdate');
            Route::put('/doctorPassword/{id}', [DoctorController::class, 'updatePassword'])->name('doctorPassword');
            Route::get('/uptime', [UpworkController::class, 'index'])->name('uptime');
            Route::post('/uptimeCreate', [UpworkController::class, 'store'])->name('uptimeCreate');
            Route::put('/uptimeUpdate/{id}', [UpworkController::class, 'update'])->name('uptimeUpdate');
            Route::delete('/uptimeDelete/{id}', [UpworkController::class, 'destroy'])->name('uptimeDelete');
            Route::post('/vacationCreate', [VacationController::class, 'store'])->name('vacationCreate');
            Route::put('/vacationUpdate/{id}', [VacationController::class, 'update'])->name('vacationUpdate');
            Route::delete('/vacationDelete/{id}', [VacationController::class, 'destroy'])->name('vacationDelete');
            Route::post('logout',[DoctorController::class,'logout'])->name('logout');
       });

});
