<div data-role="ckeditor" data-style="inline">
	@if(!empty($title))
	<h1>{{$title}}</h1>
	@endif
	@if(!empty($content))
	{!!$content!!}
	@endif
</div>