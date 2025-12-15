<?php include ("pdfsender.php");
¡
$type = '1';
$ppidtransaction = NULL;
$ppname= NULL;
$ppsurname = NULL;
$ppemail = NULL;
$ppcountry = NULL;
$ppidpayer = NULL;
$ppprice = NULL;
$ppidmerchant = NULL;
$ppaddress = NULL;
$ppprovince = NULL;
$ppregion = NULL;
$pppostalcode = NULL;
$ppstatus = NULL;
$ppcreatetime = NULL;
$ppupdate_time = NULL;
$ppguidorder = NULL;

$orderid = NULL;
$ouserId = NULL;
$osessionId = NULL;
$otoken = NULL;
$ostatus = NULL;
$osubTotal = NULL;
$oitemDiscount = NULL;
$otax = NULL;
$oshipping = NULL;
$oshippingtype = NULL;
$oweight = NULL;
$ototal = NULL;
$opromoId = NULL;
$odiscount= NULL;
$ograndTotal = NULL;
$oemail = NULL;
$obillfirstName = NULL;
$obillmiddleName = NULL;
$obilllastName = NULL;
$obillmobile = NULL;
$obillline1 = NULL;
$obillpostalcode = NULL;
$obillcity = NULL;
$obillprovince = NULL;
$obillcountry = NULL;
$oshipfirstName = NULL;
$oshipmiddleName = NULL;
$oshiplastName = NULL;
$oshipmobile = NULL;
$oshipline = NULL;
$oshippostalcode = NULL;
$oshipcity = NULL;
$oshipprovince = NULL;
$oshipcountry = NULL;
$ocreatedAt = NULL;
$oupdatedAt = NULL;
$ocontent = NULL;
$oisdeleted = NULL;

$oiid = NULL;
$oiproductId = NULL;
$oiorderId = NULL;
$oisku = NULL;
$oiprice = NULL;
$oidiscount = NULL;
$oiquantity = NULL;
$oicreatedAt = NULL;
$oiupdatedAt = NULL;
$oicontent = NULL;
$oiisdeleted = NULL;
$oiguidorderitem = NULL;



$errors = array();
$data = array(); 

if(isset($_POST['ppidtransaction']) ){
    $ppidtransaction = $_POST['ppidtransaction'];
}

if(isset($_POST['ppname']) ){
    $ppname = $_POST['ppname'];
}

if(isset($_POST['ppsurname'])){
    $ppsurname = $_POST['ppsurname'];
}

if(isset($_POST['ppemail'])){
    $ppemail = $_POST['ppemail'];
}

if(isset($_POST['ppcountry'])){
    $ppcountry = $_POST['ppcountry'];
}

if(isset($_POST['ppidpayer'])){
    $ppidpayer = $_POST['ppidpayer'];
}

if(isset($_POST['ppprice'])){
    $ppprice = $_POST['ppprice'];
}

if(isset($_POST['ppidmerchant'])){
    $ppidmerchant = $_POST['ppidmerchant'];
}

if(isset($_POST['ppaddress'])){
    $ppaddress = $_POST['ppaddress'];
}

if(isset($_POST['ppprovince'])){
    $ppprovince = $_POST['ppprovince'];
}

if(isset($_POST['ppregion'])){
    $ppregion = $_POST['ppregion'];
}

if(isset($_POST['pppostalcode'])){
    $pppostalcode = $_POST['pppostalcode'];
}

if(isset($_POST['ppstatus'])){
    $ppstatus = $_POST['ppstatus'];
}

if(isset($_POST['ppcreatetime'])){
    $ppcreatetime = $_POST['ppcreatetime'];
}

if(isset($_POST['ppupdate_time'])){
    $ppupdate_time = $_POST['ppupdate_time'];
}

