<?php
include_once("config.php");
include_once("expire.php");

//$acceptedIps = array("79.116.38.92");
$acceptedIps = array();
if(getcurrentpath() == "coming-soon"){
    if(isAcceptedIp($acceptedIps)){
        redirect("index");
    }
}else if(!isAcceptedIp($acceptedIps)){
    redirect("coming-soon");
}

//Maneja las traducciones mediante etiquetas
$lang = "es";
if(isset($_COOKIE['language'])){
    $lang = $_COOKIE['language'];
    if($lang != "es" && $lang != "en"){
        $lang = "es";
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

function getcurrentpath(){
    $relative = "";
    if($_SERVER['HTTP_HOST'] == "localhost"){
        $relative = str_replace("/hempleaf/","",$_SERVER['REQUEST_URI']);
    }else if($_SERVER['HTTP_HOST'] == "hempleaf.ddns.net"){
        $relative = str_replace("/hempleaf/","",$_SERVER['REQUEST_URI']);
    }else{
        $relative = str_replace("/","",$_SERVER['REQUEST_URI']);
    }
    return $relative;
}

function sectionhead($db){
    
    echo getMeta($db).'
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- =================== CSS ========================= -->

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="css/vendor/font-awesome-pro.min.css">
    <link rel="stylesheet" href="css/vendor/themify-icons.css">
    <link rel="stylesheet" href="css/vendor/customFonts.css">

    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="css/plugins/select2.min.css">
    <link rel="stylesheet" href="css/plugins/perfect-scrollbar.css">
    <link rel="stylesheet" href="css/plugins/swiper.min.css">
    <link rel="stylesheet" href="css/plugins/nice-select.css">
    <link rel="stylesheet" href="css/plugins/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="css/plugins/photoswipe.css">
    <link rel="stylesheet" href="css/plugins/photoswipe-default-skin.css">
    <link rel="stylesheet" href="css/plugins/magnific-popup.css">
    <link rel="stylesheet" href="css/plugins/slick.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/cookies.js"></script>

';
}

function getMeta($db, $page=""){
    $parts = explode('/', $_SERVER['SCRIPT_NAME']);
    $page = explode('.', array_pop($parts))[0];
    $qs = $_SERVER['QUERY_STRING'];
    $title = "Los Llanos - ";
    $robots = "index, follow";
    $description = "";
    $viewport = "width=device-width, initial-scale=1, shrink-to-fit=no";
    $author = "KMDatategy";
    $replyto = "soporte@hempleaf.es";
    $keywords = "";
    $resourcetype = "Document";
    $datecreated = "Mon, 3 May 2021 00:00:00 GMT+1";
    $revisitafter = "30 days";
    $query = "SELECT * FROM metadata WHERE page = ?";
    $res=$db->prepare($query, array($page));
    if($db->numRows($res) > 0){
        $row = mysqli_fetch_array($res);
        $title.=$row['title'];
        $robots = $row['robots'];
        $description = $row['description'];
        $keywords = $row['keywords'];;
    }

    if (strpos($qs, 'guidproduct') !== false) {
        $guidproduct = str_replace("guidproduct=", "", $qs);
        $query = "SELECT metatitle FROM product p
        LEFT JOIN product_translation pt ON p.id = pt.productId
        WHERE guidproduct = ? AND lang = 'es'";
        $res=$db->prepare($query, array($guidproduct));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $description = $row['metatitle'];
        }
    }else if (strpos($qs, 'guidwholesale') !== false) {
        $guidwholesale = str_replace("guidwholesale=", "", $qs);
        $query = "SELECT metatitle from wholesale w
        LEFT JOIN wholesale_translation wt ON w.id = wt.wholesaleid
        WHERE guidwholesale = ? AND lang = 'es'";
        $res=$db->prepare($query, array($guidwholesale));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $description = $row['metatitle'];
        }
    }else if (strpos($qs, 'guidpost') !== false) {
        $guidpost = str_replace("guidpost=", "", $qs);
        $query = "SELECT metatitle FROM post WHERE guidpost = ?";
        $res=$db->prepare($query, array($guidpost));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $description = $row['metatitle'];
        }
    }

    $meta = '<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>'.$title.'</title>
    <meta name="'.$robots.'" />
    <meta name="description" content="'.$description.'">
    <meta name="viewport" content="'.$viewport.'">
    <meta name="author" content="'.$author.'">
    <meta name="reply-to" content="'.$replyto.'">
    <meta name="keywords" content="'.$keywords.'">
    <meta name="resource-type" content="'.$resourcetype.'">
    <meta name="datecreated" content="'.$datecreated.'">
    <meta name="revisit-after" content="'.$revisitafter.'">';
    return $meta;
    
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
                            <!--<li><a href="myaccount#orders"><i class="fa fa-truck"></i>'.$trans['top_status'].'</a></li>-->
                        </ul>
                    </div>
                </div>
                <div class="col d-md-none d-lg-block">
                    <p class="text-center my-2">'.$trans['top_message'].'</p>
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

