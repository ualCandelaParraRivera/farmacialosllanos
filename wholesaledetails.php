<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    if(!isset($_GET['guidwholesale'])){
        redirect($location_404);
    }
    $guidwholesale = $_GET['guidwholesale'];
    $query = "SELECT title
    ,sku
    ,content
    ,guidwholesale
    ,ltrim(replace(substring(substring_index(w.image, '.', 1), length(substring_index(w.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
   ,ltrim(replace(substring(substring_index(w.image, '.', 2), length(substring_index(w.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
    FROM wholesale w
    LEFT JOIN wholesale_translation wt ON w.id = wt.wholesaleId
    WHERE wt.lang = '$lang' AND guidwholesale = ? ";
    $res=$db->prepare($query, array($guidwholesale));
    $row = mysqli_fetch_array($res);
    $title = $row['title'];
    $content = $row['content'];
    $guidwholesale = $row['guidwholesale'];
    $sku = $row['sku'];
    $imagename = $row['imagename'];
    $extension = $row['extension'];
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|wholesales|wholesaledetails", $trans);?>

    <!-- Portfolio Section Start -->
    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row learts-mb-n30">

                <div class="col-xl-8 col-12 learts-mb-30">
                    <div class="portfolio-image">
                        <img src="img/wholesale/<?=$imagename?>.<?=$extension?>" alt="">
                    </div>
                </div>

                <div class="col-xl-4 col-12 learts-mb-30">
                    <div class="portfolio-content">
                        <h2 class="title"><?=$title?></h2>
                        <div class="desc">
                            <p><?=$content?></p>
                        </div>
                        <ul class="meta">
                            <li>
                                <span class="name"><?=$trans['wholesalesdetails_sku']?>:</span>
                                <span class="value"><?=$sku?></span>
                            </li>
                            <li>
                                <span class="name"><?=$trans['wholesalesdetails_share']?>:</span>
                                <span class="value social">
                                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 'facebook-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" onclick="window.open('http://twitter.com/intent/tweet/?url='+encodeURIComponent(location.href), 'twitter-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-twitter"></i></a>
                                    <a href="#" onclick="window.open('http://pinterest.com/pin/create/button/?url='+encodeURIComponent(location.href), 'pinterest-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-pinterest-p"></i></a>
                                    <a href="mailto:?subject=Mira este producto&amp;body=Puede que te resulte interesante%0D <?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>%0D"><i class="fal fa-envelope"></i></a>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 text-center learts-mb-30 learts-mt-40"><a href="contact?guidwholesale=<?=$guidwholesale?>" class="btn btn-dark btn-outline-hover-dark"><?=$trans['wholesalesdetails_request']?></a></div>
                </div>

            </div>
        </div>

    </div>
    <!-- Portfolio Section End -->
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>