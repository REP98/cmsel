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

<form class="form" id="template" method="post" action="@if(!empty($edit)) {{route('template.update', [$template->slug])}} @else {{route('template.store')}} @endif">
	
</form>

@endsection