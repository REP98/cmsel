<form action="style" method="post">
	<div class="d-flex justify-content-end mb-1">
		<div class="btn-group" role="group" aria-label="Opciones del editor">
			<button type="submit" class="btn btn-success" aria-label="Guardar">
				<i class="fas fa-check"></i>
			</button>
			<select class="form-select warning" arial-label="Lenguajes del editor">
				<option value="text/css">CSS</option>
				<option value="application/javascript">JS</option>
				<option value="text/html" selected>HTML</option>
			</select>
		</div>
	</div>
	<textarea data-role="codeditor" name="code" 
			placeholder="Ingrese su código aqui como si fuera en una hoja HTML" data-lang="text/html"></textarea>
</form>