function sectionheader($db, $active, $trans) {
    $lang = "es";
if(isset($_COOKIE['language'])){
    $lang = $_COOKIE['language'];
    if($lang != "es" && $lang != "en"){
        $lang = "es";
    }
}
    $products = $db->getCart($lang);
$quantity = 0;
$subtotal = 0;
foreach($products as $product){
    $quantity += $product->count;
    $subtotal += $product->total + $product->totaltax;
}
    echo '<!-- Header Section Start -->
    <div class="header-section header-menu-center section bg-white d-none d-xl-block">
        <div class="container">
            <div class="row align-items-center">

                <!-- Header Logo Start -->
                <div class="col">
                    <div class="header-logo">
                        <a href="index"><img src="img/logo/logof.png" alt="Hempleaf Logo"></a>
                    </div>
                </div>
                <!-- Header Logo End -->

                <!-- Search Start -->
                <div class="col">
                    <nav class="site-main-menu menu-height-100 justify-content-center">
                        <ul>
                            <li>
                                <a href="index"><span class="menu-text">'.$trans['menu_inicio'].'</span></a>
                            </li>
                            <li>
                                <a href="shop"><span class="menu-text">'.$trans['menu_productos'].'</span></a>
                            </li>
                            <!--<li>
                                <a href="wholesales"><span class="menu-text">'.$trans['menu_wholesales'].'</span></a>
                            </li>-->
                            <li>
                                <a href="aboutus"><span class="menu-text">'.$trans['menu_nosotros'].'</span></a>
                            </li>
                            <li>
                                <a href="blog"><span class="menu-text">'.$trans['menu_blog'].'</span></a>
                            </li>
                            <li>
                                <a href="contact"><span class="menu-text">'.$trans['menu_contacto'].'</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Search End -->

                <!-- Header Tools Start -->
                <div class="col">
                    <div class="header-tools justify-content-end">
                        <div class="header-login">
                            <a href='.(isset($_SESSION['usercode'])?"myaccount":"login").'><i class="fal fa-user"></i></a>
                        </div>
                        <div class="header-cart">
                            <a href="#offcanvas-cart" class="offcanvas-toggle" id="cartcount">'.($quantity>0 ? '<span class="cart-count">'.$quantity.'</span>' : '').'<i class="fal fa-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Header Tools End -->

            </div>
        </div>

    </div>
    <!-- Header Section End -->

    <!-- Header Sticky Section Start -->
    <div class="sticky-header header-menu-center section bg-white d-none d-xl-block">
        <div class="container">
            <div class="row align-items-center">

                <!-- Header Logo Start -->
                <div class="col">
                    <div class="header-logo">
                        <a href="index"><img src="img/logo/logof.png" alt="Hempleaf Logo"></a>
                    </div>
                </div>
                <!-- Header Logo End -->

                <!-- Search Start -->
                <div class="col d-none d-xl-block">
                    <nav class="site-main-menu justify-content-center">
                        <ul>
                            <li>
                                <a href="index"><span class="menu-text">'.$trans['menu_inicio'].'</span></a>
                            </li>
                            <li>
                                <a href="shop"><span class="menu-text">'.$trans['menu_productos'].'</span></a>
                            </li>
                            <!--<li>
                                <a href="wholesales"><span class="menu-text">'.$trans['menu_wholesales'].'</span></a>
                            </li>-->
                            <li>
                                <a href="aboutus"><span class="menu-text">'.$trans['menu_nosotros'].'</span></a>
                            </li>
                            <li>
                                <a href="blog"><span class="menu-text">'.$trans['menu_blog'].'</span></a>
                            </li>
                            <li>
                                <a href="contact"><span class="menu-text">'.$trans['menu_contacto'].'</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Search End -->

                <!-- Header Tools Start -->
                <div class="col-auto">
                    <div class="header-tools justify-content-end">
                        <div class="header-login">
                        <!-- <a href='.(isset($_SESSION['usercode'])?"myaccount":"login").'><i class="fal fa-user"></i></a> -->
                        </div>
                        <div class="header-cart">
                        <!-- <a href="#offcanvas-cart" class="offcanvas-toggle" id="cartcount2">'.($quantity>0 ? '<span class="cart-count">'.$quantity.'</span>' : '').'<i class="fal fa-shopping-cart"></i></a> -->
                        </div>
                        <div class="mobile-menu-toggle d-xl-none">
                            <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                                <svg viewBox="0 0 800 600">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Header Tools End -->

            </div>
        </div>

    </div>
    <!-- Header Sticky Section End -->

    <!-- Mobile Header Section Start -->
    <div class="mobile-header bg-white section d-xl-none">
        <div class="container">
            <div class="row align-items-center">

                <!-- Header Logo Start -->
                <div class="col">
                    <div class="header-logo">
                        <a href="index"><img src="img/logo/logof.png" alt="Hempleaf Logo"></a>
                    </div>
                </div>
                <!-- Header Logo End -->

                <!-- Header Tools Start -->
                <div class="col-auto">
                    <div class="header-tools justify-content-end">
                        <div class="header-login d-none d-sm-block">
                        <!-- <a href='.(isset($_SESSION['usercode'])?"myaccount":"login").'><i class="fal fa-user"></i></a> -->
                        </div>
                        <div class="header-cart">
                        <!-- <a href="#offcanvas-cart" class="offcanvas-toggle" id="cartcount3">'.($quantity>0 ? '<span class="cart-count">'.$quantity.'</span>' : '').'<i class="fal fa-shopping-cart"></i></a> -->
                        </div>
                        <div class="mobile-menu-toggle">
                            <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                                <svg viewBox="0 0 800 600">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Header Tools End -->

            </div>
        </div>
    </div>
    <!-- Mobile Header Section End -->

    <!-- OffCanvas Cart Start -->
    <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
        <div class="inner">
            <div class="head">
            <!-- <span class="title">'.$trans['canvas_cart'].'</span> -->
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll" id="cartlist">';
            if($quantity > 0){
               echo '<ul class="minicart-product-list">';
               $lang = "es";
                if(isset($_COOKIE['language'])){
                    $lang = $_COOKIE['language'];
                    if($lang != "es" && $lang != "en"){
                        $lang = "es";
                    }
                }
               $products = $db->getCart($lang);
                    foreach($products as $product){
                    $guidproduct = $product->guidproduct;
                    $title = $product->title;
                    $imagename = $product->imagename;
                    $extension = $product->extension;
                    $price = $product->finalprice + $product->finalpricetax;
                    $quantityitem = $product->count;
                    echo '<li>
                        <a href="productdetails?guidproduct='.$guidproduct.'" class="image"><img src="img/product/'.$imagename.'-cart.'.$extension.'" alt="Cart product Image"></a>
                        <div class="content">
                            <a href="productdetails?guidproduct='.$guidproduct.'" class="title">'.$title.'</a>
                            <span class="quantity-price">'.$quantityitem.' x <span class="amount">'.$price.'€</span></span>
                            <a class="remove removeFromCart" data-id="'.$guidproduct.'">×</a>
                        </div>
                    </li>';
                }
                echo '</ul>
                ';
            }else{
                echo ''.$trans['canvas_vacio'].'';
            }
            echo '</div>
            <div class="foot">';
            if($quantity>0){
                echo '<div class="sub-total">
                    <strong>'.$trans['canvas_subtotal'].' :</strong>
                    <span class="amount">'.$subtotal.'€</span>
                </div>
                <a class="emptyCart">'.$trans['canvas_vaciar'].'</a>
                <div class="buttons">
                    <a href="cart" class="btn btn-dark btn-hover-primary">'.$trans['canvas_ver'].'</a>
                    <a href="checkout" class="btn btn-outline-dark">'.$trans['canvas_checkout'].'</a>
                </div>';
            }else{
                echo '<div class="buttons">
                <a href="shop" class="btn btn-dark btn-hover-primary offcanvas-close">'.$trans['canvas_continuar'].'</a>
                </div>';
            }
                echo '<p class="minicart-message">'.$trans['canvas_freeshipping'].'100€!</p>
            </div>
        </div>
    </div>
    <!-- OffCanvas Cart End -->

    <!-- OffCanvas Search Start -->
    <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
        <div class="inner customScroll">
            <div class="mobile-logo">
                <a href="index"><img src="img/logo/HL-Icon-White.png" alt="Hempleaf Logo"></a>
            </div>
            <div class="offcanvas-menu">
                <ul>
                    <li>
                        <a href="index"><span class="menu-text">'.$trans['menu_inicio'].'</span></a>
                    </li>
                    <li>
                        <a href="shop"><span class="menu-text">'.$trans['menu_productos'].'</span></a>
                    </li>
                    <!--<li>
                        <a href="wholesales"><span class="menu-text">'.$trans['menu_wholesales'].'</span></a>
                    </li>-->
                    <li>
                        <a href="aboutus"><span class="menu-text">'.$trans['menu_nosotros'].'</span></a>
                    </li>
                    <li>
                        <a href="blog"><span class="menu-text">'.$trans['menu_blog'].'</span></a>
                    </li>
                    <li>
                        <a href="contact"><span class="menu-text">'.$trans['menu_contacto'].'</span></a>
                    </li>
                </ul>
            </div>
            <div class="offcanvas-buttons">
                <div class="row" style="justify-content: space-around;">
                    <div class="header-tools">
                        <div class="header-login">
                        <!-- <a href='.(isset($_SESSION['usercode'])?"myaccount":"login").'><i class="fal fa-user"></i></a> -->
                        </div>
                        <div class="header-cart">
                        <!-- <a href="cart" id="cartcount4">'.($quantity>0 ? '<span class="cart-count">'.$quantity.'</span>' : '').'<i class="fal fa-shopping-cart"></i></a> -->
                        </div>
                    </div>
                    <div class="nav-bar">
                        <ul class="language">
                            <li><a href="controller/lang?lang=es&callback='.$_SERVER['REQUEST_URI'].'" id="es" class="nav-bar-lang '.(!isset($_COOKIE["language"]) || $_COOKIE["language"] == "es" ? "active" : "").'" style="color: inherit;">ES</a></li>
                            <li><a href="controller/lang?lang=en&callback='.$_SERVER['REQUEST_URI'].'" id="en" class="nav-bar-lang '.(isset($_COOKIE["language"]) && $_COOKIE["language"] == "en" ? "active" : "").'" style="color: inherit;">EN</a></li>
                        </ul>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
    <!-- OffCanvas Search End -->

    <div class="offcanvas-overlay"></div>

    <div class="modal fade" id="alertmodal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
                aria-hidden="true" data-backdrop="static">
    </div>
    ';
}

