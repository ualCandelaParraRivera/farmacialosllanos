$(document).ready(function() {

    $('form#shipaddrForm').submit(function(event) {

        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();
        
        var fd = new FormData($(this)[0]);

         $.ajax({
            type        : 'POST',
            url         : './controller/shipaddress',
            data        : fd,
            dataType    : 'json',
            processData: false,
            contentType: false,
            encode      : true
        })
            .done(function(data) {
                console.log(data);
                if (!data.success) {
                      if (data.errors.firstname) {
                        $('#shipFirstName').addClass('is-invalid');
                        $('#shipFirstName-group').append('<div class="help-block">' + data.errors.firstname + '</div>');
                    }
                    if (data.errors.middlename) {
                        $('#shipMiddleName').addClass('is-invalid');
                        $('#shipMiddleName-group').append('<div class="help-block">' + data.errors.middlename + '</div>');
                    }
                    if (data.errors.mobile) {
                        $('#shipPhone').addClass('is-invalid');
                        $('#shipPhone-group').append('<div class="help-block">' + data.errors.mobile + '</div>');
                    }
                    if (data.errors.country) {
                        $('#shipCountry').addClass('is-invalid');
                        $('#shipCountry-group').append('<div class="help-block">' + data.errors.country + '</div>');
                    }
                    if (data.errors.region) {
                        $('#shipDistrict').addClass('is-invalid');
                        $('#shipDistrict-group').append('<div class="help-block">' + data.errors.region + '</div>');
                    }
                    if (data.errors.city) {
                        $('#shipTownOrCity').addClass('is-invalid');
                        $('#shipTownOrCity-group').append('<div class="help-block">' + data.errors.city + '</div>');
                    }
                    if (data.errors.street) {
                        $('#shipAddress1').addClass('is-invalid');
                        $('#shipAddress1-group').append('<div class="help-block">' + data.errors.street + '</div>');
                    }
                    if (data.errors.account) {
                        $('#accountCheck').addClass('is-invalid');
                        $('#accountCheck-group').append('<div class="help-block">' + data.errors.account + '</div>');
                    } 
                    $('#shiprow').append('<div class="col-12 learts-mb-20 mt-3 alert alert-danger">' + data.message + '</div>');
                } else {
                    $('#shiprow').append('<div class="col-12 learts-mb-20 mt-3 alert alert-success">' + data.message + '</div>');
                }
            })
    });

});