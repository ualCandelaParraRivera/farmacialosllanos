<?php include ("pdfsenderadmin.php");

$errors = array();
$data = array();

$neworder = $_POST['create'];
$guidorder = $_POST['guid'];

if(!isset($_POST['orderid']) || empty($_POST['orderid'])){
    $orderid = NULL;
}else{
    $orderid = $_POST['orderid'];
}

if(!isset($_POST['fecha']) || empty($_POST['fecha'])){
    $fecha = NULL;
}else{
    $fecha = $_POST['fecha'];
}

if(!isset($_POST['statusid']) || intval($_POST['statusid']) == -1){
    $errors['statusid'] = "Debes establecer el estado del pedido";
}else{
    $statusid = $_POST['statusid'];
}

if(!isset($_POST['userid']) || empty($_POST['userid'])){
    $userid = NULL;
}else{
    $userid = $_POST['userid'];
}

if(!isset($_POST['email']) || empty($_POST['email'])){
    $errors['email'] = "Debes introducir un correo electrónico";
}else if(!emailValidation($_POST['email'])){
    $errors['email'] = "Debes introducir un correo electrónico válido";
}else{
    $email = $_POST['email'];
}

if(!isset($_POST['subtotal']) || empty($_POST['subtotal'])){
    $subtotal = 0;
}else{
    $subtotal = $_POST['subtotal'];
}

if(!isset($_POST['tax']) || empty($_POST['tax'])){
    $tax = 0;
}else{
    $tax = $_POST['tax'];
}

if(!isset($_POST['shipping']) || empty($_POST['shipping'])){
    $shipping = 0;
}else{
    $shipping = $_POST['shipping'];
}

if(!isset($_POST['shipping']) || empty($_POST['shipping'])){
    $shipping = 0;
}else{
    $shipping = $_POST['shipping'];
}

if(!isset($_POST['total']) || empty($_POST['total'])){
    $total = 0;
}else{
    $total = $_POST['total'];
}

if(!isset($_POST['promocode']) || empty($_POST['promocode'])){
    $promocode = NULL;
}else{
    $promocode = $_POST['promocode'];
}

if(!isset($_POST['discount']) || empty($_POST['discount'])){
    $discount = 0;
}else{
    $discount = $_POST['discount'];
}

if(!isset($_POST['grandtotal']) || empty($_POST['grandtotal'])){
    $grandtotal = 0;
}else{
    $grandtotal = $_POST['grandtotal'];
}

if(!isset($_POST['table']) || empty($_POST['table'])){
    $errors['table'] = "No existen productos en el pedido";
}else{
    $table = $_POST['table'];
}

if(!isset($_POST['billfirstname']) || empty($_POST['billfirstname'])){
    $errors['billfirstname'] = "Debes introducir el nombre";
}else{
    $billfirstname = $_POST['billfirstname'];
}

if(!isset($_POST['billmiddlename']) || empty($_POST['billmiddlename'])){
    $errors['billmiddlename'] = "Debes introducir el apellido";
}else{
    $billmiddlename = $_POST['billmiddlename'];
}

if(!isset($_POST['billlastname']) || empty($_POST['billlastname'])){
    $billlastname = '';
}else{
    $billlastname = $_POST['billlastname'];
}

if(!isset($_POST['billmobile']) || empty($_POST['billmobile'])){
    $errors['billmobile'] = "Debes introducir el teléfono";
}else{
    $billmobile = $_POST['billmobile'];
}

if(!isset($_POST['billcountry']) || empty($_POST['billcountry'])){
    $errors['billcountry'] = "Debes seleccionar el país";
}else{
    $billcountry = $_POST['billcountry'];
}

if(!isset($_POST['billdistrict']) || empty($_POST['billdistrict'])){
    $errors['billdistrict'] = "Debes seleccionar la comunidad autónoma";
}else{
    $billdistrict = $_POST['billdistrict'];
}

if(!isset($_POST['billcity']) || empty($_POST['billcity'])){
    $errors['billcity'] = "Debes introducir la ciudad";
}else{
    $billcity = $_POST['billcity'];
}

if(!isset($_POST['billaddress']) || empty($_POST['billaddress'])){
    $errors['billaddress'] = "Debes introducir la dirección";
}else{
    $billaddress = $_POST['billaddress'];
}

