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
// Route::view('/', 'welcome');
Route::get('/', function(){
	$page = new \App\Http\Controllers\PageController();
	$pag = settings('pages');
	$view = '';
	foreach ($pag as $key => $value) {
		if($value['type'] === 'index') {
			$Mp = \App\Models\Page::find($key);
			$view = $page->show($Mp);
			break;
		}
	}
	return $view;
});

Route::get('/blog/{name}', function($request){
	$name = $request->name;
	
	/*$page = new \App\Http\Controllers\PageController();
	$pag = settings('pages');
	$view = '';
	foreach ($pag as $key => $value) {
		if($value['type'] === 'index') {
			$Mp = \App\Models\Page::find($key);
			$view = $page->show($Mp);
			break;
		}
	}
	return $view;*/
});

Auth::routes();

Route::middleware(['auth:sanctum', 'verified', 'permission:ap_sessions_admin'])->group(function(){
	Route::prefix('dashboard')->group(function(){

		Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
		Route::get('/editor', function(){ return 'PÁGINA DE EDICION'; })->name('editors')->middleware(['permission:ap_config_manage read create']);

		Route::get('/test/{view}', [App\Http\Controllers\DashboardController::class, 'test']);
		
		// Pages and Template
		Route::get('/template/{type}', [\App\Http\Controllers\TemplateController::class, 'indextype'])->name('template.indextype')->middleware(['permission:ap_page read']);
		Route::get('/template/{type}/create', [\App\Http\Controllers\TemplateController::class, 'createbytype'])->name('template.newtype')->middleware(['permission:ap_page read']);

		Route::get('/page/listtojson', [\App\Http\Controllers\PageController::class, 'getJson'])->name('page.tojson');
		
		Route::resources([
			'page' => \App\Http\Controllers\PageController::class,
			'template' => \App\Http\Controllers\TemplateController::class
		]);

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
			Route::post('/', [\App\Http\Controllers\Setting::class, 'setdata'])->name('setting.set')->middleware(['permission:ap_config_manage create read', 'role:SuperAdmin|Administrador']);
		});

		Route::any('/test', function(){
			$v = settings('pages', 2, [
				'type' => 'archive',
				'condition' => [
					"archive" => "singlepost"
				]
			]);

			dd($v);
		});
	});
});
