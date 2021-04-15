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

@endsection
@section('script')
@parent
var finder;

CKFinder.start( {
	onInit: function( instance ) {
		console.log(instance)
		finder = instance;
	}
} );
@endsection