if(!isset($_POST['billpostalcode']) || empty($_POST['billpostalcode'])){
    $billpostalcode = '';
}else{
    $billpostalcode = $_POST['billpostalcode'];
}

if(!isset($_POST['shipfirstname']) || empty($_POST['shipfirstname'])){
    $errors['shipfirstname'] = "Debes introducir el nombre";
}else{
    $shipfirstname = $_POST['shipfirstname'];
}

if(!isset($_POST['shipmiddlename']) || empty($_POST['shipmiddlename'])){
    $errors['shipmiddlename'] = "Debes introducir el apellido";
}else{
    $shipmiddlename = $_POST['shipmiddlename'];
}

if(!isset($_POST['shiplastname']) || empty($_POST['shiplastname'])){
    $shiplastname = '';
}else{
    $shiplastname = $_POST['shiplastname'];
}

if(!isset($_POST['shipmobile']) || empty($_POST['shipmobile'])){
    $errors['shipmobile'] = "Debes introducir el teléfono";
}else{
    $shipmobile = $_POST['shipmobile'];
}

if(!isset($_POST['shipcountry']) || empty($_POST['shipcountry'])){
    $errors['shipcountry'] = "Debes seleccionar el país";
}else{
    $shipcountry = $_POST['shipcountry'];
}

if(!isset($_POST['shipdistrict']) || empty($_POST['shipdistrict'])){
    $errors['shipdistrict'] = "Debes seleccionar la comunidad autónoma";
}else{
    $shipdistrict = $_POST['shipdistrict'];
}

if(!isset($_POST['shipcity']) || empty($_POST['shipcity'])){
    $errors['shipcity'] = "Debes introducir la ciudad";
}else{
    $shipcity = $_POST['shipcity'];
}

if(!isset($_POST['shipaddress']) || empty($_POST['shipaddress'])){
    $errors['shipaddress'] = "Debes introducir la dirección";
}else{
    $shipaddress = $_POST['shipaddress'];
}

if(!isset($_POST['shipmentplan']) || empty($_POST['shipmentplan'])){
    $errors['shipmentplan'] = "Debes seleccionar un plan de envío";
}else{
    $shipmentplan = $_POST['shipmentplan'];
}

if(!isset($_POST['peso']) || empty($_POST['peso'])){
    $errors['peso'] = "Sebes seleccionar un plan de envío";
}else{
    $peso = $_POST['peso'];
}

if(!isset($_POST['shippostalcode']) || empty($_POST['shippostalcode'])){
    $shippostalcode = '';
}else{
    $shippostalcode = $_POST['shippostalcode'];
}

if(!isset($_POST['notes']) || empty($_POST['notes'])){
    $notes = '';
}else{
    $notes = $_POST['notes'];
}

