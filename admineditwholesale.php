<?php include("./controller/mainadmin.php");
$newwholesale = 1;
$headtext = "Nuevo Wholesale";
$imagen = "wholesale1.png";
$sku = "";
$nombre = "";
$metadatos = "";
$resumen = "";
$descripcion = "";
$name = "";
$metadata = "";
$summary = "";
$description = "";
$guidwholesale = "";

if (isset($_GET['guidwholesale'])) {
    $guidwholesale = $_GET['guidwholesale'];
    $query = "SELECT w.image as imagen
    ,w.sku
    ,wt.title as nombre
    ,wt.metatitle as metadatos
    ,wt.summary as resumen
    ,wt.content as descripcion
    ,wt2.title as name
    ,wt2.metatitle as metadata
    ,wt2.summary as summary
    ,wt2.content as description
    ,w.guidwholesale
    FROM wholesale w
    LEFT JOIN wholesale_translation wt ON w.id = wt.wholesaleId AND wt.lang = 'es'
    LEFT JOIN wholesale_translation wt2 ON w.id = wt2.wholesaleId AND wt2.lang = 'en'
    WHERE w.isdeleted = 0 AND w.guidwholesale = ?";
    $res = $db->prepare($query, array($guidwholesale));

    if ($db->numRows($res) > 0) {
        $newwholesale = 0;
        $row = mysqli_fetch_array($res);
        $nombre = $row['nombre'];
        $headtext = "Wholesale " . $nombre;
        $imagen = $row['imagen'];
        $sku = $row['sku'];
        $metadatos = $row['metadatos'];
        $descripcion = $row['descripcion'];
        $resumen = $row['resumen'];
        $name = $row['name'];
        $metadata = $row['metadata'];
        $description = $row['description'];
        $summary = $row['summary'];
        $guidwholesale = $row['guidwholesale'];
    }
}

?>
<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <?php sectionhead($headtext) ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/editwholesale.js"></script>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 8); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menucat|adminwholesales|admineditwholesale", $trans); ?>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <form action="controller/editwholesale" method="post" id="datoswholesale">
                                <input id="create" name="create" type="hidden" value="<?=$newwholesale?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidwholesale?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Wholesale (Español)
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
                                                <div class="form-group" id="sku-group">
                                                    <label for="sku" class="col-form-label">SKU <abbr class="required">*</abbr></label>
                                                    <input id="sku" name="sku" type="text" class="form-control" value="<?=$sku?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="nombre-group">
                                                    <label for="nombre" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                    <input id="nombre" name="nombre" type="text" class="form-control" value="<?=$nombre?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="metadatos-group">
                                                    <label for="metadatos" class="col-form-label">Metadatos <abbr class="required">*</abbr></label>
                                                    <input id="metadatos" name="metadatos" type="text" class="form-control" value="<?=$metadatos?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="resumen-group">
                                                    <label for="resumen" class="col-form-label">Resumen <abbr class="required">*</abbr></label>
                                                    <textarea id="resumen" name="resumen" class="form-control" rows="1"><?=$resumen?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="descripcion-group">
                                                    <label for="descripcion" class="col-form-label">Descripción <abbr class="required">*</abbr></label>
                                                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4"><?=$descripcion?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Datos Wholesale (English)</h5>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="name-group">
                                                    <label for="name" class="col-form-label">Name <abbr class="required">*</abbr></label>
                                                    <input id="name" name="name" type="text" class="form-control" value="<?=$name?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="metadata-group">
                                                    <label for="metadata" class="col-form-label">Metadata <abbr class="required">*</abbr></label>
                                                    <input id="metadata" name="metadata" type="text" class="form-control" value="<?=$metadata?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="summary-group">
                                                    <label for="summary" class="col-form-label">Summary <abbr class="required">*</abbr></label>
                                                    <textarea id="summary" name="summary" class="form-control" rows="1"><?=$summary?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="description-group">
                                                    <label for="description" class="col-form-label">Description <abbr class="required">*</abbr></label>
                                                    <textarea id="description" name="description" class="form-control" rows="4"><?=$description?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php 
                        if($newwholesale == 0){
                        ?>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <form enctype="multipart/form-data" action="#" method="POST" id="datosimagen">
                                    <input id="edit" name="edit" type="hidden" value="<?=$newwholesale?>">
                                    <input type="hidden" name="guid" value="<?=$guidwholesale?>">
                                    <h5 class="card-header">Logo
                                        <div class="btn-group ml-auto">
                                            <button type="submit" class="btn btn-sm btn-dark">
                                                Guardar
                                                <i class="mleft-5 fas fa-save"></i>
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="card-body">
                                        <div class="avatar-upload avatar-upload-cover">
                                            <div class="avatar-edit">
                                                <input type='file' id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}" />
                                                <label for="imageUpload"></label>
                                            </div>
                                            <div class="avatar-preview avatar-cover container2">
                                                <div id="imagePreview" style="background-image: url(img/wholesale/<?=$imagen?>);">
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
    <script src="js/avatarupload.js"></script>

</body>

</html>