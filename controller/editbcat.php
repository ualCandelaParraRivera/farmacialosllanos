<?php include ("main.php");

$errors = array();
$data = array();

$newbcategory = $_POST['create'];
$guidpostcategory = $_POST['guid'];

    if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
        $errors['nombre'] = "Debes introducir el nombre de la categoría";
    }else{
        $nombre = $_POST['nombre'];
    }

    if(!isset($_POST['metadatos']) || empty($_POST['metadatos'])){
        $errors['metadatos'] = "Debes introducir los metadatos de la categoría";
    }else{
        $metadatos = $_POST['metadatos'];
    }

    if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
        $errors['descripcion'] = "Debes introducir la descripción de la categoría";
    }else{
        $descripcion = $_POST['descripcion'];
    }

    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else {
        if($newbcategory==1){
            $query = "SELECT MAX(id)+1 as id FROM postcategory";
            $res = $db->query($query);
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $slug = "slug-".$id;
            $query = "INSERT INTO postcategory (title, metaTitle, slug, content, isdeleted, guidpostcategory) VALUES 
            (?, ?, '$slug', ?, 0, UUID())";
            $db->prepare($query, array($nombre, $metadatos, $descripcion));
        }else{
            $query = "SELECT id FROM postcategory WHERE guidpostcategory = ?";
            $res = $db->prepare($query, array($guidpostcategory));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE postcategory SET title = ?, metaTitle = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($nombre, $metadatos, $descripcion, $id));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['redirect'] = $newbcategory==1;
        $data['message'] = $guidpostcategory; 
    }

 echo json_encode($data);

