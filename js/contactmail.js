$(document).ready(function() {
    
    $('form#contactform').submit(function(event) {


        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();
        

        var fd = new FormData($(this)[0]);

         $.ajax({
            type 		: 'POST',
            url 		: './controller/contactmail',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {
                console.log(data);
                if (!data.success) {
                      if (data.errors.name) {
                        $('#name').addClass('is-invalid');
                        $('#name-group').append('<div class="help-block">' + data.errors.name + '</div>');
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>');
                    }
                    if (data.errors.subject) {
                        $('#subject').addClass('is-invalid');
                        $('#subject-group').append('<div class="help-block">' + data.errors.subject + '</div>');
                    }
                    if (data.errors.message) {
                        $('#message').addClass('is-invalid');
                        $('#message-group').append('<div class="help-block">' + data.errors.message + '</div>');
                    $('form#contactform').append('<div class="col-12 mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    $('form#contactform').append('<div class="col-12 mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })
 
            

        
    });

});