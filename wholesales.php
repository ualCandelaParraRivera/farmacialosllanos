<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    $query = "SELECT title
    ,summary
    ,guidwholesale
    ,ltrim(replace(substring(substring_index(w.image, '.', 1), length(substring_index(w.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
   ,ltrim(replace(substring(substring_index(w.image, '.', 2), length(substring_index(w.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
    FROM wholesale w
    LEFT JOIN wholesale_translation wt ON w.id = wt.wholesaleId
    WHERE wt.lang = '$lang' AND w.isdeleted = 0";
    $res=$db->query($query);
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|wholesales", $trans);?>

    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 learts-mb-n30">
                <?php 
                    while($row = mysqli_fetch_array($res)){
                        $title = $row['title'];
                        $summary = $row['summary'];
                        $guidwholesale = $row['guidwholesale'];
                        $imagename = $row['imagename'];
                        $extension = $row['extension'];
                ?>
                <div class="col learts-mb-30">
                    <div class="portfolio">
                        <div class="thumbnail"><img src="img/wholesale/<?=$imagename?>-370.<?=$extension?>" alt=""></div>
                        <div class="content">
                            <h4 class="title"><a href="wholesaledetails"><?=$title?></a></h4>
                            <div class="desc">
                                <p><?=$summary?></p>
                            </div>
                            <div class="link"><a href="wholesaledetails?guidwholesale=<?=$guidwholesale?>"><?=$trans['wholesales_readmore']?></a></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

        </div>

    </div>
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

<?php sectionjs();?>
</body>