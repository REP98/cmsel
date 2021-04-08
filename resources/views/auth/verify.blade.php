@extends('layouts.appwithoutnav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-dark fg-white">
                    <a href="{{url('/')}}" class="float-start w-auto">
                        <img src="{{asset('img/artpost.svg')}}" class="w-100" style="max-width: 9.375rem;">
                    </a>
                    <span class="float-end d-inline-block">{{ __('Verifique su dirección de correo electrónico') }}</span>
                </div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, verifique su correo electrónico para ver si hay un enlace de verificación.') }}
                    {{ __('Si no recibió el correo electrónico') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('haga clic aquí para solicitar otro') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
