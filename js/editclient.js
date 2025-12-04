$(document).ready(function() {
    
    // procesa el formulario
    $('form#datospersonales').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editclient',
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
                    
                    if (data.errors.firstname) {
                        $('#firstname').addClass('is-invalid'); // add the error class to show red input
                        $('#firstname-group').append('<div class="help-block">' + data.errors.firstname + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.middlename) {
                        $('#middlename').addClass('is-invalid'); // add the error class to show red input
                        $('#middlename-group').append('<div class="help-block">' + data.errors.middlename + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.mobile) {
                        $('#mobile').addClass('is-invalid'); // add the error class to show red input
                        $('#mobile-group').append('<div class="help-block">' + data.errors.mobile + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid'); // add the error class to show red input
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the actual error message under our input
                    }
                    $('form#datospersonales').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    window.location.replace("admineditclients?guiduser="+data.message);
                }
            });
            
    });

    // procesa el formulario
    $('form#datosdirecciones').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid'); // elimina la clase has-error
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); // elimina el texto de error
        $('.alert').remove(); // elimina el texto de alerta

        var fd = new FormData($(this)[0]);
        
        // procesa el formulario
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editclient',
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
                    
                    if (data.errors.billfirstname) {
                        $('#billfirstname').addClass('is-invalid'); // add the error class to show red input
                        $('#billfirstname-group').append('<div class="help-block">' + data.errors.billfirstname + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.billmiddlename) {
                        $('#billmiddlename').addClass('is-invalid'); // add the error class to show red input
                        $('#billmiddlename-group').append('<div class="help-block">' + data.errors.billmiddlename + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.billmobile) {
                        $('#billmobile').addClass('is-invalid'); // add the error class to show red input
                        $('#billmobile-group').append('<div class="help-block">' + data.errors.billmobile + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.billcountry) {
                        $('#billcountry').addClass('is-invalid'); // add the error class to show red input
                        $('#billcountry-group').append('<div class="help-block">' + data.errors.billcountry + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.billdistrict) {
                        $('#billdistrict').addClass('is-invalid'); // add the error class to show red input
                        $('#billdistrict-group').append('<div class="help-block">' + data.errors.billdistrict + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.billcity) {
                        $('#billcity').addClass('is-invalid'); // add the error class to show red input
                        $('#billcity-group').append('<div class="help-block">' + data.errors.billcity + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.billpostalcode) {
                        $('#billpostalcode').addClass('is-invalid'); // add the error class to show red input
                        $('#billpostalcode-group').append('<div class="help-block">' + data.errors.billpostalcode + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.billaddress) {
                        $('#billaddress').addClass('is-invalid'); // add the error class to show red input
                        $('#billaddress-group').append('<div class="help-block">' + data.errors.billaddress + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipfirstname) {
                        $('#shipfirstname').addClass('is-invalid'); // add the error class to show red input
                        $('#shipfirstname-group').append('<div class="help-block">' + data.errors.shipfirstname + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipmiddlename) {
                        $('#shipmiddlename').addClass('is-invalid'); // add the error class to show red input
                        $('#shipmiddlename-group').append('<div class="help-block">' + data.errors.shipmiddlename + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipmobile) {
                        $('#shipmobile').addClass('is-invalid'); // add the error class to show red input
                        $('#shipmobile-group').append('<div class="help-block">' + data.errors.shipmobile + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipcountry) {
                        $('#shipcountry').addClass('is-invalid'); // add the error class to show red input
                        $('#shipcountry-group').append('<div class="help-block">' + data.errors.shipcountry + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipdistrict) {
                        $('#shipdistrict').addClass('is-invalid'); // add the error class to show red input
                        $('#shipdistrict-group').append('<div class="help-block">' + data.errors.shipdistrict + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipcity) {
                        $('#shipcity').addClass('is-invalid'); // add the error class to show red input
                        $('#shipcity-group').append('<div class="help-block">' + data.errors.shipcity + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shippostalcode) {
                        $('#shippostalcode').addClass('is-invalid'); // add the error class to show red input
                        $('#shippostalcode-group').append('<div class="help-block">' + data.errors.shippostalcode + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipcountry) {
                        $('#shipcountry').addClass('is-invalid'); // add the error class to show red input
                        $('#shipcountry-group').append('<div class="help-block">' + data.errors.shipcountry + '</div>'); // add the actual error message under our input
                    }
                    if (data.errors.shipaddress) {
                        $('#shipaddress').addClass('is-invalid'); // add the error class to show red input
                        $('#shipaddress-group').append('<div class="help-block">' + data.errors.shipaddress + '</div>'); // add the actual error message under our input
                    }
                    $('form#datosdirecciones').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    window.location.replace("admineditclients?guiduser="+data.message);
                }
            });
            
    });

});