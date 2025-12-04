$(document).ready(function() {
    
    // procesa el formulario
    $('form#checkoutForm').submit(function(event) {


        // impide que se envie el formulario de forma normal y refresca la página
        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid'); // elimina la clase is-invalid
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta
        

        var fd = new FormData($(this)[0]);

        // procesa el formulario
         $.ajax({
            type 		: 'POST',
            url 		: './controller/placeorder',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            // devuelve el resultado
            .done(function(data) {
                console.log(data);
                // Manejo de errores
                if (!data.success) {
                     if (data.errors.billfirstname) {
                        $('#billfirstname').addClass('is-invalid');
                        $('#billfirstname-group').append('<div class="help-block">' + data.errors.billfirstname + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.billmiddlename) {
                        $('#billmiddlename').addClass('is-invalid');
                        $('#billmiddlename-group').append('<div class="help-block">' + data.errors.billmiddlename + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.billmobile) {
                        $('#billmobile').addClass('is-invalid');
                        $('#billmobile-group').append('<div class="help-block">' + data.errors.billmobile + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.billcountry) {
                        $('#billcountry').addClass('is-invalid');
                        $('#billcountry-group').append('<div class="help-block">' + data.errors.billcountry + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.billdistrict) {
                        $('#billdistrict').addClass('is-invalid');
                        $('#billdistrict-group').append('<div class="help-block">' + data.errors.billdistrict + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.billcity) {
                        $('#billcity').addClass('is-invalid');
                        $('#billcity-group').append('<div class="help-block">' + data.errors.billcity + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.billaddress1) {
                        $('#billaddress1').addClass('is-invalid');
                        $('#billaddress1-group').append('<div class="help-block">' + data.errors.billaddress1 + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shipfirstname) {
                        $('#shipfirstname').addClass('is-invalid');
                        $('#shipfirstname-group').append('<div class="help-block">' + data.errors.shipfirstname + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shipmiddlename) {
                        $('#shipmiddlename').addClass('is-invalid');
                        $('#shipmiddlename-group').append('<div class="help-block">' + data.errors.shipmiddlename + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shipmobile) {
                        $('#shipmobile').addClass('is-invalid');
                        $('#shipmobile-group').append('<div class="help-block">' + data.errors.shipmobile + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shipcountry) {
                        $('#shipcountry').addClass('is-invalid');
                        $('#shipcountry-group').append('<div class="help-block">' + data.errors.shipcountry + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shipdistrict) {
                        $('#shipdistrict').addClass('is-invalid');
                        $('#shipdistrict-group').append('<div class="help-block">' + data.errors.shipdistrict + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shipcity) {
                        $('#shipcity').addClass('is-invalid');
                        $('#shipcity-group').append('<div class="help-block">' + data.errors.shipcity + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shipaddress1) {
                        $('#shipaddress1').addClass('is-invalid');
                        $('#shipaddress1-group').append('<div class="help-block">' + data.errors.shipaddress1 + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.account) {
                        $('#accountCheck').addClass('is-invalid');
                        $('#accountCheck-group').append('<div class="help-block">' + data.errors.account + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.payment) {
                        $('#paymenttype').addClass('is-invalid');
                        $('#paymenttype-group').append('<div class="help-block">' + data.errors.payment + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.shippingtype) {
                        $('#shipmenttype').addClass('is-invalid');
                        $('#shipmenttype-group').append('<div class="help-block">' + data.errors.shippingtype + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    $('#placeordergroup').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    console.log("LOLL");
                    window.location.replace("transaction");
    
                }
            })
 
            

        
    });

});