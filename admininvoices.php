<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Facturas')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 2); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Factura", "|admininvoices", $trans);?>
                    
                    <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Data Tables</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Total</th>
                                                    <th>Receptor</th>
                                                    <th>Email</th>
                                                    <th>País</th>
                                                    <th>Comunidad</th>
                                                    <th>Ciudad</th>
                                                    <th>Fecha</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    $query = "SELECT i.idinvoice
                                                    ,CONCAT('FR', LPAD(i.idinvoice, 5, 0)) as orderId
                                                    ,ROUND(i.grandTotal, 2) as total
                                                    ,i.email
                                                    ,CONCAT(i.billfirstname, ' ', i.billmiddlename) as user
                                                    ,i.billcountry
                                                    ,i.billprovince
                                                    ,i.billcity
                                                    ,DATE_FORMAT(i.createdAt, '%d/%m/%Y') as date
                                                    ,o.guidorder
                                                    FROM `invoice` i
                                                    INNER JOIN `order` o ON i.orderid = o.id
                                                    WHERE i.isdeleted = 0";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr>
                                                    <td><?=$row['orderId']?></td>
                                                    <td><?=$row['total']?>€</td>
                                                    <td><?=$row['user']?></td>
                                                    <td><?=$row['email']?></td>
                                                    <td><?=$row['billcountry']?></td>
                                                    <td><?=$row['billprovince']?></td>
                                                    <td><?=$row['billcity']?></td>
                                                    <td><?=$row['date']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admininvoicedetailpdf?guidorder=<?=$row['guidorder']?>" target="_blank" class="btn btn-sm btn-outline-light">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <a href="admininvoicedetail?guidorder=<?=$row['guidorder']?>" class="btn btn-sm btn-outline-light">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Total</th>
                                                    <th>Receptor</th>
                                                    <th>Email</th>
                                                    <th>País</th>
                                                    <th>Comunidad</th>
                                                    <th>Ciudad</th>
                                                    <th>Fecha</th>
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