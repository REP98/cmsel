window._ = require('lodash');

const Fascino = require('./Fascino/fascino.js');

import { DataTable } from "simple-datatables"
import moment from 'moment'

window.moment = moment

const bs = require('bootstrap');

_$.Plyr = require('plyr');
_$.Route = require('./routes.js').route;

_$.each(bs, (n, i) => {
	if (!_$.hasProp(_$().__proto__, i.toLowerCase())) {
		_$().__proto__[i.toLowerCase()] = function(...args) {
			return this.each( (el) => {
				let bs = new n(el, ...args)
				_$(el).data(i, bs)
			})
		}
	}
})

_$.bs = bs

/**
 * Convierte el JSON exportado por laravel atravez de la 
 * funcion Blade @json a una tabla
 * @param {HTMLTable} el        La tabla padre
 * @param {Array} data      Matriz de Datos
 * @param {Array}  exclude   Matriz con datos a excluir como id, slug ...
 * @param {Object} transform Objecto con el renombre de datos identificado como clave=>valor donde clave es el nombre existente
 * @return {HTMLTable}
 */
function setDataFromJson(el, data, exclude = [], transform = {}) {

	if (_$.empty(el) || _$.empty(data)) {
		return el
	}

	if (_$.isObject(exclude)) {
		transform = exclude
		exclude = []
	}

	exclude = _$.merge(['slug', 'id'], exclude)

	let t = _$(el),
		thead = t.find('thead'), 
		tbody = t.find('tbody')

	if (thead.length === 0) {
		t.prepend('<thead>')
		thead = t.find('thead')
	}

	if (tbody.length === 0) {
		t.append('<tbody>')
		tbody = t.find('tbody')
	}

	let tr = thead.find('tr').length === 0 ? thead.append('<tr>') : thead.find('tr')

	Object.keys(data[0]).forEach( (name, index) => {
		if (name.indexOf('slug') === -1 && exclude.indexOf(name) === -1) {
			let th = _$('<th>')
			if (['created_at', 'updated_at', 'date'].indexOf(name) > -1) {
				name = 'fecha'
				th.data({
					type: 'date',
					format: 'DD/MM/YYYY'
				})
			}

			if (name in transform) {
				name = transform[name]
			}

			th.text(name)
			thead.find('tr').append(th.Elem[0])
		}
		
	});

	data.forEach( (table) => {
		let trb = _$('<tr>')
			trb.attr('id', 'id' in table ? table.id : _$.uniqueId('table'))
			trb.data('slug', table.slug)
		_$.each(table, (valore, n) => {
			if (n.indexOf('slug') === -1 && exclude.indexOf(n) === -1) {
				let td = _$('<td>')
				if (['created_at', 'updated_at', 'date'].indexOf(n) > -1) {
					let date = moment(valore)
					if (date.isValid()) {
						valore = date.format('DD/MM/YYYY HH:mm')
					}
				}
				td.html(valore)
				td.appendTo(trb.Elem[0])
			}
		})
		trb.appendTo(tbody.Elem[0])
	})

	return t.Elem[0]
}

/**
 * Integra dataTable Plugins a FascinoJS
 * @param  {Object} options Opciones validas para simple-dataTable
 * @return {FascinoJS}         Retorna la tabla en Objecto Fascino
 */
