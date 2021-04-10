@php
    $user = Auth::user();
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
	<script defer>
		window.uri = `{{url('/')}}`
		window.user = @json($user)
	</script>
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
		<nav class="sidebar open" id="sidebar">
			<div class="brand">
				<img src="{{asset($setting['img']->logo)}}" class="logo" alt="{{$setting['config']->title}}">
			</div>
			<nav class="nav flex-column">
				@foreach($setting['config']->menu as $n => $v)
					@php
						$url = $v->url;
						if (is_array($v->url) || is_object($v->url)) {
							$url = route($v->url[0], (array) $user[$v->url[1]]);
						}
					@endphp
					@can($v->level)
						@if(property_exists($v, 'submenu'))
						<div class="nav-item dropdown" style="order: {{$v->order}}">
							<a href="{{$url}}" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
							<span>{{$n}}</span>
							</a>
							<ul class="dropdown-menu">
								@foreach($v->submenu as $sn => $fv)
								@php
									$surl = $fv->url;
									if (is_array($fv->url) || is_object($fv->url)) {
										$surl = route($fv->url[0], (array) $user[$fv->url[1]]);
									}
								@endphp
									@can($fv->level)
										<li><a class="dropdown-item" href="{{$surl}}"><span>{{$sn}}</span></a></li>
									@endcan
								@endforeach
							</ul>
						</div>
						@else
						<div class="nav-item">
							<a href="{{$v->url}}" class="nav-link" role="button" aria-expanded="false">
							{{$n}}
							</a>
						</div>
						@endif				
					@endcan
				@endforeach
			</nav>
		</nav>
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
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-role="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							{{-- @if(Gravatar::exists(Auth::user()->email))
							<img src="{{Gravatar::get(Auth::user()->email, 'small')}}" class="profile-gravatar">
							@else
							<img src="{{asset($setting['img']->avatar)}}" class="profile-gravatar">
							@endif --}}
							<img src="{{asset($setting['img']->avatar)}}" class="profile-gravatar">
							<span>{{ $user->name }}</span>
						</a>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a href="{{ route('user.profile', $user->id)}}" class="dropdown-item">
								{{ __('Perfil') }}
							</a>
							<a class="dropdown-item" href="{{ route('logout') }}"
							   onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
								{{ __('Salir') }}
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