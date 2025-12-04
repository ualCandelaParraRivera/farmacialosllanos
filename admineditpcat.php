<?php include ("./controller/mainadmin.php");
$newpcategory = 1;
$headtext = "Nueva Categoría";
$nombre = "";
$descripcion = "";
$metadatos = "";
$name = "";
$description = "";
$metadata = "";
$guidcategory = "";

if(isset($_GET['guidcategory'])){
    $guidcategory = $_GET['guidcategory'];
    $query = "SELECT ct.title as nombre
    ,ct.content as descripcion
    ,ct.metatitle as metadatos
    ,ct2.title as name
    ,ct2.content as description
    ,ct2.metatitle as metadata
    ,c.guidcategory
    FROM category c
    LEFT JOIN category_translation ct ON c.id = ct.categoryId AND ct.lang = 'es'
    LEFT JOIN category_translation ct2 ON c.id = ct2.categoryId AND ct2.lang = 'en'
    WHERE c.isdeleted = 0 AND c.guidcategory = ?";
    $res=$db->prepare($query, array($guidcategory));

    if($db->numRows($res)>0){
        $newpcategory = 0;
        $row = mysqli_fetch_array($res);
        $nombre = $row['nombre'];
        $headtext = "Categoría ".$nombre;
        $descripcion = $row['descripcion'];
        $metadatos = $row['metadatos'];
        $name = $row['name'];
        $description = $row['description'];
        $metadata = $row['metadata'];
        $guidcategory = $row['guidcategory'];
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
        <script src="js/editpcat.js"></script>

        <?php sectionmenu($db, 4); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menucat|adminpcategories|admineditpcat", $trans);?>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form action="controller/editpcat" method="post" id="datospcategoria">
                                <input id="create" name="create" type="hidden" value="<?=$newpcategory?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidcategory?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Categoría (Español)
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
                                                <div class="form-group" id="nombre-group">
                                                    <label for="nombre" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                    <input id="nombre" name="nombre" type="text" class="form-control" value="<?=$nombre?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="metadatos-group">
                                                    <label for="metadatos" class="col-form-label">Metadatos <abbr class="required">*</abbr></label>
                                                    <input id="metadatos" name="metadatos" type="text" class="form-control" value="<?=$metadatos?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="descripcion-group">
                                                    <label for="descripcion" class="col-form-label">Descripción <abbr class="required">*</abbr></label>
                                                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4"><?=$descripcion?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Datos Categoría (English)</h5>

                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="name-group">
                                                    <label for="name" class="col-form-label">Name <abbr class="required">*</abbr></label>
                                                    <input id="name" name="name" type="text" class="form-control" value="<?=$name?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="metadata-group">
                                                    <label for="metadata" class="col-form-label">Metadata <abbr class="required">*</abbr></label>
                                                    <input id="metadata" name="metadata" type="text" class="form-control" value="<?=$metadata?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
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
                    </div>
                </div>
            </div>
            
            <?php sectionfooter($trans);?>
            
        </div>
        
    </div>

    <?php sectionjs();?>
    
</body>
 
</html>