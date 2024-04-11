// Obtener referencia al modal
const modal = document.getElementById('modal-eliminar');

// Obtener referencia al botón "Eliminar" y al botón "Cancelar"
const btnEliminar = document.querySelectorAll('.eliminar');
const btnCancel = document.getElementById('btn-cancelar-eliminar');
const btnClose = document.getElementById('close');

// Agregar evento click al botón "Eliminar"
btnEliminar.forEach(btn => {
	btn.addEventListener('click', function (event) {
		// Evitar que se ejecute el evento por defecto
		event.preventDefault();

		const idNoticia = btn.getAttribute('data-id');
		// Asignar el ID de la noticia al formulario de eliminación dentro del modal
		const formEliminar = modal.querySelector('#form-eliminar');
		const inputIdNoticia = formEliminar.querySelector(
			'input[name="id_noticia"]'
		);
		inputIdNoticia.value = idNoticia;

		console.log(inputIdNoticia.value);
		// Mostrar el modal
		modal.style.display = 'block';
	});
});

// Agregar evento click al botón "Cancelar" del modal
btnCancel.addEventListener('click', function () {
	// Ocultar el modal
	modal.style.display = 'none';
});

// Agregar evento click al botón "Cerrar" del modal
btnClose.addEventListener('click', function () {
	// Ocultar el modal
	modal.style.display = 'none';
});
