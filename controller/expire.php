<?php
include_once("config.php");
// #Inactividad, sesión expirada#
if (isset($_SESSION["usercode"])){
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
		// última actividad hace 30 minutos, elimina la sesion (30 * 60)
		session_unset();
		session_destroy();
		header("location: ".$location_logout_expire);
		exit;
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	$usertype = $_SESSION['usertype'];
}

?>