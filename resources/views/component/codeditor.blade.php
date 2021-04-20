<textarea data-role="codeditor"
		@if(!empty($attr)) {!! $attr !!} @endif
		data-lang="@if(!empty($langCode)) {{$langCode}} @else text/html @endif">
			@if(!empty($content))
			{!! $content !!}
			@endif
		</textarea>