<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>

    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <div class="home7-slider swiper-container section">
        <div class="swiper-wrapper">
            <div class="home7-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="img/slider/slide3-1<?php if($lang!='es') echo '_en'; ?>.png">
                
            </div>
            <div class="home7-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="img/slider/slide3-2<?php if($lang!='es') echo '_en'; ?>.png">
                
            </div>
        </div>
        <div class="home7-slider-prev swiper-button-prev"><i class="ti-angle-left"></i></div>
        <div class="home7-slider-next swiper-button-next"><i class="ti-angle-right"></i></div>
    </div>

    <div class="section section-padding">
        <div class="container">
            <div class="row learts-mb-n30">

                <div class="col-lg-5 col-md-6 col-12 ml-lg-auto align-self-center learts-mb-30">
                    <div class="about-us">
                        <div class="inner">
                            <img class="logo " src="img/about/about-01<?php if($lang!='es') echo '_en'; ?>.png" alt="About Image">
                            <p><?=$trans['index_about1']?></p>
                            <a href="contact" class="btn btn-primary2 btn-hover-black"><?=$trans['index_about2']?></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 ml-lg-auto learts-mb-30">
                    <div class="about-us-image">
                        <img src="img/about/about-2<?php if($lang!='es') echo '_en'; ?>.png" alt="About Image">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="section section-padding pt-0">
        <div class="container">
            <div class="row learts-mb-n30">

                <div class="col-lg-4 col-12 learts-mb-30">
                    <div class="sale-banner10">
                        <div class="inner">
                            <img src="img/banner/sale/sale-banner10-1.png" alt="Sale Banner Image">
                            <div class="content">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 learts-mb-30">

                    <div class="block-title">
                        <h3 class="title"><?=$trans['index_producttop']?></h3>
                    </div>

                    <div class="product-list-slider">
                    <?php 
                        $query = "SELECT title, price, discount, guidproduct, round((1-discount)*price,2) as finalprice, round(AVG(pr.rating)/5*100) as rate, MIN(image) as image 
                        FROM product p
                        LEFT JOIN product_translation pt ON p.id = pt.productId
                        LEFT JOIN product_review pr ON p.id = pr.productId
                        LEFT JOIN product_image pi ON p.id = pi.productId
                        WHERE pt.lang = '$lang' AND p.isdeleted = 0 AND pi.isdeleted = 0
                        GROUP BY title, guidproduct, price, discount
                        ORDER BY rate DESC
                        LIMIT 6";
                         $res=$db->query($query);
                        while($row = mysqli_fetch_array($res)){
                            $title = $row['title'];
                            $price = $row['price'];
                            $discount = $row['discount'];
                            $finalprice = $row['finalprice'];
                            $image = $row['image'];
                            $guidproduct = $row['guidproduct'];
                            $rate = $row['rate'] == '' ? 0 : $row['rate'];
                    ?>
                    <div class="list-product">
                            <div class="thumbnail">
                                <a href="productdetails?guidproduct=<?=$guidproduct?>"><img src="img/product/<?=$image?>" alt="<?=$title?>"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="productdetails?guidproduct=<?=$guidproduct?>"><?=$title?></a></h6>
                                <span class="price">
                                    <?php if($discount == 0){?>
                                        <?=$price?>€
                                    <?php } else { ?>
                                        <span class="old"><?=$price?>€</span>
                                        <span class="new"><?=$finalprice?>€</span>
                                    <?php } ?>
                                    
                                </span>
                                <?php if($rate > 0){?>
                                <div class="ratting">
                                    <span class="rate" style="width: <?=$rate?>%;"></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                        } 
                    ?>
                    </div>

                </div>

                <div class="col-lg-4 col-md-6 col-12 learts-mb-30">

                    <div class="block-title">
                        <h3 class="title"><?=$trans['index_productsales']?></h3>
                    </div>

                    <div class="product-list-slider">
                    <?php 
                        $query = "SELECT title, price, discount, guidproduct, round((1-discount)*price,2) as finalprice, round(AVG(pr.rating)/5*100) as rate, MIN(image) as image 
                        FROM product p
                        LEFT JOIN product_translation pt ON p.id = pt.productId
                        LEFT JOIN product_review pr ON p.id = pr.productId
                        LEFT JOIN product_image pi ON p.id = pi.productId
                        WHERE pt.lang = '$lang' AND discount > 0 AND p.isdeleted = 0 AND pi.isdeleted = 0
                        GROUP BY title, guidproduct, price, discount
                        ORDER BY rate DESC
                        LIMIT 6";
                         $res=$db->query($query);
                        while($row = mysqli_fetch_array($res)){
                            $title = $row['title'];
                            $price = $row['price'];
                            $discount = $row['discount'];
                            $finalprice = $row['finalprice'];
                            $image = $row['image'];
                            $guidproduct = $row['guidproduct'];
                            $rate = $row['rate'] == '' ? 0 : $row['rate'];
                    ?>
                     <div class="list-product">
                            <div class="thumbnail">
                                <a href="productdetails?guidproduct=<?=$guidproduct?>"><img src="img/product/<?=$image?>" alt="<?=$title?>"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="productdetails?guidproduct=<?=$guidproduct?>"><?=$title?></a></h6>
                                <span class="price">
                                    <?php if($discount == 0){?>
                                        <?=$price?>€
                                    <?php } else { ?>
                                        <span class="old"><?=$price?>€</span>
                                        <span class="new"><?=$finalprice?>€</span>
                                    <?php } ?>
                                    
                                </span>
                                <?php if($rate > 0){?>
                                <div class="ratting">
                                    <span class="rate" style="width: <?=$rate?>%;"></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                        } 
                    ?>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="section section-padding pt-0 pb-0">
        <div class="container">

            <div class="row learts-mb-n30">

                <div class="col-xl-3 col-lg-4 col-12 mr-auto learts-mb-30">
                    <h1 class="fw-400" style="text-align: center"><?=$trans['index_featuretitle']?></h1>
                </div>
                <div class="col-lg-8 col-12 learts-mb-30">
                    <div class="row learts-mb-n30">

                        <div class="col-md-6 col-12 learts-mb-30">
                            <p class="text-heading fw-600 learts-mb-10"><?=$trans['index_featuretitle1']?></p>
                            <p><?=$trans['index_featuretext1']?></p>
                        </div>

                        <div class="col-md-6 col-12 learts-mb-30">
                            <p class="text-heading fw-600 learts-mb-10"><?=$trans['index_featuretitle2']?></p>
                            <p><?=$trans['index_featuretext2']?></p>
                        </div>

                        <div class="col-md-6 col-12 learts-mb-30">
                            <p class="text-heading fw-600 learts-mb-10"><?=$trans['index_featuretitle3']?></p>
                            <p><?=$trans['index_featuretext3']?></p>
                        </div>

                        <div class="col-md-6 col-12 learts-mb-30">
                            <p class="text-heading fw-600 learts-mb-10"><?=$trans['index_featuretitle4']?></p>
                            <p><?=$trans['index_featuretext4']?></p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row learts-mb-n30">

                <div class="col-md-6 col-12 learts-mb-30">
                    <div class="about-us-image text-center">
                        <img src="img/about/about-3<?php if($lang!='es') echo '_en'; ?>.png" alt="About Image">
                    </div>
                </div>
                <div class="col-md-6 col-12 align-self-center learts-mb-30">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-12">
                            <div class="about-us">
                                <div class="inner">
                                    <span class="special-title"><?=$trans['index_secondabout1']?></span>
                                    <h2 class="title no-shape learts-mb-20"><?=$trans['index_secondabout2']?></h2>
                                    <p><?=$trans['index_secondabout3']?></p>
                                    <a href="contact" class="btn btn-primary2 btn-hover-black"><?=$trans['index_secondabout4']?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
    <?php sectioncookies($trans);?>
    
</body>