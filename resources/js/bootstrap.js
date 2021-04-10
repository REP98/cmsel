window._ = require('lodash');

import camelCase from 'camelcase'
import Selector from './kernel/selector.js'
import Utils from './kernel/utils.js'
import DS from './kernel/data.js'
window.Utils = Utils
window.Data = new DS('core')

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.bs = require('bootstrap');
    window.Plyr = require('plyr');
    window.Route = require('./routes.js').route;
} catch (e) {}

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

/**
 * Selecciona el elemento por selector CSS
 * @param  {String|HTMLElement} selector el selector o elemento
 * @param  {Element} context  padre principal del selector
 * @return {Array}
 */
window.querySelectors = (selector, context = document) => {
	return new Selector(selector, context).Elem;
}

/**
 * Private Function normName
 * regula y normalize el nombre de un atributo, funcion, o variable para su uso en javascript
 * @private
 * @param  {String} name variable
 * @return {String|void}  el nombre normalizado o indefinido
 */
function normName(name) {
	return typeof name !== 'string' ? undefined : name.replace(/-/g, '').toLowerCase()
}
/**
 * Private Function normalizeData
 * combiente los datos tipo texto JSON pasados por attributos a un objecto valido
 * @private
 * @param  {String} data
 * @return {Object} El objeto JSON
 */
function normalizeData(data) {
	try {
		return JSON.parse(data)
	} catch (e) {
		return data
	}
}

/**
 * Private Function normalizeElements
 * Valida y obtiene un elemento dado
 * @private
 * @param  {String|Array|Object Fascino} s
 * @return {Object|Element|Array|undefined}   El elemento en su expresion para su uso
 */
function normalizeElements(s) {
	let result
	if (Utils.isString(s)) {
		result = Utils.isSelector(s) ? querySelectors(s) : Utils.parseHTML(s)
	} else if (Utils.isElement(s)) {
		result = [s]
	} else if (Utils.isArrayish(s)) {
		result = s
	}
	return result
}
/**
 * Private Function dataAttr
 * @private
 * @param  {Object} DS   Object DATA
 * @param  {Element} elem Elemento a manipular
 * @param  {String} key  La clave del atributto data ejemplo data-valor; key = valor
 * @param  {Object|String|Array} data El resultado del atributo data
 * @return {Object|undefine|Array}  El resultado del atributo data obtenido
 */
function dataAttr(DS, elem, key, data) {
	let name

	if (Utils.empty(data) && elem.nodeType === 1) {
		name = 'data-' + key.replace(/[A-Z]/g, '-$&').toLowerCase()
		data = elem.getAttribute(name)

		if (typeof data === 'string') {
			data = normalizeData(data)
			DS.set(elem, key, data)
		} else {
			data = undefined
		}
	}
	return data
}

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
				}*/
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



window.addEv = (el, events, callback, capture = false) =>  {
	el.addEventListener(events, callback, capture)
}

window.attr = (el, ...args) => {
	if (Utils.empty(el)) {
		return 
	}
	if (Utils.empty(args)) {
		if (el.hasAttributes()) {
			let Attr = el.attributes;
			Array.from(Attr).forEach( (a) => {
				el.setAttribute(a.nodeName, a.nodeValue)
			});
			return Attr;
		}
		return el
	}

	if (args.length == 1) {
		if (Utils.isObject(args[0])) {
			querySectors(el).forEach( (e) => {
				for (let i in args[0]) {
					if( Utils.hasProp(args[0], i)) {
						let value = normalizeData(args[0][i])
						if (i in e) {
							e[i] = value;
						} else {
							e.setAttribute(i, value)
						}
					}
				}
			})
		} else if (Utils.isString(args[0])) {
			return el.hasAttributes(args[0]) ? el.getAttribute(args[0]) : false
		} else if (Utils.isFunction(args[0])) {
			querySectors(el).forEach( (e) => {
				if (e.hasAttribute()) {
					let a = el.attributes
					a.forEach((attr) => {
						args[0].call(el, [attr.nodeName, attr.nodeValue, attr])
					})
				}
			})
		}
	}

	querySectors(el).forEach( (e) => {
		let key = args[0],
			value = normalizeData(args[1])
			if (key in e) {
				e[key] = value
			} else {
				e.setAttribute(key, value)
			}
	})
	return el
}

const getData = (el, key) => {

	if (Utils.empty(key)) {
		let DS = Data.get(el)
		if (el.nodeType === 1) {
			let attributes = el.attributes,
				i = attributes.length
			while (i--) {
				if (i in attributes) {
					if (attributes[i].name.indexOf('data-') === 0) {
						let name = camelCase(attributes[i].name.slice( 5 ))
						dataAttr(Data, el, name, DS[name])
					}
				}
			}
		}
		return DS
	}

	let DS = Data.get(el, key)
	if (Utils.empty(DS)) {
		if (el.nodeType === 1) {
			DS = el.hasAttributes(`data-${args[0]}`) ? el.getAttribute(`data-${args[0]}`) : DS
		}
	}
	return DS
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
								Data.set(el, rol, EvBs)
								if (Utils.isFunction(callback)) {
									callback(el, EvBs, rol)
								}
							}
					});

				}
			})
		}
	}

}

