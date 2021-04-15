require('./bootstrap');
import CKEditorInspector from '@ckeditor/ckeditor5-inspector'
require('./CodeMirror')

window.CKE = window.CKE || {}

function saveData(data) {
	console.log('simulate, autosave')
}

window.getDataEditor = (editor) => {
	let CKE = _$(_$(editor.editor.sourceElement).clone(true)[1])
	let data = {};
	data.title = CKE.find('h1').first().text()
	CKE.find('h1').remove();
	data.content = CKE.html()
	return data;
}

_$().__proto__.editor = function(style = 'classic',options) {
	if (_$.isObject('style') && _$.isString(options)) {
		let clon = style
			style = options
			options = clon
	}

	let opt = {
		removePlugins: ['Markdown'],
		autosave: {
			waitingTime: 300000, // 300000ms = 5min
			save(editor){
				return saveData(editor.getData())
			}
		},
		codeBlock: {
			languages: [
				{language: 'plaintext', label: 'Text'},
				{language: 'php', label: 'PHP'},
				{language: 'javacript', label: 'Javascript'},
				{language: 'json', label: 'JSON'},
				{language: 'html', label: 'HTML'},
				{language: 'css', label: 'CSS'}
			]
		},
		fontFamily: {
			options: [
				'default',
				'Alex Brush',
				'Arial, sans-serif',
				'Asap',
				'Asap Condensed',
				'Courier New, Courier monospace',
				'Georgia',
				'Lucida Sans',
				'Montserrat',
				'Open Sans',
				'Open Sans Condensed',
				'Roboto',
				'Roboto Slab',
				'Tahoma',
				'Times New Roman',
				'Trebuchet MS',
				'Ubuntu',
				'Ubuntu Mono',
				'Verdana'
			],
			supportAllValues: true
		},
		fontSize: {
			options: [
				'tiny',
				11,
				12,
				'small',
				'default',
				18,
				19,
				21,
				22,
				26,
				'big',
				32,
				36,
				38,
				'huge'
			]
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
			styles: [
				'alignLeft',
				'alignCenter',
				'alignRight',
			],
			resizeOptios: [
				{
					name: 'resizeImage:original',
					label:'Original 100%',
					value: null
				},
				{
					name: 'resizeImage:75',
					label:'75%',
					value: '75'
				},
				{
					name: 'resizeImage:50',
					label:'50%',
					value: '50'
				},
				{
					name: 'resizeImage:25',
					label:'25%',
					value: '25'
				}
			],
			toolbar: [
				'imageStyle:alignLeft',
				'imageStyle:alignCenter',
				'imageStyle:alignRight',
				'|',
				'resizeImage',
				'|',
				'imageTextAlternative',
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
			// uploadUrl: _$.Route('ckfinder_connector')+'?command=QuickUpload&type=Files',
			uploadUrl: location.origin+"/admin/filemanager?editor=ckEditor",
			options: {
				language: 'es',
				//connectorPath: _$.Route('ckfinder_connector')
			}
		},
		htmlEmbed: {
			showPreviews: true,
			sanitizeHtml: (inputHtml) => {
				_$.script(inputHtml)
				return {
					html: inputHtml,
					hasChanged:true,
				}
			}
		},
		heading: {
			options: [
				{ model: 'paragraph', view:'p', title: 'Parrafos', class: 'ck-heading_paragraph'},
				{ model: 'pheading', view: {name: 'p', class:'lead'}, 
					title: 'Parrafo Encabezado', class:'ck-heading_lead'
				},
				{ model: 'headingbd', view: {name: 'h2', class:'hightitle'}, 
					title: 'Encabezado con BorderTOP', class:'ck-heading_htop'
				}
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
							_$(element).data('cke', {editor, config})
							_$('.ck-body-wrapper').insertAfter(element)
							CKEditorInspector.attach(editor)
							editor.element = element
							return editor
						} )
				})
				
				watchdog.setDestructor( editor => {
					_$.hooks.run('CKE.create', editor.element, editor)
					_$(editor.element).removeData('cke')
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
