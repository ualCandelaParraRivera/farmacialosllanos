<?php include ("main.php");
if(!isset($_SESSION['usercode'])){
    redirect($location_404);
}

$errors = array();
$data = array(); 

if(!isset($_POST['firstname']) || empty($_POST['firstname'])){
    $errors['firstname'] = $trans['control_account_error1'];
}else{
    $firstname = $_POST['firstname'];
}

if(!isset($_POST['middlename']) || empty($_POST['middlename'])){
    $errors['middlename'] = $trans['control_account_error2'];
}else{
    $middlename = $_POST['middlename'];
}

if(!isset($_POST['lastname']) || empty($_POST['lastname'])){
    $lastname = "";
}else{
    $lastname = $_POST['lastname'];
}

if(!isset($_POST['mobile']) || empty($_POST['mobile'])){
    $errors['mobile'] = $trans['control_account_error3'];
}else if(!phoneValidation($_POST['mobile'])){
    $errors['mobile'] = $trans['control_account_error4'];
}else{
    $mobile = $_POST['mobile'];
}

if(!isset($_POST['email']) || empty($_POST['email'])){
    $errors['email'] = $trans['control_account_error5'];
}else if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = $_POST['email'];
    if(!emailValidation($email)){
        $errors['email'] = $trans['control_account_error6'];
    }else{
        $query = "SELECT id FROM user u
        WHERE email = ? AND isdeleted = 0 AND isvalid = 1 AND id <> ?";
        $res=$db->prepare($query, array($email, $_SESSION['usercode']));
        if($db->numRows($res) > 0){
            $errors['email'] = $trans['control_account_error7'];
        }
    }
   
}


$changepass = false;
if(!isset($_POST['currentpwd']) || !empty($_POST['currentpwd'])){
    $query = "SELECT id FROM user u WHERE id = ? AND password = ?";
    $res=$db->prepare($query, array($_SESSION['usercode'],sha1($_POST['currentpwd'])));
    if($db->numRows($res) == 0){
        $errors['currentpwd'] = $trans['control_account_error8'];
    }else{
        if(!isset($_POST['newpwd']) || !empty($_POST['newpwd'])){
            if(isset($_POST['confirmpwd']) && empty($_POST['confirmpwd'])){
                $errors['confirmpwd'] = $trans['control_account_error9'];
            }else{
                if(!isset($_POST['confirmpwd']) || $_POST['newpwd'] != $_POST['confirmpwd']){
                    $errors['newpwd'] = $trans['control_account_error10'];
                }else{
                    $pass = $_POST['newpwd'];
                    $changepass = true;
                }
            }
        }else{
            $errors['newpwd'] = $trans['control_account_error11'];
        }
    }
}else{
    if(isset($_POST['newpwd']) && !empty($_POST['newpwd'])){
        $errors['currentpwd'] = $trans['control_account_error12'];
    }
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_account_errormessage'];
} else {
    if($changepass){
        $query = "UPDATE `user` SET firstName = ?, middleName = ?, lastName = ?, mobile = ?, email = ?, password = ?, lastLogin = NOW() WHERE id = ?";
        $args = array($firstname, $middlename, $lastname, $mobile, $email, sha1($pass), $_SESSION['usercode']);
    }else{
        $query = "UPDATE `user` SET firstName = ?, middleName = ?, lastName = ?, mobile = ?, email = ?, lastLogin = NOW() WHERE id = ?";
        $args = array($firstname, $middlename, $lastname, $mobile, $email, $_SESSION['usercode']);
    }
    $db->prepare($query,$args);
    $data['success'] = true;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_account_successmessage'];
}
echo json_encode($data);

?>