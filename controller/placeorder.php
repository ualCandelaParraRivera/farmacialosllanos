<?php 
// Iniciar output buffering para evitar problemas con headers
ob_start();

include("main.php");
include("phpmailer/PHPMailerAutoload.php");

// Establecer headers JSON al inicio
header('Content-Type: application/json; charset=utf-8');

// Limpiar cualquier output previo
ob_clean();

function enviarEmail($email, $nombre, $asunto, $mensaje){
    include("mailcredentials.php");
    $fromAddress = $contactmail;
    $fromName = $contactname;
    $toAddress = $email;
    $toName = $nombre;
    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->Host = $hostmail;
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Username = $infomail;
    $mail->Password = $infopass;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->addReplyTo($fromAddress, $fromName);
    $mail->setFrom($fromAddress, $fromName);
    $mail->addAddress($toAddress,$toName);
    $mail->isHTML(true);
    $mensaje = generarMensaje($email, $nombre, "Asunto", "Mensaje");

    $mail->smtpConnect([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ]);
    $mail->Subject = 'Asunto de prueba';
    $mail->msgHTML($mensaje);
    return $mail->send();
}

function imageToBase64($relativepath){
    $path = "../".$relativepath;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $encodedimage = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $encodedimage;
}

function generarMensaje($email, $nombre, $asunto, $mensaje){
    if($_SERVER['HTTP_HOST'] == "farmacialosllanos.ddns.net" || $_SERVER['HTTP_HOST'] == "localhost"){
        $webroot = $_SERVER['HTTP_HOST']."/farmacialosllanos/";
    }else{
        $webroot = $_SERVER['HTTP_HOST']."/";
    }
    $message = 'hola buenas';
    return $message;
}

// Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

// OBTENER PRODUCTOS DEL CARRITO AL INICIO
$products = $db->getCart($lang);
$quantity = 0;
$subtotal = 0;
$taxes = 0;
$weight = 1;

foreach($products as $product){
    $quantity += $product->count;
    $subtotal += $product->total;
    $taxes += $product->totaltax;
}

if($quantity == 0){
    echo json_encode([
        'success' => false,
        'message' => isset($trans['control_placeorder_emptycart']) ? $trans['control_placeorder_emptycart'] : 'El carrito está vacío'
    ]);
    exit;
}

// Gestión de promociones
if(isset($_SESSION['promo'])){
    if(!empty($_SESSION['promo'])){
        $promos = $db->getPromo();
        foreach($promos as $promo){
            $promocode = $promo->promocode;
            $discount = $promo->discount;
            $min = $promo->min;
            $max = $promo->max;
            $guidpromo = $promo->guidpromo;
        }
    }else{
        $promocode = "";
        $discount = 0;
        $min = -9999999;
        $max = 9999999;
        $guidpromo = "";
    }
}else{
    $promocode = "";
    $discount = 0;
    $min = -9999999;
    $max = 9999999;
    $guidpromo = "";
}

$errors = array();
$data = array(); 

