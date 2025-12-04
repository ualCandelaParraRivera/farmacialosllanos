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

    <!-- 404 Section Start -->
    <div class="section-404 section" data-bg-image="img/bg/bg-404.png">
        <div class="container">
            <div class="content-404">
                <h1 class="title"><?=$trans['404_title']?></h1>
                <h2 class="sub-title"><?=$trans['404_subtitle']?></h2>
                <p><?=$trans['404_text']?></p>
                <div class="buttons">
                    <a class="btn btn-primary btn-outline-hover-dark" href="javascript:history.go(-1)"><?=$trans['404_goback']?></a>
                    <a class="btn btn-dark btn-outline-hover-dark" href="index"><?=$trans['404_index']?></a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 Section End -->

    <?php sectionjs();?>
</body>