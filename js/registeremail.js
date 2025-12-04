$(document).ready(function() {
    
    // procesa el formulario
    $('form#frmRegister').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/registeremail',
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
                    
                    if (data.errors.registeremail) {
                        $('#registeremail').addClass('is-invalid'); // add the error class to show red input
                        $('#registeremail-group').append('<div class="help-block">' + data.errors.registeremail + '</div>'); // add the actual error message under our input
                    }
                    
                    $('form#frmRegister').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    //window.location.replace("register");
                    var url = "register";
                    var form = $('<form action="' + url + '" method="post">' +
                    '<input type="text" name="email" id="email" value="' + data.message + '" />' +
                    '</form>');
                    $('body').append(form);
                    form.submit();
                }
            });
    });

});