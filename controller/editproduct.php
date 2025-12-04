<?php include ("mainadmin.php");

$errors = array();
$data = array();
$guid = guid();
$allowed = array('jpeg', 'png', 'jpg');
$target_dir = "../img/product/";

$newproduct = $_POST['create'];
$guidproduct = $_POST['guid'];
$newphoto = $_POST['newphoto'];

if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
    $errors['nombre'] = "Debes introducir el nobre del producto";
}else{
    $nombre = $_POST['nombre'];
}

if(!isset($_POST['metadatos']) || empty($_POST['metadatos'])){
    $errors['metadatos'] = "Debes incluir los metadatos del producto";
}else{
    $metadatos = $_POST['metadatos'];
}

if(!isset($_POST['resumen']) || empty($_POST['resumen'])){
    $errors['resumen'] = "Debes introducir un resumen del producto";
}else{
    $resumen = $_POST['resumen'];
}

if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
    $errors['descripcion'] = "Debes introducir la descripción del producto"; 
}else{
    $descripcion = $_POST['descripcion'];
}

if(!isset($_POST['name']) || empty($_POST['name'])){
    $errors['name'] = "Debes introducir el nobre del producto";
}else{
    $namee = $_POST['name'];
}

if(!isset($_POST['metadata']) || empty($_POST['metadata'])){
    $errors['metadata'] = "Debes incluir los metadatos del producto";
}else{
    $metadata = $_POST['metadata'];
}

if(!isset($_POST['summary']) || empty($_POST['summary'])){
    $errors['summary'] = "Debes introducir un resumen del producto";
}else{
    $summary = $_POST['summary'];
}

if(!isset($_POST['description']) || empty($_POST['description'])){
    $errors['description'] = "Debes introducir la descripción del producto"; 
}else{
    $description = $_POST['description'];
}

if(!isset($_POST['sku']) || empty($_POST['sku'])){
    $errors['sku'] = "Debes introducir el SKU del producto"; 
}else{
    $sku = $_POST['sku'];
}

if(!isset($_POST['marcas']) || empty($_POST['marcas'])){
    $errors['marcas'] = "Debes seleccionar una marca";
}else{
    $marcas = $_POST['marcas'];
}

if(!isset($_POST['hot']) || empty($_POST['hot'])){
    $hot = 0;
}else{
    $hot = intval($_POST['hot']);
}

if(!isset($_POST['cantidad'])){
    $errors['cantidad'] = "Debes introducir el stock del producto"; 
}else if($_POST['cantidad'] < 0){
    $errors['cantidad'] = "La cantidad debe ser un valor positivo";
}else{
    $cantidad = $_POST['cantidad'];
}

if(!isset($_POST['precio'])){
    $errors['precio'] = "Debes introducir el precio del producto"; 
}else if($_POST['precio'] < 0){
    $errors['precio'] = "El precio debe ser un valor positivo";
}else{
    $precio = $_POST['precio'];
}

if(!isset($_POST['tax'])){
    $errors['tax'] = "Debes introducir el impuesto sobre el producto"; 
}else if($_POST['tax'] < 0){
    $errors['tax'] = "El impuesto no puede ser negativo"; 
}else if($_POST['tax'] > 100){
    $errors['tax'] = "El impuesto no puede ser superior a 100%"; 
}else{
    $tax = $_POST['tax'];
}

if(!isset($_POST['descuento'])){
    $errors['descuento'] = "Debes introducir el descuento del producto"; 
}else if($_POST['descuento'] < 0){
    $errors['descuento'] = "El descuento no puede ser negativo"; 
}else if($_POST['descuento'] > 100){
    $errors['descuento'] = "El descuento no puede ser superior a 100%"; 
}else{
    $descuento = $_POST['descuento'];
}

if(!isset($_POST['anchura'])){
    $errors['anchura'] = "Debes introducir la anchura del producto"; 
}else if($_POST['anchura'] < 1){
    $errors['anchura'] = "La anchura debe ser un valor positivo";
}else{
    $anchura = $_POST['anchura'];
}

