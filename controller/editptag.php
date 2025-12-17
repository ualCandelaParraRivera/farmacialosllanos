<?php include ("main.php");

$errors = array();
$data = array();

$newptag = $_POST['create'];
$guidtag = $_POST['guid'];

    if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
        $errors['nombre'] = "Debes introducir el nombre de la etiqueta";
    }else{
        $nombre = $_POST['nombre'];
    }

    if(!isset($_POST['metadatos']) || empty($_POST['metadatos'])){
        $errors['metadatos'] = "Debes introducir los metadatos de la etiqueta";
    }else{
        $metadatos = $_POST['metadatos'];
    }

    if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
        $errors['descripcion'] = "Debes introducir la descripción de la etiqueta";
    }else{
        $descripcion = $_POST['descripcion'];
    }

    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else {
        if($newptag==1){
            $query = "SELECT MAX(id)+1 as id FROM tag";
            $res = $db->query($query);
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $slug = "slug-".$id;
            $query = "INSERT INTO tag (title, metaTitle, slug, content, isdeleted, guidtag) VALUES 
            (?, ?, '$slug', ?, 0, UUID())";
            $db->prepare($query, array($nombre, $metadatos, $descripcion));
        }else{
            $query = "SELECT id FROM tag WHERE guidtag = ?";
            $res = $db->prepare($query, array($guidtag));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE tag SET title = ?, metaTitle = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($nombre, $metadatos, $descripcion, $id));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['redirect'] = $newptag==1;
        $data['message'] = $guidtag; 
    }

 echo json_encode($data);

