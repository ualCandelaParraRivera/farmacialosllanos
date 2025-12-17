$(document).ready(function() {
    
    $('form#datospersonales').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editclient',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {

                if (!data.success) {
                    
                    if (data.errors.firstname) {
                        $('#firstname').addClass('is-invalid');
                        $('#firstname-group').append('<div class="help-block">' + data.errors.firstname + '</div>');
                    }
                    if (data.errors.middlename) {
                        $('#middlename').addClass('is-invalid');
                        $('#middlename-group').append('<div class="help-block">' + data.errors.middlename + '</div>');
                    }
                    if (data.errors.mobile) {
                        $('#mobile').addClass('is-invalid');
                        $('#mobile-group').append('<div class="help-block">' + data.errors.mobile + '</div>');
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>');
                    }
                    $('form#datospersonales').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    window.location.replace("admineditclients?guiduser="+data.message);
                }
            });
            
    });

    $('form#datosdirecciones').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editclient',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {

                if (!data.success) {
                    
                    if (data.errors.billfirstname) {
                        $('#billfirstname').addClass('is-invalid');
                        $('#billfirstname-group').append('<div class="help-block">' + data.errors.billfirstname + '</div>');
                    }
                    if (data.errors.billmiddlename) {
                        $('#billmiddlename').addClass('is-invalid');
                        $('#billmiddlename-group').append('<div class="help-block">' + data.errors.billmiddlename + '</div>');
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
                    if (data.errors.billpostalcode) {
                        $('#billpostalcode').addClass('is-invalid');
                        $('#billpostalcode-group').append('<div class="help-block">' + data.errors.billpostalcode + '</div>');
                    if (data.errors.billaddress) {
                        $('#billaddress').addClass('is-invalid');
                        $('#billaddress-group').append('<div class="help-block">' + data.errors.billaddress + '</div>');
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
                    if (data.errors.shipdistrict) {
                        $('#shipdistrict').addClass('is-invalid');
                        $('#shipdistrict-group').append('<div class="help-block">' + data.errors.shipdistrict + '</div>');
                    }
                    if (data.errors.shipcity) {
                        $('#shipcity').addClass('is-invalid');
                        $('#shipcity-group').append('<div class="help-block">' + data.errors.shipcity + '</div>');
                    }
                    if (data.errors.shippostalcode) {
                        $('#shippostalcode').addClass('is-invalid');
                        $('#shippostalcode-group').append('<div class="help-block">' + data.errors.shippostalcode + '</div>');
                    }
                    if (data.errors.shipcountry) {
                        $('#shipcountry').addClass('is-invalid');
                        $('#shipcountry-group').append('<div class="help-block">' + data.errors.shipcountry + '</div>');
                    }
                    if (data.errors.shipaddress) {
                        $('#shipaddress').addClass('is-invalid');
                        $('#shipaddress-group').append('<div class="help-block">' + data.errors.shipaddress + '</div>');
                    }
                    $('form#datosdirecciones').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    window.location.replace("admineditclients?guiduser="+data.message);
                }
            });
            
    });

});