// Sanitizar y validar entradas
if(!isset($_POST['billfirstname']) || empty(trim($_POST['billfirstname']))){
    $errors['billfirstname'] = $trans['control_placeorder_error1'];
}else{
    $billfirstname = htmlspecialchars(trim($_POST['billfirstname']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billmiddlename']) || empty(trim($_POST['billmiddlename']))){
    $errors['billmiddlename'] = $trans['control_placeorder_error2'];
}else{
    $billmiddlename = htmlspecialchars(trim($_POST['billmiddlename']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billlastname']) || empty(trim($_POST['billlastname']))){
    $billlastname = NULL;
}else{
    $billlastname = htmlspecialchars(trim($_POST['billlastname']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billcompany']) || empty(trim($_POST['billcompany']))){
    $billcompany = NULL;
}else{
    $billcompany = htmlspecialchars(trim($_POST['billcompany']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['email']) || empty(trim($_POST['email']))){
    $errors['email'] = $trans['control_placeorder_error3'];
}else if(!emailValidation($_POST['email'])){
    $errors['email'] = $trans['control_placeorder_error4'];
}else{
    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_SANITIZE_EMAIL);
}

if(!isset($_POST['billmobile']) || empty(trim($_POST['billmobile']))){
    $errors['billmobile'] = $trans['control_placeorder_error5'];
}else if(!phoneValidation($_POST['billmobile'])){
    $errors['billmobile'] = $trans['control_placeorder_error6'];
}else{
    $billmobile = htmlspecialchars(trim($_POST['billmobile']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billcountry']) || empty(trim($_POST['billcountry']))){
    $errors['billcountry'] = $trans['control_placeorder_error7'];
}else{
    $billcountry = htmlspecialchars(trim($_POST['billcountry']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billdistrict']) || empty(trim($_POST['billdistrict']))){
    $errors['billdistrict'] = $trans['control_placeorder_error8'];
}else{
    $billdistrict = htmlspecialchars(trim($_POST['billdistrict']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billcity']) || empty(trim($_POST['billcity']))){
    $errors['billcity'] = $trans['control_placeorder_error9'];
}else{
    $billcity = htmlspecialchars(trim($_POST['billcity']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billpostalcode']) || empty(trim($_POST['billpostalcode']))){
    $billpostalcode = NULL;
}else{
    $billpostalcode = htmlspecialchars(trim($_POST['billpostalcode']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billaddress1']) || empty(trim($_POST['billaddress1']))){
    $errors['billaddress1'] = $trans['control_placeorder_error10'];
}else{
    $street = htmlspecialchars(trim($_POST['billaddress1']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['billaddress2']) || empty(trim($_POST['billaddress2']))){
    $street2 = NULL;
}else{
    $street2 = htmlspecialchars(trim($_POST['billaddress2']), ENT_QUOTES, 'UTF-8');
}

// Dirección de envío
if(!isset($_POST['shipfirstname']) || empty(trim($_POST['shipfirstname']))){
    $errors['shipfirstname'] = $trans['control_placeorder_error1'];
}else{
    $shipfirstname = htmlspecialchars(trim($_POST['shipfirstname']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shipmiddlename']) || empty(trim($_POST['shipmiddlename']))){
    $errors['shipmiddlename'] = $trans['control_placeorder_error2'];
}else{
    $shipmiddlename = htmlspecialchars(trim($_POST['shipmiddlename']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shiplastname']) || empty(trim($_POST['shiplastname']))){
    $shiplastname = NULL;
}else{
    $shiplastname = htmlspecialchars(trim($_POST['shiplastname']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shipmobile']) || empty(trim($_POST['shipmobile']))){
    $errors['shipmobile'] = $trans['control_placeorder_error5'];
}else if(!phoneValidation($_POST['shipmobile'])){
    $errors['shipmobile'] = $trans['control_placeorder_error6'];
}else{
    $shipmobile = htmlspecialchars(trim($_POST['shipmobile']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shipcountry']) || empty(trim($_POST['shipcountry']))){
    $errors['shipcountry'] = $trans['control_placeorder_error7'];
}else{
    $shipcountry = htmlspecialchars(trim($_POST['shipcountry']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shipdistrict']) || empty(trim($_POST['shipdistrict']))){
    $errors['shipdistrict'] = $trans['control_placeorder_error8'];
}else{
    $shipdistrict = htmlspecialchars(trim($_POST['shipdistrict']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shipcity']) || empty(trim($_POST['shipcity']))){
    $errors['shipcity'] = $trans['control_placeorder_error9'];
}else{
    $shipcity = htmlspecialchars(trim($_POST['shipcity']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shippostalcode']) || empty(trim($_POST['shippostalcode']))){
    $shippostalcode = NULL;
}else{
    $shippostalcode = htmlspecialchars(trim($_POST['shippostalcode']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shipaddress1']) || empty(trim($_POST['shipaddress1']))){
    $errors['shipaddress1'] = $trans['control_placeorder_error10'];
}else{
    $streetship = htmlspecialchars(trim($_POST['shipaddress1']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['shipaddress2']) || empty(trim($_POST['shipaddress2']))){
    $street2ship = NULL;
}else{
    $street2ship = htmlspecialchars(trim($_POST['shipaddress2']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['notes']) || empty(trim($_POST['notes']))){
    $ordernotes = NULL;
}else{
    $ordernotes = htmlspecialchars(trim($_POST['notes']), ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['paymentmethod']) || empty($_POST['paymentmethod'])){
    $errors['payment'] = $trans['control_placeorder_error16'];
}else{
    $payment = htmlspecialchars($_POST['paymentmethod'], ENT_QUOTES, 'UTF-8');
}

if(!isset($_POST['options']) || empty($_POST['options'])){
    $errors['shippingtype'] = $trans['control_placeorder_error16'];
}else{
    switch($_POST['options']){
        case 'option1':
            $shippingtype = 'eco';
            break;
        case 'option2':
            $shippingtype = 'gls24';
            break;
        case 'option3':
            $shippingtype = 'gls14';
            break;
        case 'option4':
            $shippingtype = 'gls10';
            break;
        default:
            $shippingtype = 'glsislas';
            break;
    }
}

if(!isset($_POST['shipmentprice']) || empty($_POST['shipmentprice'])){
    $errors['shipmentprice'] = $trans['control_placeorder_error16'];
}else{
    $shipping = floatval($_POST['shipmentprice']);
}

// Validación de creación de cuenta
$createaccount = false;
if(isset($_POST['accountCheck'])){
    if(!isset($_POST['password1']) || empty($_POST['password1'])){
        $errors['account'] = $trans['control_placeorder_error11']; 
    }else if(!isset($_POST['password2']) || empty($_POST['password2'])){
        $errors['account'] = $trans['control_placeorder_error12']; 
    }else if($_POST['password1'] !== $_POST['password2']){
        $errors['account'] = $trans['control_placeorder_error13'];   
    }else if(!isset($email)){
        $errors['account'] = $trans['control_placeorder_error14'];
    }else{
        $query = "SELECT id FROM user WHERE email = ? AND isdeleted = 0";
        $res = $db->prepare($query, array($email));
        if($db->numRows($res) > 0){
            $errors['account'] = $trans['control_placeorder_error15'];
        }else{
            $createaccount = true;
            $pass = $_POST['password1'];
        }
    }
}else{
    $pass = NULL;
}

if(isset($_SESSION['usercode'])){
    $userId = $_SESSION['usercode'];
}else{
    $userId = NULL;
}

$idpromo = NULL;

// Respuesta
if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
    $data['message'] = $trans['control_placeorder_errormessage'];
} else {
    try {
        $sessionId = session_id();
        $token = sha1($sessionId);
        $status = 0;
        $itemDiscount = 0;
        $descuento = 0;
        
        if(!empty($promocode)){
            $query = "SELECT id FROM promo WHERE guidpromo = ?";
            $res = $db->prepare($query, array($guidpromo));
            $row = mysqli_fetch_array($res);
            $idpromo = $row['id'];
            if($subtotal + $taxes >= $min){
                $descuento = ($subtotal + $taxes) * $discount;
                if($descuento > $max){
                    $descuento = $max;
                }
            }
        }else{
            $promocode = NULL;
        }
        
        $total = $subtotal + $taxes + $shipping;
        $grandtotal = $total - $descuento;
        $line = $street . ($street2 == NULL ? '' : ', ' . $street2);
        $lineship = $streetship . ($street2ship == NULL ? '' : ', ' . $street2ship);
 
        // Crear cuenta si es necesario
        if($createaccount){
            $hashedPassword = sha1($pass);
            $query = "INSERT INTO `user` (`firstName`, `middleName`, `lastName`, `mobile`, `email`, `password`, `image`, `admin`, `vendor`, `registeredAt`, `lastLogin`, `intro`, `isdeleted`, `isvalid`, `billfirstName`, `billmiddleName`, `billlastName`, `billmobile`, `billline1`, `billpostalcode`, `billcity`, `billprovince`, `billcountry`, `shipfirstName`, `shipmiddleName`, `shiplastName`, `shipmobile`, `shipline`, `shippostalcode`, `shipcity`, `shipprovince`, `shipcountry`, `guiduser`) VALUES 
            (?, ?, ?, ?, ?, ?, 'user1.jpg', 0, 0, NOW(), NOW(), '', 0, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, UUID());";
            $args = array($billfirstname, $billmiddlename, $billlastname, $billmobile, $email, $hashedPassword, $billfirstname, $billmiddlename, $billlastname, $billmobile, $line, $billpostalcode, $billcity, $billdistrict, $billcountry, $shipfirstname, $shipmiddlename, $shiplastname, $shipmobile, $lineship, $shippostalcode, $shipcity, $shipdistrict, $shipcountry);
            $db->prepare($query, $args);
            $userId = $db->lastID();
        }
        
        // Crear orden
        $args = array($userId, $sessionId, $token, $status, $subtotal, $itemDiscount, $taxes, $shipping, $shippingtype, $weight, $total, $idpromo, $descuento, $grandtotal, $email, $billfirstname, $billmiddlename, $billlastname, $billmobile, $line, $billpostalcode, $billcity, $billdistrict, $billcountry, $shipfirstname, $shipmiddlename, $shiplastname, $shipmobile, $lineship, $shippostalcode, $shipcity, $shipdistrict, $shipcountry, $ordernotes);
        
        $query = "INSERT INTO `order` (userId, sessionId, token, status, subTotal, itemDiscount, tax, shipping, shippingtype, weight, total, promoId, discount, grandTotal, email, billfirstName, billmiddleName, billlastName, billmobile, billline1, billpostalcode, billcity, billprovince, billcountry, shipfirstName, shipmiddleName, shiplastName, shipmobile, shipline, shippostalcode, shipcity, shipprovince, shipcountry, createdAt, updatedAt, content, isdeleted, guidorder) VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, 0, UUID())";
        
        $db->prepare($query, $args);
        $lastId = $db->lastID();
        
        // VOLVER A OBTENER EL CARRITO
        $products = $db->getCart($lang);
        
        // Insertar items del pedido - USAR EL NOMBRE CORRECTO DE LA PROPIEDAD
        $query = "INSERT INTO `order_item` (`productId`, `orderId`, `sku`, `price`, `discount`, `quantity`, `createdAt`, `updatedAt`, `content`, `isdeleted`, `guidorderitem`) VALUES 
        (?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, 0, UUID())";

        $itemsInserted = 0;

        foreach($products as $product){
            // USAR LOS NOMBRES EXACTOS QUE MUESTRA EL LOG
            $productid = $product->productid;  // NO $product->id
            $sku = $product->sku;              // NO $product->SKU  
            $price = $product->pricenotax;     // Precio sin IVA
            $discount = $product->discount;
            $quantity = $product->count;
            $content = $product->title;
            
            error_log("Insertando: ProductID=$productid, OrderID=$lastId, SKU=$sku, Price=$price, Qty=$quantity, Content=$content, Discount=$discount");
            
            // CORRECCIÓN: Solo 7 valores porque NOW() y UUID() se generan en SQL
            $args = array($productid, $lastId, $sku, $price, $discount, $quantity, $content);
            $db->prepare($query, $args);
            
            
        }
        
        error_log("Total items insertados: $itemsInserted");

        
        
        $data['success'] = true;
        $data['message'] = $trans['control_placeorder_successmessage'];
        $orderarray = array("orderid" => $lastId, "paymethod" => $payment);
        $_SESSION['orderdata'] = $orderarray;
        
    } catch (Exception $e) {
        $data['success'] = false;
        $data['message'] = 'Error al procesar el pedido. Por favor, inténtelo de nuevo.';
        $data['error_detail'] = $e->getMessage();
        error_log('ERROR CRÍTICO: ' . $e->getMessage());
    }
}

// Enviar respuesta JSON
echo json_encode($data);
ob_end_flush();
exit;