$(document).ready(function() {

    // procesa el formulario
    $('form#datosproducto').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editproduct',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            // devuelve el resultado
            .done(function(data) {
                
                // var data = JSON.parse(data);
                console.log(data);
                // Manejo de errores
                if (!data.success) {
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
                    if (data.errors.sku) {
                        $('#sku').addClass('is-invalid'); // add the error class to show red input
                        $('#sku-group').append('<div class="help-block">' + data.errors.sku + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.marcas) {
                        $('#marcas').addClass('is-invalid'); // add the error class to show red input
                        $('#marcas-group').append('<div class="help-block">' + data.errors.marcas + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.cantidad) {
                        $('#cantidad').addClass('is-invalid'); // add the error class to show red input
                        $('#cantidad-group').append('<div class="help-block">' + data.errors.cantidad + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.precio) {
                        $('#precio').addClass('is-invalid'); // add the error class to show red input
                        $('#precio-group').append('<div class="help-block">' + data.errors.precio + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.tax) {
                        $('#tax').addClass('is-invalid'); // add the error class to show red input
                        $('#tax-group').append('<div class="help-block">' + data.errors.tax + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.descuento) {
                        $('#descuento').addClass('is-invalid'); // add the error class to show red input
                        $('#descuento-group').append('<div class="help-block">' + data.errors.descuento + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.anchura) {
                        $('#anchura').addClass('is-invalid'); // add the error class to show red input
                        $('#anchura-group').append('<div class="help-block">' + data.errors.anchura + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.altura) {
                        $('#altura').addClass('is-invalid'); // add the error class to show red input
                        $('#altura-group').append('<div class="help-block">' + data.errors.altura + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.profundidad) {
                        $('#profundidad').addClass('is-invalid'); // add the error class to show red input
                        $('#profundidad-group').append('<div class="help-block">' + data.errors.profundidad + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.peso) {
                        $('#peso').addClass('is-invalid'); // add the error class to show red input
                        $('#peso-group').append('<div class="help-block">' + data.errors.peso + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.metaetiquetas) {
                        $('#metaetiquetas').addClass('is-invalid'); // add the error class to show red input
                        $('#metaetiquetas-group').append('<div class="help-block">' + data.errors.metaetiquetas + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.categorias) {
                        $('#categorias').addClass('is-invalid'); // add the error class to show red input
                        $('#categorias-group').append('<div class="help-block">' + data.errors.categorias + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.etiquetas) {
                        $('#etiquetas').addClass('is-invalid'); // add the error class to show red input
                        $('#etiquetas-group').append('<div class="help-block">' + data.errors.etiquetas + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.files) {
                        $('#files').addClass('is-invalid'); // add the error class to show red input
                        $('#files-group').append('<div class="help-block">' + data.errors.files + '</div>'); // add the actual error message under our input
                    }

                    $('#card').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    if(data.redirect){
                        window.location.replace("adminproducts");
                    }else{
                        $('#card').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
                    }
                }
            });
            
    });

});