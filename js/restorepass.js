$(document).ready(function() {
    
    // procesa el formulario
    $('form#frmRestore').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/restorepass',
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
                    
                    if (data.errors.newpass) {
                        $('#newpass').addClass('is-invalid'); // add the error class to show red input
                        $('#newpass-group').append('<div class="help-block">' + data.errors.newpass + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.confirmpass) {
                        $('#confirmpass').addClass('is-invalid'); // add the error class to show red input
                        $('#confirmpass-group').append('<div class="help-block">' + data.errors.confirmpass + '</div>'); // add the actual error message under our input
                    }
                    
                    $('form#frmRestore').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    window.location.replace("redirectresetlogin");
    
                }
            });
    });

});