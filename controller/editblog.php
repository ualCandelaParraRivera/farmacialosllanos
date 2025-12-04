<?php include ("mainadmin.php");

$errors = array();
$data = array();
$guid = guid();
$allowed = array('jpeg', 'png', 'jpg');
$target_dir = "../img/blog/";

if(isset($_POST['create'])){
    
    $newpost = $_POST['create'];
    $guidpost = $_POST['guid'];

    if(!isset($_POST['titulo']) || empty($_POST['titulo'])){
        $errors['titulo'] = "Debes introducir el título del post";
    }else{
        $titulo = $_POST['titulo'];
    }

    if(!isset($_POST['metadatos']) || empty($_POST['metadatos'])){
        $errors['metadatos'] = "Debes incluir los metadatos del post";
    }else{
        $metadatos = $_POST['metadatos'];
    }

    if(!isset($_POST['autor']) || empty($_POST['autor'])){
        $errors['autor'] = "Debes seleccionar el autor del post";
    }else{
        $autor = $_POST['autor'];
    }

    if(!isset($_POST['fecha']) || empty($_POST['fecha'])){
        $errors['fecha'] = "Debes introducir la fecha de publicación"; 
    }else{
        $fecha = strtolower($_POST['fecha']);
    }

    if(!isset($_POST['categories']) || empty($_POST['categories'])  || $_POST['categories']=="[]"){
        $errors['categories'] = "Debes introducir las categorías";
    }else{
        $categories = $_POST['categories'];
    }

    if(!isset($_POST['etiquetas']) || empty($_POST['etiquetas']) || $_POST['etiquetas']=="[]"){
        $errors['etiquetas'] = "Debes introducir las etiquetas";
    }else{
        $etiquetas = $_POST['etiquetas'];
    }

    if(!isset($_POST['descripcion']) || empty(htmlentities($_POST['descripcion']))){
        $errors['descripcion'] = "Debes introducir el contenido del post";
    }else{
        $descripcion = htmlentities($_POST['descripcion']);
    }

    if($newpost == 1 && $_FILES["imageUpload"]["size"]==0){
        $errors['imageUpload'] = "Debes incluir la imagen del post";
    }else if($newpost == 0 && $_FILES["imageUpload"]["size"]==0){
        $uploadimage = 0;
    }else{
        $uploadimage = 1;
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
            }
        }   
    }

    // Devuelve una respuesta ===========================================================
	// Si hay algun error en el array de errores, devuelve un valor de success a false
    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else { //Si todo el formulario es correcto, se guarda el pedido
        $cat = preg_split("/[,]+/",  str_replace("]","",str_replace("[","",str_replace("'","",str_replace("\"","",$categories)))));
        $tag = preg_split("/[,]+/",  str_replace("]","",str_replace("[","",str_replace("'","",str_replace("\"","",$etiquetas)))));
        /* foreach ($cat as $valor) {
            echo $valor.'<br>';
        } */
        /* foreach ($tag as $valor) {
            echo $valor.'<br>';
        } */
        if($newpost ==1){
            $query = "SELECT id FROM user WHERE guiduser = ?";
            $res = $db->prepare($query, array($autor));
            $row = mysqli_fetch_array($res);
            $userId = $row['id'];
            $query = "INSERT INTO post (userId, title, metaTitle, image, views, createdAt, publishedAt, content, isdeleted, guidpost) VALUES 
            (?, ?, ?, 'blog-1.jpg', 0, NOW(), ?, ?, 0, UUID())";
            $db->prepare($query, array($userId, $titulo, $metadatos, $fecha, $descripcion));
            $id = $db->lastID();
            $query = "SELECT guidpost FROM post WHERE id = ?";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $guidpost = $row['guidpost'];
            $isuploaded = move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
            if(!$isuploaded){
                $errors['imageUpload'] = "Hubo un error durante la subida del archivo";
            }else{
                $query = "UPDATE post SET image = ? WHERE id = ?";
                $db->prepare($query,array($imagename,$id));
                createRedimImage($imagename, $target_dir, 120);
            }

            foreach ($cat as $valor) {
                $query = "SELECT id FROM postcategory WHERE title = '$valor'";
                $res = $db->query($query);
                while($row = mysqli_fetch_array($res)){
                    $categoryId = $row['id'];
                    $query2 = "INSERT INTO post_category (postId, categoryId) VALUES 
                    ($id, $categoryId)";
                    $db->query($query2);
                }
            }

            foreach ($tag as $valor) {
                $query = "SELECT id FROM posttag WHERE title = '$valor'";
                $res = $db->query($query);
                while($row = mysqli_fetch_array($res)){
                    $tagId = $row['id'];
                    $query2 = "INSERT INTO post_tag (postId, tagId) VALUES 
                    ($id, $tagId)";
                    $db->query($query2);
                }
            }

            /* $query = "INSERT INTO user (firstName, mobile, email, password, image, admin, vendor, registeredAt, lastLogin, intro, profile, isdeleted, isvalid, guiduser) VALUES
            (?, ?, ?, sha1(UUID()), 'brand1.png', 0, 1, NOW(), NOW(), ?, ?, 0, 1, UUID())";
            $db->prepare($query, array($nombre, $telefono, $email, $introduccion, $descripcion));
            $id = $db->lastID();
            $query = "SELECT guiduser FROM user WHERE id = ?";
            $res = $db->prepare($query, array($id));
            $row = mysqli_fetch_array($res);
            $guidpost = $row['guiduser']; */
        }else{
            $query = "SELECT id FROM user WHERE guiduser = ?";
            $res = $db->prepare($query, array($autor));
            $row = mysqli_fetch_array($res);
            $userId = $row['id'];
            $query = "SELECT id FROM post WHERE guidpost = ?";
            $res = $db->prepare($query, array($guidpost));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE post SET userId = ?, title = ?, metaTitle = ?, publishedAt = ?, content = ? WHERE id = ?";
            $db->prepare($query, array($userId, $titulo, $metadatos, $fecha, $descripcion, $id));
            if($uploadimage == 1){
                $isuploaded = move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
                if(!$isuploaded){
                    $errors['imageUpload'] = "Hubo un error durante la subida del archivo";
                }else{
                    $query = "UPDATE post SET image = ? WHERE id = ?";
                    $db->prepare($query,array($imagename,$id));
                    createRedimImage($imagename, $target_dir, 120);
                }
            }
            $query = "DELETE FROM post_category WHERE postId = ?";
            $db->prepare($query, array($id));
            foreach ($cat as $valor) {
                $query = "SELECT id FROM postcategory WHERE title = '$valor'";
                $res = $db->query($query);
                while($row = mysqli_fetch_array($res)){
                    $categoryId = $row['id'];
                    $query2 = "INSERT INTO post_category (postId, categoryId) VALUES 
                    ($id, $categoryId)";
                    $db->query($query2);
                }
            }
            $query = "DELETE FROM post_tag WHERE postId = ?";
            $db->prepare($query, array($id));
            foreach ($tag as $valor) {
                $query = "SELECT id FROM posttag WHERE title = '$valor'";
                $res = $db->query($query);
                while($row = mysqli_fetch_array($res)){
                    $tagId = $row['id'];
                    $query2 = "INSERT INTO post_tag (postId, tagId) VALUES 
                    ($id, $tagId)";
                    $db->query($query2);
                }
            }

            /*  $query = "SELECT id FROM user WHERE guiduser = ?";
            $res = $db->prepare($query, array($guidpost));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE user SET firstname = ?, mobile = ?, email = ?, intro = ?, profile = ? WHERE id = ?";
            $db->prepare($query, array($nombre, $telefono, $email, $introduccion, $descripcion, $id)); */
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['redirect'] = $newpost==1;
        $data['message'] = $guidpost; 
    }

 echo json_encode($data);

}/* else if(isset($_POST['edit'])){
    
    $errors = array();
    $data = array(); // array para devolver información
    $guid = guid();
    $allowed = array('jpeg', 'png', 'jpg');
    $target_dir = "../img/blog/";

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
 */
