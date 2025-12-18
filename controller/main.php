<?php
include_once("config.php");
include_once("expire.php");

$acceptedIps = array();
if(getcurrentpath() == "coming-soon"){
    if(isAcceptedIp($acceptedIps)){
        redirect("index");
    }
}else if(!isAcceptedIp($acceptedIps)){
    redirect("coming-soon");
}

$lang = "es";
if(isset($_COOKIE['language'])){
    $lang = $_COOKIE['language'];
    if($lang != "es" && $lang != "en"){
        $lang = "es";
    }
}

 $trans = array();
$res=$db->query("SELECT tag, texto FROM etiqueta WHERE idioma = '$lang'");
while($row = mysqli_fetch_array($res)){
    $trans[$row['tag']] = $row['texto'];
}

function getcurrentpath(){
    $relative = "";
    if($_SERVER['HTTP_HOST'] == "localhost"){
        $relative = str_replace("/farmacialosllanos/","",$_SERVER['REQUEST_URI']);
    }else if($_SERVER['HTTP_HOST'] == "farmacialosllanos.ddns.net"){
        $relative = str_replace("/farmacialosllanos/","",$_SERVER['REQUEST_URI']);
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/cookies.js"></script>

';
}

function getMeta($db, $page=""){
    $lang = "es";
    if(isset($_COOKIE['language'])){
        $lang = $_COOKIE['language'];
        if($lang != "es" && $lang != "en"){
            $lang = "es";
        }
    }
    $parts = explode('/', $_SERVER['SCRIPT_NAME']);
    $page = explode('.', array_pop($parts))[0];
    $qs = $_SERVER['QUERY_STRING'];
    $title = "Los Llanos - ";
    $robots = "index, follow";
    $description = "";
    $viewport = "width=device-width, initial-scale=1, shrink-to-fit=no";
    $author = "Grupo3";
    $replyto = "info@farmacialosllanos.org";
    $keywords = "";
    $resourcetype = "Document";
    $datecreated = "Thu, 20 Nov 2025 00:00:00 GMT+1";
    $revisitafter = "30 days";
    
    // Valores por defecto para Social Media
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $domain = $_SERVER['HTTP_HOST'];
    $ogImage = $protocol . "://" . $domain . "/img/logo/logof.png";
    $ogType = "website";
    $ogUrl = $protocol . "://" . $domain . $_SERVER['REQUEST_URI'];
    $canonicalUrl = $ogUrl; // URL canónica por defecto
    $siteName = "Farmacia Los Llanos";
    
    $query = "SELECT * FROM metadata WHERE page = ? AND lang= ?";
    $res=$db->prepare($query, array($page, $lang));
    if($db->numRows($res) > 0){
        $row = mysqli_fetch_array($res);
        $title.=$row['title'];
        $robots = $row['robots'];
        $description = $row['description'];
        $keywords = $row['keywords'];
    }

    if (strpos($qs, 'guidproduct') !== false) {
        $guidproduct = str_replace("guidproduct=", "", $qs);
        $query = "SELECT summary, metatitle, pi.image FROM product p
        LEFT JOIN product_translation pt ON p.id = pt.productId
        LEFT JOIN (SELECT DISTINCT productId, image FROM product_image WHERE isdeleted = 0 LIMIT 1) pi ON p.id = pi.productId
        WHERE guidproduct = ? AND lang = ?";
        $res=$db->prepare($query, array($guidproduct, $lang));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $description = $row['summary'];
            $keywords = $row['metatitle'];
            $ogType = "product";
            if(!empty($row['image'])){
                $ogImage = $protocol . "://" . $domain . "/img/product/" . $row['image'];
            }
            // Canonical para productos
            $canonicalUrl = $protocol . "://" . $domain . "/productdetails?guidproduct=" . $guidproduct;
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
            // Canonical para wholesales
            $canonicalUrl = $protocol . "://" . $domain . "/wholesaledetails?guidwholesale=" . $guidwholesale;
        }
    }else if (strpos($qs, 'guidpost') !== false) {
        $guidpost = str_replace("guidpost=", "", $qs);
        $query = "SELECT metatitle, image FROM post WHERE guidpost = ?";
        $res=$db->prepare($query, array($guidpost));
        if($db->numRows($res) > 0){
            $row = mysqli_fetch_array($res);
            $description = $row['metatitle'];
            $ogType = "article";
            if(!empty($row['image'])){
                $ogImage = $protocol . "://" . $domain . "/img/blog/" . $row['image'];
            }
            // Canonical para posts de blog
            $canonicalUrl = $protocol . "://" . $domain . "/blogdetails?guidpost=" . $guidpost;
        }
    }else if (!empty($qs) && strpos($qs, 'page=') !== false) {
        // Para páginas con paginación, usar la URL sin el parámetro de página
        $canonicalUrl = $protocol . "://" . $domain . "/" . $page;
    }else{
        // Para páginas normales sin query string
        $canonicalUrl = $protocol . "://" . $domain . "/" . $page;
    }

    $meta = '<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>'.$title.'</title>
    <meta name="robots" content="'.$robots.'">
    <meta name="description" content="'.$description.'">
    <meta name="viewport" content="'.$viewport.'">
    <meta name="author" content="'.$author.'">
    <meta name="reply-to" content="'.$replyto.'">
    <meta name="keywords" content="'.$keywords.'">
    <meta name="resource-type" content="'.$resourcetype.'">
    <meta name="datecreated" content="'.$datecreated.'">
    <meta name="revisit-after" content="'.$revisitafter.'">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="'.$canonicalUrl.'">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="'.$ogType.'">
    <meta property="og:url" content="'.$canonicalUrl.'">
    <meta property="og:title" content="'.$title.'">
    <meta property="og:description" content="'.$description.'">
    <meta property="og:image" content="'.$ogImage.'">
    <meta property="og:site_name" content="'.$siteName.'">
    <meta property="og:locale" content="'.($lang == 'es' ? 'es_ES' : 'en_US').'">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="'.$canonicalUrl.'">
    <meta property="twitter:title" content="'.$title.'">
    <meta property="twitter:description" content="'.$description.'">
    <meta property="twitter:image" content="'.$ogImage.'">';
    
    return $meta;
}

