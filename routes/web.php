<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\RecordsController;
use Illuminate\Support\Facades\Auth;
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
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::resource('/employees', EmployeesController::class, [
            'parameters' => ['employees' => 'user']
        ])->middleware(['manager']);

        Route::resource('/records', RecordsController::class);
        Route::prefix('/records')->name('records.')->group(function () {
            Route::get('/by-category/{category}', [RecordsController::class, 'indexByCategory'])->name('byCategory');
            Route::get('/by-author/{author}', [RecordsController::class, 'indexByAuthor'])->name('byAuthor');
        });


    });

Auth::routes();
