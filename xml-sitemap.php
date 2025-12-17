<?php


require './xml-config.php';

$replace_files = array_keys( $replace );

header( 'Content-Type: application/xml' );

echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";

$ignore = array_merge( $ignore, array( '.', '..', 'xml-config.php', 'xml-sitemap.php' ) );

if ( isset( $xsl ) && !empty( $xsl ) )
	echo '<?xml-stylesheet type="text/xsl" href="' . SITEMAP_DIR_URL . $xsl . '"?>' . "\n";

function parse_dir( $dir, $url ) {
	global $ignore, $filetypes, $replace, $chfreq, $prio, $replace_files;
	$specificprior = $prio;

	$handle = opendir( $dir );
	while ( false !== ( $file = readdir( $handle ) ) ) {

		if ( in_array( utf8_encode( $file ), $ignore ) ){
			continue;
		}
		
		if(strpos($file, "admin") !== false || strpos($file, "redirect") !== false || strpos($file, "orderview") !== false
		|| strpos($file, "restorepassword") !== false || strpos($file, "transaction") !== false || strpos($file, "validateregistration") !== false
		|| strpos($file, "wholesales") !== false || strpos($file, "wholesaledetails") !== false){
			continue;
		}

		switch ($file) {
			case 'index.php': $specificprior = 1; break;
			case '404.php': $specificprior = 0.1; break;
			case 'about.php': $specificprior = 0.8; break;
			case 'blog.php': $specificprior = 0.8; break;
			case 'blogdetails.php': $specificprior = 0.7; break;
			case 'cart.php': $specificprior = 0.4; break;
			case 'checkout.php': $specificprior = 0.4; break;
			case 'contact.php': $specificprior = 0.8; break;
			case 'faq.php': $specificprior = 0.75; break;
			case 'login.php': $specificprior = 0.7; break;
			case 'logout.php': $specificprior = 0.1; break;
			case 'lostpassword.php': $specificprior = 0.4; break;
			case 'myaccount.php': $specificprior = 0.6; break;
			case 'shop.php': $specificprior = 0.8; break;
			case 'productdetails.php': $specificprior = 0.7; break;
			case 'register.php': $specificprior = 0.7; break;
			case 'termsandconditions.php': $specificprior = 0.4; break;
			case 'privacy.php': $specificprior = 0.4; break;
			case 'legal.php': $specificprior = 0.4; break;
			case 'cookies.php': $specificprior = 0.4; break;
			default: $specificprior = $prio; break;
		}


		if ( is_dir( $file ) ) {
			if ( defined( 'RECURSIVE' ) && RECURSIVE )
				parse_dir( $file, $url . $file . '/' );
		}

		$fileinfo = pathinfo( $dir . $file );
		if ( in_array( $fileinfo['extension'], $filetypes ) ) {

			if (filemtime( $dir .'/'. $file )==FALSE) {
				$mod = date( 'c', filectime( $dir . $file ) );
			} else {
				$mod = date( 'c', filemtime( $dir . $file ) );
			}

			if ( in_array( $file, $replace_files ) )
				$file = $replace[$file];

	?>

    <url>
        <loc><?php echo $url . str_replace(".php", "", rawurlencode( $file )); ?></loc>
        <lastmod><?php echo $mod; ?></lastmod>
        <changefreq><?php echo $chfreq; ?></changefreq>
        <priority><?php echo $specificprior; ?></priority>
    </url><?php
		}
	}
	closedir( $handle );
}

?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><?php
	parse_dir( SITEMAP_DIR, SITEMAP_DIR_URL );
?>

</urlset>
