$(document).ready(function(){

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
                    setTimeout(function() {
                        $(".grid-item:last").after(response).show().fadeIn("slow");
                        
                        var rowno = row + rowperpage;

                        if(rowno >= allcount){
                            $('.loadmoreproducts').html("<i class=\"ti-minus\"></i> Ocultar");
                        }else{
                            $(".loadmoreproducts").html("<i class=\"ti-plus\"></i> Más");
                        }
                    }, 1000);

                }
            });
        }else{
            $('.loadmoreproducts').text("Ocultando...");

            setTimeout(function() {
                $('.grid-item:nth-child('+rowperpage+')').nextAll('.grid-item').remove();
                $("#row").val(0);
                $('.loadmoreproducts').html("<i class=\"ti-plus\"></i> Más");
            }, 1000);

        }

    });

});