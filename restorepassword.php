<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    if (isset($_SESSION['usercode'])){
        header('location: '.$location_already_logged);
        exit;
      }
      if(!isset($_GET['token']) || !isset($_GET['guiduser'])){
        header('location: '.$location_403);
      }
      $token = $_GET['token'];
      $guiduser = $_GET['guiduser'];
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/restorepass.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|login|restorepassword", $trans);?>

    <div class="section section-padding">
        <div class="container">

            <div class="lost-password">
                <p><?=$trans['restorepass_text']?></p>
                <form id="frmRestore" action="controller/restorepass" method="post">
                    <div class="row learts-mb-n30">
                        <div class="col-12 learts-mb-30 form-group" id="newpass-group">
                            <label for="newpass"><?=$trans['restorepass_newpass']?></label>
                            <input id="newpass" name="newpass" class="form-control" type="password">
                        </div>
                        <div class="col-12 learts-mb-30 form-group" id="confirmpass-group">
                            <label for="confirmpass"><?=$trans['restorepass_confirmpass']?></label>
                            <input id="confirmpass" name="confirmpass" class="form-control" type="password">
                        </div>
                        <input id="guiduser" name="guiduser" value="<?=$guiduser?>" type="hidden">
                        <input id="token" name="token" value="<?=$token?>" type="hidden">
                        <div class="col-12 text-center learts-mb-30">
                            <button type="submit" class="btn btn-dark btn-outline-hover-dark"><?=$trans['restorepass_restore']?></button>
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