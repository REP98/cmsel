<textarea data-role="editor" 
@if(!empty($attr))
@foreach($attr as $name => $value)
@foreach($value as $attN => $attV)
{{$name}}-{{$attN}}="{{$attV}}"
@endforeach
@endforeach
@endif
>
	@if(!empty($editorContent))
	{!! $editorContent !!}
	@endif
</textarea >