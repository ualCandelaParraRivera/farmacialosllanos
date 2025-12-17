<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    $subject = "";
    $message = "";
    if(isset($_GET['guidwholesale'])){
        $query = "SELECT title, sku FROM wholesale w
        LEFT JOIN wholesale_translation wt ON w.id = wt.wholesaleId
         WHERE wt.lang = '$lang' AND guidwholesale = ?";
         $res=$db->prepare($query, array($_GET['guidwholesale']));
         if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $subject = $trans['contact_infoabout']." ".$row['sku'];
            $message = $trans['contact_infoabout2']." ".$row['title'];
         }
    }
    $name = "";
    $email = "";
    if(isset($_SESSION['usercode'])){
        $query = "SELECT CONCAT(firstname, ' ',middlename) as name
        ,email 
        FROM user u
        WHERE id = ?";
        $res=$db->prepare($query, array($_SESSION['usercode']));
        if($db->numRows($res) > 0){
           $row = mysqli_fetch_array($res);
            $name = $row['name'];
            $email = $row['email'];
        }
    }
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/contactmail.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb('|contact', $trans);?>

    <div class="section section-padding">
        <div class="container">
            <div class="section-title2 text-center">
                <h2 class="title"><?=$trans['contact_title']?></h2>
                <p><?=$trans['contact_text']?></p>
            </div>
            
            <div class="row learts-mt-30">
                <div class="col-lg-4 col-md-6 col-12 learts-mb-30">
                    <div class="contact-info">
                        <h4 class="title"><?=$trans['contact_address_shop']?></h4>
                        <span class="info"><i class="icon fal fa-map-marker-alt"></i> <?=$trans['contact_address_shop2']?></span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 learts-mb-30">
                    <div class="contact-info">
                        <h4 class="title"><?=$trans['contact_contact_shop']?></h4>
                        <span class="info"><i class="icon fal fa-phone-alt"></i> <?=$trans['contact_mobile_shop']?></span>
                        <span class="info"><i class="icon fal fa-envelope"></i> <?=$trans['contact_mail_shop']?></span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 learts-mb-30">
                    <div class="contact-info">
                        <h4 class="title"><?=$trans['contact_hour_shop']?></h4>
                        <span class="info"><i class="icon fal fa-clock"></i> <?=$trans['contact_hour_shop2']?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="section section-padding pt-0 pb-0">
        <div class="container">
            <div class="section-title2 text-center">
                <h2 class="title"><?=$trans['contact_messagetitle']?></h2>
            </div>

            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <div class="contact-form">
                        <form action="controller/contactmail" id="contactform" method="post">
                            <div class="row learts-mb-n30">
                                <div class="col-md-6 col-12 learts-mb-30"><input type="text" value="<?=$name?>" placeholder="<?=$trans['contact_formname']?> *" id="name" name="name"></div>
                                <div class="col-md-6 col-12 learts-mb-30"><input type="email" value="<?=$email?>" placeholder="<?=$trans['contact_formemail']?> *" id="email" name="email"></div>
                                <div class="col-md-12 col-12 learts-mb-30"><input type="text" value="<?=$subject?>" placeholder="<?=$trans['contact_formsubject']?> *" id="subject" name="subject"></div>
                                <div class="col-12 learts-mb-30"><textarea name="message" id="message" placeholder="<?=$trans['contact_formmessage']?>"><?=$message?></textarea></div>
                                <div class="col-12 text-center learts-mb-30"><button type="submit" class="btn btn-dark btn-outline-hover-dark"><?=$trans['contact_formsubmit']?></button></div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>