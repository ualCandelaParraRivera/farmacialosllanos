<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Pedidos')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 1); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Pedidos", "|adminorders", $trans);?>

                    <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Pedidos
                                    <div class="btn-group ml-auto">
                                        <a href="admineditorder" class="btn btn-sm btn-dark">
                                            Nuevo pedido
                                            <i class="mleft-5 fas fa-plus"></i>
                                        </a>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered firstcol" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Estado</th>
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
                                                    $query = "SELECT o.id
                                                    ,CONCAT('OR', LPAD(o.id, 5, 0)) as orderId
                                                    ,CASE status WHEN 0 THEN 'Nuevo'
                                                        WHEN 1 THEN 'En revisión'
                                                        WHEN 2 THEN 'Pagado'
                                                        WHEN 3 THEN 'Fallido'
                                                        WHEN 4 THEN 'Enviado'
                                                        WHEN 5 THEN 'Reparto'
                                                        WHEN 6 THEN 'Devuelto'
                                                        WHEN 7 THEN 'Completado' END as status
                                                    ,ROUND(grandTotal, 2) as total
                                                    ,email
                                                    ,CONCAT(shipfirstname, ' ', shipmiddlename) as user
                                                    ,shipcountry
                                                    ,shipprovince
                                                    ,shipcity
                                                    ,DATE_FORMAT(createdAt, '%d/%m/%Y') as date
                                                    ,guidorder
                                                    FROM `order` o
                                                    WHERE o.id NOT IN (SELECT orderid FROM invoice)";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="ordr-<?=$row['guidorder']?>">
                                                    <td><?=$row['orderId']?></td>
                                                    <td><?=$row['status']?></td>
                                                    <td><?=$row['total']?>€</td>
                                                    <td><?=$row['user']?></td>
                                                    <td><?=$row['email']?></td>
                                                    <td><?=$row['shipcountry']?></td>
                                                    <td><?=$row['shipprovince']?></td>
                                                    <td><?=$row['shipcity']?></td>
                                                    <td><?=$row['date']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditorder?guidorder=<?=$row['guidorder']?>" class="btn btn-sm btn-outline-light">
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
                                                    <th>Estado</th>
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