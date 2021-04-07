require('./bootstrap');

/**
 * Constantes y Variables
 */
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

window.addEv(el, events, callback, capture = false){
	el.addEventListener(events, callback, capture)
}
