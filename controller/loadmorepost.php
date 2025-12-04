<?php
include_once("main.php");
$row = $_POST['row'];
$type = $_POST['type'];
$guid = $_POST['guid'];
$rowsperpage = $postperpage;

if($type == 1){
    $query = "SELECT p.title
    ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
    ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
    ,views
    ,SUBSTRING(p.content,1,100) as content
    ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
    ,guidpost
    FROM post p
    INNER JOIN post_category phc ON p.id = phc.postId
    INNER JOIN postcategory pc ON phc.categoryId = pc.id
    WHERE p.isdeleted = 0 AND pc.guidpostcategory = ?
    ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
    LIMIT $row,$rowsperpage";
    $res=$db->prepare($query, array($guid));
}else if($type == 2){
    $query = "SELECT p.title
    ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
    ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
    ,views
    ,SUBSTRING(p.content,1,100) as content
    ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
    ,guidpost
    FROM post p
    INNER JOIN post_tag pht ON p.id = pht.postId
    INNER JOIN posttag pt ON pht.tagId = pt.id
    WHERE p.isdeleted = 0 AND pt.guidposttag = ?
    ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
    LIMIT $row,$rowsperpage";
    $res=$db->prepare($query, array($guid));
}else if($type == 3){
    $query = "SELECT p.title
    ,ltrim(replace(substring(substring_index(p.image, '.', 1), length(substring_index(p.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
    ,ltrim(replace(substring(substring_index(p.image, '.', 2), length(substring_index(p.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
    ,views
    ,SUBSTRING(p.content,1,100) as content
    ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
    ,guidpost FROM post p
    INNER JOIN user u ON p.userId = u.id
    WHERE p.isdeleted=0 AND u.guiduser = ?
    ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
    LIMIT $row,$rowsperpage";
    $res=$db->prepare($query, array($guid));
}else{
    $query = "SELECT title
    ,ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
    ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
    ,views
    ,SUBSTRING(content,1,100) as content
    ,DATE_FORMAT(publishedAt, '%d/%m/%Y') as date 
    ,guidpost
    FROM post
    WHERE isdeleted = 0
    ORDER BY DATE_FORMAT(publishedAt, '%Y/%m/%d') DESC
    LIMIT $row,$rowsperpage";
    $res=$db->query($query);
}


$html = '';
while($row = mysqli_fetch_array($res)){
    $title = $row['title'];
    $imagename = $row['imagename'];
    $extension = $row['extension'];
    $content = html_entity_decode($row['content']);
    $views = $row['views'];
    $date = $row['date'];
    $guidpost = $row['guidpost'];
    $html.='<div class="col-12 border-bottom learts-pb-40 learts-mb-40 post">
    <div class="blog">
        <div class="row learts-mb-n30">
            <div class="col-md-5 col-12 learts-mb-30">
                <div class="image mb-0">
                    <a href="blogdetails?guidpost='.$guidpost.'"><img src="img/blog/'.$imagename.'.'.$extension.'" alt="Blog Image"></a>
                </div>
            </div>
            <div class="col-md-7 col-12 align-self-center learts-mb-30">
                <div class="content">
                    <ul class="meta">
                        <li><i class="far fa-calendar"></i><a href="blogdetails?guidpost='.$guidpost.'">'.$date.'</a></li>
                        <li><i class="far fa-eye"></i> '.$views.' '.$trans['blog_views'].'</li>
                    </ul>
                    <h5 class="title"><a href="blogdetails?guidpost='.$guidpost.'">'.$title.'</a></h5>
                    <div class="desc">
                        <p>'.$content.'…</p>
                    </div>
                    <a href="blogdetails?guidpost='.$guidpost.'" class="link">'.$trans['blog_readmore'].'</a>
                </div>
            </div>
        </div>
    </div>
</div>';
}
echo $html;
?>