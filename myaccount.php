<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<?php 
    if(!isset($_SESSION['usercode']) || $_SESSION['usertype'] < 0) {
        header("location: ".$location_loginuser);
    }
    $query = "SELECT firstname
    , middlename
    , lastname
    , mobile
    , email
    , billfirstname
    , billmiddlename
    , CASE WHEN billlastname IS NULL THEN '' ELSE billlastname END as billlastname
    , billmobile
    , billline1
    , CASE WHEN billpostalcode IS NULL THEN '' ELSE billpostalcode END as billpostalcode
    , billcity
    , billprovince
    , billcountry
    , shipfirstname
    , shipmiddlename
    , CASE WHEN shiplastname IS NULL THEN '' ELSE shiplastname END as shiplastname
    , shipmobile
    , shipline
    , CASE WHEN shippostalcode IS NULL THEN '' ELSE shippostalcode END as shippostalcode
    , shipcity
    , shipprovince
    , shipcountry
    FROM user where isdeleted = 0 AND isvalid = 1 AND id = ? ";
    $res=$db->prepare($query, array($_SESSION['usercode']));
    $row = mysqli_fetch_array($res);
    $firstname = $row['firstname'];
    $middlename = $row['middlename'];
    $lastname = $row['lastname'];
    $mobile = $row['mobile'];
    $email = $row['email'];
    $billfirstname = $row['billfirstname'];
    $billmiddlename = $row['billmiddlename'];
    $billlastname = $row['billlastname'];
    $billmobile = $row['billmobile'];
    $billline1 = $row['billline1'];
    $billpostalcode = $row['billpostalcode'];
    $billcity = $row['billcity'];
    $billprovince = $row['billprovince'];
    $billcountry = $row['billcountry'];
    $shipfirstname = $row['shipfirstname'];
    $shipmiddlename = $row['shipmiddlename'];
    $shiplastname = $row['shiplastname'];
    $shipmobile = $row['shipmobile'];
    $shipline = $row['shipline'];
    $shippostalcode = $row['shippostalcode'];
    $shipcity = $row['shipcity'];
    $shipprovince = $row['shipprovince'];
    $shipcountry = $row['shipcountry'];
?>
<?php 
    /* $res=$db->query("SELECT name FROM user");
    while($row = mysqli_fetch_array($res)){
        echo $row['name'];
    } */
?>
<html class="no-js" lang="<?=$lang?>">

