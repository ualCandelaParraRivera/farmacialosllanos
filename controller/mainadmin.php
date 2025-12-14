<?php
include_once("config.php");
include_once("expire.php");

//Maneja las traducciones mediante etiquetas
$lang = "es";
if(isset($_COOKIE['language'])){
    $lang = $_COOKIE['language'];
    if($lang != "es" && $lang != "en"){
        $lang = "es";
    }
}

if(!isset($_SESSION['usertype']) || $_SESSION['usertype'] <> 1){
    if(isset($_SESSION['usercode'])){
        redirect("myaccount");
    }else{
        redirect("login");
    }
}

/* $products = $db->getCart();
$quantity = 0;
foreach($products as $product){
    $quantity += $product->count;
} */
/* foreach($products as $product){
    echo $product->guidproduct;
    echo "<br>";
    echo $product->title;
    echo "<br>";
    echo $product->imagename;
    echo "<br>";
    echo $product->extension;
    echo "<br>";
    echo $product->price;
    echo "<br>";
    echo $product->count;
    echo "<br>";
    echo $product->total;
    echo "<br>";
} */

 $trans = array();
$res=$db->query("SELECT tag, texto FROM etiqueta WHERE idioma = '$lang'");
while($row = mysqli_fetch_array($res)){
    $trans[$row['tag']] = $row['texto'];
}
//Fin de traducciones

function sectionhead($text){
    echo '    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Los Llanos - '.$text.'</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./HL-Icon-White.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">

    <!-- =================== CSS ========================= -->

    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fonts/circular-std/style.css">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">

    

';
}

function sectiontopbar($trans){
    echo '<!-- Topbar Section Start -->
    <div class="topbar-section section border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col d-none d-md-block">
                    <div class="topbar-menu">
                        <ul>
                            <li><a href="https://maps.app.goo.gl/oUg9AVoB9mbK26Pe7" target="_blank"><i class="fa fa-map-marker-alt"></i>'.$trans['top_store'].'</a></li>
                            <li><a href="myaccount#orders"><i class="fa fa-truck"></i>'.$trans['top_status'].'</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col d-md-none d-lg-block">
                    <p class="text-center my-2">'.$trans['top_message'].' 59€ !</p>
                </div>

                <!-- Header Language Start -->
                <div class="col d-none d-md-block">
                    <div class="nav-bar">
                        <ul class="language">
                            <li><a href="controller/lang?lang=es&callback='.$_SERVER['REQUEST_URI'].'" id="es" class="nav-bar-lang '.(!isset($_COOKIE["language"]) || $_COOKIE["language"] == "es" ? "active" : "").'">ES</a></li>
                            <li><a href="controller/lang?lang=en&callback='.$_SERVER['REQUEST_URI'].'" id="en" class="nav-bar-lang '.(isset($_COOKIE["language"]) && $_COOKIE["language"] == "en" ? "active" : "").'">EN</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Header Language End -->
            </div>
        </div>
    </div>
    <!-- Topbar Section End -->
    ';
}

