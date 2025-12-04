<?php include ("main.php");
if(!empty($_POST["shipmenttype"])){ 
    $shipmenttype = $_POST['shipmenttype'];
    $weight = $_POST['weight'];
    $subtotal = $_POST['subtotal'];
    $tax = $_POST['tax'];
    $discount = $_POST['discount'];
    $ship = 0;
    $query = "SELECT shipping FROM envio WHERE type = ? AND ? BETWEEN minweight AND maxweight";
    $res = $db->prepare($query, array($shipmenttype, $weight)); 

    if($db->numRows($res) > 0){ 
        $row = mysqli_fetch_array($res);
        $ship = $row['shipping'];
    }
}
echo json_encode(array("ship" => $ship,
            "total" => $subtotal+$tax+$ship,
            "grandtotal" => $subtotal+$tax+$ship-$discount
            )
        );
?>