<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Productos')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 8); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Wholesales", "|menucat|adminwholesales", $trans);?>
                    
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Wholesales
                                    <div class="btn-group ml-auto">
                                        <a href="admineditwholesale" class="btn btn-sm btn-dark">
                                            Nuevo wholesale
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
                                                    <th>Metadatos</th>
                                                    <th>Resumen</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $query = "SELECT ltrim(replace(substring(substring_index(w.image, '.', 1), length(substring_index(w.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                                    ,ltrim(replace(substring(substring_index(w.image, '.', 2), length(substring_index(w.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                                    ,wt.title as nombre
                                                    ,w.sku
                                                    ,wt.metatitle as metadatos
                                                    ,wt.summary as resumen
                                                    ,w.guidwholesale
                                                     FROM wholesale w
                                                    LEFT JOIN wholesale_translation wt ON w.id = wt.wholesaleId
                                                    WHERE wt.lang = 'es' AND w.isdeleted = 0";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="pwho-<?=$row['guidwholesale']?>">
                                                    <td>
                                                        <div class="m-r-10"><img src="img/wholesale/<?=$row['imagename']?>.<?=$row['extension']?>" alt="user" class="rounded" width="45"></div>
                                                    </td>
                                                    <td><?=$row['nombre']?></td>
                                                    <td><?=$row['sku']?></td>
                                                    <td><?=$row['metadatos']?></td>
                                                    <td><?=$row['resumen']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditwholesale?guidwholesale=<?=$row['guidwholesale']?>" class="btn btn-sm btn-outline-light">
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
                                                    <th>Metadatos</th>
                                                    <th>Resumen</th>
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