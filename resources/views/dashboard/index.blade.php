@extends('layouts.dashboard')

@section('content')
<h2>HOLA MUNDO</h2>
@include('component.editor', ['attr'=>[
							'data' => [
								'toolbar' => json_encode([
									'styleselect | bold italic underline strikethrough | inserttable | image media link openlink unlink | alignleft aligncenter alignright alignjustify | numlist bullist | hr code restoredraft'
								]),
								'menubar'=> 'false'
							]
							]])
@endsection