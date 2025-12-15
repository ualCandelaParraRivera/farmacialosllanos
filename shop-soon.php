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
    <div class="section-404 section" data-bg-image="img/bg/bg-shopsoon.png">
        <div class="container">
            <div class="content-404">
                <h1 class="title"><?=$trans['shopsoon_title']?></h1>
                <h2 class="sub-title"><?=$trans['shopsoon_subtitle']?></h2>
                <p><?=$trans['shopsoon_text']?></p>
                <div class="buttons">
                    <a class="btn btn-primary btn-outline-hover-dark" href="javascript:history.go(-1)"><?=$trans['shopsoon_goback']?></a>
                    <a class="btn btn-dark btn-outline-hover-dark" href="index"><?=$trans['shopsoon_index']?></a>
                </div>
            </div>
        </div>
    </div>

    <?php sectionjs();?>
</body>