<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    if(!isset($_GET['guidpost'])){
        header("location: ".$location_404);
    }
    $guidpost = $_GET['guidpost'];
    $query = "SELECT p.title
    ,ltrim(replace(substring(substring_index(p.image, '.', 1), length(substring_index(p.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
    ,ltrim(replace(substring(substring_index(p.image, '.', 2), length(substring_index(p.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
    ,views
    ,p.content
    ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
    ,guidpost
    ,u.firstname
    ,u.middlename
    ,u.intro
    ,u.guiduser
    ,ltrim(replace(substring(substring_index(u.image, '.', 1), length(substring_index(u.image, '.', 1 - 1)) + 1), '.', '')) AS userimage
    ,ltrim(replace(substring(substring_index(u.image, '.', 2), length(substring_index(u.image, '.', 2 - 1)) + 1), '.', '')) AS userextension 
    
    ,u.instagram
    FROM post p
    LEFT JOIN user u ON p.userid = u.id
    WHERE p.guidpost = ?";
    $res=$db->prepare($query, array($guidpost));
    if($db->numRows($res)==0){
        redirect("404");
    }
    while($row = mysqli_fetch_array($res)){
        $title = $row['title'];
        $firstname = $row['firstname'];
        $middlename = $row['middlename'];
        $date = $row['date'];
        $views = $row['views'];
        $content = html_entity_decode($row['content']);
        $imagename = $row['imagename'];
        $extension = $row['extension'];
        $userimage = $row['userimage'];
        $userextension = $row['userextension'];
        $intro = $row['intro'];
        $guidpost = $row['guidpost'];
        $guiduser = $row['guiduser'];
        $instagram = $row['instagram'];
    }

    $query = "UPDATE post SET views=? WHERE guidpost = ?";
    $db->prepare($query, array($views+1, $guidpost));
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|blog|blogdetails", $trans);?>

    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row learts-mb-n50">

                <div class="col-xl-9 col-lg-8 col-12 learts-mb-50">
                    <div class="single-blog">
                        <div class="image">
                            <img src="img/blog/<?=$imagename?>.<?=$extension?>" alt="<?=$title?>">
                        </div>
                        <div class="content">
                            <ul class="category">
                            <?php 
                            $query = "SELECT pc.title, pc.guidpostcategory FROM postcategory pc
                            INNER JOIN post_category phc ON pc.id = phc.categoryId
                            INNER JOIN post p ON phc.postId = p.id
                            WHERE p.guidpost = ?";
                            $res=$db->prepare($query, array($guidpost));
                            while($row = mysqli_fetch_array($res)){
                            ?>
                                <li><a href="blog?guidpostcategory=<?=$row['guidpostcategory']?>"><?=$row['title']?></a></li>
                            <?php } ?>
                            </ul>
                            <h2 class="title"><?=$title?></h2>
                            <ul class="meta">
                                <li><i class="fal fa-user"></i> <?=$trans['blogdetails_by']?> <a href="blog?guiduser=<?=$guiduser?>"><?=$firstname?> <?=$middlename?></a></li>
                                <li><i class="far fa-calendar"></i><a href="#"><?=$date?></a></li>
                                <li><i class="far fa-eye"></i> <?=$views?> <?=$trans['blogdetails_views']?></li>
                            </ul>
                            <div class="desc">
                                <?=$content?>
                            </div>
                        </div>
                        <div class="blog-footer row no-gutters justify-content-between align-items-center">
                            <div class="col-auto">
                                <ul class="tags">
                                    <i class="icon fas fa-tags"></i>
                                    <?php 
                                    $query = "SELECT pt.title, pt.guidposttag FROM posttag pt
                                    INNER JOIN post_tag pht ON pt.id = pht.tagId
                                    INNER JOIN post p ON pht.postId = p.id
                                    WHERE p.guidpost = ?";
                                    $res=$db->prepare($query, array($guidpost));
                                    while($row = mysqli_fetch_array($res)){
                                    ?>
                                    <li><a href="blog?guidposttag=<?=$row['guidposttag']?>"><?=$row['title']?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <div class="post-share">
                                <?=$trans['blogdetails_share']?>
                                    <span class="toggle"><i class="fas fa-share-alt"></i></span>
                                    <ul class="social-list">
                                        <li class="hintT-top" data-hint="Facebook"><a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 'facebook-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-facebook-f"></i></a></li>
                                        <li class="hintT-top" data-hint="Twitter"><a href="#" onclick="window.open('http://twitter.com/intent/tweet/?url='+encodeURIComponent(location.href), 'twitter-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-twitter"></i></a></li>
                                        <li class="hintT-top" data-hint="Pinterest"><a href="#" onclick="window.open('http://pinterest.com/pin/create/button/?url='+encodeURIComponent(location.href), 'pinterest-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-pinterest-p"></i></a></li>
                                        <li class="hintT-top" data-hint="Email"><a href="mailto:?subject=Mira este artículo&amp;body=Puede que te resulte interesante%0D <?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>%0D"><i class="fal fa-envelope-open"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-author">
                        <div class="thumbnail">
                            <img src="img/team/<?=$userimage?>.<?=$userextension?>" alt="<?=$firstname?> <?=$middlename?>">
                        </div>
                        <div class="content">
                            <a href="blog?guiduser=<?=$guiduser?>" class="name"><?=$firstname?> <?=$middlename?></a>
                            <p><?=$intro?></p>
                            <div class="social">
                                
                                <a href="<?=$instagram?>"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        
                    </div>
                    <div class="related-blog">
                        <div class="block-title pb-0 border-bottom-0">
                            <h2 class="title"><?=$trans['blogdetails_related']?></h2>
                        </div>
                        <div class="row learts-mb-n40">
                        <?php 
                            $query = "SELECT * FROM (
                                SELECT DISTINCT p.title
                                    ,ltrim(replace(substring(substring_index(p.image, '.', 1), length(substring_index(p.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                    ,ltrim(replace(substring(substring_index(p.image, '.', 2), length(substring_index(p.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                    ,views
                                    ,SUBSTRING(p.content,1,100) as content
                                    ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
                                    ,guidpost FROM post p
                                INNER JOIN post_tag pht ON p.id = pht.postId
                                INNER JOIN posttag pt ON pht.tagId = pt.id
                                WHERE pt.guidposttag IN (SELECT guidposttag FROM posttag pt
                                INNER JOIN post_tag pht ON pt.id = pht.tagId
                                INNER JOIN post p ON pht.postId = p.id
                                WHERE p.guidpost = ?) AND p.isdeleted = 0
                                UNION
                                SELECT DISTINCT p.title
                                    ,ltrim(replace(substring(substring_index(p.image, '.', 1), length(substring_index(p.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                    ,ltrim(replace(substring(substring_index(p.image, '.', 2), length(substring_index(p.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                    ,views
                                    ,SUBSTRING(p.content,1,100) as content
                                    ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
                                    ,guidpost FROM post p
                                INNER JOIN post_tag pht ON p.id = pht.postId
                                INNER JOIN posttag pt ON pht.tagId = pt.id
                                WHERE pt.guidposttag NOT IN (SELECT guidposttag FROM posttag pt
                                INNER JOIN post_tag pht ON pt.id = pht.tagId
                                INNER JOIN post p ON pht.postId = p.id
                                WHERE p.guidpost = ?) AND p.isdeleted = 0
                                )as p 
                                WHERE guidpost <> ?
                                LIMIT 2";
                                $res=$db->prepare($query, array($guidpost,$guidpost,$guidpost));
                                while($row = mysqli_fetch_array($res)){
                                    $title = $row['title'];
                                    $imagename = $row['imagename'];
                                    $extension = $row['extension'];
                                    $content = $row['content'];
                                    $views = $row['views'];
                                    $date = $row['date'];
                                    $guidpost = $row['guidpost'];
                        ?>
                            <div class="col-md-6 col-12 learts-mb-40">
                                <div class="blog">
                                    <div class="image">
                                        <a href="blogdetails?guidpost=<?=$guidpost?>"><img src="img/blog/<?=$imagename?>.<?=$extension?>" alt="<?=$title?>"></a>
                                    </div>
                                    <div class="content">
                                        <ul class="meta">
                                            <li><i class="far fa-calendar"></i><a href="blogdetails?guidpost=<?=$guidpost?>"><?=$date?></a></li>
                                            <li><i class="far fa-eye"></i> <?=$views?> <?=$trans['blogdetails_views']?></li>
                                        </ul>
                                        <h5 class="title mb-0"><a href="blogdetails?guidpost=<?=$guidpost?>"><?=$title?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-12 learts-mb-10">
                    
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['blogdetails_recent']?></h3>
                        <ul class="widget-blogs">
                        <?php
                            $query = "SELECT title
                            ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                            ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                            ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
                            ,guidpost
                            FROM post
                            ORDER BY date DESC
                            LIMIT 3";
                            $res=$db->query($query);
                            while($row = mysqli_fetch_array($res)){
                                $title = $row['title'];
                                $imagename = $row['imagename'];
                                $extension = $row['extension'];
                                $date = $row['date'];
                                $guidpost = $row['guidpost'];
                        ?>
                        <li class="widget-blog">
                                <div class="thumbnail">
                                    <a href="blogdetails?guidpost=<?=$guidpost?>"><img src="img/blog/<?=$imagename?>.<?=$extension?>" alt="<?=$title?>"></a>
                                </div>
                                <div class="content">
                                    <h6 class="title"><a href="blogdetails?guidpost=<?=$guidpost?>"><?=$title?></a></h6>
                                    <span class="date"><?=$date?></span>
                                </div>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                    <div class="single-widget learts-mb-40">
                        <div class="widget-banner">
                            <img src="img/banner/widget-banner.png" alt="">
                        </div>
                    </div>
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['blogdetails_categories']?></h3>
                        <ul class="widget-list">
                        <?php
                            $query = "SELECT pc.title
                            ,pc.guidpostcategory
                            ,count(phc.postId) as count 
                            FROM postcategory pc
                            LEFT JOIN post_category phc ON pc.id = phc.categoryId
                            LEFT JOIN post p ON phc.postId = p.id
                            WHERE p.isdeleted = 0
                            GROUP BY title, guidpostcategory
                            ORDER BY count DESC
                            LIMIT 6";
                            $res=$db->query($query);
                            while($row = mysqli_fetch_array($res)){
                                $title = $row['title'];
                                $guidpostcategory = $row['guidpostcategory'];
                                $count = $row['count'];
                        ?>
                            <li><a href="blog?guidpostcategory=<?=$guidpostcategory?>"><?=$title?></a> <span class="count"><?=$count?></span></li>
                        <?php } ?>
                        </ul>
                    </div>
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['blogdetails_tags']?></h3>
                        <div class="widget-tags">
                        <?php
                            $query = "SELECT title, guidposttag, count(id) as count FROM posttag pt
                            LEFT JOIN post_tag pht ON pt.id = pht.tagId
                            WHERE pt.isdeleted = 0
                            GROUP BY title, guidposttag
                            ORDER BY count DESC
                            LIMIT 3";
                            $res=$db->query($query);
                            while($row = mysqli_fetch_array($res)){
                                $title = $row['title'];
                                $guidposttag = $row['guidposttag'];
                                $count = $row['count'];
                        ?>
                            <a href="blog?guidposttag=<?=$guidposttag?>"><?=$title?></a>
                        <?php } ?>
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