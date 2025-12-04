<?php
include ("mainadmin.php");
if(isset($_POST['op']) && $_POST['op']=="add"){
    if(empty($_POST['id'])){
        echo json_encode(array("errorproduct" => 'Debes seleccionar un producto'
            )
        );
    }else if(empty($_POST['qty'])){
        echo json_encode(array("errorquantity" => 'Debes indicar una cantidad'
            )
        );
    }else if(intval($_POST['qty']) < 0){
        echo json_encode(array("errorquantity" => 'Debes indicar una cantidad positiva'
            )
        );
    }else{
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        if(!isset($_POST['datas'])){
            $datas = array();
        }else{
            $datas = $_POST['datas'];
        }
        $promo = $_POST['promo'];
    
        $subtotal = 0;
        $impuestos = 0;
        $envio = 0;
        $weight = 0;
        $total = 0;
        $descuento = 0;
        $promodescuento = 0;
        
        $importefinal = 0;
        $query = "SELECT ROUND((1-discount)*pricenotax,2) as subtotal
        ,ROUND((1-discount)*pricenotax*tax,2) as impuestos
        ,weight
        ,ROUND(pricenotax*discount,2) as descuento
        ,ROUND(price,2) as total
        FROM product p WHERE p.id = ?";
        for ($i=0; $i < count($datas); $i++) {
            $pid = intval($datas[$i][0]);
            $q = intval($datas[$i][1]);
            $res=$db->prepare($query, array($pid));
            $row = mysqli_fetch_array($res);
            $subtotal += $row['subtotal'] * $q;
            $impuestos += $row['impuestos'] * $q;
            $weight += $row['weight'] * $q;
            $total += $row['total'] * $q;
            $descuento += $row['descuento'] * $q;
        }
    
        $res=$db->prepare($query, array($id));
        $row = mysqli_fetch_array($res);
        $subtotal += $row['subtotal'] * $qty;
        $impuestos += $row['impuestos'] * $qty;
        $weight += $row['weight'] * $qty;
        $total += $row['total'] * $qty;
        $descuento += $row['descuento'] * $qty;
    
        $query = "SELECT id, discount, min, max FROM promo WHERE id = ?";
        $res=$db->prepare($query, array($promo));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $ppromo = $row['discount'];
            $pmin = $row['min'];
            $pmax = $row['max'];
            if($total > $pmin){
                $promodescuento = $total * $ppromo;
                if($promodescuento > $pmax){
                    $promodescuento = $pmax;
                }
            }
            
        }
    
        $importefinal = $total - $promodescuento;
    
        $query = "SELECT p.id
        ,p.sku
        ,pt.summary as product
        ,ROUND(p.pricenotax, 2) as price
        ,ROUND(p.discount*100, 2) as discount
        ,? as quantity
        ,ROUND((1-discount)*pricenotax*?,2) as subtotal
        FROM product p
        LEFT JOIN product_translation pt ON p.id = pt.productId
        WHERE pt.lang = 'es' AND p.isdeleted = 0 AND p.id = ?";
        $res=$db->prepare($query, array($qty, $qty, $id));
        $row = mysqli_fetch_array($res);
    
        echo json_encode(array("id" => $row['id'],
            "sku" => $row['sku'],
            "product" => $row['product'],
            "price" => $row['price'],
            "discount" => $row['discount'],
            "quantity" => $row['quantity'],
            "subtotal" => $row['subtotal'],
            "sumsubtotal" => $subtotal,
            "sumimpuestos" => $impuestos,
            "weight" => $weight,
            "sumenvio" => $envio,
            "sumdescuento" => $descuento,
            "sumtotal" => $total,
            "promodescuento" => $promodescuento,
            "importefinal" => $importefinal
            )
        );
    }
}else if(isset($_POST['op']) && $_POST['op']=="edit"){
    if(empty($_POST['id'])){
        echo json_encode(array("errorproduct" => 'Debes seleccionar un producto'
            )
        );
    }else if(empty($_POST['qty'])){
        echo json_encode(array("errorquantity" => 'Debes indicar una cantidad'
            )
        );
    }else if(intval($_POST['qty']) < 0){
        echo json_encode(array("errorquantity" => 'Debes indicar una cantidad positiva'
            )
        );
    }else{
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        if(!isset($_POST['datas'])){
            $datas = array();
        }else{
            $datas = $_POST['datas'];
        }
        $promo = $_POST['promo'];
        $remid = intval($_POST['remid']);
        $remqty = intval($_POST['remqty']);
    
        $subtotal = 0;
        $impuestos = 0;
        $envio = 0;
        $weight = 0;
        $total = 0;
        $descuento = 0;
        $promodescuento = 0;
        
        $importefinal = 0;
        $query = "SELECT ROUND((1-discount)*pricenotax,2) as subtotal
        ,ROUND((1-discount)*pricenotax*tax,2) as impuestos
        ,weight
        ,ROUND(pricenotax*discount,2) as descuento
        ,ROUND(price,2) as total
        FROM product p WHERE p.id = ?";
        for ($i=0; $i < count($datas); $i++) {
            $pid = intval($datas[$i][0]);
            $q = intval($datas[$i][1]);
            $res=$db->prepare($query, array($pid));
            $row = mysqli_fetch_array($res);
            $subtotal += $row['subtotal'] * $q;
            $impuestos += $row['impuestos'] * $q;
            $weight += $row['weight'] * $q;
            $total += $row['total'] * $q;
            $descuento += $row['descuento'] * $q;
        }
    
        $query = "SELECT ROUND((1-discount)*pricenotax,2) as subtotal
        ,ROUND((1-discount)*pricenotax*tax,2) as impuestos
        ,weight
        ,ROUND(pricenotax*discount,2) as descuento
        ,ROUND(price,2) as total
        FROM product p WHERE p.id = ?";
        $res=$db->prepare($query, array($remid));
        $row = mysqli_fetch_array($res);
        $subtotal -= $row['subtotal'] * $remqty;
        $impuestos -= $row['impuestos'] * $remqty;
        $weight -= $row['weight'] * $remqty;
        $total -= $row['total'] * $remqty;
        $descuento -= $row['descuento'] * $remqty;
        
    
        $res=$db->prepare($query, array($id));
        $row = mysqli_fetch_array($res);
        $subtotal += $row['subtotal'] * $qty;
        $impuestos += $row['impuestos'] * $qty;
        $weight += $row['weight'] * $qty;
        $total += $row['total'] * $qty;
        $descuento += $row['descuento'] * $qty;
    
        $query = "SELECT id, discount, min, max FROM promo WHERE id = ?";
        $res=$db->prepare($query, array($promo));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $ppromo = $row['discount'];
            $pmin = $row['min'];
            $pmax = $row['max'];
            if($total > $pmin){
                $promodescuento = $total * $ppromo;
                if($promodescuento > $pmax){
                    $promodescuento = $pmax;
                }
            }
            
        }
    
        $importefinal = $total - $promodescuento;
    
        $query = "SELECT p.id
        ,p.sku
        ,pt.summary as product
        ,ROUND(p.pricenotax, 2) as price
        ,ROUND(p.discount*100, 2) as discount
        ,? as quantity
        ,ROUND((1-discount)*pricenotax*?,2) as subtotal
        FROM product p
        LEFT JOIN product_translation pt ON p.id = pt.productId
        WHERE pt.lang = 'es' AND p.isdeleted = 0 AND p.id = ?";
        $res=$db->prepare($query, array($qty, $qty, $id));
        $row = mysqli_fetch_array($res);
    
        echo json_encode(array("id" => $row['id'],
            "sku" => $row['sku'],
            "product" => $row['product'],
            "price" => $row['price'],
            "discount" => $row['discount'],
            "quantity" => $row['quantity'],
            "subtotal" => $row['subtotal'],
            "sumsubtotal" => $subtotal,
            "sumimpuestos" => $impuestos,
            "weight" => $weight,
            "sumenvio" => $envio,
            "sumdescuento" => $descuento,
            "sumtotal" => $total,
            "promodescuento" => $promodescuento,
            "importefinal" => $importefinal
            )
        );
    }
    
}else if(isset($_POST['op']) && $_POST['op']=="promo"){
    $promodescuento = 0;
    if(empty($_POST['promocode'])){
        $promodescuento = 0;
        $subtotal = floatval($_POST['subtotal']);
        $tax = floatval($_POST['tax']);
        $shipping = floatval($_POST['shipping']);
        $total = $subtotal + $tax + $shipping;
        $importefinal = $total;
    }else{
        $promocode = intval($_POST['promocode']);
        $subtotal = floatval($_POST['subtotal']);
        $tax = floatval($_POST['tax']);
        $shipping = floatval($_POST['shipping']);
        $query = "SELECT id, discount, min, max FROM promo WHERE id = ?";
        $res=$db->prepare($query, array($promocode));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $ppromo = $row['discount'];
            $pmin = $row['min'];
            $pmax = $row['max'];
            if($subtotal+$tax > $pmin){
                $promodescuento = ($subtotal+$tax) * $ppromo;
                if($promodescuento > $pmax){
                    $promodescuento = $pmax;
                }
            }
            
        }
        $importefinal = $subtotal + $tax + $shipping - $promodescuento;
    }

    
    echo json_encode(array("promodescuento" => $promodescuento,
        "importefinal" => $importefinal
        )
    );
}else if(isset($_POST['op']) && $_POST['op']=="rem"){
    if(!isset($_POST['datas'])){
        $datas = array();
    }else{
        $datas = $_POST['datas'];
    }
    $promo = $_POST['promo'];

    $subtotal = 0;
    $impuestos = 0;
    $envio = 0;
    $weight = 0;
    $total = 0;
    $descuento = 0;
    $promodescuento = 0;
    
    $importefinal = 0;
    $query = "SELECT ROUND((1-discount)*pricenotax,2) as subtotal
    ,ROUND((1-discount)*pricenotax*tax,2) as impuestos
    ,weight
    ,ROUND(pricenotax*discount,2) as descuento
    ,ROUND(price,2) as total
    FROM product p WHERE p.id = ?";
    for ($i=0; $i < count($datas); $i++) {
        $pid = intval($datas[$i][0]);
        $q = intval($datas[$i][1]);
        $res=$db->prepare($query, array($pid));
        $row = mysqli_fetch_array($res);
        $subtotal += $row['subtotal'] * $q;
        $impuestos += $row['impuestos'] * $q;
        $weight += $row['weight'] * $q;
        $total += $row['total'] * $q;
        $descuento += $row['descuento'] * $q;
    }

    $query = "SELECT id, discount, min, max FROM promo WHERE id = ?";
    $res=$db->prepare($query, array($promo));
    if($db->numRows($res) > 0){
        $row = mysqli_fetch_array($res);
        $ppromo = $row['discount'];
        $pmin = $row['min'];
        $pmax = $row['max'];
        if($total > $pmin){
            $promodescuento = $total * $ppromo;
            if($promodescuento > $pmax){
                $promodescuento = $pmax;
            }
        }
        
    }

    $importefinal = $total - $promodescuento;

    echo json_encode(array("sumsubtotal" => $subtotal,
        "sumimpuestos" => $impuestos,
        "weight" => $weight,
        "sumenvio" => $envio,
        "sumdescuento" => $descuento,
        "sumtotal" => $total,
        "promodescuento" => $promodescuento,
        "importefinal" => $importefinal
        )
    );
}


?>