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
 
<div class="card shadow-sm">
	<div class="card-header bg-white">
		<h2>{{__('Plantillas')}}</h2>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				@include('component.table')
			</div>
		</div>
	</div>
</div>

@endsection
