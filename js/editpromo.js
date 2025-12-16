$(document).ready(function() {
    $('form#datospromo').submit(function(event) {
        $('.form-group').removeClass('is-invalid');
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();
        event.preventDefault();
        var fd = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: './controller/editpromo',
            data: fd,
            dataType: 'json',
            processData: false,
            contentType: false,
            encode: true
        }).done(function(data) {
            if (!data.success) {
                if (data.errors.codigo) {
                    $('#codigo').addClass('is-invalid');
                    $('#codigo-group').append('<div class="help-block">' + data.errors.codigo + '</div>');
                }
                if (data.errors.descuento) {
                    $('#descuento').addClass('is-invalid');
                    $('#descuento-group').append('<div class="help-block">' + data.errors.descuento + '</div>');
                }
                if (data.errors.minimo) {
                    $('#minimo').addClass('is-invalid');
                    $('#minimo-group').append('<div class="help-block">' + data.errors.minimo + '</div>');
                }
                if (data.errors.maximo) {
                    $('#maximo').addClass('is-invalid');
                    $('#maximo-group').append('<div class="help-block">' + data.errors.maximo + '</div>');
                }
                if (data.errors.fechainicio) {
                    $('#fechainicio').addClass('is-invalid');
                    $('#fechainicio-group').append('<div class="help-block">' + data.errors.fechainicio + '</div>');
                }
                if (data.errors.fechafin) {
                    $('#fechafin').addClass('is-invalid');
                    $('#fechafin-group').append('<div class="help-block">' + data.errors.fechafin + '</div>');
                }
                if (data.errors.descripcion) {
                    $('#descripcion').addClass('is-invalid');
                    $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>');
                }
                $('form#datospromo').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');
            } else {
                if (data.redirect) {
                    window.location.replace("adminpromos");
                } else {
                    window.location.replace("admineditpromo?guidpromo=" + data.message);
                }
            }
        });
    });
});