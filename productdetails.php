<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
if(!isset($_GET['guidproduct'])){
}
$guidproduct = $_GET['guidproduct'];
$query = "SELECT p.id as productid
,title
,price
,discount
,guidproduct
,ROUND((1-discount)*price,2) as finalprice
,ROUND(AVG(pr.rating)/5*100) as rate
,COUNT(pr.rating) as reviews
,quantity
,summary
,content as description
,u.firstname as brand
,u.image as brandimage
,u.profile
,sku
FROM product p 
LEFT JOIN product_translation pt ON p.id = pt.productId
LEFT JOIN product_review pr ON p.id = pr.productId
LEFT JOIN user u ON p.userid = u.id
WHERE guidproduct = ? AND lang = ?
GROUP BY p.id, title, guidproduct, price, discount, summary, content, firstname, image, sku, quantity, profile";
    $res=$db->prepare($query, array($guidproduct, $lang));
    if($db->numRows($res) == 0){
    }
    $row = mysqli_fetch_array($res);
    $productid = $row['productid'];
    $title = $row['title'];
    $price = $row['price'];
    $discount = $row['discount'];
    $finalprice = $row['finalprice'];
    $rate = $row['rate'];
    $reviews = $row['reviews'];
    $quantity = $row['quantity'];
    $summary = $row['summary'];
    $description = $row['description'];
    $brand = $row['brand'];
    $brandimage = $row['brandimage'];
    $profile = $row['profile'];
    $sku = $row['sku'];
    
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|shop|productdetails", $trans);?>

    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">

                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-images">
                        <?php 
                            $query = "SELECT CONCAT('[',GROUP_CONCAT(image SEPARATOR ', '),']') as images FROM (
                                SELECT CONCAT('{\"src\": \"img/product/',ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')),'-zoom.',ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')),'\", \"w\": 700, \"h\": 1100}') as image
                                FROM product p
                                LEFT JOIN product_image pi ON p.id = pi.productId
                                WHERE p.guidproduct = ? AND pi.isdeleted = 0
                                ) p";
                                $res=$db->prepare($query, array($guidproduct));
                                $row = mysqli_fetch_array($res);
                                $imagesenlarge = $row['images'];

                        ?>
                        <button class="product-gallery-popup hintT-left" data-hint="<?=$trans['productsdetails_imageenlarge']?>" data-images='<?=$imagesenlarge?>'><i class="far fa-expand"></i></button>
                        <?php 
                                    $query = "SELECT pm.key, pm.content 
                                    FROM product p
                                    LEFT JOIN product_has_meta phm ON p.id = phm.productId
                                    LEFT JOIN product_meta pm ON phm.metaid = pm.Id
                                    WHERE p.guidproduct = ? AND pm.isdeleted=0 AND pm.key = 'video'";
                                     $res=$db->prepare($query, array($guidproduct));
                                     if($db->numRows($res) > 0){
                                        $row = mysqli_fetch_array($res);
                                        echo '<a href="'.$row['content'].'" class="product-video-popup video-popup hintT-left" data-hint="'.$trans['productsdetails_imageenlarge'].'"><i class="fal fa-play"></i></a>';
                                     }
                                ?>
                        <div class="product-gallery-slider">
                            <?php
                                $query = "SELECT ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                FROM product p
                                LEFT JOIN product_image pi ON p.id = pi.productId
                                WHERE p.guidproduct = ? AND pi.isdeleted = 0";
                                $res=$db->prepare($query, array($guidproduct));
                                while($row = mysqli_fetch_array($res)){
                                    $imagename = $row['imagename'];
                                    $extension = $row['extension'];
                            ?>
                            <div class="product-zoom" data-image="img/product/<?=$imagename?>-zoom.<?=$extension?>">
                                <img src="img/product/<?=$imagename?>.<?=$extension?>" alt="">
                            </div>
                            <?php } ?>
                        </div>
                        <div class="product-thumb-slider">
                        <?php
                                $query = "SELECT ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                FROM product p
                                LEFT JOIN product_image pi ON p.id = pi.productId
                                WHERE p.guidproduct = ? AND pi.isdeleted = 0";
                                $res=$db->prepare($query, array($guidproduct));
                                while($row = mysqli_fetch_array($res)){
                                    $imagename = $row['imagename'];
                                    $extension = $row['extension'];
                            ?>
                            <div class="item">
                                <img src="img/product/<?=$imagename?>-thumb.<?=$extension?>" alt="">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-summery">
                        <div class="product-nav">
                            <a href="#"><i class="fal fa-long-arrow-left"></i></a>
                            <a href="#"><i class="fal fa-long-arrow-right"></i></a>
                        </div>
                        <?php if($reviews > 0){ ?>
                        <div class="product-ratings">
                            <span class="star-rating">
                                <span class="rating-active" style="width: <?=$rate?>%;">ratings</span>
                            </span>
                            <a href="#reviews" class="review-link">(<span class="count"><?=$reviews?></span> <?=$trans['productsdetails_reviews']?>)</a>
                        </div>
                        <?php } ?>
                        <h3 class="product-title"><?=$title?></h3>
                        <div class="product-price"><?php if($discount > 0){ echo '<span class="old">'.$price.'€</span> - <span class="new">'.$finalprice.'€</span>'; } else { echo $price.'€'; } ?></div>
                        <div class="product-description">
                            <p><?=$description?></p>
                        </div>
                        <div class="product-variations">
                            <table>
                                <tbody>
                                <?php 
                                    $query = "SELECT pm.key, CASE WHEN pm.key = 'color' THEN CONCAT('<div class=\"product-colors\">',GROUP_CONCAT(CONCAT('<a style=\"background-color: ',content,';\" data-bg-color=\"',content,'\"></a>') SEPARATOR ''),'</div>') ELSE CONCAT('<div class=\"product-sizes\">',GROUP_CONCAT(CONCAT('<a>',content,'</a>') SEPARATOR ''),'</div>') END as content
                                    FROM product p
                                    LEFT JOIN product_has_meta phm ON p.id = phm.productId
                                    LEFT JOIN product_meta pm ON phm.metaId = pm.Id
                                    WHERE p.guidproduct = ? AND pm.isdeleted=0 AND pm.key <> 'video'
                                    GROUP BY pm.key";
                                     $res=$db->prepare($query, array($guidproduct));
                                     while($row = mysqli_fetch_array($res)){
                                         $key = ucfirst($row['key']);
                                         $content = $row['content'];
                                ?>
                                    <tr>
                                        <td class="label"><span><?=$key?></span></td>
                                        <td class="value">
                                                <?=$content?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                    <tr>
                                        <td class="label"><span><?=$trans['productsdetails_quantity']?></span></td>
                                        <td class="value">
                                            <div class="product-quantity">
                                                <span class="qty-btn minuss" <?php if($quantity <= 0){ echo 'style="pointer-events: none; opacity: 0.5;"'; } ?>><i class="ti-minus"></i></span>
                                                <input type="text" class="input-qty" step="1" min="1" max="<?=$quantity?>" value="<?php echo $quantity > 0 ? '1' : '0'; ?>" pattern="[0-9]*" inputmode="numeric" <?php if($quantity <= 0){ echo 'disabled'; } ?>>
                                                <span class="qty-btn pluss" <?php if($quantity <= 0){ echo 'style="pointer-events: none; opacity: 0.5;"'; } ?>><i class="ti-plus"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="product-buttons">
                            <button class="btn btn-dark btn-outline-hover-dark" id="addToCartDetails" data-id="<?=$guidproduct?>" <?php if($quantity <= 0){ echo 'disabled style="pointer-events: none; opacity: 0.5; cursor: not-allowed;"'; } ?>><i class="fal fa-shopping-cart"></i> <?=$trans['productsdetails_addtocart']?></button>
                        </div>
                        <div class="product-brands">
                            <span class="title"><?=$trans['productsdetails_brands']?></span>
                            <div class="brands">
                                    <?php
                                $query = "SELECT guiduser as guidbrand
                                ,ltrim(replace(substring(substring_index(u.image, '.', 1), length(substring_index(u.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                ,ltrim(replace(substring(substring_index(u.image, '.', 2), length(substring_index(u.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                FROM product p
                                LEFT JOIN user u ON p.userId = u.id
                                WHERE u.isdeleted = 0 AND u.vendor = 1 AND guidproduct = ?";
                                $res=$db->prepare($query, array($guidproduct));
                                while($row = mysqli_fetch_array($res)){
                                ?>
                                <a href="shop?guidbrand=<?=$row['guidbrand']?>"><img src="img/brands/<?=$row['imagename']?>.<?=$row['extension']?>" alt="<?=$brand?>"></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="product-meta">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="label"><span><?=$trans['productsdetails_sku']?></span></td>
                                        <td class="value"><?=$sku?></td>
                                    </tr>
                                    <tr>
                                        <td class="label"><span><?=$trans['productsdetails_category']?></span></td>
                                        <td class="value">
                                            <ul class="product-category">
                                                <?php 
                                                $query = "SELECT ct.title as category, c.slug FROM product p
                                                LEFT JOIN product_category pc ON p.id = pc.productId
                                                LEFT JOIN category c ON pc.categoryId = c.id
                                                LEFT JOIN category_translation ct ON c.id = ct.categoryId
                                                WHERE p.guidproduct = ? AND lang = ?";
                                                $res=$db->prepare($query, array($guidproduct, $lang));
                                                while($row = mysqli_fetch_array($res)){
                                                $category = $row['category'];
                                                $slug = $row['slug'];
                                                ?>
                                                <li><a href="shop?category=<?=$slug?>"><?=$category?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label"><span><?=$trans['productsdetails_tags']?></span></td>
                                        <td class="value">
                                            <ul class="product-tags">
                                            <?php 
                                                $query = "SELECT t.title as tag, t.slug FROM product p
                                                LEFT JOIN product_tag pt ON p.id = pt.productId
                                                LEFT JOIN tag t ON pt.tagId = t.id
                                                WHERE p.guidproduct = ?";
                                                $res=$db->prepare($query, array($guidproduct));
                                                while($row = mysqli_fetch_array($res)){
                                                $tag = $row['tag'];
                                                $slug = $row['slug'];
                                                ?>
                                                <li><a href="shop?tag=<?=$slug?>"><?=$tag?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label"><span><?=$trans['productsdetails_share']?></span></td>
                                        <td class="va">
                                            <div class="product-share">
                                                <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 'facebook-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-facebook-f"></i></a>
                                                <a href="#" onclick="window.open('http://twitter.com/intent/tweet/?url='+encodeURIComponent(location.href), 'twitter-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-twitter"></i></a>
                                                <a href="#" onclick="window.open('http://pinterest.com/pin/create/button/?url='+encodeURIComponent(location.href), 'pinterest-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-pinterest"></i></a>
                                                <a href="mailto:?subject=Mira este producto&amp;body=Puede que te resulte interesante%0D <?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>%0D"><i class="fal fa-envelope"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>

    <div class="section section-padding border-bottom">
        <div class="container">

            <ul class="nav product-info-tab-list">
                <li><a class="active" data-toggle="tab" href="#tab-description"><?=$trans['productsdetails_description']?></a></li>
                <li><a data-toggle="tab" href="#tab-pwb_tab"><?=$trans['productsdetails_brand']?></a></li>
                <li><a data-toggle="tab" href="#tab-additional_information"><?=$trans['productsdetails_information']?></a></li>
            </ul>
            <div class="tab-content product-infor-tab-content">
                <div class="tab-pane fade show active" id="tab-description">
                    <div class="row">
                        <div class="col-lg-10 col-12 mx-auto">
                            <p><?=$description?></p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pwb_tab">
                    <div class="row learts-mb-n30">
                        <div class="col-12 learts-mb-30">
                            <div class="row learts-mb-n10">
                                <?php
                                    $query = "SELECT profile
                                    ,firstname
                                    ,ltrim(replace(substring(substring_index(u.image, '.', 1), length(substring_index(u.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                    ,ltrim(replace(substring(substring_index(u.image, '.', 2), length(substring_index(u.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                    FROM product p
                                    LEFT JOIN user u ON p.userId = u.id
                                    WHERE u.isdeleted = 0 AND u.vendor = 1 AND guidproduct = ?";
                                    $res=$db->prepare($query, array($guidproduct));
                                    while($row = mysqli_fetch_array($res)){
                                    ?>
                                <div class="col-lg-2 col-md-3 col-12 learts-mb-10"><img src="img/brands/<?=$row['imagename']?>.<?=$row['extension']?>" alt="<?=$row['firstname']?>"></div>
                                <div class="col learts-mb-10">
                                    <p><?=$row['profile']?></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-additional_information">
                    <div class="row">
                        <div class="col-lg-8 col-md-10 col-12 mx-auto">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <?php 
                                        $query = "SELECT pm.key, pm.content 
                                        FROM product p
                                        LEFT JOIN product_has_meta phm ON p.id = phm.productId
                                        LEFT JOIN product_meta pm ON phm.metaid = pm.Id
                                        WHERE p.guidproduct = ? AND pm.isdeleted=0 AND pm.key <> 'video'
                                        ORDER BY pm.key, pm.content";
                                        $res=$db->prepare($query, array($guidproduct));
                                        while($row = mysqli_fetch_array($res)){
                                            $key = ucfirst($row['key']);
                                            $content = ucfirst($row['content']);
                                    ?>
                                        <tr>
                                            <td><?=$key?></td>
                                            <td <?php if($key == 'Color') {echo 'bgcolor="'.$content.'"'; } ?>> <?php if($key <> 'Color') {echo $content; } ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="section section-padding pb-0">
        <div class="container">

            <div class="section-title2 text-center">
                <h2 class="title"><?=$trans['productsdetails_mightalsolike']?></h2>
            </div>
            <div class="product-carousel">
                <?php
                    $query = "SELECT p.id, pt.title
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
                    ,GROUP_CONCAT(DISTINCT pm.content ORDER BY pm.key SEPARATOR ';') as color
                    ,GROUP_CONCAT(DISTINCT pm2.content ORDER BY pm2.key SEPARATOR ';') as size
                    ,round(AVG(pr.rating)/5*100) as rate
                    FROM product p
                    LEFT JOIN (SELECT DISTINCT productId, image FROM product_image WHERE isdeleted = 0) pi ON p.id = pi.productId
                    LEFT JOIN product_translation pt ON p.id = pt.productId
                    LEFT JOIN product_has_meta phm ON p.id = phm.productId
                    LEFT JOIN product_meta pm ON phm.metaId = pm.id AND pm.key = 'color'
                    LEFT JOIN product_meta pm2 ON phm.metaId = pm2.id AND pm2.key <> 'color' AND pm2.key <> 'video'
                    LEFT JOIN (SELECT id FROM product
                    ORDER BY publishedAt DESC
                    LIMIT $topnewproducts) tp ON p.id = tp.id
                    LEFT JOIN product_review pr ON p.id = pr.productId
                    WHERE lang = '$lang' AND p.isdeleted = 0 
                    GROUP BY p.id
                    LIMIT 8";

                    $res=$db->query($query);
                    while($row = mysqli_fetch_array($res)){
                        $id = $row['id'];
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
                ?>
                <div class="col">
                    <div class="product">
                        <div class="product-thumb">
                            <a href="productdetails?guidproduct=<?=$guidproduct?>" class="image">
                            <?php if($isdiscount+$ishot+$isoutofstock > 0){?>
                                <span class="product-badges">
                                    <?php if($isdiscount > 0){?><span class="onsale">-<?=$discountlabel?></span><?php } ?>
                                    <?php if($ishot > 0){?><span class="hot">☆</span><?php } ?>
                                    <?php if($isoutofstock > 0){?><span class="outofstock"><i class="fal fa-frown"></i></span><?php } ?>
                                </span>
                            <?php } ?>
                                <img src="img/product/<?=$imagename?>-328.<?=$extension?>" alt="Product Image">
                                <img class="image-hover " src="img/product/<?=$imagename?>-328hover.<?=$extension?>" alt="Product Image">
                            </a>
                            <?php if($color || $size) {?>
                            <div class="product-options">
                                <?php if($color) {?>
                                <ul class="colors">
                                <?php 
                                    $colorsarray = explode(";",$color);
                                    foreach ($colorsarray as $c){
                                ?>
                                    <li style="background-color: <?=$c?>;"><?=$c?></li>
                                    <?php } ?>
                                </ul>
                                <?php }  ?>
                                <?php if($size) {?>
                                <ul class="sizes">
                                <?php 
                                    $sizessarray = explode(";",$size);
                                    foreach ($sizessarray as $s){
                                ?>
                                    <li><?=$s?></li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="product-info">
                            <h6 class="title"><a href="productdetails"><?=$title?></a></h6>
                            <span class="price">
                                <?php if($discount > 0){?>
                                    <span class="old"><?=$price?>€</span>
                                    <span class="new"><?=$finalprice?>€</span>
                                <?php } else { ?>
                                <?=$price?>€
                                <?php } ?>
                            </span>
                            <div class="product-buttons">
                                <a href="#quickViewModal" data-id="<?=$guidproduct?>" id="<?=$guidproduct?>" data-toggle="modal" class="product-button hintT-top" data-hint="<?=$trans['productsdetails_quickview']?>"><i class="fal fa-search"></i></a>
                                <a class="product-button hintT-top addToCart" data-hint="<?=$trans['productsdetails_addtocart']?>" data-id="<?=$guidproduct?>"><i class="fal fa-shopping-cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <?php sectionfooter($trans);?>

    <div class="quickViewModal modal fade" id="quickViewModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button class="close" data-dismiss="modal">&times;</button>
                <div id="modalin" class="row learts-mb-n30">
                    
                </div>
            </div>
        </div>
    </div> 

    <?php sectionjs();?>
    <script>
    // Event delegation para que funcione con productos cargados dinámicamente
    $(document).on('click', 'a.product-button', function(e) {
        e.preventDefault();
        var guidproduct = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'controller/quickviewproduct',
            data: {
                'guidproduct': guidproduct
            },
            success: function(response) {
                $('#modalin').html(response);
                // Reinicializar slick slider para el modal
                $('#quickViewModal').off('shown.bs.modal').on('shown.bs.modal', function (e) {
                    if (!$('.product-gallery-slider-quickview').hasClass('slick-initialized')) {
                        $('.product-gallery-slider-quickview').slick({
                            dots: true,
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                            nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
                        });
                    }
                });
            }
        });
    });
    </script>
</body>