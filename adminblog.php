<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Posts')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 11); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">

                    <?php sectionbreadcrumb("Posts", "|menublog|adminblog", $trans);?>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Posts
                                    <div class="btn-group ml-auto">
                                        <a href="admineditblog" class="btn btn-sm btn-dark">
                                            Nuevo post
                                            <i class="mleft-5 fas fa-plus"></i>
                                        </a>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered first">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Título</th>
                                                    <th>Autor</th>
                                                    <th>Fecha</th>
                                                    <th>Vistas</th>
                                                    <th>Metadatos</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    $query = "SELECT p.id
                                                    ,p.title as titulo
                                                    ,p.metatitle as metadatos
                                                    ,CONCAT(u.firstname,' ',u.middlename) as autor
                                                    ,DATE_FORMAT(p.publishedAt, '%d/%m/%Y') as fecha
                                                    ,p.views as vistas
                                                    ,p.guidpost
                                                    FROM post p
                                                    LEFT JOIN user u ON p.userId = u.id
                                                    WHERE p.isdeleted = 0";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="bpos-<?=$row['guidpost']?>">
                                                    <td><?=$row['id']?></td>
                                                    <td><?=$row['titulo']?></td>
                                                    <td><?=$row['autor']?></td>
                                                    <td><?=$row['fecha']?></td>
                                                    <td><?=$row['vistas']?></td>
                                                    <td><?=$row['metadatos']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditblog?guidpost=<?=$row['guidpost']?>" class="btn btn-sm btn-outline-light">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-outline-light cd-popup-trigger">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Título</th>
                                                    <th>Autor</th>
                                                    <th>Fecha</th>
                                                    <th>Vistas</th>
                                                    <th>Metadatos</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cd-popup" role="alert"></div>
            <?php sectionfooter($trans);?>
        </div>
    </div>

    <?php sectionjs();?>
    
</body>
 
</html>