<?php include("./controller/mainadmin.php");
$newproduct = 1;
$headtext = "Nuevo Producto";
$id = "";
$nombre = "";
$metadatos = "";
$resumen = "";
$descripcion = "";
$name = "";
$metadata = "";
$summary = "";
$description = "";
$sku = "";
$cantidad = "";
$precio = "";
$tax = "";
$descuento = "";
$height = "";
$width = "";
$depth = "";
$weight = "";
$brand = "";
$hot = 0;
$guidbrand = "";
$guidproduct = "";

if (isset($_GET['guidproduct'])) {
    $guidproduct = $_GET['guidproduct'];
    $query = "SELECT p.id
    ,pt.title as nombre
    ,pt.metatitle as metadatos
    ,pt.summary as resumen
    ,pt.content as descripcion
    ,pt2.title as name
    ,pt2.metatitle as metadata
    ,pt2.summary as summary
    ,pt2.content as description
    ,p.sku
    ,p.quantity as cantidad
    ,ROUND(p.price,2) as precio
	,ROUND(p.tax*100, 2) as tax
    ,ROUND(p.discount*100,2) as descuento
    ,p.height
    ,p.width
    ,p.depth
    ,p.weight
    ,u.firstname as brand
    ,p.hot
    ,u.guiduser as guidbrand
    ,p.guidproduct
    FROM product p
    LEFT JOIN product_translation pt ON p.id = pt.productId AND pt.lang = 'es'
    LEFT JOIN product_translation pt2 ON p.id = pt2.productId AND pt2.lang = 'en'
    LEFT JOIN user u ON p.userId = u.id
    WHERE guidproduct = ?";
    $res = $db->prepare($query, array($guidproduct));

    if ($db->numRows($res) > 0) {
        $newproduct = 0;
        $row = mysqli_fetch_array($res);
        $id = $row['id'];
        $nombre = $row['nombre'];
        $headtext = "Producto ".$nombre;
        $metadatos = $row['metadatos'];
        $resumen = $row['resumen'];
        $descripcion = $row['descripcion'];
        $name = $row['name'];
        $metadata = $row['metadata'];
        $summary = $row['summary'];
        $description = $row['description'];
        $sku = $row['sku'];
        $cantidad = $row['cantidad'];
        $precio = $row['precio'];
        $tax = $row['tax'];
        $descuento = $row['descuento'];
        $height = $row['height'];
        $width = $row['width'];
        $depth = $row['depth'];
        $weight = $row['weight'];
        $brand = $row['brand'];
        $hot = $row['hot'];
        $guidbrand = $row['guidbrand'];
        $guidproduct = $row['guidproduct'];
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
    <script src="js/editproduct.js"></script>

</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 3); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb($headtext, "|menucat|adminproducts|admineditproduct", $trans); ?>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form enctype="multipart/form-data" action="controller/editproduct" method="post" id="datosproducto">
                                <input id="create" name="create" type="hidden" value="<?=$newproduct?>">
                                <input id="guid" name="guid" type="hidden" value="<?=$guidproduct?>">
                                <div class="card">
                                    <div id="card">
                                        <h5 class="card-header">Datos Producto (Español)
                                            <div class="btn-group ml-auto">
                                                <button type="submit" class="btn btn-sm btn-dark">
                                                    Guardar
                                                    <i class="mleft-5 fas fa-save"></i>
                                                </button>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group" id="nombre-group">
                                                            <label for="nombre" class="col-form-label">Nombre <abbr class="required">*</abbr></label>
                                                            <input id="nombre" name="nombre" type="text" class="form-control" value="<?=$nombre?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group" id="metadatos-group">
                                                            <label for="metadatos" class="col-form-label">Metadatos <abbr class="required">*</abbr></label>
                                                            <input id="metadatos" name="metadatos" type="text" class="form-control" value="<?=$metadatos?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group" id="resumen-group">
                                                            <label for="resumen" class="col-form-label">Resumen <abbr class="required">*</abbr></label>
                                                            <textarea id="resumen" name="resumen" class="form-control" rows="2"><?=$resumen?></textarea>
                                                        </div>
                                                    </div>
                                                </div>           
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group" id="descripcion-group">
                                                        <label for="descripcion" class="col-form-label">Descripción <abbr class="required">*</abbr></label>
                                                        <textarea id="descripcion" name="descripcion" class="form-control" rows="11"><?=$descripcion?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Datos Producto (English)</h5>

                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group" id="name-group">
                                                            <label for="name" class="col-form-label">Name <abbr class="required">*</abbr></label>
                                                            <input id="name" name="name" type="text" class="form-control" value="<?=$name?>">
                                                        </div>
                                                    </div> 
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group" id="metadata-group">
                                                            <label for="metadata" class="col-form-label">Metadata <abbr class="required">*</abbr></label>
                                                            <input id="metadata" name="metadata" type="text" class="form-control" value="<?=$metadata?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group" id="summary-group">
                                                            <label for="summary" class="col-form-label">Summary <abbr class="required">*</abbr></label>
                                                            <textarea id="summary" name="summary" class="form-control" rows="2"><?=$summary?></textarea>
                                                        </div>
                                                    </div>
                                                </div>           
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group" id="description-group">
                                                        <label for="description" class="col-form-label">Description <abbr class="required">*</abbr></label>
                                                        <textarea id="description" name="description" class="form-control" rows="11"><?=$description?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-top">
                                        <h5>Propiedades Producto</h5>

                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="sku-group">
                                                            <label for="sku" class="col-form-label">SKU <abbr class="required">*</abbr></label>
                                                            <input id="sku" name="sku" type="text" class="form-control" value="<?=$sku?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="marca-group">
                                                            <label for="marcas" class="col-form-label">Marca <abbr class="required">*</abbr></label>
                                                            <select id="marcas" name="marcas" type="text" class="form-control" value="<?=$brand?>">
                                                                <option value="">Selecciona una marca...</option>
                                                            <?php
                                                                $query = "SELECT firstname as brand, guiduser as guidbrand FROM user WHERE admin = 0 AND vendor = 1 AND isdeleted = 0";
                                                                $res = $db->query($query);
                                                                while($row = mysqli_fetch_array($res)){
                                                            ?>
                                                                <option value="<?=$row['guidbrand']?>" <?php if($row['guidbrand'] == $guidbrand){echo "selected";}?>><?=$row['brand']?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="hot-group">
                                                            <label for="fa-solid fa-fire" class="col-form-label">Interesante</label>
                                                            <select id="fa-solid fa-fire" name="fa-solid fa-fire" type="text" class="form-control">
                                                                <option value="0" <?php if($hot == 0){ echo "selected"; }?>>No</option>
                                                                <option value="1" <?php if($hot == 1){ echo "selected"; }?>>Si</option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="cantidad-group">
                                                            <label for="cantidad" class="col-form-label">Cantidad <abbr class="required">*</abbr></label>
                                                            <input id="cantidad" name="cantidad" step="1" type="number" class="form-control" value="<?=$cantidad?>" placeholder="Cantidad inicial">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="precio-group">
                                                            <label for="precio" class="col-form-label">Precio (€) <abbr class="required">*</abbr></label>
                                                            <input id="precio" name="precio" step="0.01" type="number" class="form-control" value="<?=$precio?>" placeholder="Precio del producto">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="tax-group">
                                                            <label for="tax" class="col-form-label">IVA (%) <abbr class="required">*</abbr></label>
                                                            <input id="tax" name="tax" step="0.01" type="number" class="form-control" value="<?=$tax?>" placeholder="Porcentaje de impuesto sobre el producto">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="descuento-group">
                                                            <label for="descuento" class="col-form-label">Descuento (%) <abbr class="required">*</abbr></label>
                                                            <input id="descuento" name="descuento" step="0.01" type="number" class="form-control" value="<?=$descuento?>" placeholder="Porcentaje de descuento">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="anchura-group">
                                                            <label for="anchura" class="col-form-label">Anchura <abbr class="required">*</abbr></label>
                                                            <input id="anchura" name="anchura" step="0.1" type="number" class="form-control" value="<?=$width?>" placeholder="Cantidad inicial">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="altura-group">
                                                            <label for="altura" class="col-form-label">Altura <abbr class="required">*</abbr></label>
                                                            <input id="altura" name="altura" step="0.1" type="number" class="form-control" value="<?=$height?>" placeholder="Precio del producto">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="profundidad-group">
                                                            <label for="profundidad" class="col-form-label">Profundidad <abbr class="required">*</abbr></label>
                                                            <input id="profundidad" name="profundidad" step="0.1" type="number" class="form-control" value="<?=$depth?>" placeholder="Porcentaje de impuesto sobre el producto">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <div class="form-group" id="v-group">
                                                            <label for="peso" class="col-form-label">Peso <abbr class="required">*</abbr></label>
                                                            <input id="peso" name="peso" step="0.1" type="number" class="form-control" value="<?=$weight?>" placeholder="Porcentaje de descuento">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="metaetiquetas-group">
                                                            <label for="etiquetas" class="col-form-label">Atributos <abbr class="required">*</abbr></label>
                                                            <?php
                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(CONCAT(pm.key,': ',pm.content) SEPARATOR '\', \''),'\']') as metatags
                                                                FROM product p
                                                                LEFT JOIN product_has_meta phm ON p.id = phm.productId
                                                                LEFT JOIN product_meta pm ON phm.metaId = pm.id
                                                                WHERE pm.isdeleted = 0 AND p.id = ?";
                                                                $metatags = "[]";
                                                                $res = $db->prepare($query, array($id));
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $metatags = $row['metatags'];
                                                                }

                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(DISTINCT CONCAT(pm.key,': ',pm.content) SEPARATOR '\', \''),'\']') as metatags
                                                                FROM product_meta pm 
                                                                WHERE pm.isdeleted = 0";
                                                                $allmetatags = "[]";
                                                                $res = $db->query($query);
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $allmetatags = $row['metatags'];
                                                                }
                                                            ?>
                                                            <div class="directorist-select directorist-select-multi" id="multimetatags" data-isSearch="true" data-default="<?=$metatags?>" data-multiSelect="<?=$allmetatags?>" style="position: relative;z-index: 9998;">               
                                                                <input type="hidden" id="metaetiquetas" name="metaetiquetas" value="<?=$metatags?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="categoria-group">
                                                            <label for="categories" class="col-form-label">Categorías <abbr class="required">*</abbr></label>
                                                            <?php
                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(ct.title SEPARATOR '\', \''),'\']') as categorias
                                                                FROM product p
                                                                LEFT JOIN product_category phc ON p.id = phc.productId
                                                                LEFT JOIN category c ON phc.categoryId = c.id
                                                                LEFT JOIN category_translation ct ON c.id = ct.categoryId AND ct.lang = 'es'
                                                                WHERE c.isdeleted = 0 AND p.id = ?";
                                                                $categorias = "[]";
                                                                $res = $db->prepare($query, array($id));
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $categorias = $row['categorias'];
                                                                }

                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(ct.title SEPARATOR '\', \''),'\']') as categorias 
                                                                FROM category c
                                                                LEFT JOIN category_translation ct ON c.id = ct.categoryId AND ct.lang = 'es'
                                                                WHERE c.isdeleted = 0";
                                                                $allcategorias = "[]";
                                                                $res = $db->query($query);
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $allcategorias = $row['categorias'];
                                                                }
                                                            ?>
                                                            <div class="directorist-select directorist-select-multi" id="multicategories" data-isSearch="true" data-default="<?=$categorias?>" data-multiSelect="<?=$allcategorias?>" style="position: relative;z-index: 9997;">               
                                                                <input type="hidden" id="categorias" name="categorias" value="<?=$categorias?>">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="form-group" id="etiqueta-group">
                                                            <label for="etiquetas" class="col-form-label">Etiquetas <abbr class="required">*</abbr></label>
                                                            <?php
                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(t.title SEPARATOR '\', \''),'\']') as etiquetas
                                                                FROM product p
                                                                LEFT JOIN product_tag pht ON p.id = pht.productId
                                                                LEFT JOIN tag t ON pht.tagId = t.id
                                                                WHERE t.isdeleted = 0 AND p.id = ?";
                                                                $etiquetas = "[]";
                                                                $res = $db->prepare($query, array($id));
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $etiquetas = $row['etiquetas'];
                                                                }

                                                                $query = "SELECT CONCAT('[\'',GROUP_CONCAT(t.title SEPARATOR '\', \''),'\']') as etiquetas
                                                                FROM tag t
                                                                WHERE t.isdeleted = 0";
                                                                $alletiquetas = "[]";
                                                                $res = $db->query($query);
                                                                $row = mysqli_fetch_array($res);
                                                                if($db->numRows($res) > 0){
                                                                    $alletiquetas = $row['etiquetas'];
                                                                }
                                                            ?>
                                                            <div class="directorist-select directorist-select-multi" id="multitags" data-isSearch="true" data-default="<?=$etiquetas?>" data-multiSelect="<?=$alletiquetas?>" style="position: relative;z-index: 9996;">               
                                                                <input type="hidden" id="etiquetas" name="etiquetas" value="<?=$etiquetas?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>           
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body border-top">
                                        <h5>Imágenes del Producto</h5>

                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group" id="files-group">
                                                    <label for="files" class="col-form-label">Imágenes <abbr class="required">*</abbr></label>
                                                    <input id="files" name="files[]" type="file" class="form-control" multiple="multiple" accept=".jpg, .jpeg, .png">
                                                    <input id="newphoto" name="newphoto" type="hidden" value="0">
                                                    <div class="form-group" id="metadata-group">
                                                </div>
                                                    <div class="preview-images-zone" id="previews">
                                                        <?php
                                                            $query = "SELECT image FROM product_image pi
                                                            WHERE isdeleted = 0 AND productId = ?";
                                                            
                                                            $res = $db->prepare($query, array($id));
                                                            
                                                            if($db->numRows($res) > 0){
                                                                $i = 1;
                                                                while($row = mysqli_fetch_array($res)){
                                                            
                                                        ?>
                                                        <div class="preview-image preview-show-<?=$i?>">
                                                            <div class="image-zone"><img src="./img/product/<?=$row['image']?>"></div>
                                                        </div>
                                                        <?php $i++; } } ?>
                                                    </div>
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

    <script src="./js/multitags.js"></script>
    <script>
        pureScriptSelect('#multimetatags');
        pureScriptSelect('#multicategories');
        pureScriptSelect('#multitags');
    </script>
    <script>
        var images = function(input, imgPreview) {
            
            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        
                        var pre = "<div class='preview-image preview-show-"+(i+1)+"'><div class='image-zone'>";
                        var post = "</div></div>";
                        var t = "<img src="+event.target.result+">";
                        var total = pre+t+post;
                        $($.parseHTML(total)).appendTo(imgPreview);
                    }
                    console.log(input.files[i].name);
                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#files').on('change', function() {
            images(this, '#previews');
        });
            
         $('#files').on('click',function(){
            $('#files').val("");
            $('#previews').html("");
            $('#newphoto').val("1");

        }); 
    </script>

    <script>CKEDITOR.replace( 'descripcion', {customConfig: 'config.js'});</script>
    
    <script>
        var data = CKEDITOR.instances.descripcion.getData();
        CKEDITOR.instances.descripcion.on('change', function() { CKEDITOR.instances.descripcion.updateElement() });
    </script>
    <script>CKEDITOR.replace( 'description', {customConfig: 'config.js'});</script>
    
    <script>
        var data = CKEDITOR.instances.description.getData();
        CKEDITOR.instances.description.on('change', function() { CKEDITOR.instances.description.updateElement() });
    </script>
</body>

</html>