$(document).ready(function() {
    // Manejar botones de cantidad en detalle de producto
    $('.pluss, .minuss').on('click', function() {
        var $button = $(this);
        var $input = $button.parent().find('.input-qty');
        var oldValue = parseFloat($input.val());
        var maxStock = parseInt($input.attr('data-max'));
        
        if ($button.hasClass('pluss')) {
            var newVal = oldValue + 1;
            if (newVal > maxStock) {
                alert('No hay suficiente stock disponible. Stock máximo: ' + maxStock);
                newVal = maxStock;
            }
        } else {
            if (oldValue > 1) {
                var newVal = oldValue - 1;
            } else {
                newVal = 1;
            }
        }
        
        $input.val(newVal);
    });
    
    // Validar input manual
    $('.input-qty').on('change', function() {
        var $input = $(this);
        var value = parseInt($input.val());
        var maxStock = parseInt($input.attr('data-max'));
        var minStock = parseInt($input.attr('min')) || 1;
        
        if (isNaN(value) || value < minStock) {
            $input.val(minStock);
            alert('La cantidad mínima es ' + minStock);
        } else if (value > maxStock) {
            $input.val(maxStock);
            alert('No hay suficiente stock disponible. Stock máximo: ' + maxStock);
        }
    });
});