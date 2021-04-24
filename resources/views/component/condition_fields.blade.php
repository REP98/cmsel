<div class="input-group w-50 me-2 condition_fields" aria-label="Condiciones">
	<span class="input-group-text" id="text">{{__('Mostrar en')}}</span>
	<select class="form-select condition_type" name="condition[type]">
		@php
			$condition_type = [
					'url' => 'Url de la Página',
					'index' => 'Principal',
					'category' => 'Categoría',
					'archive' => 'Archivo',
					'post' => 'Entradas',
					'custom_post' => 'Entradas Personalizadas',
					'byid'=> 'Por ID'
			];
			$selected = !empty($edit) ? $type : 'url';
		@endphp
		@foreach($condition_type as $name => $value)
		<option value="{{$name}}" @if($selected == $name) selected @endif>{{$value}}</option>
		@endforeach
	</select>
	<div class="outputcond"></div>
</div>

@section('script')
@parent
@if($loadScipt === false)
window.ConponentCondition = {}

function ifit(conditionFields, remove){
	if(remove === true) {
		let span = conditionFields.find('.text2')
		span.remove()
	} else {
		let span = _$('<span>')
		span.addClass('input-group-text', 'text2')
		span.html('si es')
		conditionFields.find('.outputcond').before(span)
	}
}

function createSelect(conditionFields, attr, options) {
	var select = _$('<select>'),
		p = conditionFields.find('.outputcond')
	if (!_$.empty(attr)) {
		select.attr(attr)		
	}
	select.addClass('form-select')
	if (!_$.empty(options)) {
		_$.each(options, function(val, name){
			let opt = _$('<option>')
			opt.val(name)
			opt.text(val)
			@if(!empty($condition))
			@php
			$value = array_values($condition)[0];
			@endphp
			if (name === '{{$value}}') {
				opt.prop('selected', true)
			}
			@endif
			opt.appendTo(select.Elem[0])
		})
	}
	p.emptyHtml()
	select.appendTo(p.Elem[0])
	return select
}

var change = function(){
	let type = _$(this).val()
	const conditionFields = _$(_$(this).parent())
	const outputcond = conditionFields.find('.outputcond')
	console.log(type);
	if (conditionFields.find('.text2').length === 0 && ['url', 'index'].indexOf(type) === -1) {
		ifit(conditionFields, false)
	} else if(conditionFields.find('.text2').length > 0 && ['url', 'index'].indexOf(type) > -1) {
		ifit(conditionFields, true)
	}
	switch(type) {
		case 'category':
		if (!_$.hasProp(ConponentCondition, 'selectedCategories')) {
			ConponentCondition.selectedCategories = createSelect(conditionFields,
			{
				name:'condition[condition][category]'
			},{/* List Category via Ajax */})
		}/* else axios.get()*/
		break;
		case 'archive': 
		if (!_$.hasProp(ConponentCondition, 'selectedArchive')) {
			ConponentCondition.selectedArchive = createSelect(conditionFields,
			{
				name:'condition[condition][archive]'
			},{
				'singlepost':'Entradas',
				'category':'Categorias',
				'author':'Autors',
				'tags': 'Etiquetas'	
			})
		} else {
			outputcond.html(ConponentCondition.selectedArchive.Elem[0])	
		}
		break;
		case 'post': 
		if (!_$.hasProp(ConponentCondition, 'selectedPost')) {
			ConponentCondition.selectedPost = createSelect(conditionFields,
			{
				name:'condition[condition][post]'
			},{/* List Post via Ajax */})
		}/* else axios.get()*/
		break;
		case 'custom_post': 
		if (!_$.hasProp(ConponentCondition, 'selectedCustomPost')) {
			ConponentCondition.selectedCustomPost = createSelect(conditionFields,
			{
				name:'condition[condition][custompost]'
			},{/* List Custom Post via Ajax */})
		}/* else axios.get()*/
		break;
		case 'byid': 
		if (!_$.hasProp(ConponentCondition, 'selectedCustomPost')) {
			ConponentCondition.selectedCustomPost = createSelect(conditionFields,
			{
				name:'condition[condition][byid]'
			},{/* List Custom Post via Ajax */})
		}/* else axios.get()*/
		break;
	}
}

change.call(_$(".condition_type").Elem[0], null)

_$(".condition_type").change(change)
@endif
@endsection