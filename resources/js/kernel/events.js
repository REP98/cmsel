/**
 * @module EventHandler
 */
import camelCase from 'camelcase'
import {
	empty,
	isFunction,
	isObject,
} from './utils.js'

const EHUid = -1,
	overriddenStop = Event.prototype.stopPropagation,
	overriddenPrevent = Event.prototype.preventDefault

Event.prototype.stopPropagation = function(...args) {
	this.isPropagationStopped = true
	overriddenStop(...args)
}
Event.prototype.preventDefault = function(...args) {
	this.isPreventedDefault = true
	overriddenPrevent(...args)
}

Event.prototype.stop = function(immediate) {
	return immediate ? this.stopImmediatePropagation() : this.stopPropagation()
}

/**
 * Maneja y manipula los Eventos del DOM
 * @namespace EventHandler
 * @class
 */
export default class EventHandler {
	/** @constructs */
	constructor() {
		EHUid++
		this.UID = EHUid
		this.EvUID = 0
		this.events = []
		this.ListEvent = {}
		this.EventHooks = {}
	}
	/**
	 * Establece y alamacena en memoria los Eventos a Ejecutar
	 * @memberOf EventHandler
	 * @param {Object} obj
	 * @return {Numeric} Posición del Evento
	 */
	set(obj) {
		let i, freeIndex = -1, eventObj, resultIndex

		if (this.events.length > 0) {
			for (i = 0; i < this.events.length; i++) {
				if (this.events[i].handler === null) {
					freeIndex = i
					break
				}
			}
		}

		eventObj = {
			element: obj.el,
			event: obj.event,
			handler: obj.handler,
			selector: obj.selector,
			ns: obj.ns,
			id: obj.id,
			options: obj.options
		}

		if (freeIndex === -1) {
			this.events.push(eventObj)
			resultIndex = this.events.length - 1
		} else {
			this.events[freeIndex] = eventObj
			resultIndex = freeIndex
		}

		return resultIndex
	}
	/**
	 * Obtiene la función del Evento dado por su indice en memoria
	 * @memberOf EventHandler
	 * @param  {Numeric} index
	 * @return {Function|Undefined}
	 */
	get(index) {
		if (!empty(this.events[index])) {
			return this.events[index].handler
		}
		return undefined
	}

