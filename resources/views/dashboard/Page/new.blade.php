@extends('layouts.dashboard')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
	   {{ session('status') }}
	    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
	   {{ session('error') }}
	    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif

<form class="form" id="page" method="post" action="@if(!empty($edit)) {{route('page.update', [$page->id])}} @else {{route('page.store')}} @endif">
	@csrf
	<!-- CAMPOS OCULTOS -->
	<input type="hidden" name="content" id='content'>
	<nav class="w-100">
		<ul class="nav nav-tabs nav-fill" id="tabOptions" role="tablist">
			<li class="nav-item" role="presentation">
				<a href="#" class="nav-link active" id="tinymce-editor" data-bs-toogle="tab" data-target="#tinymce" role="tab" aria-selected="true" aria-control="tinymce">Editor</a>
			</li>
			<li class="nav-item" role="presentation">
				<a href="#" class="nav-link" id="html-editor" data-bs-toogle="tab" data-target="#html" role="tab" aria-selected="false" aria-control="html">HTML</a>
			</li>
			<li class="nav-item" role="presentation">
				<a href="#" class="nav-link" id="css-editor" data-bs-toogle="tab" data-target="#css" role="tab" aria-selected="false" aria-control="css">CSS</a>
			</li>
			<li class="nav-item" role="presentation">
				<a href="#" class="nav-link" id="js-editor" data-bs-toogle="tab" data-target="#js" role="tab" aria-selected="false" aria-control="js">JS</a>
			</li>
			
		</ul>
	</nav>
	<div class="tab-content" id="contentCampo">
		<div class="tab-pane fade show" id="tinymce" role="tabpanel" aria-labelledby="tinymce-editor">
			<div class="row mb-2">
				<div class="col-12 d-flex justify-content-around">
					<div class="inpt-group w-50 d-inline-flex me-2" aria-label="Condiciones">
						<span class="input-group-text" id="text">Página Padre</span>
						<select class="form-select" name="parent">
							<option value="">Ningúna</option>
							@foreach($pages as $p)
							<option value="{{$p->id}}" @if(!empty($edit) && $page->parent_id === $p->id) selected @endif>{{$p->title}}</option>
							@endforeach
						</select>
					</div>
					<div class="inpt-group w-50 d-inline-flex me-2" aria-label="Condiciones">
						<span class="input-group-text" id="text">Mostrar en</span>
						<select class="form-select" name="condition[type]">
							@php
								$condition_type = [
										'index' => 'Principal',
										'category' => 'Categoría',
										'archive' => 'Archivo',
										'post' => 'Entradas',
										'custom_post' => 'Entradas Personalizadas'
								];
							@endphp
							@foreach($condition_type as $name => $value)
							<option value="{{$name}}">{{$value}}</option>
							@endforeach
						</select>
						<span class="input-group-text" id="text">si</span>
						<select class="form-select" disabled id="loadajax" name="condition[ifset]">
							<option value="all">Todos</option>
						</select>
					</div>
					<div class="btn-group" role="group" aria-label="Grupo de Opciones Avanzadas">
						<button type="submit" class="btn btn-outline-success" id="savepage"> Guardar</button>
						<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalcode">
							<i class="fas fa-cog"></i> <span class="d-none-md">CSS/JS</span>
						</button>
					</div>
				</div>
			</div>
			
			<input type="text" class="form-control w-100 mb-2" name="title" placeholder="Ingrese su titulo">
			@include('component.editor-inline')
		</div>
		<div class="tab-pane fade" id="html" role="tabpanel" aria-labelledby="html-editor">
			@include('component.codeditor', ['attr' => 'id="html-codeditor"'])
		</div>
		<div class="tab-pane fade" id="css" role="tabpanel" aria-labelledby="css-editor">
			@include('component.codeditor', ['attr' => 'id="css-codeditor" name="style"', 'langCode' => 'text/css'])
		</div>
		<div class="tab-pane fade" id="js" role="tabpanel" aria-labelledby="js-editor">
			@include('component.codeditor', ['attr' => 'id="js-codeditor" name="script"', 'langCode' => 'aplication/javascript'])
		</div>
	</div>
</form>
@endsection
@section('script')
@parent

_$('[data-bs-toogle="tab"]').on('show.bs.tab', function(e){
	let target = e.target
	let previusTab = e.relatedTarget

	console.dir(target, previusTab)
})
_$('form#page').on('submit', function(e){
	e.preventDefault();

	let ta = _$.getValueActiveEditor(),
		tc = _$('[data-role="codeditor"]').data('code'),
		content = ta.editor.getData(),
		code = tc.getValue(),
		parse = _$.parseHTML(content),
		outHtml = '',
		title = _$(parse[0]).text()
		parse.forEach((e, i) => {
			if (i > 0) {
				outHtml += _$(e).outerHTML()
			}
		})

		_$('input[name="title"]').val(title)
		_$('input[name="content"]').val(encodeURIComponent(outHtml.trim()))
		_$('input[name="style"]').val(encodeURIComponent(code.trim()))
		
		this.submit()
})
@endsection
