/**
 * TinyMce Bootstrap plugin
 * @version TinyMce 5, Bootstrap 5, Plugins 1
 * @author Robert Pérez <delfinmundo@gmail.com>
 */

/**
 * Fascino plugins is required
 */

if (window._$ === undefined) {
	throw new Error('Fascino is not defined')
}

/**
 * Bootstrap plugins is required
 */

let bs = window.bootstrap || _$.bs || window.bs

if (bs === undefined ) {
	throw new Error('Bootstrap is not defined')
}

const optionsDefault = {
	bootstrapCss: '',
	component: [
		'row',
		'col',
		'form',
		'btn',
		'icon',
		'image',
		'table',
		'alert',  
		'breadcrumb',
		'pagination',
		'badge',
		'carousel', 
		'collapse', 
		'dropdown', 
		'modal', 
		'offcanvas', 
		'Popover', 
		'ScrollSpy', 
		'Tab', 
		'Toast', 
		'Tooltip'
	]
};

tinymce.PluginManager.add('bootstrap', (editor, url) => {
	console.log(editor, url);
	editor.bootstrap = _$.extend({}, optionsDefault, editor.bootstrap);
	
})