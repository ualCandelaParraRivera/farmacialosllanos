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

    <div class="coming-soon-section section section-padding" data-bg-image="img/bg/coming-soon.png">
        <div class="container">
            <div class="coming-soon-content">
                <div class="logo">
                    <a href="index"><img src="img/logo/logof.png" alt="Hempleaf Logo"></a>
                </div>
                <h2 class="title"><?=$trans['comingsoon_title']?></h2>
                <div class="countdown3" data-countdown="2021/05/15"></div>
            </div>
        </div>
    </div>

    <?php sectionjs();?>
</body>