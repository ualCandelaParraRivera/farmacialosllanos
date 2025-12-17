<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
$rowsperpage = $postperpage;
$type = 0;
$guid = '';
    if(isset($_GET['guidpostcategory'])){
        $guidpostcategory = $_GET['guidpostcategory'];
        $type = 1;
        $guid = $guidpostcategory;
        $rowsperpage = $postperpage;
        $query = "SELECT count(p.id) as allcount
        FROM post p
        INNER JOIN post_category phc ON p.id = phc.postId
        INNER JOIN postcategory pc ON phc.categoryId = pc.id
        WHERE p.isdeleted = 0 AND pc.guidpostcategory = ?";
        $res=$db->prepare($query, array($guidpostcategory));
        $row = mysqli_fetch_array($res);
        $allcount = $row['allcount'];

        $query = "SELECT p.title
        ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
        ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
        ,views
        ,content as content
        ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
        ,guidpost
        FROM post p
        INNER JOIN post_category phc ON p.id = phc.postId
        INNER JOIN postcategory pc ON phc.categoryId = pc.id
        WHERE p.isdeleted = 0 AND pc.guidpostcategory = ?
        ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
        LIMIT 0,$rowsperpage";
        $res=$db->prepare($query, array($guidpostcategory));
    }else if(isset($_GET['guidposttag'])){
        $guidposttag = $_GET['guidposttag'];
        $type = 2;
        $guid = $guidposttag;
        $rowsperpage = $postperpage;
        $query = "SELECT count(p.id) as allcount
        FROM post p
        INNER JOIN post_tag pht ON p.id = pht.postId
        INNER JOIN posttag pt ON pht.tagId = pt.id
        WHERE p.isdeleted = 0 AND pt.guidposttag = ?
        ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC";
        $res=$db->prepare($query, array($guidposttag));
        $row = mysqli_fetch_array($res);
        $allcount = $row['allcount'];

        $query = "SELECT p.title
        ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
        ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
        ,views
        ,content as content
        ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
        ,guidpost
        FROM post p
        INNER JOIN post_tag pht ON p.id = pht.postId
        INNER JOIN posttag pt ON pht.tagId = pt.id
        WHERE p.isdeleted = 0 AND pt.guidposttag = ?
        ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
        LIMIT 0,$rowsperpage";
        $res=$db->prepare($query, array($guidposttag));
    }else if(isset($_GET['guiduser'])){
        $guiduser = $_GET['guiduser'];
        $type = 3;
        $guid = $guiduser;
        $rowsperpage = $postperpage;
        $query = "SELECT count(p.id) as allcount
        FROM post p
        INNER JOIN user u ON p.userId = u.id
        WHERE p.isdeleted=0 AND u.guiduser = ?
        ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC";
        $res=$db->prepare($query, array($guiduser));
        $row = mysqli_fetch_array($res);
        $allcount = $row['allcount'];

        $query = "SELECT p.title
        ,ltrim(replace(substring(substring_index(p.image, '.', 1), length(substring_index(p.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
        ,ltrim(replace(substring(substring_index(p.image, '.', 2), length(substring_index(p.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
        ,views
        ,content as content
        ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
        ,guidpost FROM post p
        INNER JOIN user u ON p.userId = u.id
        WHERE p.isdeleted=0 AND u.guiduser = ?
        ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
        LIMIT 0,$rowsperpage";
        $res=$db->prepare($query, array($guiduser));
    }else{
        $rowsperpage = $postperpage;
        $type = 0;
        $guid = '';
        $query = "SELECT count(id) as allcount
        FROM post
        WHERE isdeleted = 0";
        $res=$db->query($query);
        $row = mysqli_fetch_array($res);
        $allcount = $row['allcount'];

        $query = "SELECT title
        ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
        ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
        ,views
        ,content as content
        ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
        ,guidpost
        FROM post
        WHERE isdeleted = 0
        ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
        LIMIT 0,$rowsperpage";
        $res=$db->query($query);
    }
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/loadmorepost.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|blog", $trans);?>

    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row learts-mb-n50">

                <div class="col-xl-9 col-lg-8 col-12 learts-mb-50">
                    <div class="row no-gutters learts-mb-n40">
                        <?php
                            
                            while($row = mysqli_fetch_array($res)){
                                $title = $row['title'];
                                $imagename = $row['imagename'];
                                $extension = $row['extension'];
                                $content = substr(preg_replace( "/\n\s+/", "\n", rtrim(strip_tags(html_entity_decode($row['content'])))),0,100);
                                $views = $row['views'];
                                $date = $row['date'];
                                $guidpost = $row['guidpost'];
                        ?>
                        <div class="col-12 border-bottom learts-pb-40 learts-mb-40 post">
                            <div class="blog">
                                <div class="row learts-mb-n30">
                                    <div class="col-md-5 col-12 learts-mb-30">
                                        <div class="image mb-0">
                                            <a href="blogdetails?guidpost=<?=$guidpost?>"><img src="img/blog/<?=$imagename?>.<?=$extension?>" alt="Blog Image"></a>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-12 align-self-center learts-mb-30">
                                        <div class="content">
                                            <ul class="meta">
                                                <li><i class="far fa-calendar"></i><a href="blogdetails?guidpost=<?=$guidpost?>"><?=$date?></a></li>
                                                <li><i class="far fa-eye"></i> <?=$views?> <?=$trans['blog_views']?></li>
                                            </ul>
                                            <h5 class="title"><a href="blogdetails?guidpost=<?=$guidpost?>"><?=$title?></a></h5>
                                            <div class="desc">
                                                <p><?=$content?>…</p>
                                            </div>
                                            <a href="blogdetails?guidpost=<?=$guidpost?>" class="link"><?=$trans['blog_readmore']?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                    </div>
                    <?php if($allcount > $postperpage){?>
                    <div class="row learts-mt-50">
                        <div class="col text-center">
                            <a  class="btn btn-dark btn-outline-hover-dark load-more" id="loadmore"><?=$trans['blog_loadmore']?></a>
                            <input type="hidden" id="row" value="0">
                            <input type="hidden" id="postperpage" value="<?=$rowsperpage?>">
                            <input type="hidden" id="all" value="<?=$allcount?>">
                            <input type="hidden" id="type" value="<?=$type?>">
                            <input type="hidden" id="guid" value="<?=$guid?>">
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="col-xl-3 col-lg-4 col-12 learts-mb-10">

                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['blog_recentposts']?></h3>
                        <ul class="widget-blogs">
                        <?php
                            $query = "SELECT title
                            ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                            ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                            ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
                            ,guidpost
                            FROM post
                            ORDER BY publishedAt DESC
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
                                    <a href="blogdetails?guidpost=<?=$guidpost?>"><img src="img/blog/<?=$imagename?>-120.<?=$extension?>" alt="Widget Blog Post"></a>
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
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['blog_categories']?></h3>
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
                        <h3 class="widget-title product-filter-widget-title"><?=$trans['blog_tags']?></h3>
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