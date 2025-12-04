$(document).ready(function() {

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
    $('form#datospost').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editblog',
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
                    if (data.errors.titulo) {
                        $('#titulo').addClass('is-invalid'); // add the error class to show red input
                        $('#titulo-group').append('<div class="help-block">' + data.errors.titulo + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.metadatos) {
                        $('#metadatos').addClass('is-invalid'); // add the error class to show red input
                        $('#metadatos-group').append('<div class="help-block">' + data.errors.metadatos + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.autor) {
                        $('#autor').addClass('is-invalid'); // add the error class to show red input
                        $('#autor-group').append('<div class="help-block">' + data.errors.autor + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.fecha) {
                        $('#fecha').addClass('is-invalid'); // add the error class to show red input
                        $('#fecha-group').append('<div class="help-block">' + data.errors.fecha + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.categories) {
                        $('#categories').addClass('is-invalid'); // add the error class to show red input
                        $('#categories-group').append('<div class="help-block">' + data.errors.categories + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.etiquetas) {
                        $('#etiquetas').addClass('is-invalid'); // add the error class to show red input
                        $('#etiquetas-group').append('<div class="help-block">' + data.errors.etiquetas + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid'); // add the error class to show red input
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.imageUpload) {
                        $('#imageUpload').addClass('is-invalid'); // add the error class to show red input
                        $('#imageUpload-group').append('<div class="help-block">' + data.errors.imageUpload + '</div>'); // add the actual error message under our input
                    }

                    $('form#datospost').append('<div class="mt-3 alert alert-danger">' + data.errors.message + '</div>');

                } else {
                    if(data.redirect){
                        window.location.replace("adminblog");
                    }else{
                        window.location.replace("admineditblog?guidpost="+data.message);
                    }
                }
            });
            
    });

});