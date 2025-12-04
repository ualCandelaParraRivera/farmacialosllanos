$(document).ready(function() {
    
    // procesa el formulario
    $('form#datosptag').submit(function(event) {

        
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-control').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta
        event.preventDefault();
        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editptag',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            // devuelve el resultado
            .done(function(data) {

                // Manejo de errores
                if (!data.success) {
                    
                    if (data.errors.nombre) {
                        $('#nombre').addClass('is-invalid'); // add the error class to show red input
                        $('#nombre-group').append('<div class="help-block">' + data.errors.nombre + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.metadatos) {
                        $('#metadatos').addClass('is-invalid'); // add the error class to show red input
                        $('#metadatos-group').append('<div class="help-block">' + data.errors.metadatos + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid'); // add the error class to show red input
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>'); // add the actual error message under our input
                    }
                    $('form#datosptag').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    if(data.redirect){
                        window.location.replace("adminptags");
                    }else{
                        window.location.replace("admineditptag?guidtag="+data.message);
                    }
                    
                }
            });
            
    });

});