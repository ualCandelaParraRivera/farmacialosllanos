$(document).ready(function() {
    
    // procesa el formulario
    $('form#datoswholesale').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editwholesale',
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
                    
                    if (data.errors.sku) {
                        $('#sku').addClass('is-invalid'); // add the error class to show red input
                        $('#sku-group').append('<div class="help-block">' + data.errors.sku + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.nombre) {
                        $('#nombre').addClass('is-invalid'); // add the error class to show red input
                        $('#nombre-group').append('<div class="help-block">' + data.errors.nombre + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.metadatos) {
                        $('#metadatos').addClass('is-invalid'); // add the error class to show red input
                        $('#metadatos-group').append('<div class="help-block">' + data.errors.metadatos + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.resumen) {
                        $('#resumen').addClass('is-invalid'); // add the error class to show red input
                        $('#resumen-group').append('<div class="help-block">' + data.errors.resumen + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid'); // add the error class to show red input
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.name) {
                        $('#name').addClass('is-invalid'); // add the error class to show red input
                        $('#name-group').append('<div class="help-block">' + data.errors.name + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.metadata) {
                        $('#metadata').addClass('is-invalid'); // add the error class to show red input
                        $('#metadata-group').append('<div class="help-block">' + data.errors.metadata + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.summary) {
                        $('#summary').addClass('is-invalid'); // add the error class to show red input
                        $('#summary-group').append('<div class="help-block">' + data.errors.summary + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.description) {
                        $('#description').addClass('is-invalid'); // add the error class to show red input
                        $('#description-group').append('<div class="help-block">' + data.errors.description + '</div>'); // add the actual error message under our input
                    }
                    $('form#datoswholesale').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    window.location.replace("admineditwholesale?guidwholesale="+data.message);
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
            url 		: './controller/editwholesale',
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