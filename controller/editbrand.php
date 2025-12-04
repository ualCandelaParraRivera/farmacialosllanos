<?php include ("main.php");

$errors = array();
$data = array();

if(isset($_POST['create'])){
    
    $newbrand= $_POST['create'];
    $guiduser = $_POST['guid'];

    if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
        $errors['nombre'] = "Debes introducir el nombre de la marca";
    }else{
        $nombre = $_POST['nombre'];
    }

    if(!isset($_POST['introduccion']) || empty($_POST['introduccion'])){
        $errors['introduccion'] = "Debes incluir la introducción de la marca";
    }else{
        $introduccion = $_POST['introduccion'];
    }

    if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
        $errors['descripcion'] = "Debes introducir la descripcion de la marca";
    }else{
        $descripcion = $_POST['descripcion'];
    }

    if(!isset($_POST['email']) || empty($_POST['email'])){
        $email = NULL;
    }else if(!emailValidation($_POST['email'])){
        $errors['email'] = "Debes introducir un correo electrónico válido";
    }else{
        $email = strtolower($_POST['email']);
    }

    if(!isset($_POST['telefono']) || empty($_POST['telefono'])){
        $telefono = NULL;
    }else if(!phoneValidation($_POST['telefono'])){
        $errors['telefono'] = "Debes introducir un teléfono válido";
    }else{
        $telefono = $_POST['telefono'];
    }

    // Devuelve una respuesta ===========================================================
	// Si hay algun error en el array de errores, devuelve un valor de success a false
    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else { //Si todo el formulario es correcto, se guarda el pedido
        if($newbrand==1){
            $query = "INSERT INTO user (firstName, mobile, email, password, image, admin, vendor, registeredAt, lastLogin, intro, profile, isdeleted, isvalid, guiduser) VALUES
            (?, ?, ?, sha1(UUID()), 'brand1.png', 0, 1, NOW(), NOW(), ?, ?, 0, 1, UUID())";
            $db->prepare($query, array($nombre, $telefono, $email, $introduccion, $descripcion));
            $id = $db->lastID();
            $query = "SELECT guiduser FROM user WHERE id = ?";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $guiduser = $row['guiduser'];
        }else{
            $query = "SELECT id FROM user WHERE guiduser = ?";
            $res = $db->prepare($query, array($guiduser));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE user SET firstname = ?, mobile = ?, email = ?, intro = ?, profile = ? WHERE id = ?";
            $db->prepare($query, array($nombre, $telefono, $email, $introduccion, $descripcion, $id));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['message'] = $guiduser; 
    }

 echo json_encode($data);

}else if(isset($_POST['edit'])){
    
    $errors = array();
    $data = array(); // array para devolver información
    $guid = guid();
    $allowed = array('jpeg', 'png', 'jpg');
    $target_dir = "../img/brands/";

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
            $guidbrand = $_POST['guid'];
            $query = "SELECT id FROM user WHERE guiduser = ?";
            $res = $db->prepare($query, array($guidbrand));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE user SET image = ? WHERE id = ?";
            $res = $db->prepare($query,array($name,$id));
        }
    }
    }   

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
}

