<?php
require 'config.php';
include("main.php");

class user {
    

    function get($db,$usercode){
        $query = "SELECT id as iduser
        ,firstName
        ,middleName
        ,lastName
        ,mobile
        ,email
        ,password
        ,image
        ,admin as usertype
        ,registeredAt
        ,lastLogin
        ,intro
        ,profile
        ,guiduser
        FROM user u
        WHERE id = ?";
        $result = $db->prepare($query, array($usercode));
        $row = mysqli_fetch_array($result);
        $this->usercode = $row["iduser"];
		$this->usertype = $row["usertype"];
		$this->login = $row["email"];
        $this->pwd = $row["password"];
        $this->name = $row["firstName"];
		$this->ap1 = $row["middleName"];
		$this->ap2 = $row["lastName"];
        $this->phone = $row["mobile"];
        $this->registeredAt = $row["registeredAt"];
        $this->lastLogin = $row["lastLogin"];
        $this->intro = $row["intro"];
        $this->profile = $row["profile"];
        $this->image = $row["image"];
        $this->guiduser = $row["guiduser"];
    }

    function verifylogin($db,$login,$pwd){
        if (emailValidation($login)) {
            $query = 
            "SELECT id as iduser 
            FROM user 
            WHERE email = ? AND password = ? AND isvalid = 1 AND isdeleted = 0";
            $result = $db->prepare($query, array($login, sha1($pwd)));
            if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
                $this->get($db,$row["iduser"]);
                return TRUE;
            }
        }
        return FALSE;
    }

    function getTokenByUsername($db,$username,$expired) {
	    $query = "Select * from tokenauth where username = ? and is_expired = ?";
	    $result = $db->prepareArray($query, array($username, $expired));
	    return $result;
    }

    function markAsExpired($db,$tokenId) {
        $query = "UPDATE tokenauth SET is_expired = ? WHERE id = ?";
        $expired = 1;
        $result = $db->prepare($query, array($expired, $tokenId));
        return $result;
    }

    function insertToken($db,$username, $random_password_hash, $random_selector_hash, $expiry_date) {
        $query = "INSERT INTO tokenauth (username, password_hash, selector_hash, expiry_date) values (?, ?, ?,?)";
        $result = $db->prepare($query, array($username, $random_password_hash, $random_selector_hash, $expiry_date));
        return $result;
    }

    
}

$login = trim($_POST["email"]);
$pwd = trim($_POST["password"]);
$remember = isset($_POST['remember']) ? $_POST['remember'] : '';
$user = new user;
$error = "";

$current_time = time();
$current_date = date("Y-m-d H:i:s", $current_time);

$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);

if ($user->verifylogin($db,$login,$pwd)){
    // Regenerar ID de sesión para prevenir session fixation
    session_regenerate_id(true);
    
    $_SESSION["usercode"] = $user->usercode;
    $_SESSION["usertype"] = $user->usertype;
    if ($_SESSION["usertype"] >= 0) {
        $query = "SELECT lastlogin FROM user WHERE id = ".$_SESSION["usercode"];
        $res = $db->query($query);
        $row = mysqli_fetch_array($res);
        $_SESSION["lastlogin"] = $row['lastlogin'];
        $query = "UPDATE user SET lastlogin=NOW() WHERE id=".$_SESSION["usercode"];
        $db->query($query);
        if(!empty($remember)){
            // Configurar cookies con flags de seguridad
            $cookie_options = array(
                'expires' => $cookie_expiration_time,
                'path' => '/',
                'domain' => '',
                'secure' => true,      // Solo HTTPS
                'httponly' => true,    // No accesible desde JavaScript
                'samesite' => 'Strict' // Protección CSRF
            );
            
            setcookie("member_login", $login, $cookie_options);
            $_COOKIE['member_login'] = $login;
            $random_password = getToken(16);
            setcookie("random_password", $random_password, $cookie_options);
            $random_selector = getToken(32);
            setcookie("random_selector", $random_selector, $cookie_options);
            $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
            $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
            $userToken = $user->getTokenByUsername($db, $login, 0);
            if (! empty($userToken[0]["id"])) {
                $user->markAsExpired($db,$userToken[0]["id"]);
            }
            $user->insertToken($db, $login, $random_password_hash, $random_selector_hash, $expiry_date);
        } else {
            clearAuthCookie();
        }

        header("location: ../".$location_userarea);
    } else {
        header("location: ../".$location_loginerror);
    }
}else if(! empty($_COOKIE["member_login"]) && ! empty($_COOKIE["random_password"]) && ! empty($_COOKIE["random_selector"])){

    $isPasswordVerified = false;
    $isSelectorVerified = false;
    $isExpiryDateVerified = false;
    
    $userToken = $user->getTokenByUsername($db,$_COOKIE["member_login"],0);
    
    if (password_verify($_COOKIE["random_password"], $userToken[0]["password_hash"])) {
        $isPasswordVerified = true;
        echo "SI";
    }
    
    if (password_verify($_COOKIE["random_selector"], $userToken[0]["selector_hash"])) {
        $isSelectorVerified = true;
    }
    
    if($userToken[0]["expiry_date"] >= $current_date) {
        $isExpiryDareVerified = true;
    } 
    if (!empty($userToken[0]["id"]) && $isPasswordVerified && $isSelectorVerified && $isExpiryDareVerified) {
        header("location: ../".$location_userarea);
    } else {
        if(!empty($userToken[0]["id"])) {
            $user->markAsExpired($db,$userToken[0]["id"]);
        }
        clearAuthCookie();
        header("location: ../".$location_loginerror);
    }

}else{
    header("location: ../".$location_loginerror);
}

?>