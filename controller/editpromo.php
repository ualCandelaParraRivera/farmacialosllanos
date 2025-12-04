<?php include ("mainadmin.php");

$errors = array();
$data = array();

$newpromo = $_POST['create'];
$guidpromo = $_POST['guid'];

    if(!isset($_POST['codigo']) || empty($_POST['codigo'])){
        $errors['codigo'] = "Debes introducir el código de promoción";
    }else{
        $codigo = $_POST['codigo'];
        $query = "SELECT id FROM promo WHERE promocode = ? AND guidpromo <> ?";
        $res = $db->prepare($query, array($codigo, $guidpromo));
        if($db->numRows($res) > 0){
            $errors['codigo'] = "Ya existe ese código promocional";
        }
    }

    if(!isset($_POST['descuento'])){
        $errors['descuento'] = "Debes introducir porcentaje de descuento";
    }else{
        $descuento = $_POST['descuento'];
        if($descuento < 0){
            $errors['descuento'] = "El descuento no puede ser negativo";
        }else if($descuento > 100){
            $errors['descuento'] = "El descuento no puede ser superior a 100%";
        }
    }

    if(!isset($_POST['minimo'])){
        $errors['minimo'] = "Debes introducir el importe mínimo del descuento";
    }else{
        $minimo = $_POST['minimo'];
        if($minimo < 0){
            $errors['minimo'] = "El importe mínimo no puede ser negativo";
        }
    }
    if(!isset($_POST['maximo'])){
        $errors['maximo'] = "Debes introducir el importe máximo del descuento";
    }else{
        $maximo = $_POST['maximo'];
        if($maximo < 0){
            $errors['maximo'] = "El importe maximo no puede ser negativo";
        }
    }
    if(!isset($_POST['fechainicio']) || empty($_POST['fechainicio'])){
        $errors['fechainicio'] = "Debes introducir la fecha de comienzo";
    }else{
        $fechainicio = $_POST['fechainicio'];
    }
    if(!isset($_POST['fechafin']) || empty($_POST['fechafin'])){
        $errors['fechafin'] = "Debes introducir la fecha de finalización";
    }else{
        $fechafin = $_POST['fechafin'];
    }
    if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
        $errors['descripcion'] = "Debes introducir la descripción de la promoción";
    }else{
        $descripcion = $_POST['descripcion'];
    }
    if(isset($_POST['fechainicio']) && !empty($_POST['fechainicio']) && isset($_POST['fechafin']) && !empty($_POST['fechafin'])){
        if($fechainicio > $fechafin){
            $errors['fechafin'] = "La fecha de finalización debe ser posterior a la fecha de comienzo";
        }
    }

    // Devuelve una respuesta ===========================================================
	// Si hay algun error en el array de errores, devuelve un valor de success a false
    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = "Existen errores en el formulario";
	} else { //Si todo el formulario es correcto, se guarda el pedido
        if($newpromo==1){
            $query = "INSERT INTO promo (promocode, content, discount, min, max, startDate, endDate, isdeleted, guidpromo) VALUES 
            (?, ?, ?, ?, ?, ?, ?, 0, UUID())";
            $db->prepare($query, array($codigo, $descripcion, $descuento/100, $minimo, $maximo, $fechainicio, $fechafin));
        }else{
            $query = "SELECT id FROM promo WHERE guidpromo = ?";
            $res = $db->prepare($query, array($guidpromo));
            $row = mysqli_fetch_array($res);
            $id = $row['id'];
            $query = "UPDATE promo SET promocode = ?, content = ?, discount = ?, min = ?, max = ?, startDate = ?, endDate = ? WHERE id = ?";
            $db->prepare($query, array($codigo, $descripcion, $descuento/100, $minimo, $maximo, $fechainicio, $fechafin, $id));
        }
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['redirect'] = $newpromo==1;
        $data['message'] = $guidpromo; 
    }

 echo json_encode($data);

