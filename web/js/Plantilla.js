$(function() {
   // Solo para efectos de desplegar una ventana modal utiliza un formulario en views/plantillas/formplantilla.php, crear
   $('#botonCreaPlantilla').click(function(e) {
      e.preventDefault();
      $('#modalCreaPlantilla').modal('show').find('#contenidoCreaPlantilla').load( $(this).data('url') );
   });

   // Solo para efectos de desplegar una ventana modal utiliza un formulario en views/plantillas/formplantilla.php, actualizar
   $('.botonActPlantilla').click(function(e) {
      e.preventDefault();
      $('#modalActPlantilla').modal('show').find('#contenidoActPlantilla').load( $(this).data('url') );
   });


   $('.borra-plantilla').click(function(e) {
      e.preventDefault(); // Si lo quito la ventana modal de confirmación se ejecuta pero al segundo se quita

      var datos  = $(this);
      var regn   = datos.data('regn');
      var url    = datos.data('url');

      krajeeDialog.confirm('Esta seguro(a) que desea borrar esta Plantilla?', function (result) {
         if (result) {
            $.ajax({
               url: 'borra-plantilla',
               data: {'regn': regn},
               type: 'POST',
               dataType: 'json',
               done: function(resultado) {
                  if(resultado.estado == 'failed') {
                     krajeeDialog.alert('La plantilla no pudo ser borrado, porque hay datos que dependen de el, por ejemplo capitulos.')
                  } else {
                     window.location = 'plantillas';   // No hago el redirect en el controlador, sino aquí
                  };
               },
              /* error: function(e){
                  alert('Error al tratar de borrar la plantilla: '+e.responseText);
               } */
            });
         }
      });
   });

});
