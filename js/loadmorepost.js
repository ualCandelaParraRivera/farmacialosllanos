$(document).ready(function(){

    $('.load-more').click(function(){
        var row = Number($('#row').val());
        var allcount = Number($('#all').val());
        var rowperpage = Number($('#postperpage').val());
        var type  = Number($('#type').val());
        var guid  = $('#guid').val();
        row = row + rowperpage;

        if(row < allcount){
            $("#row").val(row);

            $.ajax({
                url: 'controller/loadmorepost',
                type: 'post',
                data: {row:row, type:type, guid:guid},
                beforeSend:function(){
                    $(".load-more").text("Cargando...");
                },
                success: function(response){
                    setTimeout(function() {
                        $(".post:last").after(response).show().fadeIn("slow");
                        var rowno = row + rowperpage;

                        if(rowno >= allcount){
                            $('.load-more').text("Ocultar");
                        }else{
                            $(".load-more").text("Cargar más");
                        }
                    }, 1000);
                }
            });
        }else{
            $('.load-more').text("Ocultando...");

            setTimeout(function() {
                $('.post:nth-child('+rowperpage+')').nextAll('.post').remove();
                $("#row").val(0);
                $('.load-more').text("Cargar más");
            }, 1000);
        }
    });

});