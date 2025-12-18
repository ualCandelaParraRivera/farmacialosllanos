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
				$cookie_options = array(
					'expires' => time() + 60*60*24*30,
					'path' => '/',
					'domain' => '',
					'secure' => true,
					'httponly' => true,
					'samesite' => 'Strict'
				);
				setcookie('over18', $age, $cookie_options);
			}else{
				$_SESSION['over18'] = $age;
			}
			header("location: ../index");
	}

?>