if(!isset($_POST['altura'])){
    $errors['altura'] = "Debes introducir la altura del producto"; 
}else if($_POST['altura'] < 1){
    $errors['altura'] = "La altura debe ser un valor positivo";
}else{
    $altura = $_POST['altura'];
}

if(!isset($_POST['profundidad'])){
    $errors['profundidad'] = "Debes introducir la profundidad del producto"; 
}else if($_POST['profundidad'] < 1){
    $errors['profundidad'] = "La profundidad debe ser un valor positivo";
}else{
    $profundidad = $_POST['profundidad'];
}

if(!isset($_POST['peso'])){
    $errors['peso'] = "Debes introducir el peso del producto"; 
}else if($_POST['peso'] < 1){
    $errors['peso'] = "El peso debe ser un valor positivo";
}else{
    $peso = $_POST['peso'];
}

if(!isset($_POST['metaetiquetas']) || empty($_POST['metaetiquetas']) || $_POST['metaetiquetas']=="[]"){
    $errors['metaetiquetas'] = "Debes introducir los metadatos";
}else{
    $metaetiquetas = $_POST['metaetiquetas'];
}

if(!isset($_POST['categorias']) || empty($_POST['categorias'])  || $_POST['categorias']=="[]"){
    $errors['categorias'] = "Debes introducir las categorías";
}else{
    $categorias = $_POST['categorias'];
}

if(!isset($_POST['etiquetas']) || empty($_POST['etiquetas']) || $_POST['etiquetas']=="[]"){
    $errors['etiquetas'] = "Debes introducir las etiquetas";
}else{
    $etiquetas = $_POST['etiquetas'];
}

if(($newproduct == 1) || ($newproduct == 0 && $newphoto == 1)){
    $count = 0;
    foreach($_FILES["files"]['tmp_name'] as $key => $tmp_name){
        if(!empty($tmp_name)){
            $count++;
        }
    }

    if($count != 0){
        $notallowed = 0;
        foreach($_FILES["files"]['name'] as $key => $name){
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                $notallowed++;
            }
        }
        if($notallowed == $count){
            $errors['files']="No son tipos de imagen permitidos";
        }else{
            $oversize = 0;
            foreach($_FILES["files"]['tmp_name'] as $key => $tmp_name){
                $size = filesize ($tmp_name);
                if($size > 3145728){
                    $oversize++;
                }
            }
            if($oversize == $count){
                $errors['files']="Los tamaños de archivo superan el limite (3MB)";
            }
        }
    }else{
        $errors['files'] = "Debes incluir las imagenes del post";
    }
}
    
// }else if($newproduct == 0 && $_FILES["files"]["size"]==0){
//     $uploadimage = 0;
// }else{
//     $uploadimage = 1;
//     $check = getimagesize($_FILES["files"]["tmp_name"]);
//     if($check == false) {
//         $errors['files']="No es un archivo de imagen";
//     }else{
//         $filename = $_FILES["files"]["name"];
//         $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
//         $size = filesize ($_FILES["files"]["tmp_name"]);
//         if (!in_array($ext, $allowed)) {
//             $errors['files']="No es un tipo de imagen permitido";
//         }else if($size > 3145728){
//             $errors['files']="El tamaño del archivo supera el limite (3MB)";
//         }else{
//             $imagename = $guid . ".".$ext; 
//             $target_file = $target_dir . basename($imagename);
//         }
//     }   
// }

