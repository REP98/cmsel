<?php

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
Route::view('/', 'welcome');

Auth::routes();
Route::middleware(['auth:sanctum', 'verified', 'permission:ap_sessions_admin'])->group(function(){
	Route::prefix('dashboard')->group(function(){
		Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
	});
});
