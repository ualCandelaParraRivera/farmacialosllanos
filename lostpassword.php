<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/resetpass.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|login|lostpassword", $trans);?>

   
    <div class="section section-padding">
        <div class="container">

            <div class="lost-password">
                <p><?=$trans['lostpassword_text']?></p>
                <form id="frmReset" action="controller/resetpass" method="post">
                    <div class="row learts-mb-n30">
                        <div class="col-12 learts-mb-30 form-group" id="email-group">
                            <label for="email"><?=$trans['lostpassword_email']?></label>
                            <input id="email" name="email" class="form-control" type="text">
                        </div>
                        <div class="col-12 text-center learts-mb-30">
                            <button type="submit" class="btn btn-dark btn-outline-hover-dark"><?=$trans['lostpassword_reset']?></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

<?php sectionjs();?>
</body>