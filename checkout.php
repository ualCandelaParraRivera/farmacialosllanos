<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    $products = $db->getCart($lang);
    $quantity = 0;
    $subtotal = 0;
    $taxes = 0;
    $weight = 0;
    foreach($products as $product){
        $quantity += $product->count;
        $subtotal += $product->total;
        $taxes += $product->totaltax;
        // $weight += $product->count * $product->weight;
    }
    if($quantity == 0){
        redirect($location_404);
    }
    if(isset($_SESSION['promo'])){
        if(!empty($_SESSION['promo'])){
            $promos = $db->getPromo();
            foreach($promos as $promo){
                $promocode = $promo->promocode;
                $discount = $promo->discount;
                $min = $promo->min;
                $max = $promo->max;
                $guidpromo = $promo->guidpromo;
            }
        }else{
            $promocode = "";
            $discount = 0;
            $min = -9999999;
            $max = 9999999;
            $guidpromo = "";
        }
    }else{
        $promocode = "";
        $discount = 0;
        $min = -9999999;
        $max = 9999999;
        $guidpromo = "";
    }

    $email = "";
    $billfirstname = "";
    $billmiddlename = "";
    $billlastname = "";
    $billmobile = "";
    $billcountry = "";
    $billprovince = "";
    $billcity = "";
    $billline1 = "";
    $billpostalcode = "";
    $shipfirstname = "";
    $shipmiddlename = "";
    $shiplastname = "";
    $shipmobile = "";
    $shipcountry = "";
    $shipprovince = "";
    $shipcity = "";
    $shipline = "";
    $shippostalcode = "";

    if(isset($_SESSION['usercode'])){
        $query = "SELECT email
        ,billfirstname
        ,billmiddlename
        ,billlastname
        ,billmobile
        ,billcountry
        ,billprovince
        ,billcity
        ,billline1
        ,billpostalcode
        ,shipfirstname
        ,shipmiddlename
        ,shiplastname
        ,shipmobile
        ,shipcountry
        ,shipprovince
        ,shipcity
        ,shipline
        ,shippostalcode
        FROM user
        WHERE isdeleted = 0 AND vendor = 0 AND id = ?";
        $res=$db->prepare($query, array($_SESSION['usercode']));
        if($db->numRows($res)){
            $row = mysqli_fetch_array($res);
            $email = $row['email'];
            $billfirstname = $row['billfirstname'];
            $billmiddlename = $row['billmiddlename'];
            $billlastname = $row['billlastname'];
            $billmobile = $row['billmobile'];
            $billcountry = $row['billcountry'];
            $billprovince = $row['billprovince'];
            $billcity = $row['billcity'];
            $billline1 = $row['billline1'];
            $billpostalcode = $row['billpostalcode'];
            $shipfirstname = $row['shipfirstname'];;
            $shipmiddlename = $row['shipmiddlename'];
            $shiplastname = $row['shiplastname'];
            $shipmobile = $row['shipmobile'];
            $shipcountry = $row['shipcountry'];
            $shipprovince = $row['shipprovince'];
            $shipcity = $row['shipcity'];
            $shipline = $row['shipline'];
            $shippostalcode = $row['shippostalcode'];
        }
    }
    
    if($lang != "en"){
        $locale = "es_ES";
    }else{
        $locale = "en_US";
    }