<head>
    <?php sectionhead($db)?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/accountdetails.js"></script>
    <script src="js/billaddress.js"></script>
    <script src="js/shipaddress.js"></script>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb("|myaccount", $trans);?>

    <!-- My Account Section Start -->
    <div class="section section-padding pb-0">
        <div class="container">
            <div class="row learts-mb-n30">

                <!-- My Account Tab List Start -->
                <div class="col-lg-4 col-12 learts-mb-30">
                    <div class="myaccount-tab-list nav">
                        <a href="#dashboard" class="active" data-toggle="tab"><?=$trans['myaccount_tabdashboard']?> <i class="far fa-home"></i></a>
                        <a href="#orders" data-toggle="tab"><?=$trans['myaccount_taborders']?> <i class="far fa-file-alt"></i></a>
                        <!-- <a href="#download" data-toggle="tab">Invoices <i class="far fa-arrow-to-bottom"></i></a> -->
                        <a href="#address" data-toggle="tab"><?=$trans['myaccount_tabaddress']?> <i class="far fa-map-marker-alt"></i></a>
                        <a href="#account-info" data-toggle="tab"><?=$trans['myaccount_tabaccount']?> <i class="far fa-user"></i></a>
                        <?php if($_SESSION['usertype'] == 1){ ?><a href="admin"><?=$trans['myaccount_tabadmin']?> <i class="far fa-cog"></i></a><?php } ?>
                        <a href="logout"><?=$trans['myaccount_tablogout']?> <i class="far fa-sign-out-alt"></i></a>
                    </div>
                </div>
                <!-- My Account Tab List End -->

                <!-- My Account Tab Content Start -->
                <div class="col-lg-8 col-12 learts-mb-30">
                    <div class="tab-content">

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade show active" id="dashboard">
                            <div class="myaccount-content dashboard">

                                <p><?=$trans['myaccount_dashboardhello']?> <strong><?=$firstname?></strong></p>
                                <p><?=$trans['myaccount_dashboardmessage']?></p>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="orders">
                            <div class="myaccount-content order">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?=$trans['myaccount_ordertable_order']?></th>
                                                <th><?=$trans['myaccount_ordertable_date']?></th>
                                                <th><?=$trans['myaccount_ordertable_status']?></th>
                                                <th><?=$trans['myaccount_ordertable_total']?></th>
                                                <th><?=$trans['myaccount_ordertable_action']?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query = "SELECT DATE_FORMAT(createdAt, '%d/%m/%Y %H:%i') as date
                                            ,CASE status WHEN 0 THEN '".$trans['myaccount_orderstatus0']."'
                                            WHEN 1 THEN '".$trans['myaccount_orderstatus1']."'
                                            WHEN 2 THEN '".$trans['myaccount_orderstatus2']."'
                                            WHEN 3 THEN '".$trans['myaccount_orderstatus3']."'
                                            WHEN 4 THEN '".$trans['myaccount_orderstatus4']."'
                                            WHEN 5 THEN '".$trans['myaccount_orderstatus5']."'
                                            WHEN 6 THEN '".$trans['myaccount_orderstatus6']."'
                                            WHEN 7 THEN '".$trans['myaccount_orderstatus7']."' END as status
                                            ,grandtotal as total
                                            ,guidorder
                                            FROM `hempleaf`.`user` u
                                            LEFT JOIN `hempleaf`.`order` o ON u.id = o.userId
                                            WHERE u.isdeleted = 0 and u.isvalid = 1 AND o.isdeleted = 0 AND u.id = ?";
                                            $res=$db->prepare($query, array($_SESSION['usercode']));
                                            $i=1;
                                            while($row = mysqli_fetch_array($res)){
                                                $date = $row['date'];
                                                $status = $row['status'];
                                                $total = $row['total'];
                                                $guidorder = $row['guidorder'];
                                            ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$date?></td>
                                                <td><?=$status?></td>
                                                <td><?=$total?>€</td>
                                                <td><a href="orderview?guidorder=<?=$guidorder?>"><?=$trans['myaccount_orderview']?></a></td>
                                            </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <!-- <div class="tab-pane fade" id="download">
                            <div class="myaccount-content download">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Invoice No.</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>FR019725</td>
                                                <td>22 Agosto 2018</td>
                                                <td>Paid</td>
                                                <td><a href="#"><i class="far fa-arrow-to-bottom mr-1"></i> Download File</a></td>
                                            </tr>
                                            <tr>
                                                <td>FR019726</td>
                                                <td>12 Septiembre 2018</td>
                                                <td>Denied</td>
                                                <td><a href="#"><i class="far fa-arrow-to-bottom mr-1"></i> Download File</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="address">
                            <div class="myaccount-content address">
                                <p><?=$trans['myaccount_addresstitle']?></p>
                                <div class="row learts-mb-n30">
                                    <div class="col-md-6 col-12 learts-mb-30">
                                        <h4 class="title"><?=$trans['myaccount_addressbilling']?> <a href="#billingaddresform" data-toggle="collapse" class="edit-link"><?=$trans['myaccount_addressedit']?></a></h4>
                                        <address>
                                            <p><strong><?=$billfirstname?> <?=$billmiddlename?></strong></p>
                                            <p><?=$billline1?><br>
                                                <?=$billcity?><?php if(!empty($billpostalcode)){ echo ", ".$billpostalcode;}?>, <?=$billprovince?>, <?=$billcountry?></p>
                                            <p><?=$trans['myaccount_addressmobile']?>: <?=$billmobile?></p>
                                        </address>
                                        
                                    </div>
                                    <div class="col-md-6 col-12 learts-mb-30">
                                        <h4 class="title"><?=$trans['myaccount_addressshipping']?> <a href="#shippingaddresform" data-toggle="collapse" class="edit-link"><?=$trans['myaccount_addressedit']?></a></h4>
                                        <address>
                                            <p><strong><?=$shipfirstname?> <?=$shipmiddlename?></strong></p>
                                            <p><?=$shipline?><br>
                                            <?=$shipcity?><?php if(!empty($shippostalcode)){ echo ", ".$shippostalcode;}?>, <?=$shipprovince?>, <?=$shipcountry?></p>
                                            <p><?=$trans['myaccount_addressmobile']?>: <?=$shipmobile?></p>
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div id="billingaddresform" class="collapse learts-mt-30" data-parent="#address">
                                <div class="address-form">
                                    <p><?=$trans['myaccount_billingtitle']?></p>
                                    <form id="billaddrForm" action="#" method="post" class="learts-mb-n10">
                                        <div class="row" id="billrow">
                                            <div class="col-md-6 col-12 learts-mb-20 form-group" id="billFirstName-group">
                                                <label for="billFirstName"><?=$trans['myaccount_billingfirstname']?> <abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="<?=$billfirstname?>" name="billFirstName" id="billFirstName">
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-20 form-group" id="billMiddleName-group">
                                                <label for="billMiddleName"><?=$trans['myaccount_billingmiddlename']?> <abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="<?=$billmiddlename?>" name="billMiddleName" id="billMiddleName">
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-20 form-group" id="billLastName-group">
                                                <label for="billLastName"><?=$trans['myaccount_billinglastname']?></label>
                                                <input type="text" class="form-control" value="<?=$billlastname?>" name="billLastName" id="billLastName">
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30 form-group" id="billPhone-group">
                                                <label for="billPhone"><?=$trans['myaccount_billingphone']?> <abbr class="required">*</abbr></label>
                                                <input type="tel" class="form-control" value="<?=$billmobile?>" name="billPhone" id="billPhone" pattern="^\+?(?:[0-9] ?){6,14}[0-9]$">
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="billCountry-group">
                                                <label for="billCountry"><?=$trans['myaccount_billingcountry']?> <abbr class="required">*</abbr></label>
                                                <select id="billCountry" name="billCountry" class="select2-basic form-control">
                                                    <option value=""><?=$trans['myaccount_billingcountryselect']?></option>
                                                    <?php 
                                                    $query = "SELECT name, id FROM countries ORDER BY name";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <option value="<?=$row['name']?>" <?php if($row['name']==$billcountry) echo "selected";?>><?=$row['name']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="billDistrict-group">
                                                <label for="billDistrict"><?=$trans['myaccount_billingdistrict']?> <abbr class="required">*</abbr></label>
                                                <select id="billDistrict" name="billDistrict" class="select2-basic form-control">
                                                <?php 
                                                    $query = "SELECT r.id, r.name FROM regions r
                                                    INNER JOIN countries c ON r.country_id = c.id
                                                    WHERE c.name = ? ORDER BY name";
                                                    $res=$db->prepare($query,array($billcountry));
                                                    while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <option value="<?=$row['name']?>" <?php if($row['name']==$billprovince) echo "selected";?>><?=$row['name']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="billTownOrCity-group">
                                                <label for="billTownOrCity"><?=$trans['myaccount_billingcity']?> <abbr class="required">*</abbr></label>
                                                <input type="text" value="<?=$billcity?>" class="form-control" name="billTownOrCity" id="billTownOrCity">
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="billPostcode-group">
                                                <label for="billPostcode"><?=$trans['myaccount_billingpostcode']?></label>
                                                <input type="text" class="form-control" value="<?=$billpostalcode?>" name="billPostcode" id="billPostcode">
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="billAddress1-group">
                                                <label for="billAddress1"><?=$trans['myaccount_billingstreet']?> <abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="<?=$billline1?>" name="billAddress1" id="billAddress1" placeholder="<?=$trans['myaccount_billingstreetph']?>">
                                                
                                                <label for="billAddress2" class="sr-only"><?=$trans['myaccount_billingstreet2']?></label>
                                                <input type="text" class="form-control" name="billAddress2" id="billAddress2" placeholder="<?=$trans['myaccount_billingstreet2ph']?>">
                                            </div>
                                            <div class="col-12 learts-mb-20 form-group">
                                                <button type="submit" class="btn btn-dark btn-outline-hover-dark learts-mb-10"><?=$trans['myaccount_billingsave']?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="shippingaddresform" class="collapse learts-mt-30" data-parent="#address">
                                <div class="address-form">
                                    <p><?=$trans['myaccount_shippingtitle']?></p>
                                    <form id="shipaddrForm" action="#" method="post" class="learts-mb-n10">
                                        <!-- <input class="learts-mb-10" type="text" placeholder="Coupon code">
                                        <input class="learts-mb-10" type="text" placeholder="Coupon code">
                                        <button class="btn btn-dark btn-outline-hover-dark learts-mb-10">apply coupon</button> -->
                                        <div class="row" id="shiprow">
                                            <div class="col-md-6 col-12 learts-mb-20 form-group" id="shipFirstName-group">
                                                <label for="shipFirstName"><?=$trans['myaccount_billingfirstname']?> <abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="<?=$shipfirstname?>" name="shipFirstName" id="shipFirstName">
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-20 form-group" id="shipMiddleName-group">
                                                <label for="shipMiddleName"><?=$trans['myaccount_billingmiddlename']?> <abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="<?=$shipmiddlename?>" name="shipMiddleName" id="shipMiddleName">
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-20 form-group" id="shipLastName-group">
                                                <label for="shipLastName"><?=$trans['myaccount_billinglastname']?></label>
                                                <input type="text" class="form-control" value="<?=$shiplastname?>" name="shipLastName" id="shipLastName">
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30 form-group" id="shipPhone-group">
                                                <label for="shipPhone"><?=$trans['myaccount_billingphone']?> <abbr class="required">*</abbr></label>
                                                <input type="tel" class="form-control" value="<?=$shipmobile?>" name="shipPhone" id="shipPhone" pattern="^\+?(?:[0-9] ?){6,14}[0-9]$">
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="shipCountry-group">
                                                <label for="shipCountry"><?=$trans['myaccount_billingcountry']?> <abbr class="required">*</abbr></label>
                                                <select id="shipCountry" name="shipCountry" class="select2-basic form-control">
                                                    <option value=""><?=$trans['myaccount_billingcountryselect']?></option>
                                                    <?php 
                                                    $query = "SELECT name, id FROM countries ORDER BY name";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <option value="<?=$row['name']?>" <?php if($row['name']==$shipcountry) echo "selected";?>><?=$row['name']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="shipDistrict-group">
                                                <label for="shipDistrict"><?=$trans['myaccount_billingdistrict']?> <abbr class="required">*</abbr></label>
                                                <select id="shipDistrict" name="shipDistrict" class="select2-basic form-control">
                                                <?php 
                                                    $query = "SELECT r.id, r.name FROM regions r
                                                    INNER JOIN countries c ON r.country_id = c.id
                                                    WHERE c.name = ? ORDER BY name";
                                                    $res=$db->prepare($query,array($shipcountry));
                                                    while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <option value="<?=$row['name']?>" <?php if($row['name']==$shipprovince) echo "selected";?>><?=$row['name']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="shipTownOrCity-group">
                                                <label for="shipTownOrCity"><?=$trans['myaccount_billingcity']?> <abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="<?=$shipcity?>" name="shipTownOrCity" id="shipTownOrCity">
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="shipPostcode-group">
                                                <label for="shipPostcode"><?=$trans['myaccount_billingpostcode']?></label>
                                                <input type="text" class="form-control" value="<?=$shippostalcode?>" name="shipPostcode" id="shipPostcode">
                                            </div>
                                            <div class="col-6 learts-mb-20 form-group" id="shipAddress1-group">
                                                <label for="shipAddress1"><?=$trans['myaccount_billingstreet']?> <abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="<?=$shipline?>" name="shipAddress1" id="shipAddress1" placeholder="<?=$trans['myaccount_billingstreetph']?>">
                                                
                                                <label for="shipAddress2" class="sr-only"><?=$trans['myaccount_billingstreet2']?></label>
                                                <input type="text" class="form-control" name="shipAddress2" id="shipAddress2" placeholder="<?=$trans['myaccount_billingstreet2ph']?>">
                                            </div>
                                            <div class="col-12 learts-mb-20 form-group">
                                                <button type="submit" class="btn btn-dark btn-outline-hover-dark learts-mb-10"><?=$trans['myaccount_billingsave']?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="account-info">
                            <div class="myaccount-content account-details">
                                <div class="account-details-form">
                                    <form action="controller/accountdetails" method="post" id="accountdetailsForm">
                                        <div class="row learts-mb-n30">
                                            <div class="col-md-6 col-12 learts-mb-30 form-group" id="firstname-group">
                                                <div class="single-input-item">
                                                    <label for="firstname"><?=$trans['myaccount_accountfirstname']?> <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?=$firstname?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30 form-group" id="middlename-group">
                                                <div class="single-input-item">
                                                    <label for="middlename"><?=$trans['myaccount_accountmiddlename']?> <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" name="middlename" id="middlename" value="<?=$middlename?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30 form-group" id="lastname-group">
                                                <div class="single-input-item">
                                                    <label for="lastname"><?=$trans['myaccount_accountlastname']?></label>
                                                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?=$lastname?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30 form-group" id="mobile-group">
                                                <label for="mobile"><?=$trans['myaccount_accountphone']?> <abbr class="required">*</abbr></label>
                                                <input type="phone" class="form-control" name="mobile" id="mobile" value="<?=$mobile?>" pattern="^\+?(?:[0-9] ?){6,14}[0-9]$">
                                            </div>
                                            <div class="col-12 learts-mb-30 form-group" id="email-group">
                                                <label for="email"><?=$trans['myaccount_accountemail']?> <abbr class="required">*</abbr></label>
                                                <input type="email" class="form-control" name="email" id="email" value="<?=$email?>">
                                            </div>
                                            <div class="col-12 learts-mb-30 learts-mt-30">
                                                <fieldset>
                                                    <legend><?=$trans['myaccount_accountpasswordtitle']?></legend>
                                                    <div class="row learts-mb-n30">
                                                        <div class="col-12 learts-mb-30 form-group" id="currentpwd-group">
                                                            <label for="currentpwd"><?=$trans['myaccount_accountcurrentpass']?></label>
                                                            <input class="form-control" type="password" name="currentpwd" id="currentpwd">
                                                        </div>
                                                        <div class="col-12 learts-mb-30 form-group" id="newpwd-group">
                                                            <label for="newpwd"><?=$trans['myaccount_accountnewpass']?></label>
                                                            <input class="form-control" type="password" name="newpwd" id="newpwd">
                                                        </div>
                                                        <div class="col-12 learts-mb-30 form-group" id="confirmpwd-group">
                                                            <label for="confirmpwd"><?=$trans['myaccount_accountconfirm']?></label>
                                                            <input class="form-control" type="password" name="confirmpwd" id="confirmpwd">
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-12 learts-mb-30">
                                                <button type="submit" class="btn btn-dark btn-outline-hover-dark"><?=$trans['myaccount_accountsave']?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- Single Tab Content End -->

                    </div>
                </div> <!-- My Account Tab Content End -->
            </div>
        </div>
    </div>
    <!-- My Account Section End -->
    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

<?php sectionjs();?>
</body>