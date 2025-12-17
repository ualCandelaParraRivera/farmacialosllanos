$(document).ready(function() {
    $('form#translate').submit(function(event) {
        event.preventDefault();
        var fd = new FormData($(this)[0]);

        $.ajax({
            type        : 'POST',
            url         : './controller/translate',
            data        : fd,
            dataType    : 'json',
            processData: false,
            contentType: false,
            encode      : true
        })
        .done(function(data) {
        })
    });
});