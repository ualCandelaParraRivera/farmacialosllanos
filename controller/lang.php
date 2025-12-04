<?php
$lang = "es";
$server = $_SERVER["HTTP_HOST"];
if(isset( $_GET["lang"])) {
    $lang = $_GET["lang"];
    setcookie ( 'language', $lang, time() + 60*60*24*30, '/', ''.$server.'');
    if(isset($_GET['callback'])){
        /* echo $_GET['callback']; */
         header( "location: ".$_GET['callback'] );
    }else{
        header( "location: index" );
    }  
}else{
    setcookie ( 'language', $lang, time() + 60*60*24*30, '/', ''.$server.'');
    if(isset($_GET['callback'])){
        header( "location: ".$_GET['callback'] );
    }else{
        header( "location: index" );
    }  
}

?>