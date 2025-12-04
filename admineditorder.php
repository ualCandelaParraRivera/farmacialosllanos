<?php include("./controller/mainadmin.php");
$neworder = 1;
$headtext = "Nuevo Pedido";
$id = "";
$userid = "";
$registereduser = "";
$orderid = "";
// $statusid = "";
// $status = "";
// $subtotal = "";
// $tax = "";
// $shipping = "";
// $shippingtype = "";
// $weight = "";
// $total = "";
// $discount = "";
// $grandtotal = "";
// $promoid = "";
// $promocode = "";
// $email = "";
// $billfirstname = "";
// $billmiddlename = "";
// $billlastname = "";
// $billmobile = "";
// $billline1 = "";
// $billpostalcode = "";
// $billcity = "";
// $billprovince = "";
// $billcountry = "";
// $shipfirstname = "";
// $shipmiddlename = "";
// $shiplastname = "";
// $shipmobile = "";
// $shipline = "";
// $shippostalcode = "";
// $shipcity = "";
// $shipprovince = "";
// $shipcountry = "";
// $fecha = "";
// $notes = "";
// $guidorder = "";
$statusid = 0;
$ostatus = 'Nuevo';
$osubtotal = 0;
$otax = 0;
$oshipping = 0;
$oshippingtype = '';
$oweight = 0;
$ototal = 0;
$odiscount = 0;
$ograndtotal = 0;
$opromoid = '';
$promocode = '';
$oemail = '';
$obillfirstname = '';
$obillmiddlename = '';
$obilllastname = '';
$obillmobile = '';
$obillline1 = '';
$obillpostalcode = '';
$obillcity = '';
$obillprovince = '';
$obillcountry = '';
$oshipfirstname = '';
$oshipmiddlename = '';
$oshiplastname = '';
$oshipmobile = '';
$oshipline = '';
$oshippostalcode = '';
$oshipcity = '';
$oshipprovince = '';
$oshipcountry = '';
$fecha = '';
$notes = '';
$guidorder = ''; 

// $type = '0';

if (isset($_GET['guidorder'])) {
    $guidorder = $_GET['guidorder'];
    $query = "SELECT o.id
    ,CASE WHEN userid IS NULL THEN 0 ELSE userid END as userid
    ,CASE WHEN userid IS NULL THEN 'Usuario no registrado' ELSE CONCAT(u.firstname,' ',u.middlename) END as registereduser
    ,CONCAT('OR', LPAD(o.id, 5, 0)) as orderid
    ,status as statusid
    ,CASE status WHEN 0 THEN 'Nuevo'
        WHEN 1 THEN 'En revisión'
        WHEN 2 THEN 'Pagado'
        WHEN 3 THEN 'Fallido'
        WHEN 4 THEN 'Enviado'
        WHEN 5 THEN 'Reparto'
        WHEN 6 THEN 'Devuelto'
        WHEN 7 THEN 'Completado' END as status
    ,subtotal
    ,tax
    ,shipping
    ,shippingtype
    ,weight
    ,total
    ,o.discount
    ,grandtotal
    ,promoid
    ,promocode
    ,o.email
    ,o.billfirstname
    ,o.billmiddlename
    ,CASE WHEN o.billlastname IS NULL THEN '' ELSE o.billlastname END as billlastname
    ,o.billmobile
    ,o.billline1 as billline1
    ,CASE WHEN o.billpostalcode IS NULL THEN '' ELSE o.billpostalcode END as billpostalcode
    ,o.billcity
    ,o.billprovince
    ,o.billcountry
    ,o.shipfirstname
    ,o.shipmiddlename
    ,CASE WHEN o.shiplastname IS NULL THEN  '' ELSE o.shiplastname END as shiplastname
    ,o.shipmobile
    ,o.shipline
    ,CASE WHEN o.shippostalcode IS NULL THEN '' ELSE o.shippostalcode END as shippostalcode
    ,o.shipcity
    ,o.shipprovince
    ,o.shipcountry
    ,DATE_FORMAT(createdAt, '%Y-%m-%dT%H:%i') as fecha
    ,o.content as notes
    ,guidorder
    ,o.sessionId as sessionId
    ,o.token as token
    ,o.itemDiscount as itemDiscount
    ,o.createdAt as createdAt
    ,o.updatedAt as updatedAt
    ,o.content as content
    ,o.isdeleted as isdeleted
    FROM `order` o
    LEFT JOIN user u ON o.userid = u.id
    LEFT JOIN promo p ON o.promoid = p.id
    WHERE o.isdeleted = 0 AND guidorder = ?";
    $res = $db->prepare($query, array($guidorder));

    if ($db->numRows($res) > 0) {
        $neworder = 0;
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $ouserid = $row['userid'];
        $registereduser = $row['registereduser'];
        $orderid = $row['orderid'];
        $headtext = "Pedido ".$orderid;
        $statusid = $row['statusid'];
        $ostatus = $row['status'];
        $osubtotal = $row['subtotal'];
        $otax = $row['tax'];
        $oshipping = $row['shipping'];
        $oshippingtype = $row['shippingtype'];
        $oweight = $row['weight'];
        $ototal = $row['total'];
        $odiscount = $row['discount'];
        $ograndtotal = $row['grandtotal'];
        $opromoid = $row['promoid'];
        $promocode = $row['promocode'];
        $oemail = $row['email'];
        $obillfirstname = $row['billfirstname'];
        $obillmiddlename = $row['billmiddlename'];
        $obilllastname = $row['billlastname'];
        $obillmobile = $row['billmobile'];
        $obillline1 = $row['billline1'];
        $obillpostalcode = $row['billpostalcode'];
        $obillcity = $row['billcity'];
        $obillprovince = $row['billprovince'];
        $obillcountry = $row['billcountry'];
        $oshipfirstname = $row['shipfirstname'];
        $oshipmiddlename = $row['shipmiddlename'];
        $oshiplastname = $row['shiplastname'];
        $oshipmobile = $row['shipmobile'];
        $oshipline = $row['shipline'];
        $oshippostalcode = $row['shippostalcode'];
        $oshipcity = $row['shipcity'];
        $oshipprovince = $row['shipprovince'];
        $oshipcountry = $row['shipcountry'];
        $fecha = $row['fecha'];
        $notes = $row['notes'];
        $guidorder = $row['guidorder']; 

        $osessionId = $row['sessionId']; 
        $otoken = $row['token']; 
        $oitemDiscount = $row['itemDiscount']; 
        $ocreatedAt = $row['createdAt']; 
        $oupdatedAt = $row['updatedAt']; 
        $ocontent = $row['content']; 
        $oisdeleted = $row['isdeleted']; 
    }
}

