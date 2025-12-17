<?php include ("main.php");
	$minAge = 18;
	
	if(isset($_POST['submit'])){
		
		if(strlen($_POST['mm'])==1)
		$month = '0'.$_POST['mm'];
		else 
		$month = $_POST['mm'];
		$agevar = $_POST['yy'].'/'.$month.'/'.$_POST['dd'];
		
		$age = strtotime($agevar);

		$eightteen = strtotime("-" . $minAge . " years");
		$server = $_SERVER["HTTP_HOST"];

			
			if(isset($_POST['rememberme']) && $_POST['rememberme'] == 'remember-me'){
				setcookie ( 'over18', $age, time() + 60*60*24*30, '/', ''.$server.'');
			}else{
				$_SESSION['over18'] = $age;
			}
			header("location: ../index");
	}

?>