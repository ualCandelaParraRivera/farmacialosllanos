<?php include ("mainadmin.php");

$errors = array();
$data = array();

$newattribute = $_POST['create'];
$guidproductmeta = $_POST['guid'];

if(!isset($_POST['clave']) || empty($_POST['clave'])){
    $errors['clave'] = "Debes introducir la clave del atributo";
}else{
    $clave = $_POST['clave'];
}

if(!isset($_POST['valor']) || empty($_POST['valor'])){
    $errors['valor'] = "Debes introducir el valor del atributo";
}else{
    $valor = $_POST['valor'];
}

if(empty($errors)){
    $query = "SELECT id FROM product_meta WHERE `key` = ? AND content = ? AND guidproductmeta <> ?";
    $res = $db->prepare($query, array($clave, $valor, $guidproductmeta));
    if($db->numRows($res) > 0){
        $errors['valor'] = "Ya existe un valor igual para esa clave";
    }
}

// CORREGIDO: Si NO hay errores, entonces ejecutar INSERT/UPDATE
if (empty($errors)) {
    if($newattribute==1){
        $query = "INSERT INTO product_meta (`key`, content, isdeleted, guidproductmeta) VALUES
        (?, ?, 0, UUID())";
        $db->prepare($query, array($clave, $valor));
    }else{
        $query = "SELECT id FROM product_meta WHERE guidproductmeta = ?";
        $res = $db->prepare($query, array($guidproductmeta));
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $query = "UPDATE product_meta SET `key` = ?, content = ? WHERE id = ?";
        $db->prepare($query, array($clave, $valor, $id));
    }
    
    $data['success'] = true;
    $data['errors']  = array();
    $data['redirect'] = $newattribute==1;
    $data['message'] = "Atributo guardado correctamente"; 
} else {
    // Si HAY errores, devolver mensaje de error
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = "Existen errores en el formulario";
}

echo json_encode($data);
?>