?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
   
    <script src="https://www.paypal.com/sdk/js?client-id=ASluQE8pQPTJA9GtfFMg3I3EdXssslkTsEhC7WP86lX7ifgcEg-OYKyh9aLtmoZJ68gfJw2k1GpuFS1K&disable-funding=card,sofort&currency=EUR&locale=<?=$locale?>"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|checkout", $trans);?> 

    <!-- Checkout Section Start -->
    <div class="section section-padding pb-0">
        <div class="container">
            <form action="controller/placeorder" method="post" id="checkoutForm" class="checkout-form learts-mb-50" form="checkoutForm">
                <div class="section-title2">
                    <h2 class="title"><?=$trans['checkout_title']?></h2>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12 learts-mb-20 form-group" id="billfirstname-group">
                        <label for="billfirstname"><?=$trans['checkout_firstname']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="billfirstname" id="billfirstname" value="<?=$billfirstname?>">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20 form-group" id="billmiddlename-group">
                        <label for="billmiddlename"><?=$trans['checkout_middlename']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="billmiddlename" id="billmiddlename" value="<?=$billmiddlename?>">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20 form-group" id="billlastname-group">
                        <label for="billlastname"><?=$trans['checkout_lastname']?></label>
                        <input type="text" class="form-control" name="billlastname" id="billlastname" value="<?=$billlastname?>">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30 form-group" id="billmobile-group">
                        <label for="billmobile"><?=$trans['checkout_phone']?> <abbr class="required">*</abbr></label>
                        <input type="tel" class="form-control" name="billmobile" id="billmobile" pattern="^\+?(?:[0-9] ?){6,14}[0-9]$"  value="<?=$billmobile?>">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20 form-group" id="email-group">
                        <label for="email"><?=$trans['checkout_email']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="email" id="email"  value="<?=$email?>">
                    </div>
                    <div class="col-6 learts-mb-20">
                        <label for="billcompany"><?=$trans['checkout_company']?></label>
                        <input type="text" class="form-control" name="billcompany" id="billcompany">
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="billcountry-group">
                        <label for="billcountry"><?=$trans['checkout_country']?> <abbr class="required">*</abbr></label>
                        <select id="billcountry" name="billcountry" class="select2-basic form-control">
                            <option value=""><?=$trans['checkout_countryselect']?></option>
                            <?php 
                            $query = "SELECT name, id FROM countries ORDER BY name";
                            $res=$db->query($query);
                            while($row = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?=$row['name']?>" <?php if($row['name'] == $billcountry){ echo 'selected';} ?>><?=$row['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="billdistrict-group">
                        <label for="billdistrict"><?=$trans['checkout_district']?> <abbr class="required">*</abbr></label>
                        <select id="billdistrict" name="billdistrict" class="select2-basic form-control">
                            <option value=""><?=$trans['checkout_districtph']?></option>
                            <?php 
                             $query = "SELECT r.id, r.name FROM regions r
                             INNER JOIN countries c ON r.country_id = c.id
                             WHERE c.name = ? ORDER BY name";
                            $res=$db->prepare($query, array($billcountry));
                            while($row = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?=$row['name']?>" <?php if($row['name'] == $billprovince){ echo 'selected';} ?>><?=$row['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="billcity-group">
                        <label for="billcity"><?=$trans['checkout_city']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="billcity" id="billcity" value="<?=$billcity?>">
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="billpostalcode-group">
                        <label for="billpostalcode"><?=$trans['checkout_postalcode']?></label>
                        <input type="text" class="form-control" name="billpostalcode" id="billpostalcode" value="<?=$billpostalcode?>">
                    </div>
                    <div class="col-6 learts-mb-60 form-group" id="billaddress1-group">
                        <label for="billaddress1"><?=$trans['checkout_street']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="billaddress1" id="billaddress1"  value="<?=$billline1?>" placeholder="<?=$trans['checkout_streetph']?>">
                        
                        <label for="billaddress2" class="sr-only"><?=$trans['checkout_street2']?></label>
                        <input type="text" class="form-control" name="billaddress2" id="billaddress2" placeholder="<?=$trans['checkout_street2ph']?>">
                    </div>
                    
                </div>
                <input id="paymenttype" name="paymentmethod" type="hidden" value="w">
                <input id="shipmenttype" name="shipmentmethod" type="hidden" value="">
                <input id="shipmentprice" name="shipmentprice" type="hidden" value="-1">
                <input id="weight" name="weight" type="hidden" value="<?=$weight?>">
            
                <div class="section-title2">
                    <h2 class="title"><?=$trans['checkout_shiptitle']?></h2>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12 learts-mb-20 form-group" id="shipfirstname-group">
                        <label for="shipfirstname"><?=$trans['checkout_shipfirstname']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="shipfirstname" id="shipfirstname" value="<?=$shipfirstname?>">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20 form-group" id="shipmiddlename-group">
                        <label for="shipmiddlename"><?=$trans['checkout_shipmiddlename']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="shipmiddlename" id="shipmiddlename" value="<?=$shipmiddlename?>">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20 form-group" id="shiplastname-group">
                        <label for="shiplastname"><?=$trans['checkout_shiplastname']?></label>
                        <input type="text" class="form-control" name="shiplastname" id="shiplastname" value="<?=$shiplastname?>">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30 form-group" id="shipmobile-group">
                        <label for="shipmobile"><?=$trans['checkout_shipphone']?> <abbr class="required">*</abbr></label>
                        <input type="tel" class="form-control" name="shipmobile" id="shipmobile" pattern="^\+?(?:[0-9] ?){6,14}[0-9]$" value="<?=$shipmobile?>">
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="shipcountry-group">
                        <label for="shipcountry"><?=$trans['checkout_shipcountry']?> <abbr class="required">*</abbr></label>
                        <select id="shipcountry" name="shipcountry" class="select2-basic form-control">
                            <option value=""><?=$trans['checkout_shipcountryselect']?></option>
                            <?php 
                            $query = "SELECT name, id FROM countries ORDER BY name";
                            $res=$db->query($query);
                            while($row = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?=$row['name']?>" <?php if($row['name'] == $shipcountry){ echo 'selected';} ?>><?=$row['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="shipdistrict-group">
                        <label for="shipdistrict"><?=$trans['checkout_shipdistrict']?> <abbr class="required">*</abbr></label>
                        <select id="shipdistrict" name="shipdistrict" class="select2-basic form-control">
                            <option value=""><?=$trans['checkout_shipdistrictph']?></option>
                            <?php 
                             $query = "SELECT r.id, r.name FROM regions r
                             INNER JOIN countries c ON r.country_id = c.id
                             WHERE c.name = ? ORDER BY name";
                            $res=$db->prepare($query, array($shipcountry));
                            while($row = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?=$row['name']?>" <?php if($row['name'] == $shipprovince){ echo 'selected';} ?>><?=$row['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="shipcity-group">
                        <label for="shipcity"><?=$trans['checkout_shipcity']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="shipcity" id="shipcity" value="<?=$shipcity?>">
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="shippostalcode-group">
                        <label for="shippostalcode"><?=$trans['checkout_shippostalcode']?></label>
                        <input type="text" class="form-control" name="shippostalcode" id="shippostalcode" value="<?=$shippostalcode?>">
                    </div>
                    <div class="col-6 learts-mb-20 form-group" id="shipaddress1-group">
                        <label for="shipaddress1"><?=$trans['checkout_shipstreet']?> <abbr class="required">*</abbr></label>
                        <input type="text" class="form-control" name="shipaddress1" id="shipaddress1"  value="<?=$shipline?>" placeholder="<?=$trans['checkout_shipstreetph']?>">
                        
                        <label for="shipaddress2" class="sr-only"><?=$trans['checkout_shipstreet2']?></label>
                        <input type="text" class="form-control" name="shipaddress2" id="shipaddress2" placeholder="<?=$trans['checkout_shipstreet2ph']?>">
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="notes"><?=$trans['checkout_notes']?></label>
                        <textarea  name="notes" id="notes" placeholder="<?=$trans['checkout_notesph']?>"></textarea>
                    </div>
                    <?php
                    if(!isset($_SESSION['usercode'])){
                    ?>
                    <div class="col-12 learts-mb-20">
                        <div class="form-check form-group" id="accountCheck-group">
                            <input type="checkbox" class="form-check-input" name="accountCheck" id="accountCheck">
                            <label class="form-check-label" for="accountCheck"><?=$trans['checkout_createaccount']?></label>
                            
                        </div>
                        <div id="accountInput" class="collapse learts-mt-20">
                                <div class="coupon-form">
                                    <p><?=$trans['checkout_createtext']?></p>
                                    <label for="password1"><?=$trans['checkout_createpassword']?> <abbr class="required">*</abbr></label>
                                    <input class="learts-mb-10" name="password1" id="password1" type="password" placeholder="<?=$trans['checkout_createpasswordph']?>">
                                    <label for="password2"><?=$trans['checkout_createconfirmpassword']?> <abbr class="required">*</abbr></label>
                                    <input class="learts-mb-10" name="password2" id="password2" type="password" placeholder="<?=$trans['checkout_createconfirmpasswordph']?>">
                                </div>
                            </div>
                    </div>
                    <?php } ?>
                </div>
            </form>
            <div class="section-title2 text-center">
                <h2 class="title"><?=$trans['checkout_yourship']?></h2>
            </div>
            <div class="row learts-mb-n30">
                <div class="col-lg-12 order-lg-1 learts-mb-30">
                    <div class="order-payment">
                        <div class="shipment-method">
                        <?php if(empty($shipprovince)){
                            $loaddisable = 0;   
                        }else if($shipprovince == 'Canarias' || $shipprovince == 'Islas Baleares'){
                            $loaddisable = 2;
                        }else{
                            $loaddisable = 1;
                        }

                        $query = "SELECT eco, gls24, gls14, gls10, CASE WHEN glsislas IS NULL THEN 0 ELSE glsislas END as glsislas FROM 
                        (SELECT shipping as eco FROM envio WHERE ? BETWEEN minweight AND maxweight AND isles = '' AND type = 'eco') a
                        LEFT JOIN (
                        SELECT shipping as gls24 FROM envio WHERE ? BETWEEN minweight AND maxweight AND isles = '' AND type = 'gls24') gls24 ON 1=1
                        LEFT JOIN (
                        SELECT shipping as gls14 FROM envio WHERE ? BETWEEN minweight AND maxweight AND isles = '' AND type = 'gls14') gls14 ON 1=1
                        LEFT JOIN (
                        SELECT shipping as gls10 FROM envio WHERE ? BETWEEN minweight AND maxweight AND isles = '' AND type = 'gls10') gls10 ON 1=1
                        LEFT JOIN (
                        SELECT shipping as glsislas FROM envio WHERE ? BETWEEN minweight AND maxweight AND isles = ? AND type = 'glsislas') glsislas ON 1=1";
                        $res=$db->prepare($query, array($weight,$weight,$weight,$weight,$weight,$shipprovince));
                        $valeco = 0;
                        $val24 = 0;
                        $val14 = 0;
                        $val10 = 0;
                        $valislas = 0;
                        if($db->numRows($res) > 0){
                            $row = mysqli_fetch_array($res);
                            $valeco = $row['eco'];
                            $val24 = $row['gls24'];
                            $val14 = $row['gls14'];
                            $val10 = $row['gls10'];
                            $valislas = $row['glsislas'];
                        }
                        ?>
                            <div class="accordion" id="shippingMethod">
                                <div class="card-group" id="shipcardgroup">
                                    <div class="card text-center" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">GLS Economy</h5>
                                            <p class="card-text"><?=$trans['checkout_shipping_eco']?></p>
                                            <input type="radio" class="radio-custom input-group-field" name="options" id="option1" autocomplete="off" style="display: none;" value="<?=$valeco?>" <?php if($loaddisable==0 || $loaddisable == 2){ ?>disabled<?php } ?>><label class="btn btn-secondary radio-custom input-group-field" for="option1"><i class="fa fa-truck"></i></label>
                                        </div>
                                    </div>
                                    <div class="card text-center" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">GLS 24</h5>
                                            <p class="card-text"><?=$trans['checkout_shipping_gls24']?></p>
                                            <input type="radio" class="radio-custom input-group-field" name="options" id="option2" autocomplete="off" style="display: none;" value="<?=$val24?>" <?php if($loaddisable==0 || $loaddisable == 2){ ?>disabled<?php } ?>><label class="btn btn-secondary radio-custom input-group-field" for="option2"><i class="fa fa-truck"></i></label>
                                        </div>
                                    </div>
                                    <div class="card text-center" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">GLS 14</h5>
                                            <p class="card-text"><?=$trans['checkout_shipping_gls14']?></p>
                                            <input type="radio" class="radio-custom input-group-field" name="options" id="option3" autocomplete="off" style="display: none;" value="<?=$val14?>" <?php if($loaddisable==0 || $loaddisable == 2){ ?>disabled<?php } ?>><label class="btn btn-secondary radio-custom input-group-field" for="option3"><i class="fa fa-truck"></i></label>
                                        </div>
                                    </div>
                                    <div class="card text-center" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">GLS 10</h5>
                                            <p class="card-text"><?=$trans['checkout_shipping_gls10']?></p>
                                            <input type="radio" class="radio-custom input-group-field" name="options" id="option4" autocomplete="off" style="display: none;" value="<?=$val10?>" <?php if($loaddisable==0 || $loaddisable == 2){ ?>disabled<?php } ?>><label class="btn btn-secondary radio-custom input-group-field" for="option4"><i class="fa fa-truck"></i></label>
                                        </div>
                                    </div>
                                    <div class="card text-center" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">GLS Islas</h5>
                                            <p class="card-text"><?=$trans['checkout_shipping_glsislas']?></p>
                                            <input type="radio" class="radio-custom input-group-field" name="options" id="option5" autocomplete="off" style="display: none;" value="<?=$valislas?>" <?php if($loaddisable==0 || $loaddisable == 1){ ?>disabled<?php } ?>><label class="btn btn-secondary radio-custom input-group-field" for="option5"><i class="fa fa-truck"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-title2 text-center">
                <h2 class="title"><?=$trans['checkout_yourorder']?></h2>
            </div>
            <div class="row learts-mb-n30">
                <div class="col-lg-6 order-lg-2 learts-mb-30">
                    <div class="order-review">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="name"><?=$trans['checkout_yourorderproduct']?></th>
                                    <th class="total"><?=$trans['checkout_yourordersubtotal']?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($products as $product){
                                    $guidproduct = $product->guidproduct;
                                    $title = $product->title;
                                    $imagename = $product->imagename;
                                    $extension = $product->extension;
                                    $price = $product->finalprice;
                                    $quantityitem = $product->count;
                            ?>
                                <tr>
                                    <td class="name"><?=$title?>&nbsp; <strong class="quantity">×&nbsp;<?=$quantityitem?></strong></td>
                                    <td class="total"><span><?=number_format($price, 2, ',', '.')?>€</span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="subtotal">
                                    <th><?=$trans['checkout_yourordersubtotal2']?></th>
                                    <td><span><?=number_format($subtotal, 2, ',', '.')?>€</span></td>
                                </tr>
                                <tr class="subtotal">
                                    <th><?=$trans['checkout_yourordertax']?></th>
                                    <td><span><?=number_format($taxes, 2, ',', '.')?>€</span></td>
                                </tr>
                                <?php
                            $descuento = 0;
                            if(!empty($promocode)){
                                
                                if($subtotal+$taxes >= $min){
                                    $descuento = ($subtotal+$taxes)*$discount;
                                    if($descuento > $max){
                                        $descuento = $max;
                                    }
                                }
                            }
                            $grandtotal = $subtotal + $taxes - $descuento;
                            
                            if($descuento > 0){ ?>
                                <tr class="subtotal">
                                    <th><?=$trans['checkout_yourorderpromo']?></th>
                                    <td><span><?=number_format(-$descuento, 2, ',', '.')?>€</span></td>
                                </tr>
                            <?php } ?>
                                
                                <tr class="subtotal">
                                    <th><?=$trans['checkout_yourordershipping']?></th>
                                    <td id="shippingcost"><span>-€</span></td>
                                </tr>
                                <tr class="total">
                                <input id="finalprice" name="finalprice" type="hidden" value="<?=$grandtotal?>">
                                    <th><?=$trans['checkout_yourordertotal']?></th>
                                    <td id="grandtotal"><strong><span><?=number_format($grandtotal, 2, ',', '.')?>€</span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1 learts-mb-30">
                    <div class="order-payment">
                        <div class="payment-method">
                            <div class="accordion" id="paymentMethod">
                                <div class="card active">
                                    <div class="card-header">
                                        <button data-toggle="collapse" data-target="#wirePayments" id="wirebtn"><?=$trans['checkout_wiretransfer']?> </button>
                                    </div>
                                    <div id="wirePayments" class="collapse show" data-parent="#paymentMethod">
                                        <div class="card-body">
                                            <p><?=$trans['checkout_wiretransfertext']?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <button data-toggle="collapse" data-target="#cardPayments" id="cardbtn"><?=$trans['checkout_credit']?></button>
                                    </div>
                                    <div id="cardPayments" class="collapse" data-parent="#paymentMethod">
                                        <div class="card-body">
                                            <p><?=$trans['checkout_credittext']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="payment-note"><?=$trans['checkout_creditcondition']?></p>
<button class="btn btn-dark btn-outline-hover-dark" type="submit" form="checkoutForm"><?=$trans['checkout_placeorder']?></button>                        </div>
                    </div>
                </div>
            </div>
            <div class="learts-mb-n30" id="placeordergroup"></div>
        </div>
    </div>
    <!-- Checkout Section End -->
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
    <script src="js/placeorder.js"></script>
    <!-- Add the checkout buttons, set up the order and approve the order -->
    <!-- <script>
      paypal.Buttons({
        style : {
        color: 'blue',
        shape: 'pill'
    
    },
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: <?=$grandtotal?>
              }
            }]
          });
        },
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            alert('Transaction completed by ' + details.payer.name.given_name);
          });
        }
      }).render('#paypal-button-container'); // Display payment options on your web page
    </script> -->
</body>