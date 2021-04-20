<div data-role="editor" data-style="inline"
@if(!empty($attr))
@foreach($attr as $name => $value)
@foreach($value as $attN => $attV)
{{$name}}-{{$attN}}="{{$attV}}"
@endforeach
@endforeach
@endif
>
	@if(!empty($content))
	{!! $content !!}
	@endif
</div>