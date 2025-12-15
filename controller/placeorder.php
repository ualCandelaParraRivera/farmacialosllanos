<?php include ("main.php");

include("phpmailer/PHPMailerAutoload.php");

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
    if($_SERVER['HTTP_HOST'] == "hempleaf.ddns.net" || $_SERVER['HTTP_HOST'] == "localhost"){
        $webroot = $_SERVER['HTTP_HOST']."/hempleaf/";
    }else{
        $webroot = $_SERVER['HTTP_HOST']."/";
    }
    $message = 'hola buenas';
    return $message;

}

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
    redirect($location_404);
}
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

if(!isset($_POST['billfirstname']) || empty($_POST['billfirstname'])){
    $errors['billfirstname'] = $trans['control_placeorder_error1'];
}else{
    $billfirstname = $_POST['billfirstname'];
}

if(!isset($_POST['billmiddlename']) || empty($_POST['billmiddlename'])){
    $errors['billmiddlename'] = $trans['control_placeorder_error2'];
}else{
    $billmiddlename = $_POST['billmiddlename'];
}

if(!isset($_POST['billlastname']) || empty($_POST['billlastname'])){
    $billlastname = NULL;
}else{
    $billlastname = $_POST['billlastname'];
}

if(!isset($_POST['billcompany']) || empty($_POST['billcompany'])){
    $billcompany = NULL;
}else{
    $billcompany = $_POST['billcompany'];
}
if(!isset($_POST['email']) || empty($_POST['email'])){
    $errors['email'] = $trans['control_placeorder_error3'];
}else if(!emailValidation($_POST['email'])){
    $errors['email'] = $trans['control_placeorder_error4'];
}else{
    $email = strtolower($_POST['email']);
}

if(!isset($_POST['billmobile']) || empty($_POST['billmobile'])){
    $errors['billmobile'] = $trans['control_placeorder_error5'];
}else if(!phoneValidation($_POST['billmobile'])){
    $errors['billmobile'] = $trans['control_placeorder_error6'];
}else{
    $billmobile = $_POST['billmobile'];
}

if(!isset($_POST['billcountry']) || empty($_POST['billcountry'])){
    $errors['billcountry'] = $trans['control_placeorder_error7'];
}else{
    $billcountry = $_POST['billcountry'];
}

if(!isset($_POST['billdistrict']) || empty($_POST['billdistrict'])){
    $errors['billdistrict'] = $trans['control_placeorder_error8'];
}else{
    $billdistrict = $_POST['billdistrict'];
}

if(!isset($_POST['billcity']) || empty($_POST['billcity'])){
    $errors['billcity'] = $trans['control_placeorder_error9'];
}else{
    $billcity = $_POST['billcity'];
}
if(!isset($_POST['billpostalcode']) || empty($_POST['billpostalcode'])){
    $billpostalcode = NULL;
}else{
    $billpostalcode = $_POST['billpostalcode'];
}

if(!isset($_POST['billaddress1']) || empty($_POST['billaddress1'])){
    $errors['billaddress1'] = $trans['control_placeorder_error10'];
}else{
    $street = $_POST['billaddress1'];
}

if(!isset($_POST['billaddress2']) || empty($_POST['billaddress2'])){
    $street2 = NULL;
}else{
    $street2 = $_POST['billaddress2'];
}

if(!isset($_POST['shipfirstname']) || empty($_POST['shipfirstname'])){
    $errors['shipfirstname'] = $trans['control_placeorder_error1'];
}else{
    $shipfirstname = $_POST['shipfirstname'];
}

if(!isset($_POST['shipmiddlename']) || empty($_POST['shipmiddlename'])){
    $errors['shipmiddlename'] = $trans['control_placeorder_error2'];
}else{
    $shipmiddlename = $_POST['shipmiddlename'];
}

if(!isset($_POST['shiplastname']) || empty($_POST['shiplastname'])){
    $shiplastname = NULL;
}else{
    $shiplastname = $_POST['shiplastname'];
}

