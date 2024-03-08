<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;

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

Route::get('/', function () {
    return redirect('home');
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);

    Route::resource('attendances', AttendanceController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('schedules', ScheduleController::class);

    Route::get('getEmployees', [EmployeeController::class, 'listEmployees'])->name('listEmployees');
    Route::get('listSchedules', [ScheduleController::class, 'listSchedules'])->name('listSchedules');
    Route::get('events', [AttendanceController::class, 'events'])->name('events');
    Route::get('getEvents', [AttendanceController::class, 'getEvents'])->name('getEvents');
    Route::get('today', [AttendanceController::class, 'today'])->name('today');
    Route::get('getToday', [AttendanceController::class, 'getToday'])->name('getToday');
    Route::get('at', [AttendanceController::class, 'at'])->name('at');

    Route::get('month', [AttendanceController::class, 'month'])->name('month');
    Route::get('getMonth', [AttendanceController::class, 'getMonth'])->name('getMonth');

    Route::get('month2', [AttendanceController::class, 'month2'])->name('month2');
    Route::get('getMonth2/{mes?}/{anio?}', [AttendanceController::class, 'getMonth2'])->name('getMonth2');
});


Route::get('/users2', [UserController::class, 'index2'])->name('users.index2');
