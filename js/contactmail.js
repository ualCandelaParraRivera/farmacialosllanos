$(document).ready(function() {
    
    // procesa el formulario
    $('form#contactform').submit(function(event) {


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
            url 		: './controller/contactmail',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            // devuelve el resultado
            .done(function(data) {
                console.log(data);
                // Manejo de errores
                if (!data.success) {
                      if (data.errors.name) {
                        $('#name').addClass('is-invalid');
                        $('#name-group').append('<div class="help-block">' + data.errors.name + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.subject) {
                        $('#subject').addClass('is-invalid');
                        $('#subject-group').append('<div class="help-block">' + data.errors.subject + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.message) {
                        $('#message').addClass('is-invalid');
                        $('#message-group').append('<div class="help-block">' + data.errors.message + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    $('form#contactform').append('<div class="col-12 mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    $('form#contactform').append('<div class="col-12 mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })
 
            

        
    });

});