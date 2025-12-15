$(document).ready(function(){

    // Load more data
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

                    // Setting little delay while displaying new content
                    setTimeout(function() {
                        // appending posts after last post with class="post"
                        $(".post:last").after(response).show().fadeIn("slow");
                        var rowno = row + rowperpage;

                        // checking row value is greater than allcount or not
                        if(rowno >= allcount){

                            // Change the text and background
                            $('.load-more').text("Ocultar");
                            //$('.load-more').css("background","darkorchid");
                        }else{
                            $(".load-more").text("Cargar más");
                        }
                    }, 1000);

                }
            });
        }else{
            $('.load-more').text("Ocultando...");

            // Setting little delay while removing contents
            setTimeout(function() {

                // When row is greater than allcount then remove all class='post' element after 3 element
                $('.post:nth-child('+rowperpage+')').nextAll('.post').remove();

                // Reset the value of row
                $("#row").val(0);

                // Change the text and background
                $('.load-more').text("Cargar más");
                //$('.load-more').css("background","#15a9ce");
                
            }, 1000);


        }

    });

});