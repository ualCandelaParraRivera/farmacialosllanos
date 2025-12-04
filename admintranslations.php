<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Traducciones')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 14); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Traducciones", "|admintranslations", $trans);?>

                    <?php 
                        $query = "SELECT DISTINCT SUBSTRING_INDEX(e.tag, '_', 1) as `page`
                        FROM etiqueta e
                        WHERE e.idioma = 'es'";
                        $res2=$db->query($query);
                        while($row2 = mysqli_fetch_array($res2)){
                            $grupo = ucfirst($row2['page']);
                    ?>
                    <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Grupo <?=$grupo?>
                                    <div class="btn-group ml-auto">
                                        <a href="adminedittrans?group=<?=$row2['page']?>" class="btn btn-sm btn-dark">
                                            Editar grupo
                                            <i class="mleft-5 fas fa-pencil-alt"></i>
                                        </a>
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
                                                    $query = "SELECT SUBSTRING_INDEX(e.tag, '_', 1) as `page`,
                                                    REPLACE(e.tag,CONCAT(SUBSTRING_INDEX(e.tag, '_', 1),'_'),'') as `member`
                                                    ,e.tag
                                                    , e.texto as es
                                                    , e2.texto as en 
                                                    FROM etiqueta e 
                                                    LEFT JOIN etiqueta e2 ON e.tag = e2.tag AND e.idioma = 'es' AND e2.idioma = 'en'
                                                    WHERE e.idioma = 'es' AND SUBSTRING_INDEX(e.tag, '_', 1) = '$grupo'";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr>
                                                    <td><?=$row['page']?></td>
                                                    <td><?=$row['member']?></td>
                                                    <td><?=$row['tag']?></td>
                                                    <td><?=$row['es']?></td>
                                                    <td><?=$row['en']?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Grupo</th>
                                                    <th>Miembro</th>
                                                    <th>Etiqueta</th>
                                                    <th>Español</th>
                                                    <th>English</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            
            <?php sectionfooter($trans);?>
            
        </div>
        
    </div>

    <?php sectionjs();?>
    
</body>
 
</html>