function sectionheader($db, $active) {
    $userid = $_SESSION['usercode'];
    $query = "SELECT firstname
    ,middlename
    ,email 
    ,ltrim(replace(substring(substring_index(u.image, '.', 1), length(substring_index(u.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
    ,ltrim(replace(substring(substring_index(u.image, '.', 2), length(substring_index(u.image, '.', 2 - 1)) + 1), '.', '')) AS extension
    ,guiduser
    FROM user u where id = ?";
    $res=$db->prepare($query, array($userid));
    if($db->numRows($res)==0){
        redirect("404");
    }
    $row = mysqli_fetch_array($res);
    $firstname = $row['firstname'];
    $middlename = $row['middlename'];
    $email = $row['email'];
    $imagename = $row['imagename'];
    $extension = $row['extension'];
    $guiduser = $row['guiduser'];

    $indicator = '';
    $query = "SELECT id FROM `order` WHERE TIMESTAMPDIFF(SECOND, ? , createdAt) >= 0";
    $res=$db->prepare($query, array($_SESSION['lastlogin']));
    if($db->numRows($res) > 0){
        $indicator = '<span class="indicator"></span>';
    }
    
    $query = "SELECT CONCAT(shipfirstname,' ',shipmiddlename) as user
    ,CONCAT(ROUND(grandTotal,2),'€') as total
    ,TIMESTAMPDIFF(SECOND, createdAt , NOW()) as time
    ,CASE WHEN TIMESTAMPDIFF(SECOND, ? , createdAt) >= 0 THEN 1 ELSE 0 END as notification
    ,guidorder
    FROM `order`
    ORDER BY createdAt DESC
    LIMIT 6";
    $res=$db->prepare($query, array($_SESSION['lastlogin']));
    echo '<!-- Header Section Start -->
    <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <div class="col">
                    <div class="header-logo">
                      <a href="index"><img src="assets/images/logo-2.png" alt="Los Llanos Logo"></a>
                    </div>
                  </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> '.$indicator.'</a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notificación</div>
                                    <div class="notification-list">
                                        <div class="list-group">';
                                        while($row = mysqli_fetch_array($res)){
                                            $username = $row['user'];
                                            $usertotal = $row['total'];
                                            $usertime = $row['time'];
                                            $usernotification = $row['notification'];
                                            $userguidorder = $row['guidorder'];
                                            $activenotification = $usernotification == 1 ? ' active' : '';
                                            $timetext = '';
                                            if($usertime<60){
                                                $timetext = 'Hace menos de 1 minuto';
                                            }else if($usertime<120){
                                                $timetext = 'Hace 1 minuto';
                                            }else if($usertime<3600){
                                                $timetext = 'Hace '.intdiv($usertime,60).' minutos';
                                            }else if($usertime<7200){
                                                $timetext = 'Hace 1 hora';
                                            }else if($usertime<86400){
                                                $timetext = 'Hace '.intdiv($usertime,3600).' horas';
                                            }else if($usertime<172800){
                                                $timetext = 'Hace 1 día';
                                            }else if($usertime<604800){
                                                $timetext = 'Hace '.intdiv($usertime,86400).' días';
                                            }else if($usertime<1209600){
                                                $timetext = 'Hace 1 semana';
                                            }else{
                                                $timetext = 'Hace '.intdiv($usertime,604800).' semanas';
                                            }

                                            echo '<a href="admineditorder?guidorder='.$userguidorder.'" class="list-group-item list-group-item-action'.$activenotification.'">
                                            <div class="notification-info">
                                                <div class="notification-list-user-img"><img src="img/team/user1-90.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                <div class="notification-list-user-block"><span class="notification-list-user-name">'.$username.'</span>ha realizado un pedido por importe de <strong>'.$usertotal.'</strong>.
                                                    <div class="notification-date">'.$timetext.'</div>
                                                </div>
                                            </div>
                                        </a>';
                                        }
                                        echo'
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="adminorders">Ver todos los pedidos</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="index" target="_blank" class="connection-item"><img src="assets/images/hempleaf256.png" alt="" > <span>Farmacialosllanos</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="https://webmail.hempleaf.es/" target="_blank" class="connection-item"><img src="assets/images/mail256.png" alt="" > <span>Correo</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="https://www.gls-spain.es/es/" target="_blank" class="connection-item"><img src="assets/images/gls256.png" alt="" > <span>Transporte</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="https://www.instagram.com/farmacialosllanosalmeria/" target="_blank" class="connection-item"><img src="assets/images/instagram256.png" alt=""> <span>Instagram</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="https://www.facebook.com/FarmaciaLosLlanos/" target="_blank" class="connection-item"><img src="assets/images/facebook256.png" alt="" ><span>Facebook</span></a>
                                        </div>
                                        
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/team/'.$imagename.'.'.$extension.'" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">'.$firstname.' '.$middlename.' </h5>
                                    <span class="status"></span><span class="ml-2">'.$email.'</span>
                                </div>
                                <a class="dropdown-item" href="admineditadmins?guiduser='.$guiduser.'"><i class="fas fa-user mr-2"></i>Perfil</a>
                                <!--<a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>-->
                                <a class="dropdown-item" href="logout"><i class="fas fa-power-off mr-2"></i>Salir</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Header Section End -->
    ';
}

function sectionmenu($db, $active){
    $indicator = '';
    $query = "SELECT id FROM `order` WHERE TIMESTAMPDIFF(SECOND, ? , createdAt) >= 0";
    $res=$db->prepare($query, array($_SESSION['lastlogin']));
    if($db->numRows($res) > 0){
        $indicator = '<span class="badge badge-secondary">Nuevo</span>';
    }
    echo '<!-- Menu Section Start -->
    <div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item ">
                        <a class="nav-link '.($active==0 ? 'active' : '').'" style="margin-top: 10px;" href="admin"><i class="fa fa-fw fa-chart-bar"></i>Dashboard</a>
                    </li>
                    <li class="nav-divider">
                        Tienda
                    </li>
                    <li class="nav-item">
                        <a class="nav-link '.($active>=1 && $active<=2 ? 'active' : '').'" href="#" data-toggle="collapse" aria-expanded="'.($active>=1 && $active<=2 ? 'true' : 'false').'" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-shopping-basket"></i>Pedidos</a>
                        <div id="submenu-2" class="collapse submenu '.($active>=1 && $active<=2 ? 'show' : '').'">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link '.($active==1 ? 'active' : '').'" href="adminorders">Pedidos'.$indicator.'</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==2 ? 'active' : '').'" href="admininvoices">Facturas</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link '.($active>=3 && $active<=8 ? 'active' : '').'" href="#" data-toggle="collapse" aria-expanded="'.($active>=3 && $active<=8 ? 'true' : 'false').'" data-target="#submenu-3" aria-controls="submenu-3"><i class="mdi mdi-store" style="font-size: 19px;"></i>Catálogo</a>
                        <div id="submenu-3" class="collapse submenu '.($active>=3 && $active<=8 ? 'show' : '').'">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link '.($active==3 ? 'active' : '').'" href="adminproducts">Productos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==4 ? 'active' : '').'" href="adminpcategories">Categorías</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==5 ? 'active' : '').'" href="adminptags">Etiquetas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==6 ? 'active' : '').'" href="adminattributes">Atributos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==7 ? 'active' : '').'" href="adminbrands">Marcas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==8 ? 'active' : '').'" href="adminwholesales">Wholesales</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link '.($active>=9 && $active<=10 ? 'active' : '').'" href="#" data-toggle="collapse" aria-expanded="'.($active>=9 && $active<=10 ? 'true' : 'false').'" data-target="#submenu-x" aria-controls="submenu-3"><i class="fas fa-fw fa-users" style="font-size: 16px;"></i>Usuarios</a>
                        <div id="submenu-x" class="collapse submenu '.($active>=9 && $active<=10 ? 'show' : '').'">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link '.($active==9 ? 'active' : '').'" href="adminclients">Clientes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==10 ? 'active' : '').'" href="adminadmins">Administradores</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-divider">
                        Features
                    </li>
                    <li class="nav-item">
                        <a class="nav-link '.($active>=11 && $active<=13 ? 'active' : '').'" href="#" data-toggle="collapse" aria-expanded="'.($active>=11 && $active<=13 ? 'true' : 'false').'" data-target="#submenu-4" aria-controls="submenu-4"><i class="fa fa-fw fa-newspaper"></i>Blog</a>
                        <div id="submenu-4" class="collapse submenu '.($active>=11 && $active<=13 ? 'show' : '').'">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link '.($active==11 ? 'active' : '').'" href="adminblog">Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==12 ? 'active' : '').'" href="adminbcategories">Categorías</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link '.($active==13 ? 'active' : '').'" href="adminbtags">Etiquetas</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link '.($active==14 ? 'active' : '').'" href="admintranslations"><i class="fas fa-fw fa-globe"></i>Traducciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link '.($active==15 ? 'active' : '').'" href="adminpromos"><i class="fas fa-fw fa-gift"></i>Promociones</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- Menu Section End -->
';
}

function sectionbreadcrumb($title, $text, $trans){
    $tokens = explode("|", $text);
    $N = count($tokens);
    $var = getPage($tokens[$N-1], $trans);
    echo '
                    <!-- Page Title/Header Start -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">'.$title.'</h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">';
                                        for($i=0; $i < $N; $i++) {
                                            $var = getPage($tokens[$i], $trans);
                                            if($i < $N-1){
                                                echo '<li class="breadcrumb-item"><a href="'.$var[0].'">'.$var[1].'</a></li>';
                                            }  else {
                                                echo '<li class="breadcrumb-item active">'.$var[1].'</li>';
                                            }
                                        }
                                        echo '</ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page Title/Header End -->
    ';
}    

function getPage($text, $trans){
    switch($text){
        case "admin": $ref="admin"; $name="Dashboard"; break;
        case "adminorders": $ref="adminorders"; $name="Pedidos"; break;
        case "admininvoices": $ref="admininvoices"; $name="Facturas"; break;
        case "menucat": $ref="#"; $name="Catálogo"; break;
        case "adminpcategories": $ref="adminpcategories"; $name="Categorías"; break;
        case "adminptags": $ref="adminptags"; $name="Etiquetas"; break;
        case "adminbrands": $ref="adminbrands"; $name="Marcas"; break;
        case "adminproducts": $ref="adminproducts"; $name="Productos"; break;
        case "adminwholesales": $ref="adminwholesales"; $name="Wholesales"; break;
        case "menuuser": $ref="#"; $name="Usuarios"; break;
        case "adminclients": $ref="adminclients"; $name="Clientes"; break;
        case "adminadmins": $ref="adminadmins"; $name="Administradores"; break;
        case "menublog": $ref="#"; $name="Blog"; break;
        case "adminblog": $ref="adminblog"; $name="Posts"; break;
        case "adminbcategories": $ref="adminbcategories"; $name="Categorías"; break;
        case "adminbtags": $ref="adminbtags"; $name="Etiquetas"; break;
        case "admintranslations": $ref="admintranslations"; $name="Traducciones"; break;
        case "adminedittrans": $ref="adminedittrans"; $name="Editar Traducciones"; break;
        case "admineditclients": $ref="admineditclients"; $name="Editar Clientes"; break;
        case "admineditadmins": $ref="admineditadmins"; $name="Editar Administradores"; break;
        case "admineditpcat": $ref="admineditpcat"; $name="Editar Categorías"; break;
        case "admineditptags": $ref="admineditptags"; $name="Editar Etiquetas"; break;
        case "admineditbrand": $ref="admineditbrand"; $name="Editar Marcas"; break;
        case "admineditbcat": $ref="admineditbcat"; $name="Editar Categorías"; break;
        case "admineditbtag": $ref="admineditbtag"; $name="Editar Etiquetas"; break;
        case "admineditblog": $ref="admineditblog"; $name="Editar Post"; break;
        case "admineditwholesale": $ref="admineditwholesale"; $name="Editar Wholesale"; break;
        case "adminpromos": $ref="adminpromos"; $name="Promociones"; break;
        case "admineditpromo": $ref="admineditpromo"; $name="Editar Promociones"; break;
        case "admineditproduct": $ref="admineditproduct"; $name="Editar Producto"; break;
        case "adminattributes": $ref="adminattributes"; $name="Atributos"; break;
        case "admineditattributes": $ref="admineditattributes"; $name="Editar Atributo"; break;
        case "admineditorder": $ref="admineditorder"; $name="Editar Pedido"; break;
        case "admininvoicedetail": $ref="admininvoicedetail"; $name="Ver Factura"; break;
        case "redirectlogin": $ref="redirectlogin"; $name=$trans['breadcrumb_'.$text]; break;
        case "myaccount": $ref="myaccount"; $name=$trans['breadcrumb_'.$text]; break;
        case "register": $ref="register"; $name=$trans['breadcrumb_'.$text]; break;
        case "shop": $ref="shop"; $name=$trans['breadcrumb_'.$text]; break;
        case "wholesales": $ref="wholesales"; $name=$trans['breadcrumb_'.$text]; break;
        case "blog": $ref="blog"; $name=$trans['breadcrumb_'.$text]; break;
        case "blogdetails": $ref="blogdetails"; $name=$trans['breadcrumb_'.$text]; break;
        case "aboutus": $ref="aboutus"; $name=$trans['breadcrumb_'.$text]; break;
        case "faq": $ref="faq"; $name=$trans['breadcrumb_'.$text]; break;
        case "wholesaledetails": $ref="wholesaledetails"; $name=$trans['breadcrumb_'.$text]; break;
        case "productdetails": $ref="productdetails"; $name=$trans['breadcrumb_'.$text]; break;
        case "cart": $ref="cart"; $name=$trans['breadcrumb_'.$text]; break;
        case "orderview": $ref="orderview"; $name=$trans['breadcrumb_'.$text]; break;

        default: $ref="admin"; $name="Inicio"; break;
    }
    $var = array($ref, $name);
    return $var;
}


function sectionfooter($trans) {
    echo '
    <!-- Footer -->
    <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            &copy; <script>document.write(new Date().getFullYear());</script>  farmacialosllanos. Todos los derechos reservados.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="mailto:soporte@hempleaf.es">Soporte</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Footer ends -->
';
}

function sectionjs(){
    echo '<!-- ==================== JS ======================== -->

    <!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="assets/libs/js/dashboard-ecommerce.js"></script>

    <script src="assets/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/vendor/datatables/js/data-table.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/libs/js/doublecheck.js"></script>
';
}

function url($arr,$n,$text){
    $s = '';
    for($i = 0; $i<count($arr); $i++){
        if($i == $n){
            if(!empty($text)){
                $s.='&'.$text;
            }
        }else if(!empty($arr[$i])){
            $s.='&'.$arr[$i];
        }
    }
    if(startsWith($s,'&')){
        $s = substr($s, 1);
    }
    return empty($s) ? '' : '?'.$s;
}

function startsWith ($string, $startString) { 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
}

function getToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i = 0; $i < $length; $i ++) {
        $token .= $codeAlphabet[cryptoRandSecure(0, $max)];
    }
    return $token;
}

function redirect($url) {
    header("Location:" . $url);
    exit;
}

function clearAuthCookie() {
    if (isset($_COOKIE["member_login"])) {
        setcookie("member_login", "");
    }
    if (isset($_COOKIE["random_password"])) {
        setcookie("random_password", "");
    }
    if (isset($_COOKIE["random_selector"])) {
        setcookie("random_selector", "");
    }
}

function cryptoRandSecure($min, $max){
    $range = $max - $min;
    if ($range < 1) {
        return $min; // not so random...
    }
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

function emailValidation($email) {
    $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/";
    $email = strtolower($email);

    return preg_match ($regex, $email);
}

function phoneValidation($phone){
    $regex = "/^\+?(?:[0-9] ?){6,14}[0-9]$/";
    return preg_match($regex, $phone);
}

function guid(){
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function redimImage($nombreimg, $rutaimg, $xmax, $ymax){  
    $ext = explode(".", $nombreimg);  
    $ext = $ext[count($ext)-1];  
  
    if($ext == "jpg" || $ext == "jpeg")  
        $imagen = imagecreatefromjpeg($rutaimg);  
    elseif($ext == "png")  
        $imagen = imagecreatefrompng($rutaimg);  
    elseif($ext == "gif")  
        $imagen = imagecreatefromgif($rutaimg);  
      
    $x = imagesx($imagen);  
    $y = imagesy($imagen);  
      
    if($x <= $xmax && $y <= $ymax){
        return $imagen;  
    }
  
    if($x >= $y) {  
        $nuevax = $xmax;  
        $nuevay = $nuevax * $y / $x;  
    }  
    else {  
        $nuevay = $ymax;  
        $nuevax = $x / $y * $nuevay;  
    }  
      
    $img2 = imagecreatetruecolor($nuevax, $nuevay);  
    imagecopyresized($img2, $imagen, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);  
    return $img2;   
}

function createRedimImage($imagesrc, $targetdir, $maxlen){
    $dir = opendir($targetdir);
    $imagen_optimizada=redimImage($imagesrc,$targetdir.basename($imagesrc), $maxlen, $maxlen);
    $ext = explode(".", $imagesrc);
    $ext = $ext[count($ext)-1];
    $name = substr($imagesrc,0,-(strlen($ext)+1));
    switch ($ext) {
        case 'jpg':
        case 'jpeg': imagejpeg($imagen_optimizada, $targetdir.$name.'-'.$maxlen.'.'.$ext);
            break;
        case 'png': imagepng($imagen_optimizada, $targetdir.$name.'-'.$maxlen.'.'.$ext);
            break;
        default:
            break;
    }
    closedir($dir);
}

function redimImageWidth($nombreimg, $rutaimg, $xmax){  
    $ext = explode(".", $nombreimg);  
    $ext = $ext[count($ext)-1];  
  
    if($ext == "jpg" || $ext == "jpeg")  
        $imagen = imagecreatefromjpeg($rutaimg);  
    elseif($ext == "png")  
        $imagen = imagecreatefrompng($rutaimg);  
    elseif($ext == "gif")  
        $imagen = imagecreatefromgif($rutaimg);  
      
    $x = imagesx($imagen);  
    $y = imagesy($imagen);  
      
    if($x <= $xmax){
        return $imagen;  
    }
  
    $nuevax = $xmax;  
    $nuevay = $nuevax * $y / $x;  
      
    $img2 = imagecreatetruecolor($nuevax, $nuevay);  
    imagecopyresized($img2, $imagen, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);  
    return $img2;   
}

function createRedimImageWidth($imagesrc, $targetdir, $maxlen, $sufix=''){
    $dir = opendir($targetdir);
    $imagen_optimizada=redimImageWidth($imagesrc,$targetdir.basename($imagesrc), $maxlen);
    $ext = explode(".", $imagesrc);
    $ext = $ext[count($ext)-1];
    $name = substr($imagesrc,0,-(strlen($ext)+1));
    switch ($ext) {
        case 'jpg':
        case 'jpeg': imagejpeg($imagen_optimizada, $targetdir.$name.'-'.$maxlen.$sufix.'.'.$ext);
            break;
        case 'png': imagepng($imagen_optimizada, $targetdir.$name.'-'.$maxlen.$sufix.'.'.$ext);
            break;
        default:
            break;
    }
    closedir($dir);
}

function createRedimImageWidthNoLength($imagesrc, $targetdir, $maxlen, $sufix=''){
    $dir = opendir($targetdir);
    $imagen_optimizada=redimImageWidth($imagesrc,$targetdir.basename($imagesrc), $maxlen);
    $ext = explode(".", $imagesrc);
    $ext = $ext[count($ext)-1];
    $name = substr($imagesrc,0,-(strlen($ext)+1));
    switch ($ext) {
        case 'jpg':
        case 'jpeg': imagejpeg($imagen_optimizada, $targetdir.$name.'-'.$sufix.'.'.$ext);
            break;
        case 'png': imagepng($imagen_optimizada, $targetdir.$name.'-'.$sufix.'.'.$ext);
            break;
        default:
            break;
    }
    closedir($dir);
}

function deleteFile($dir, $filename, $sufix=''){
    $ext = explode(".", $filename);
    $ext = $ext[count($ext)-1];
    $name = substr($filename,0,-(strlen($ext)+1));
    $filepath = $dir.$name.$sufix.'.'.$ext;
    if(file_exists($filepath)){
        unlink($filepath);
    }
}



function validatepage($db, $query, $args, $per_page = 10,$page = 1, $url = '?'){
    $query = "SELECT COUNT(*) as num FROM (".$query.") as subquery";
    if(is_null($args)){
        $res = $db->query($query);
    }else{
        $res = $db->prepare($query, $args);
    }
    
    if (!$res) return 1;
    $row = mysqli_fetch_array($res);
    $total = $row['num'];
    $page = ($page <= 0 ? 1 : $page);  
    $lastpage = ceil($total/$per_page);
    if($page > $lastpage){
        return $lastpage;
    }
    if($lastpage <= 1){
        return 1;
    }
    return $page;
}

function pagination($db, $query, $args, $per_page = 10,$page = 1, $url = '?', $q=''){        
    $query = "SELECT COUNT(*) as num FROM (".$query.") as subquery";
    if(is_null($args)){
        $res = $db->query($query);
    }else{
        $res = $db->prepare($query, $args);
    }
    if (!$res) return;
    $row = mysqli_fetch_array($res);
    $total = $row['num'];
    $adjacents = "2"; 

    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;								
    
    $prev = $page - 1;							
    $next = $page + 1;
    $lastpage = ceil($total/$per_page);
    $lpm1 = $lastpage - 1;
    if($page > $lastpage){
        $page = $lastpage;
    }
    if($lastpage < 1){
        $page = 1;
    }
    
    $pagination = "";
    if($lastpage > 1){	
        $pagination .= "<ul class='pagination'>";
        if ($page > 1){ 
            $pagination.="<li class='page-item'><a href='{$url}page=1{$q}' class='page-link' aria-label='Primero'><i class='ti-angle-double-left'></i></a></li>";
            $pagination.="<li class='page-item'><a href='{$url}page=$prev{$q}' class='page-link' aria-label='Previo'><i class='ti-angle-left'></i></a></li>";
        }else{
            $pagination.="<li class='page-item disabled'><a href='{$url}page=1{$q}' class='page-link' aria-label='Primero'><i class='ti-angle-double-left' aria-hidden='true'></i></a></li>";
            $pagination.="<li class='page-item disabled'><a href='{$url}page=$prev{$q}' class='page-link' aria-label='Previo'><i class='ti-angle-left' aria-hidden='true'></i></a></li>";
        }
        if ($lastpage < 7 + ($adjacents * 2)){	
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page){
                    $pagination.="<li class='page-item active'><a class='page-link'>$counter</a></li>";
                }else{
                    $pagination.= "<li class='page-item'><a href='{$url}page=$counter{$q}' class='page-link'>$counter</a></li>";
                    
                }		
            }
            
        }elseif($lastpage > 5 + ($adjacents * 2)){
            if($page < 1 + ($adjacents * 2)){
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page){
                        $pagination.="<li class='page-item active'><a class='page-link'>$counter</a></li>";
                    }else{
                        $pagination.= "<li class='page-item'><a href='{$url}page=$counter{$q}' class='page-link'>$counter</a></li>";
                    }					
                }
                $pagination.="<li class='page-item disabled'><a href='{$url}page=1{$q}' class='page-link'>...</a></li>";
                $pagination.= "<li class='page-item'><a href='{$url}page=$lpm1{$q}' class='page-link'>$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a href='{$url}page=$lastpage{$q}' class='page-link'>$lastpage</a></li>";
                        
            }elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                $pagination.= "<li class='page-item'><a href='{$url}page=1{$q}' class='page-link'>1</a></li>";
                $pagination.= "<li class='page-item'><a href='{$url}page=2{$q}' class='page-link'>2</a></li>";
                $pagination.=" <li class='page-item disabled'><a href='{$url}page=1{$q}' class='page-link'>...</a></li>";
                
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                    if ($counter == $page){
                        $pagination.="<li class='page-item active'><a class='page-link'>$counter</a></li>";
                    }else{
                        $pagination.= "<li class='page-item'><a href='{$url}page=$counter{$q}' class='page-link'>$counter</a></li>";
                    }
                }
                $pagination.="<li class='page-item disabled'><a href='{$url}page=1{$q}' class='page-link'>...</a></li>";
                $pagination.= "<li class='page-item'><a href='{$url}page=$lpm1{$q}' class='page-link'>$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a href='{$url}page=$lastpage{$q}' class='page-link'>$lastpage</a></li>";		
            
            }else{
                $pagination.= "<li class='page-item'><a href='{$url}page=1{$q}' class='page-link'>1</a></li>";
                $pagination.= "<li class='page-item'><a href='{$url}page=2{$q}' class='page-link'>2</a></li>";
                $pagination.="<li class='page-item disabled'><a href='{$url}page=1{$q}' class='page-link'>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                    if ($counter == $page){
                        $pagination.="<li class='page-item active'><a class='page-link'>$counter</a></li>";
                    }else{
                        $pagination.= "<li class='page-item'><a href='{$url}page=$counter{$q}' class='page-link'>$counter</a></li>";
                    }
                }
            }
        }
        
        if ($page < $counter - 1){
            $pagination.="<li class='page-item'><a href='{$url}page=$next{$q}' class='page-link' aria-label='Siguiente'><i class='ti-angle-right'></i></a></li>";
            $pagination.="<li class='page-item'><a href='{$url}page=$lastpage{$q}' class='page-link' aria-label='Ultimo'><i class='ti-angle-double-right'></i></a></li>";
        }else{
            $pagination.="<li class='page-item disabled'><a href='{$url}page=$next{$q}' class='page-link' aria-label='Siguiente'><i class='ti-angle-right' aria-hidden='true'></i></a></li>";
            $pagination.="<li class='page-item disabled'><a href='{$url}page=$lastpage{$q}' class='page-link' aria-label='Ultimo'><i class='ti-angle-double-right' aria-hidden='true'></i></a></li>";
        
        }
        $pagination.= "</ul>\n";		
    }
    return $pagination;
}

?>