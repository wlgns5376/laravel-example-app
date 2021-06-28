<?php

use App\Events\Test;
use App\Http\Controllers\PermissionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ContactController;

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
    return Inertia::render('Home', [
    ]);
})->name('home');

Route::get('/broadcast', function () {
    broadcast(new Test);

    return 'broadcast';
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    Route::resource('roles', RoleController::class)->middleware('can:access_role');
    Route::resource('permissions', PermissionController::class)->middleware('can:access_permission');
    Route::resource('contacts', ContactController::class)->middleware('can:access_contact');
});
