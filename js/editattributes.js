$(document).ready(function() {

    $('form#datosatributos').submit(function(event) {

        $('.form-group').removeClass('is-invalid');
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();
        event.preventDefault();
        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editattributes',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {

                if (!data.success) {
                    
                    if (data.errors.clave) {
                        $('#clave').addClass('is-invalid');
                        $('#clave-group').append('<div class="help-block">' + data.errors.clave + '</div>'); 
                    }
                    if (data.errors.valor) {
                        $('#valor').addClass('is-invalid');
                        $('#valor-group').append('<div class="help-block">' + data.errors.valor + '</div>');
                    }
                    
                    $('form#datosatributos').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    window.location.replace("adminattributes");
                }
            });
            
    });

});