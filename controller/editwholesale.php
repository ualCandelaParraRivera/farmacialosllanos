<?php include ("mainadmin.php");

$errors = array();
$data = array();

if(isset($_POST['create'])){
    
    $newwholesale= $_POST['create'];
    $guidwholesale = $_POST['guid'];

    if(!isset($_POST['sku']) || empty($_POST['sku'])){
        $errors['sku'] = "Debes introducir el SKU del producto";
    }else{
        $sku = $_POST['sku'];
    }

    if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
        $errors['nombre'] = "Debes introducir el nombre del producto";
    }else{
        $nombre = $_POST['nombre'];
    }

    if(!isset($_POST['metadatos']) || empty($_POST['metadatos'])){
        $errors['metadatos'] = "Debes introducir los metadatos del producto";
    }else{
        $metadatos = $_POST['metadatos'];
    }

    if(!isset($_POST['resumen']) || empty($_POST['resumen'])){
        $errors['resumen'] = "Debes introducir un resumen del producto";
    }else{
        $resumen = $_POST['resumen'];
    }

    if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
        $errors['descripcion'] = "Debes introducir una descripción del producto";
    }else{
        $descripcion = $_POST['descripcion'];
    }

    if(!isset($_POST['name']) || empty($_POST['name'])){
        $errors['name'] = "Debes introducir el nombre del producto";
    }else{
        $imagename = $_POST['name'];
    }

    if(!isset($_POST['metadata']) || empty($_POST['metadata'])){
        $errors['metadata'] = "Debes introducir los metadatos del producto";
    }else{
        $metadata = $_POST['metadata'];
    }

    if(!isset($_POST['summary']) || empty($_POST['summary'])){
        $errors['summary'] = "Debes introducir un resumen del producto";
    }else{
        $summary = $_POST['summary'];
    }

    if(!isset($_POST['description']) || empty($_POST['description'])){
        $errors['description'] = "Debes introducir una descripción del producto";
    }else{
        $description = $_POST['description'];
    }

    // Devuelve una respuesta ===========================================================
	// Si hay algun error en el array de errores, devuelve un valor de success a false
    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else { //Si todo el formulario es correcto, se guarda el pedido
        if($newwholesale==1){
            $query = "INSERT INTO wholesale (image, sku, isdeleted, guidwholesale) VALUES 
            ('wholesale1.jpg', ?, 0, UUID())";
            $db->prepare($query, array($sku));
            $id = $db->lastID();
            $query = "SELECT guidwholesale FROM wholesale WHERE id = ?";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $guidwholesale = $row['guidwholesale'];
            //ES
            $query = "INSERT INTO wholesale_translation (wholesaleId, title, metaTitle, summary, content, lang) VALUES 
            (?, ?, ?, ?, ?, 'es')";
            $db->prepare($query, array($id,$nombre, $metadatos, $resumen, $descripcion));
            //EN
            $query = "INSERT INTO wholesale_translation (wholesaleId, title, metaTitle, summary, content, lang) VALUES 
            (?, ?, ?, ?, ?, 'en')";
            $db->prepare($query, array($id,$imagename, $metadata, $summary, $description));

        }else{
            $query = "SELECT id FROM wholesale WHERE guidwholesale = ?";
            $res = $db->prepare($query, array($guidwholesale));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            //ES
            $query = "SELECT id FROM wholesale_translation WHERE wholesaleId = ? AND lang = 'es'";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $transid = $row['id'];
            $query = "UPDATE wholesale_translation SET title = ?, metaTitle = ?, summary = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($nombre, $metadatos, $resumen, $descripcion, $transid));
            //EN
            $query = "SELECT id FROM wholesale_translation WHERE wholesaleId = ? AND lang = 'en'";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $transid = $row['id'];
            $query = "UPDATE wholesale_translation SET title = ?, metaTitle = ?, summary = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($imagename, $metadata, $summary, $description, $transid));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['message'] = $guidwholesale; 
    }

 echo json_encode($data);

}else if(isset($_POST['edit'])){
    
    $errors = array();
    $data = array(); // array para devolver información
    $guid = guid();
    $allowed = array('jpeg', 'png', 'jpg');
    $target_dir = "../img/wholesale/";

    $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
    if($check == false) {
        $errors['imageUpload']="No es un archivo de imagen";
    }else{
        $filename = $_FILES["imageUpload"]["name"];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $size = filesize ($_FILES["imageUpload"]["tmp_name"]);
    if (!in_array($ext, $allowed)) {
        $errors['imageUpload']="No es un tipo de imagen permitido";
    }else if($size > 3145728){
        $errors['imageUpload']="El tamaño del archivo supera el limite (3MB)";
    }else{
        $imagename = $guid . ".".$ext; 
        $target_file = $target_dir . basename($imagename);
        $isuploaded = move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
        if(!$isuploaded){
            $errors['imageUpload']="Hubo un error durante la subida del archivo";
        }else{
            $guidwholesale = $_POST['guid'];
            $query = "SELECT id FROM wholesale WHERE guidwholesale = ?";
            $res = $db->prepare($query, array($guidwholesale));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE wholesale SET image = ? WHERE id = ?";
            $res = $db->prepare($query,array($imagename,$id));
            createRedimImage($imagename, $target_dir, 370);
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

