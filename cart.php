<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 

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

?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|cart", $trans);?>

    <div class="section section-padding pb-0">
        <div class="container">
        <?php
        if($quantity > 0){
        ?>
            <form class="cart-form" action="#">
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
                            <td class="quantity">
                                <div class="product-quantity">
                                    <span class="qty-btn minus" data-id="<?=$guidproduct?>"><i class="ti-minus"></i></span>
                                    <input type="text" class="input-qty" value="<?=$quantityitem?>">
                                    <span class="qty-btn plus" data-id="<?=$guidproduct?>"><i class="ti-plus"></i></span>
                                </div>
                            </td>
                            <td class="subtotal"><span><?php echo ($price*$quantityitem);?>€</span></td>
                            <td class="remove"><a class="btn removeFromCart" data-id="<?=$guidproduct?>">×</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="row justify-content-between mb-n3">
                    <div class="col-auto mb-3">
                        <div class="cart-coupon">
                            <input type="text" placeholder="<?=$trans['cart_code']?>" id="input-promo" value="<?=$promocode?>">
                            <button class="btn" id="submitpromocode"><i class="fal fa-gift"></i></button>
                        </div>
                        <?php
                            if(!empty($promocode)){
                                echo '<div class="help-block">'.$trans['cart_code1'].' '.$promocode.' '.$trans['cart_code2'].'</div>';
                            }
                        ?>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-light btn-hover-dark mr-3 mb-3" href="shop"><?=$trans['cart_continue']?></a>
                    </div>
                </div>
            </form>
            <div class="cart-totals mt-5">
                <h2 class="title"><?=$trans['cart_carttitle']?></h2>
                <table>
                    <tbody>
                        <tr class="subtotal">
                            <th><?=$trans['cart_cartsubtotal']?></th>
                            <td><span class="amount"><?=number_format($subtotal, 2, ',', '.')?>€</span></td>
                        </tr>
                        <tr class="subtotal">
                            <th><?=$trans['cart_carttax']?></th>
                            <td><strong><span class="amount"><?=number_format($taxes, 2, ',', '.')?>€</span></strong></td>
                        </tr>
                        <?php
                            $descuento = 0;
                            $shipping = 0;
                            $query = "SELECT shipping
                            FROM envio
                            WHERE type = 'eco' AND $weight BETWEEN minweight AND maxweight";
                            $res=$db->query($query);
                            $row = mysqli_fetch_array($res);

                            if(!empty($promocode)){
                                
                                if($subtotal+$taxes >= $min){
                                    $descuento = ($subtotal+$taxes)*$discount;
                                    if($descuento > $max){
                                        $descuento = $max;
                                    }
                                }
                            }
                            $grandtotal = $subtotal + $taxes - $descuento;
                            if($descuento > 0){ ?>
                            <tr class="subtotal">
                            <th><?=$trans['cart_cartpromo']?></th>
                            <td><strong><span class="amount"><?=number_format(-$descuento, 2, ',', '.')?>€</span></strong></td>
                        </tr>
                            <?php }
                        ?>
                        
                        <tr class="subtotal">
                            <th><?=$trans['cart_cartshipping']?></th>
                            <td><span>-€</span></td>
                        </tr>
                        <tr class="total">
                            <th><?=$trans['cart_carttotal']?></th>
                            <td><strong><span class="amount"><?=number_format($grandtotal, 2, ',', '.')?>€</span></strong></td>
                        </tr>
                    </tbody>
                </table>
                <a href="checkout" class="btn btn-dark btn-outline-hover-dark"><?=$trans['cart_cartcheckout']?></a>
            </div>
            <?php } else { ?>
                <h1>Tu carrito está vacío :(</h1>
                <div class="col-auto mt-5">
                    <a class="btn btn-light btn-hover-dark mr-3 mb-3" href="shop"><?=$trans['cart_continue']?></a>
                </div>
            <?php } ?>
        </div>

    </div>
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>