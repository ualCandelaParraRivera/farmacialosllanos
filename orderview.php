<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    if(!isset($_GET['guidorder'])){
        redirect($location_404);
    }
    $guidorder = $_GET['guidorder'];
    $query = "SELECT u.id FROM `user` u
    INNER JOIN `order` o ON u.id = o.userid
    WHERE guidorder = ? AND u.id = ?";
    $res = $db->prepare($query, array($guidorder,$_SESSION['usercode']));
    if($db->numRows($res)==0){
        redirect($location_404);
    }

    $query = "SELECT subtotal
    , tax
    , shipping
    , o.discount
    , total
    , grandtotal
    , promocode
    , pr.content as promodescription
    , billfirstname
    , billmiddlename
    , CASE WHEN billlastname IS NULL THEN '' ELSE billlastname END as billlastname
    , billmobile
    , billline1
    , CASE WHEN billpostalcode IS NULL THEN '' ELSE billpostalcode END as billpostalcode
    , billcity
    , billprovince
    , billcountry
    , shipfirstname
    , shipmiddlename
    , CASE WHEN shiplastname IS NULL THEN '' ELSE shiplastname END as shiplastname
    , shipmobile
    , shipline
    , CASE WHEN shippostalcode IS NULL THEN '' ELSE shippostalcode END as shippostalcode
    , shipcity
    , shipprovince
    , shipcountry
    , createdAt
    , updatedAt
    , o.content as ordernotes 
    FROM `order` o
    LEFT JOIN promo pr ON o.promoId = pr.id
    WHERE guidorder = ?";
    $res = $db->prepare($query, array($guidorder));
    if($db->numRows($res)==0){
        redirect($location_404);
    }
    $row = mysqli_fetch_array($res);
    $subtotal = $row['subtotal'];
    $tax = $row['tax'];
    $discount = $row['discount'];
    $shipping = $row['shipping'];
    $total = $row['total'];
    $grandtotal = $row['grandtotal'];
    $promocode = $row['promocode'];
    $promodescription = $row['promodescription'];
    $billfirstname = $row['billfirstname'];
    $billmiddlename = $row['billmiddlename'];
    $billlastname = $row['billlastname'];
    $billmobile = $row['billmobile'];
    $billline1 = $row['billline1'];
    $billpostalcode = $row['billpostalcode'];
    $billcity = $row['billcity'];
    $billprovince = $row['billprovince'];
    $billcountry = $row['billcountry'];
    $shipfirstname = $row['shipfirstname'];
    $shipmiddlename = $row['shipmiddlename'];
    $shiplastname = $row['shiplastname'];
    $shipmobile = $row['shipmobile'];
    $shipline = $row['shipline'];
    $shippostalcode = $row['shippostalcode'];
    $shipcity = $row['shipcity'];
    $shipprovince = $row['shipprovince'];
    $shipcountry = $row['shipcountry'];
    $createdAt = $row['createdAt'];
    $updatedAt = $row['updatedAt'];
    $ordernotes = $row['ordernotes'];
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|myaccount|orderview", $trans);?>

    <!-- Shopping Cart Section Start -->
    <div class="section section-padding pb-0">
        <div class="container">
            <form class="cart-form" action="#">
                <table class="cart-wishlist-table table">
                    <thead>
                        <tr>
                            <th class="name" colspan="2"><?=$trans['orderview_tableproduct']?></th>
                            <th class="price"><?=$trans['orderview_tableprice']?></th>
                            <th class="quantity"><?=$trans['orderview_tablequantity']?></th>
                            <th class="subtotal"><?=$trans['orderview_tabletotal']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $query = "SELECT p.guidproduct
                            ,pt.title
                            ,ROUND(oi.price-oi.price*oi.discount/100, 2) as price
                            ,oi.quantity
                            ,ROUND(oi.price-oi.price*oi.discount/100, 2)*oi.quantity as total
                            ,ltrim(replace(substring(substring_index(pi.image, '.', 1), length(substring_index(pi.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                            ,ltrim(replace(substring(substring_index(pi.image, '.', 2), length(substring_index(pi.image, '.', 2 - 1)) + 1), '.', '')) AS extension  
                            FROM `order` o
                            LEFT JOIN `order_item` oi ON o.id = oi.orderid
                            LEFT JOIN product p on oi.productid = p.id
                            LEFT JOIN product_translation pt ON p.id = pt.productId
                            LEFT JOIN (SELECT pi.productId, pi.image FROM product_image pi WHERE pi.isdeleted = 0 GROUP BY productId) pi ON p.id = pi.productId
                            WHERE pt.lang = '$lang' AND guidorder = ?";
                            $res = $db->prepare($query, array($guidorder));
                            while($row = mysqli_fetch_array($res)){
                        ?>
                        <tr>
                            <td class="thumbnail"><a href="productdetails?guidproduct=<?=$row['guidproduct']?>"><img src="img/product/<?=$row['imagename']?>.<?=$row['extension']?>"></a></td>
                            <td class="name"> <a href="productdetails"><?=$row['title']?></a></td>
                            <td class="price"><span><?=number_format($row['price'], 2, ',', '.')?>€</span></td>
                            <td class="quantityView"><span><?=$row['quantity']?></span></td>
                            <td class="subtotal"><span><?=number_format($row['total'], 2, ',', '.')?>€</span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="row justify-content-between mb-n3">
                    <div class="col-6 mb-3">
                        <div class="cart-coupon">
                            <input type="text" value="<?=$promocode?>" readonly>
                            <p><i class="fal fa-gift"></i>  <?=$promodescription?></p>
                        </div>
                        <div class="myaccount-content address learts-mt-40">        
                            <div class="row learts-mb-n30">
                                <div class="col-md-6 col-12 learts-mb-30">
                                    <h4 class="title"><?=$trans['orderview_billingaddress']?></h4>
                                    <address>
                                        <p><strong><?=$billfirstname?> <?=$billmiddlename?></strong></p>
                                        <p><?=$billline1?><br>
                                            <?=$billcity?><?php if(!empty($billpostalcode)){ echo ", ".$billpostalcode;}?>, <?=$billprovince?>, <?=$billcountry?></p>
                                        <p><?=$trans['orderview_billingphone']?>: <?=$billmobile?></p>
                                    </address>
                                </div>
                                <div class="col-md-6 col-12 learts-mb-30">
                                    <h4 class="title"><?=$trans['orderview_shippingaddress']?></h4>
                                    <address>
                                        <p><strong><?=$shipfirstname?> <?=$shipmiddlename?></strong></p>
                                        <p><?=$shipline?><br>
                                        <?=$shipcity?><?php if(!empty($shippostalcode)){ echo ", ".$shippostalcode;}?>, <?=$shipprovince?>, <?=$shipcountry?></p>
                                        <p><?=$trans['orderview_shippingphone']?>: <?=$shipmobile?></p>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="cart-totals">
                            <h2 class="title"><?=$trans['orderview_carttitle']?></h2>
                            <table>
                                <tbody>
                                    <tr class="subtotal">
                                        <th><?=$trans['orderview_cartsubtotal']?></th>
                                        <td><span class="amount"><?=number_format($subtotal, 2, ',', '.')?>€</span></td>
                                    </tr>
                                    <tr class="subtotal">
                                        <th><?=$trans['orderview_carttax']?></th>
                                        <td><span><?=number_format($tax, 2, ',', '.')?>€</span></td>
                                    </tr>
                                    <?php
                                        if($discount > 0){ ?>
                                    <tr class="subtotal">
                                        <th><?=$trans['orderview_cartpromo']?></th>
                                        <td><span><?=number_format(-$discount, 2, ',', '.')?>€</span></td>
                                    </tr>
                                    <?php } ?>
                                    
                                    <tr class="subtotal">
                                        <th><?=$trans['orderview_cartshipping']?></th>
                                        <td><span><?=number_format($shipping, 2, ',', '.')?>€</span></td>
                                    </tr>
                                    <tr class="total">
                                        <th><?=$trans['orderview_carttotal']?></th>
                                        <td><strong><span class="amount"><?=number_format($grandtotal, 2, ',', '.')?>€</span></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>

    </div>
    <!-- Shopping Cart Section End -->

    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>