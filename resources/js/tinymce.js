const tinymCe = require('tinymce');
require('tinymce/themes/silver');
require('tinymce/icons/default');
require('tinymce/plugins/advlist');
require('tinymce/plugins/anchor');
require('tinymce/plugins/autolink');
require('tinymce/plugins/autoresize');
require('tinymce/plugins/autosave');
require('tinymce/plugins/charmap');
require('tinymce/plugins/code');
// require('tinymce/plugins/emoticons');
require('tinymce/plugins/fullpage');
require('tinymce/plugins/fullscreen');
require('tinymce/plugins/hr');
require('tinymce/plugins/image');
require('tinymce/plugins/importcss');
require('tinymce/plugins/imagetools');
require('tinymce/plugins/insertdatetime');
require('tinymce/plugins/link');
require('tinymce/plugins/lists');
require('tinymce/plugins/media');
require('tinymce/plugins/pagebreak');
require('tinymce/plugins/paste');
require('tinymce/plugins/preview');
require('tinymce/plugins/searchreplace');
require('tinymce/plugins/table');
require('tinymce/plugins/visualblocks');
require('tinymce/plugins/visualchars');
require('tinymce/plugins/wordcount');

// custom plugis
require('./tinymce-plugins')


tinyMCE.baseURL = location.origin+'/public/js/tinymce'

_$.getValueActiveEditor = function(offHtml = true){
	return _$.getValueEditor(tinyMCE.activeEditor, offHtml);
}

_$.getValueEditor = function(e, offHtml = true){
	var editor = e.getContent();
	if(offHtml){
		var start = editor.indexOf('<body') + 6;
		var end = editor.indexOf('</body>') - start - 1;
		return editor.substr(start, end);
	}
	return editor;
}

_$().__proto__.editor = function(style = 'classic', options = {}) {

	if (_$.isObject('style') && _$.isString(options)) {
		let clon = style
			style = options
			options = clon
	}

	let opt = {
		path_absolute: '/',
		relative_urls: false,
		themes: 'sviler',
		theme: 'silver',
		language: 'es_ES',
		plugins: [
			'advlist',
			'anchor',
			'autolink',
			'autoresize',
			'autosave',
			'bootstrap',
			'charmap',
			'code',
			// 'emoticons',
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

	return this.each((el) => {
		let s = _$(el).hasData('style') ? _$(el).data('style') : style,
			d = _$(el).data()

		opt.target = el;
		opt.setup = (editor) =>{
			_$(el).data('tinymce', editor)
			
		}
		if(s === 'inline'){
			opt.inline = true
			opt.toolbar[0] += 'preview'
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