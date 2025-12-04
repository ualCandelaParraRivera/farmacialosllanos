$(document).ready(function() {
    
    // procesa el formulario
    $('form#accountdetailsForm').submit(function(event) {


        // impide que se envie el formulario de forma normal y refresca la página
        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid'); // elimina la clase is-invalid
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta
        

        var fd = new FormData($(this)[0]);

        // procesa el formulario
         $.ajax({
            type 		: 'POST',
            url 		: './controller/accountdetails',
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
                        $('#firstname').addClass('is-invalid');
                        $('#firstname-group').append('<div class="help-block">' + data.errors.firstname + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.middlename) {
                        $('#middlename').addClass('is-invalid');
                        $('#middlename-group').append('<div class="help-block">' + data.errors.middlename + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.lastname) {
                        $('#lastname').addClass('is-invalid');
                        $('#lastname-group').append('<div class="help-block">' + data.errors.lastname + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.mobile) {
                        $('#mobile').addClass('is-invalid');
                        $('#mobile-group').append('<div class="help-block">' + data.errors.mobile + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.currentpwd) {
                        $('#currentpwd').addClass('is-invalid');
                        $('#currentpwd-group').append('<div class="help-block">' + data.errors.currentpwd + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.newpwd) {
                        $('#newpwd').addClass('is-invalid');
                        $('#newpwd-group').append('<div class="help-block">' + data.errors.newpwd + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.confirmpwd) {
                        $('#confirmpwd').addClass('is-invalid');
                        $('#confirmpwd-group').append('<div class="help-block">' + data.errors.confirmpwd + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    $('form#accountdetailsForm').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    $('form#accountdetailsForm').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })
 
            

        
    });

});