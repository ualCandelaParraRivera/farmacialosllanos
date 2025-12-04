<?php include ("./controller/mainadmin.php");
if(!isset($_GET['group'])){
    redirect('admintranslations');
}
$group = $_GET['group'];
$query = "SELECT SUBSTRING_INDEX(e.tag, '_', 1) as `page`,
REPLACE(e.tag,CONCAT(SUBSTRING_INDEX(e.tag, '_', 1),'_'),'') as `member`
,e.tag
,e.texto as es
,e2.texto as en 
FROM etiqueta e 
LEFT JOIN etiqueta e2 ON e.tag = e2.tag AND e.idioma = 'es' AND e2.idioma = 'en'
WHERE e.idioma = 'es' AND SUBSTRING_INDEX(e.tag, '_', 1) = ?";
$res=$db->prepare($query, array($group));
if($db->numRows($res) == 0){
    redirect('admintranslations');
}
?>
<!DOCTYPE html>


<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Traducciones '.ucfirst($group))?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/translate.js"></script>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 14); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Editar Traducciones", "|admintranslations|adminedittrans", $trans);?>

                    <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <form action="#" id="translate" method="POST">
                            <div class="card">
                                <h5 class="card-header">Grupo <?=ucfirst($group)?>
                                    <div class="btn-group ml-auto">
                                        <button class="btn btn-sm btn-dark">
                                            Guardar
                                            <i class="mleft-5 fas fa-save"></i>
                                        </button>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered first">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"  style="width:10%">Grupo</th>
                                                        <th scope="col"  style="width:10%">Miembro</th>
                                                        <th scope="col"  style="width:14%">Etiqueta</th>
                                                        <th scope="col"  style="width:33%">Español</th>
                                                        <th scope="col"  style="width:33%">English</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        while($row = mysqli_fetch_array($res)){
                                                    ?>
                                                    <tr>
                                                        <td><?=$row['page']?></td>
                                                        <td><?=$row['member']?></td>
                                                        <td><input class="diabledinput" type="text" name="tag[]" value="<?=$row['tag']?>" readonly></td>
                                                        <td><input type="text" name="es[]" value="<?=$row['es']?>" placeholder="Introduce la traducción para español"></td>
                                                        <td><input type="text" name="en[]" value="<?=$row['en']?>" placeholder="Introduce la traducción para inglés"></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th scope="col"  style="width:10%">Grupo</th>
                                                        <th scope="col"  style="width:10%">Miembro</th>
                                                        <th scope="col"  style="width:14%">Etiqueta</th>
                                                        <th scope="col"  style="width:33%">Español</th>
                                                        <th scope="col"  style="width:33%">English</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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