// Devuelve una respuesta ===========================================================
// Si hay algun error en el array de errores, devuelve un valor de success a false
if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = "Existen errores en el formulario";
} else { //Si todo el formulario es correcto, se guarda el pedido
    $metatags = preg_split("/[,]+/",  str_replace("]","",str_replace("[","",str_replace("'","",str_replace("\"","",$metaetiquetas)))));
    $cat = preg_split("/[,]+/",  str_replace("]","",str_replace("[","",str_replace("'","",str_replace("\"","",$categorias)))));
    $tag = preg_split("/[,]+/",  str_replace("]","",str_replace("[","",str_replace("'","",str_replace("\"","",$etiquetas)))));
   
    if(($newproduct == 1)){
        $query = "SELECT MAX(id)+1 as id FROM product";
        $res = $db->query($query);
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $slug = "slug-".$id;
        $userId = '';
        $query = "SELECT id FROM user where guiduser = ?";
        $res = $db->prepare($query, array($marcas));
        $row = mysqli_fetch_array($res);
        if($db->numRows($res) > 0){
            $userId = $row['id'];
        }
        $pricenotax = (1-$tax/100)*$precio;
        $query = "INSERT INTO product (userId, slug, type, sku, pricenotax, price, tax, discount, quantity, height, width, depth, weight, shop, createdAt, updatedAt, publishedAt, startsAt, endsAt, isdeleted, guidproduct, hot) VALUES 
        (?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW(), NOW(), NOW(), NOW(), 0, UUID(),?)";
        $args = array($userId, $slug, $sku, $pricenotax, $precio, $tax/100, $descuento/100, $cantidad, $altura, $anchura, $profundidad, $peso, $hot);
        $db->prepare($query, $args);
        $id = $db->lastID();

        $query = "INSERT INTO product_translation (productId, title, metaTitle, summary, content, lang) VALUES (?, ?, ?, ?, ?, 'es')";
        $db->prepare($query, array($id, $nombre, $metadatos, $resumen, $descripcion));

        $query = "INSERT INTO product_translation (productId, title, metaTitle, summary, content, lang) VALUES (?, ?, ?, ?, ?, 'en')";
        $db->prepare($query, array($id, $namee, $metadata, $summary, $description));

        $query = "INSERT INTO product_review (productId, rating) VALUES (?, 0)";
        $db->prepare($query, array($id));

        foreach ($metatags as $valor) {
            $kv = explode(": ", $valor);
            $k = trim($kv[0]);
            $v = trim($kv[1]);
            $query = "SELECT id FROM product_meta pm WHERE pm.key = ? AND pm.content = ?";
            $res = $db->prepare($query, array($k, $v));
            $row = mysqli_fetch_array($res);
            $attid = $row['id'];
            $query = "INSERT INTO product_has_meta (productId, metaId) VALUES (?, ?)";
            $db->prepare($query, array($id, $attid));
        }

        foreach ($cat as $valor) {
            $query = "SELECT c.id FROM category c
            INNER JOIN category_translation ct ON c.id = ct.categoryId
            WHERE c.isdeleted = 0 AND ct.title = ?";
            $res = $db->prepare($query, array($valor));
            $row = mysqli_fetch_array($res);
            $attid = $row['id'];
            $query = "INSERT INTO product_category (productId, categoryId) VALUES (?, ?)";
            $db->prepare($query, array($id, $attid));
        }

        foreach ($tag as $valor) {
            $query = "SELECT t.id FROM tag t
            WHERE t.isdeleted = 0 AND t.title = ?";
            $res = $db->prepare($query, array($valor));
            $row = mysqli_fetch_array($res);
            $attid = $row['id'];
            $query = "INSERT INTO product_tag (productId, tagId) VALUES (?, ?)";
            $db->prepare($query, array($id, $attid));
        }

        // $guid = guid();
        // $imagename = $guid . ".".$ext; 
        // $target_file = $target_dir . basename($imagename);
        $first = 0;

        foreach($_FILES["files"]['tmp_name'] as $key => $tmp_name){
            //Validamos que el archivo exista
            if($_FILES["files"]["name"][$key]) {
                $guid = guid();
                $source = $_FILES["files"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                $path = $_FILES['files']['name'][$key];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $filename = $first.$guid.'.'.$ext; //Obtenemos el nombre original del archivo
    
                
                //$directorio = 'img/gallery'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($target_dir)){
                    mkdir($target_dir, 0777, true) or die("No se puede crear el directorio de extracci&oacute;n");	
                }
                
                $dir=opendir($target_dir); //Abrimos el directorio de destino
                $target_path = $target_dir.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                $target_pathname = $target_dir.'/'.$filename; 
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(move_uploaded_file($source, $target_path)){
                    $query = "INSERT INTO product_image (productId, image, isdeleted) VALUES (?, ?, 0)";
                    $db->prepare($query, array($id, $filename));
                    createRedimImageWidth($filename, $target_dir,328);
                    createRedimImageWidth($filename, $target_dir,328,'hover');
                    createRedimImageWidth($filename, $target_dir,270);
                    createRedimImageWidth($filename, $target_dir,270,'hover');
                    createRedimImageWidthNoLength($filename, $target_dir,75,'cart');
                    createRedimImageWidthNoLength($filename, $target_dir,120,'list');
                    createRedimImageWidthNoLength($filename, $target_dir,120,'thumb');
                    createRedimImageWidthNoLength($filename, $target_dir,100,'widget');
                    createRedimImageWidthNoLength($filename, $target_dir,810,'zoom');
                    $first++;
                }
                    
                closedir($dir); //Cerramos el directorio de destino
            }
        }

    }else{
        $query = "SELECT id FROM product p WHERE guidproduct = ?";
        $res = $db->prepare($query, array($guidproduct));
        $row = mysqli_fetch_array($res);
        $id = $row['id'];

        $query = "SELECT id FROM user where guiduser = ?";
        $res = $db->prepare($query, array($marcas));
        $row = mysqli_fetch_array($res);
        if($db->numRows($res) > 0){
            $userId = $row['id'];
        }

        $pricenotax = (1-$tax/100)*$precio;
        $query = "UPDATE product SET userId = ?, sku = ?, pricenotax = ?, price = ?, tax = ?, discount = ?, quantity = ?, height = ?, width = ?, depth = ?, weight = ?, updatedAt = NOW(), hot = ? WHERE id = ?";
        $args = array($userId, $sku, $pricenotax, $precio, $tax/100, $descuento/100, $cantidad, $altura, $anchura, $profundidad, $peso, $hot, $id);
        $db->prepare($query, $args);

        $query = "UPDATE product_translation SET title = ?, metaTitle = ?, summary = ?, content = ? WHERE productId = ? AND lang = 'es'";
        $db->prepare($query, array($nombre, $metadatos, $resumen, $descripcion, $id));

        $query = "UPDATE product_translation SET title = ?, metaTitle = ?, summary = ?, content = ? WHERE productId = ? AND lang = 'en'";
        $db->prepare($query, array($namee, $metadata, $summary, $description, $id));


        $query = "DELETE FROM product_has_meta WHERE productId = ?";
        $db->prepare($query, array($id));
        foreach ($metatags as $valor) {
            $kv = explode(": ", $valor);
            $k = trim($kv[0]);
            $v = trim($kv[1]);
            $query = "SELECT id FROM product_meta pm WHERE pm.key = ? AND pm.content = ?";
            $res = $db->prepare($query, array($k, $v));
            $row = mysqli_fetch_array($res);
            $attid = $row['id'];
            $query = "INSERT INTO product_has_meta (productId, metaId) VALUES (?, ?)";
            $db->prepare($query, array($id, $attid));
        }

        $query = "DELETE FROM product_category WHERE productId = ?";
        $db->prepare($query, array($id));
        foreach ($cat as $valor) {
            $query = "SELECT c.id FROM category c
            INNER JOIN category_translation ct ON c.id = ct.categoryId
            WHERE c.isdeleted = 0 AND ct.title = ?";
            $res = $db->prepare($query, array($valor));
            $row = mysqli_fetch_array($res);
            $attid = $row['id'];
            $query = "INSERT INTO product_category (productId, categoryId) VALUES (?, ?)";
            $db->prepare($query, array($id, $attid));
        }

        $query = "DELETE FROM product_tag WHERE productId = ?";
        $db->prepare($query, array($id));
        foreach ($tag as $valor) {
            $query = "SELECT t.id FROM tag t
            WHERE t.isdeleted = 0 AND t.title = ?";
            $res = $db->prepare($query, array($valor));
            $row = mysqli_fetch_array($res);
            $attid = $row['id'];
            $query = "INSERT INTO product_tag (productId, tagId) VALUES (?, ?)";
            $db->prepare($query, array($id, $attid));
        }

        if($newphoto == 1){
            $query = "SELECT image FROM product_image WHERE productId = ? AND image NOT LIKE 'image01%'";
            $res = $db->prepare($query, array($id));
            while($row = mysqli_fetch_array($res)){
                deleteFile($target_dir, $row['image'], $sufix='');
                deleteFile($target_dir, $row['image'], $sufix='-328');
                deleteFile($target_dir, $row['image'], $sufix='-328hover');
                deleteFile($target_dir, $row['image'], $sufix='-270');
                deleteFile($target_dir, $row['image'], $sufix='-270hover');
                deleteFile($target_dir, $row['image'], $sufix='-cart');
                deleteFile($target_dir, $row['image'], $sufix='-list');
                deleteFile($target_dir, $row['image'], $sufix='-thumb');
                deleteFile($target_dir, $row['image'], $sufix='-widget');
                deleteFile($target_dir, $row['image'], $sufix='-zoom');
            }
            $query = "UPDATE product_image SET isdeleted = 1 WHERE productId = ?";
            $db->prepare($query, array($id));
            $first = 0;
            foreach($_FILES["files"]['tmp_name'] as $key => $tmp_name){
                //Validamos que el archivo exista
                if($_FILES["files"]["name"][$key]) {
                    $guid = guid();
                    $source = $_FILES["files"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                    $path = $_FILES['files']['name'][$key];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $filename = $first.$guid.'.'.$ext; //Obtenemos el nombre original del archivo
        
                    
                    //$directorio = 'img/gallery'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($target_dir)){
                        mkdir($target_dir, 0777, true) or die("No se puede crear el directorio de extracci&oacute;n");	
                    }
                    
                    $dir=opendir($target_dir); //Abrimos el directorio de destino
                    $target_path = $target_dir.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                    $target_pathname = $target_dir.'/'.$filename; 
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(move_uploaded_file($source, $target_path)){
                        $query = "INSERT INTO product_image (productId, image, isdeleted) VALUES (?, ?, 0)";
                        $db->prepare($query, array($id, $filename));
                        createRedimImageWidth($filename, $target_dir,328);
                        createRedimImageWidth($filename, $target_dir,328,'hover');
                        createRedimImageWidth($filename, $target_dir,270);
                        createRedimImageWidth($filename, $target_dir,270,'hover');
                        createRedimImageWidthNoLength($filename, $target_dir,75,'cart');
                        createRedimImageWidthNoLength($filename, $target_dir,120,'list');
                        createRedimImageWidthNoLength($filename, $target_dir,120,'thumb');
                        createRedimImageWidthNoLength($filename, $target_dir,100,'widget');
                        createRedimImageWidthNoLength($filename, $target_dir,810,'zoom');
                        $first++;
                    }
                        
                    closedir($dir); //Cerramos el directorio de destino
                }
            }
        }
    }
    // if($newpost ==1){
    //     $query = "SELECT id FROM user WHERE guiduser = ?";
    //     $res = $db->prepare($query, array($autor));
    //     $row = mysqli_fetch_array($res);
    //     $userId = $row['id'];
    //     $query = "INSERT INTO post (userId, title, metaTitle, image, views, createdAt, publishedAt, content, isdeleted, guidpost) VALUES 
    //     (?, ?, ?, 'blog-1.jpg', 0, NOW(), ?, ?, 0, UUID())";
    //     $db->prepare($query, array($userId, $titulo, $metadatos, $fecha, $descripcion));
    //     $id = $db->lastID();
    //     $query = "SELECT guidpost FROM post WHERE id = ?";
    //     $res = $db->prepare($query, array($id));
    //     $row = mysqli_fetch_array($res);
    //     $guidpost = $row['guidpost'];
    //     $isuploaded = move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
    //     if(!$isuploaded){
    //         $errors['imageUpload'] = "Hubo un error durante la subida del archivo";
    //     }else{
    //         $query = "UPDATE post SET image = ? WHERE id = ?";
    //         $db->prepare($query,array($imagename,$id));
    //         createRedimImage($imagename, $target_dir, 120);
    //     }

    //     foreach ($cat as $valor) {
    //         $query = "SELECT id FROM postcategory WHERE title = '$valor'";
    //         $res = $db->query($query);
    //         while($row = mysqli_fetch_array($res)){
    //             $categoryId = $row['id'];
    //             $query2 = "INSERT INTO post_category (postId, categoryId) VALUES 
    //             ($id, $categoryId)";
    //             $db->query($query2);
    //         }
    //     }

    //     foreach ($tag as $valor) {
    //         $query = "SELECT id FROM posttag WHERE title = '$valor'";
    //         $res = $db->query($query);
    //         while($row = mysqli_fetch_array($res)){
    //             $tagId = $row['id'];
    //             $query2 = "INSERT INTO post_tag (postId, tagId) VALUES 
    //             ($id, $tagId)";
    //             $db->query($query2);
    //         }
    //     }

    //     /* $query = "INSERT INTO user (firstName, mobile, email, password, image, admin, vendor, registeredAt, lastLogin, intro, profile, isdeleted, isvalid, guiduser) VALUES
    //     (?, ?, ?, sha1(UUID()), 'brand1.png', 0, 1, NOW(), NOW(), ?, ?, 0, 1, UUID())";
    //     $db->prepare($query, array($nombre, $telefono, $email, $introduccion, $descripcion));
    //     $id = $db->lastID();
    //     $query = "SELECT guiduser FROM user WHERE id = ?";
    //     $res = $db->prepare($query, array($id));
    //     $row = mysqli_fetch_array($res);
    //     $guidpost = $row['guiduser']; */
    // }else{
    //     $query = "SELECT id FROM user WHERE guiduser = ?";
    //     $res = $db->prepare($query, array($autor));
    //     $row = mysqli_fetch_array($res);
    //     $userId = $row['id'];
    //     $query = "SELECT id FROM post WHERE guidpost = ?";
    //     $res = $db->prepare($query, array($guidpost));
    //     $row = mysqli_fetch_array($res);
    //     $id = $row['id'];
    //     $query = "UPDATE post SET userId = ?, title = ?, metaTitle = ?, publishedAt = ?, content = ? WHERE id = ?";
    //     $db->prepare($query, array($userId, $titulo, $metadatos, $fecha, $descripcion, $id));
    //     if($uploadimage == 1){
    //         $isuploaded = move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
    //         if(!$isuploaded){
    //             $errors['imageUpload'] = "Hubo un error durante la subida del archivo";
    //         }else{
    //             $query = "UPDATE post SET image = ? WHERE id = ?";
    //             $db->prepare($query,array($imagename,$id));
    //             createRedimImage($imagename, $target_dir, 120);
    //         }
    //     }
    //     $query = "DELETE FROM post_category WHERE postId = ?";
    //     $db->prepare($query, array($id));
    //     foreach ($cat as $valor) {
    //         $query = "SELECT id FROM postcategory WHERE title = '$valor'";
    //         $res = $db->query($query);
    //         while($row = mysqli_fetch_array($res)){
    //             $categoryId = $row['id'];
    //             $query2 = "INSERT INTO post_category (postId, categoryId) VALUES 
    //             ($id, $categoryId)";
    //             $db->query($query2);
    //         }
    //     }
    //     $query = "DELETE FROM post_tag WHERE postId = ?";
    //     $db->prepare($query, array($id));
    //     foreach ($tag as $valor) {
    //         $query = "SELECT id FROM posttag WHERE title = '$valor'";
    //         $res = $db->query($query);
    //         while($row = mysqli_fetch_array($res)){
    //             $tagId = $row['id'];
    //             $query2 = "INSERT INTO post_tag (postId, tagId) VALUES 
    //             ($id, $tagId)";
    //             $db->query($query2);
    //         }
    //     }

        /*  $query = "SELECT id FROM user WHERE guiduser = ?";
        $res = $db->prepare($query, array($guidpost));
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $query = "UPDATE user SET firstname = ?, mobile = ?, email = ?, intro = ?, profile = ? WHERE id = ?";
        $db->prepare($query, array($nombre, $telefono, $email, $introduccion, $descripcion, $id)); */
    $data['success'] = true;
    $data['errors']  = $errors;
    $data['redirect'] = $newproduct==1;
    $data['message'] = "Cambios guardados correctamente"; 
}
        
    

 echo json_encode($data);

/* else if(isset($_POST['edit'])){
    
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
