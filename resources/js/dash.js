require('./bootstrap')
require('./CodeMirror')
require('./tinymce')

function saveData(data) {
	console.log('simulate, autosave')
}

_$(() => {
	_$.setFree$()
	
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
