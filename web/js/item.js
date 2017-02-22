$(function() {
	// Solo para efectos de desplegar una ventana modal utiliza un formulario en views/itemsgraficos/formitems.php, crear
	$('.botonCreaItem').click(function() {
		//e.preventDefault();
		$('#modalCreaItem').modal('show').find('#contenidoCreaItem').load( $(this).attr('value') );
	});

	// Solo para efectos de desplegar una ventana modal utiliza un formulario en views/itemsgraficos/formitems.php, actualizar
	$('.botonActItem').click(function() {
		$('#modalActItem').modal('show').find('#contenidoActItem').load( $(this).data('url') );
	});

	// Borrar item. Regn viene encriptado
	$('.borra-item').click(function(e) {
		e.preventDefault(); // Si lo quito la ventana modal de confirmación se ejecuta pero al segundo se quita

		var datos = $(this);
		var regn  = datos.data('regn');
		var url   = datos.data('url');

		krajeeDialog.confirm('Esta seguro(a) que desea borrar este item?', function (result) {
			if (result) {
				window.location = url+'?regn='+regn;
			}
		});
	});

});
