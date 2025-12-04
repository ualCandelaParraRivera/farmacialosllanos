<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php
header( "refresh:5;url=login" );
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|login|restorepassword", $trans);?>

    <!-- Lost Password Section Start -->
    <div class="section section-padding">
        <div class="container">

            <div class="lost-password">
            <h1><?=$trans['redirectresetlogin_title']?></h1>
                <form action="#">
                    <div class="row learts-mb-n30">
                        <div class="col-12 text-center learts-mb-10">
                            <a><br><?=$trans['redirectreset_text']?></a>
                        </div>
                        <div class="col-12 text-center learts-mb-30">
                        
                            <a><?=$trans['redirectreset_text2']?></a>
                        </div>
                        <div class="col-12 text-center learts-mb-30">
                            <a href="login" class="btn btn-dark btn-outline-hover-dark"><?=$trans['redirectreset_redirect']?></a>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
    <!-- Lost Password Section End -->
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

<?php sectionjs();?>
<script>
    var countDownDate = 5;
    var now = 0;
    var x = setInterval(function() {
        now = now + 1;
        var distance = countDownDate - now;
        document.getElementById("count").innerHTML = distance;
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("count").innerHTML = "0";
        }
    }, 1000);
    </script>
</body>