if(!isset($_POST['shipmobile']) || empty($_POST['shipmobile'])){
    $errors['shipmobile'] = $trans['control_placeorder_error5'];
}else if(!phoneValidation($_POST['shipmobile'])){
    $errors['shipmobile'] = $trans['control_placeorder_error6'];
}else{
    $shipmobile = $_POST['shipmobile'];
}

if(!isset($_POST['shipcountry']) || empty($_POST['shipcountry'])){
    $errors['shipcountry'] = $trans['control_placeorder_error7'];
}else{
    $shipcountry = $_POST['shipcountry'];
}

if(!isset($_POST['shipdistrict']) || empty($_POST['shipdistrict'])){
    $errors['shipdistrict'] = $trans['control_placeorder_error8'];
}else{
    $shipdistrict = $_POST['shipdistrict'];
}

if(!isset($_POST['shipcity']) || empty($_POST['shipcity'])){
    $errors['shipcity'] = $trans['control_placeorder_error9'];
}else{
    $shipcity = $_POST['shipcity'];
}
if(!isset($_POST['shippostalcode']) || empty($_POST['shippostalcode'])){
    $shippostalcode = NULL;
}else{
    $shippostalcode = $_POST['shippostalcode'];
}

if(!isset($_POST['shipaddress1']) || empty($_POST['shipaddress1'])){
    $errors['shipaddress1'] = $trans['control_placeorder_error10'];
}else{
    $streetship = $_POST['shipaddress1'];
}

if(!isset($_POST['shipaddress2']) || empty($_POST['shipaddress2'])){
    $street2ship = NULL;
}else{
    $street2ship = $_POST['shipaddress2'];
}


if(!isset($_POST['notes']) || empty($_POST['notes'])){
    $ordernotes = NULL;
}else{
    $ordernotes = $_POST['notes'];
}

if(!isset($_POST['paymentmethod']) || empty($_POST['paymentmethod'])){
    $errors['payment'] = $trans['control_placeorder_error16'];
}else{
    $payment = $_POST['paymentmethod'];
}

if(!isset($_POST['shipmentmethod']) || empty($_POST['shipmentmethod'])){
    $errors['shippingtype'] = $trans['control_placeorder_error16'];
}else{
    $shippingtype = $_POST['shipmentmethod'];
}

if(!isset($_POST['shipmentprice']) || empty($_POST['shipmentprice'])){
    $errors['shipmentprice'] = $trans['control_placeorder_error16'];
}else{
    $shipping = $_POST['shipmentprice'];
}

$createaccount = false;
if(isset($_POST['accountCheck'])){
    if(!isset($_POST['password1']) || empty($_POST['password1'])){
        $errors['account'] = $trans['control_placeorder_error11']; 
    }else if(!isset($_POST['password2']) || empty($_POST['password2'])){
        $errors['account'] = $trans['control_placeorder_error12']; 
    }else if($_POST['password1'] <> $_POST['password2']){
        $errors['account'] = $trans['control_placeorder_error13'];   
    }else if(!isset($email)){
        $errors['account'] = $trans['control_placeorder_error14'];
    }else{
        $query = "SELECT id FROM user WHERE email = ? AND isdeleted = 0";
        $res=$db->prepare($query, array($email));
        if($db->numRows($res) > 0){
            $errors['account'] = $trans['control_placeorder_error15'];
        }else{
            $createaccount = true;
            $pass = $_POST['password1'];
        }
    }
}else{
    $pass=NULL;
}

if(isset($_SESSION['usercode'])){
    $userId = $_SESSION['usercode'];
}else{
    $userId = NULL;
}

