$(function() {
   // Solo para efectos de desplegar una ventana modal utiliza un formulario en views/itemsgraficos/formitems.php, crear
   $('#botonCreaItem').click(function(e) {
      e.preventDefault();
      $('#modalCreaItem').modal('show').find('#contenidoCreaItem').load( $(this).data('url') );
   });

   // Solo para efectos de desplegar una ventana modal utiliza un formulario en views/itemsgraficos/formitems.php, actualizar
   $('.botonActItem').click(function(e) {
      e.preventDefault();
      $('#modalActItem').modal('show').find('#contenidoActItem').load( $(this).data('url') );
   });


   $('.borra-item').click(function(e) {
      e.preventDefault(); // Si lo quito la ventana modal de confirmación se ejecuta pero al segundo se quita

      var datos  = $(this);
      var regn   = datos.data('regn');
      var titulo = datos.data('titulo');
      var url    = datos.data('url');

      krajeeDialog.confirm('Esta seguro(a) que desea borrar este item?', function (result) {
         if (result) {
            $.ajax({
               url: 'borraitem',
               data: {'regn': regn, 'titulo': titulo},
               type: 'POST',
               dataType: 'json',
               done: function(resultado) {
                  if(resultado.estado == 'failed') {
                     krajeeDialog.alert('El item no pudo ser borrado, porque hay datos que dependen de el, por ejemplo plantillas.')
                  } else {
                     window.location = 'items';   // No hago el redirect en el controlador, sino aquí
                  };
               },
              /* error: function(e){
                  alert('Error al tratar de borrar el item: '+e.responseText);
               } */
            });
         }
      });
   });

});



