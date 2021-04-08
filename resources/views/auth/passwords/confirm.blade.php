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
                    <span class="float-end d-inline-block">{{ __('Confirmar contraseña') }}</span>
                </div>
                <div class="card-body">
                    {{ __('Confirme su contraseña antes de continuar.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input id="password" placeholder="{{ __('Contraseña') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <label for="password">{{ __('Contraseña') }}</label>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                       
                        <div class="form-group row mb-0">
                            <div class="col-12 justify-content-between">
                                <button type="submit" class="btn bg-carmesi fg-dark fg-carmesi-hover bg-transparent-hover">
                                    {{ __('Confirmar contraseña') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
