$(document).ready(function() {
    
    $('form#datosmarca').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editbrand',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {

                if (!data.success) {
                    
                    if (data.errors.nombre) {
                        $('#nombre').addClass('is-invalid');
                        $('#nombre-group').append('<div class="help-block">' + data.errors.nombre + '</div>');
                    }
                    if (data.errors.introduccion) {
                        $('#introduccion').addClass('is-invalid');
                        $('#introduccion-group').append('<div class="help-block">' + data.errors.introduccion + '</div>');
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid');
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>');
                    }
                    if (data.errors.telefono) {
                        $('#telefono').addClass('is-invalid');
                        $('#telefono-group').append('<div class="help-block">' + data.errors.telefono + '</div>');
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>');
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
    $('form#datosimagen').submit(function(event) {

        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);

        $.ajax({
            type 		: 'POST',
            url 		: './controller/editbrand',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {
                if (!data.success) {
                    $('form#datosimagen').append('<div class="mt-3 alert alert-danger">' + data.errors.message + '</div>');

                } else {

                    $('form#datosimagen').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })

            

        
    });
});