$(document).ready(function() {
    var form = $('#checkoutForm');
    var formMessages = $('#placeordergroup');

    $(form).submit(function(e) {
        e.preventDefault();

        // Limpiar mensajes anteriores
        $(formMessages).empty();
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        // Obtener el método de envío seleccionado
        var selectedShipping = $('input[name="options"]:checked');
        if (selectedShipping.length === 0) {
            $(formMessages).html('<div class="alert alert-danger">Debe seleccionar un método de envío</div>');
            return false;
        }

        // Crear FormData con todos los campos del formulario
        var formData = $(form).serialize();
        
        // Agregar el valor del radio button seleccionado
        formData += '&options=' + selectedShipping.attr('id');

        console.log('FormData:', formData); // Para debugging

        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData,
            dataType: 'json'
        })
        .done(function(response) {
            console.log('Response completa:', response);
            console.log('Success value:', response.success);

            if (response.success === false || !response.success) {
                // Mostrar errores
                if (response.errors) {
                    $.each(response.errors, function(key, value) {
                        var formGroup = $('#' + key + '-group');
                        $(formGroup).addClass('has-error');
                        $(formGroup).append('<div class="help-block text-danger">' + value + '</div>');
                    });
                }

                if (response.message) {
                    $(formMessages).html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            } else {
                // Éxito
                console.log('Pedido realizado con éxito, redirigiendo...');
                $(formMessages).html('<div class="alert alert-success">Pedido realizado correctamente. Redirigiendo...</div>');
                
                // Redirigir directamente sin vaciar el carrito (el servidor ya lo hace)
                setTimeout(function() {
                    console.log('Redirigiendo a transaction...');
                    window.location.replace('transaction');
                }, 1500);
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Error completo:', xhr);
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response text:', xhr.responseText);
            
            // Intentar parsear la respuesta como JSON
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.message) {
                    $(formMessages).html('<div class="alert alert-danger">' + response.message + '</div>');
                } else {
                    $(formMessages).html('<div class="alert alert-danger">Ha ocurrido un error. Por favor, inténtelo de nuevo.</div>');
                }
            } catch(e) {
                if (xhr.responseText !== '') {
                    $(formMessages).html('<div class="alert alert-danger">' + xhr.responseText + '</div>');
                } else {
                    $(formMessages).html('<div class="alert alert-danger">Ha ocurrido un error. Por favor, inténtelo de nuevo.</div>');
                }
            }
        });
    });

    // Actualizar el precio de envío cuando se selecciona una opción
    $('input[name="options"]').on('change', function() {
        var shippingPrice = parseFloat($(this).val());
        var finalPrice = parseFloat($('#finalprice').val());
        var grandTotal = finalPrice + shippingPrice;
        
        $('#shipmentprice').val(shippingPrice);
        $('#shippingcost span').text(shippingPrice.toFixed(2).replace('.', ',') + '€');
        $('#grandtotal span').text(grandTotal.toFixed(2).replace('.', ',') + '€');
        
        // Guardar el tipo de envío
        $('#shipmenttype').val($(this).attr('id'));
    });
});