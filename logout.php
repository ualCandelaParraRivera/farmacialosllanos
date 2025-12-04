<?php
include("controller/main.php");
$_SESSION = Array();
session_unset();
session_destroy();
//clearAuthCookie();
header("location: ".$location_logout);
?>