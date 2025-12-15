$(document).ready(function() {
    
    // Manejar cambio de método de pago
    $('#wirebtn').off('click').on('click', function() {
        $('#paymenttype').val('w');
        console.log('Método de pago seleccionado: Transferencia');
    });
    
    $('#cardbtn').off('click').on('click', function() {
        $('#paymenttype').val('c');
        console.log('Método de pago seleccionado: Tarjeta');
    });
    
    // Manejar cambio de método de envío
    $('input[name="options"]').off('change').on('change', function() {
        var selectedValue = $(this).val();
        var selectedId = $(this).attr('id');
        
        $('#shipmentprice').val(selectedValue);
        $('#shipmenttype').val(selectedId);
        
        // Actualizar el costo de envío en la tabla
        $('#shippingcost span').text(parseFloat(selectedValue).toFixed(2).replace('.', ',') + '€');
        
        // Actualizar el total
        var finalprice = parseFloat($('#finalprice').val());
        var grandtotal = finalprice + parseFloat(selectedValue);
        $('#grandtotal span').text(grandtotal.toFixed(2).replace('.', ',') + '€');
        
        console.log('Método de envío:', selectedId, 'Precio:', selectedValue);
    });
    
    // Capturar clic del botón
    $('.btn.btn-dark.btn-outline-hover-dark').off('click').on('click', function(e) {
        e.preventDefault();
        $('#checkoutForm').submit();
    });
    
    // procesa el formulario
    $('form#checkoutForm').off('submit').on('submit', function(event) {
        event.preventDefault();
        
        console.log('Formulario enviado');
        console.log('Método de pago:', $('#paymenttype').val());
        console.log('Método de envío:', $('#shipmenttype').val());
        console.log('Precio envío:', $('#shipmentprice').val());
        
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();
        
        var fd = new FormData($(this)[0]);

        $.ajax({
            type: 'POST',
            url: './controller/placeorder',
            data: fd,
            dataType: 'json',
            processData: false,
            contentType: false,
            encode: true
        })
        .done(function(data) {
            console.log(data);
            if (!data.success) {
                // Manejo de errores
                if (data.errors.billfirstname) {
                    $('#billfirstname').addClass('is-invalid');
                    $('#billfirstname-group').append('<div class="help-block">' + data.errors.billfirstname + '</div>');
                }
                if (data.errors.billmiddlename) {
                    $('#billmiddlename').addClass('is-invalid');
                    $('#billmiddlename-group').append('<div class="help-block">' + data.errors.billmiddlename + '</div>');
                }
                if (data.errors.email) {
                    $('#email').addClass('is-invalid');
                    $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>');
                }
                if (data.errors.billmobile) {
                    $('#billmobile').addClass('is-invalid');
                    $('#billmobile-group').append('<div class="help-block">' + data.errors.billmobile + '</div>');
                }
                if (data.errors.billcountry) {
                    $('#billcountry').addClass('is-invalid');
                    $('#billcountry-group').append('<div class="help-block">' + data.errors.billcountry + '</div>');
                }
                if (data.errors.billdistrict) {
                    $('#billdistrict').addClass('is-invalid');
                    $('#billdistrict-group').append('<div class="help-block">' + data.errors.billdistrict + '</div>');
                }
                if (data.errors.billcity) {
                    $('#billcity').addClass('is-invalid');
                    $('#billcity-group').append('<div class="help-block">' + data.errors.billcity + '</div>');
                }
                if (data.errors.billaddress1) {
                    $('#billaddress1').addClass('is-invalid');
                    $('#billaddress1-group').append('<div class="help-block">' + data.errors.billaddress1 + '</div>');
                }
                if (data.errors.shipfirstname) {
                    $('#shipfirstname').addClass('is-invalid');
                    $('#shipfirstname-group').append('<div class="help-block">' + data.errors.shipfirstname + '</div>');
                }
                if (data.errors.shipmiddlename) {
                    $('#shipmiddlename').addClass('is-invalid');
                    $('#shipmiddlename-group').append('<div class="help-block">' + data.errors.shipmiddlename + '</div>');
                }
                if (data.errors.shipmobile) {
                    $('#shipmobile').addClass('is-invalid');
                    $('#shipmobile-group').append('<div class="help-block">' + data.errors.shipmobile + '</div>');
                }
                if (data.errors.shipcountry) {
                    $('#shipcountry').addClass('is-invalid');
                    $('#shipcountry-group').append('<div class="help-block">' + data.errors.shipcountry + '</div>');
                }
                if (data.errors.shipdistrict) {
                    $('#shipdistrict').addClass('is-invalid');
                    $('#shipdistrict-group').append('<div class="help-block">' + data.errors.shipdistrict + '</div>');
                }
                if (data.errors.shipcity) {
                    $('#shipcity').addClass('is-invalid');
                    $('#shipcity-group').append('<div class="help-block">' + data.errors.shipcity + '</div>');
                }
                if (data.errors.shipaddress1) {
                    $('#shipaddress1').addClass('is-invalid');
                    $('#shipaddress1-group').append('<div class="help-block">' + data.errors.shipaddress1 + '</div>');
                }
                if (data.errors.account) {
                    $('#accountCheck').addClass('is-invalid');
                    $('#accountCheck-group').append('<div class="help-block">' + data.errors.account + '</div>');
                }
                if (data.errors.payment) {
                    $('#paymenttype').addClass('is-invalid');
                    $('#paymenttype-group').append('<div class="help-block">' + data.errors.payment + '</div>');
                }
                if (data.errors.shippingtype) {
                    $('#shipmenttype').addClass('is-invalid');
                    $('#shipmenttype-group').append('<div class="help-block">' + data.errors.shippingtype + '</div>');
                }
                $('#placeordergroup').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');
            } else {
                console.log("Pedido realizado correctamente");
                window.location.replace("transaction");
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Error AJAX:', error);
            console.error('Response:', xhr.responseText);
        });
    });
});