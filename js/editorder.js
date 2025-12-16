$(document).ready(function() {

    $('form#datospedido').submit(function(event) {

        event.preventDefault();
        $('.form-group').removeClass('is-invalid');
        $('.form-control').removeClass('is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.help-block').remove();
        $('.alert').remove();

        var fd = new FormData($(this)[0]);

        var table = $("#example");
        var trs = document.querySelectorAll('#tablebody tr');
        var datas = [];
        for (i = 0; i < trs.length; i++) {
            cells = trs[i].cells;
            if(cells.length > 6){
                datas.push([cells[0].innerText, cells[5].innerText]);
            }
        }

        fd.append("table", datas);
        
        $.ajax({
            type 		: 'POST',
            url 		: './controller/editorder',
            data 		: fd,
            dataType 	: 'json',
            processData: false,
            contentType: false,
            encode 		: true
        })
            .done(function(data) {
                console.log('Respuesta completa:', data);
                
                if (!data.success) {
                    if (data.errors) {
                       
                        if (data.errors.email) {
                            $('#email').addClass('is-invalid');
                            $('#email-group').append('<div class="help-block">' + data.errors.email + '</div>');
                        }
                        if (data.errors.table) {
                            $('#table').addClass('is-invalid');
                            $('#table-group').append('<div class="help-block" style="color:#dc3545" style="color:#dc3545">' + data.errors.table + '</div>');
                        }
                        if (data.errors.billfirstname) {
                            $('#billfirstname').addClass('is-invalid');
                            $('#billfirstname-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.billfirstname + '</div>');
                        }
                        if (data.errors.billmiddlename) {
                            $('#billmiddlename').addClass('is-invalid');
                            $('#billmiddlename-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.billmiddlename + '</div>');
                        }
                        if (data.errors.billmobile) {
                            $('#billmobile').addClass('is-invalid');
                            $('#billmobile-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.billmobile + '</div>');
                        }
                        if (data.errors.billcountry) {
                            $('#billcountry').addClass('is-invalid');
                            $('#billcountry-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.billcountry + '</div>');
                        }
                        if (data.errors.billdistrict) {
                            $('#billdistrict').addClass('is-invalid');
                            $('#billdistrict-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.billdistrict + '</div>');
                        }
                        if (data.errors.billcity) {
                            $('#billcity').addClass('is-invalid');
                            $('#billcity-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.billcity + '</div>');
                        }
                        if (data.errors.billaddress) {
                            $('#billaddress').addClass('is-invalid');
                            $('#billaddress-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.billaddress + '</div>');
                        }
                        if (data.errors.shipfirstname) {
                            $('#shipfirstname').addClass('is-invalid');
                            $('#shipfirstname-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipfirstname + '</div>');
                        }
                        if (data.errors.shipmiddlename) {
                            $('#shipmiddlename').addClass('is-invalid');
                            $('#shipmiddlename-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipmiddlename + '</div>');
                        }
                        if (data.errors.shipmobile) {
                            $('#shipmobile').addClass('is-invalid');
                            $('#shipmobile-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipmobile + '</div>');
                        }
                        if (data.errors.shipcountry) {
                            $('#shipcountry').addClass('is-invalid');
                            $('#shipcountry-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipcountry + '</div>');
                        }
                        if (data.errors.shipdistrict) {
                            $('#shipdistrict').addClass('is-invalid');
                            $('#shipdistrict-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipdistrict + '</div>');
                        }
                        if (data.errors.shipcity) {
                            $('#shipcity').addClass('is-invalid');
                            $('#shipcity-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipcity + '</div>');
                        }
                        if (data.errors.shipaddress) {
                            $('#shipaddress').addClass('is-invalid');
                            $('#shipaddress-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipaddress + '</div>');
                        }
                        if (data.errors.shipmentplan) {
                            $('#shipmentplan').addClass('is-invalid');
                            $('#shipmentplan-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.shipmentplan + '</div>');
                        }
                        if (data.errors.peso) {
                            $('#peso').addClass('is-invalid');
                            $('#peso-group').append('<div class="help-block" style="color:#dc3545">' + data.errors.peso + '</div>');
                        }
                        
                        if (data.message) {
                            $('#placeordergroup').append('<div class="mt-3 alert alert-danger">' + data.message + '</div>');
                        }
                    } else {
                        $('#placeordergroup').append('<div class="mt-3 alert alert-danger">Ocurrió un error. Por favor, intenta nuevamente.</div>');
                    }
                } else {
                    console.log("Pedido guardado correctamente");
                    window.location.replace("adminorders");
                }
            })
            .fail(function(xhr, status, error) {
                console.error('Error AJAX:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
                
                try {
                    var response = JSON.parse(xhr.responseText);
                    console.error('Response JSON:', response);
                } catch(e) {
                    console.error('La respuesta no es JSON válido');
                }
                
                $('#placeordergroup').html('<div class="mt-3 alert alert-danger">Error al procesar la solicitud. Revisa la consola para más detalles.</div>');
            });
            
    });

});