?>
<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <?php sectionhead($headtext) ?>
    <script src="./ckeditor/ckeditor.js"></script>
    <link href="./css/multitags/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/editorder.js"></script>

</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 1); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menucat|adminorders|admineditorder", $trans); ?>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form action="controller/editorder" method="post" id="datospedido">
                                <input id="create" name="create" type="hidden" value="<?=$neworder?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidorder?>">
                                <input id="ostatus" name="ostatus" type="hidden" value="<?=$ostatus?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Pedido
                                        <div class="btn-group ml-auto">
                                            <button type="submit" class="btn btn-sm btn-dark">
                                                Guardar
                                                <i class="mleft-5 fas fa-save"></i>
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="orderid-group">
                                                            <label for="orderid" class="col-form-label">ID Pedido <abbr class="required">*</abbr></label>
                                                            <input id="orderid" name="orderid" type="text" class="form-control" value="<?=$orderid?>" readonly>
                                                        </div>
                                                    </div> 
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="fecha-group">
                                                            <label for="fecha" class="col-form-label">Fecha <abbr class="required">*</abbr></label>
                                                            <input id="fecha" name="fecha" type="datetime-local" class="form-control" value="<?=$fecha?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="statusid-group">
                                                            <label for="statusid" class="col-form-label">Estado <abbr class="required">*</abbr></label>
                                                            <select id="statusid" name="statusid" type="text" class="form-control" value="<?=$statusid?>">
                                                                <option value="-1">Selecciona un estado...</option>
                                                                <option value="0" <?php if($statusid == 0) { ?> selected <?php } ?>>Nuevo</option>
                                                                <option value="1" <?php if($statusid == 1) { ?> selected <?php } ?>>En revisión</option>
                                                                <option value="2" <?php if($statusid == 2) { ?> selected <?php } ?>>Pagado</option>
                                                                <option value="3" <?php if($statusid == 3) { ?> selected <?php } ?>>Fallido</option>
                                                                <option value="4" <?php if($statusid == 4) { ?> selected <?php } ?>>Enviado</option>
                                                                <option value="5" <?php if($statusid == 5) { ?> selected <?php } ?>>Reparto</option>
                                                                <option value="6" <?php if($statusid == 6) { ?> selected <?php } ?>>Devuelto</option>
                                                                <option value="7" <?php if($statusid == 7) { ?> selected <?php } ?>>Completado</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="userid-group">
                                                            <label for="userid" class="col-form-label">Usuario </label>
                                                            <select id="userid" name="userid" type="text" class="form-control" value="<?=$ouserid?>">
                                                                <option value="0" <?php if($userid == 0) { ?> selected <?php } ?>>Usuario no registrado</option>
                                                                <?php 
                                                                    $query = "SELECT id, CONCAT(firstname, ' ', middlename) as user FROM user WHERE admin = 0 AND vendor = 0 AND isdeleted = 0 ORDER BY CONCAT(firstname, ' ', middlename)";
                                                                    $res = $db->query($query);
                                                                    while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                    <option value="<?=$row['id']?>" <?php if($userid == $row['id']) { ?> selected <?php } ?>><?=$row['user']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="email-group">
                                                            <label for="email" class="col-form-label">Email <abbr class="required">*</abbr></label>
                                                            <input id="email" name="email" type="email" placeholder="correo@ejemplo.com" class="form-control" value="<?=$oemail?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Resumen</h5>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="subtotal-group">
                                                            <label for="subtotal" class="col-form-label">Subtotal (€)</label>
                                                            <input id="subtotal" name="subtotal" type="text" class="form-control" value="<?=$osubtotal?>" readonly>
                                                        </div>
                                                    </div> 
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="tax-group">
                                                            <label for="tax" class="col-form-label">Impuestos (€)</label>
                                                            <input id="tax" name="tax" type="text" class="form-control" value="<?=$otax?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipping-group">
                                                            <label for="shipping" class="col-form-label">Envío (€)</label>
                                                            <input id="shipping" name="shipping" type="text" class="form-control" value="<?=$oshipping?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="total-group">
                                                            <label for="total" class="col-form-label">Total (€)</label>
                                                            <input id="total" name="total" type="text" class="form-control" value="<?=$ototal?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>           
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="promocode-group">
                                                            <label for="promocode" class="col-form-label">Promoción</label>
                                                            <select id="promocode" name="promocode" type="text" class="form-control" onchange="applyPromo();">
                                                                <option value="0" <?php if($opromoid == '') { ?> selected <?php } ?>>Sin promoción</option>
                                                                <?php 
                                                                    $query = "SELECT id, promocode FROM promo WHERE isdeleted = 0";
                                                                    $res = $db->query($query);
                                                                    while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                    <option value="<?=$row['id']?>" <?php if($opromoid == $row['id']) { ?> selected <?php } ?>><?=$row['promocode']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="discount-group">
                                                            <label for="discount" class="col-form-label">Descuento (€)</label>
                                                            <input id="discount" name="discount" type="text" class="form-control" value="<?=$odiscount?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>           
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="grandtotal-group">
                                                            <label for="grandtotal" class="col-form-label">Importe final</label>
                                                            <input id="grandtotal" name="grandtotal" type="text" class="form-control" value="<?=$ograndtotal?>" readonly>
                                                        </div>
                                                    </div> 
                                                </div>           
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Desglose</h5>
                                        <div class="table-responsive form-group" id="table-group">
                                            <table id="example" class="table table-striped table-bordered first" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SKU</th>
                                                        <th>Producto</th>
                                                        <th>Precio unitario</th>
                                                        <th>Descuento</th>
                                                        <th>Cantidad</th>
                                                        <th>Subtotal</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tablebody">
                                                    <?php
                                                        $query = "SELECT sku
                                                        ,oi.productId
                                                        ,oi.content as productolinea
                                                        ,ROUND(price,2) as preciounitario
                                                        ,ROUND(oi.discount*100,2) as descuentolinea
                                                        ,quantity as cantidadlinea
                                                        ,ROUND((1-oi.discount)*price*quantity, 2) as subtotallinea
                                                        ,guidorderitem
                                                        FROM `order` o
                                                        LEFT JOIN order_item oi ON o.id = oi.orderid
                                                        WHERE oi.isdeleted = 0 AND o.id = ?";
                                                        $res=$db->prepare($query, array($id));
                                                        while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?=$row['productId']?></td>
                                                        <td><?=$row['sku']?></td>
                                                        <td><?=$row['productolinea']?></td>
                                                        <td><?=$row['preciounitario']?>€</td>
                                                        <td><?=$row['descuentolinea']?>%</td>
                                                        <td><?=$row['cantidadlinea']?></td>
                                                        <td><?=$row['subtotallinea']?>€</td>
                                                        <td>
                                                            <div class="btn-group ml-auto">
                                                                <a href="#addorderitem" data-toggle="collapse" class="btn btn-sm btn-outline-light" onclick="productDisplay(this);">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                                <button class="btn btn-sm btn-outline-light" onclick="productDelete(this);">
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
                                                        <th>SKU</th>
                                                        <th>Producto</th>
                                                        <th>Precio unitario</th>
                                                        <th>Descuento</th>
                                                        <th>Cantidad</th>
                                                        <th>Subtotal</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div id="orderitem">
                                            <a href="#addorderitem" data-toggle="collapse" class="btn btn-sm btn-dark" id="addorderitembtn">
                                                    Agregar <i class="mleft-5 fas fa-plus"></i>
                                            </a>
                                        </div>
                                        <div id="addorderitem" class="collapse learts-mt-30" data-parent="#orderitem">
                                            <div style="margin-top:20px">
                                                <p>Agrega un producto al pedido actual</p>
                                                <div class="row" id="additemrow">
                                                    <div class="col-md-3 col-3 learts-mb-20 form-group" id="producto-group">
                                                        <label for="producto">Producto <abbr class="required">*</abbr></label>
                                                        <select id="producto" name="producto" type="text" class="form-control">
                                                            <option value="">Seleccione producto...</option>
                                                            <?php
                                                                $query = "SELECT p.id
                                                                ,pt.title
                                                                FROM product p 
                                                                LEFT JOIN product_translation pt ON p.id = pt.productId
                                                                WHERE pt.lang = 'es' AND isdeleted = 0";
                                                                $res=$db->query($query);
                                                                while($row = mysqli_fetch_array($res)){
                                                            ?>
                                                                <option value="<?=$row['id']?>"><?=$row['title']?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-3 learts-mb-20 form-group" id="cantidad-group">
                                                        <label for="cantidad">Cantidad <abbr class="required">*</abbr></label>
                                                        <input type="number" class="form-control" value="1" name="cantidad" id="cantidad">
                                                    </div>
                                                </div>
                                                <div class="col-12 learts-mb-20 form-group">
                                                    <button data-toggle="collapse" type="button" class="btn btn-dark btn-outline-hover-dark learts-mb-10" id="updateButton" onclick="productUpdate();">Agregar al pedido</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Dirección de Facturación</h5>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billfirstname-group">
                                                            <label for="billfirstname" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                            <input id="billfirstname" name="billfirstname" type="text" class="form-control" value="<?=$obillfirstname?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billmiddlename-group">
                                                            <label for="billmiddlename" class="col-form-label">Primer Apellido <abbr class="required">*</abbr></label>
                                                            <input id="billmiddlename" name="billmiddlename" type="text" class="form-control" value="<?=$obillmiddlename?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billlastname-group">
                                                            <label for="billlastname" class="col-form-label">Segundo Apellido </label>
                                                            <input id="billlastname" name="billlastname" type="text" class="form-control" value="<?=$obilllastname?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billmobile-group">
                                                            <label for="billmobile" class="col-form-label">Teléfono <abbr class="required">*</abbr></label>
                                                            <input id="billmobile" name="billmobile" type="text" class="form-control" value="<?=$obillmobile?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billcountry-group">
                                                            <label for="billcountry" class="col-form-label">País <abbr class="required">*</abbr></label>
                                                            <select id="billcountry" name="billcountry" class="select2-basic form-control">
                                                                <option value="">Seleccione un país...</option>
                                                                <?php 
                                                                $query = "SELECT name, id FROM countries ORDER BY name";
                                                                $res=$db->query($query);
                                                                while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                <option value="<?=$row['name']?>" <?php if($row['name']==$obillcountry) echo "selected";?>><?=$row['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                    <div class="form-group" id="billdistrict-group">
                                                            <label for="billdistrict" class="col-form-label">Comunidad Autónoma <abbr class="required">*</abbr></label>
                                                            <select id="billdistrict" name="billdistrict" class="select2-basic form-control">
                                                                <option value="">Seleccione una comunidad...</option>
                                                            <?php 
                                                                $query = "SELECT r.id, r.name FROM regions r
                                                                INNER JOIN countries c ON r.country_id = c.id
                                                                WHERE c.name = ? ORDER BY name";
                                                                $res=$db->prepare($query,array($obillcountry));
                                                                while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                <option value="<?=$row['name']?>" <?php if($row['name']==$obillprovince) echo "selected";?>><?=$row['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billcity-group">
                                                            <label for="billcity" class="col-form-label">Ciudad <abbr class="required">*</abbr></label>
                                                            <input id="billcity" name="billcity" type="text" class="form-control" value="<?=$obillcity?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billaddress-group">
                                                            <label for="billaddress" class="col-form-label">Dirección <abbr class="required">*</abbr></label>
                                                            <input id="billaddress" name="billaddress" type="text" class="form-control" value="<?=$obillline1?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="billpostalcode-group">
                                                            <label for="billpostalcode" class="col-form-label">Código Postal</label>
                                                            <input id="billpostalcode" name="billpostalcode" type="text" class="form-control" value="<?=$obillpostalcode?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Dirección de Envío</h5>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipfirstname-group">
                                                            <label for="shipfirstname" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                            <input id="shipfirstname" name="shipfirstname" type="text" class="form-control" value="<?=$oshipfirstname?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipmiddlename-group">
                                                            <label for="shipmiddlename" class="col-form-label">Primer Apellido <abbr class="required">*</abbr></label>
                                                            <input id="shipmiddlename" name="shipmiddlename" type="text" class="form-control" value="<?=$oshipmiddlename?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shiplastname-group">
                                                            <label for="shiplastname" class="col-form-label">Segundo Apellido </label>
                                                            <input id="shiplastname" name="shiplastname" type="text" class="form-control" value="<?=$oshiplastname?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipmobile-group">
                                                            <label for="shipmobile" class="col-form-label">Teléfono <abbr class="required">*</abbr></label>
                                                            <input id="shipmobile" name="shipmobile" type="text" class="form-control" value="<?=$oshipmobile?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipcountry-group">
                                                            <label for="shipcountry" class="col-form-label">País <abbr class="required">*</abbr></label>
                                                            <select id="shipcountry" name="shipcountry" class="select2-basic form-control">
                                                                <option value="">Seleccione un país...</option>
                                                                <?php 
                                                                $query = "SELECT name, id FROM countries ORDER BY name";
                                                                $res=$db->query($query);
                                                                while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                <option value="<?=$row['name']?>" <?php if($row['name']==$oshipcountry) echo "selected";?>><?=$row['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                    <div class="form-group" id="shipdistrict-group">
                                                            <label for="shipdistrict" class="col-form-label">Comunidad Autónoma <abbr class="required">*</abbr></label>
                                                            <select id="shipdistrict" name="shipdistrict" class="select2-basic form-control">
                                                                <option value="">Seleccione una comunidad...</option>
                                                            <?php 
                                                                $query = "SELECT r.id, r.name FROM regions r
                                                                INNER JOIN countries c ON r.country_id = c.id
                                                                WHERE c.name = ? ORDER BY name";
                                                                $res=$db->prepare($query,array($oshipcountry));
                                                                while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                <option value="<?=$row['name']?>" <?php if($row['name']==$oshipprovince) echo "selected";?>><?=$row['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipcity-group">
                                                            <label for="shipcity" class="col-form-label">Ciudad <abbr class="required">*</abbr></label>
                                                            <input id="shipcity" name="shipcity" type="text" class="form-control" value="<?=$oshipcity?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipaddress-group">
                                                            <label for="shipaddress" class="col-form-label">Dirección <abbr class="required">*</abbr></label>
                                                            <input id="shipaddress" name="shipaddress" type="text" class="form-control" value="<?=$oshipline?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shippostalcode-group">
                                                            <label for="shippostalcode" class="col-form-label">Código Postal</label>
                                                            <input id="shippostalcode" name="shippostalcode" type="text" class="form-control" value="<?=$oshippostalcode?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Método de Envío</h5>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="peso-group">
                                                            <label for="peso" class="col-form-label">Peso Total (gr)</label>
                                                            <input id="peso" name="peso" type="text" class="form-control" value="<?=$oweight?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="shipmentplan-group">
                                                            <label for="shipmentplan" class="col-form-label">Plan de transporte <abbr class="required">*</abbr></label>
                                                            <select id="shipmentplan" name="shipmentplan" class="select2-basic form-control">
                                                                <option value="">Seleccione un método de envío...</option>
                                                                <?php 
                                                                $isles = ($shipprovince == 'Canarias' || $shipprovince == 'Islas Baleares') ? $oshipprovince : '';
                                                                $query = "SELECT UPPER(type) as name, type, shipping
                                                                FROM envio
                                                                WHERE ? BETWEEN minweight AND maxweight AND isles = ?
                                                                GROUP BY type, isles";
                                                                $res=$db->prepare($query, array($oweight, $isles));
                                                                while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                <option value="<?=$row['type']?>" <?php if($row['type']==$oshippingtype) echo "selected";?>><?=$row['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Notas del Pedido</h5>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group" id="notes-group">
                                                        <label for="notes" class="col-form-label">Notas </label>
                                                            <textarea id="notes" name="notes" class="form-control" rows="4"><?=$notes?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php sectionfooter($trans); ?>

        </div>

    </div>

    <?php sectionjs(); ?>

<script>
    $(document).ready(function(){
        $("#addorderitembtn").click(function(){
            $("#updateButton").text("Agregar al pedido");
            formClear();
        });
    });

    $('#billcountry').on('change', function() {
        console.log($(this).val());
        var country = $(this).val();
        if (country) {
            $.ajax({
                type: 'POST',
                url: 'controller/loaddataselect',
                data: {
                    'country': country
                },
                success: function(html) {
                    $('#billdistrict').html(html);
                    // $('#billdistrict').niceSelect('update');
                }
            });
        } else {
            $('#billdistrict').html('<option value="">Selecciona un pais...</option>');
            // $('#billdistrict').niceSelect('update');
        }
    });

    $('#shipcountry').on('change', function() {
        console.log($(this).val());
        var country = $(this).val();
        if (country) {
            $.ajax({
                type: 'POST',
                url: 'controller/loaddataselect',
                data: {
                    'country': country
                },
                success: function(html) {
                    $('#shipdistrict').html(html);
                }
            });
        } else {
            $('#shipdistrict').html('<option value="">Selecciona un pais...</option>');
        }
    });

    $('#shipdistrict').on('change', function() {
        console.log($(this).val());
        var district = $(this).val();
        var weight = $("#peso").val();
        if (district) {
            $.ajax({
                type: 'POST',
                url: 'controller/loadshipmentselect2',
                data: {
                    'district': district, 'weight': weight
                },
                success: function(html) {
                    $('#shipmentplan').html(html);
                    $("#shipmentplan").prop("disabled", false);
                }
            });
        } else {
            $('#shipmentplan').html('<option value="">Selecciona una comunidad...</option>');
            $("#shipmentplan").prop("disabled", true);
        }
    });

    $('#shipmentplan').on('change', function() {
        console.log($(this).val());
        var shipmenttype = $(this).val();
        var weight = $("#peso").val();
        var subtotal = parseFloat($("#subtotal").val());
        var tax = parseFloat($("#tax").val());
        var discount = parseFloat($("#discount").val());
        if (shipmenttype) {
            $.ajax({
                type: 'POST',
                url: 'controller/loadshippingprice',
                data: {
                    'shipmenttype': shipmenttype, 'weight': weight, 'subtotal': subtotal, 'tax': tax, 'discount': discount
                },
                success: function(data) {
                    console.log(data);
                    var x = JSON.parse(data);
                    $('#shipping').val(x.ship.toFixed(2));
                    $('#total').val(x.total.toFixed(2));
                    $('#grandtotal').val(x.grandtotal.toFixed(2));
                }
            });
        } else {
            $('#shipping').val(0);
            $('#total').val((subtotal+tax).toFixed(2));
            $('#grandtotal').val((subtotal+tax-discount).toFixed(2));
        }
    });

    var editRow = null;

    function applyPromo(){
        var promocode = $("#promocode").val();
        var total = $("#total").val();
        var subtotal = $("#subtotal").val();
        var tax = $("#tax").val();
        var shipping = $("#shipping").val();
        $.ajax({
            type 		: 'POST',
            url 		: 'controller/getorderitem',
            data 		: {op: "promo", promocode: promocode, subtotal: subtotal, tax: tax, shipping: shipping }
        })
        .done(function(data) {
            x = JSON.parse(data);
            $("#discount").val(x.promodescuento.toFixed(2));
            $("#grandtotal").val(x.importefinal.toFixed(2));
        })
    }

    function productDisplay(ctl) {
      editRow = $(ctl).parents("tr");
      var cols = editRow.children("td");
      $("#producto").val($(cols[0]).text());
      $("#cantidad").val($(cols[5]).text());
      $("#updateButton").text("Actualizar");
    }

    function productUpdate() {
      if ($("#updateButton").text() == "Actualizar") {
        productUpdateInTable();
      } else {
        productAddToTable();
      }
      $("#producto").focus();
    }

    function productAddToTable() {
        productAddBuildTableRow();
    }

    function productUpdateInTable() {
        productUpdateBuildTableRow();
    }

    function productAddBuildTableRow() {
        var id = $("#producto").val();
        var qty = $("#cantidad").val();
        var promo = $("#promocode").val();
        var table = $("#example");
        var trs = document.querySelectorAll('#tablebody tr');
        var datas = [];
        for (i = 0; i < trs.length; i++) {
            cells = trs[i].cells;
            if(cells.length > 6){
                datas.push([cells[0].innerText, cells[5].innerText]);
            }
            
        }

        var ret = "";
        $.ajax({
            type 		: 'POST',
            url 		: 'controller/getorderitem',
            data 		: {op: "add", id: id, qty: qty, datas: datas, promo: promo}
        })
        .done(function(data) {
            x = JSON.parse(data);
            $('.form-group').removeClass('is-invalid');
            $('.form-control').removeClass('is-invalid');
            $('.help-block').remove();
            $('.alert').remove();
            if(x.errorproduct){
                $('#producto').addClass('is-invalid');
                $('#producto-group').append('<div class="help-block">' + x.errorproduct + '</div>');
            }else if(x.errorquantity){
                $('#cantidad').addClass('is-invalid');
                $('#cantidad-group').append('<div class="help-block">' + x.errorquantity + '</div>');
            }else{
                ret =
                "<tr>"+
                    "<td>"+x.id+"</td>"+
                    "<td>"+x.sku+"</td>"+
                    "<td>"+x.product+"</td>"+
                    "<td>"+x.price+"€</td>"+
                    "<td>"+x.discount+"%</td>"+
                    "<td>"+x.quantity+"</td>"+
                    "<td>"+x.subtotal+"€</td>"+
                    "<td>"+
                        "<div class='btn-group ml-auto'>"+
                            "<a href='#addorderitem' data-toggle='collapse' class='btn btn-sm btn-outline-light' onclick='productDisplay(this);'>"+
                                "<i class='fas fa-pencil-alt'></i>"+
                            "</a>"+
                            "<button class='btn btn-sm btn-outline-light' onclick='productDelete(this);'>"+
                                "<i class='fas fa-trash-alt'></i>"+
                            "</button>"+
                        "</div>"+
                    "</td>"+
                "</tr>";
                $(".dataTables_empty").parents("tr").remove();
                $("#example tbody").append(ret);
                $("#subtotal").val(x.sumsubtotal.toFixed(2));
                $("#tax").val(x.sumimpuestos.toFixed(2));
                $("#peso").val(x.weight);
                $("#envio").val(x.sumenvio.toFixed(2));
                $("#total").val(x.sumtotal.toFixed(2));
                $("#discount").val(x.promodescuento.toFixed(2));
                $("#grandtotal").val(x.importefinal.toFixed(2));
                formClear();
                $("#addorderitem").collapse('hide');
            }
            
        })
    }

    function productUpdateBuildTableRow() {
        var id = $("#producto").val();
        var qty = $("#cantidad").val();
        var promo = $("#promocode").val();
        var table = $("#example");
        var cols = editRow.children("td");
        remid = $(cols[0]).text();
        remqty = $(cols[5]).text();
        var trs = document.querySelectorAll('#tablebody tr');
        var datas = [];
        for (i = 0; i < trs.length; i++) {
            cells = trs[i].cells;
            if(cells.length > 6){
                datas.push([cells[0].innerText, cells[5].innerText]);
            }
        }
        
        var ret = "";
        $.ajax({
            type 		: 'POST',
            url 		: 'controller/getorderitem',
            data 		: {op: "edit", id: id, qty: qty, datas: datas, promo: promo, remid: remid, remqty: remqty}
        })
        .done(function(data) {
            x = JSON.parse(data);
            $('.form-group').removeClass('is-invalid');
            $('.form-control').removeClass('is-invalid');
            $('.help-block').remove();
            $('.alert').remove();
            if(x.errorproduct){
                $('#producto').addClass('is-invalid');
                $('#producto-group').append('<div class="help-block">' + x.errorproduct + '</div>');
            }else if(x.errorquantity){
                $('#cantidad').addClass('is-invalid');
                $('#cantidad-group').append('<div class="help-block">' + x.errorquantity + '</div>');
            }else{
                ret =
                "<tr>"+
                    "<td>"+x.id+"</td>"+
                    "<td>"+x.sku+"</td>"+
                    "<td>"+x.product+"</td>"+
                    "<td>"+x.price+"€</td>"+
                    "<td>"+x.discount+"%</td>"+
                    "<td>"+x.quantity+"</td>"+
                    "<td>"+x.subtotal+"€</td>"+
                    "<td>"+
                        "<div class='btn-group ml-auto'>"+
                            "<a href='#addorderitem' data-toggle='collapse' class='btn btn-sm btn-outline-light' onclick='productDisplay(this);'>"+
                                "<i class='fas fa-pencil-alt'></i>"+
                            "</a>"+
                            "<button class='btn btn-sm btn-outline-light' onclick='productDelete(this);'>"+
                                "<i class='fas fa-trash-alt'></i>"+
                            "</button>"+
                        "</div>"+
                    "</td>"+
                "</tr>";
                $(editRow).after(ret);
                $(editRow).remove();
                formClear();
                $("#subtotal").val(x.sumsubtotal.toFixed(2));
                $("#tax").val(x.sumimpuestos.toFixed(2));
                $("#peso").val(x.weight);
                $("#envio").val(x.sumenvio.toFixed(2));
                $("#total").val(x.sumtotal.toFixed(2));
                $("#discount").val(x.promodescuento.toFixed(2));
                $("#grandtotal").val(x.importefinal.toFixed(2));
                formClear();
                $("#addorderitem").collapse('hide');
            }
            
        })
    }

    function formClear() {
      $("#producto").val("");
      $("#cantidad").val("1");
    }

    function productDelete(ctl) {
        editRow = $(ctl).parents("tr");
        editRow.remove();
        var promo = $("#promocode").val();
        var table = $("#example");
        var cols = editRow.children("td");
        var trs = document.querySelectorAll('#tablebody tr');
        var datas = [];
        for (i = 0; i < trs.length; i++) {
            cells = trs[i].cells;
            if(cells.length > 6){
                datas.push([cells[0].innerText, cells[5].innerText]);
            }
        }

        $.ajax({
            type 		: 'POST',
            url 		: 'controller/getorderitem',
            data 		: {op: "rem", datas: datas, promo: promo}
        })
        .done(function(data) {
            x = JSON.parse(data);
            $('.form-group').removeClass('is-invalid');
            $('.form-control').removeClass('is-invalid');
            $('.help-block').remove();
            $('.alert').remove();
            if(x.errorproduct){
                $('#producto').addClass('is-invalid');
                $('#producto-group').append('<div class="help-block">' + x.errorproduct + '</div>');
            }else if(x.errorquantity){
                $('#cantidad').addClass('is-invalid');
                $('#cantidad-group').append('<div class="help-block">' + x.errorquantity + '</div>');
            }else{
                $(editRow).remove();
                formClear();
                if(x.sumsubtotal == 0){
                    var ret = '<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No hay información</td></tr>'
                    $("#example tbody").append(ret);
                }
                $("#subtotal").val(x.sumsubtotal.toFixed(2));
                $("#tax").val(x.sumimpuestos.toFixed(2));
                $("#peso").val(x.weight);
                $("#envio").val(x.sumenvio.toFixed(2));
                $("#total").val(x.sumtotal.toFixed(2));
                $("#discount").val(x.promodescuento.toFixed(2));
                $("#grandtotal").val(x.importefinal.toFixed(2));
                formClear();
                $("#addorderitem").collapse('hide');
            }
            
        })
    }

    function setSelectBoxByText(etxt) {
        var eid = document.getElementById("producto");
        for (var i = 0; i < eid.options.length; ++i) {
            if (eid.options[i].text === etxt)
                eid.options[i].selected = true;
        }
    }
 </script>

</body>

</html>