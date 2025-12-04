<?php include ("./controller/mainadmin.php");
$newpromo = 1;
$headtext = "Nueva Promoción";
$codigo = "";
$descripcion = "";
$descuento = "";
$minimo = "";
$maximo = "";
$fechainicio = "";
$fechafin = "";
$guidpromo= "";

if(isset($_GET['guidpromo'])){
    $guidpromo= $_GET['guidpromo'];
    $query = "SELECT promocode as codigo
    ,content as descripcion
    ,ROUND(discount*100,2) as descuento
    ,min as minimo
    ,max as maximo
    ,DATE_FORMAT(startDate, '%Y-%m-%d') as fechainicio
    ,DATE_FORMAT(endDate, '%Y-%m-%d') as fechafin
    ,guidpromo 
    FROM promo
    WHERE isdeleted = 0 AND guidpromo= ?";
    $res=$db->prepare($query, array($guidpromo));

    if($db->numRows($res)>0){
        $newpromo = 0;
        $row = mysqli_fetch_array($res);
        $codigo = $row['codigo'];
        $headtext = "Promoción ".$codigo;
        $descripcion = $row['descripcion'];
        $descuento = $row['descuento'];
        $minimo = $row['minimo'];
        $maximo = $row['maximo'];
        $fechainicio = $row['fechainicio'];
        $fechafin = $row['fechafin'];
        $guidpromo= $row['guidpromo'];
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
        <script src="js/editpromo.js"></script>

        <?php sectionmenu($db, 15); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|adminpromos|admineditpromo", $trans);?>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <form action="controller/editpcat" method="post" id="datospromo">
                                <input id="create" name="create" type="hidden" value="<?=$newpromo?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidpromo?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Promoción
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
                                                <div class="form-group" id="codigo-group">
                                                    <label for="codigo" class="col-form-label">Código <abbr class="required">*</abbr></label>
                                                    <input id="codigo" name="codigo" type="text" class="form-control" value="<?=$codigo?>" placeholder="Código de promoción">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="descuento-group">
                                                    <label for="descuento" class="col-form-label">Descuento (%) <abbr class="required">*</abbr></label>
                                                    <input id="descuento" name="descuento" step="0.01" type="number" class="form-control" value="<?=$descuento?>" placeholder="Porcentaje de descuento">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="minimo-group">
                                                    <label for="minimo" class="col-form-label">Importe Mínimo (€) <abbr class="required">*</abbr></label>
                                                    <input id="minimo" name="minimo" step="1" type="number" class="form-control" value="<?=$minimo?>" placeholder="Importe mínimo para aplicar el descuento">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="maximo-group">
                                                    <label for="maximo" class="col-form-label">Descuento Máximo (€) <abbr class="required">*</abbr></label>
                                                    <input id="maximo" name="maximo" step="0.01" type="number" class="form-control" value="<?=$maximo?>" placeholder="Importe máximo de descuento">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="fechainicio-group">
                                                    <label for="fechainicio" class="col-form-label">Fecha Comienzo <abbr class="required">*</abbr></label>
                                                    <input id="fechainicio" name="fechainicio" type="date" class="form-control" value="<?=$fechainicio?>" placeholder="Fecha de inicio de la promoción">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="fechafin-group">
                                                    <label for="fechafin" class="col-form-label">Fecha Finalización <abbr class="required">*</abbr></label>
                                                    <input id="fechafin" name="fechafin" type="date" class="form-control" value="<?=$fechafin?>" placeholder="Fecha de fin de la promoción">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="descripcion-group">
                                                    <label for="descripcion" class="col-form-label">Descripción <abbr class="required">*</abbr></label>
                                                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Descripción de la promoción"><?=$descripcion?></textarea>
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