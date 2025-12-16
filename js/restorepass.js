$(document).ready(function() {

    $('form#frmRestore').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type        : 'POST',
            url         : './controller/restorepass',
            data        : fd,
            dataType    : 'json',
            processData : false,
            contentType : false,
            encode      : true
        })
        .done(function(data) {

            if (!data.success) {
                
                if (data.errors.newpass) {
                    $('#newpass').addClass('is-invalid');
                    $('#newpass-group').append('<div class="help-block">' + data.errors.newpass + '</div>');
                }
                if (data.errors.confirmpass) {
                    $('#confirmpass').addClass('is-invalid');
                    $('#confirmpass-group').append('<div class="help-block">' + data.errors.confirmpass + '</div>');
                }
                
                $('form#frmRestore').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

            } else {

                window.location.replace("redirectresetlogin");

            }
        });
    });

});