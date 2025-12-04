<?php include ("main.php");
 

$errors = array(); // array con los errores producidos
$data = array(); // array para devolver información

if(!isset($_POST['registeremail']) || empty($_POST['registeremail'])){
    $errors['registeremail'] = $trans['control_registeremail_error1'];
}else{
    $registeremail = $_POST['registeremail'];
    if(emailValidation($registeremail)){
        $query = "SELECT id FROM user WHERE email = ? AND isdeleted = 0";
        $res = $db->prepare($query, array($registeremail));
        if($db->numRows($res) > 0){
            $errors['registeremail'] = $trans['control_registeremail_error2'];
        }
    }else{
        $errors['registeremail'] = $trans['control_registeremail_error3'];
    }
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_registeremail_errormessage'];
}else{
    $data['success'] = true;
    $data['errors']  = $errors;
    $data['message'] = $registeremail;
    
}
echo json_encode($data);
?>