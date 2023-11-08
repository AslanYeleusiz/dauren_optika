<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GlassTypesController;
use App\Http\Controllers\Admin\LensTypesController;
use App\Http\Controllers\Admin\LensController;
use Inertia\Inertia;

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
    return Inertia::render('Admin/home');
})->name('index');
Route::resource('types', GlassTypesController::class)->except(['show'])->names('types');
Route::resource('lensTypes', LensTypesController::class)->except(['show'])->names('lensTypes');
Route::resource('lenses', LensController::class)->except(['show'])->names('lenses');

//Route::middleware('adminAuth')->group(function () {
//    Route::resource('roles', RoleController::class)->except(['show'])->names('roles');
//});
