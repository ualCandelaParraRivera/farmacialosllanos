<?php include ("main.php");

$errors = array();
$data = array();

if(isset($_POST['create'])){
    
    $newuser = $_POST['create'];

    if(!isset($_POST['firstname']) || empty($_POST['firstname'])){
        $errors['firstname'] = "Debes introducir el nombre del cliente";
    }else{
        $firstname = $_POST['firstname'];
    }

    if(!isset($_POST['middlename']) || empty($_POST['middlename'])){
        $errors['middlename'] = "Debes introducir el primer apellido del cliente";
    }else{
        $middlename = $_POST['middlename'];
    }

    if(!isset($_POST['lastname']) || empty($_POST['lastname'])){
        $lastname = NULL;
    }else{
        $lastname = $_POST['lastname'];
    }

    if(!isset($_POST['email']) || empty($_POST['email'])){
        $errors['email'] = "Debes introducir el correo electrónico del cliente";
    }else if(!emailValidation($_POST['email'])){
        $errors['email'] = "Debes introducir un correo electrónico válido";
    }else{
        $email = strtolower($_POST['email']);
        $guiduser = $_POST['guid'];
        if($newuser==1){
            $query = "SELECT id FROM user u WHERE u.email = ? AND u.isdeleted = 0";
            $res=$db->prepare($query, array($email));
        }else{
            $query = "SELECT id FROm user u WHERE u.email = ? AND u.isdeleted = 0 AND guiduser <> ?";
            $res=$db->prepare($query, array($email, $guiduser));
        }
        if($db->numROws($res) > 0){
            $errors['email'] = "No es posible usar ese correo electrónico";
        }
    }

    if(!isset($_POST['phone']) || empty($_POST['phone'])){
        $errors['mobile'] = "Debes introducir el teléfono del cliente";
    }else if(!phoneValidation($_POST['phone'])){
        $errors['mobile'] = "Debes introducir un teléfono válido";
    }else{
        $mobile = $_POST['phone'];
    }

    // Devuelve una respuesta ===========================================================
	// Si hay algun error en el array de errores, devuelve un valor de success a false
    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else { //Si todo el formulario es correcto, se guarda el pedido
        if($newuser==1){
            $query = "INSERT INTO `user` (`firstName`, `middleName`, `lastName`, `mobile`, `email`, `password`, `image`, `admin`, `vendor`, `registeredAt`, `lastLogin`, `isdeleted`, `isvalid`, `guiduser`) VALUES
            (?, ?, ?, ?, ?, sha1(UUID()), 'user1.jpg', 0, 0, NOW(), NOW(), 0, 1, UUID())";
            $db->prepare($query, array($firstname, $middlename, $lastname, $mobile, $email));
            $id = $db->lastID();
            $query = "SELECT guiduser FROM user WHERE id = ?";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $guiduser = $row['guiduser'];
        }else{
            $query = "SELECT id FROM user WHERE guiduser = ?";
            $res = $db->prepare($query, array($guiduser));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE `user` SET firstname = ?, middlename = ?, lastname = ?, mobile = ?, email = ? WHERE id = ?";
            $db->prepare($query, array($firstname, $middlename, $lastname, $mobile, $email, $id));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['message'] = $guiduser; 
    }

 echo json_encode($data);
}else if(isset($_POST['edit'])){
    if(!isset($_POST['billfirstname']) || empty($_POST['billfirstname'])){
        $errors['billfirstname'] = "Debes introducir el nombre del cliente";
    }else{
        $billfirstname = $_POST['billfirstname'];
    }

    if(!isset($_POST['billmiddlename']) || empty($_POST['billmiddlename'])){
        $errors['billmiddlename'] = "Debes introducir el primer apellido del cliente";
    }else{
        $billmiddlename = $_POST['billmiddlename'];
    }

    if(!isset($_POST['billlastname']) || empty($_POST['billlastname'])){
        $billlastname = NULL;
    }else{
        $billlastname = $_POST['billlastname'];
    }

    if(!isset($_POST['billmobile']) || empty($_POST['billmobile'])){
        $errors['billmobile'] = "Debes introducir el teléfono del cliente";
    }else if(!phoneValidation($_POST['billmobile'])){
        $errors['billmobile'] = "Debes introducir un teléfono válido";
    }else{
        $billmobile = $_POST['billmobile'];
    }

    if(!isset($_POST['billcountry']) || empty($_POST['billcountry'])){
        $errors['billcountry'] = "Debes seleccionar un país";
    }else{
        $billcountry = $_POST['billcountry'];
    }
    
    if(!isset($_POST['billdistrict']) || empty($_POST['billdistrict'])){
        $errors['billdistrict'] = "Debes seleccionar una comunidad autónoma";
    }else{
        $billdistrict = $_POST['billdistrict'];
    }
    
    if(!isset($_POST['billcity']) || empty($_POST['billcity'])){
        $errors['billcity'] = "Debes introducir la ciudad";
    }else{
        $billcity = $_POST['billcity'];
    }
    
    if(!isset($_POST['billpostalcode']) || empty($_POST['billpostalcode'])){
        $billpostalcode = NULL;
    }else{
        $billpostalcode = $_POST['billpostalcode'];
    }
    
    if(!isset($_POST['billaddress']) || empty($_POST['billaddress'])){
        $errors['billaddress'] = "Debes introducir la dirección";
    }else{
        $billaddress = $_POST['billaddress'];
    }

    //
    if(!isset($_POST['shipfirstname']) || empty($_POST['shipfirstname'])){
        $errors['shipfirstname'] = "Debes introducir el nombre del cliente";
    }else{
        $shipfirstname = $_POST['shipfirstname'];
    }

    if(!isset($_POST['shipmiddlename']) || empty($_POST['shipmiddlename'])){
        $errors['shipmiddlename'] = "Debes introducir el primer apellido del cliente";
    }else{
        $shipmiddlename = $_POST['shipmiddlename'];
    }

    if(!isset($_POST['shiplastname']) || empty($_POST['shiplastname'])){
        $shiplastname = NULL;
    }else{
        $shiplastname = $_POST['shiplastname'];
    }

    if(!isset($_POST['shipmobile']) || empty($_POST['shipmobile'])){
        $errors['shipmobile'] = "Debes introducir el teléfono del cliente";
    }else if(!phoneValidation($_POST['shipmobile'])){
        $errors['shipmobile'] = "Debes introducir un teléfono válido";
    }else{
        $shipmobile = $_POST['shipmobile'];
    }

    if(!isset($_POST['shipcountry']) || empty($_POST['shipcountry'])){
        $errors['shipcountry'] = "Debes seleccionar un país";
    }else{
        $shipcountry = $_POST['shipcountry'];
    }
    
    if(!isset($_POST['shipdistrict']) || empty($_POST['shipdistrict'])){
        $errors['shipdistrict'] = "Debes seleccionar una comunidad autónoma";
    }else{
        $shipdistrict = $_POST['shipdistrict'];
    }
    
    if(!isset($_POST['shipcity']) || empty($_POST['shipcity'])){
        $errors['shipcity'] = "Debes introducir la ciudad";
    }else{
        $shipcity = $_POST['shipcity'];
    }
    
    if(!isset($_POST['shippostalcode']) || empty($_POST['shippostalcode'])){
        $shippostalcode = NULL;
    }else{
        $shippostalcode = $_POST['shippostalcode'];
    }
    
    if(!isset($_POST['shipaddress']) || empty($_POST['shipaddress'])){
        $errors['shipaddress'] = "Debes introducir la dirección";
    }else{
        $shipaddress = $_POST['shipaddress'];
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
    }else{
        $guiduser = $_POST['guid'];
        $query = "SELECT id FROM user WHERE guiduser = ?";
        $res = $db->prepare($query, array($guiduser));
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $query = "UPDATE `user` SET `billfirstName` = ?, `billmiddleName` = ?, `billlastName` = ?, `billmobile` = ?, `billline1` = ?, `billpostalcode` = ?, `billcity` = ?, `billprovince` = ?, `billcountry` = ?, `shipfirstName` = ?, `shipmiddleName` = ?, `shiplastName` = ?, `shipmobile` = ?, `shipline` = ?, `shippostalcode` = ?, `shipcity` = ?, `shipprovince` = ?, `shipcountry` = ? WHERE id = ?";
        $db->prepare($query, array($billfirstname, $billmiddlename, $billlastname, $billmobile, $billaddress, $billpostalcode, $billcity, $billdistrict, $billcountry, $shipfirstname, $shipmiddlename, $shiplastname, $shipmobile, $shipaddress, $shippostalcode, $shipcity, $shipdistrict, $shipcountry, $id));
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['message'] = $guiduser; 
    }
    echo json_encode($data);
}

