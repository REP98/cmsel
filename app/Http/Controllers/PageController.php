<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PagesModel;
use App\Models\Style;
use App\Models\Setting as SettingModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


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
				'email'
			],
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
			'title' => ['required']
		],
		[
			'title.required' => 'Solicitamos un titulo para su página'
		]);

		if ($valid->fails()) {
			return redirect('page/create')
					->withErrors($valid)
					->withInput();
		}

		$description = [
			'title' => $request->title,
			'description' => Str::limit($request->content, 50, '(...)')
		];
		$style = new Style([
			'name' => 'default',
			'css' => $request->style
		]);
		$pageData = [
			'title' => $request->title,
	        'description' => json_encode($description),
	        'content' => htmlentities(urldecode($request->content))
		];
		if (!empty($request->parent)) {
			$pageData['parent_id'] = $request->parent;
		}
		$page = PagesModel::create($pageData);
		$page->styles()->sync($style);
		$page->PostAutor()->sync(auth()->user());
		$page->save();

		$this->Setting->setConfig('page', [[
					'id'=>$page->id,
					'condition'=> $request->condition
				]]);

		return route('page.update', [$page->id])
			->with('status', 'Página <a target="_blank" href="/'.$page->slug.'">'.$page->title.'</a> Guardada con éxito');
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
			'title' => ['required']
		],
		[
			'title.required' => 'Solicitamos un titulo para su página'
		]);

		if ($valid->fails()) {
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
