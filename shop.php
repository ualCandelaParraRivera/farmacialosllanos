<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    //$acceptedIps = array("86.127.253.50", "95.60.8.51");
    // $acceptedIps = array("86.127.236.178", "213.194.151.141", "160.178.138.178");

    // if(!isAcceptedIp($acceptedIps)){
    //     redirect("shop-soon");
    // }
    //  redirect("shop-soon");
?>
<?php 
    $getpage = isset($_GET['page']) ? 'page='.$_GET['page'] : '';
    $pagevalue = isset($_GET['page']) ? $_GET['page'] : '';
    $getsort = isset($_GET['sort']) ? 'sort='.$_GET['sort'] : '';
    $sortvalue = isset($_GET['sort']) ? $_GET['sort'] : '0';
    $getprice = isset($_GET['price']) ? 'price='.$_GET['price'] : '';
    $pricevalue = isset($_GET['price']) ? $_GET['price'] : '';
    $getcategory = isset($_GET['guidcategory']) ? 'guidcategory='.$_GET['guidcategory'] : '';
    $categoryvalue = isset($_GET['guidcategory']) ? $_GET['guidcategory'] : '';
    $getcolor = isset($_GET['color']) ? 'color='.$_GET['color'] : '';
    $colorvalue = isset($_GET['color']) ? $_GET['color'] : '';
    $getbrand = isset($_GET['guidbrand']) ? 'guidbrand='.$_GET['guidbrand'] : '';
    $brandvalue = isset($_GET['guidbrand']) ? $_GET['guidbrand'] : '';
    $gettag = isset($_GET['guidtag']) ? 'guidtag='.$_GET['guidtag'] : '';
    $tagvalue = isset($_GET['guidtag']) ? $_GET['guidtag'] : '';
    $getsearch = isset($_GET['search']) ? 'search='.$_GET['search'] : '';
    $searchvalue = isset($_GET['search']) ? $_GET['search'] : '';

    $arr = array($getpage, $getsort, $getprice, $getcategory, $getcolor, $getbrand, $gettag, $getsearch);

    $sqlorderby = '';
    if($sortvalue == 1){
        $sqlorderby = ' ORDER BY round(AVG(pr.rating)/5*100) desc';
    }else if($sortvalue == 2){
        $sqlorderby = ' ORDER BY publishedAt desc';
    }else if($sortvalue == 3){
        $sqlorderby = ' ORDER BY ROUND((1-discount)*price,2) asc';
    }else if($sortvalue == 4){
        $sqlorderby = ' ORDER BY ROUND((1-discount)*price,2) desc';
    }


    $q = 'SELECT MAX(ROUND((1-discount)*price,2)) as price FROM product p WHERE p.isdeleted = 0';
    $res=$db->query($q);
    $row = mysqli_fetch_array($res);
    $maxprice = $row['price'];
    $sqlprice = '';
    if($pricevalue == 1){
        $sqlprice = ' AND ROUND((1-discount)*price,2) >= '.($maxprice*0).' AND ROUND((1-discount)*price,2) <= '.($maxprice*0.2).' ';
    }else if($pricevalue == 2){
        $sqlprice = ' AND ROUND((1-discount)*price,2) >= '.($maxprice*0.2).' AND ROUND((1-discount)*price,2) <= '.($maxprice*0.4).' ';
    }else if($pricevalue == 3){
        $sqlprice = ' AND ROUND((1-discount)*price,2) >= '.($maxprice*0.4).' AND ROUND((1-discount)*price,2) <= '.($maxprice*0.6).' ';
    }else if($pricevalue == 4){
        $sqlprice = ' AND ROUND((1-discount)*price,2) >= '.($maxprice*0.6).' AND ROUND((1-discount)*price,2) <= '.($maxprice*0.8).' ';
    }else if($pricevalue == 5){
        $sqlprice = ' AND ROUND((1-discount)*price,2) >= '.($maxprice*0.8).' AND ROUND((1-discount)*price,2) <= '.($maxprice).' ';
    }

    $sqlcategory = '';
    if(!empty($categoryvalue)){
        $sqlcategory = ' AND p.id IN (SELECT productId FROM category c
    LEFT JOIN product_category pc ON c.id = pc.categoryId
    WHERE c.guidcategory = \''.($db->real_escape_string($categoryvalue)).'\') ';
    }

    $sqltag = '';
    if(!empty($tagvalue)){
        $sqltag = ' AND p.id IN (SELECT productId FROM tag t
        LEFT JOIN product_tag pt ON t.id = pt.tagId
        WHERE t.guidtag = \''.($db->real_escape_string($tagvalue)).'\') ';
    }

    $sqlcolor = '';
    if(!empty($colorvalue)){
        $sqlcolor = ' AND pm.content = \'#'.$colorvalue.'\' ';
    }
    
    $sqlbrand = '';
    if(!empty($brandvalue)){
        $sqlbrand = '  AND p.userId IN (SELECT id FROM user
        WHERE vendor = 1 AND guiduser = \''.($db->real_escape_string($brandvalue)).'\') ';
    }

    $sqlsearch = '';
    if(!empty($searchvalue)){
        $seval = ($db->real_escape_string($searchvalue));
        $sqlsearch = ' AND (pt.title LIKE \'%'.$seval.'%\' OR pt.summary LIKE \'%'.$seval.'%\' OR pt.content LIKE \'%'.$seval.'%\') ';
    }

    //echo url($arr,-1,'');




    $rowsperpage = $productsperpage;
    $query = "SELECT count(id) as allcount 
    FROM product p
    WHERE p.isdeleted = 0";
    $res=$db->query($query);
    $row = mysqli_fetch_array($res);
    $allcount = $row['allcount'];
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/loadmoreproducts.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|shop", $trans);?>

    <!-- Shop Products Section Start -->
    <div class="section section-padding pt-0 pb-0">

        <!-- Shop Toolbar Start -->
        <div class="shop-toolbar border-bottom">
            <div class="container">
                <div class="row learts-mb-n20">

                    <!-- Isotop Filter Start -->
                    <div class="col-md col-12 align-self-center learts-mb-20">
                        <div class="isotope-filter shop-product-filter" data-target="#shop-products">
                            <button class="active" data-filter="*"><?=$trans['products_groupfilter1']?></button>
                            <button data-filter=".featured"><?=$trans['products_groupfilter2']?></button>
                            <button data-filter=".new"><?=$trans['products_groupfilter3']?></button>
                            <button data-filter=".sales"><?=$trans['products_groupfilter4']?></button>
                        </div>
                    </div>
                    <!-- Isotop Filter End -->

                    <div class="col-md-auto col-12 learts-mb-20">
                        <ul class="shop-toolbar-controls">

                            <li>
                                <div class="product-sorting">
                                    <select class="nice-select" onchange="location = this.value;">
                                        <option value="shop<?=url($arr,1,'')?>" <?php if($sortvalue==0){ ?>selected="selected"<?php } ?> ><?=$trans['products_groupfilter5']?></option>
                                        <option value="shop<?=url($arr,1,'sort=1')?>" <?php if($sortvalue==1){ ?>selected="selected"<?php } ?> ><?=$trans['products_groupfilter6']?></option>
                                        <option value="shop<?=url($arr,1,'sort=2')?>" <?php if($sortvalue==2){ ?>selected="selected"<?php } ?> ><?=$trans['products_groupfilter7']?></option>
                                        <option value="shop<?=url($arr,1,'sort=3')?>" <?php if($sortvalue==3){ ?>selected="selected"<?php } ?> ><?=$trans['products_groupfilter8']?></option>
                                        <option value="shop<?=url($arr,1,'sort=4')?>" <?php if($sortvalue==4){ ?>selected="selected"<?php } ?> ><?=$trans['products_groupfilter9']?></option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="product-column-toggle d-none d-xl-flex">
                                    <button class="toggle hintT-top" data-hint="5 <?=$trans['products_groupcolumns']?>" data-column="5"><i class="ti-layout-grid4-alt"></i></button>
                                    <button class="toggle active hintT-top" data-hint="4 <?=$trans['products_groupcolumns']?>" data-column="4"><i class="ti-layout-grid3-alt"></i></button>
                                    <button class="toggle hintT-top" data-hint="3 <?=$trans['products_groupcolumns']?>" data-column="3"><i class="ti-layout-grid2-alt"></i></button>
                                </div>
                            </li>
                            <li>
                                <a class="product-filter-toggle" href="#product-filter"><?=$trans['products_groupfilter10']?></a>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <!-- Shop Toolbar End -->

        <!-- Product Filter Start -->
        <div id="product-filter" class="product-filter bg-light">
            <div class="container">
                <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 learts-mb-n30">

                    <!-- Sort by Start -->
                    <div class="col learts-mb-30">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['products_filter1']?></h3>
                        <ul class="widget-list product-filter-widget customScroll">
                            <li><a href="shop<?=url($arr,1,'')?>"><?=$trans['products_filter1_1']?></a></li>
                            <li><a href="shop<?=url($arr,1,'sort=1')?>"><?=$trans['products_filter1_2']?></a></li>
                            <li><a href="shop<?=url($arr,1,'sort=2')?>"><?=$trans['products_filter1_3']?></a></li>
                            <li><a href="shop<?=url($arr,1,'sort=3')?>"><?=$trans['products_filter1_4']?></a></li>
                            <li><a href="shop<?=url($arr,1,'sort=4')?>"><?=$trans['products_filter1_5']?></a></li>
                        </ul>
                    </div>
                    <!-- Sort by End -->

                    <!-- Price filter Start -->
                    <div class="col learts-mb-30">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['products_filter2']?></h3>
                        <ul class="widget-list product-filter-widget customScroll">
                            <li> <a href="shop<?=url($arr,2,'')?>"><?=$trans['products_filter2_1']?></a></li>
                            <?php
                            $query = "SELECT CONCAT('<span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.0,0),'</span>€ - <span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.2,0),'</span>€') as price01
                            ,CONCAT('<span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.2,0),'</span>€ - <span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.4,0),'</span>€') as price02
                            ,CONCAT('<span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.4,0),'</span>€ - <span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.6,0),'</span>€') as price03
                            ,CONCAT('<span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.6,0),'</span>€ - <span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.8,0),'</span>€') as price04
                            ,CONCAT('<span class=\"amount\"><span class=\"cur-symbol\"></span>',ROUND(price*0.8,0),'</span>€ +') as price05 
                            FROM (
                            SELECT MAX(ROUND((1-discount)*price,2)) as price FROM product p WHERE p.isdeleted = 0
                            ) p";
                            $res=$db->query($query);
                            $row = mysqli_fetch_array($res);
                            ?>
                            <li> <a href="shop<?=url($arr,2,'price=1')?>"><?=$row['price01']?></a></li>
                            <li> <a href="shop<?=url($arr,2,'price=2')?>"><?=$row['price02']?></a></li>
                            <li> <a href="shop<?=url($arr,2,'price=3')?>"><?=$row['price03']?></a></li>
                            <li> <a href="shop<?=url($arr,2,'price=4')?>"><?=$row['price04']?></a></li>
                            <li> <a href="shop<?=url($arr,2,'price=5')?>"><?=$row['price05']?></a></li>
                        </ul>
                    </div>
                    <!-- Price filter End -->

                    <!-- Categories Start -->
                    <div class="col learts-mb-30">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['products_filter3']?></h3>
                        <ul class="widget-list product-filter-widget customScroll">
                            <li><a href="shop<?=url($arr,3,'')?>"><?=$trans['products_filter3_1']?></a></li>
                        <?php
                                $query = "SELECT ct.title, c.guidcategory, COUNT(p.id) as count FROM category c
                                LEFT JOIN category_translation ct ON c.id = ct.categoryId
                                LEFT JOIN product_category pc ON c.id = pc.categoryId
                                LEFT JOIN product p ON pc.productId = p.id
                                WHERE c.isdeleted = 0 AND p.isdeleted = 0 AND ct.lang = '$lang'
                                GROUP BY c.id
                                ORDER BY ct.title ASC";
                                $res=$db->query($query);
                                while($row = mysqli_fetch_array($res)){
                                    $title = $row['title'];
                                    $count = $row['count'];
                                    $guidcategory = $row['guidcategory'];
                                ?>
                            <li><a href="shop<?=url($arr,3,'guidcategory='.$guidcategory)?>"><?=$title?></a> <span class="count"><?=$count?></span></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- Categories End -->

                    <!-- Filters by colors Start -->
                    <div class="col learts-mb-30">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['products_filter4']?></h3>
                        <ul class="widget-colors product-filter-widget customScroll">
                            <li><a href="shop<?=url($arr,4,'')?>" class="hintT-right" data-hint="<?=$trans['products_filter4_1']?>"><span data-bg-image="img/icons/clear.png" data-bg-color="#f8f8f8">#f8f8f8</span></a></li>
                            <?php
                            $query = "SELECT DISTINCT(content) as color
                            FROM product_meta pm
                            WHERE pm.key = 'color' AND pm.isdeleted = 0";
                            $res=$db->query($query);
                            while($row = mysqli_fetch_array($res)){
                            ?>
                            <li><a href="shop<?=url($arr,4,'color='.substr($row['color'],1))?>" class="hintT-right" data-hint="<?=$row['color']?>"><span data-bg-color="<?=$row['color']?>"><?=$row['color']?></span></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- Filters by colors End -->

                    <!-- Brands Start -->
                    <div class="col learts-mb-30">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['products_filter5']?></h3>
                        <ul class="widget-list product-filter-widget customScroll">
                        <li><a href="shop<?=url($arr,5,'')?>"><?=$trans['products_filter5_1']?></a></li>
                            <?php
                            $query = "SELECT u.guiduser, firstname as marca, COUNT(p.id) as count FROM user u
                            INNER JOIN product p ON u.id = p.userId
                            WHERE vendor = 1 AND p.isdeleted = 0
                            GROUP BY u.id";
                            $res=$db->query($query);
                            while($row = mysqli_fetch_array($res)){
                                $marca = $row['marca'];
                                $count = $row['count'];
                                $guiduser = $row['guiduser'];
                            ?>
                            <li><a href="shop<?=url($arr,5,'guidbrand='.$guiduser)?>"><?=$marca?></a> <span class="count">(<?=$count?>)</span></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- Brands End -->

                </div>
            </div>
        </div>
        <!-- Product Filter End -->

        <div class="section learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">

                    <div class="col-lg-9 col-12 learts-mb-50 order-lg-2">
                        <!-- Products Start -->
                        <div id="shop-products" class="products row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
                            <!-- <div class="grid-sizer col-1"></div> -->
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
                                LEFT JOIN (SELECT DISTINCT productId, image FROM product_image WHERE isdeleted = 0 GROUP BY productId ORDER BY image) pi ON p.id = pi.productId
                                LEFT JOIN product_translation pt ON p.id = pt.productId
                                LEFT JOIN product_has_meta phm ON p.id = phm.productId
                                LEFT JOIN product_meta pm ON phm.metaId = pm.id AND pm.key = 'color' AND pm.isdeleted = 0
                                LEFT JOIN product_meta pm2 ON phm.metaId = pm2.id AND pm2.key <> 'color' AND pm2.key <> 'video' AND pm2.isdeleted = 0
                                LEFT JOIN (SELECT id FROM product
                                ORDER BY publishedAt DESC
                                LIMIT $topnewproducts) tp ON p.id = tp.id
                                LEFT JOIN product_review pr ON p.id = pr.productId
                                WHERE lang = '$lang' AND p.isdeleted = 0 $sqlprice $sqlcategory $sqltag $sqlcolor $sqlbrand $sqlsearch 
                                GROUP BY p.id
                                $sqlorderby 
                                LIMIT 0, $rowsperpage";
    
                                $res=$db->query($query);
                                while($row = mysqli_fetch_array($res)){
                                    $id = $row['id'];
                                    $imagename = $row['imagename'];
                                    $extension = $row['extension'];
                                    $title = $row['title'];
                                    $price = $row['price'];
                                    $discountlabel = $row['discountlabel'];
                                    $discount = $row['discount']*100;
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
                            <div class="grid-item col<?=$label?>">
                                <div class="product">
                                    <div class="product-thumb">
                                        <a href="productdetails?guidproduct=<?=$guidproduct?>" class="image">
                                        <?php if($isdiscount+$ishot+$isoutofstock > 0){?>
                                            <span class="product-badges">
                                                <?php if($isdiscount > 0){?><span class="onsale">-<?=$discountlabel?></span><?php } ?>
                                                <?php if($ishot > 0){?><span class="hot">hot</span><?php } ?>
                                                <?php if($isoutofstock > 0){?><span class="outofstock"><i class="fal fa-exclamation-triangle"></i></span><?php } ?>
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
                                            <a href="#quickViewModal" data-id="<?=$guidproduct?>" id="<?=$guidproduct?>" data-toggle="modal" class="product-button hintT-top" data-hint="<?=$trans['products_quickview']?>"><i class="fal fa-search"></i></a>
                                            <a class="product-button hintT-top addToCart" data-hint="<?=$trans['products_addtocart']?>" data-id="<?=$guidproduct?>"><i class="fal fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            

                        </div>
                        <!-- Products End -->
                        <?php 
                            if($rowsperpage < $allcount){
                        ?>
                        <div class="text-center learts-mt-70">
                            <button class="btn btn-dark btn-outline-hover-dark loadmoreproducts"><i class="ti-plus"></i> <?=$trans['products_more']?></button>
                            <input type="hidden" id="row" value="0">
                            <input type="hidden" id="productsperpage" value="<?=$rowsperpage?>">
                            <input type="hidden" id="all" value="<?=$allcount?>">
                        </div>
                        <?php } ?>

                        <!-- <div class="text-center learts-mt-70">
                            <div class="pagination">
                                <div class="pagination-container">
                                    <div class="pagination-hover-overlay"></div>
                                    <a href="#0" class="pagination-prev">
                                        <span class="icon-pagination icon-pagination-prev">
                                            <i class="icon material-icons">
                                                keyboard_arrow_left
                                            </i>
                                        </span>
                                    </a>

                                    <a href="#0" class="pagination-page-number">1</a>
                                    <a href="#0" class="pagination-page-number">2</a>
                                    <a href="#0" class="pagination-page-number">3</a>
                                    <a href="#0" class="pagination-page-number">4</a>

                                    <a href="#0" class="pagination-next">
                                        <span class="icon-pagination icon-pagination-next">
                                            <i class="icon material-icons">
                                                keyboard_arrow_left
                                            </i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                        

                    <div class="col-lg-3 col-12 learts-mb-10 order-lg-1">

                        <!-- Search Start -->
                        <div class="single-widget learts-mb-40">
                            <div class="widget-search">
                                <form action="shop" method="get">
                                    <input name="search" type="text" value="<?=$searchvalue?>" placeholder="<?=$trans['products_search']?>">
                                    <button><i class="fal fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <!-- Search End -->

                        <!-- Categories Start -->
                        <div class="single-widget learts-mb-40">
                            <h3 class="widget-title product-filter-widget-title"><?=$trans['products_categories']?></h3>
                            <ul class="widget-list">
                                <li><a href="shop<?=url($arr,3,'')?>"><?=$trans['products_allcategories']?></a></span></li>
                                <?php
                                $query = "SELECT ct.title, c.guidcategory, COUNT(p.id) as count FROM category c
                                LEFT JOIN category_translation ct ON c.id = ct.categoryId
                                LEFT JOIN product_category pc ON c.id = pc.categoryId
                                LEFT JOIN product p ON pc.productId = p.id
                                WHERE c.isdeleted = 0 AND p.isdeleted = 0 AND ct.lang = '$lang'
                                GROUP BY c.id
                                ORDER BY ct.title ASC";
                                $res=$db->query($query);
                                while($row = mysqli_fetch_array($res)){
                                    $title = $row['title'];
                                    $count = $row['count'];
                                    $guidcategory = $row['guidcategory'];
                                ?>
                                <li><a href="shop<?=url($arr,3,'guidcategory='.$guidcategory)?>"><?=$title?></a> <span class="count"><?=$count?></span></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- Categories End -->


                        <!-- List Product Widget Start -->
                        <div class="single-widget learts-mb-40">
                            <h3 class="widget-title product-filter-widget-title"><?=$trans['products_new']?></h3>
                            <ul class="widget-products">
                            <?php
                                $query = "SELECT pt.title
                                ,ltrim(replace(substring(substring_index(pi.image, '.', 1), length(substring_index(pi.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                ,ltrim(replace(substring(substring_index(pi.image, '.', 2), length(substring_index(pi.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                ,ROUND((1-discount)*price,2) as finalprice
                                ,round(AVG(pr.rating)/5*100) as rate
                                ,guidproduct
                                FROM product p
                                LEFT JOIN (SELECT DISTINCT productId, image FROM product_image WHERE isdeleted = 0 GROUP BY productId ORDER BY image ) pi ON p.id = pi.productId
                                LEFT JOIN product_translation pt ON p.id = pt.productId
                                LEFT JOIN product_review pr ON p.id = pr.productId
                                WHERE lang = '$lang' AND p.isdeleted = 0 AND p.quantity > 0
                                GROUP BY p.id
                                ORDER BY publishedAt DESC
                                LIMIT 3";
                                $res=$db->query($query);
                                while($row = mysqli_fetch_array($res)){
                                    $title = $row['title'];
                                    $imagename = $row['imagename'];
                                    $extension = $row['extension'];
                                    $finalprice = $row['finalprice'];
                                    $rate = $row['rate'];
                                    $guidproduct = $row['guidproduct'];
                            ?>
                                <li class="product">
                                    <div class="thumbnail">
                                        <a href="productdetails?guidproduct=<?=$guidproduct?>"><img src="img/product/<?=$imagename?>-widget.<?=$extension?>" alt="List product"></a>
                                    </div>
                                    <div class="content">
                                        <h6 class="title"><a href="productdetails?guidproduct=<?=$guidproduct?>"><?=$title?></a></h6>
                                        <span class="price">
                                            <?=$finalprice?>€
                                        </span>
                                        <div class="ratting">
                                            <span class="rate" style="width: <?=$rate?>%;"></span>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            </ul>
                        </div>
                        <!-- List Product Widget End -->

                        <!-- Tags Start -->
                        <div class="single-widget learts-mb-40">
                            <h3 class="widget-title product-filter-widget-title"><?=$trans['products_tags']?></h3>
                            <div class="widget-tags">
                                <a href="shop<?=url($arr,6,'')?>"><?=$trans['products_alltags']?></a>
                            <?php
                                 $query = "SELECT DISTINCT title as tag
                                 ,guidtag
                                 FROM product p
                                 LEFT JOIN product_tag pt ON p.id = pt.productId
                                 LEFT JOIN tag t ON pt.tagId = t.id
                                 WHERE p.isdeleted = 0 AND t.isdeleted = 0";
                                $res=$db->query($query);
                                while($row = mysqli_fetch_array($res)){
                                    $tag = $row['tag'];
                                    $guidtag = $row['guidtag'];
                            ?>
                                <a href="shop<?=url($arr,6,'guidtag='.$guidtag)?>"><?=$tag?></a>
                            <?php } ?>
                            </div>
                        </div>
                        <!-- Tags End -->

                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- Shop Products Section End -->
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <!-- Modal -->
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
    $('a.product-button').on('click', function(e) {
        var guidproduct = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'controller/quickviewproduct',
            data: {
                'guidproduct': guidproduct
            },
            success: function(response) {
                $('#modalin').html(response);
                
            }
        });
        
    });
    </script>
</body>