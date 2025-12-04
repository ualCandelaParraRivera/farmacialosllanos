<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Marcas')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 7); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Marcas", "|menucat|adminbrands", $trans);?>
                    
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Marcas
                                    <div class="btn-group ml-auto">
                                        <a href="admineditbrand" class="btn btn-sm btn-dark">
                                            Nueva marca
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
                                                    <th>Introducción</th>
                                                    <th>Descripción</th>
                                                    <th>Artículos</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $query = "SELECT ltrim(replace(substring(substring_index(u.image, '.', 1), length(substring_index(u.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                                    ,ltrim(replace(substring(substring_index(u.image, '.', 2), length(substring_index(u.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                                    ,u.firstname as nombre
                                                    ,u.intro as introduccion
                                                    ,u.profile as descripcion
                                                    ,COUNT(p.id) as artículos
                                                    ,guiduser as guidbrand
                                                    FROM user u
                                                    LEFT JOIN product p ON p.userId = u.id AND p.isdeleted = 0
                                                    WHERE u.vendor = 1 AND u.isdeleted = 0
                                                    GROUP BY u.id";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="pbra-<?=$row['guidbrand']?>">
                                                    <td>
                                                        <div class="m-r-10"><img src="img/brands/<?=$row['imagename']?>.<?=$row['extension']?>" alt="user" class="rounded" width="45"></div>
                                                    </td>
                                                    <td><?=$row['nombre']?></td>
                                                    <td><?=$row['introduccion']?></td>
                                                    <td><?=$row['descripcion']?></td>
                                                    <td><?=$row['artículos']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditbrand?guidbrand=<?=$row['guidbrand']?>" class="btn btn-sm btn-outline-light">
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
                                                    <th>Introducción</th>
                                                    <th>Descripción</th>
                                                    <th>Artículos</th>
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