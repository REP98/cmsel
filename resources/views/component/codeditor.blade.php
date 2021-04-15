<form action="style" method="post">
	<!-- <div class="d-flex justify-content-end mb-1">
		<div class="btn-group" role="group" aria-label="Opciones del editor">
			<button type="submit" class="btn btn-success" aria-label="Guardar">
				<i class="fas fa-check"></i>
			</button>
		</div>
	</div> -->
	<textarea data-role="codeditor"
			@if(!empty($attr)) {{$attr}} @endif
			data-lang="@if(!empty($langCode)) {{$langCode}} @else text/html @endif"
			placeholder="Ingrese su código aquí"></textarea>
</form>