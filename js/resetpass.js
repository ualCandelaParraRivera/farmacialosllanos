$(document).ready(function() {
    
    // procesa el formulario
    $('form#frmReset').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/resetpass',
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
                    
                    if (data.errors.pass) {
                        $('#email').addClass('is-invalid'); // add the error class to show red input
                        $('#email-group').append('<div class="help-block">' + data.errors.pass + '</div>'); // add the actual error message under our input
                    }
                    
                    $('form#frmReset').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    // Si todo es correcto, se muestra un mensaje
                    $('form#frmReset').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            });
    });

});