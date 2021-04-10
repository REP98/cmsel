<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Setting;

class DashboardController extends Controller
{
	public $Setting;

    public function __construct()
    {
        $this->middleware('auth');
        $this->Setting = new Setting();
    }

    public function index()
    {
/*
    	$this->Setting->setConfig('menu', [
    		'Página'=>[
    			'url'=>route('page'),
    			'level' => 'ap_page read',
    			'order' => 1,
    			'submenu'=> [
    				'Nueva' => [
    					'url' => route('page.new'),
    					'level' => 'ap_page create'
    				]
    			]
    		],
    		'Entradas' => [
    			'url' => route('post'),
    			'level' => 'ap_post read',
    			'order' => 2,
    			'submenu' => [
    				'Añadir' => [
    					'url' => route('post.new'),
    					'level' => 'ap_post create'
    				],
    				'Categorias' => [
    					'url' => route('post.category'),
    					'level' => 'ap_post_cat create'
    				],
    				'Etiquetas' => [
    					'url' => route('post.tag'),
    					'level' => 'ap_post_tag create'
    				]
    			]
    		],
    		'Plantillas' => [
    			'url' => route('template'),
    			'level' => 'ap_page read',
    			'order' => 6,
    			'submenu' => [
    				'Cabezera' => [
    					'url' => route('template.header'),
    					'level' => 'ap_page read create'
    				],
    				'Sección' => [
    					'url'=> route('template.section'),
    					'level' => 'ap_page read create'
    				],
    				'Pie' => [
    					'url' => route('template.footer'),
    					'level' => 'ap_page read create'
    				],
    				'Widget' => [
    					'url' => route('template.widget'),
    					'level' => 'ap_page read create'
    				]
    			]
    		],
    		'Style'=> [
    			'url' => route('editors'),
    			'order' => 9,
    			'level' => 'ap_config_manage read create'
    		],
    		'Usuarios' => [
    			'url' => route('user'),
    			'order' => 10,
    			'level' => 'ap_user_manager read create',
    			'submenu' => [
    				'Perfil' => [
    					'url' => ['user.profile','id'],
    					'level' => 'ap_sessions_admin read'
    				],
    				'Nuevo' => [
    					'url' => route('user.new'),
    					'level' => 'ap_user_manager create'
    				],
    				'Permisos' => [
    					'url' => route('user.permissions'),
    					'level' => 'read create',
    					'role' => 'SuperAdmin|Administrador'
    				]
    			]
    		],
    		'Ajustes' => [
    			'url' => route('setting'),
    			'level' => 'ap_config_manage create read',
    			'role' => 'SuperAdmin|Administrador',
    			'order' => 13,
    		]
    	]);
*/
    	return view('dashboard.index', ['setting' => $this->Setting->get()]);
    }
}
