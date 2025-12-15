$(document).ready(function(){

    // Load more data
    $('.loadmoreproducts').click(function(){
        var row = Number($('#row').val());
        var allcount = Number($('#all').val());
        var rowperpage = Number($('#productsperpage').val());
        row = row + rowperpage;

        if(row < allcount){
            $("#row").val(row);

            $.ajax({
                url: 'controller/loadmoreproducts',
                type: 'post',
                data: {row:row},
                beforeSend:function(){
                    $(".loadmoreproducts").text("Cargando...");
                },
                success: function(response){

                    // Setting little delay while displaying new content
                    setTimeout(function() {
                        // appending posts after last product with class="grid-item"
                         $(".grid-item:last").after(response).show().fadeIn("slow");
                        
                        var rowno = row + rowperpage;

                        // checking row value is greater than allcount or not
                        if(rowno >= allcount){

                            // Change the text and background
                            $('.loadmoreproducts').html("<i class=\"ti-minus\"></i> Ocultar");
                        }else{
                            $(".loadmoreproducts").html("<i class=\"ti-plus\"></i> Más");
                        }
                    }, 1000);

                }
            });
        }else{
            $('.loadmoreproducts').text("Ocultando...");

            // Setting little delay while removing contents
            setTimeout(function() {

                // When row is greater than allcount then remove all class='grid-item' element after X element
                $('.grid-item:nth-child('+rowperpage+')').nextAll('.grid-item').remove();

                // Reset the value of row
                $("#row").val(0);

                // Change the text and background
                $('.loadmoreproducts').html("<i class=\"ti-plus\"></i> Más");
                //$('.load-more').css("background","#15a9ce");
                
            }, 1000);


        }

    });

});