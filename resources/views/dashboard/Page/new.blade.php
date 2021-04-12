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
<form class="form" method="post" action="@if(!empty($edit)) {{route('page.update', $page->id)}} @else {{route('page.store')}} @endif">
	@csrf
	<div class="row mb-2">
		<div class="col-12 d-flex justify-content-end">
			<div class="btn-group" role="group" aria-label="Grupo de Opciones Avanzadas">
				<button type="submit" class="btn btn-outline-success"> Guardar</button>
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalcode">
					<i class="fas fa-cog"></i> CSS/JS
				</button>
			</div>
		</div>
	</div>
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