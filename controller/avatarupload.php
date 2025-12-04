<?php include ("mainadmin.php");

$errors = array();
$data = array(); // array para devolver información
$guid = guid();
$allowed = array('jpeg', 'png', 'jpg');
$target_dir = "../img/team/";

$check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
if($check == false) {
  $errors['pass']="No es un archivo de imagen";
}else{
  $filename = $_FILES["imageUpload"]["name"];
  $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  $size = filesize ($_FILES["imageUpload"]["tmp_name"]);
  if (!in_array($ext, $allowed)) {
    $errors['pass']="No es un tipo de imagen permitido";
  }else if($size > 3145728){
    $errors['pass']="El tamaño del archivo supera el limite (3MB)";
  }else{
    $name = $guid . ".".$ext; 
    $target_file = $target_dir . basename($name);
    $isuploaded = move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
    if(!$isuploaded){
      $errors['pass']="Hubo un error durante la subida del archivo";
    }else{
        $guiduser = $_POST['guid'];
        $query = "SELECT id FROM user WHERE guiduser = ?";
        $res = $db->prepare($query, array($guiduser));
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $query = "UPDATE user SET image = ? WHERE id = ?";
        $res = $db->prepare($query,array($name,$id));
    }
  }
}






//header("location: ../areaperfil.php");

// Devuelve una respuesta ===========================================================
	// Si hay algun error en el array de errores, devuelve un valor de success a false
    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = 'Existen errores en el formulario.';
	} else {
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['message'] = 'Se ha actualizado la imagen correctamente';
        
    }

echo json_encode($data); 