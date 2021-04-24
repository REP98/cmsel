@extends('layouts.dashboard')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
	   {!! session('status') !!}
	    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
	   {!! session('error') !!}
	    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif

<form class="form" id="page" method="post" action="@if(!empty($edit)) {{route('page.update', [$page->slug])}} @else {{route('page.store')}} @endif">
	<!-- CAMPOS OCULTOS -->
	@csrf
	@if(!empty($edit))
	{{ method_field('PATCH') }}
	@endif
	<input type="hidden" name="content" id='content' value="@if(!empty($edit)) {!! urlencode($page->content) !!} @endif">
	<input type="hidden" name="js" id='js-input' value="@if(!empty($edit)) {!! $style->js !!}@endif">
	<input type="hidden" name="css" id='css-input' value="@if(!empty($edit)) {!! $style->css !!}@endif">
	<!-- FIN CAMPOS OCULTOS -->
	<div class="d-flex justify-content-between align-items-center mb-3">
	<h2>
		@empty($edit)
		{{__('Nueva Página')}}
		@else
		{{__('Actualizar Página')}}
		@endempty
	</h2>
	<div class="btn-group" role="group" aria-label="Grupo de Opciones Avanzadas">
		<button type="submit" class="btn btn-outline-success" id="savepage">
		<i class="fas fa-save"></i> {{__('Guardar')}}</button>
	</div>
</div>
	<!-- TiTULO Y CONDIFICONALES -->
	<div class="row mb-2">
		<div class="col-12 d-flex justify-content-around">
			<div class="input-group w-50 d-inline-flex me-2" aria-label="Condiciones">
				<span class="input-group-text" id="text">{{__('Página Padre')}}</span>
				<select class="form-select" name="parent">
					<option value="">{{__('Ningúna')}}</option>
					@foreach($pages as $p)
					@if($p->id !== $page->id)
					<option value="{{$p->id}}" @if(!empty($edit) && $page->parent_id === $p->id) selected @endif>{{$p->title}}</option>
					@endif
					@endforeach
				</select>
			</div>
			@php
			if(empty($edit)) {
				$condition = [
					'loadScipt' => false
				];
			} else {
				$condition['loadScipt'] = false;
			}
			@endphp
			@include('component.condition_fields', $condition)
		</div>
		<div class="col-12 my-2">
			<input type="text" class="form-control w-100 mb-2" name="title" placeholder="Ingrese su titulo" value="@if(!empty($edit)) {{$page->title}} @endif">
		</div>
		@if(!empty($edit))
		<div class="col-12">
			<a href="{{url('/').'/'.$page->slug}}" class="link-primary" id="slug" target="_blank">{{url('/').'/'.$page->slug}}</a>
		</div>
		@endif
	</div>
	<!-- FIN TITULO -->
	<!-- NAVBAR -->
	<nav class="w-100">
		<ul class="nav nav-tabs nav-fill" id="taboptions" role="tablist">
			<li class="nav-item" role="presentation">
				<a href="#tinymce" class="nav-link active" id="tinymce-editor" data-bs-toggle="tab" data-bs-target="#tinymce" role="tab" aria-selected="true" aria-control="tinymce">Editor</a>
			</li>
			<li class="nav-item" role="presentation">
				<a href="#html" class="nav-link" id="html-editor" data-bs-toggle="tab" data-bs-target="#html" role="tab" aria-selected="false" aria-control="html">HTML</a>
			</li>
			<li class="nav-item" role="presentation">
				<a href="#css" class="nav-link" id="css-editor" data-bs-toggle="tab" data-bs-target="#css" role="tab" aria-selected="false" aria-control="css">CSS</a>
			</li>
			<li class="nav-item" role="presentation">
				<a href="#js" class="nav-link" id="js-editor" data-bs-toggle="tab" data-bs-target="#js" role="tab" aria-selected="false" aria-control="js">JS</a>
			</li>			
		</ul>
	</nav>
	<!-- END NAVBAR -->
	<div class="tab-content" id="contentcampo">
		@php
			$editorHTML = ['attr' => 'id="html-codeditor"', 'langCode' => 'htmlmixed'];
			$editorCSS = ['attr' => 'id="css-codeditor"', 'langCode' => 'css'];
			$editorJS = ['attr' => 'id="js-codeditor"', 'langCode' => 'javascript'];
			$EditorTMC = [];
			if (!empty($edit)) {
				$editorCSS['content'] = urldecode($style->css);
				$editorJS['content'] = urldecode($style->js);
				$EditorTMC = ['content' => urldecode($page->content) ];
			}
		@endphp
		<div class="tab-pane fade show active" id="tinymce" role="tabpanel" aria-labelledby="tinymce-editor">
			@include('component.editor-inline', $EditorTMC)
		</div>

		<div class="tab-pane fade" id="html" role="tabpanel" aria-labelledby="html-editor">
			<h5 class="my-2">Editor HTML</h5>
			@include('component.codeditor', $editorHTML) 
		</div>
		<div class="tab-pane fade" id="css" role="tabpanel" aria-labelledby="css-editor">
			<h5 class="my-2">Editor CSS</h5>
			@include('component.codeditor', $editorCSS)
		</div>
		<div class="tab-pane fade" id="js" role="tabpanel" aria-labelledby="js-editor">
			<h5 class="my-2">Editor JS</h5>
			@include('component.codeditor', $editorJS)
		</div>
	</div>
</form>
@endsection
@section('script')
@parent
/* SET COMMENT BY DEFAULTS*/
@empty($edit)
_$("#html-codeditor").data('code').getDoc().setValue('<!-- Código del editor -->\n')
_$("#css-codeditor").data('code').getDoc().setValue('/*-- Código CSS para el página */\n')
_$("#js-codeditor").data('code').getDoc().setValue('/** Código JS para la página */\n')

@else
tinyMCE.activeEditor.setContent(`{!! html_entity_decode($page->content) !!}`)
@endempty

var delay, tmcDelay

_$("#html-codeditor").data('code').on('change',function(){
	clearTimeout(delay);
	if (_$("#html-editor").hasClass('active')) {
		delay = setTimeout(updatePreview, 300);
	}
})

function updatePreview() {
	var editor = _$("#html-codeditor").data('code')
	tinymce.activeEditor.setContent(editor.getValue())
}
function updateCode(){
	let editor = _$.getValueActiveEditor(false)
	_$("#html-codeditor").data('code').setValue(editor)
}

tinymce.activeEditor.on('change', function(e){
	let editor = e.target;
	clearTimeout(tmcDelay);
	if (_$('#tinymce').hasClass('active')) {
		tmcDelay = setTimeout(updateCode, 300);
	}
})

_$('form#page').on('submit', function(e){
	e.preventDefault();
	let tiny = tinyMCE.activeEditor.getBody().innerHTML,
		css = _$("#css-codeditor").data('code').getValue(),
		js = _$("#js-codeditor").data('code').getValue()

	_$('input[name="content"]').val(encodeURIComponent(tiny.trim()))
	_$('input[name="css"]').val(encodeURIComponent(css.trim()))
	_$('input[name="js"]').val(encodeURIComponent(js.trim()))
	if(_$.isFunction(this.submit)){
		this.submit()
	} else if(_$.isFunction(this._mceOldSubmit)) {
		this._mceOldSubmit()
	}
	
})
@endsection
