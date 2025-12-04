$(document).ready(function() {
    //open popup
    $('.cd-popup-trigger').on('click', function(event){
        var id = $(this).closest('tr').data('id');
        console.log(id);
        event.preventDefault();
        $.ajax({
            type 		: 'POST',
            url 		: 'controller/doublecheck',
            data 		: {op:"pop", id: id}
        })
        // devuelve el resultado
        .done(function(data) {
            console.log(data);
            $('.cd-popup').html(data);
            $('.cd-popup').addClass('is-visible');
        })
        
    });
    
    //close popup
    $('.cd-popup').on('click', function(event){
        if( $(event.target).is('.cd-popup-yes') ) {
            var id = $(event.target).data("value");
            console.log(id);
            $(this).removeClass('is-visible');
            event.preventDefault();
            $.ajax({
                type 		: 'POST',
                url 		: 'controller/doublecheck',
                data 		: {op:"del", id: id}
            })
            // devuelve el resultado
            .done(function(data) {
                console.log(data);
                location.reload();
            })
            
        }
    });

    //close popup
    $('.cd-popup').on('click', function(event){
        if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup-no') || $(event.target).is('.cd-popup') ) {
            console.log("NO");
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
            $('.cd-popup').removeClass('is-visible');
        }
    });

});