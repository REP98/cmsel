require('./bootstrap');
require('./CodeMirror')
const tinymCe = require('tinymce');

tinyMCE.baseURL = location.origin+'/public/js/tinymce'

_$.getValueActiveEditor = function(offHtml = true){
	return _$.getValueEditor(tinyMCE.activeEditor, offHtml);
}

_$.getValueEditor = function(e, offHtml = true){
	var editor = e.getContent();
	if(offHtml){
		var start = editor.indexOf('<body>') + 6;
		var end = editor.indexOf('</body>') - start - 1;
		return editor.substr(start, end);
	}
	return editor;
}
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
		path_absolute: '/',
		relative_urls: false,
		themes: 'sviler',
		language: 'es_ES',
		plugins: [
			'advlist',
			'anchor',
			'autolink',
			'autoresize',
			'autosave',
			'charmap',
			'code',
			'emoticons',
			'fullpage',
			'fullscreen',
			'hr',
			'image',
			'importcss',
			'imagetools',
			'insertdatetime',
			'link',
			'lists',
			'media',
			'pagebreak',
			'paste',
			'preview',
			'searchreplace',
			'table',
			//'toc',
			'visualblocks',
			'visualchars',
			'wordcount',
		],
		toolbar: [
			'styleselect | fontselect fontsizeselect forecolor backcolor | bold italic underline strikethrough subscript superscript | hr code',
			'image link openlink unlink anchor | alignleft aligncenter alignright alignjustify |  numlist bullist indent outdent | blockquote removeformat | restoredraft',
		],
		//OPCIONES EXTRAS
		fullpage_default_encoding: 'UTF-8',
		fullpage_default_font_size: '1rem',
		fullpage_default_font_family: _$('body').style('fontFamily'),
		file_picker_callback : function(callback, value, meta) {
			let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth,
				y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight,
				cmsURL = opt.path_absolute + 'dashboard/filemanager?editor=' + meta.fieldname

			if (meta.filetype == 'image') {
				cmsURL += "&type=Images"
			} else {
				cmsURL += "&type=Files"
			}

			cmsURL += '&lang=es&modal=true'

			tinyMCE.activeEditor.windowManager.openUrl({
				url : cmsURL,
				title : 'Filemanager',
				width : x * 0.8,
				height : y * 0.8,
				resizable : "yes",
				close_previous : "no",
				onMessage: (api, message) => {
				  callback(message.content);
				}
			});
		},
		//IMAGE
		a11y_advanced_options: true,
		image_caption: true,
		image_advtab: true,
		image_title: true,
		imagetools_cors_hosts: [document.domain],
		images_upload_base_path:'/public/storage/photos',
		images_upload_url: '',
		automatic_uploads: true,
		//TABLE
		table_default_attributes: {
			class:'table'
		},
		table_default_styles: {
		},
		table_responsive_width: true,
		//TPL MEDIA
		audio_template_callback: function(data) {
			return '<audio controls>' + '\n<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' + '</audio>';
		},
		video_template_callback: function(data) {
			return '<video width="' + data.width + '" height="' + data.height + '"' + (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' + '<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' + (data.source2 ? '<source src="' + data.source2 + '"' + (data.source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : '') + '</video>';
		},
		//TOC
		toc_depth:6,
		toc_class:'sv-toc',
		branding: false,
		draggable_modal: true,
		font_formats: 'Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats; Alex Brush=Alex Brush, cursive; Asap=Asap, sans-serif; Asap Condensed=Asap Condensed, sans-serif; Montserrat=Montserrat, sans-serif; Open Sans=Open Sans, sans-serif; Open Sans Condensed=Open Sans Condensed, sans-serif; Roboto=Roboto, sans-serif; Roboto Slab=Roboto Slab, sans-serif; Ubuntu=Ubuntu, sans-serif; Ubuntu Mono=Ubuntu Mono, monospace;',
		fontsize_formats: '8px 9px 10px 12px 14px 16px 18px 22px 24px 28px 32px 34px 36px 48px',
		placeholder: 'Escribe el contenido...',
		min_height: 500,
		contextmenu: false,
		// PASTE
		paste_block_drop: true,
		paste_data_image: true,
		paste_merge_formats: true
	}
/*
	let opt = {
		
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

*/
	return this.each((el) => {
		let s = _$(el).hasData('style') ? _$(el).data('style') : style,
			d = _$(el).data()

		opt.target = el;

		if(s === 'inline'){
			opt.inline = true
			
		} else {
			opt.menu = {
				file: {
					title: 'Archivo',
					items: 'preview | print '
				},
				edit: {
					title: 'Editar',
					items: 'undo  redo | cut copy paste | selectall | searchreplace'
				},
				view: {
					title: 'Ver',
					items: 'code | visualaid visualchars visualblocks | spellchecker | fullscreen fullpage '
				},
				insert: {
					title: 'Insertar',
					items: 'image link template inserttable media | emoticons charmap | hr | anchor blockquote insertdatetime | toc tocupdate | pagebreak'
				},
				format: {
					title: 'Formatos',
					items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat'
				},
				tools: {
					title: 'Herramientas',
					items: 'spellchecker spellcheckerlanguage | codesample wordcount'
				},
				table: {
					title: 'Tablas',
					items: 'inserttable | cell row column | tableprops deletetable'
				},
			}
		}
		
		if(_$(el).hasData('toolbar')) {
			opt.toolbar = _$.normalizeData(d.toolbar);
		}

		if(_$(el).hasData('autoresize')) {
			opt.plugins.push('autoresize')
			opt.autoresize_bottom_margin = 50;
		}

		if(_$(el).hasData('menubar')) {
			opt.menubar = _$(el).data();
		}
		

		tinymce.init(opt);
	});
}

_$(() => {

	_$('a[href]').each((a)=> {
		var link = _$(a).attr('href');
		
		if (link === location.href) {
			_$(a).addClass('active')
		}
	});

	_$('.sidebar-toggle').click((e) => {
		e.preventDefault()
		_$("#sidebar").toggleClass('open')
	})

	_$('.sidebar .nav .nav-item.dropdown').hover(
		function(e) {
			let el_link = _$('[data-bs-toggle]', this)
			if (!_$.empty(el_link)) {
				let Menu = _$(el_link.next('ul'));
				Menu.addClass('show')
				el_link.addClass('show')
			}
		},
		function(e) {
			let el_link = _$('[data-bs-toggle]', this)
			if (!_$.empty(el_link)) {
				let Menu = _$(el_link.next('ul'));
				Menu.removeClass('show')
				el_link.removeClass('show')
			}
		}
	)

	_$('.sidebar a[href]').click(function(e){
		e.preventDefault()
		let h = _$(this).attr('href');
		if (h !== '#') {
			location.assign(h);
		}
	})

	_$('[data-role*=table]').dataTable()

	if (_$('[data-role=editor]').length > 0) {
		_$('[data-role=editor]').editor()
	}
	if (_$('[data-role*=codeditor]').length > 0) {
		_$('[data-role*=codeditor]').codeditor()
	}
})
