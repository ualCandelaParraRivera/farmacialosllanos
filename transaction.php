<?php include("./controller/phpmailer/PHPMailerAutoload.php");
include("./controller/pdfsender.php");

if (isset($_SESSION['orderdata']['orderid'])){
    $orderid = $_SESSION['orderdata']['orderid'];
    $query= "SELECT idinvoice FROM invoice
    WHERE orderid = ?";

    $res=$db->prepare($query, array($orderid));
    if($db->numRows($res) != 0){
        header("location: ".$location_404);
    } 

}else{
    header("location: ".$location_404);
}


?>
<!DOCTYPE html>
<?php 

$orderid = $_SESSION['orderdata']['orderid'];
$paymethod = $_SESSION['orderdata']['paymethod'];
// Tipo de pago para generar la factura
$type = '0';
$products = $db->getCart($lang);
$quantity = 0;
$subtotal = 0;
$taxes = 0;
$weight = 0;
foreach($products as $product){
    $quantity += $product->count;
    $subtotal += $product->total;
    $taxes += $product->totaltax;
    $weight += $product->count * $product->weight;
}


if(isset($_SESSION['promo'])){
    if(!empty($_SESSION['promo'])){
        $promos = $db->getPromo();
        foreach($promos as $promo){
            $promocode = $promo->promocode;
            $discount = $promo->discount;
            $min = $promo->min;
            $max = $promo->max;
            $guidpromo = $promo->guidpromo;
        }
    }else{
        $promocode = "";
        $discount = 0;
        $min = -9999999;
        $max = 9999999;
        $guidpromo = "";
    }
}else{
    $promocode = "";
    $discount = 0;
    $min = -9999999;
    $max = 9999999;
    $guidpromo = "";
}
 
if($lang != "en"){
    $locale = "es_ES";
}else{
    $locale = "en_US";
}  
?>

