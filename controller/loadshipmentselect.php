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

// echo '<div class="card text-center" style="width: 18rem;">
// <div class="card-body">
//     <h5 class="card-title">GLS Economy</h5>
//     <p class="card-text">'.$trans['checkout_shipping_eco'].'</p>
//     <input type="radio" class="radio-custom input-group-field" name="options" id="option1" autocomplete="off" style="display: none;" value="'.$glseco.'"'.$ecodisabled.'><label class="btn btn-secondary radio-custom input-group-field" for="option1"><i class="fa fa-truck"></i></label>
// </div>
// </div>
// <div class="card text-center" style="width: 18rem;">
// <div class="card-body">
//     <h5 class="card-title">GLS 24</h5>
//     <p class="card-text">'.$trans['checkout_shipping_gls24'].'</p>
//     <input type="radio" class="radio-custom input-group-field" name="options" id="option2" autocomplete="off" style="display: none;" value="'.$gls24.'"'.$gls24disabled.'><label class="btn btn-secondary radio-custom input-group-field" for="option2"><i class="fa fa-truck"></i></label>
// </div>
// </div>
// <div class="card text-center" style="width: 18rem;">
// <div class="card-body">
//     <h5 class="card-title">GLS 14</h5>
//     <p class="card-text">'.$trans['checkout_shipping_gls14'].'</p>
//     <input type="radio" class="radio-custom input-group-field" name="options" id="option3" autocomplete="off" style="display: none;" value="'.$gls14.'"'.$gls14disabled.'><label class="btn btn-secondary radio-custom input-group-field" for="option3"><i class="fa fa-truck"></i></label>
// </div>
// </div>
// <div class="card text-center" style="width: 18rem;">
// <div class="card-body">
//     <h5 class="card-title">GLS 10</h5>
//     <p class="card-text">'.$trans['checkout_shipping_gls10'].'</p>
//     <input type="radio" class="radio-custom input-group-field" name="options" id="option4" autocomplete="off" style="display: none;" value="'.$gls10.'"'.$gls10disabled.'><label class="btn btn-secondary radio-custom input-group-field" for="option4"><i class="fa fa-truck"></i></label>
// </div>
// </div>
// <div class="card text-center" style="width: 18rem;">
// <div class="card-body">
//     <h5 class="card-title">GLS Islas</h5>
//     <p class="card-text">'.$trans['checkout_shipping_glsislas'].'</p>
//     <input type="radio" class="radio-custom input-group-field" name="options" id="option5" autocomplete="off" style="display: none;" value="'.$glsislas.'"'.$glsislasdisabled.'><label class="btn btn-secondary radio-custom input-group-field" for="option5"><i class="fa fa-truck"></i></label>
// </div>
// </div>';

?>