if(isset($_POST['ppguidorder'])){
    $ppguidorder = $_POST['ppguidorder'];

    $query = "SELECT id as orderid
    ,userId as ouserId
    ,sessionId as osessionId
    ,token as otoken
    ,status as ostatus
    ,subTotal as osubTotal
    ,itemDiscount as oitemDiscount
    ,tax as otax
    ,shipping as oshipping
    ,shippingtype as oshippingtype
    ,weight as oweight
    ,total as ototal
    ,promoId as opromoId
    ,discount as odiscount
    ,grandTotal as ograndTotal
    ,email as oemail
    ,billfirstName as  obillfirstName
    ,billmiddleName as obillmiddleName
    ,billlastName as obilllastName
    ,billmobile as obillmobile
    ,billline1 as obillline1
    ,billpostalcode as obillpostalcode
    ,billcity as obillcity
    ,billprovince as obillprovince
    ,billcountry as obillcountry
    ,shipfirstName as oshipfirstName
    ,shipmiddleName as oshipmiddleName
    ,shiplastName as oshiplastName
    ,shipmobile as oshipmobile
    ,shipline as oshipline
    ,shippostalcode as oshippostalcode
    ,shipcity as oshipcity
    ,shipprovince as oshipprovince
    ,shipcountry as oshipcountry
    ,createdAt as ocreatedAt
    ,updatedAt as oupdatedAt
    ,content as ocontent
    ,isdeleted  as oisdeleted
    FROM `order` WHERE guidorder = ?";
    $res = $db->prepare($query,array($ppguidorder));    

    if($db->numRows($res) > 0){
        $row = mysqli_fetch_array($res); 
        $orderid = $row['orderid'];
        $ouserId = $row['ouserId'];
        $osessionId = $row['osessionId'];
        $otoken = $row['otoken'];
        $ostatus = $row['ostatus'];
        $osubTotal = $row['osubTotal'];
        $oitemDiscount = $row['oitemDiscount'];
        $otax = $row['otax'];
        $oshipping = $row['oshipping'];
        $oshippingtype = $row['oshippingtype'];
        $oweight = $row['oweight'];
        $ototal = $row['ototal'];
        $opromoId = $row['opromoId'];
        $odiscount = $row['odiscount'];
        $ograndTotal = $row['ograndTotal'];
        $oemail = $row['oemail'];
        $obillfirstName = $row['obillfirstName'];
        $obillmiddleName = $row['obillmiddleName'];
        $obilllastName = $row['obilllastName'];
        $obillmobile = $row['obillmobile'];
        $obillline1 = $row['obillline1'];
        $obillpostalcode = $row['obillpostalcode'];
        $obillcity = $row['obillcity'];
        $obillprovince = $row['obillprovince'];
        $obillcountry = $row['obillcountry'];
        $oshipfirstName = $row['oshipfirstName'];
        $oshipmiddleName = $row['oshipmiddleName'];
        $oshiplastName = $row['oshiplastName'];
        $oshipmobile = $row['oshipmobile'];
        $oshipline = $row['oshipline'];
        $oshippostalcode = $row['oshippostalcode'];
        $oshipcity = $row['oshipcity'];
        $oshipprovince = $row['oshipprovince'];
        $oshipcountry = $row['oshipcountry'];
        $ocreatedAt = $row['ocreatedAt'];
        $oupdatedAt = $row['oupdatedAt'];
        $ocontent = $row['ocontent'];
        $oisdeleted = $row['oisdeleted'];

        $args = array($orderid,$ouserId,$osessionId,$otoken,$ostatus,$osubTotal,$oitemDiscount,$otax,$oshipping,$oshippingtype,$oweight,$ototal,$opromoId,$odiscount,$ograndTotal,$oemail,$obillfirstName,$obillmiddleName,$obilllastName,$obillmobile,$obillline1,$obillpostalcode,$obillcity,$obillprovince,$obillcountry,$oshipfirstName,$oshipmiddleName,$oshiplastName,$oshipmobile,$oshipline,$oshippostalcode,$oshipcity,$oshipprovince,$oshipcountry,$ocreatedAt,$oupdatedAt,$ocontent,$oisdeleted,$ppguidorder,$ppidtransaction,$ppname,$ppsurname,$ppemail,$ppcountry,$ppidpayer,$ppprice,$ppidmerchant,$ppaddress,$ppprovince,$ppregion,$pppostalcode,$ppstatus,$ppcreatetime,$ppupdate_time);
        $query = "INSERT INTO `invoice` (orderid, userId, sessionId, token, status, subTotal, itemDiscount, tax, shipping, shippingtype, weight, total, promoId, discount, grandTotal, email,
        billfirstName, billmiddleName, billlastName, billmobile, billline1, billpostalcode, billcity, billprovince, billcountry, shipfirstName, shipmiddleName, shiplastName,
        shipmobile, shipline, shippostalcode, shipcity, shipprovince, shipcountry, createdAt, updatedAt, content, isdeleted, guidorder, ppidtransaction, ppname, ppsurname, ppemail, ppcountry, ppidpayer, ppprice, ppidmerchant, ppaddress, ppprovince, ppregion, pppostalcode, ppstatus, ppcreatetime, ppupdate_time, invoicedate) VALUES 
         (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $db->prepare($query,$args);
        $lastId = $db->lastID();

        $query = "SELECT id as oiid 
        ,productId as oiproductid
        ,orderId as oiorderid
        ,sku as oisku
        ,price as oiprice
        ,discount as oidiscount
        ,quantity as oiquantity
        ,createdAt as oicreatedAt
        ,updatedAt as oiupdatedAt
        ,content as oicontent 
        ,isdeleted as oiisdeleted
        ,guidorderitem as oiguidorderitem
        FROM order_item WHERE orderid = ?";
        $res = $db->prepare($query,array($orderid));

        while($row = mysqli_fetch_array($res)){
            $oiid = $row['oiid'];
            $oiproductId = $row['oiproductid'];
            $oiorderId = $row['oiorderid'];
            $oisku = $row['oisku'];
            $oiprice = $row['oiprice'];
            $oidiscount = $row['oidiscount'];
            $oiquantity = $row['oiquantity'];
            $oicreatedAt = $row['oicreatedAt'];
            $oiupdatedAt = $row['oiupdatedAt'];
            $oicontent = $row['oicontent'];
            $oiisdeleted = $row['oiisdeleted'];
            $oiguidorderitem = $row['oiguidorderitem'];
            $args = array($lastId,$oiid,$oiproductId,$oiorderId,$oisku,$oiprice,$oidiscount,$oiquantity,$oicreatedAt,$oiupdatedAt,$oicontent,$oiisdeleted,$oiguidorderitem);
          
            $query = "INSERT INTO `invoice_item` (idinvoice, orderiditem, productId, orderId, sku, price, discount, quantity, createdAt, updatedAt, content, isdeleted, guidorderitem, invoiceitemdate) VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $db->prepare($query,$args);
        }
    }
        
    $_SESSION['orderdata'] = NULL;
    $db->emptyCart("","");

    $query = "SELECT email, billfirstname FROM invoice WHERE orderid = ?";       
                
    $res=$db->prepare($query, array($orderid));
    while($row = mysqli_fetch_array($res)){
        $email = $row['email'];
        $billfirstname = $row['billfirstname'];
    }
    sendAttatchment($db, $orderid, $type, $trans, $lang);
}
$data = array('html' => $trans['paypal_checkout_success']);      
 echo json_encode($data);

 