$(document).ready(function() {
    
    // procesa el formulario
    $('form#shipaddrForm').submit(function(event) {


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
            url 		: './controller/shipaddress',
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
                      if (data.errors.firstname) {
                        $('#shipFirstName').addClass('is-invalid');
                        $('#shipFirstName-group').append('<div class="help-block">' + data.errors.firstname + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.middlename) {
                        $('#shipMiddleName').addClass('is-invalid');
                        $('#shipMiddleName-group').append('<div class="help-block">' + data.errors.middlename + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.mobile) {
                        $('#shipPhone').addClass('is-invalid');
                        $('#shipPhone-group').append('<div class="help-block">' + data.errors.mobile + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.country) {
                        $('#shipCountry').addClass('is-invalid');
                        $('#shipCountry-group').append('<div class="help-block">' + data.errors.country + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.region) {
                        $('#shipDistrict').addClass('is-invalid');
                        $('#shipDistrict-group').append('<div class="help-block">' + data.errors.region + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.city) {
                        $('#shipTownOrCity').addClass('is-invalid');
                        $('#shipTownOrCity-group').append('<div class="help-block">' + data.errors.city + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.street) {
                        $('#shipAddress1').addClass('is-invalid');
                        $('#shipAddress1-group').append('<div class="help-block">' + data.errors.street + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.account) {
                        $('#accountCheck').addClass('is-invalid');
                        $('#accountCheck-group').append('<div class="help-block">' + data.errors.account + '</div>'); // agrega el mensaje de error debajo de la entrada
                    } 
                    $('#shiprow').append('<div class="col-12 learts-mb-20 mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    $('#shiprow').append('<div class="col-12 learts-mb-20 mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })
 
            

        
    });

});