function sectiontopbar($trans){
    echo '
    <div class="topbar-section section border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col d-none d-md-block">
                    <div class="topbar-menu">
                        <ul>
                            <li><a href="https://maps.app.goo.gl/oUg9AVoB9mbK26Pe7" target="_blank" aria-label="Localización"><i class="fa fa-map-marker-alt"></i>'.$trans['top_store'].'</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col d-md-none d-lg-block">
                    <p class="text-center my-2">'.$trans['top_message'].'</p>
                </div>

                <div class="col d-none d-md-block">
                    <div class="nav-bar">
                        <ul class="language">
                            <li><a href="controller/lang?lang=es&callback='.$_SERVER['REQUEST_URI'].'" id="es" class="nav-bar-lang '.(!isset($_COOKIE["language"]) || $_COOKIE["language"] == "es" ? "active" : "").'" aria-label="Español">ES</a></li>
                            <li><a href="controller/lang?lang=en&callback='.$_SERVER['REQUEST_URI'].'" id="en" class="nav-bar-lang '.(isset($_COOKIE["language"]) && $_COOKIE["language"] == "en" ? "active" : "").'" aria-label="Inglés">EN</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    echo '
    <div class="header-section header-menu-center section bg-white d-none d-xl-block">
        <div class="container">
            <div class="row align-items-center">

                <div class="col">
                    <div class="header-logo">
                        <a href="./" aria-label="Inicio"><img src="img/logo/logof.png" alt="Los Llanos Logo"></a>
                    </div>
                </div>

                <div class="col">
                    <nav class="site-main-menu menu-height-100 justify-content-center">
                        <ul>
                            <li>
                                <a href="index"><span class="menu-text">'.$trans['menu_inicio'].'</span></a>
                            </li>
                            <li>
                                <a href="shop"><span class="menu-text">'.$trans['menu_productos'].'</span></a>
                            </li>
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

                <div class="col">
                    <div class="header-tools justify-content-end">
                        <div class="header-login">
                            <a href='.(isset($_SESSION['usercode'])?"myaccount":"login").' aria-label="Cuenta de usuario"><i class="fal fa-user"></i></a>
                        </div>
                        <div class="header-cart">
                            <a href="#offcanvas-cart" class="offcanvas-toggle" id="cartcount" aria-label="Carrito de compras">'.($quantity>0 ? '<span class="cart-count">'.$quantity.'</span>' : '').'<i class="fal fa-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="sticky-header header-menu-center section bg-white d-none d-xl-block">
        <div class="container">
            <div class="row align-items-center">

                <div class="col">
                    <div class="header-logo">
                        <a href="./" aria-label="Inicio"><img src="img/logo/logof.png" alt="Farmacia Los Llanos Logo"></a>
                    </div>
                </div>

                <div class="col d-none d-xl-block">
                    <nav class="site-main-menu justify-content-center">
                        <ul>
                            <li>
                                <a href="index"><span class="menu-text">'.$trans['menu_inicio'].'</span></a>
                            </li>
                            <li>
                                <a href="shop"><span class="menu-text">'.$trans['menu_productos'].'</span></a>
                            </li>
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

                <div class="col-auto">
                    <div class="header-tools justify-content-end">
                        <div class="header-login">
                        </div>
                        <div class="header-cart">
                        </div>
                        <div class="mobile-menu-toggle d-xl-none">
                            <a href="#offcanvas-mobile-menu" class="offcanvas-toggle" aria-label="Menú móvil">
                                <svg viewBox="0 0 800 600">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="mobile-header bg-white section d-xl-none">
        <div class="container">
            <div class="row align-items-center">

                <div class="col">
                    <div class="header-logo">
                        <a href="./" aria-label="Inicio"><img src="img/logo/logof.png" alt="Los Llanos Logo"></a>
                    </div>
                </div>

                <div class="col-auto">
                    <div class="header-tools justify-content-end">
                        <div class="header-login d-none d-sm-block">
                        </div>
                        <div class="header-cart">
                        </div>
                        <div class="mobile-menu-toggle">
                            <a href="#offcanvas-mobile-menu" class="offcanvas-toggle" aria-label="Menú móvil">
                                <svg viewBox="0 0 800 600">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
        <div class="inner">
            <div class="head">
            <!-- <span class="title">'.$trans['canvas_cart'].'</span> -->
                <button class="offcanvas-close" aria-label="Cerrar">×</button>
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
                        <a href="productdetails?guidproduct='.$guidproduct.'" class="image"><img src="img/product/'.$imagename.'-cart.'.$extension.'" alt="Producto del carrito"></a>
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

    <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
        <div class="inner customScroll">
            <div class="mobile-logo">
                <a href="index" aria-label="Inicio"><img src="img/logo/HL-Icon-White.png" alt="Los Llanos Logo"></a>
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
                        <a href='.(isset($_SESSION['usercode'])?"myaccount":"login").' aria-label="Cuenta de usuario"><i class="fal fa-user" style="color: #595959;"></i></a>
                        </div>
                        <div class="header-cart">
                        <a href="cart" id="cartcount4" aria-label="Carrito de compras">'.($quantity>0 ? '<span class="cart-count">'.$quantity.'</span>' : '').'<i class="fal fa-shopping-cart"  style="color: #595959;"></i></a>
                        </div>
                    </div>
                    <div class="nav-bar">
                        <ul class="language">
                            <li><a href="controller/lang?lang=es&callback='.$_SERVER['REQUEST_URI'].'" id="es" class="nav-bar-lang '.(!isset($_COOKIE["language"]) || $_COOKIE["language"] == "es" ? "active" : "").'" style="color: inherit;" aria-label="Español">ES</a></li>
                            <li><a href="controller/lang?lang=en&callback='.$_SERVER['REQUEST_URI'].'" id="en" class="nav-bar-lang '.(isset($_COOKIE["language"]) && $_COOKIE["language"] == "en" ? "active" : "").'" style="color: inherit;" aria-label="English">EN</a></li>
                        </ul>
                    </div>
                </div>
            </div>
           
        </div>
    </div>

    <div class="offcanvas-overlay"></div>

    <div class="modal fade" id="alertmodal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Carrito de compras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="alertModalBody">
                    <!-- El mensaje se inyectará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Continuar comprando</button>
                    <button type="button" class="btn btn-primary" id="modalBtnConfirm">Ver carrito</button>
                </div>
            </div>
        </div>
    </div>
    ';
}

