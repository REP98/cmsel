<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Page;
use App\Models\Style;
use App\Models\Setting as SettingModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PageController extends Controller
{

	public $Setting;
	private $typeCondition  = [ 'index', 'category', 'archive', 'post', 'custom_post'];

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
			'dataTable' => Page::with('users')->get(),
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
			]
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
			'pages' => [],
			'widgetbar' => [
				[
					'url' => route('page.index'),
					'name' => 'Página'
				]
			]
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

		$user = User::find(auth()->user()->id);


		$style = new Style([
			'name' => 'default',
			'css' => $request->style,
			'js' => '',
		    'show' => array_search($request->condition['type'], $this->typeCondition),
		    'level' => '-1',
		    'user' => '-1'
		]);
		$user->styles()->save($s);
		$page = new Page([
		    'title' => $request->title,
		    'description' => [
		        'title'=> $request->title,
		        'description' => Str::limit($request->content, 50, '(...)')
		    ],
		    'content' => htmlentities(urldecode($request->content)),
		    'parent_id' => empty($request->parent) ? 0 : $request->parent
		]);
		$user->pages()->save($page);
		$style->pages()->attach($page->id)
		
		$this->Setting->pages($page->id, $request->condition);

		return route('page.update', [$page->id])
			->with('status', 'Página <a target="_blank" href="/'.$page->slug.'">'.$page->title.'</a> Guardada con éxito');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Page  $Page
	 * @return \Illuminate\Http\Response
	 */
	public function show(Page $Page)
	{
		// Aqui debemos redireccionar al pagina en el Front-END del Site
		debug($Page);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Page  $Page
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Page $Page)
	{
		$this->middleware(['auth:sanctum', 'permission:ap_page update']);
		debug($Page->all()->id);
		return '<h1></h1>';
		/*return view('dashboard.Page.new', [
			'edit' => true,
			'page' => $Page,
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
		]); */
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Page  $Page
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Page $Page)
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
					->route('page.edit', $Page->id)
					->withErrors($valid)
					->withInput();
		}
		debug($request->all(), $Page);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Page  $Page
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Page $Page)
	{
		debug($Page);
	}
}
