<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

	protected $typeI18n = [
		'footer' => 'pie',
		'header' => 'cabezera',
		'section' =>'sección',
		'widget' => 'widget'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	   $this->middleware(['auth:sanctum', 'permission:ap_page read']);
	   return view('dashboard.template.index', [
			'widgetbar' => [
				[
					'url' => route('template.newtype', ['footer']),
					'name' => 'Añadir Pie'
				],
				[
					'url' => route('template.newtype', ['header']),
					'name' => 'Añadir Cabezera'
				],
				[
					'url' => route('template.newtype', ['section']),
					'name' => 'Añadir Sección'
				],
				[
					'url' => route('template.newtype', ['widget']),
					'name' => 'Añadir Widget'
				]
			],
			'dataTableType' => 'template',
			'dataTable' => Template::with('users')->get(),
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
				'content',
				'users'
			],
			'dataTableTransform'=>[
				'name'=>'Titulo',
				'type' =>'Tipo',
				'shotcode' => 'Código corto',
			]
		]);
	}
	/**
	 * Display a listing of the resource by type.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indextype(Request $Request)
	{
		$this->middleware(['auth:sanctum', 'permission:ap_page read']);

		return view('dashboard.template.index', [
			'widgetbar' => [
				[
					'url' => route('template.newtype', [$Request->type]),
					'name' => 'Añadir '.ucwords($this->typeI18n[$Request->type])
				]
			],
			'dataTableType' => 'template',
			'dataTable' => Template::with('users')->where('type', $Request->type)->get(),
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
				'content',
				'users',
				'type'
			],
			'dataTableTransform'=>[
				'name'=>'Titulo',
				'shotcode' => 'Código corto',
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
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Template  $template
	 * @return \Illuminate\Http\Response
	 */
	public function show(Template $template)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Template  $template
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Template $template)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Template  $template
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Template $template)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Template  $template
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Template $template)
	{
		//
	}
}
