<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    if(!isset($_POST['email'])){
        redirect($location_loginuser);
    }
    $email = $_POST['email'];
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/register.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|login|register", $trans);?>

    <div class="section section-padding pb-0">
        <div class="container">

            <div class="lost-password">
                <form id="frmRegistration" action="controller/register" method="post">
                    <div class="row learts-mb-n30">
                        <div class="col-md-6 col-12 learts-mb-30 form-group" id="firstname-group">
                            <div class="single-input-item">
                                <label for="firstname"><?=$trans['register_firstname']?> <abbr class="required">*</abbr></label>
                                <input type="text" class="form-control" id="firstname" name="firstname">
                            </div>
                        </div>
                        <div class="col-md-6 col-12 learts-mb-30 form-group" id="middlename-group">
                            <div class="single-input-item">
                                <label for="middlename"><?=$trans['register_middlename']?> <abbr class="required">*</abbr></label>
                                <input type="text" class="form-control" id="middlename" name="middlename">
                            </div>
                        </div>
                        <div class="col-md-6 col-12 learts-mb-30 form-group" id="lastname-group">
                            <label for="lastname"><?=$trans['register_lastname']?></label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <div class="col-md-6 col-12 learts-mb-30 form-group" id="mobile-group">
                            <label for="mobile"><?=$trans['register_mobile']?> <abbr class="required">*</abbr></label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                        </div>
                        <div class="col-12 learts-mb-30 form-group" id="email-group">
                            <label for="email"><?=$trans['register_email']?>  <abbr class="required">*</abbr></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?=$email?>" readonly>
                        </div>
                        <div class="col-md-6 col-12 learts-mb-30 form-group" id="newpass-group">
                            <label for="newpass"><?=$trans['register_newpass']?> <abbr class="required">*</abbr></label>
                            <input type="password" class="form-control" id="newpass" name="newpass">
                        </div>
                        <div class="col-md-6 col-12 learts-mb-30 form-group" id="confirmpass-group">
                            <label for="confirmpass"><?=$trans['register_confirmpass']?> <abbr class="required">*</abbr></label>
                            <input type="password" class="form-control" id="confirmpass" name="confirmpass">
                        </div>
                        <div class="col-12 learts-mb-40">
                            <div class="row learts-mb-n20">
                                <div class="col-12 learts-mb-20 form-group" id="accept-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="accept" name="accept">
                                        <label class="form-check-label" for="accept"><?=$trans['register_accept']?> <abbr class="required">*</abbr></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 learts-mb-30">
                            <div class="row learts-mb-n20">
                                <div class="col-6 learts-mb-20">
                                    <button type="submit" class="btn btn-dark btn-outline-hover-dark"><?=$trans['register_register']?></button>
                                </div>
                                <div class="col-6 learts-mb-20">
                                    <a href="login" class="fw-400"><?=$trans['register_haveaccount']?></a>
                                </div>
                            </div>
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