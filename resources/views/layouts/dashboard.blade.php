@php
    $user = auth()->user();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Dashboard {{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<script src="{{ asset('js/dash.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link rel="dns-prefetch" href="//use.fontawesome.com">
	<link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Asap+Condensed:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Asap:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		
	<!-- Styles -->
	<link href="{{ asset('css/dash.css') }}" rel="stylesheet">
	@yield('link_style')
	<style type="text/css">
		@yield('style')
	</style>
</head>
<body>
	<div class="wrapper">
		<nav class="sidebar" id="sidebar"></nav>
		<div class="main">
			<header class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle">
					<i class="fas fa-bars"></i>
				</a>
				@if(!empty($widgetbar))
					<ul class="navbar-nav">
						@foreach($widgetbar as $k => $v)
						<li class="nav-item px-2">
							<a href="{{$v['url']}}" class="nav-link" role="button">
								{{$v['name']}}
							</a>
						</li>
						@endforeach
					</ul>
				@endif
				<ul class="navbar-nav ms-auto">
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							{{ Auth::user()->name }}
						</a>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ route('logout') }}"
							   onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</li>
				</ul>
			</header>
			<main class="content">
				<div class="container-fluid p-0">
					@yield('content')
				</div>
			</main>
			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-12 text-end">
							<p class="mb-0">
								&copy; {{date('Y')}} - <a href="{{url('/')}}" class="text-muted">{{ config('app.name', 'Laravel') }}</a>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
</body>
</html>