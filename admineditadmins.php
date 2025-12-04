<?php include ("./controller/mainadmin.php");
$newuser = 1;
$headtext = "Nuevo Administrador";
$firstname = "";
$middlename = "";
$lastname = "";
$mobile = "";
$email = "";
$image = "team-1.jpg";
$profile = "";
$intro = "";
$billfirstname = "";
$billmiddlename = "";
$billlastname = "";
$billmobile = "";
$billline1 = "";
$billpostalcode = "";
$billcity = "";
$billprovince = "";
$billcountry = "";
$shipfirstname = "";
$shipmiddlename = "";
$shiplastname = "";
$shipmobile = "";
$shipline = "";
$shippostalcode = "";
$shipcity = "";
$shipprovince = "";
$shipcountry = "";
$guiduser = "";
if(isset($_GET['guiduser'])){
    $guid = $_GET['guiduser'];
    $query = "SELECT id
    ,firstname
    ,middlename
    ,lastname
    ,mobile
    ,email
    ,image
    ,profile
    ,intro
    ,billfirstname
    ,billmiddlename
    ,billlastname
    ,billmobile
    ,billline1
    ,billpostalcode
    ,billcity
    ,billprovince
    ,billcountry
    ,shipfirstname
    ,shipmiddlename
    ,shiplastname
    ,shipmobile
    ,shipline
    ,shippostalcode
    ,shipcity
    ,shipprovince
    ,shipcountry
    ,guiduser
     FROM user
     WHERE guiduser = ?";
    $res=$db->prepare($query, array($guid));
    if($db->numRows($res) > 0){
        $newuser = 0;
        $row = mysqli_fetch_array($res);
        $firstname = $row['firstname'];
        $headtext = "Administrador ".$firstname;
        $middlename = $row['middlename'];
        $lastname = $row['lastname'];
        $mobile = $row['mobile'];
        $email = $row['email'];
        $image = $row['image'];
        $profile = $row['profile'];
        $intro = $row['intro'];
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
        $guiduser = $row['guiduser'];
    }
}



