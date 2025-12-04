<?php include ("main.php");?>
<?php 
$guidproduct = $_POST['guidproduct'];

?>
        <!-- Product Images Start -->
        <div class="col-lg-6 col-12 learts-mb-30">
            <div class="product-images">
                <div class="product-gallery-slider-quickview">
                <?php 
                $query = "SELECT ltrim(replace(substring(substring_index(image, '.', 1), length(substring_index(image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                ,ltrim(replace(substring(substring_index(image, '.', 2), length(substring_index(image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                FROM product p
                LEFT JOIN product_image pi ON p.id = pi.productId
                WHERE p.guidproduct = ? AND pi.isdeleted = 0";
                
                $res=$db->prepare($query, array($guidproduct));
                while($row = mysqli_fetch_array($res)){
                    $imagename = $row['imagename'];
                    $extension = $row['extension'];
                ?>
                <div class="product-zoom" data-image="img/product/<?=$imagename?>-zoom.<?=$extension?>">
                        <img src="img/product/<?=$imagename?>.<?=$extension?>" alt="">
                    </div>
                <?php }?>
                </div> 
            </div>
        </div>
        <!-- Product Images End -->

        <!-- Product Summery Start -->
        <div class="col-lg-6 col-12 overflow-hidden learts-mb-30">
            <div class="product-summery customScroll">
            <?php 
                $query = "SELECT title, content, CONCAT(round(price,2),'€') as price, discount, guidproduct, CONCAT(round((1-discount)*price,2),'€') as finalprice,  customerrates, rating/customerrates/5*100 as rate
                FROM product p
                LEFT JOIN product_translation pt ON p.id = pt.productId
                LEFT JOIN (SELECT count(id) as customerrates, SUM(rating) as rating, productId FROM product_review GROUP BY productId)  pr ON p.id = pr.productId
                LEFT JOIN product_image pi ON p.id = pi.productId
                WHERE pt.lang = '$lang' AND p.guidproduct = ?";
                $res=$db->prepare($query, array($guidproduct));
                $row = mysqli_fetch_array($res);
                $title = $row['title'];
                $content = $row['content'];
                $price = $row['price'];
                $discount = $row['discount'];
                $finalprice = $row['finalprice'];
                $guidproduct = $row['guidproduct'];
                $customerrates = $row['customerrates'] == '' ? 0 : $row['customerrates'];
                $rate = $row['rate'] == '' ? 0 : $row['rate'];
                ?>
                <div class="product-ratings">
                    <span class="star-rating">
                    <span class="rating-active" style="width: <?=$rate?>%;">ratings</span>
                    </span>
                    <a href="#reviews" class="review-link">(<span class="count"><?=$customerrates?></span> <?=$trans['products_quickmodal_reviews']?>)</a>
                </div>
                <h3 class="product-title"><?=$title?></h3>
                <div class="product-price"><?php if($discount > 0){ echo '<span class="old">'.$price.'</span> - <span class="new">'.$finalprice.'</span>'; } else { echo $price; } ?></div>
                <div class="product-description">
                    <p><?=$content?></p>
                </div>
                <div class="product-variations">
                    <table>
                        <tbody>
                            <?php 
                            $query = "SELECT pm.key, GROUP_CONCAT(CONCAT('<a>',content,'</a>') SEPARATOR '') as content FROM product p
                            LEFT JOIN product_has_meta phm ON p.id = phm.productId
                            LEFT JOIN product_meta pm ON phm.metaid = pm.Id
                            WHERE p.guidproduct = ? AND pm.key <> 'video' AND pm.key <> 'color'
                            GROUP BY pm.key";

                            $res=$db->prepare($query, array($guidproduct));
                            while($row = mysqli_fetch_array($res)){
                                $key = $row['key'];
                                $content = $row['content'];
                            ?>
                            <tr>
                                <td class="label"><span><?=$key?></span></td>
                                <td class="value">
                                    <div class="product-sizes">
                                        <?=$content?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php 
                            $query = "SELECT pm.key, GROUP_CONCAT(CONCAT('<a style=\"background-color: ',content,';\" data-bg-color=\"',content,'\"></a>') SEPARATOR '') as content FROM product p
                            LEFT JOIN product_has_meta phm ON p.id = phm.productId
                            LEFT JOIN product_meta pm ON phm.metaid = pm.Id
                            WHERE p.guidproduct = ? AND pm.key = 'color'
                            GROUP BY pm.key";
                             $res=$db->prepare($query, array($guidproduct));
                             while($row = mysqli_fetch_array($res)){
                                 $key = $row['key'];
                                 $content = $row['content'];
                            ?>
                            <tr>
                                <td class="label"><span><?=$key?></span></td>
                                <td class="value">
                                    <div class="product-colors">
                                        <?=$content?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="product-brands">
                    <span class="title"><?=$trans['products_quickmodal_brands']?></span>
                    <div class="brands">
                        <?php
                        $query = "SELECT guiduser as guidbrand
                        ,ltrim(replace(substring(substring_index(u.image, '.', 1), length(substring_index(u.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                        ,ltrim(replace(substring(substring_index(u.image, '.', 2), length(substring_index(u.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                         FROM product p
                         LEFT JOIN user u ON p.userId = u.id
                         WHERE u.isdeleted = 0 AND u.vendor = 1 AND guidproduct = ?";
                        $res=$db->prepare($query, array($guidproduct));
                        while($row = mysqli_fetch_array($res)){
                        ?>
                        <a href="shop?guidbrand=<?=$row['guidbrand']?>"><img src="img/brands/<?=$row['imagename']?>.<?=$row['extension']?>" alt=""></a>
                        <?php } ?>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- Product Summery End -->


<?php ?>