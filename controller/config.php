<?php
require 'database.class.php';

$location_accessdenied = "403"; // página de denegación de acceso
$location_accessdenied_default = "403"; // página de denegación de acceso por defecto
$location_403 = "403";
$location_404 = "404";
$location_500 = "500";
$location_loginuser = "login"; //página de login usuario por defecto
$location_loginerror = "login?error=invalidlogin"; // pagina de login invalido
$location_logout = "login?message=logout"; // el usuario será redireccionado a esta página cuando cierre sesion
$location_logout_expire = "login?message=expire"; // el usuario será redireccionado a esta página cuando expire la sesion
$location_already_logged = "redirectlogin";
$location_userarea = "myaccount";
$location_cart="cart";
$postperpage = 6; //Number of post per page that will be shown
$productsperpage = 10;
$topnewproducts = 4;

if($_SERVER['HTTP_HOST'] == "hempleaf.ddns.net" || $_SERVER['HTTP_HOST'] == "localhost"){
    $webroot = $_SERVER['HTTP_HOST']."/hempleaf/";
}else{
    $webroot = $_SERVER['HTTP_HOST']."/";
}

$session_name = "losllanos"; // nombre de la sesion

if (is_null($location_accessdenied))
$location_accessdenied = $location_accessdenied_default;

$db=Db::getInstance();

session_name("losllanos");  
session_start();
if(!isset($_SESSION['cart'])){
    $_SESSION['cart']="";
}
if(!isset($_SESSION['promo'])){
    $_SESSION['promo']="";
}
?>