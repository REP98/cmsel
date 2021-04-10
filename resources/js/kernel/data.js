import camelCase from 'camelcase'
import {
	empty,
	hasProp,
	isArrayish,
	isString
} from './utils.js'
/**
 * Contador de Invocaciones
 * @type {Number}
 */
var DataUI = -1
/**
 * @class
 */
export default class Data {
	/**
	 * @constructs
	 * @param  {String} ID Nombre del data
	 * @return {void}
	 */
	constructor(ID) {
		this.UID = `CMSEL:${ID.toUpperCase()}`
		DataUI++
		this.id = DataUI
	}
	/**
	 * Valida si el elemento acceta atributos data
	 * @param  {Element} el
	 * @return {Boolean}
	 */
	acceptData(el) {
		return el.nodeType === 1 || el.nodeType === 9 || !( +el.nodeType )
	}
	/**
	 * Alamcena el valor de atributo
	 * @param  {Element}  el
	 * @param  {Boolean} config Indica si el objeto sera configurable
	 * @return {Object}
	 */
	storage(el, config = true) {
		let val = el[this.UID]
		if (!val) {
			val = {}
			if (this.acceptData(el)) {
				if (el.nodeType) {
					el[this.UID] = val
				} else {
					Object.defineProperty(el, this.UID, {
						value: val,
						configurable: config
					})
				}
			}
		}
		return val
	}
	/**
	 * Establece el nuevo valor de la propiedad
	 * @param {Element} el
	 * @param {String} key  La clave
	 * @param {Obect|String} data El valor a establecer
	 * @return {Object|String} El nuevo valor establecido
	 */
	set(el, key, data) {
		let store = this.storage(el)

		if (isString(key)) {
			store[camelCase(key)] = data
		} else {
			for (let prop in key) {
				if (hasProp(key, prop)) {
					store[camelCase(prop)] = key[prop]
				}
			}
		}
		return store
	}
	/**
	 * Obtiene el valor del Atributo o todos
	 * @param  {Element} el
	 * @param  {String} key La clave a buscar
	 * @return {Object|String|Boolean}
	 */
	get(el, key) {
		if (empty(key)) {
			return this.storage(el)
		}

		return el[this.UID] && el[this.UID][key] ? el[this.UID][key] : false
	}
	/**
	 * Obtiene o Establece el atributo
	 * @param  {Element} el
	 * @param  {String} key  La clave
	 * @param  {String|Object} data El valor
	 * @return {Object|String}      El valor obtenido
	 */
	access(el, key, data) {
		if (empty(key) || ((key && isString(key)) && empty(data)) ) {
			return this.get(el, key)
		}

		this.set(el, key, data)
		return empty(data) ? key : data
	}
	/**
	 * Verifica si el elemento tiene la clave dada
	 * @param  {Element}  el
	 * @param  {String}  key La clave
	 * @return {Boolean}
	 */
	has(el, key) {
		if (empty(key)) {
			let c = this.storage(el)
			return !empty(c)
		} else {
			return this.get(el, key) !== false
		}
	}
	/**
	 * Remueve una clave dada
	 * @param  {Element} el
	 * @param  {String} key La clave
	 * @return {void|Boolean}
	 */
	remove(el, key) {
		let i, store = el[this.UID]
		if (empty(store)) {
			return
		}

		if (!empty(key)) {
			if (isArrayish(key)) {
				key = key.map(camelCase)
			} else {
				key = camelCase(key)
				key = key in store ? [key] : (key.match( /[^\x20\t\r\n\f]+/g ) || [])
			}
			i = key.length

			while (i--) {
				delete store[key[i]]
			}
		}

		if (empty(key) && empty(store)) {
			if (el.nodeType) {
				el[this.UID] = undefined
			} else {
				delete el[this.UID]
			}
		}

		return true
	}
}
