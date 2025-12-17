$(document).ready(function() {

    $('form#datosptag').submit(function(event) {

        $('.form-group').removeClass('is-invalid');
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();
        event.preventDefault();
        var fd = new FormData($(this)[0]);

        $.ajax({
            type        : 'POST',
            url         : './controller/editptag',
            data        : fd,
            dataType    : 'json',
            processData : false,
            contentType : false,
            encode      : true
        })
        .done(function(data) {

            if (!data.success) {

                if (data.errors.nombre) {
                    $('#nombre').addClass('is-invalid');
                    $('#nombre-group').append('<div class="help-block">' + data.errors.nombre + '</div>');
                }
                if (data.errors.metadatos) {
                    $('#metadatos').addClass('is-invalid');
                    $('#metadatos-group').append('<div class="help-block">' + data.errors.metadatos + '</div>');
                }
                if (data.errors.descripcion) {
                    $('#descripcion').addClass('is-invalid');
                    $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>');
                }
                $('form#datosptag').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

            } else {
                if(data.redirect){
                    window.location.replace("adminptags");
                }else{
                    window.location.replace("admineditptag?guidtag="+data.message);
                }
            }
        });

    });

});