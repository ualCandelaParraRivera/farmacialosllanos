<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    /* $res=$db->query("SELECT name FROM user");
    while($row = mysqli_fetch_array($res)){
        echo $row['name'];
    } */
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|aboutus", $trans);?>

    <!-- About Section Start -->
    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row learts-mb-n30">

                <div class="col-md-6 col-12 align-self-center learts-mb-30">
                    <div class="about-us3">
                        <!-- <span class="sub-title"><?=$trans['aboutus_aboutsubtitle']?></span> -->
                        <h2 class="title"><?=$trans['aboutus_abouttitle']?></h2>
                        <div class="desc">
                            <p><?=$trans['aboutus_aboutdescription']?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 text-center learts-mb-30">
                    <img src="img/about/about-6.png" alt="">
                </div>

            </div>
        </div>

    </div>
    <!-- About Section End -->

    <!-- Feature Section Start -->
    <!-- <div class="section section-padding pb-0">
        <div class="container">
            <div class="row row-cols-md-3 row-cols-1 learts-mb-n30">

                <div class="col learts-mb-30">
                    <div class="icon-box4">
                        <div class="inner">
                            <div class="content">
                                <h6 class="title"><?=$trans['aboutus_feature1title']?></h6>
                                <p><?=$trans['aboutus_feature1text']?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col border-left border-right learts-mb-30">
                    <div class="icon-box4">
                        <div class="inner">
                            <div class="content">
                                <h6 class="title"><?=$trans['aboutus_feature2title']?></h6>
                                <p><?=$trans['aboutus_feature2text']?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col learts-mb-30">
                    <div class="icon-box4">
                        <div class="inner">
                            <div class="content">
                                <h6 class="title"><?=$trans['aboutus_feature3title']?></h6>
                                <img class="img-hover-color " src="img/others/pay.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> -->
    <!-- Feature Section End -->

    <!-- Team Section Start -->
    <!-- <div class="section section-padding">
        <div class="container">

            <div class="section-title2 text-center">
                <h2 class="title"><?=$trans['aboutus_team']?></h2>
                <p><?=$trans['aboutus_teamquotes']?></p>
            </div>
            <div class="row row-cols-md-3 row-cols-sm-2 row-cols-1 learts-mb-n30">

                <div class="col learts-mb-30">
                    <div class="team">
                        <div class="image">
                            <img src="img/team/victor.png" alt="">
                            <div class="social">
                                <a href="https://www.linkedin.com/in/victor-manuel-manrique-morales-027279203" target="_blank"><i class="fab fa-linkedin"></i></a>
                                <a href="https://www.instagram.com/hempleafspain/" target="_blank"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <h6 class="name"><?=$trans['aboutus_team1name']?></h6>
                            <span class="title"><?=$trans['aboutus_team1title']?></span>
                        </div>
                    </div>
                </div>

                <div class="col learts-mb-30">
                    <div class="team">
                        <div class="image">
                            <img src="img/team/izabel.png" alt="">
                            <div class="social">
                                <a href="https://www.linkedin.com/in/izabele-lever" target="_blank"><i class="fab fa-linkedin"></i></a>
                                <a href="https://www.instagram.com/hempleafspain/" target="_blank"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <h6 class="name"><?=$trans['aboutus_team2name']?></h6>
                            <span class="title"><?=$trans['aboutus_team2title']?></span>
                        </div>
                    </div>
                </div>

                <div class="col learts-mb-30">
                    <div class="team">
                        <div class="image">
                            <img src="img/team/sergio.png" alt="">
                            <div class="social">
                                <a href="https://www.linkedin.com/in/cheikh-tidiane-diallo-sow-65a490110" target="_blank"><i class="fab fa-linkedin"></i></a>
                                <a href="https://www.instagram.com/hempleafspain/" target="_blank"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <h6 class="name"><?=$trans['aboutus_team3name']?></h6>
                            <span class="title"><?=$trans['aboutus_team3title']?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> -->
    <!-- Team Section End -->

    <!-- Instagram Section Start -->
    <div class="section section-fluid section-padding pt-20 pb-0">
        <div class="container">

            <!-- Section Title Start -->
            <div class="section-title2 text-center">
                <h3 class="sub-title"><?=$trans['aboutus_instagram']?></h3>
                <h2 class="title">@hempleafspain</h2>
            </div>
            <!-- Section Title End -->

            <div id="instagram-feed221" class="instagram-carousel instagram-carousel1 instagram-feed">
            </div>

        </div>
    </div>
    <!-- Instagram Section End -->
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>

</html>