function sectionbreadcrumb($text, $trans){
    $tokens = explode("|", $text);
    $N = count($tokens);
    $var = getPage($tokens[$N-1], $trans);
    echo '
    <!-- Page Title/Header Start -->
    <div class="page-title-section section" data-bg-image="img/bg/page-title-1.jpg">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="page-title">
                        <h1 class="title">'.$var[1].'</h1>
                        <ul class="breadcrumb">';
                        for($i=0; $i < $N; $i++) {
                            $var = getPage($tokens[$i], $trans);
                            if($i < $N-1){
                                echo '<li class="breadcrumb-item"><a href="'.$var[0].'">'.$var[1].'</a></li>';
                            }  else {
                                echo '<li class="breadcrumb-item active">'.$var[1].'</li>';
                            }
                        }
                        echo '</ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->
    ';
}    

function getPage($text, $trans){
    switch($text){
        case "contact": $ref="contact"; $name=$trans['breadcrumb_'.$text]; break;
        case "login": $ref="login"; $name=$trans['breadcrumb_'.$text]; break;
        case "lostpassword": $ref="lostpassword"; $name=$trans['breadcrumb_'.$text]; break;
        case "restorepassword": $ref="restorepassword"; $name=$trans['breadcrumb_'.$text]; break;
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
        case "termsandconditions": $ref="termsandconditions"; $name=$trans['breadcrumb_'.$text]; break;
        case "privacy": $ref="privacy"; $name=$trans['breadcrumb_'.$text]; break;
        case "legal": $ref="legal"; $name=$trans['breadcrumb_'.$text]; break;
        case "cookies": $ref="cookies"; $name=$trans['breadcrumb_'.$text]; break;
        case "payment": $ref="transaction"; $name="Pago"; break;

        default: $ref="index"; $name=$trans['breadcrumb_index']; break;
    }
    $var = array($ref, $name);
    return $var;
}

