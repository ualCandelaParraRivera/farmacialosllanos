<?php
include ("mainadmin.php");
if(isset($_POST['op'])){
    $op = $_POST['op'];
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $guid = substr($id, 5);
        $operation = substr($id,0,4);

        if($op == "pop"){
            $text = '';
            switch ($operation) {
                case 'pcat':
                    $query = "SELECT title as nombre
                    FROM category c
                    LEFT JOIN category_translation ct ON c.id = ct.categoryId AND ct.lang = 'es'
                    WHERE c.isdeleted = 0 AND guidcategory = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'ptag':
                    $query = "SELECT title as nombre FROM tag WHERE isdeleted = 0 AND guidtag = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'pbra':
                    $query = "SELECT u.firstname as nombre FROM user u WHERE u.isdeleted = 0 AND u.guiduser =  ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'prod':
                    $query = "SELECT pt.title as nombre
                    FROM product p
                    LEFT JOIN product_translation pt ON p.id = pt.productId
                    WHERE pt.lang = 'es' AND p.isdeleted = 0 AND p.guidproduct = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'pwho':
                    $query = "SELECT wt.title as nombre
                    FROM wholesale w
                    LEFT JOIN wholesale_translation wt ON w.id = wt.wholesaleId
                    WHERE wt.lang = 'es' AND guidwholesale = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'ucli':
                    $query = "SELECT CONCAT(firstname,' ',middlename) as nombre
                    FROM user
                    WHERE admin = 0 AND vendor = 0 AND isdeleted = 0 AND guiduser = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'uadm':
                    $query = "SELECT CONCAT(firstname,' ',middlename) as nombre
                    FROM user
                    WHERE admin = 1 AND vendor = 0 AND isdeleted = 0 AND guiduser = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'bpos':
                    $query = "SELECT p.title as nombre
                    FROM post p
                    WHERE p.isdeleted = 0 AND guidpost = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'bcat':
                    $query = "SELECT title as nombre
                    FROM postcategory c
                    WHERE c.isdeleted = 0 AND guidpostcategory = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'btag':
                    $query = "SELECT title as nombre FROM posttag WHERE isdeleted = 0 AND guidposttag = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'prom':
                    $query = "SELECT promocode as nombre FROM promo WHERE isdeleted = 0 AND guidpromo = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'ordr':
                    $query = "SELECT CONCAT('OR', LPAD(o.id, 5, 0)) as nombre FROM `order` o WHERE isdeleted = 0 AND guidorder = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                case 'patt':
                    $query = "SELECT CONCAT(`key`, ' - ', content) as nombre FROM product_meta WHERE isdeleted = 0 AND guidproductmeta = ?";
                    $res=$db->prepare($query, array($guid));
                    $row = mysqli_fetch_array($res);
                    $text = '<div class="cd-popup-container">
                                <p>¿Estás seguro que deseas borrar <strong>'.$row['nombre'].'</strong>?</p>
                                <ul class="cd-buttons">
                                    <li><a class="cd-popup-yes" data-value="'.$id.'" href="#0">Sí, seguro</a></li>
                                    <li><a class="cd-popup-no" href="#0">No, aún no</a></li>
                                </ul>
                                <a href="#0" class="cd-popup-close img-replace"></a>
                            </div>';
                    break;
                
                default:
                    break;
            }
            
            echo $text;
        }else if($op == "del"){
            
            switch ($operation) {
                case 'pcat':
                    $query = "UPDATE category SET isdeleted = 1 WHERE guidcategory = ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'ptag':
                    $query = "UPDATE tag SET isdeleted = 1 WHERE guidtag = ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'pbra':
                    $query = "UPDATE user SET isdeleted = 1 WHERE guiduser= ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'prod':
                    $query = "UPDATE product SET isdeleted = 1 WHERE guidproduct= ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'pwho':
                    $query = "UPDATE wholesale SET isdeleted = 1 WHERE guidwholesale= ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'ucli':
                    $query = "UPDATE user SET isdeleted = 1 WHERE guiduser= ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'uadm':
                    $query = "UPDATE user SET isdeleted = 1 WHERE guiduser= ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'bpos':
                    $query = "UPDATE post SET isdeleted = 1 WHERE guidpost= ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'bcat':
                    $query = "UPDATE postcategory SET isdeleted = 1 WHERE guidpostcategory= ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'btag':
                    $query = "UPDATE posttag SET isdeleted = 1 WHERE guidposttag = ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'prom':
                    $query = "UPDATE promo SET isdeleted = 1 WHERE guidpromo = ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'ordr':
                    $query = "UPDATE `order` SET isdeleted = 1 WHERE guidorder = ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                case 'patt':
                    $query = "UPDATE `product_meta` SET isdeleted = 1 WHERE guidproductmeta = ? AND isdeleted = 0";
                    $db->prepare($query, array($guid));
                    break;
                default:
                    break;
            }
            echo "deleted";
        }
    }
}


?>