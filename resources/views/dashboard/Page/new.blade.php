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
<form class="form" id="page" method="post" action="@if(!empty($edit)) {{route('page.update', $page->id)}} @else {{route('page.store')}} @endif">
	@csrf
	<div class="row mb-2">
		<div class="col-12 d-flex justify-content-around">
			<div class="inpt-group w-50 d-inline-flex me-2" aria-label="Condiciones">
				<span class="input-group-text" id="text">Página Padre</span>
				<select class="form-select" name="parent">
					<option value="">Ningúna</option>
				</select>
			</div>
			<div class="inpt-group w-50 d-inline-flex me-2" aria-label="Condiciones">
				<span class="input-group-text" id="text">Mostrar en</span>
				<select class="form-select" name="condition[type]">
					<option value="index">Principal</option>
					<option value="category">Categoría</option>
					<option value="archive">Archivo</option>
					<option value="post">Entradas</option>
					<option value="custom_post">Entradas Personalizadas</option>
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
	<!-- CAMPOS OCULTOS -->
	<input type="hidden" name="title">
	<input type="hidden" name="content" id='content'>
	<input type="hidden" name="style" id='stylescamp'>
	@include('component.editor-inline')
</form>
<div class="modal code fade" tabindex="-1" id="modalcode" aria-labelleby="modalcodelabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalcodelabel">Editor CSS/JS</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
			</div>
			<div class="modal-body">
				@include('component.codeditor')
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
@parent
_$('form#page').on('submit', function(e){
	e.preventDefault();

	let ta = _$('[data-role="ckeditor"]').data('cke'),
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
