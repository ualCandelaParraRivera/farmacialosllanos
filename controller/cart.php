<?php
	include_once("main.php");
	$action = strip_tags($_GET["action"]);
	switch ($action) {
		case "add":
			$data = $db->addToCart($lang,$trans);
			echo $data;
			break;
		case "addqty":
			$data = $db->addToCartQty($lang,$trans);
			echo $data;
			break;
		case "remove":
			$db->removeFromCart($lang,$trans);
			break;
		case "set":
			$db->setToCart();
			break;
		case "promocart":
			$data = $db->getPromoCart($trans);
			echo $data;
			break;
		case "empty":
			$db->emptyCart($lang,$trans);
			break;
	}
?>