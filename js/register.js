$(document).ready(function() {
    
    // procesa el formulario
    $('form#frmRegistration').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/register',
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
                    
                    if (data.errors.firstname) {
                        $('#firstname').addClass('is-invalid'); // add the error class to show red input
                        $('#firstname-group').append('<div class="help-block">' + data.errors.firstname + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.middlename) {
                        $('#middlename').addClass('is-invalid'); // add the error class to show red input
                        $('#middlename-group').append('<div class="help-block">' + data.errors.middlename + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.mobile) {
                        $('#mobile').addClass('is-invalid'); // add the error class to show red input
                        $('#mobile-group').append('<div class="help-block">' + data.errors.mobile + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid'); // add the error class to show red input
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.newpass) {
                        $('#newpass').addClass('is-invalid'); // add the error class to show red input
                        $('#newpass-group').append('<div class="help-block">' + data.errors.newpass + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.confirmpass) {
                        $('#confirmpass').addClass('is-invalid'); // add the error class to show red input
                        $('#confirmpass-group').append('<div class="help-block">' + data.errors.confirmpass + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.accept) {
                        $('#accept').addClass('is-invalid'); // add the error class to show red input
                        $('#accept-group').append('<div class="help-block">' + data.errors.accept + '</div>'); // add the actual error message under our input
                    }
                    
                    $('form#frmRegistration').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    $('form#frmRegistration').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
                }
            });
    });

});