?>
<!DOCTYPE html>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead($headtext)?>
    <!-- <script src='//static.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script> -->
    <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script> -->
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
        <script src="js/editadmin.js"></script>

        <?php sectionmenu($db, 10); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menuuser|adminadmins|admineditadmins", $trans);?>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <form action="controller/editadmin" method="post" id="datospersonales">
                                <input id="create" name="create" type="hidden" value="<?=$newuser?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guiduser?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Personales
                                        <div class="btn-group ml-auto">
                                            <button type="submit" class="btn btn-sm btn-dark">
                                                Guardar
                                                <i class="mleft-5 fas fa-save"></i>
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="firstname-group">
                                                    <label for="firstname" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                    <input id="firstname" name="firstname" type="text" class="form-control" value="<?=$firstname?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="middlename-group">
                                                    <label for="middlename" class="col-form-label">Primer Apellido <abbr class="required">*</abbr></label>
                                                    <input id="middlename" name="middlename" type="text" class="form-control" value="<?=$middlename?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="lastname-group">
                                                    <label for="lastname" class="col-form-label">Segundo Apellido</label>
                                                    <input id="lastname" name="lastname" type="text" class="form-control" value="<?=$lastname?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="email-group">
                                                    <label for="email" class="col-form-label">Correo electrónico <abbr class="required">*</abbr></label>
                                                    <input id="email" name="email" type="email" placeholder="correo@ejemplo.com" class="form-control" value="<?=$email?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="phone-group">
                                                    <label for="phone" class="col-form-label">Teléfono <abbr class="required">*</abbr></label>
                                                    <input id="phone" name="phone" type="number" class="form-control" placeholder="xxx-xx-xx-xx" value="<?=$mobile?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group" id="intro-group">
                                                    <label for="intro" class="col-form-label">Intro <abbr class="required">*</abbr></label>
                                                    <textarea id="intro" name="intro" type="text" class="form-control" rows="1"><?=$intro?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group" id="profile-group">
                                                    <label for="profile" class="col-form-label">Profile <abbr class="required">*</abbr></label>
                                                    <textarea id="profile" name="profile" type="text" class="form-control" rows="2"><?=$profile?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php 
                        if($newuser == 0){
                        ?>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <form enctype="multipart/form-data" action="#" method="POST" id="datosimagen">
                                    <input type="hidden" name="guid" value="<?=$guiduser?>">
                                    <h5 class="card-header">Avatar
                                        <div class="btn-group ml-auto">
                                            <button type="submit" class="btn btn-sm btn-dark">
                                                Guardar
                                                <i class="mleft-5 fas fa-save"></i>
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="card-body">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" name="avatar" class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}" />
                                                <label for="imageUpload"></label>
                                            </div>
                                            <div class="avatar-preview container2">
                                                <div id="imagePreview" style="background-image: url(img/team/<?=$image?>);">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php 
                    if($newuser == 0){
                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <form action="controller/editadmin" method="post" id="datosdirecciones">
                                <input id="edit" name="edit" type="hidden" value="1">
                                <input id="guid" name="guid" type="hidden" value="<?=$guiduser?>">
                                <div class="card">
                                    <h5 class="card-header">Direcciones
                                        <div class="btn-group ml-auto">
                                            <button class="btn btn-sm btn-dark">
                                                Guardar
                                                <i class="mleft-5 fas fa-save"></i>
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <h3>Dirección de Facturación</h3>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billfirstname-group">
                                                            <label for="billfirstname" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                            <input id="billfirstname" name="billfirstname" type="text" class="form-control" value="<?=$billfirstname?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billmiddlename-group">
                                                            <label for="billmiddlename" class="col-form-label">Primer Apellido <abbr class="required">*</abbr></label>
                                                            <input id="billmiddlename" name="billmiddlename" type="text" class="form-control" value="<?=$billmiddlename?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billlastname-group">
                                                            <label for="billlastname" class="col-form-label">Segundo Apellido</label>
                                                            <input id="billlastname" name="billlastname" type="text" class="form-control" value="<?=$billlastname?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billmobile-group">
                                                            <label for="billmobile" class="col-form-label">Teléfono <abbr class="required">*</abbr></label>
                                                            <input id="billmobile" name="billmobile" type="number" placeholder="xxx-xx-xx-xx" class="form-control" value="<?=$billmobile?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billcountry-group">
                                                            <label for="billcountry" class="col-form-label">País <abbr class="required">*</abbr></label>
                                                            <select id="billcountry" name="billcountry" class="select2-basic form-control">
                                                                <option value="">Seleccione un país...</option>
                                                                <?php 
                                                                $query = "SELECT name, id FROM countries ORDER BY name";
                                                                $res=$db->query($query);
                                                                while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                <option value="<?=$row['name']?>" <?php if($row['name']==$billcountry) echo "selected";?>><?=$row['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billdistrict-group">
                                                            <label for="billdistrict" class="col-form-label">Comunidad Autónoma <abbr class="required">*</abbr></label>
                                                            <select id="billdistrict" name="billdistrict" class="select2-basic form-control">
                                                                <option value="">Seleccione una comunidad...</option>
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
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billcity-group">
                                                            <label for="billcity" class="col-form-label">Ciudad <abbr class="required">*</abbr></label>
                                                            <input id="billcity" name="billcity" type="text" class="form-control" value="<?=$billcity?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billpostalcode-group">
                                                            <label for="billpostalcode" class="col-form-label">Código Postal</label>
                                                            <input id="billpostalcode" name="billpostalcode" type="text" class="form-control" value="<?=$billpostalcode?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="billaddress-group">
                                                            <label for="billaddress" class="col-form-label">Dirección <abbr class="required">*</abbr></label>
                                                            <input id="billaddress" name="billaddress" type="text" class="form-control" value="<?=$billline1?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <h3>Dirección de Envío</h3>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shipfirstname-group">
                                                            <label for="shipfirstname" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                            <input id="shipfirstname" name="shipfirstname" type="text" class="form-control" value="<?=$shipfirstname?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shipmiddlename-group">
                                                            <label for="shipmiddlename" class="col-form-label">Primer Apellido <abbr class="required">*</abbr></label>
                                                            <input id="shipmiddlename" name="shipmiddlename" type="text" class="form-control" value="<?=$shipmiddlename?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shiplastname-group">
                                                            <label for="shiplastname" class="col-form-label">Segundo Apellido</label>
                                                            <input id="shiplastname" name="shiplastname" type="text" class="form-control" value="<?=$shiplastname?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shipmobile-group">
                                                            <label for="shipmobile" class="col-form-label">Teléfono <abbr class="required">*</abbr></label>
                                                            <input id="shipmobile" name="shipmobile" type="number" placeholder="xxx-xx-xx-xx" class="form-control" value="<?=$shipmobile?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shipcountry-group">
                                                            <label for="shipcountry" class="col-form-label">País <abbr class="required">*</abbr></label>
                                                            <select id="shipcountry" name="shipcountry" class="select2-basic form-control">
                                                                <option value="">Seleccione un país...</option>
                                                                <?php 
                                                                $query = "SELECT name, id FROM countries ORDER BY name";
                                                                $res=$db->query($query);
                                                                while($row = mysqli_fetch_array($res)){
                                                                ?>
                                                                <option value="<?=$row['name']?>" <?php if($row['name']==$shipcountry) echo "selected";?>><?=$row['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shipdistrict-group">
                                                            <label for="shipdistrict" class="col-form-label">Comunidad Autónoma <abbr class="required">*</abbr></label>
                                                            <select id="shipdistrict" name="shipdistrict" class="select2-basic form-control">
                                                            <option value="">Seleccione una comunidad...</option>
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
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shipcity-group">
                                                            <label for="shipcity" class="col-form-label">Ciudad <abbr class="required">*</abbr></label>
                                                            <input id="shipcity" name="shipcity" type="text" class="form-control" value="<?=$shipcity?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shippostalcode-group">
                                                            <label for="shippostalcode" class="col-form-label">Código Postal</label>
                                                            <input id="shippostalcode" name="shippostalcode" type="text" class="form-control" value="<?=$shippostalcode?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="shipaddress-group">
                                                            <label for="shipaddress" class="col-form-label">Dirección <abbr class="required">*</abbr></label>
                                                            <input id="shipaddress" name="shipaddress" type="text" class="form-control" value="<?=$shipline?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            
            <?php sectionfooter($trans);?>
            
        </div>
        
    </div>

    <?php sectionjs();?>
    <script src="js/avatarupload.js"></script>
    
</body>
 
</html>