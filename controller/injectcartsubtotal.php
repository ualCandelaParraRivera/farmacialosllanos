<?php
include_once("config.php");
include_once("expire.php");

$products = $db->getCart($lang);
$quantity = 0;
$subtotal = 0;
foreach($products as $product){
    $quantity += $product->count;
    $subtotal += $product->total;
}
if($quantity>0){
    echo '<div class="sub-total">
        <strong>Subtotal :</strong>
        <span class="amount">'.$subtotal.'€</span>
    </div>
    <div class="buttons">
        <a href="cart" class="btn btn-dark btn-hover-primary">view cart</a>
        <a href="checkout" class="btn btn-outline-dark">checkout</a>
    </div>';
}else{
    echo '<div class="buttons">
    <a href="shop" class="btn btn-dark btn-hover-primary offcanvas-close">Continuar Comprando</a>
    </div>';
}
?>