<?php
require 'database.class.php';

$location_accessdenied = "403";
$location_accessdenied_default = "403"; 
$location_403 = "403";
$location_404 = "404";
$location_500 = "500";
$location_loginuser = "login";
$location_loginerror = "login?error=invalidlogin";
$location_logout = "login?message=logout"; 
$location_logout_expire = "login?message=expire";
$location_already_logged = "redirectlogin";
$location_userarea = "myaccount";
$location_cart="cart";
$postperpage = 6; 
$productsperpage = 10;
$topnewproducts = 4;

if($_SERVER['HTTP_HOST'] == "farmacialosllanos.ddns.net" || $_SERVER['HTTP_HOST'] == "localhost"){
    $webroot = $_SERVER['HTTP_HOST']."/farmacialosllanos/";
}else{
    $webroot = $_SERVER['HTTP_HOST']."/";
}

$session_name = "losllanos"; 

if (is_null($location_accessdenied))
$location_accessdenied = $location_accessdenied_default;

$db=Db::getInstance();

// Configuración segura de sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Solo HTTPS
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_lifetime', 0); // Sesión expira al cerrar navegador

session_name("losllanos");  
session_start();

if(!isset($_SESSION['cart'])){
    $_SESSION['cart']="";
}
if(!isset($_SESSION['promo'])){
    $_SESSION['promo']="";
}
?>