	/**
	 * Ganchos y anclas de Eventos
	 */
	/**
	 * Obtiene la lista de los Eventos Enganchados
	 * @memberOf EventHandler
	 * @return {Object}
	 */
	getEventHooks() {
		return this.EventHooks
	}
	/**
	 * Registra los Ganchos
	 * @memberOf EventHandler
	 * @param {String} event   Lista de Eventos
	 * @param {Function} handler Función del Evento
	 * @param {String} type    Poscion del gancho puede ser before o after
	 * @return {Class EventHandler}
	 */
	addEventHook(event, handler, type) {
		if (empty(type)) {
			type = 'before'
		}

		let strToArr = event.split(' ')

		strToArr.forEach((n) => {
			this.EventHooks[camelCase(type+'-'+n)] = handler
		})

		return this
	}
	/**
	 * Elimina un evento enganchado
	 * @memberOf EventHandler
	 * @param  {String} event Eventos
	 * @param  {String} type  before o after
	 * @return {Class EventHandler}
	 */
	removeEventHook(event, type) {
		if (empty(type)) {
			type = 'before'
		}

		let strToArr = event.split(' ')

		strToArr.forEach((n) => {
			delete this.EventHooks[camelCase(type+'-'+n)]
		})

		return this
	}
	/**
	 * Remueve todos los eventos dado
	 * @param  {String} event Lista de eventos o undefined para borrar todo
	 * @return {Class EventHandler}
	 */
	removeEventHooks(event) {
		if (empty(event)) {
			this.EventHooks = {}
		} else {
			this.removeEventHook(event, 'before')
			this.removeEventHook(event, 'after')
		}
		return this
	}
	/**
	 * Eventos
	 */
	/**
	 * Obtiene los eventos almacenados
	 * @memberOf EventHandler
	 * @return {Object}
	 */
	getEvents() {
		return this.events
	}
	/**
	 * Ejecuta los eventos dados
	 * @memberOf EventHandler
	 * @param  {Element} el         El elemento
	 * @param  {String|Array} eventsList Lista de eventos con su namespace si es necesario
	 * @param  {String} sel        Selector a iterar o null
	 * @param  {Function} handler    Función a ejecutar
	 * @param  {Object} options    Opciones de addEventListiner
	 * @return {Element|Object|Class EventHandler}
	 */
	on(el, eventsList, sel, handler, options) {
		if (empty(el)) {
			return this
		}

		if (isFunction(sel)) {
			options = handler
			handler = sel
			sel = undefined
		}

		if (!isObject(options)) {
			options = {}
		}

		let EvL = eventsList.split(' ')

		EvL.forEach((ev) => {
			let callback,
				event = ev.split('.'),
				name = normName(event[0]),
				ns = options.ns ? options.ns : event[1],
				index,
				originEvent

			this.EvUID++

			callback = (e) => {
				let target = e.target,
					bEvent = this.EventHooks[camelCase('before-'+name)],
					aEvent = this.EventHooks[camelCase('after-'+name)]

				if (isFunction(bEvent)) {
					bEvent.call(target, e)
				}

				if (!sel) {
					handler.call(el, e)
				} else {
					while (target && target !== el) {
						if (Element.prototype.matches.call(target, sel) ) {
							handler.call(target, e)
							if (e.isPropagationStopped) {
								e.stopImmediatePropagation()
								break
							}
						}
						target = target.parentNode
					}
				}

				if (isFunction(aEvent)) {
					aEvent.call(target, e)
				}

				if (options.once) {
					index = +_$(el).origin('event-' + e.type + (sel ? ':' + sel : '') + (ns ? ':' + ns : ''))
					if (!isNaN(index)) {
						this.events.splice(index, 1)
					}
				}
			}

			Object.defineProperty(
				callback,
				'name',
				{
					value: handler.name && handler.name !== '' ? handler.name : 'func_event_' + name + '_' + this.EvUID
				}
			)

			originEvent = name + (sel ? ':' + sel : '') + (ns ? ':' + ns : '')
			el.addEventListener(name, callback, !empty(options) ? options : false)
			index = this.set({
				el: el,
				event: name,
				handler: callback,
				selector: sel,
				ns: ns,
				id: this.EvUID,
				options: !empty(options) ? options : false
			})

			_$(el).origin(`event-${originEvent}`, index)
		})

		return el
	}
	/**
	 * Ejecuta solo el primer eventos del elemento
	 * @memberOf EventHandler
	 * @param  {Element} el      El Elemento
	 * @param  {String} events  Eventos
	 * @param  {String} sel     Selector o null
	 * @param  {Function} handler Función a ejecutar
	 * @param  {Object} options Opciones de addEventListiner
	 * @return {Element|Object|Class EventHandler}
	 */
	one(el, events, sel, handler, options) {
		if (!isObject(options)) {
			options = {}
		}

		options.once = true

		return this.on.apply(this, [el, events, sel, handler, options])
	}
	/**
	 * Private Remueve todos los Eventos de todos los elementos seleccionado
	 * @private
	 * @memberOf EventHandler
	 * @return {Class EventHandler}
	 */
	_off() {
		this.events.forEach((n) => {
			n.element.removeEventListener(n.event, n.handler, true)
		})
		this.events = []
		return this
	}
	/**
	 * Remueve los Eventos de los elementos dado
	 * @memberOf EventHandler
	 * @public
	 * @param  {Element} el         Elemento
	 * @param  {String} eventsList Lista de Eventos
	 * @param  {String} sel        Selecotr o null
	 * @param  {Object} options    Opciones de removeEventListiner
	 * @return {ELement|Object|Class EventHandler}
	 */
	off(el, eventsList, sel, options) {
		if (isObject(sel)) {
			options = sel
			sel = null
		}

		if (!isObject(options)) {
			options = {}
		}

		if (empty(eventsList) || eventsList.toLowerCase() === 'all' || eventsList === '*') {
			this.events.forEach((e) => {
				if (e.elements === el) {
					el.removeEventListener(e.event, e.handler, e.options)
					e.handler = null
					_$(el).origin('event-' + name + (e.selector ? ':' + e.selector : '') + (e.ns ? ':' + e.ns : ''), null)
				}
			})
			return el
		}

		let Evl = eventsList.split(' ')
		Evl.forEach((e) => {
			let evMap = e.split('.'),
				name = normName(evMap[0]),
				ns = options.ns ? options.ns : evMap[1],
				originEvent, index

			originEvent = 'event-' + name + (sel ? ':' + sel : '') + (ns ? ':' + ns : '')
			index = _$(el).origin(originEvent)

			if (index !== undefined && this.events[index].handler) {
				el.removeEventListener(name, this.events[index].handler, this.events[index].options)
				this.events[index].handler = null
			}

			_$(el).origin(originEvent, null)
		})

		return el
	}
}
