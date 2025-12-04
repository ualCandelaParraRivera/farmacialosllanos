$(document).ready(function() {
    
    // procesa el formulario
    $('form#translate').submit(function(event) {


        // impide que se envie el formulario de forma normal y refresca la página
        event.preventDefault();
        var fd = new FormData($(this)[0]);

        // procesa el formulario
         $.ajax({
            type 		: 'POST',
            url 		: './controller/translate',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            // devuelve el resultado
            .done(function(data) {
                // Manejo de errores
                
            })
 
            

        
    });

});