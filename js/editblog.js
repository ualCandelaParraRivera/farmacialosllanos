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
    
    $('form#datospost').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editblog',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {
                console.log(data);
                if (!data.success) {
                    if (data.errors.titulo) {
                        $('#titulo').addClass('is-invalid');
                        $('#titulo-group').append('<div class="help-block">' + data.errors.titulo + '</div>');
                    }
                    if (data.errors.metadatos) {
                        $('#metadatos').addClass('is-invalid');
                        $('#metadatos-group').append('<div class="help-block">' + data.errors.metadatos + '</div>');
                    }
                    if (data.errors.autor) {
                        $('#autor').addClass('is-invalid');
                        $('#autor-group').append('<div class="help-block">' + data.errors.autor + '</div>');
                    }
                    if (data.errors.fecha) {
                        $('#fecha').addClass('is-invalid');
                        $('#fecha-group').append('<div class="help-block">' + data.errors.fecha + '</div>');
                    }
                    if (data.errors.categories) {
                        $('#categories').addClass('is-invalid');
                        $('#categories-group').append('<div class="help-block">' + data.errors.categories + '</div>');
                    }
                    if (data.errors.etiquetas) {
                        $('#etiquetas').addClass('is-invalid');
                        $('#etiquetas-group').append('<div class="help-block">' + data.errors.etiquetas + '</div>');
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid');
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>');
                    if (data.errors.imageUpload) {
                        $('#imageUpload').addClass('is-invalid');
                        $('#imageUpload-group').append('<div class="help-block">' + data.errors.imageUpload + '</div>');
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