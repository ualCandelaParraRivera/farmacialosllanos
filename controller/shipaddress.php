<?php include ("main.php");
if(!isset($_SESSION['usercode'])){
    redirect($location_404);
}

$errors = array();
$data = array(); 

 if(!isset($_POST['shipFirstName']) || empty($_POST['shipFirstName'])){
    $errors['firstname'] = $trans['control_shipping_error1'];
}else{
    $firstname = $_POST['shipFirstName'];
}

 if(!isset($_POST['shipMiddleName']) || empty($_POST['shipMiddleName'])){
    $errors['middlename'] = $trans['control_shipping_error2'];
}else{
    $middlename = $_POST['shipMiddleName'];
}

if(!isset($_POST['shipLastName']) || empty($_POST['shipLastName'])){
    $lastname = "";
}else{
    $lastname = $_POST['shipLastName'];
}

if(!isset($_POST['shipPhone']) || empty($_POST['shipPhone'])){
    $errors['mobile'] = $trans['control_shipping_error3'];
}else if(!phoneValidation($_POST['shipPhone'])){
    $errors['mobile'] = $trans['control_shipping_error4'];
}else{
    $mobile = $_POST['shipPhone'];
}

if(!isset($_POST['shipCountry']) || empty($_POST['shipCountry'])){
    $errors['country'] = $trans['control_shipping_error5'];
}else{
    $country = $_POST['shipCountry'];
}

if(!isset($_POST['shipDistrict']) || empty($_POST['shipDistrict'])){
    $errors['region'] = $trans['control_shipping_error6'];
}else{
    $region = $_POST['shipDistrict'];
}

if(!isset($_POST['shipTownOrCity']) || empty($_POST['shipTownOrCity'])){
    $errors['city'] = $trans['control_shipping_error7'];
}else{
    $city = $_POST['shipTownOrCity'];
}

if(!isset($_POST['shipPostcode']) || empty($_POST['shipPostcode'])){
    $postalcode = NULL;
}else{
    $postalcode = $_POST['shipPostcode'];
}

if(!isset($_POST['shipAddress1']) || empty($_POST['shipAddress1'])){
    $errors['street'] = $trans['control_shipping_error8'];
}else{
    $street = $_POST['shipAddress1'];
}

if(!isset($_POST['shipAddress2']) || empty($_POST['shipAddress2'])){
    $street2 = NULL;
}else{
    $street2 = $_POST['shipAddress2'];
} 

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_shipping_errormessage'];
} else {
    $line = $street.($street2==NULL? '' : ', '.$street2);
    $query = "UPDATE `user` SET `shipfirstName` = ?, `shipmiddleName` = ?, `shiplastName` = ?, `shipmobile` = ?, `shipline` = ?, `shippostalcode` = ?, `shipcity` = ?, `shipprovince` = ?, `shipcountry` = ? WHERE id = ?";
    $args = array($firstname, $middlename, $lastname, $mobile, $line, $postalcode, $city, $region, $country, $_SESSION['usercode']);
    
    $db->prepare($query,$args);
    $data['success'] = true;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_shipping_successmessage'];
}
echo json_encode($data);

?>