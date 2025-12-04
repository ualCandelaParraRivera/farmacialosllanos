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
            url 		: './controller/avatarupload',
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