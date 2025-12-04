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
echo ($quantity>0 ? '<span class="cart-count">'.$quantity.'</span>' : '').'<i class="fal fa-shopping-cart"></i>';
?>