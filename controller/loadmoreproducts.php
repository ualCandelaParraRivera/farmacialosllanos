<?php
include_once("main.php");
$row = $_POST['row'];
$rowsperpage = $productsperpage;

$query = "SELECT pt.title
,ltrim(replace(substring(substring_index(pi.image, '.', 1), length(substring_index(pi.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
,ltrim(replace(substring(substring_index(pi.image, '.', 2), length(substring_index(pi.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
,ROUND(price,2) as price
,discount
,CONCAT(ROUND(discount*100),'%') as discountlabel
,ROUND((1-discount)*price,2) as finalprice
,hot as ishot
,CASE WHEN discount > 0 THEN 1 ELSE 0 END as isdiscount
,CASE WHEN quantity = 0 THEN 1 ELSE 0 END as isoutofstock
,CASE WHEN tp.id IS NULL THEN 0 ELSE 1 END as isnew
,guidproduct
,GROUP_CONCAT(pm.content ORDER BY pm.key SEPARATOR ';') as color
,GROUP_CONCAT(pm2.content ORDER BY pm2.key SEPARATOR ';') as size
FROM product p
LEFT JOIN (SELECT DISTINCT productId, image FROM product_image WHERE isdeleted = 0 GROUP BY productId ORDER BY image) pi ON p.id = pi.productId
LEFT JOIN product_translation pt ON p.id = pt.productId
LEFT JOIN product_has_meta phm ON p.id = phm.productId
LEFT JOIN product_meta pm ON phm.metaId = pm.id AND pm.key = 'color' AND pm.isdeleted = 0
LEFT JOIN product_meta pm2 ON phm.metaId = pm2.id AND pm2.key <> 'color' AND pm2.key <> 'video' AND pm2.isdeleted = 0
LEFT JOIN (SELECT id FROM product
ORDER BY publishedAt DESC
LIMIT $topnewproducts) tp ON p.id = tp.id
WHERE lang = '$lang' AND p.isdeleted = 0
GROUP BY p.id
LIMIT $row,$rowsperpage";
$res=$db->query($query);



$html = '';
while($row = mysqli_fetch_array($res)){
    $imagename = $row['imagename'];
    $extension = $row['extension'];
    $title = $row['title'];
    $price = $row['price'];
    $discountlabel = $row['discountlabel'];
    $discount = $row['discount'];
    $finalprice = $row['finalprice'];
    $guidproduct = $row['guidproduct'];
    $isdiscount = $row['isdiscount'];
    $ishot = $row['ishot'];
    $isoutofstock = $row['isoutofstock'];
    $isnew = $row['isnew'];
    $color = $row['color'];
    $size = $row['size'];
    $label = ($isdiscount==1?" sales":"").($ishot==1?" featured":"").($isnew==1?" new":"");

    $html.='<div class="grid-item col '.$label.'">
                                <div class="product">
                                    <div class="product-thumb">
                                        <a href="productdetails?guidproduct='.$guidproduct.'" class="image">
                                        ';
                                        if($isdiscount+$ishot+$isoutofstock > 0){
                                            $html.='<span class="product-badges">
                                            ';
                                                if($isdiscount > 0){ $html.='<span class="onsale">-'.$discountlabel.'</span>'; }
                                                if($ishot > 0){ $html.='<span class="hot">☆</span>'; }
                                                if($isoutofstock > 0){ $html.='<span class="outofstock"><i class="fal fa-frown"></i></span>'; }
                                            $html.='</span>
                                            ';
                                        }
                                            $html.='<img src="img/product/'.$imagename.'-328.'.$extension.'" alt="Product Image">
                                            <img class="image-hover " src="img/product/'.$imagename.'-328hover.'.$extension.'" alt="Product Image">
                                        </a>
                                        ';
                                        if($color || $size) {
                                        $html.='<div class="product-options">
                                        ';
                                            if($color) {
                                            $html.='<ul class="colors">
                                            ';
                                                $colorsarray = explode(";",$color);
                                                foreach ($colorsarray as $c){
                                                $html.='<li style="background-color: '.$c.';">'.$c.'</li>
                                                ';
                                                }
                                            $html.='</ul>
                                            ';
                                            }
                                            if($size) {
                                            $html.='<ul class="sizes">
                                            ';
                                                $sizessarray = explode(";",$size);
                                                foreach ($sizessarray as $s){
                                                $html.='<li>'.$s.'</li>
                                                ';
                                                }
                                            $html.='</ul>
                                            ';
                                            }
                                        $html.='</div>
                                        ';
                                        }
                                    $html.='</div>
                                    <div class="product-info">
                                        <h6 class="title"><a href="productdetails">'.$title.'</a></h6>
                                        <span class="price">
                                        ';
                                         if($discount > 0){
                                            $html.='<span class="old">'.$price.'€</span>
                                            <span class="new">'.$finalprice.'€</span>
                                            ';
                                        } else {
                                            $html.=$price.'€
                                            ';
                                        }
                                        $html.='</span>
                                        <div class="product-buttons">
                                            <a href="#quickViewModal" data-id="'.$guidproduct.'" id="'.$guidproduct.'" data-toggle="modal" class="product-button hintT-top" data-hint="'.$trans['products_quickview'].'"><i class="fal fa-search"></i></a>
                                            <a class="product-button hintT-top addToCart" data-hint="'.$trans['products_addtocart'].'"  data-id="'.$guidproduct.'"><i class="fal fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
}
echo $html;
?>