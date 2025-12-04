<?php include("./controller/mainadmin.php");
$newbrand = 1;
$headtext = "Nueva Marca";
$imagen = "brand1.png";
$nombre = "";
$telefono = "";
$email = "";
$introduccion = "";
$descripcion = "";
$guidbrand = "";

if (isset($_GET['guidbrand'])) {
    $guidbrand = $_GET['guidbrand'];
    $query = "SELECT u.image as imagen
    ,u.firstname as nombre
    ,u.mobile as telefono
    ,u.email
    ,u.intro as introduccion
    ,u.profile as descripcion
    ,guiduser as guidbrand
    FROM user u
    WHERE u.vendor = 1 AND u.isdeleted = 0 AND guiduser = ?";
    $res = $db->prepare($query, array($guidbrand));

    if ($db->numRows($res) > 0) {
        $newbrand = 0;
        $row = mysqli_fetch_array($res);
        $nombre = $row['nombre'];
        $headtext = "Marca " . $nombre;
        $imagen = $row['imagen'];
        $telefono = $row['telefono'];
        $email = $row['email'];
        $descripcion = $row['descripcion'];
        $introduccion = $row['introduccion'];
        $guidbrand = $row['guidbrand'];
    }
}

?>
<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <?php sectionhead($headtext) ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/editbrand.js"></script>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 7); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menucat|adminbrands|admineditbrand", $trans); ?>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <form action="controller/editbrand" method="post" id="datosmarca">
                                <input id="create" name="create" type="hidden" value="<?=$newbrand?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidbrand?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Marca
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
                                                <div class="form-group" id="nombre-group">
                                                    <label for="nombre" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                    <input id="nombre" name="nombre" type="text" class="form-control" value="<?=$nombre?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="nombre-group">
                                                    <label for="introduccion" class="col-form-label">Introducción <abbr class="required">*</abbr></label>
                                                    <textarea id="introduccion" name="introduccion" class="form-control" rows="1"><?=$introduccion?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="descripcion-group">
                                                    <label for="descripcion" class="col-form-label">Descripción <abbr class="required">*</abbr></label>
                                                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4"><?=$descripcion?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="telefono-group">
                                                    <label for="telefono" class="col-form-label">Teléfono</label>
                                                    <input id="telefono" name="telefono" type="tel" placeholder="xxx-xx-xx-xx" class="form-control" value="<?=$telefono?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="email-group">
                                                    <label for="email" class="col-form-label">Correo electrónico</label>
                                                    <input id="email" name="email" type="email" placeholder="correo@ejemplo.com" class="form-control" value="<?=$email?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php 
                        if($newbrand == 0){
                        ?>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <form enctype="multipart/form-data" action="#" method="POST" id="datosimagen">
                                    <input id="edit" name="edit" type="hidden" value="<?=$newbrand?>">
                                    <input type="hidden" name="guid" value="<?=$guidbrand?>">
                                    <h5 class="card-header">Logo
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
                                            <div class="avatar-preview avatar-brand container2">
                                                <div id="imagePreview" style="background-image: url(img/brands/<?=$imagen?>);">
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
                </div>
            </div>

            <?php sectionfooter($trans); ?>

        </div>

    </div>

    <?php sectionjs(); ?>
    <!-- <script src="js/avatarupload.js"></script> -->

</body>

</html>