$(document).ready(function() {

    $('form#frmRegistration').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type        : 'POST',
            url         : './controller/register',
            data        : fd,
            dataType    : 'json',
            processData : false,
            contentType : false,
            encode      : true
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
                    if (data.errors.email2) {
                        $('#email2').addClass('is-invalid');
                        $('#email2-group').append('<div class="help-block">' + data.errors.email2 + '</div>');
                    }
                    if (data.errors.newpass) {
                        $('#newpass').addClass('is-invalid');
                        $('#newpass-group').append('<div class="help-block">' + data.errors.newpass + '</div>');
                    }
                    if (data.errors.confirmpass) {
                        $('#confirmpass').addClass('is-invalid');
                        $('#confirmpass-group').append('<div class="help-block">' + data.errors.confirmpass + '</div>');
                    }
                    if (data.errors.accept) {
                        $('#accept').addClass('is-invalid');
                        $('#accept-group').append('<div class="help-block">' + data.errors.accept + '</div>');
                    }
                    
                    $('form#frmRegistration').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {

                    $('form#frmRegistration').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
                }
            });
    });

});