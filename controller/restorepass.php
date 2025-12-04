<?php include ("main.php");
 

$errors = array(); // array con los errores producidos
$data = array(); // array para devolver información

if(!isset($_POST['newpass']) || empty($_POST['newpass'])){
    $errors['newpass'] = $trans['control_restore_error1'];
}else{
    $newpass = $_POST['newpass'];
}

if(!isset($_POST['confirmpass']) || empty($_POST['confirmpass'])){
    $errors['confirmpass'] = $trans['control_restore_error2'];
}else{
    $confirmpass = $_POST['confirmpass'];
}

if(!isset($_POST['guiduser']) || empty($_POST['guiduser'])){
    $errors['guiduser'] = $trans['control_restore_error3'];
}else{
    $guiduser = $_POST['guiduser'];
}

if(!isset($_POST['token']) || empty($_POST['token'])){
    $errors['token'] = $trans['control_restore_error3'];
}else{
    $token = $_POST['token'];
}
if(empty($errors) && $newpass != $confirmpass){
    $errors['newpass'] = $trans['control_restore_error4'];
    $errors['confirmpass'] = $trans['control_restore_error4'];
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_restore_errormessage'];
}else{
    $query = "SELECT guiduser FROM resetpass WHERE token = ?";
    $res = $db->prepare($query, array($token));
    if($db->numRows($res) == 0){
        $data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = $trans['control_restore_errormessage2'];
    }else{
        $row = $res->fetch_assoc();
        if(sha1($row['guiduser']) != $guiduser){
            $data['success'] = false;
            $data['errors']  = $errors;
            $data['message'] = $trans['control_restore_errormessage2'];
        }else{
            $query = "UPDATE user SET password = ? WHERE guiduser = ? AND isdeleted = 0";
            $db->prepare($query, array(sha1($newpass), $row['guiduser']));
            $query = "DELETE FROM resetpass WHERE token = ?";
            $res = $db->prepare( $query, array($token)); 
            $data['success'] = true;
            $data['errors']  = $errors;
            $data['message'] = $trans['control_restore_successmessage'];
        }
       
    }
    
}
echo json_encode($data);
?>