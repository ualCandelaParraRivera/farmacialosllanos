$(document).ready(function() {
    
    // procesa el formulario
    $('form#datosmarca').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editbrand',
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
                    if (data.errors.introduccion) {
                        $('#introduccion').addClass('is-invalid'); // add the error class to show red input
                        $('#introduccion-group').append('<div class="help-block">' + data.errors.introduccion + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid'); // add the error class to show red input
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.telefono) {
                        $('#telefono').addClass('is-invalid'); // add the error class to show red input
                        $('#telefono-group').append('<div class="help-block">' + data.errors.telefono + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid'); // add the error class to show red input
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the actual error message under our input
                    }
                    $('form#datosmarca').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    window.location.replace("admineditbrand?guidbrand="+data.message);
                }
            });
            
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });

    // procesa el formulario
    $('form#datosimagen').submit(function(event) {

        // impide que se envie el formulario de forma normal y refresca la página
        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid'); // elimina la clase is-invalid
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);

        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editbrand',
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
                    $('form#datosimagen').append('<div class="mt-3 alert alert-danger">' + data.errors.message + '</div>');

                } else {

                    $('form#datosimagen').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })

            

        
    });
});