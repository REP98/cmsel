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

<h3 class="w-auto d-inline-flex">{{__('Configuraciones')}}</h3>
<button id="save-setting" class="d-inline-flex btn btn-outline-success sticky-top float-end">
	<i class="fa fa-save me-1"></i>
	<span class="d-block-md">{{__('Guardar')}}</span>
</button>
<div class="row align-items-start" id="content-setting">
	<div class="col-12 col-md-3 col-lg-2">
		<div class="card sticky-md-top mb-3 mb-md-0">
			<div class="card-header d-flex justify-content-between">
				<h5 class="card-title mb-0">{{__('Menú')}}</h5>
				<button class="btn border-none d-block d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsemenu" aria-expanded="false" aria-controls="collapsemenu">
					<i class="fas fa-cog"></i>
					<span class="visually-hidden">{{__('Menú de configuraciones')}}</span>
				</button>
			</div>
			<div id="collapsemenu" class="collapse show list-group list-group-flush " role="tablist">
				<a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general" role="tab">
					{{__('General')}}
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#image" role="tab">
					{{__('Images')}}
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#pages" role="tab">
					{{__('Páginas')}}
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#menu2" role="tab">
					{{__('Menú')}}
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#mail" role="tab">
					{{__('Correo Electrónico')}}
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#config" role="tab">
					{{__('Configuraciones Avanzadas')}}
				</a>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-9 col-lg-10">
		<div class="tab-content" style="min-height: 70vh;">
			<div class="tab-pane show active" id="general" role="tabpanel" aria-labelledby="general-tab">
				<div class="card shadow-sm">
					<div class="card-header">
						<h5 class="card-title mb-0">{{__('General')}}</h5>
					</div>
					<div class="card-body">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" name="general[site_title]" placeholder="{{__('Ingreser titulo de sitio')}}" value="{{$setting->general('site_title')}}">
							<label for="site_title">{{__('Titulo del Sitio Web')}}</label>
						</div>
						<div class="form-floating mb-3">
							<textarea class="form-control" name="general[site_description]" maxlength="200" placeholder="{{__('Descripción del Sitio Web')}}" value="{{$setting->general('site_description')}}"></textarea>
							<label for="site_title">{{__('Descripción del Sitio Web')}}</label>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="image" role="tabpanel" aria-labelledby="image-tab">
				<div class="card shadow-sm">
					<div class="card-header">
						<h5 class="card-title mb-0">{{__('Imágenes Generales')}}</h5>
					</div>
					<div class="card-body">
						<div class="input-group">
					      <span class="input-group-btn">
					        <a id="lfm" data-input="thumbnail" data-preview="holder" data-lfm-type="Images" class="btn btn-primary">
					          <i class="fa fa-picture-o"></i> Choose
					        </a>
					      </span>
					      <input id="thumbnail" class="form-control" type="text" name="filepath">
					    </div>
					    <img id="holder" style="margin-top:15px;max-height:100px;">
					</div>
				</div>
			</div>
			<div class="tab-pane" id="pages" role="tabpanel" aria-labelledby="pages-tab">
				<div class="card shadow-sm">
					<div class="card-header">
						<h5 class="card-title mb-0">{{__('Páginas')}}</h5>
					</div>
					<div class="card-body">
						@empty((array) $setting->pages())
						<h5>No hay páginas listadas <a href="#" id="getpage">Desea agregar una?</a></h5>
						<div id="showlistpage">
							<div class="input-group mb-3">
								<label class="input-group-text">{{__('Seleccione la pagina')}}</label>
								<select class="form-select" name="page[id]" id="listpage"></select>
							</div>
							<div class="input-group mb-3">
								<label class="input-group-text">{{__('Seleccione la pagina')}}</label>
								<select class="form-select" name="page[id][type]" id="typepage" disabled>
									<option value="index">Página Principal</option>
									<option value="category">Página de Categorias</option>
									<option value="post">Página de Entradas Individuales</option>
									<option value="custom_post_type">Página de Entradas personalizadas</option>
									<option value="archive">Página para un archivo especifico</option>
									<option value="byid">Página para un elemento por ID</option>
								</select>
							</div>
							<div class="dinamic" id="dinamic-selection"></div>
						</div>
						@else
						<h5>Lista de Páginas</h5>
						@endif
					</div>
				</div>
			</div>
			<div class="tab-pane" id="menu2" role="tabpanel" aria-labelledby="menu2-tab">
				<div class="card shadow-sm">
					<div class="card-header">
						<h5 class="card-title mb-0">{{__('Menú')}}</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<div class="input-group">
									<label class="input-group-text">{{__('Seleccione el menú')}}</label>
									<select class="form-select" name="menu[]">
										@foreach(get_object_vars($setting->menu()) as $name => $value)
										<option value="{{$name}}">{{ucwords($name)}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="mail" role="tabpanel" aria-labelledby="mail-tab">
				<div class="card shadow-sm">
					<div class="card-header">
						<h5 class="card-title mb-0">{{__('Correo Electrónico')}}</h5>
					</div>
					<div class="card-body">
						@php
							$host = env('MAIL_HOST');
							$port = env('MAIL_PORT');
							$username = env('MAIL_USERNAME', '');
							$password = env('MAIL_PASSWORD', '');
							$encryption = env('MAIL_ENCRYPTION', '');
							$email = env('MAIL_FROM_ADDRESS', '');
							$names = env('MAIL_FROM_NAME', '');

							if(!empty((array) $setting->menu())) {

								$host = $setting->menu('host');
								$port = $setting->menu('port');
								$username = $setting->menu('username');
								$password = $setting->menu('password');
								$encryption = $setting->menu('encryption');
								$email = $setting->menu('email');
								$names = $setting->menu('name');
							}
						@endphp
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="input-group mb-3">
									<label class="input-group-text">
										{{__('Correo de Envio')}}
									</label>
									<input type="email" class="form-control" name="mail[email]" placeholder="example@domain.com" value="{{$email}}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="input-group mb-3">
									<label class="input-group-text">
										{{__('Nombre de Envio')}}
									</label>
									<input type="text" class="form-control" name="mail[name]" placeholder="{{__('Nombre a Mostrar')}}" value="{{$names}}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="input-group mb-3">
									<label class="input-group-text">
										{{__('Servidor SMTP')}}
									</label>
									<input type="text" class="form-control" name="mail[host]" placeholder="smtp.domain.com" value="{{$host}}">
								</div>
							</div>
							<div class="col-12 col-md-3">
								<div class="input-group mb-3">
									<label class="input-group-text">
										{{__('Puerto')}}
									</label>
									<input type="number" min="1" class="form-control" name="mail[port]" placeholder="{{__('Puerto a conectar')}}" value="{{$port}}">
								</div>
							</div>
							<div class="col-12 col-md-3">
								<div class="input-group mb-3">
									<label class="input-group-text">
										{{__('Encriptación')}}
									</label>
									<input type="text" class="form-control" name="mail[encryption]" placeholder="{{__('Tls ó ssl')}}" value="{{$encryption}}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="input-group mb-3">
									<label class="input-group-text">
										{{__('Usuario')}}
									</label>
									<input type="text" class="form-control" name="mail[username]" placeholder="JhoeDoe98" value="{{$username}}">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="input-group mb-3">
									<label class="input-group-text">
										{{__('Contraseña')}}
									</label>
									<input type="password" class="form-control" name="mail[password]" placeholder="{{__('Ingrese la contraseña del usuario')}}" value="{{$password}}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="config" role="tabpanel" aria-labelledby="config-tab">
				<div class="card shadow-sm">
					<div class="card-header">
						<h5 class="card-title mb-0">{{__('Configuraciones Avanzadas')}}</h5>
					</div>
					<div class="card-body">
						
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
@php

@endphp

@endsection
@section('script')
@parent

const hash = location.hash
const TabA = _$("#collapsemenu a")

TabA.tab()

TabA.click(function(){
	location.hash = _$(this).attr('href')
})

if(!_$.empty(hash.trim())){
	_$.bs.Tab.getInstance(_$(`#collapsemenu a[href='${hash}']`).Elem[0]).show()
}
_$('#lfm').lfm()

let slp = _$('#showlistpage').collapse()
slp.data('collapse').hide()

_$('a#getpage').click(function(e){
e.preventDefault()
	let collapse = _$(_$('#showlistpage'))
	axios.get(_$.Route('page.tojson'))
		.then(function(responce){
			let selet = collapse.find('#listpage')
			console.log(responce)
		})
		.catch((error)=> {
			console.log(error.message)			
		})
})

_$('#save-setting').click(function(){
	let i = _$(_$(this).find('i'))
	let text = _$(_$(this).find('span'))
	let configs = {}

	let children = _$('#content-setting').find('input,textarea,select')

	children.each(function(el) {
		let re = /(\w+)\[(\w+)\]/gi.exec(el.name)
		if (!_$.empty(re)) {
			let r = Array.from(re);
			if (!_$.hasProp(configs, r[1])) {
				configs[r[1]] = {}
			}

			configs[r[1]][r[2]] = el.value
		}
	})
	console.log(configs)
})
@endsection
