<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
		Route::get('/editor', function(){ return 'PÁGINA DE EDICION'; })->name('editors')->middleware(['permission:ap_config_manage read create']);

		Route::get('/test/{view}', [App\Http\Controllers\DashboardController::class, 'test']);
		// Pages
		Route::resource('page', \App\Http\Controllers\PageController::class)->middleware(['permission:ap_page read']);

		// Medios
		Route::group(['prefix' => 'filemanager', 'middleware' => ['auth:sanctum', 'permission:ap_sessions_admin']], function () {
			\UniSharp\LaravelFilemanager\Lfm::routes();
        });
		
		// Post
		Route::prefix('post')->middleware(['permission:read'])->group(function(){
			Route::get('/', function(){ return 'PÁGINA DE POST'; })->name('post')->middleware(['permission:ap_post read']);
			Route::get('/new', function(){ return 'NUEVO POST'; })->name('post.new')->middleware(['permission:ap_post create']);
			Route::get('/categorys', function(){ return 'PAGINA DE CATEGORIAS'; })->name('post.category')->middleware(['permission:ap_post_cat create']);
			Route::get('/tags', function(){ return 'PAGINA DE ETIQUETAS'; })->name('post.tag')->middleware(['permission:ap_post_tag create']);
		});

		// Plantillas
		Route::prefix('template')->middleware(['permission:ap_page read'])->group(function(){
			Route::get('/', function(){ return 'PÁGINA DE PLANTILLAS'; })->name('template');
			Route::get('/header', function(){ return 'CABEZERAS'; })->name('template.header')->middleware(['permission:create']);
			Route::get('/sections', function(){ return 'SECCIONES'; })->name('template.section')->middleware(['permission:create']);
			Route::get('/footer', function(){ return 'PIE'; })->name('template.footer')->middleware(['permission:create']);
			Route::get('/widget', function(){ return 'widget'; })->name('template.widget')->middleware(['permission:create']);
		});

		// Usuarios
		Route::prefix('user')->middleware(['permission:ap_user_manager read'])->group(function(){
			Route::get('/', function(){	return 'USUARIOS';	})->name('user');
			Route::get('/profile/{id}', function(){	return 'MI PERFIL';	})->name('user.profile')->middleware(['permission:ap_sessions_admin']);
			Route::get('/new', function(){	return 'NUEVOS USUARIOS';	})->name('user.new')->middleware(['permission:create']);
			Route::get('/permissions', function(){	return 'PERMISOS y ROLES';	})->name('user.permissions')->middleware(['permission:read create', 'role:SuperAdmin|Administrador']);
		});

		// Ajustes
		Route::prefix('setting')->middleware(['permission:ap_user_manager read'])->group(function(){
			Route::get('/', [\App\Http\Controllers\Setting::class, 'index'])->name('setting')->middleware(['permission:ap_config_manage create read', 'role:SuperAdmin|Administrador']);
		});
		Route::any('/test', function(){
			$v = settings('menu', 'dashboard.Archivos',[
	                        'url' => route('unisharp.lfm.show'),
	                        'order' => 3,
	                        'level' => 'read create'
	                    ]);
			dd($v);
		});
	});
});
