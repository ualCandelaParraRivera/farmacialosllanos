<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Promociones')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 15); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Promociones", "|adminpromos", $trans);?>
                    
                    <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Promociones
                                    <div class="btn-group ml-auto">
                                        <a href="admineditpromo" class="btn btn-sm btn-dark">
                                            Nueva promoción
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
                                                    <th>Código</th>
                                                    <th>Descripción</th>
                                                    <th>Descuento</th>
                                                    <th>Importe Mínimo</th>
                                                    <th>Descuento Máximo</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Fin</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT id
                                                ,promocode as codigo
                                                ,content as descripcion
                                                ,ROUND(discount*100,2) as descuento
                                                ,min as minimo
                                                ,max as maximo
                                                ,DATE_FORMAT(startDate, '%d/%m/%Y') as fechainicio
                                                ,DATE_FORMAT(endDate, '%d/%m/%Y') as fechafin
                                                ,guidpromo
                                                FROM promo
                                                WHERE isdeleted = 0";
                                                $res=$db->query($query);
                                                while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="prom-<?=$row['guidpromo']?>">
                                                    <td><?=$row['id']?></td>
                                                    <td><?=$row['codigo']?></td>
                                                    <td><?=$row['descripcion']?></td>
                                                    <td><?=$row['descuento']?>%</td>
                                                    <td><?=$row['minimo']?>€</td>
                                                    <td><?=$row['maximo']?>€</td>
                                                    <td><?=$row['fechainicio']?></td>
                                                    <td><?=$row['fechainicio']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditpromo?guidpromo=<?=$row['guidpromo']?>" class="btn btn-sm btn-outline-light">
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
                                                    <th>Código</th>
                                                    <th>Descripción</th>
                                                    <th>Descuento</th>
                                                    <th>Importe Mínimo</th>
                                                    <th>Descuento Máximo</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Fin</th>
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