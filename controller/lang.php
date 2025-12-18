<?php
$lang = "es";
$server = $_SERVER["HTTP_HOST"];

$cookie_options = array(
    'expires' => time() + 60*60*24*30,
    'path' => '/',
    'domain' => '',
    'secure' => true,      // Solo HTTPS
    'httponly' => false,   // JavaScript puede acceder (necesario para selector de idioma)
    'samesite' => 'Lax'    // Lax porque puede venir de enlaces externos
);

if(isset( $_GET["lang"])) {
    $lang = $_GET["lang"];
    setcookie('language', $lang, $cookie_options);
    if(isset($_GET['callback'])){
         header( "location: ".$_GET['callback'] );
    }else{
        header( "location: index" );
    }  
}else{
    setcookie('language', $lang, $cookie_options);
    if(isset($_GET['callback'])){
        header( "location: ".$_GET['callback'] );
    }else{
        header( "location: index" );
    }  
}

?>