<?php include ("main.php");
if(!empty($_POST["country"])){ 
    $query = "SELECT r.id, r.name FROM regions r
    INNER JOIN countries c ON r.country_id = c.id
    WHERE c.name = ? ORDER BY name";
    $res = $db->prepare($query, array($_POST['country'])); 
     
    if($db->numRows($res) > 0){  
        echo '<option value="-1">'.$trans['control_loaddataselect_text1'].'</option>'; 
        while($row = mysqli_fetch_array($res)){   
            echo '<option value="'.$row['name'].'">'.$row['name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="-1">'.$trans['control_loaddataselect_text2'].'</option>'; 
    } 
}else{ 
        echo '<option value="-1">'.$trans['control_loaddataselect_text2'].'</option>'; 
    }
?>