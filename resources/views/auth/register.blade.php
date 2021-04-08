@extends('layouts.appwithoutnav')

@section('content')
<div class="container">
	<div class="row justify-content-center align-items-center vh-100">
		<div class="col-md-6">
			<div class="card shadow-sm">
				<div class="card-header bg-dark fg-white">
					<a href="{{url('/')}}" class="float-start w-auto">
						<img src="{{asset('img/artpost.svg')}}" class="w-100" style="max-width: 9.375rem;">
					</a>
					<span class="float-end d-inline-block">{{ __('Registro') }}</span>
				</div>

				<div class="card-body">
					<form method="POST" action="{{ route('register') }}">
						@csrf
						<div class="form-floating mb-3">
							<input id="name" placeholder="{{ __('Nombre') }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
							<label for="name">{{ __('Nombre') }}</label>
						</div>
						@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						<div class="form-floating mb-3">
							<input id="email" placeholder="{{ __('Correo') }}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
							<label for="email">{{ __('Correo') }}</label>
						</div>
						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						<div class="form-floating mb-3">
							<input id="password" placeholder="{{ __('Contraseña') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
							<label for="password">{{ __('Contraseña') }}</label>
						</div>
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror

						<div class="form-floating mb-3">
							<input id="password-confirm" placeholder="{{ __('Confirmar Contraseña') }}" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
							<label for="password-confirm">{{ __('Confirmar Contraseña') }}</label>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-6 mt-1 w-100 text-center">
								<button type="submit" class="btn bg-carmesi fg-dark fg-carmesi-hover bg-transparent-hover">
									{{ __('Registrarce') }}
								</button>
								@guest
		                            @if (Route::has('login'))
										<a class="ml-4 btn-link btn bg-black fg-white fg-dark-hover bg-transparent-hover" href="{{ route('login') }}">{{ __('Entrar') }}</a>
		                            @endif
	                            @endguest
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
