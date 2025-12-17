<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");

if(!isset($_GET['guidorder'])){
    redirect(404);
}
$guidorder = $_GET['guidorder'];
$query = "SELECT o.id
,CONCAT('FR', LPAD(o.id, 5, 0)) as invoiceid
,DATE_FORMAT(createdAt, '%d/%m/%Y') as date
,CONCAT(billfirstname, ' ', billmiddlename) as user
,billline1 as address
,CONCAT(billpostalcode,', ',billcity,', ',billprovince,', ',billcountry) as city
,email
,billmobile as phone
,CONCAT(ROUND(subtotal, 2),'€') as subtotal
,CONCAT(ROUND(discount, 2),'€') as discount
,CONCAT(ROUND(tax, 2),'€') as tax
,CONCAT(ROUND(shipping, 2),'€') as shipping
,CONCAT(ROUND(grandTotal, 2),'€') as grandtotal
,guidorder
FROM `order` o
WHERE isdeleted = 0 AND guidorder = ?";
$res=$db->prepare($query, array($guidorder));
if($db->numRows($res) == 0){
    redirect("404");
}
$row = mysqli_fetch_array($res);
$invoiceid = $row['invoiceid'];
$date = $row['date'];
$user = $row['user'];
$address = $row['address'];
$city = $row['city'];
$email = $row['email'];
$phone = $row['phone'];
$subtotal = $row['subtotal'];
$discount = $row['discount'];
$tax = $row['tax'];
$shipping = $row['shipping'];
$grandtotal = $row['grandtotal'];

?>
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

                    <?php sectionbreadcrumb("Factura ".$invoiceid, "|admininvoices|admininvoicedetail", $trans);?>
                    
                    <div class="row">
                        <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header p-4" style="display: block;">
                                    <a class="pt-2 d-inline-block" href="index">Farmacia Los Llanos</a>
                                    <div class="float-right">
                                        <h3 class="mb-0">Factura #<?=$invoiceid?></h3>
                                        Fecha: <?=$date?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            <h5 class="mb-3">De:</h5>                                            
                                            <h3 class="text-dark mb-1">Farmacia Los Llanos S.L.</h3>
                                            <div>B-02910669</div>
                                            <div>C/ Potasio, 7</div>
                                            <div>Email: info@farmacialosllanos.org</div>
                                            <div>Teléfono: (+34) 950 33 70 53</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h5 class="mb-3">A:</h5>
                                            <h3 class="text-dark mb-1"><?=$user?></h3>                                            
                                            <div><?=$address?></div>
                                            <div><?=$city?></div>
                                            <div>Email: <?=$email?></div>
                                            <div>Teléfono: <?=$phone?></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive-sm">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th>SKU</th>
                                                    <th>Descripcion</th>
                                                    <th class="right">Precio Unitario</th>
                                                    <th class="right">Descuento</th>
                                                    <th class="center">Cantidad</th>
                                                    <th class="right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $query = "SELECT sku
                                                    ,oi.content as producto
                                                    ,CONCAT(ROUND(price,2),'€') as preciounitario
                                                    ,CONCAT(ROUND(oi.discount*100,2),'%') as descuento
                                                    ,quantity as cantidad
                                                    ,CONCAT(ROUND((1-oi.discount)*price*quantity, 2),'€') as subtotal
                                                    FROM `order` o
                                                    LEFT JOIN order_item oi ON o.id = oi.orderid
                                                    WHERE oi.isdeleted = 0 AND o.guidorder = ?";
                                                    $res=$db->prepare($query, array($guidorder));
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr>
                                                    <td class="center"><?=$i?></td>
                                                    <td class="left strong"><?=$row['sku']?></td>
                                                    <td class="left strong"><?=$row['producto']?></td>
                                                    <td class="left"><?=$row['preciounitario']?></td>
                                                    <td class="right"><?=$row['descuento']?></td>
                                                    <td class="center"><?=$row['cantidad']?></td>
                                                    <td class="right"><?=$row['subtotal']?></td>
                                                </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-lg-4 col-sm-5">
                                        </div>
                                        <div class="col-lg-4 col-sm-5 ml-auto">
                                            <table class="table table-clear">
                                                <tbody>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Subtotal</strong>
                                                        </td>
                                                        <td class="right"><?=$subtotal?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Promoción</strong>
                                                        </td>
                                                        <td class="right"><?=$discount?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Impuestos</strong>
                                                        </td>
                                                        <td class="right"><?=$tax?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Gastos de envío</strong>
                                                        </td>
                                                        <td class="right"><?=$shipping?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Total</strong>
                                                        </td>
                                                        <td class="right">
                                                            <strong class="text-dark"><?=$grandtotal?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <p class="mb-0">Farmacia Los Llanos S.L., B-02910669, C/ Potasio, 7</p>
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
</body>
 
</html>