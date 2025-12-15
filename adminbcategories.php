<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Categorías')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 12); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Categorías", "|menublog|adminbcategories", $trans);?>
                    
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Categorías de Post
                                    <div class="btn-group ml-auto">
                                        <a href="admineditbcat" class="btn btn-sm btn-dark">
                                            Nueva categoría
                                            <i class="mleft-5 fas fa-plus"></i>
                                        </a>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Metadatos</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT c.id
                                                ,title as nombre
                                                ,content as descripcion
                                                ,metatitle as metadatos
                                                ,guidpostcategory
                                                FROM postcategory c
                                                WHERE c.isdeleted = 0";
                                                $res=$db->query($query);
                                                while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="bcat-<?=$row['guidpostcategory']?>">
                                                    <td><?=$row['id']?></td>
                                                    <td><?=$row['nombre']?></td>
                                                    <td><?=$row['descripcion']?></td>
                                                    <td><?=$row['metadatos']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditbcat?guidpostcategory=<?=$row['guidpostcategory']?>" class="btn btn-sm btn-outline-light">
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
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Metadatos</th>
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