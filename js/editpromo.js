$(document).ready(function() {
    
    // procesa el formulario
    $('form#datospromo').submit(function(event) {

        
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-control').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta
        event.preventDefault();
        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editpromo',
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
                    
                    if (data.errors.codigo) {
                        $('#codigo').addClass('is-invalid'); // add the error class to show red input
                        $('#codigo-group').append('<div class="help-block">' + data.errors.codigo + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.descuento) {
                        $('#descuento').addClass('is-invalid'); // add the error class to show red input
                        $('#descuento-group').append('<div class="help-block">' + data.errors.descuento + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.minimo) {
                        $('#minimo').addClass('is-invalid'); // add the error class to show red input
                        $('#minimo-group').append('<div class="help-block">' + data.errors.minimo + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.maximo) {
                        $('#maximo').addClass('is-invalid'); // add the error class to show red input
                        $('#maximo-group').append('<div class="help-block">' + data.errors.maximo + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.fechainicio) {
                        $('#fechainicio').addClass('is-invalid'); // add the error class to show red input
                        $('#fechainicio-group').append('<div class="help-block">' + data.errors.fechainicio + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.fechafin) {
                        $('#fechafin').addClass('is-invalid'); // add the error class to show red input
                        $('#fechafin-group').append('<div class="help-block">' + data.errors.fechafin + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid'); // add the error class to show red input
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>'); // add the actual error message under our input
                    }
                    $('form#datospromo').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    if(data.redirect){
                        window.location.replace("adminpromos");
                    }else{
                        window.location.replace("admineditpromo?guidpromo="+data.message);
                    }
                    
                }
            });
            
    });

});