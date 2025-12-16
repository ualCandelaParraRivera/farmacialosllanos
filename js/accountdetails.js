$(document).ready(function() {
    
    $('form#accountdetailsForm').submit(function(event) {


        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove(); 
        $('.alert').remove(); 
        

        var fd = new FormData($(this)[0]);

         $.ajax({
            type 		: 'POST',
            url 		: './controller/accountdetails',
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
                    if (data.errors.lastname) {
                        $('#lastname').addClass('is-invalid');
                        $('#lastname-group').append('<div class="help-block">' + data.errors.lastname + '</div>');
                    }
                    if (data.errors.mobile) {
                        $('#mobile').addClass('is-invalid');
                        $('#mobile-group').append('<div class="help-block">' + data.errors.mobile + '</div>');
                    }
                    if (data.errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>');
                    }
                    if (data.errors.currentpwd) {
                        $('#currentpwd').addClass('is-invalid');
                        $('#currentpwd-group').append('<div class="help-block">' + data.errors.currentpwd + '</div>');
                    }
                    if (data.errors.newpwd) {
                        $('#newpwd').addClass('is-invalid');
                        $('#newpwd-group').append('<div class="help-block">' + data.errors.newpwd + '</div>');
                    }
                    if (data.errors.confirmpwd) {
                        $('#confirmpwd').addClass('is-invalid');
                        $('#confirmpwd-group').append('<div class="help-block">' + data.errors.confirmpwd + '</div>');
                    }
                    $('form#accountdetailsForm').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');

                } else {
                    $('form#accountdetailsForm').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })
 
            

        
    });

});