function sectioncookies($trans){
    echo '<div id="cookies">
        '.$trans['control_cookiesmessage'].' 🍪 ! 
        <span id="close-cookies" class="cookie-button">'.$trans['control_cookiesaccept'].'</span>
    </div>';
}


function sectionfooter($trans) {
    echo '
    <!-- Footer -->
    <div class="footer8-section section section-padding bg-dark learts-pt-60 learts-mt-100">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-4 col-sm-6 col-12 learts-mb-40">
                    <h4 class="widget-title">'.$trans['footer_contactanos'].'</h4>
                    <div class="widget-contact2">
                        <p>C/ Potasio, 7<br> Loma Cabrera, Almería <br> info@farmacialosllanos.org <br> <span>(+34) 950 33 70 53</span> <br> <span class="text-primary">www.farmacialosllanos.org</span></p>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 learts-mb-40">
                    <h4 class="widget-title">'.$trans['footer_usefull'].'</h4>
                    <ul class="widget-list">
                        <li><a href="shop">'.$trans['footer_shop'].'</a></li>
                        <!-- <li><a href="wholesales">'.$trans['footer_wholesales'].'</a></li> -->
                        <!-- <li><a href="myaccount">'.$trans['footer_myaccount'].'</a></li> -->
                        <li><a href="contact">'.$trans['footer_contacto'].'</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 learts-mb-40">
                    <h4 class="widget-title">'.$trans['footer_about'].'</h4>
                    <ul class="widget-list">
                        <li><a href="aboutus">'.$trans['footer_aboutus'].'</a></li>
                        <li><a href="https://maps.app.goo.gl/oUg9AVoB9mbK26Pe7" target="_blank">'.$trans['footer_store'].'</a></li>
                        <li><a href="faq">'.$trans['footer_faq'].'</a></li>
                        <li><a href="xml-sitemap">'.$trans['footer_sitemap'].'</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 learts-mb-40">
                    <h4 class="widget-title">'.$trans['footer_legal'].'</h4>
                    <ul class="widget-list">
                        <li><a href="termsandconditions">'.$trans['footer_terms'].'</a></li>
                        <li><a href="privacy">'.$trans['footer_policy'].'</a></li>
                        <li><a href="legal">'.$trans['footer_notice'].'</a></li>
                        <li><a href="cookies">'.$trans['footer_cookies'].'</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 learts-mb-40">
                    <h4 class="widget-title">'.$trans['footer_social'].'</h4>
                    <ul class="widget-list">
                        <li> <i class="fab fa-instagram"></i> <a href="https://www.instagram.com/farmacialosllanosalmeria/" target="_blank">Instagram</a></li>
                        
                        <li> <i class="fab fa-facebook"></i> <a href="https://www.facebook.com/FarmaciaLosLlanos/" target="_blank">Facebook</a></li>
                    </ul>
                </div>
            </div>
            <div class="row align-items-end learts-mb-n40 learts-mt-40">
                <div class="col-md-4 col-12 learts-mb-40 order-md-2">
                    <div class="widget-about text-center">
                        <img src="img/logo/logof.png" alt="">
                    </div>
                </div>

                <div class="col-md-4 col-12 learts-mb-40 order-md-3">
                    <div class="widget-payment text-center text-md-right">
                        <img src="img/others/pay.png" alt="">
                    </div>
                </div>

                <div class="col-md-4 col-12 learts-mb-40 order-md-1">
                    <div class="widget-copyright">
                        <p class="copyright text-center text-md-left">&copy; <script>document.write(new Date().getFullYear());</script>  Farmacialosllanos. '.$trans['footer_copy'].'</a></p>
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

    <!-- Vendors JS -->
    <script src="js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="js/vendor/jquery-3.4.1.min.js"></script>
    <script src="js/vendor/jquery-migrate-3.1.0.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>

    <!-- Plugins JS -->
    <script src="js/plugins/select2.min.js"></script>
    <script src="js/plugins/jquery.nice-select.min.js"></script>
    <script src="js/plugins/perfect-scrollbar.min.js"></script>
    <script src="js/plugins/swiper.min.js"></script>
    <script src="js/plugins/slick.min.js"></script>
    <script src="js/plugins/mo.min.js"></script>
    <script src="js/plugins/jquery.instagramFeed.min.js"></script>
    <script src="js/plugins/jquery.ajaxchimp.min.js"></script>
    <script src="js/plugins/jquery.countdown.min.js"></script>
    <script src="js/plugins/imagesloaded.pkgd.min.js"></script>
    <script src="js/plugins/isotope.pkgd.min.js"></script>
    <script src="js/plugins/jquery.matchHeight-min.js"></script>
    <script src="js/plugins/ion.rangeSlider.min.js"></script>
    <script src="js/plugins/photoswipe.min.js"></script>
    <script src="js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="js/plugins/jquery.zoom.min.js"></script>
    <script src="js/plugins/ResizeSensor.js"></script>
    <script src="js/plugins/jquery.sticky-sidebar.min.js"></script>
    <script src="js/plugins/product360.js"></script>
    <script src="js/plugins/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins/jquery.scrollUp.min.js"></script>
    <script src="js/plugins/scrollax.min.js"></script>

    <!-- Main Activation JS -->
    <script src="js/main.js"></script>
';
}

function isAcceptedIp($acceptedIps){
    return empty($acceptedIps) || in_array(getIp(), $acceptedIps);
}

function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip del cliente
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip desde proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
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