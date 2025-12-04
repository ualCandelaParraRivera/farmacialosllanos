<?php include("./controller/mainadmin.php");
$newpost = 1;
$headtext = "Nuevo Post";
$imagen = "blog-1.jpg";
$id = "";
$titulo = "";
$metadatos = "";
$autor = "";
$fecha = "";
$descripcion = "";
$guiduser = "";
$guidpost = "";

if (isset($_GET['guidpost'])) {
    $guidpost = $_GET['guidpost'];
    $query = "SELECT p.id
    ,p.title as titulo
    ,p.metatitle as metadatos
    ,p.content as descripcion
    ,p.image as imagen
    ,p.guidpost
    ,DATE_FORMAT(publishedAt, '%Y-%m-%d') as fecha
    ,u.guiduser
    ,CONCAT(u.firstname,' ',u.middlename) as autor
    FROM post p
    LEFT JOIN user u ON p.userId = u.id
    WHERE p.isdeleted = 0 AND guidpost = ?";
    $res = $db->prepare($query, array($guidpost));

    if ($db->numRows($res) > 0) {
        $newpost = 0;
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $titulo = $row['titulo'];
        $headtext = "Post " . $titulo;
        $imagen = $row['imagen'];
        $metadatos = $row['metadatos'];
        $autor = $row['autor'];
        $fecha = $row['fecha'];
        $descripcion = $row['descripcion'];
        $guiduser = $row['guiduser'];
        $guidpost = $row['guidpost'];
    }
}

?>
<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <?php sectionhead($headtext) ?>
    <script src="./ckeditor/ckeditor.js"></script>
    <link href="./css/multitags/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/editblog.js"></script>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 11); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menublog|adminblog|admineditblog", $trans); ?>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form enctype="multipart/form-data" action="controller/editblog" method="post" id="datospost">
                                <input id="create" name="create" type="hidden" value="<?=$newpost?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidpost?>">
                                <div class="card">
                                    <h5 class="card-header">Datos Post
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
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="titulo-group">
                                                            <label for="titulo" class="col-form-label">Título <abbr class="required">*</abbr></label>
                                                            <input id="titulo" name="titulo" type="text" class="form-control" value="<?=$titulo?>">
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
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="autor-group">
                                                            <label for="autor" class="col-form-label">Autor <abbr class="required">*</abbr></label>
                                                            <select id="autor" name="autor" type="text" class="form-control" value="<?=$autor?>">
                                                                <option value="">Selecciona un autor...</option>
                                                            <?php
                                                                $query = "SELECT CONCAT(firstname, ' ', middlename) as autor, guiduser FROM user WHERE admin = 1 AND isdeleted = 0";
                                                                $res = $db->query($query);
                                                                while($row = mysqli_fetch_array($res)){
                                                            ?>
                                                                <option value="<?=$row['guiduser']?>" <?php if($row['guiduser'] == $guiduser){echo "selected";}?>><?=$row['autor']?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="fecha-group">
                                                            <label for="fecha" class="col-form-label">Fecha <abbr class="required">*</abbr></label>
                                                            <input id="fecha" name="fecha" type="date" class="form-control" value="<?=$fecha?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="categories-group">
                                                            <label for="categories" class="col-form-label">Categorías <abbr class="required">*</abbr></label>
                                                            <?php
                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(title SEPARATOR '\', \''),'\']') as categories 
                                                                FROM post_category phc
                                                                LEFT JOIN postcategory pc ON phc.categoryId = pc.id
                                                                WHERE postId = ?";
                                                                $categories = "[]";
                                                                $res = $db->prepare($query, array($id));
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $categories = $row['categories'];
                                                                }

                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(title SEPARATOR '\', \''),'\']') as categories 
                                                                FROM postcategory";
                                                                $allcategories = "[]";
                                                                $res = $db->query($query);
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $allcategories = $row['categories'];
                                                                }
                                                            ?>
                                                            <div class="directorist-select directorist-select-multi" id="multicategories" data-isSearch="true" data-default="<?=$categories?>" data-multiSelect="<?=$allcategories?>" style="position: relative;z-index: 9999;">               
                                                                <input type="hidden" id="categories" name="categories" value="<?=$categories?>">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group" id="etiquetas-group">
                                                            <label for="etiquetas" class="col-form-label">Etiquetas <abbr class="required">*</abbr></label>
                                                            <?php
                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(title SEPARATOR '\', \''),'\']') as tags
                                                                FROM post_tag pht
                                                                LEFT JOIN posttag pt ON pht.tagId = pt.id
                                                                WHERE postId = ?";
                                                                $tags = "[]";
                                                                $res = $db->prepare($query, array($id));
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $tags = $row['tags'];
                                                                }

                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(title SEPARATOR '\', \''),'\']') as tags 
                                                                FROM posttag";
                                                                $alltags = "[]";
                                                                $res = $db->query($query);
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $alltags = $row['tags'];
                                                                }
                                                            ?>
                                                            <div class="directorist-select directorist-select-multi" id="multitags" data-isSearch="true" data-default="<?=$tags?>" data-multiSelect="<?=$alltags?>" style="position: relative;z-index: 9998;">               
                                                                <input type="hidden" id="etiquetas" name="etiquetas" value="<?=$tags?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="avatar-upload avatar-upload-cover avatar-upload-blog">
                                                    <div class="avatar-edit">
                                                        <input type='file' id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" name="avatar" class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}" />
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview avatar-cover container2">
                                                        <div id="imagePreview" style="background-image: url(img/blog/<?=$imagen?>);">
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="descripcion-group">
                                                    <label for="descripcion" class="col-form-label">Descripción <abbr class="required">*</abbr></label>
                                                    <textarea name="descripcion" id="descripcion"><?=$descripcion?></textarea>
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

            <?php sectionfooter($trans); ?>

        </div>

    </div>

    <?php sectionjs(); ?>
    <!-- <script src="js/avatarupload.js"></script> -->
    <script>CKEDITOR.replace( 'descripcion',
    {customConfig: 'config.js'});
    </script>
    
    <script>
        var data = CKEDITOR.instances.descripcion.getData();
        CKEDITOR.instances.descripcion.on('change', function() { CKEDITOR.instances.descripcion.updateElement() });
        // Your code to save "data", usually through Ajax.
    </script>
    <script src="./js/multitags.js"></script>
    <script>
        // pureScriptSelect('#select');
        pureScriptSelect('#multicategories');
        pureScriptSelect('#multitags');
    </script>

</body>

</html>