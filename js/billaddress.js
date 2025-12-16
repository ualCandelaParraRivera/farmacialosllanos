$(document).ready(function() {
    
    $('form#billaddrForm').submit(function(event) {

        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();
        

        var fd = new FormData($(this)[0]);

         $.ajax({
            type 		: 'POST',
            url 		: './controller/billaddress',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {
                console.log(data);
                if (!data.success) {
                      if (data.errors.firstname) {
                        $('#billFirstName').addClass('is-invalid');
                        $('#billFirstName-group').append('<div class="help-block">' + data.errors.firstname + '</div>'); // agrega el mensaje de error debajo de la entrada
                    }
                    if (data.errors.middlename) {
                        $('#billMiddleName').addClass('is-invalid');
                        $('#billMiddleName-group').append('<div class="help-block">' + data.errors.middlename + '</div>');
                    }
                    if (data.errors.mobile) {
                        $('#billPhone').addClass('is-invalid');
                        $('#billPhone-group').append('<div class="help-block">' + data.errors.mobile + '</div>');
                    }
                    if (data.errors.country) {
                        $('#billCountry').addClass('is-invalid');
                        $('#billCountry-group').append('<div class="help-block">' + data.errors.country + '</div>');
                    }
                    if (data.errors.region) {
                        $('#billDistrict').addClass('is-invalid');
                        $('#billDistrict-group').append('<div class="help-block">' + data.errors.region + '</div>');
                    }
                    if (data.errors.city) {
                        $('#billTownOrCity').addClass('is-invalid');
                        $('#billTownOrCity-group').append('<div class="help-block">' + data.errors.city + '</div>');
                    }
                    if (data.errors.street) {
                        $('#billAddress1').addClass('is-invalid');
                        $('#billAddress1-group').append('<div class="help-block">' + data.errors.street + '</div>');
                    }
                    if (data.errors.account) {
                        $('#accountCheck').addClass('is-invalid');
                        $('#accountCheck-group').append('<div class="help-block">' + data.errors.account + '</div>');
                    } 
                    $('#billrow').append('<div class="col-12 learts-mb-20 mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    $('#billrow').append('<div class="col-12 learts-mb-20 mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })
 
            

        
    });

});