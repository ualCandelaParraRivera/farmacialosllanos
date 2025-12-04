<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Etiquetas')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 5); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Etiquetas", "|menucat|adminptags", $trans);?>
                    
                    <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Etiquetas de Productos
                                    <div class="btn-group ml-auto">
                                        <a href="admineditptag" class="btn btn-sm btn-dark">
                                            Nueva etiqueta
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
                                                    $query = "SELECT id, title as nombre, content as descripcion, metatitle as metadatos, guidtag FROM tag WHERE isdeleted = 0";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="ptag-<?=$row['guidtag']?>">
                                                    <td><?=$row['id']?></td>
                                                    <td><?=$row['nombre']?></td>
                                                    <td><?=$row['descripcion']?></td>
                                                    <td><?=$row['metadatos']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditptag?guidtag=<?=$row['guidtag']?>" class="btn btn-sm btn-outline-light">
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
                        <!-- ============================================================== -->
                        <!-- end data table  -->
                        <!-- ============================================================== -->
                    </div>
                </div>
            </div>
            <div class="cd-popup" role="alert"></div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php sectionfooter($trans);?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->

    <?php sectionjs();?>
</body>
 
</html>