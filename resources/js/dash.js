require('./bootstrap');
import CKEditorInspector from '@ckeditor/ckeditor5-inspector'
require('./CodeMirror')

console.log(CodeMirror)

window.CKE = window.CKE || {}

function saveData(data) {
	console.log('simulate, autosave')
}

_$().__proto__.editor = function(style = 'classic',options) {
	if (_$.isObject('style') && _$.isString(options)) {
		let clon = style
			style = options
			options = clon
	}

	let opt = {
		autosave: {
			waitingTime: 300000, // 300000ms = 5min
			save(editor){
				return saveData(editor.getData())
			}
		},
		fontFamily: {
			options: [
				'default',
				'Alex Brush',
				'Asap',
				'Asap Condensed',
				'Montserrat',
				'Open Sans Condensed',
				'Roboto',
				'Roboto Slab'
			],
			supportAllValues: true
		},
		toolbar: {
			items: [
				'heading',
				'|',
				'fontSize',
				'fontFamily',
				'fontColor',
				'fontBackgroundColor',
				'highlight',
				'|',
				'bold',
				'italic',
				'underline',
				'strikethrough',
				'|',
				'removeFormat',
				'superscript',
				'subscript',
				'specialCharacters',
				'link',
				'todoList',
				'bulletedList',
				'numberedList',
				'|',
				'alignment',
				'outdent',
				'indent',
				'|',
				'CKFinder',
				'imageUpload',
				'imageInsert',
				'mediaEmbed',
				'horizontalLine',
				'-',
				'code',
				'|',
				'undo',
				'redo',
				'restrictedEditing',
				'|',
				'blockQuote',
				'insertTable',
				'|',
				'codeBlock',
				'htmlEmbed',
				'pageBreak',
				'|',
				'MathType',
				'ChemType',
				'textPartLanguage'
			],
			shouldNotGroupWhenFull: true
		},
		language: 'es',
		image: {
			toolbar: [
				'imageTextAlternative',
				'imageStyle:full',
				'imageStyle:side',
				'linkImage'
			]
		},
		table: {
			contentToolbar: [
				'tableColumn',
				'tableRow',
				'mergeTableCells',
				'tableCellProperties',
				'tableProperties'
			]
		},
		ckfinder: {
			options: {
				language: 'es'
			}
		},
		heading: {
			options: [
				{ model: 'paragraph', view:'p', title: 'Parrafos', class: 'ck-heading_paragraph'}
			]
		}			
	}

	for(let i = 1; i <= 6; i++){
		opt.heading.options.push({
			model: `heading${i}`,
			title: `Heading ${i}`,
			view: `h${i}`,
			class: `ck-heading_heading${i}`
		})
	}

	return this.each((el) => {
		let s = _$(el).hasData('style') ? _$(el).data('style') : style,
			tn = (CKSource, e) => {
				const watchdog = new CKSource.Watchdog()
				
				watchdog.setCreator( ( element, config ) => {
					return CKSource.Editor
						.create( element, config )
						.then( editor => {
							_$.hooks.run('CKE.create', element, editor, config)
							_$(element).data('CKE', {editor, config})
							CKEditorInspector.attach(editor)
							editor.element = element
							return editor
						} )
				})
				
				watchdog.setDestructor( editor => {
					_$.hooks.run('CKE.create', editor.element, editor)
					_$(editor.element).removeData('CKE')
					return editor.destroy();
				})
				
				watchdog.on( 'error', (e) => {
					console.log("CKE_Error:", e);
				})

				watchdog
					.create(e, opt)
					.catch((e) => {
						console.log("CKE_Error:", e);
					})

				window.CKE[s] = {CKSource, watchdog, e}
			}
		if (_$.hasProp(window.CKE, s)) {
			return this.each((el) => {
				if (el !== window.CKE[s].e) {
					tn(window.CKE[s].CKSource, el)
				}
			})
		} else {
			
			return this.each((el) => {
				if (s === 'inline') {
				/* webpackChunkName: "ckeditor/[name].[chunkhash]" */	import('./ckeditor5-inline/build/ckeditor.js')
						.then(cke => {
							tn(CKSource, el)
						})
						.catch(e => {
							console.log("CKE-LOADER_ Error:", e);
						})
				} else {
				/* webpackChunkName: "ckeditor/[name].[chunkhash]" */	import('./ckeditor5/build/ckeditor.js')
						.then(cke => {
							tn(CKSource, el)
						})
						.catch(e => {
							console.log("CKE-LOADER_ Error:", e);
						})
				}				
			})
		}
	});
}

$(() => {

	$('a[href]').each((a)=> {
		var link = $(a).attr('href');
		
		if (link === location.href) {
			$(a).addClass('active')
		}
	});

	$('.sidebar-toggle').click((e) => {
		e.preventDefault()
		$("#sidebar").toggleClass('open')
	})

	$('.sidebar .nav .nav-item.dropdown').hover(
		function(e) {
			let el_link = $('[data-bs-toggle]', this)
			if (!$.empty(el_link)) {
				let Menu = $(el_link.next('ul'));
				Menu.addClass('show')
				el_link.addClass('show')
			}
		},
		function(e) {
			let el_link = $('[data-bs-toggle]', this)
			if (!$.empty(el_link)) {
				let Menu = $(el_link.next('ul'));
				Menu.removeClass('show')
				el_link.removeClass('show')
			}
		}
	)

	$('.sidebar a[href]').click(function(e){
		e.preventDefault()
		let h = $(this).attr('href');
		if (h !== '#') {
			location.assign(h);
		}
	})

	$('[data-role*=table]').dataTable()

	if ($('[data-role*=ckeditor]').length > 0) {
		$('[data-role*=ckeditor]').editor()
	}
	if ($('[data-role*=codeditor]').length > 0) {
		$('[data-role*=codeditor]').codeditor()
	}
})
