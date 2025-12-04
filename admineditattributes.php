<?php include ("./controller/mainadmin.php");
$newattribute = 1;
$headtext = "Nuevo Atributo";
$clave = "";
$valor = "";
$guidproductmeta = "";

if(isset($_GET['guidproductmeta'])){
    $guidproductmeta = $_GET['guidproductmeta'];
    $query = "SELECT id,
    `key` as clave
    ,content as valor
    ,guidproductmeta
    FROM product_meta
    WHERE isdeleted = 0 AND guidproductmeta = ?";
    $res=$db->prepare($query, array($guidproductmeta));

    if($db->numRows($res)>0){
        $newattribute = 0;
        $row = mysqli_fetch_array($res);
        $clave = $row['clave'];
        $headtext = "Atributo ".$clave;
        $valor = $row['valor'];
        $guidproductmeta = $row['guidproductmeta'];
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
        <script src="js/editattributes.js"></script>

        <?php sectionmenu($db, 6); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menucat|adminattributes|admineditattributes", $trans);?>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form action="controller/editattributes" method="post" id="datosatributos">
                                <input id="create" name="create" type="hidden" value="<?=$newattribute?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidproductmeta?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Atributo
                                        <div class="btn-group ml-auto">
                                            <button type="submit" class="btn btn-sm btn-dark">
                                                Guardar
                                                <i class="mleft-5 fas fa-save"></i>
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="clave-group">
                                                    <label for="clave" class="col-form-label">Clave <abbr class="required">*</abbr></label>
                                                    <input id="clave" name="clave" type="text" class="form-control" value="<?=$clave?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="valor-group">
                                                    <label for="valor" class="col-form-label">Valor <abbr class="required">*</abbr></label>
                                                    <input id="valor" name="valor" type="text" class="form-control" value="<?=$valor?>">
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