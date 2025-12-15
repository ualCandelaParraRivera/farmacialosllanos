<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|aboutus", $trans);?>

   
    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row learts-mb-n30">

                <div class="col-md-6 col-12 align-self-center learts-mb-30">
                    <div class="about-us3">
                       <?=$trans['aboutus_aboutsubtitle']?></span> -->
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
    
    <div class="section section-padding">
        <div class="container">

            <div class="section-title2 text-center">
                <h2 class="title"><?=$trans['aboutus_team']?></h2>
                <p><?=$trans['aboutus_teamquotes']?></p>
            </div>
            <div class="row row-cols-md-3 row-cols-sm-2 row-cols-1 learts-mb-n30">

                <div class="col learts-mb-30">
                    <div class="team">
                        <div class="image">
                            <img src="img/team/2.jpg" alt="">
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
                            <img src="img/team/1.jpg" alt="">
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
                            <img src="img/team/6.jpg" alt="">
                        </div>
                        <div class="content">
                            <h6 class="name"><?=$trans['aboutus_team3name']?></h6>
                            <span class="title"><?=$trans['aboutus_team3title']?></span>
                        </div>
                    </div>
                </div>
                <div class="col learts-mb-30">
                    <div class="team">
                        <div class="image">
                            <img src="img/team/4.jpg" alt="">
                        </div>
                        <div class="content">
                            <h6 class="name"><?=$trans['aboutus_team4name']?></h6>
                            <span class="title"><?=$trans['aboutus_team4title']?></span>
                        </div>
                    </div>
                </div>
                <div class="col learts-mb-30">
                    <div class="team">
                        <div class="image">
                            <img src="img/team/3.jpg" alt="">
                        </div>
                        <div class="content">
                            <h6 class="name"><?=$trans['aboutus_team5name']?></h6>
                            <span class="title"><?=$trans['aboutus_team5title']?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
   
    <div class="section section-fluid section-padding pt-20 pb-0">
        <div class="container">

            <div class="section-title2 text-center">
                <h3 class="sub-title"><?=$trans['aboutus_instagram']?></h3>
                <h2 class="title">@farmacialosllanosalmeria</h2>
            </div>

            <div id="instagram-feed221" class="instagram-carousel instagram-carousel1 instagram-feed">
            </div>

        </div>
    </div>
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>

</html>