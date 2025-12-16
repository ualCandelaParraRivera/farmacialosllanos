$(document).ready(function() {
    $('form#frmReset').submit(function(event) {
        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);

        $.ajax({
            type        : 'POST',
            url         : './controller/resetpass',
            data        : fd,
            dataType    : 'json',
            processData : false,
            contentType : false,
            encode      : true
        })
        .done(function(data) {
            if (!data.success) {
                if (data.errors.pass) {
                    $('#email').addClass('is-invalid');
                    $('#email-group').append('<div class="help-block">' + data.errors.pass + '</div>');
                }
                $('form#frmReset').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');
            } else {
                $('form#frmReset').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
            }
        });
    });
});