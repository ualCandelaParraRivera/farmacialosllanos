<?php include ("./controller/mainadmin.php");
$newbcategory = 1;
$headtext = "Nueva Categoría";
$nombre = "";
$descripcion = "";
$metadatos = "";
$guidpostcategory = "";

if(isset($_GET['guidpostcategory'])){
    $guidpostcategory = $_GET['guidpostcategory'];
    $query = "SELECT title as nombre
        ,content as descripcion
        ,metatitle as metadatos
        ,guidpostcategory
        FROM postcategory c
        WHERE c.isdeleted = 0 AND guidpostcategory = ?";
    $res=$db->prepare($query, array($guidpostcategory));

    if($db->numRows($res)>0){
        $newbcategory = 0;
        $row = mysqli_fetch_array($res);
        $nombre = $row['nombre'];
        $headtext = "Categoría ".$nombre;
        $descripcion = $row['descripcion'];
        $metadatos = $row['metadatos'];
        $guidpostcategory = $row['guidpostcategory'];
    }

}

?>
<!DOCTYPE html>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead($headtext)?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
        <script src="js/editbcat.js"></script>

        <?php sectionmenu($db, 12); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menublog|adminbcategories|admineditbcat", $trans);?>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <form action="controller/editbcat" method="post" id="datosbcategoria">
                                <input id="create" name="create" type="hidden" value="<?=$newbcategory?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidpostcategory?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Categoría
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
                                                <div class="form-group" id="nombre-group">
                                                    <label for="nombre" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                    <input id="nombre" name="nombre" type="text" class="form-control" value="<?=$nombre?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="metadatos-group">
                                                    <label for="metadatos" class="col-form-label">Metadatos</label>
                                                    <input id="metadatos" name="metadatos" type="text" class="form-control" value="<?=$metadatos?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="descripcion-group">
                                                    <label for="descripcion" class="col-form-label">Descripción <abbr class="required">*</abbr></label>
                                                    <textarea id="descripcion" name="descripcion" class="form-control"><?=$descripcion?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php sectionfooter($trans);?>
            
        </div>
        
    </div>

    <?php sectionjs();?>
    
</body>
 
</html>