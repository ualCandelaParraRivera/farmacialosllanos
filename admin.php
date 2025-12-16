<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Administración')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 0); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <?php sectionbreadcrumb("Dashboard", "|admin", $trans);?>
                    <div class="ecommerce-widget">

                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Ventas</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="card1value">-€</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-primary font-weight-bold" id="card1percentage">
                                            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>-%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Pedidos</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="card2value">-</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-primary font-weight-bold" id="card2percentage">
                                            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>-%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue2"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Valor Medio por Carrito</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="card3value">-€</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-primary font-weight-bold" id="card3percentage">
                                            <span>-</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Nuevos Clientes</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="card4value">-</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-primary font-weight-bold" id="card4percentage">
                                            <span>-%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Pedidos Recientes</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Nº</th>
                                                        <th class="border-0">Imagen</th>
                                                        <th class="border-0">Producto</th>
                                                        <th class="border-0">SKU</th>
                                                        <th class="border-0">Cantidad</th>
                                                        <th class="border-0">Precio</th>
                                                        <th class="border-0">Fecha Pedido</th>
                                                        <th class="border-0">Cliente</th>
                                                        <th class="border-0">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $query = "SELECT ltrim(replace(substring(substring_index(pi.image, '.', 1), length(substring_index(pi.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
                                                        ,ltrim(replace(substring(substring_index(pi.image, '.', 2), length(substring_index(pi.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
                                                        ,pt.title as productname
                                                        ,oi.sku
                                                        ,oi.quantity
                                                        ,ROUND((1-oi.discount)*price,2) as price
                                                        ,oi.createdAt
                                                        ,CONCAT(o.billfirstname, ' ', o.billmiddlename) as customer
                                                        ,CASE status WHEN 0 THEN 'Nuevo'
                                                            WHEN 1 THEN 'En revisión'
                                                            WHEN 2 THEN 'Pagado'
                                                            WHEN 3 THEN 'Fallido'
                                                            WHEN 4 THEN 'Enviado'
                                                            WHEN 5 THEN 'Reparto'
                                                            WHEN 6 THEN 'Devuelto'
                                                            WHEN 7 THEN 'Completado' END as status
                                                        ,status as statusid
                                                         FROM order_item oi
                                                        LEFT JOIN `order` o ON oi.orderID = o.id
                                                        LEFT JOIN product_translation pt ON pt.productId = oi.productId 
                                                        LEFT JOIN (SELECT productId, image FROM product_image WHERE isdeleted = 0 GROUP BY productId) pi ON pi.productId = oi.productId
                                                        WHERE pt.lang = 'es'
                                                        ORDER BY createdAt DESC
                                                        LIMIT 6";
                                                        $res=$db->query($query);
                                                        $cont = 1;
                                                        while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?=$cont?></td>
                                                        <td>
                                                            <div class="m-r-10"><img src="img/product/<?=$row['imagename']?>-widget.<?=$row['extension']?>" alt="user" class="rounded" width="45"></div>
                                                        </td>
                                                        <td><?=$row['productname']?> </td>
                                                        <td><?=$row['sku']?> </td>
                                                        <td><?=$row['quantity']?></td>
                                                        <td><?=$row['price']?>€</td>
                                                        <td><?=$row['createdAt']?></td>
                                                        <td><?=$row['customer']?> </td>
                                                        <td><span class="badge-dot badge-brand mr-1"></span><?=$row['status']?> </td>
                                                    </tr>
                                                    <?php $cont++; } ?>
                                                    <tr>
                                                        <td colspan="9"><a href="adminorders" class="btn btn-outline-light float-right">Ver Pedidos</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Pedidos por Día</h5>
                                    <div class="card-body">
                                        <div class="ct-chart ct-golden-section" style="height: 354px;"></div>
                                        <div class="text-center">
                                            <span class="legend-item mr-2">
                                                    <span class="fa-xs mr-1 legend-tile" style="color: #5fa77f"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">Registrados</span>
                                            </span>
                                            <span class="legend-item mr-2">

                                                    <span class="fa-xs mr-1 legend-tile" style="color: #476c5e"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">No Registrados</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Pedidos por Categorías</h5>
                                    <div class="card-body">
                                        <div class="ct-chart-category ct-golden-section" style="height: 315px;"></div>
                                        <div class="text-center m-t-40">
                                            <?php
                                            $query = "SELECT ct.title as category, COUNT(oi.id) as count FROM order_item oi
                                            LEFT JOIN `order` o ON oi.orderId = o.id 
                                            LEFT JOIN product_category pc ON oi.productId = pc.productId
                                            LEFT JOIN category c ON pc.categoryId = c.id
                                            LEFT JOIN category_translation ct ON c.id = ct.categoryId
                                            WHERE ct.lang = 'es' AND o.isdeleted = 0
                                            GROUP BY ct.title
                                            ORDER BY COUNT(oi.id) DESC";
                                            $res=$db->query($query);
                                            $cont = 0;
                                            $color = '5fa77f';
                                            while($row = mysqli_fetch_array($res)){
                                                $cont++;
                                                switch($cont){
                                                    case 1: $color = '5fa77f'; break;
                                                    case 2: $color = '476c5e'; break;
                                                    case 3: $color = 'f2cd5e'; break;
                                                    case 4: $color = 'f2ab27'; break;
                                                    case 5: $color = 'ffa47f'; break;
                                                    case 6: $color = 'b4f87b'; break;
                                                    case 7: $color = 'c4a9f0'; break;
                                                    case 8: $color = '6b0392'; break;
                                                    case 9: $color = 'f05b4f'; break;
                                                    case 10: $color = 'dda458'; break;
                                                    case 11: $color = 'eacf7d'; break;
                                                    case 12: $color = '86797d'; break;
                                                    case 13: $color = 'b2c326'; break;
                                                    case 14: $color = '6188e2'; break;
                                                    case 15: $color = 'a748ca'; break;

                                                }
                                            ?>
                                            <span class="legend-item mr-3">
                                                    <span class="fa-xs mr-1 legend-tile" style="color: #<?=$color?>"><i class="fa fa-fw fa-square-full "></i></span>
                                                    <span class="legend-text"><?=$row['category']?></span>
                                            </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"> Total Ventas Mensual</h5>
                                    <div class="card-body">
                                        <div id="morris_totalrevenue"></div>
                                    </div>
                                   
                                </div>
                            </div>

                        </div>

                        
                    </div>
                </div>
            </div>
            <?php sectionfooter($trans);?>
        </div>
    </div>

    <?php sectionjs();?>
    <script src="assets/libs/js/dashboard.js"></script>
</body>
 
</html>