<?php
include("controller/main.php");
$_SESSION = Array();
session_unset();
session_destroy();
header("location: ".$location_logout);
?>