<?php include ("main.php");
if(!isset($_SESSION['usercode'])){
    redirect($location_404);
}

$errors = array();
$data = array(); 

 if(!isset($_POST['billFirstName']) || empty($_POST['billFirstName'])){
    $errors['firstname'] = $trans['control_billing_error1'];
}else{
    $firstname = $_POST['billFirstName'];
}

 if(!isset($_POST['billMiddleName']) || empty($_POST['billMiddleName'])){
    $errors['middlename'] = $trans['control_billing_error2'];
}else{
    $middlename = $_POST['billMiddleName'];
}

if(!isset($_POST['billLastName']) || empty($_POST['billLastName'])){
    $lastname = "";
}else{
    $lastname = $_POST['billLastName'];
}

if(!isset($_POST['billPhone']) || empty($_POST['billPhone'])){
    $errors['mobile'] = $trans['control_billing_error3'];
}else if(!phoneValidation($_POST['billPhone'])){
    $errors['mobile'] = $trans['control_billing_error4'];
}else{
    $mobile = $_POST['billPhone'];
}

if(!isset($_POST['billCountry']) || empty($_POST['billCountry'])){
    $errors['country'] = $trans['control_billing_error5'];
}else{
    $country = $_POST['billCountry'];
}

if(!isset($_POST['billDistrict']) || empty($_POST['billDistrict'])){
    $errors['region'] = $trans['control_billing_error6'];
}else{
    $region = $_POST['billDistrict'];
}

if(!isset($_POST['billTownOrCity']) || empty($_POST['billTownOrCity'])){
    $errors['city'] = $trans['control_billing_error7'];
}else{
    $city = $_POST['billTownOrCity'];
}

if(!isset($_POST['billPostcode']) || empty($_POST['billPostcode'])){
    $postalcode = NULL;
}else{
    $postalcode = $_POST['billPostcode'];
}

if(!isset($_POST['billAddress1']) || empty($_POST['billAddress1'])){
    $errors['street'] = $trans['control_billing_error8'];
}else{
    $street = $_POST['billAddress1'];
}

if(!isset($_POST['billAddress2']) || empty($_POST['billAddress2'])){
    $street2 = NULL;
}else{
    $street2 = $_POST['billAddress2'];
} 

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_billing_errormessage'];
} else {
    $line = $street.($street2==NULL? '' : ', '.$street2);
    $query = "UPDATE `user` SET `billfirstName` = ?, `billmiddleName` = ?, `billlastName` = ?, `billmobile` = ?, `billline1` = ?, `billpostalcode` = ?, `billcity` = ?, `billprovince` = ?, `billcountry` = ? WHERE id = ?";
    $args = array($firstname, $middlename, $lastname, $mobile, $line, $postalcode, $city, $region, $country, $_SESSION['usercode']);
    
    $db->prepare($query,$args);
    $data['success'] = true;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_billing_successmessage'];
}
echo json_encode($data);

?>