$idpromo = NULL;

    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = $trans['control_placeorder_errormessage'];
	} else {
        $sessionId = session_id();
        $token = sha1($sessionId);
        $status = 0;
        $itemDiscount = 0;
        $descuento = 0;
        if(!empty($promocode)){
            $query = "SELECT id FROM promo WHERE guidpromo = ?";
            $res = $db->prepare($query,array($guidpromo));
            $row = mysqli_fetch_array($res);
            $idpromo = $row['id'];
            if($subtotal+$taxes >= $min){
                $descuento = ($subtotal+$taxes)*$discount;
                if($descuento > $max){
                    $descuento = $max;
                }
            }
        }else{
            $promocode = NULL;
        }
        $total = $subtotal + $taxes + $shipping;
        $grandtotal = $total - $descuento;
        $line = $street.($street2==NULL? '' : ', '.$street2);
        $lineship = $streetship.($street2ship==NULL? '' : ', '.$street2ship);
 
        if($createaccount){           
            $query = "INSERT INTO `user` (`firstName`, `middleName`, `lastName`, `mobile`, `email`, `password`, `image`, `admin`, `vendor`, `registeredAt`, `lastLogin`, `intro`, `isdeleted`, `isvalid`, `billfirstName`, `billmiddleName`, `billlastName`, `billmobile`, `billline1`, `billpostalcode`, `billcity`, `billprovince`, `billcountry`, `shipfirstName`, `shipmiddleName`, `shiplastName`, `shipmobile`, `shipline`, `shippostalcode`, `shipcity`, `shipprovince`, `shipcountry`, `guiduser`) VALUES 
            (?, ?, ?, ?, ?, ?, 'user1.jpg', 0, 0, NOW(), NOW(), '', 0, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, UUID());";
            $args = array($billfirstname,$billmiddlename,$billlastname,$billmobile,$email,sha1($pass),$billfirstname,$billmiddlename,$billlastname,$billmobile,$line,$billpostalcode,$billcity,$billdistrict,$billcountry,$shipfirstname,$shipmiddlename,$shiplastname,$shipmobile,$lineship,$shippostalcode,$shipcity,$shipdistrict,$shipcountry);
            $db->prepare($query,$args);
            $userId = $db->lastId();
        }
        $args = array($userId,$sessionId,$token,$status,$subtotal,$itemDiscount,$taxes,$shipping,$shippingtype,$weight,$total,$idpromo,$descuento,$grandtotal,$email,$billfirstname,$billmiddlename,$billlastname,$billmobile,$line,$billpostalcode,$billcity,$billdistrict,$billcountry,$shipfirstname,$shipmiddlename,$shiplastname,$shipmobile,$lineship,$shippostalcode,$shipcity,$shipdistrict,$shipcountry,$ordernotes);
        $query = "INSERT INTO `order` (userId, sessionId, token, status, subTotal, itemDiscount, tax, shipping, shippingtype, weight, total, promoId, discount, grandTotal, email, billfirstName, billmiddleName, billlastName, billmobile, billline1, billpostalcode, billcity, billprovince, billcountry, shipfirstName, shipmiddleName, shiplastName, shipmobile, shipline, shippostalcode, shipcity, shipprovince, shipcountry, createdAt, updatedAt, content, isdeleted, guidorder) VALUES 
         (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, 0, UUID())";
        $db->prepare($query,$args);
        $lastId = $db->lastId();
        $query = "INSERT INTO `order_item` (`productId`, `orderId`, `sku`, `price`, `discount`, `quantity`, `createdAt`, `updatedAt`, `content`, `isdeleted`, `guidorderitem`) VALUES 
        (?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, 0, UUID());";
        foreach($products as $product){
            $productid = $product->productid;
            $sku = $product->sku;
            $price = $product->pricenotax;
            $discount = $product->discount;
            $quantity = $product->count;
            $content = $product->summary;
            $args = array($productid,$lastId,$sku,$price,$discount,$quantity,$content);
            $db->prepare($query,$args);
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['message'] = $trans['control_placeorder_successmessage'];
        $orderarray = array("orderid" => $lastId, "paymethod" => $payment);
        $_SESSION['orderdata']=$orderarray; 
    }

 echo json_encode($data);