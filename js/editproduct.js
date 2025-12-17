$(document).ready(function() {

    $('form#datosproducto').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editproduct',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {
                
                console.log(data);
                if (!data.success) {
                    if (data.errors.nombre) {
                        $('#nombre').addClass('is-invalid');
                        $('#nombre-group').append('<div class="help-block">' + data.errors.nombre + '</div>');
                    }
                    if (data.errors.metadatos) {
                        $('#metadatos').addClass('is-invalid');
                        $('#metadatos-group').append('<div class="help-block">' + data.errors.metadatos + '</div>');
                    }
                    if (data.errors.resumen) {
                        $('#resumen').addClass('is-invalid');
                        $('#resumen-group').append('<div class="help-block">' + data.errors.resumen + '</div>');
                    }
                    if (data.errors.descripcion) {
                        $('#descripcion').addClass('is-invalid');
                        $('#descripcion-group').append('<div class="help-block">' + data.errors.descripcion + '</div>');
                    }
                    if (data.errors.metadata) {
                        $('#metadata').addClass('is-invalid');
                        $('#metadata-group').append('<div class="help-block">' + data.errors.metadata + '</div>');
                    }
                    if (data.errors.summary) {
                        $('#summary').addClass('is-invalid');
                        $('#summary-group').append('<div class="help-block">' + data.errors.summary + '</div>');
                    }
                    if (data.errors.description) {
                        $('#description').addClass('is-invalid');
                        $('#description-group').append('<div class="help-block">' + data.errors.description + '</div>');
                    }
                    if (data.errors.sku) {
                        $('#sku').addClass('is-invalid');
                        $('#sku-group').append('<div class="help-block">' + data.errors.sku + '</div>');
                    }
                    if (data.errors.marcas) {
                        $('#marcas').addClass('is-invalid');
                        $('#marcas-group').append('<div class="help-block">' + data.errors.marcas + '</div>');
                    }
                    if (data.errors.cantidad) {
                        $('#cantidad').addClass('is-invalid');
                        $('#cantidad-group').append('<div class="help-block">' + data.errors.cantidad + '</div>');
                    }
                    if (data.errors.precio) {
                        $('#precio').addClass('is-invalid');
                        $('#precio-group').append('<div class="help-block">' + data.errors.precio + '</div>');
                    }
                    if (data.errors.tax) {
                        $('#tax').addClass('is-invalid');
                        $('#tax-group').append('<div class="help-block">' + data.errors.tax + '</div>');
                    }
                    if (data.errors.descuento) {
                        $('#descuento').addClass('is-invalid');
                        $('#descuento-group').append('<div class="help-block">' + data.errors.descuento + '</div>');
                    }
                    if (data.errors.anchura) {
                        $('#anchura').addClass('is-invalid');
                        $('#anchura-group').append('<div class="help-block">' + data.errors.anchura + '</div>');
                    }
                    if (data.errors.altura) {
                        $('#altura').addClass('is-invalid');
                        $('#altura-group').append('<div class="help-block">' + data.errors.altura + '</div>');
                    }
                    if (data.errors.profundidad) {
                        $('#profundidad').addClass('is-invalid');
                        $('#profundidad-group').append('<div class="help-block">' + data.errors.profundidad + '</div>');
                    }
                    if (data.errors.peso) {
                        $('#peso').addClass('is-invalid');
                        $('#peso-group').append('<div class="help-block">' + data.errors.peso + '</div>');
                    }
                    if (data.errors.metaetiquetas) {
                        $('#metaetiquetas').addClass('is-invalid');
                        $('#metaetiquetas-group').append('<div class="help-block">' + data.errors.metaetiquetas + '</div>');
                    }
                    if (data.errors.categorias) {
                        $('#categorias').addClass('is-invalid');
                        $('#categorias-group').append('<div class="help-block">' + data.errors.categorias + '</div>');
                    }
                    if (data.errors.etiquetas) {
                        $('#etiquetas').addClass('is-invalid');
                        $('#etiquetas-group').append('<div class="help-block">' + data.errors.etiquetas + '</div>');
                    }
                    if (data.errors.files) {
                        $('#files').addClass('is-invalid');
                        $('#files-group').append('<div class="help-block">' + data.errors.files + '</div>');
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