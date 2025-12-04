<?php include ("main.php");
if(!empty($_POST["district"])){ 
    $district = $_POST['district'];
    $weight = $_POST['weight'];
    if($district <> "Canarias" && $district <> "Islas Baleares"){
        $district = "";
    }
    $query = "SELECT UPPER(type) as name, type, shipping
    FROM envio
    WHERE ? BETWEEN minweight AND maxweight AND isles = ?
    GROUP BY type, isles";
    $res = $db->prepare($query, array($weight, $district)); 

    if($db->numRows($res) > 0){  
        echo '<option value="">Selecciona un plan de envío...</option>'; 
        while($row = mysqli_fetch_array($res)){   
            echo '<option value="'.$row['type'].'">'.$row['name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Selecciona primero una comunidad</option>'; 
    } 
}else{ 
        echo '<option value="">Selecciona primero una comunidad</option>'; 
    }
?>