<?php

define( 'SITEMAP_DIR', './' );

if($_SERVER['HTTP_HOST'] == "farmacialosllanos.ddns.net" || $_SERVER['HTTP_HOST'] == "localhost"){
    $webroot = $_SERVER['HTTP_HOST']."/farmacialosllanos/";
}else{
    $webroot = $_SERVER['HTTP_HOST']."/";
}

define( 'SITEMAP_DIR_URL', 'https://'.$webroot );

define( 'RECURSIVE', false );

$filetypes = array( 'php', 'html', 'pdf' );

$replace = array( 'index.php' => '' );

$xsl = 'xml-sitemap.xsl';

$chfreq = 'monthly';

$prio = 0.5;

$ignore = array( 'config.php', 'first.php' );