if(!isset($_POST['ostatus']) || intval($_POST['ostatus']) == -1){
    $errors['ostatus'] = "Debes establecer el estado del pedido";
}else{
    $ostatus = $_POST['ostatus'];
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = "Existen errores en el formulario";
} else {
    if(($neworder == 1)){
        $sessionId = session_id();
        $token = sha1($sessionId);
        $query = "INSERT INTO `order` (userId, sessionId, token, status, subTotal, itemDiscount, tax, shipping, shippingtype, weight, total, promoId, discount, grandTotal, email, billfirstName, billmiddleName, billlastName, billmobile, billline1, billpostalcode, billcity, billprovince, billcountry, shipfirstName, shipmiddleName, shiplastName, shipmobile, shipline, shippostalcode, shipcity, shipdistrict, shipcountry, createdAt, updatedAt, content, isdeleted, guidorder) VALUES 
        (?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, 0, UUID())";
        $args = array($userid, $sessionId, $token, $statusid, $subtotal, $tax, $shipping, $shipmentplan, $peso, $total, $promocode, $discount, $grandtotal, $email, $billfirstname, $billmiddlename, $billlastname, $billmobile, $billaddress, $billpostalcode, $billcity, $billdistrict, $billcountry, $shipfirstname, $shipmiddlename, $shiplastname, $shipmobile, $shipaddress, $shippostalcode, $shipcity, $shipdistrict, $shipcountry, $notes);
        $db->prepare($query, $args);
        $id = $db->lastID();
        $query = "INSERT INTO order_item (productId, orderId, sku, price, discount, quantity, createdAt, updatedAt, content, isdeleted, guidorderitem) VALUES
        (?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, 0, UUID())";
        $datas = explode(",", $table);
        for ($i=0; $i < count($datas)/2; $i++) {
            $pid = intval($datas[$i*2]);
            $q = intval($datas[$i*2+1]);
            $query2 = "SELECT p.id
            ,p.sku
            ,pt.summary as product
            ,ROUND(p.pricenotax, 2) as price
            ,p.discount as discount
            ,? as quantity
            ,ROUND((1-discount)*pricenotax*?,2) as subtotal
            FROM product p
            LEFT JOIN product_translation pt ON p.id = pt.productId
            WHERE pt.lang = 'es' AND p.isdeleted = 0 AND p.id = ?";
            $res=$db->prepare($query2, array($q, $q, $pid));
            $row = mysqli_fetch_array($res);
            $args = array($row['id'], $id, $row['sku'],$row['price'],$row['discount'],$row['quantity'],$row['product']);
            $db->prepare($query, $args);
        }
        $s = '';
    }else{
        $query = "SELECT status FROM `order` WHERE guidorder = ? AND isdeleted = 0";
        $res = $db->prepare($query, array($guidorder));
        $oldStatusId = 0;
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $oldStatusId = $row['status'];
        }
        
        $query = "SELECT id FROM `order` WHERE guidorder = ?";
        $res=$db->prepare($query, array($guidorder));
        
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            
            $query = "UPDATE `order` SET status = ?, subTotal = ?, tax = ?, shipping = ?, shippingtype = ?, weight = ?,total = ?, promoId = ?, discount = ?, grandTotal = ?, email = ?, billfirstName = ?, billmiddleName = ?, billlastName = ?, billmobile = ?, billline1 = ?, billpostalcode = ?, billcity = ?, billprovince = ?, billcountry = ?, shipfirstName = ?, shipmiddleName = ?, shiplastName = ?, shipmobile = ?, shipline = ?, shippostalcode = ?, shipcity = ?, shipprovince = ?, shipcountry = ?, updatedAt = NOW(), content = ? WHERE id = ?";
            $args = array($statusid, $subtotal, $tax, $shipping, $shipmentplan, $peso, $total, $promocode, $discount, $grandtotal, $email, $billfirstname, $billmiddlename, $billlastname, $billmobile, $billaddress, $billpostalcode, $billcity, $billdistrict, $billcountry, $shipfirstname, $shipmiddlename, $shiplastname, $shipmobile, $shipaddress, $shippostalcode, $shipcity, $shipdistrict, $shipcountry, $notes, $id);
            $db->prepare($query, $args);

            $query = "SELECT id FROM order_item WHERE orderId = ?";
            $res=$db->prepare($query, array($id));
            while($row = mysqli_fetch_array($res)){
                $oiid = $row['id'];
                $query = "UPDATE order_item SET isdeleted = 1 WHERE id = ?";
                $db->prepare($query, array($oiid));
            }
            
            $query = "INSERT INTO order_item (productId, orderId, sku, price, discount, quantity, createdAt, updatedAt, content, isdeleted, guidorderitem) VALUES
            (?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, 0, UUID())";
            $datas = explode(",", $table);
            for ($i=0; $i < count($datas)/2; $i++) {
                $pid = intval($datas[$i*2]);
                $q = intval($datas[$i*2+1]);
                $query2 = "SELECT p.id
                ,p.sku
                ,pt.summary as product
                ,ROUND(p.pricenotax, 2) as price
                ,p.discount as discount
                ,? as quantity
                ,ROUND((1-discount)*pricenotax*?,2) as subtotal
                FROM product p
                LEFT JOIN product_translation pt ON p.id = pt.productId
                WHERE pt.lang = 'es' AND p.isdeleted = 0 AND p.id = ?";
                $res=$db->prepare($query2, array($q, $q, $pid));
                $row = mysqli_fetch_array($res);
                $args = array($row['id'], $id, $row['sku'],$row['price'],$row['discount'],$row['quantity'],$row['product']);
                $db->prepare($query, $args);
            }
            
           
            if($oldStatusId != $statusid && $statusid == 2){
            
                $query = "SELECT idinvoice FROM `invoice` WHERE orderid = ? AND isdeleted = 0";
                $res=$db->prepare($query, array($id));
                
                if($db->numRows($res) > 0){
                    $row = mysqli_fetch_array($res);
                    $idinvoice = $row['idinvoice'];

                    $query = "UPDATE `invoice` SET isdeleted = 1 WHERE idinvoice = ?";
                    $db->prepare($query, array($idinvoice));

                    $query = "SELECT idinvoiceitem FROM invoice_item WHERE idinvoice = ? AND isdeleted=0";
                    $res2=$db->prepare($query, array($idinvoice));

                    while($row2 = mysqli_fetch_array($res2)){
                        $idinvoiceitem = $row2['idinvoiceitem'];
                        $query = "UPDATE `invoice_item` SET isdeleted = 1 WHERE idinvoiceitem = ?";
                        $db->prepare($query, array($idinvoiceitem));
                    }
                }

                $type = '1';
                $query = "SELECT id, userId, sessionId, token, `status`, subTotal, itemDiscount, tax, shipping, shippingtype, 
                `weight`, total, promoId, discount, grandTotal, email, billfirstName, billmiddleName, billlastName, billmobile, 
                billline1, billpostalcode, billcity, billprovince, billcountry, shipfirstName, shipmiddleName, shiplastName, shipmobile, shipline, 
                shippostalcode, shipcity, shipprovince, shipcountry, createdAt, content, guidorder
                FROM `order` WHERE id = ? AND isdeleted = 0";
                $res=$db->prepare($query, array($id));
                
                if($db->numRows($res) == 0){
                    error_log("ERROR: No se encontró el pedido con ID: " . $id);
                    $data['success'] = false;
                    $data['message'] = "Error: No se encontró el pedido";
                    echo json_encode($data);
                    exit();
                }
                
                $row = mysqli_fetch_array($res);
                
                $orderid = $row['id'];
                $userid = $row['userId'];
                $sessionId = $row['sessionId'];
                $token = $row['token'];
                $status = $row['status'];
                $subtotal = $row['subTotal'];
                $itemDiscount = $row['itemDiscount'];
                $tax = $row['tax'];
                $shipping = $row['shipping'];
                $shippingtype = $row['shippingtype'];
                $weight = $row['weight'];
                $total = $row['total'];
                $promoId = $row['promoId'];
                $discount = $row['discount'];
                $grandTotal = $row['grandTotal'];
                $email = $row['email'];
                $billfirstName = $row['billfirstName'];
                $billmiddleName = $row['billmiddleName'];
                $billlastName = $row['billlastName'];
                $billmobile = $row['billmobile'];
                $billline1 = $row['billline1'];
                $billpostalcode = $row['billpostalcode'];
                $billcity = $row['billcity'];
                $billprovince = $row['billprovince'];
                $billcountry = $row['billcountry'];
                $shipfirstName = $row['shipfirstName'];
                $shipmiddleName = $row['shipmiddleName'];
                $shiplastName = $row['shiplastName'];
                $shipmobile = $row['shipmobile'];
                $shipline = $row['shipline'];
                $shippostalcode = $row['shippostalcode'];
                $shipcity = $row['shipcity'];
                $shipprovince = $row['shipprovince'];
                $shipcountry = $row['shipcountry'];
                $createdAt = $row['createdAt'];
                $content = $row['content'];
                $guidorder = $row['guidorder'];
                
                error_log("Creando factura para pedido ID: " . $orderid);
                
                $ppidtransaction = ''; 
                        
                $args = array($orderid,$userid,$sessionId,$token,$status,$subtotal,$itemDiscount,$tax,$shipping,$shippingtype,
                $weight,$total,$promoId,$discount,$grandTotal,$email,$billfirstName,$billmiddleName,$billlastName,$billmobile,
                $billline1,$billpostalcode,$billcity,$billprovince,$billcountry,$shipfirstName,$shipmiddleName,$shiplastName,$shipmobile,$shipline,
                $shippostalcode,$shipcity,$shipprovince,$shipcountry,$createdAt,$content,$guidorder,$ppidtransaction);

                $query = "INSERT INTO invoice (`orderid`, `userId`, `sessionId`, `token`, `status`, `subTotal`, `itemDiscount`, `tax`, `shipping`, `shippingtype`, 
                `weight`, `total`, `promoId`, `discount`, `grandTotal`, `email`, `billfirstName`, `billmiddleName`, `billlastName`, `billmobile`, 
                `billline1`, `billpostalcode`, `billcity`, `billprovince`, `billcountry`, `shipfirstName`, `shipmiddleName`, `shiplastName`, `shipmobile`, `shipline`,
                `shippostalcode`, `shipcity`, `shipprovince`, `shipcountry`, `createdAt`, `updatedAt`, `content`, `isdeleted`, `guidorder`, `invoicedate`, `ppidtransaction`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, NOW(), ?, 0, ?, NOW(), ?)";
                
                $result = $db->prepare($query,$args);
                
                
                $lastId = $db->lastID();
                error_log("Factura creada con ID: " . $lastId);
                
                if(!$lastId || $lastId == 0){
                    error_log("ERROR: No se obtuvo el ID de la factura creada");
                    $data['success'] = false;
                    $data['message'] = "Error: No se pudo obtener el ID de la factura";
                    echo json_encode($data);
                    exit();
                }
                    
                $query = "SELECT id as orderitemid
                ,productId
                ,sku
                ,price
                ,discount
                ,quantity
                ,createdAt
                ,content
                ,guidorderitem
                FROM `order_item` WHERE orderid = ? AND isdeleted = 0";
                $res=$db->prepare($query, array($orderid));
                
                if($db->numRows($res) == 0){
                    error_log("ADVERTENCIA: No se encontraron items para el pedido: " . $orderid);
                }
                    
                $query = "INSERT INTO `invoice_item` (idinvoice, orderiditem, productId, orderId, sku, price, discount, quantity, createdAt, updatedAt, content, isdeleted, guidorderitem, invoiceitemdate) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, 0, ?, NOW())";
                    
                $itemCount = 0;
                while($row = mysqli_fetch_array($res)){
                    $orderitemid = $row['orderitemid'];
                    $productId = $row['productId'];
                    $sku = $row['sku'];
                    $price = $row['price'];
                    $discount = $row['discount'];
                    $quantity = $row['quantity'];
                    $createdAt = $row['createdAt'];
                    $content = $row['content'];
                    $guidorderitem = $row['guidorderitem'];
                    
                    $args = array($lastId,$orderitemid,$productId,$orderid,$sku,$price,$discount,$quantity,$createdAt,$content,$guidorderitem);
                    $itemResult = $db->prepare($query,$args);
                    
                    if(!$itemResult){
                        error_log("ERROR al insertar item de factura: ");
                    } else {
                        $itemCount++;
                    }
                }
                
                error_log("Items de factura insertados: " . $itemCount);
                
                error_log("=== INICIO ENVÍO EMAIL ===");
                try {
                    ob_start();
                    $emailSent = sendAttatchment($db, $orderid, $type, $trans, $lang);
                    $emailOutput = ob_get_clean();
                    
                    if($emailOutput) {
                        error_log("Salida capturada del email: " . $emailOutput);
                    }
                    
                    if($emailSent) {
                        error_log("Email enviado correctamente");
                    } else {
                        error_log("El email no se pudo enviar pero el proceso continúa");
                    }
                } catch (Exception $e) {
                    ob_end_clean();
                    error_log("Excepción al enviar email: " . $e->getMessage());
                    error_log("Stack trace: " . $e->getTraceAsString());
                } catch (Error $e) {
                    ob_end_clean();
                    error_log("Error fatal al enviar email: " . $e->getMessage());
                    error_log("Stack trace: " . $e->getTraceAsString());
                }
                error_log("=== FIN ENVÍO EMAIL ===");
            }
        }
    }
    
    $data['success'] = true;
    $data['errors']  = $errors;
    $data['redirect'] = $neworder==1;
    $data['message'] = "Pedido guardado correctamente";
}

if (ob_get_level()) {
    ob_end_clean();
}
header('Content-Type: application/json');
echo json_encode($data);
exit();