<html class="no-js" lang="<?=$lang?>"> 
<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=ASluQE8pQPTJA9GtfFMg3I3EdXssslkTsEhC7WP86lX7ifgcEg-OYKyh9aLtmoZJ68gfJw2k1GpuFS1K&disable-funding=card,sofort&currency=EUR&locale=<?=$locale?>"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|payment", $trans);?>

    <?php
    $query = "SELECT pt.title
    ,oi.price
    ,oi.quantity
    ,ROUND(oi.price * oi.quantity,2) as subtotal
    ,ltrim(replace(substring(substring_index(pi.image, '.', 1), length(substring_index(pi.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
    ,ltrim(replace(substring(substring_index(pi.image, '.', 2), length(substring_index(pi.image, '.', 2 - 1)) + 1), '.', '')) AS extension     
    FROM hempleaf.order_item oi
    LEFT JOIN product p ON oi.productId = p.id
    LEFT JOIN product_translation pt ON p.id = pt.productId
    LEFT JOIN (SELECT pi.productId, pi.image FROM product_image pi WHERE pi.isdeleted = 0 GROUP BY productId) pi ON p.id = pi.productId
    WHERE oi.orderId = ?  AND pt.lang = ? "; 


        $res=$db->prepare($query, array($orderid, $lang));
        if($db->numRows($res) == 0){
             header("location: ".$location_404);
        }        
    ?>
       
    
    <?php

    $query = "SELECT guidorder    
    FROM hempleaf.order
    WHERE id = ?";

        $res=$db->prepare($query, array($orderid));
        if($db->numRows($res) == 0){
             header("location: ".$location_404);
    }  
        while($row = mysqli_fetch_array($res)){
        $guidorder = $row['guidorder'];
            
    }
    ?> 

    <!-- Shopping Cart Section Start -->
    <div class="section section-padding pb-0">
        <div class="container">
        <?php

        if($quantity > 0){

        ?>
            <form class="cart-form" action="#">
            <input id="guidorder" name="guidorder" type="hidden" value="<?=$guidorder?>">
            <table class="cart-wishlist-table table">
                    <thead>
                        <tr>
                            <th class="name" colspan="2"><?=$trans['cart_tableproduct']?></th>
                            <th class="price"><?=$trans['cart_tableprice']?></th>
                            <th class="quantity"><?=$trans['cart_tablequantity']?></th>
                            <th class="subtotal"><?=$trans['cart_tabletotal']?></th>
                            <th class="remove">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($products as $product){
                            $guidproduct = $product->guidproduct;
                            $title = $product->title;
                            $imagename = $product->imagename;
                            $extension = $product->extension;
                            $price = $product->finalprice;
                            $quantityitem = $product->count;
                    ?>
                        <tr>
                            <td class="thumbnail"><a href="productdetails?guidproduct=<?=$guidproduct?>"><img src="img/product/<?=$imagename?>-cart.<?=$extension?>"></a></td>
                            <td class="name"> <a href="productdetails?guidproduct=<?=$guidproduct?>"><?=$title?></a></td>
                            <td class="price"><span><?=$price?>€</span></td>

                            <!-- Hay que centrar este quantity en la tabla pero no se como :( ) -->
                            <td class="quantity"><span><?=$quantityitem?></span></td>
                            <td class="subtotal"><span><?php echo ($price*$quantityitem);?>€</span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
                            
            <div class="cart-totals mt-5" id="payment-box">
                <h2 class="title"><?=$trans['cart_carttitle']?></h2>
                <table>
                    <tbody>
                        <?php
                            $descuento = 0;
                            $shipping = 0;

                            $query = "SELECT 
                            CONCAT('OR',LPAD(id,5,'0')) as id
                            ,o.subTotal
                            ,o.tax
                            ,o.shipping
                            ,ROUND(o.grandTotal,2) as grandTotal
                            FROM hempleaf.order o
                            WHERE id = ?";
                            
                            $res=$db->prepare($query, array($orderid));
                            if($db->numRows($res) == 0){
                                 header("location: ".$location_404);
                            }    

                            while($row = mysqli_fetch_array($res)){
                                $id = $row['id'];
                                $subTotal = $row['subTotal'];
                                $tax = $row['tax'];
                                $shipping = $row['shipping'];
                                $grandTotal = $row['grandTotal'];

                             ?>
                           
                            <tr class="subtotal">
                                <th><?=$trans['cart_cartsubtotal']?></th>
                                <td><span class="amount"><?=number_format($subTotal, 2, ',', '.')?>€</span></td>          
                            </tr>
                            <?php }

                        ?>

                        <tr class="tax">
                            <th><?=$trans['cart_carttax']?></th>
                            <td><strong><span class="amount"><?=number_format($tax, 2, ',', '.')?>€</span></strong></td>
                        </tr>

                        <tr class="tax">
                            <th><?=$trans['cart_cartshipping']?></th>
                            <td><strong><span class="amount"><?=number_format($shipping, 2, ',', '.')?>€</span></strong></td>
                        </tr>

                        <tr class="total">
                            <th><?=$trans['cart_carttotal']?></th>
                            <td><strong><span class="amount"><?=number_format($grandTotal, 2, ',', '.')?>€</span></strong></td>
                        </tr>
                    </tbody>
                </table>

                <?php
                if($paymethod == "c"){ ;?>     

                <div id="paypal-button-container"></div>
                <?php } ?>
                
                <!-- <a href="checkout" class="btn btn-dark btn-outline-hover-dark"><?=$trans['cart_cartcheckout']?></a> -->
            </div>
                <?php
                if($paymethod == "w"){ ;?>                                  
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-11">
                        <div class="user-payment-method bg-light mt-5">
                                <h2 class="title"><?=$trans['wiretransfer_title']?></h2>
                                <p class="text"><br><?=$trans['wiretransfer_info']?></br>
                                    <br><?=$trans['wiretransfer_bank']?></br>
                                    <br><?=$trans['wiretransfer_account']?></br>
                                    <br><?=$trans['wiretransfer_concept']?>: <?=$id?></br>
                                    <br><?=$trans['wiretransfer_beneficiary']?></br>
                                    <br><?=$trans['wiretransfer_amount']?>: <?=$grandTotal?>€</br></p>
                                <a class="btn btn-dark btn-outline-hover-dark" type="submit" form="checkoutForm" href="index"><?=$trans['modal_confirm']?></a>
                        </div>
                    </div>
                </div>
            </div>
                <?php 

                $query = "SELECT email, billfirstname FROM `order` WHERE id = ?";       
                
                $res=$db->prepare($query, array($orderid));
                if($db->numRows($res) == 0){
            }  
            while($row = mysqli_fetch_array($res)){
            $email = $row['email'];
            $billfirstname = $row['billfirstname'];
            
            }
            sendAttatchment($db, $orderid, $type, $trans, $lang);

            $_SESSION['orderdata'] = NULL;
            $db->emptyCart("","");
                }
                ?>
            </div>
                <div class="col-lg-6 order-lg-1 learts-mb-30">
                </div>
            </div>
            <?php } else { ?>
                <h1>Tu carrito está vacío :(</h1>
                <div class="col-auto mt-5">
                    <a class="btn btn-light btn-hover-dark mr-3 mb-3" href="shop"><?=$trans['cart_continue']?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Shopping Cart Section End -->
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs(); ?>
    <!-- Add the checkout buttons, set up the order and approve the order -->
    <script>
      paypal.Buttons({
        style : {
        color: 'blue',
        shape: 'pill'
    
    },
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: <?= number_format($grandTotal, 2, '.', '.') ?>
              }
            }]
          });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                guidorder = $("#guidorder").val();
            // alert('Transaction completed by ' + details.payer.name.given_name);
                $.ajax({
                    type: 'POST',
                    url: 'controller/invoicepaypal',
                    data: {
                        'ppidtransaction' : details.id
                        ,'ppname': details.payer.name.given_name
                        ,'ppsurname' : details.payer.name.surname
                        ,'ppemail' : details.payer.email_adress
                        ,'ppcountry' : details.payer.address.country_code
                        ,'ppidpayer' : details.payer.payer_id
                        ,'ppprice' : details.purchase_units[0].amount.value
                        ,'ppidmerchant' : details.purchase_units[0].payee.merchant_id
                        ,'ppaddress' : details.purchase_units[0].shipping.address.address_line_1
                        ,'ppprovince' : details.purchase_units[0].shipping.address.admin_area_1
                        ,'ppregion' : details.purchase_units[0].shipping.address.admin_area_2
                        ,'pppostalcode' : details.purchase_units[0].shipping.address.postal_code
                        ,'ppstatus' : details.session_status
                        ,'ppcreatetime' : details.create_time
                        ,'ppupdate_time' : details.update_time
                        ,'ppguidorder' : guidorder
                    },
                    success: function(html) {
                        var x = JSON.parse(html);
                        
                        $('.help-block').remove(); // elimina el texto de error
                        $('.alert').remove(); // elimina el texto de alerta
                        $('#paypal-button-container').remove();
                        $('#payment-box').append('<div class="col-12 learts-mb-20 mt-3 alert alert-success">'+x.html+'</div>');
                        // $('#payment-box').append('<div class="btn btn-dark btn-outline-hover-dark" type="submit" form="checkoutForm" href="index">'.$trans['modal_confirm'].'</div>');


                    },

                });
            });
        },
        onCancel: function(data, actions){
            $('.help-block').remove(); // elimina el texto de error
            $('.alert').remove(); // elimina el texto de alerta
            $('#payment-box').append('<div class="col-12 learts-mb-20 mt-3 alert alert-danger">La operación ha sido cancelada.</div>');
            
        },

    }).render('#paypal-button-container'); // Display payment options on your web page
</script>

</body>

