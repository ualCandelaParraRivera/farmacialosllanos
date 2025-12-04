$(document).ready(function() {
    
    // procesa el formulario
    $('form#datosatributos').submit(function(event) {

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
            url 		: './controller/editattributes',
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
                    
                    if (data.errors.clave) {
                        $('#clave').addClass('is-invalid'); // add the error class to show red input
                        $('#clave-group').append('<div class="help-block">' + data.errors.clave + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.valor) {
                        $('#valor').addClass('is-invalid'); // add the error class to show red input
                        $('#valor-group').append('<div class="help-block">' + data.errors.valor + '</div>'); // add the actual error message under our input
                    }
                    
                    $('form#datosatributos').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    window.location.replace("adminattributes");
                }
            });
            
    });

});