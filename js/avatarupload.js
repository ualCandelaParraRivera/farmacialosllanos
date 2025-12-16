$(document).ready(function() {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });

    $('form#datosimagen').submit(function(event) {

        event.preventDefault();
        
        $('.form-control').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);

        $.ajax({
            type 		: 'POST',
            url 		: './controller/avatarupload',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {
                if (!data.success) {
                    $('form#datosimagen').append('<div class="mt-3 alert alert-danger">' + data.errors.message + '</div>');

                } else {

                    $('form#datosimagen').append('<div class="mt-3 alert alert-success">' + data.message + '</div>');
    
                }
            })

            

        
    });
    
});