$(document).ready(function() {
    $('form#frmRegister').submit(function(event) {
        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/registeremail',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
        .done(function(data) {
            if (!data.success) {
                if (data.errors.registeremail) {
                    $('#registeremail').addClass('is-invalid');
                    $('#registeremail-group').append('<div class="help-block">' + data.errors.registeremail + '</div>');
                }
                $('form#frmRegister').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');
            } else {
                var url = "register";
                var form = $('<form action="' + url + '" method="post">' +
                    '<input type="text" name="email" id="email" value="' + data.message + '" />' +
                    '</form>');
                $('body').append(form);
                form.submit();
            }
        });
    });
});