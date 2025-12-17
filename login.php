<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php
  if (isset($_SESSION['usercode'])){
    header('location: '.$location_already_logged);
    exit;
  }
?>
<?php 
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/registeremail.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|login", $trans);?>

    <div class="section section-padding">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-6">
                    <div class="user-login-register bg-light">
                        <div class="login-register-title">
                            <h2 class="title"><?=$trans['login_logintitle']?></h2>
                            <?php if(isset($_GET['error']) && $_GET['error']=='invalidlogin'){ ?>
                            <p class="desc"><?=$trans['login_logininvalid']?></p>
                            <?php } else if (isset($_GET['message']) && $_GET['message']=='logout'){?>
                            <p class="desc"><?=$trans['login_loginclose']?></p>
                            <?php } else if (isset($_GET['message']) && $_GET['message']=='expire'){?>
                            <p class="desc"><?=$trans['login_loginexpire']?></p>
                            <?php } else {?>
                            <p class="desc"><?=$trans['login_loginsubtitle']?></p>
                            <?php } ?>
                            
                        </div>
                        <div class="login-register-form">
                            <form action="controller/verifylogin" method="post">
                                <div class="row learts-mb-n50">
                                    <div class="col-12 learts-mb-50">
                                        <input type="email" name="email" id="email" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" placeholder="<?=$trans['login_loginemail']?>">
                                    </div>
                                    <div class="col-12 learts-mb-50">
                                        <input type="password" name="password" id="password" value="<?php if(isset($_COOKIE["random_password"])) { echo $_COOKIE["random_password"]; } ?>" placeholder="<?=$trans['login_loginpassword']?>"></div>
                                    <div class="col-12 text-center learts-mb-50">
                                        <button type="submit" class="btn btn-dark btn-outline-hover-dark"><?=$trans['login_loginacceder']?></button>
                                    </div>
                                    <div class="col-12 learts-mb-50">
                                        <div class="row learts-mb-n20">
                                            
                                            <div class="col-12 learts-mb-20">
                                                <a href="lostpassword" class="fw-400"><?=$trans['login_loginlostpassword']?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="user-login-register">
                        <div class="login-register-title">
                            <h2 class="title"><?=$trans['login_registertitle']?></h2>
                            <p class="desc"><?=$trans['login_registersubtitle']?></p>
                        </div>
                        <div class="login-register-form">
                            <form id="frmRegister" action="controller/validateregisteremail" method="post">
                                <div class="row learts-mb-n50">
                                    <div class="col-12 learts-mb-20 form-group" id="registeremail-group">
                                        <label for="registeremail"><?=$trans['login_registeremail']?> <abbr class="required">*</abbr></label>
                                        <input type="email" id="registeremail" name="registeremail">
                                    </div>
                                    <div class="col-12 learts-mb-50">
                                        <p><?=$trans['login_registeradvice']?></p>
                                    </div>
                                    <div class="col-12 text-center learts-mb-50">
                                        <button type="submit" class="btn btn-dark btn-outline-hover-dark"><?=$trans['login_registerregistrar']?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>