_$().__proto__.dataTable = function(options){

	if (this.length === 0) {
		return
	}

	const opt = {
		sortable: true,
		searchable: true,

		// Pagination
		paging: true,
		perPage: 10,
		perPageSelect: [5, 10, 15, 20, 25, 50, 100],
		nextPrev: true,
		firstLast: false,
		prevText: "&lsaquo;",
		nextText: "&rsaquo;",
		firstText: "&laquo;",
		lastText: "&raquo;",
		ellipsisText: "&hellip;",
		ascText: "▴",
		descText: "▾",
		truncatePager: true,
		pagerDelta: 2,

		scrollY: "",

		fixedColumns: true,
		fixedHeight: false,

		header: true,
		hiddenHeader: false,
		footer: false,
		columns: [],
		labels: {
			placeholder: "Buscar...",
			perPage: "{select} Páginas mostradas",
			noRows: "No hay paginas a mostrar",
			info: "{start}/{end} de {page} Páginas",
		},
		layout: {
			top: "{search}{select}",
			bottom: "{info}{pager}"
		}
	}

	return this.each((el) => {
		let o = _$.extend({}, opt, options)
			o = _$.extend({}, o, _$(el).data() || {})

		if (_$(el).hasData('data')) {
			el = setDataFromJson(
				el,
				 _$.normalizeData(_$(el).data('data')), 
				 _$.normalizeData(_$(el).data('exclude') || []), 
				 _$.normalizeData(_$(el).data('transform') || {})
			)
		}

		if (_$(el).hasData('checkbox')) {
			_$(el).find('thead tr').prepend('<th>')
			_$(el).find('tbody tr').prepend('<td>')

			if (_$.empty(o.columns)) {
				o.columns = Array.from('')
			}
			o.columns.push({
				select: 0,
				sortable:false,
				render: function(data, cell, row){
					return `<div class="form-check">
						<input type="checkbox" class="form-check-input cellcheck"/>
						<label class="form-check-label">${data}</label>
					</div>
					`
				}
			})
		}

		if (_$(el).hasData('actions')) {
			_$(el).find('thead tr').append('<th>')
			_$(el).find('tbody tr').each(tr => {
				_$(tr).append('<td>')
			})
			if (_$.empty(o.columns)) {
				o.columns = Array.from('')
			}
			o.columns.push({
				select: _$(el).find('thead tr th').length - 1,
				sortable:false,
				render: function(data, cell, row){
					let id = _$(row).data('slug')
					let type = _$(_$(row).parents('table')).data('type')
					return `<div class="actions d-flex justify-content-center w-100">
					<a href="${_$.Route(type+'.edit', [id])}" class="btn fg-dark fg-green-hover">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
					</a>
					<from action="${_$.Route(type+'.destroy', [id])}" method="post">
						<input type="hidden" name="_token" value="${_$('meta[name="csrf-token"').attr('content')}">
						<input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn fg-dark fg-red-hover">
                        	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
					</form>
					</div>
					`
				}
			})
		}

		let dt = new DataTable(el, o)

		// Agregamos un gancho para su uso desde el front-end
		_$.hooks.run('table.init', el, dt)

		_$(el).data('dataTable', dt)
	});
}

