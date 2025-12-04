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
if($quantity > 0){
    echo '<ul class="minicart-product-list">';
    foreach($products as $product){
    $guidproduct = $product->guidproduct;
    $title = $product->title;
    $imagename = $product->imagename;
    $extension = $product->extension;
    $price = $product->price;
    $quantityitem = $product->count;
    echo '<li>
        <a href="productdetails?guidproduct='.$guidproduct.'" class="image"><img src="img/product/'.$imagename.'-cart.'.$extension.'" alt="Cart product Image"></a>
        <div class="content">
            <a href="productdetails?guidproduct='.$guidproduct.'" class="title">'.$title.'</a>
            <span class="quantity-price">'.$quantityitem.' x <span class="amount">'.$price.'€</span></span>
            <a class="remove removeFromCart" data-id="'.$guidproduct.'">×</a>
        </div>
    </li>';
    }
    echo '</ul>
     ';
}else{
    echo 'No hay productos en tu carrito';
}
?>