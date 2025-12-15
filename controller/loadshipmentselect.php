<?php include ("main.php");
$glseco = 0;
$ecodisabled = ' disabled';
$gls10 = 0;
$gls10disabled = ' disabled';
$gls14 = 0;
$gls14disabled = ' disabled';
$gls24 = 0;
$gls24disabled = ' disabled';
$glsislas = 0;
$glsislasdisabled = ' disabled';
if(!empty($_POST["district"])){ 
    $district = $_POST['district'];
    $weight = $_POST['weight'];
    if($district <> "Canarias" && $district <> "Islas Baleares"){
        $district = "";
    }
    $query = "SELECT type, shipping, isles
    FROM envio
    WHERE ? BETWEEN minweight AND maxweight AND isles = ?
    GROUP BY type, isles";
    $res = $db->prepare($query, array($weight, $district)); 
    if($db->numRows($res) > 0){
        if($district == ""){
            while($row = mysqli_fetch_array($res)){
                switch ($row['type']) {
                    case 'eco': $glseco = $row['shipping']; break;
                    case 'gls10': $gls10 = $row['shipping']; break;
                    case 'gls14': $gls14 = $row['shipping']; break;
                    case 'gls24': $gls24 = $row['shipping']; break;
                    default: break;
                }
            }
            $ecodisabled = '';
            $gls10disabled = '';
            $gls14disabled = '';
            $gls24disabled = '';
            $glsislasdisabled = ' disabled';
        }else{
            while($row = mysqli_fetch_array($res)){
                switch ($row['type']) {
                    case 'glsislas': $glsislas = $row['shipping']; break;
                    default: break;
                }
            }
            $ecodisabled = ' disabled';
            $gls10disabled = ' disabled';
            $gls14disabled = ' disabled';
            $gls24disabled = ' disabled';
            $glsislasdisabled = '';
        }
    }

}

echo json_encode(array("glseco" => $glseco,
            "ecodisabled" => $ecodisabled,
            "gls24" => $gls24,
            "gls24disabled" => $gls24disabled,
            "gls14" => $gls14,
            "gls14disabled" => $gls14disabled,
            "gls10" => $gls10,
            "gls10disabled" => $gls10disabled,
            "glsislas" => $glsislas,
            "glsislasdisabled" => $glsislasdisabled
            )
        );
?>