function setModal($title, $content, $actions, $options = {}) {
	let foot = !_$.empty($actions) ? `<div class="modal-footer">${$actions.join( )}</div>` : ''
	return `<div id="${_$.uniqueId('modal-bs')}" class="modal fade" tabindex="-1" aria-labelledy="titlemodal" aria-hide="true">
		<div class="modal-dialog modal-dialog-centered modal-lg  
				${!_$.hasProp($options, 'scrollable') ? '' : $options.scrollable ? 'modal-dialog-scrollable' : ''}">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="titlemodal">${$title}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body">${$content}</div>
				${foot}
			</div>
		</div>
	</div>`;
}
window.getSelectedItems = function(items){
	console.log(window.iamel,items)
	delete window.iamel
}
_$().__proto__.lfm = function(type = 'Files', route_prefix = '/dashboard/filemanager'){
	
	return this.each((el) => {
		
		type = _$(el).hasData('lfm-type') ? _$(el).data('lfm-type') : type
		route_prefix = _$(el).hasData('lfm-prefix') ? _$(el).data('lfm-prefix') : route_prefix

		_$(el).click(function(){
			let target_input = _$(_$(el).data('input')),
				target_preview = _$(_$(el).data('preview')),
				target_modal = _$.parseHTML(setModal('Administrador de Archivos'), ''),
				targe_content

			target_modal  = _$(target_modal)
			target_modal.style({
				minHeight: '70vh',
				minWidth: '80vh',
				width: '90%'
			})
			targe_content = target_modal.find('.modal-dialog .modal-content .modal-body')
			axios
				.get(route_prefix, {
					params: {
						lang: 'es',
						modal: 'true',
						callback: 'getSelectedItems',
						type:type
					}
				})
				.then((response) => {
					window.iamel = el
					_$.setFree$()
					_$(targe_content).html(response.data);
				})
				.catch((error) => {
					console.error(error)
				})
			/*
			window.SetUrl = function (items) {
				console.log(items);
		      var file_path = items.map(function (item) {
		        return item.url;
		      }).join(',');

		      // set the value of the desired input to image url
		      target_input.value = file_path;
		      target_input.dispatchEvent(new Event('change'));

		      // clear previous preview
		      target_preview.innerHtml = '';

		      // set or change the preview image src
		      items.forEach(function (item) {
		        let img = document.createElement('img')
		        img.setAttribute('style', 'height: 5rem')
		        img.setAttribute('src', item.thumb_url)
		        target_preview.appendChild(img);
		      });

		      // trigger change event
		      target_preview.dispatchEvent(new Event('change'));
		    }
		    */
			target_modal.appendTo('body')
			target_modal.modal().show()
		})
	})
}
/*
var lfm = function(id, type, options) {
  let button = document.getElementById(id);

  button.addEventListener('click', function () {
    var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
    var target_input = document.getElementById(button.getAttribute('data-input'));
    var target_preview = document.getElementById(button.getAttribute('data-preview'));

    window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
    window.SetUrl = function (items) {
      var file_path = items.map(function (item) {
        return item.url;
      }).join(',');

      // set the value of the desired input to image url
      target_input.value = file_path;
      target_input.dispatchEvent(new Event('change'));

      // clear previous preview
      target_preview.innerHtml = '';

      // set or change the preview image src
      items.forEach(function (item) {
        let img = document.createElement('img')
        img.setAttribute('style', 'height: 5rem')
        img.setAttribute('src', item.thumb_url)
        target_preview.appendChild(img);
      });

      // trigger change event
      target_preview.dispatchEvent(new Event('change'));
    };
  });
};
*/
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/*
const uri = location.origin,
	MOfn = (target, options, callback) => {
		let MO = new MutationObserver((mutationList, observer) => {
			mutationList.forEach( mutation => {
				/*switch (mutation.type) {
					case 'childList':
						
						 Observa y ejecuta Mutaciones en uno o mas hijos del DOM
						 cuando son añadidos o eliminados.
						 
					
					break;
					case 'attributes': 
						
						Observa cuando el valor de un atributo en el mutation.target ha cambiado
						 
						
					break;
				}
				if (typeof callback === 'function') {
					callback.apply(null,[mutation,observer])
				}
			});	
		});
		return MO.observe(target, options)
	},
	ObserverOptions = {
		childList: true,
		attributes: true,
		subtree: true
	}


window.actions = (sel, type, callback) => {
	if (typeof sel !== 'string') {
		throw new Error(`Dashboard Error:\n ${sel.toString()} no es un selector valido`)
		return
	}

	const el = querySelectors(sel)

	if (el.length > 0){		
		if ( type === 'Plyr') {
			el.forEach( (element) =>  {
				const dataset = getData(element)
				const opt = {
					blankVideo: window.uri+ 'img/blank.mp4',
					autoplay: dataset.autoplay !== undefined ? dataset.autoplay : false,
					autopause: dataset.autopause !== undefined ? dataset.autopause : false,
					hideControls: dataset.hideControls !== undefined ? dataset.hideControls : true
				}
				const plyr = new Plyr(element, extend({}, opt, callback))
			});
		}
		if (type === 'bs') {
			el.forEach( (e) => {
				const dataset = getData(e)
				if (Utils.hasProp(dataset, 'role')) {
					let roles = dataset.role.indexOf(',') > -1 ? dataset.role.split(',') : [dataset.role]

					roles.forEach( (rol) =>  {
						let cRol = Utils.Capitalize(rol)
						
							if (Utils.hasProp(bs, cRol)) {
								let EvBs = new bs[cRol](e)
								Data.set(e, rol, EvBs)
								if (Utils.isFunction(callback)) {
									callback(e, EvBs, rol)
								}
							}
					});

				}
			})
		}
		if (type === 'dt') {
			var i = 0;
			
			el.forEach( (e) => {
				const dataset = getData(e)
				let o = Utils.extend({}, opt, dataset)
				const DT = new DataTable(e, o)
				Data.set(e, 'DataTable', DT)
			})
		}
	}

}*/