function sectionbreadcrumb($text, $trans){
    $tokens = explode("|", $text);
    $N = count($tokens);
    $var = getPage($tokens[$N-1], $trans);
    echo '
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
    echo '<div id="cookies-banner" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; z-index: 999999; background: #fff; box-shadow: 0 -2px 20px rgba(0,0,0,0.1); padding: 20px; margin: 0; width: 100%;">
        <div class="cookies-content" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
                <div class="cookies-icon" style="font-size: 48px; flex-shrink: 0;">🍪</div>
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="margin: 0 0 10px 0; font-size: 20px; color: #333; font-family: Marcellus, Arial, Helvetica, sans-serif;">'.$trans['cookies_banner_title'].'</h3>
                    <p style="margin: 0 0 20px 0; font-size: 14px; color: #595959; line-height: 1.5;">'.$trans['cookies_banner_message'].' <a href="cookies" style="color: #333; text-decoration: underline;">'.$trans['cookies_banner_link'].'</a></p>
                    
                   <div style="margin-bottom: 20px;">
                        <div class="cookie-category" style="background: #f9f9f9; padding: 12px; margin-bottom: 10px; border-radius: 4px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="cookie-switch">
                                    <input type="checkbox" id="cookie-necessary" checked disabled aria-label="Cookies Necesarias - Obligatorias">
                                    
                                </div>
                                <div style="flex: 1;">
                                    <span style="font-size: 14px; color: #333; font-weight: 500;">Cookies Necesarias</span>
                                    <span style="background: #333; color: #fff; padding: 2px 6px; border-radius: 3px; font-size: 10px; margin-left: 8px;">Obligatorias</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cookie-category" style="background: #f9f9f9; padding: 12px; margin-bottom: 10px; border-radius: 4px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="cookie-switch">
                                    <input type="checkbox" id="cookie-analytics" aria-label="Activar Cookies Analíticas">
                                   
                                </div>
                                <div style="flex: 1;">
                                    <span style="font-size: 14px; color: #333; font-weight: 500;">Cookies Analíticas</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cookie-category" style="background: #f9f9f9; padding: 12px; margin-bottom: 10px; border-radius: 4px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="cookie-switch">
                                    <input type="checkbox" id="cookie-marketing" aria-label="Activar Cookies de Marketing">
                                    
                                </div>
                                <div style="flex: 1;">
                                    <span style="font-size: 14px; color: #333; font-weight: 500;">Cookies de Marketing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cookies-buttons" style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button id="accept-all-cookies" class="btn btn-primary2 btn-hover-black">Aceptar todas</button>
                        <button id="reject-cookies" class="btn btn-secondary btn-hover-black" style="background-color: #54585F;border-color: #54585F;">Rechazar</button>
                        <button id="save-cookie-preferences" class="btn btn-secondary btn-hover-black" style="background-color: #54585F;border-color: #54585F;">Guardar preferencias</button>
                    </div>
                </div>
            </div>
        </div>
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
                        <p>C/ Potasio, 7<br> Loma Cabrera, Almería <br> info@farmacialosllanos.org <br> <span>(+34) 950 33 70 53</span> <br> <span style="color: #A7CDB8;">www.farmacialosllanos.org</span></p>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 learts-mb-40">
                    <h4 class="widget-title">'.$trans['footer_usefull'].'</h4>
                    <ul class="widget-list">
                        <li><a href="shop">'.$trans['footer_shop'].'</a></li>
                        <li><a href="myaccount">'.$trans['footer_myaccount'].'</a></li>
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
                        <li> <i class="fab fa-instagram"></i> <a href="https://www.instagram.com/farmacialosllanosalmeria/" target="_blank" aria-label="Instagram">Instagram</a></li>
                        
                        <li> <i class="fab fa-facebook"></i> <a href="https://www.facebook.com/FarmaciaLosLlanos/" target="_blank" aria-label="Facebook">Facebook</a></li>
                    </ul>
                </div>
            </div>
            <div class="row align-items-end learts-mb-n40 learts-mt-40">
                <div class="col-md-4 col-12 learts-mb-40 order-md-2">
                    <div class="widget-about text-center">
                        <img src="img/logo/logof.png" alt="Logo Farmacia Los Llanos">
                    </div>
                </div>

                <div class="col-md-4 col-12 learts-mb-40 order-md-3">
                    <div class="widget-payment text-center text-md-right">
                        <img src="img/others/pay.png" alt="Métodos de pago">
                    </div>
                </div>

                <div class="col-md-4 col-12 learts-mb-40 order-md-1">
                    <div class="widget-copyright">
                        <p class="copyright text-center text-md-left">&copy; <script>document.write(new Date().getFullYear());</script>  Farmacia Los Llanos. '.$trans['footer_copy'].'</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Footer ends -->
';
}

function sectionjs(){
    global $trans;
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
    <!--<script src="js/plugins/jquery.instagramFeed.min.js"></script>-->
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
    <script src="js/productquantity.js"></script>
';
    sectioncookies($trans);
}

function isAcceptedIp($acceptedIps){
    return empty($acceptedIps) || in_array(getIp(), $acceptedIps);
}

function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
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
    $cookie_options = array(
        'expires' => time() - 3600,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    );
    
    if (isset($_COOKIE["member_login"])) {
        setcookie("member_login", "", $cookie_options);
    }
    if (isset($_COOKIE["random_password"])) {
        setcookie("random_password", "", $cookie_options);
    }
    if (isset($_COOKIE["random_selector"])) {
        setcookie("random_selector", "", $cookie_options);
    }
}

function cryptoRandSecure($min, $max){
    $range = $max - $min;
    if ($range < 1) {
        return $min;
    }
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1;
    $bits = (int) $log + 1;
    $filter = (int) (1 << $bits) - 1;
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter;
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