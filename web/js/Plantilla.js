$(function() {
	// Solo para efectos de desplegar una ventana modal utiliza un formulario en views/plantillas/formplantilla.php, crear
	$('.botonCreaPlantilla').click(function() {
		//e.preventDefault();
		$('#modalCreaPlantilla').modal('show').find('#contenidoCreaPlantilla').load( $(this).attr('value') );
	});

	// Solo para efectos de desplegar una ventana modal utiliza un formulario en views/plantillas/formplantilla.php, actualizar
	$('.botonActPlantilla').click(function() {
		$('#modalActPlantilla').modal('show').find('#contenidoActPlantilla').load( $(this).data('url') );
	});

	// Borrar plantilla. Regn viene encriptado
	$('.borra-plantilla').click(function(e) {
		e.preventDefault(); // Si lo quito la ventana modal de confirmación se ejecuta pero al segundo se quita

		var datos = $(this);
		var regn  = datos.data('regn');
		var url   = datos.data('url');

		krajeeDialog.confirm('Esta seguro(a) que desea borrar esta Plantilla?', function (result) {
			if (result) {
				window.location = url+'?regn='+regn;
			}
		});
	});

});
