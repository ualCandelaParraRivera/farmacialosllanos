<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Productos')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 3); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Productos", "|menucat|adminproducts", $trans);?>
                    
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Productos
                                    <div class="btn-group ml-auto">
                                        <a href="admineditproduct" class="btn btn-sm btn-dark">
                                            Nuevo producto
                                            <i class="mleft-5 fas fa-plus"></i>
                                        </a>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Nombre</th>
                                                    <th>SKU</th>
                                                    <th>Precio</th>
                                                    <th>IVA</th>
                                                    <th>Descuento</th>
                                                    <th>Cantidad</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $query = "SELECT ltrim(replace(substring(substring_index(pi.image, '.', 1), length(substring_index(pi.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                                    ,ltrim(replace(substring(substring_index(pi.image, '.', 2), length(substring_index(pi.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                                    ,pt.title as nombre
                                                    ,p.sku
                                                    ,ROUND(p.price,2) as precio
                                                    ,ROUND(p.tax*100,2) as iva
                                                    ,ROUND(p.discount*100,2) as descuento
                                                    ,p.quantity as cantidad
                                                    ,p.guidproduct
                                                     FROM product p
                                                    LEFT JOIN product_translation pt ON p.id = pt.productId
                                                    LEFT JOIN product_image pi ON p.id = pi.productId
                                                    WHERE pt.lang = 'es' AND p.isdeleted = 0 AND pi.isdeleted = 0
                                                    GROUP BY p.id";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="prod-<?=$row['guidproduct']?>">
                                                    <td>
                                                        <div class="m-r-10"><img src="img/product/<?=$row['imagename']?>-widget.<?=$row['extension']?>" alt="user" class="rounded" width="45"></div>
                                                    </td>
                                                    <td><?=$row['nombre']?></td>
                                                    <td><?=$row['sku']?></td>
                                                    <td><?=$row['precio']?>€</td>
                                                    <td><?=$row['iva']?>%</td>
                                                    <td><?=$row['descuento']?>%</td>
                                                    <td><?=$row['cantidad']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditproduct?guidproduct=<?=$row['guidproduct']?>" class="btn btn-sm btn-outline-light">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-outline-light cd-popup-trigger">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Nombre</th>
                                                    <th>SKU</th>
                                                    <th>Precio</th>
                                                    <th>IVA</th>
                                                    <th>Descuento</th>
                                                    <th>Cantidad</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="cd-popup" role="alert"></div>
            <?php sectionfooter($trans);?>

        </div>
    </div>

    <?php sectionjs();?>
</body>
 
</html>