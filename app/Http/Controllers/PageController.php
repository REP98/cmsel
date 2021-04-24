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
	private $typeCondition  = [ 'url', 'index', 'category', 'archive', 'post', 'custom_post', 'byid'];

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
			'dataTableType' => 'page',
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
				'email',
				'users'
			],
			'dataTableTransform'=>[
				'title'=>'Titulo',
				'name' => 'Autor',
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
		$conditon = [];
		if(array_key_exists('condition', $request->condition)) {
			$conditon = $request->condition['condition'];
		}

		$user = User::find(auth()->user()->id);

		$style = new Style([
			'name' => $request->title.'.style',
			'css' => $request->css,
			'js' => $request->js,
		    'show' => array_search($request->condition['type'], $this->typeCondition),
		    'level' => '-1',
		    'user' => '-1'
		]);

		$user->styles()->save($style);

		$page = new Page([
		    'title' => $request->title,
		    'description' => [
		        'title'=> $request->title,
		        'description' => Str::limit(htmlentities(strip_tags(urldecode($request->content))), 50, '(...)')
		    ],
		    'content' => htmlentities(urldecode($request->content)),
		    'parent_id' => empty($request->parent) ? 0 : $request->parent
		]);

		$user->pages()->save($page);
		$style->level = 'page-'.$page->id;
		$style->pages()->attach($page->id);
		
		$this->Setting->pages($page->id, ['type'=>$request->condition['type'], 'condition' => $conditon]);

		return redirect()
			->route('page.edit', [$page->slug])
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
		$v = [
			'title' => $Page->title,
			'meta' => [
				'title'=> $Page->description['title'],
				'description'=> $Page->description['description'],
			],
			'content' => html_entity_decode($Page->content),
			'style' => '',
			'script' => '',
			'Model' => $Page
		];

		foreach ($Page->styles as $key => $value) {
			$v['style'] .= $value->css;
			$v['script'] .= $value->js;
		}

		return view('pages.index', $v);
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
		$data = [
			'edit' => true,
			'pages' => Page::All(),
			'page'=> $Page,
			'style'=> $Page->styles()->first(),
			'condition' => $this->Setting->pages($Page->id),
			'widgetbar' => [
				[
					'url' => route('page.index'),
					'name' => 'Páginas'
				],
				[
					'url' => route('page.create'),
					'name' => 'Añadir Página'
				]
			]
		];
		return view('dashboard.Page.new', $data); 
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
					->route('page.edit', $Page->slug)
					->withErrors($valid)
					->withInput();
		}

		if(!array_key_exists('condition', $request->condition)) {
			$request->condition['condition'] = [];
		}
		$desc = [
 			'title'=> $request->title,
		    'description' => Str::limit(htmlentities(strip_tags(urldecode($request->content))), 50, '(...)')
		];
		
		$user = User::find(auth()->user()->id);

		$Page->title = $request->title;
		$Page->description = array_merge($Page->description, $desc);
		$Page->content = htmlentities(urldecode($request->content));
		$Page->parent_id = empty($request->parent) ? 0 : $request->parent;
		
		$style = $Page->styles()->first();	
		$style->js = $request->js;
		$style->css = $request->css;
		$style->show = array_search($request->condition['type'], $this->typeCondition);

		$style->save();
		$Page->save();

		$this->Setting->pages($Page->id, $request->condition);

		return redirect()
			->route('page.edit', [$Page->slug])
			->with('status', 'Página <a target="_blank" href="/'.$Page->slug.'">'.$Page->title.'</a> Actualizada con éxito');
	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Page  $Page
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Page $Page)
	{
		$title = $Page->title;
		$Page->styles()->delete();
		$Page->delete();
		return redirect()
			->route('page.index')
			->with('status', 'Página '.$title.' borrada');
	
	}

	public function getJson($id = null) {
		if(empty($id)) {
			return response()->json(Page::All());
		}
		return response()->json(Page::find($id));
	}

	public function getBody($html)
	{
		$body = '';
		$start = stripos( $html, '<body' );
		dd($start);
		$end = stripos( $html, '<body>' );
		$body = substr($html, $start + 6, $end - $start - 1);
		return $body;	
	}
}
/*
moreiefn 
SXsheSLNy6hE*/
