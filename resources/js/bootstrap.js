window._ = require('lodash');

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

window.querySelectors = (selector, context = document) => {
	return context.querySelectorAll(selector).length > 1 ? 
		context.querySelectorAll(selector) :
		context.querySelector(selector) != null ? [context.querySelector(selector)]: []
}

window.addEv = (el, events, callback, capture = false) =>  {
	el.addEventListener(events, callback, capture)
}
