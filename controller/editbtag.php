<?php include ("main.php");

$errors = array();
$data = array();

$newbtag = $_POST['create'];
$guidposttag = $_POST['guid'];

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
        if($newbtag==1){
            $query = "SELECT MAX(id)+1 as id FROM posttag";
            $res = $db->query($query);
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $slug = "slug-".$id;
            $query = "INSERT INTO posttag (title, metaTitle, slug, content, isdeleted, guidposttag) VALUES 
            (?, ?, '$slug', ?, 0, UUID())";
            $db->prepare($query, array($nombre, $metadatos, $descripcion));
        }else{
            $query = "SELECT id FROM posttag WHERE guidposttag = ?";
            $res = $db->prepare($query, array($guidposttag));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE posttag SET title = ?, metaTitle = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($nombre, $metadatos, $descripcion, $id));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['redirect'] = $newbtag==1;
        $data['message'] = $guidposttag; 
    }

 echo json_encode($data);

