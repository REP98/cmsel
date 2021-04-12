<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PagesModel;
use App\Models\Setting as SettingModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Setting;

class PageController extends Controller
{

	public $Setting;

	public function __construct()
	{
		$this->middleware(['auth:sanctum', 'verified', 'permission:ap_sessions_admin']);
		$this->Setting = new Setting();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->middleware(['auth:sanctum', 'permission:ap_page read']);
		return view('dashboard.Page.page', [
			'widgetbar' => [
				[
					'url' => route('page.create'),
					'name' => 'Añadir Página'
				]
			],
			'dataTable' => PagesModel::with('PostAutor')->get(),
			'dataTableExclude' => [
				"created_at", 
				"user_id", 
				'style_id', 
				'parent_id', 
				'description', 
				'content',
				'email_verified_at',
				'password',
				'email'],
			'dataTableTransform'=>[
				'title'=>'Titulo',
				'name' => 'Autor'
			],
			'setting' => $this->Setting->get()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->middleware(['auth:sanctum', 'permission:ap_page read']);
		return view('dashboard.Page.new', [
			'edit' => false,
			'page' => [],
			'widgetbar' => [
				[
					'url' => route('page.index'),
					'name' => 'Página'
				]
			],
			'setting' => $this->Setting->get()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->middleware(['auth:sanctum', 'permission:ap_page create']);

		$valid = Validator::make($request->all(), 
		[
			'title' => 'require'
		],
		[
			'title' => 'Solicitamos un titulo para su página'
		]);

		if ($valid->fail()) {
			return redirect('page/create')
					->withErrors($valid)
					->withInput();
		}
		/*
		$user = User::find($request->autor);
		$style = 
		$pageData = [
			'title' => $request->title,
	        'description' => $request->description,
	        'content' => $request->content,
	        'style_id' ,
	        'user_id'
		];
		*/
		debug($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\PagesModel  $pagesModel
	 * @return \Illuminate\Http\Response
	 */
	public function show(PagesModel $pagesModel)
	{
		// Aqui debemos redireccionar al pagina en el Front-END del Site
		debug($pagesModel);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\PagesModel  $pagesModel
	 * @return \Illuminate\Http\Response
	 */
	public function edit(PagesModel $pagesModel)
	{
		$this->middleware(['auth:sanctum', 'permission:ap_page update']);
		
		return view('dashboard.Page.new', [
			'edit' => true,
			'page' => $pagesModel,
			'widgetbar' => [
				[
					'url' => route('page.index'),
					'name' => 'Páginas'
				],
				[
					'url' => route('page.create'),
					'name' => 'Añadir Página'
				]
			],
			'setting' => $this->Setting->get()
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PagesModel  $pagesModel
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, PagesModel $pagesModel)
	{
		$this->middleware(['auth:sanctum', 'permission:ap_page update']);

		$valid = Validator::make($request->all(), 
		[
			'title' => 'require'
		],
		[
			'title' => 'Solicitamos un titulo para su página'
		]);

		if ($valid->fail()) {
			return redirect()
					->route('page.edit', $pagesModel->id)
					->withErrors($valid)
					->withInput();
		}
		debug($request->all(), $pagesModel);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\PagesModel  $pagesModel
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(PagesModel $pagesModel)
	{
		debug($pagesModel);
	}
}
