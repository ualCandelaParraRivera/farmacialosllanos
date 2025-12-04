<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Categorías')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 6); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Categorías", "|menucat|adminattributes", $trans);?>
                    
                    <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Atributos de Productos
                                    <div class="btn-group ml-auto">
                                        <a href="admineditattributes" class="btn btn-sm btn-dark">
                                            Nuevo atributo
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
                                                    <th>Clave</th>
                                                    <th>Valor</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT id,
                                                `key` as clave
                                                ,content as valor
                                                ,guidproductmeta
                                                FROM product_meta
                                                WHERE isdeleted = 0";
                                                $res=$db->query($query);
                                                while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="patt-<?=$row['guidproductmeta']?>">
                                                    <td><?=$row['id']?></td>
                                                    <td><?=$row['clave']?></td>
                                                    <td><?=$row['valor']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditattributes?guidproductmeta=<?=$row['guidproductmeta']?>" class="btn btn-sm btn-outline-light">
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
                                                    <th>Clave</th>
                                                    <th>Valor</th>
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