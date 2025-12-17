<?php include ("main.php");

$errors = array();
$data = array();

$newpcategory = $_POST['create'];
$guidcategory = $_POST['guid'];

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

    if(!isset($_POST['name']) || empty($_POST['name'])){
        $errors['name'] = "Debes introducir el nombre de la categoría";
    }else{
        $name = $_POST['name'];
    }

    if(!isset($_POST['metadata']) || empty($_POST['metadata'])){
        $errors['metadata'] = "Debes introducir los metadatos de la categoría";
    }else{
        $metadata = $_POST['metadata'];
    }

    if(!isset($_POST['description']) || empty($_POST['description'])){
        $errors['description'] = "Debes introducir la descripción de la categoría";
    }else{
        $description = $_POST['description'];
    }

    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else {
        if($newpcategory==1){
            $query = "SELECT MAX(id)+1 as id FROM category";
            $res = $db->query($query);
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $slug = "slug-".$id;
            $query = "INSERT INTO category (slug, isdeleted, guidcategory) VALUES 
            ('$slug', 0, UUID())";
            $db->query($query);
            $id = $db->lastID();
            $query = "SELECT guidcategory FROM category WHERE id = ?";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $query = "INSERT INTO category_translation (categoryId, title, metaTitle, content, lang) VALUES 
            (?, ?, ?, ?, 'es')";
            $db->prepare($query, array($id,$nombre, $metadatos, $descripcion));
            $query = "INSERT INTO category_translation (categoryId, title, metaTitle, content, lang) VALUES 
            (?, ?, ?, ?, 'en')";
            $db->prepare($query, array($id,$name, $metadata, $description));
        }else{
            $query = "SELECT id FROM category WHERE guidcategory = ?";
            $res = $db->prepare($query, array($guidcategory));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "SELECT id FROM category_translation WHERE categoryId = ? AND lang = 'es'";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $transid = $row['id'];
            $query = "UPDATE category_translation SET title = ?, metaTitle = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($nombre, $metadatos, $descripcion, $transid));
            $query = "SELECT id FROM category_translation WHERE categoryId = ? AND lang = 'en'";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $transid = $row['id'];
            $query = "UPDATE category_translation SET title = ?, metaTitle = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($name, $metadata, $description, $transid));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['redirect'] = $newpcategory==1;
        $data['message'] = $guidcategory; 
    }

 echo json_encode($data);

