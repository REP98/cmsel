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

<h3>{{__('Configuraciones')}}</h3>
<div class="row">
	<div class="col-12 col-md-3 col-lg-2">
		<div class="card">
			<div class="card-header d-flex justify-content-between">
				<h5 class="card-title mb-0">Menú</h5>
				<button class="btn border-none d-block d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsemenu" aria-expanded="false" aria-controls="collapsemenu">
					<i class="fas fa-cog"></i>
					<span class="visually-hidden">Menú de configuraciones</span>
				</button>
			</div>
			<div id="collapsemenu" class="collapse show list-group list-group-flush " role="tablist">
				<a class="list-group-item list-group-item-action active" data-toggle="list" href="#general" role="tab">
					General
				</a>
				<a class="list-group-item list-group-item-action" data-toggle="list" href="#password" role="tab">
					Password
				</a>
				<a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
					Privacy and safety
				</a>
				<a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
					Email notifications
				</a>
				<a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
					Web notifications
				</a>
				<a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
					Widgets
				</a>
				<a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
					Your data
				</a>
				<a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
					Delete account
				</a>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-9 col-lg-10">
		<div class="tab-content">
			<div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
				<div class="card shadow-sm">
					<div class="card-header">
						<div id="title">General</div>
					</div>
					<div class="card-body">
						<a href="#modal" data-fs-toggle="ckfinder-modal">
							<img src="{{asset($setting['img']->logo)}}" class="bg-dark img-thumbnail" alt="Logo del sito">
						</a>
						<div id="output" style="float: left;font-size: 0.8em;line-height: 1.4em;margin: 3px 7px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
_$("[data-fs-toggle*='ckfinder-modal']").click(function(e){
	e.preventDefault();
	CKFinder.modal( {
		chooseFiles: true,
		width: 800,
		height: 600,
		onInit: function( finder ) {
			finder.on( 'files:choose', function( evt ) {
				var file = evt.data.files.first();
				var output = document.getElementById( 'output' );
				output.innerHTML = 'Selected: ' + escapeHtml( file.get( 'name' ) ) + '<br>URL: ' + escapeHtml( file.getUrl() );
			} );

			finder.on( 'file:choose:resizedImage', function( evt ) {
				var output = document.getElementById( 'output' );
				output.innerHTML = 'Selected resized image: ' + escapeHtml( evt.data.file.get( 'name' ) ) + '<br>url: ' + escapeHtml( evt.data.resizedUrl );
			} );
		}
	} );
})
@endsection
