<!DOCTYPE html>
<?php include ("./controller/mainadmin.php");?>
<html class="no-js" lang="es">
 
<head>
    <?php sectionhead('Administradores')?>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php sectionheader($db, 0); ?>

        <?php sectionmenu($db, 10); ?>

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content">

                    <?php sectionbreadcrumb("Clientes", "|menuuser|adminadmins", $trans);?>
                    
                    <div class="row">
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Listado de Administradores
                                    <div class="btn-group ml-auto">
                                        <a href="admineditadmins" class="btn btn-sm btn-dark">
                                            Nuevo administrador
                                            <i class="mleft-5 fas fa-plus"></i>
                                        </a>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Apellido 1</th>
                                                    <th>Apellido 2</th>
                                                    <th>Teléfono</th>
                                                    <th>Email</th>
                                                    <th>Último Acceso</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $query = "SELECT firstname
                                                    ,middlename
                                                    ,lastname
                                                    ,mobile
                                                    ,email
                                                    ,lastlogin
                                                    ,guiduser
                                                    FROM user
                                                    WHERE admin = 1 AND vendor = 0 AND isdeleted = 0";
                                                    $res=$db->query($query);
                                                    while($row = mysqli_fetch_array($res)){
                                                ?>
                                                <tr data-id="uadm-<?=$row['guiduser']?>">
                                                    <td><?=$row['firstname']?></td>
                                                    <td><?=$row['middlename']?></td>
                                                    <td><?=$row['lastname']?></td>
                                                    <td><?=$row['mobile']?></td>
                                                    <td><?=$row['email']?></td>
                                                    <td><?=$row['lastlogin']?></td>
                                                    <td>
                                                        <div class="btn-group ml-auto">
                                                            <a href="admineditadmins?guiduser=<?=$row['guiduser']?>" class="btn btn-sm btn-outline-light">
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
                                                    <th>Nombre</th>
                                                    <th>Apellido 1</th>
                                                    <th>Apellido 2</th>
                                                    <th>Teléfono</th>
                                                    <th>Email</th>
                                                    <th>Último Acceso</th>
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
                <div class="cd-popup" role="alert"></div>        
            <?php sectionfooter($trans);?>

        </div>
    </div>

    <?php sectionjs();?>
</body>
 
</html>