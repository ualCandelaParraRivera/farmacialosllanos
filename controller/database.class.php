<?php

Class Db{

   private $servidor='cuberty.ddns.net:3306';
   private $usuario='llanosfarmacia';
   private $password='Llanos25!Ual';
   private $base_datos='losllanos';
   private $link;
   private $res;
   private $array;
   private $stmt;
   static $_instance;

   private function __construct(){
      $this->conectar();
   }

   private function __clone(){ }

   public static function getInstance(){
      if (!(self::$_instance instanceof self)){
         self::$_instance=new self();
      }
      return self::$_instance;
   }

   private function conectar(){
      $this->link=mysqli_connect($this->servidor, $this->usuario, $this->password);
      mysqli_select_db($this->link, $this->base_datos);
      mysqli_set_charset($this->link, "utf8");
   }

   public function query($sql){
      $this->res=mysqli_query($this->link, $sql);
      return $this->res;
   }

   public function prepare($sql, $vars){
        $a_params = array();
        $param_type = $this->getTypes($vars);
        $n = count($vars);
        $a_params[] = & $param_type;
        for($i = 0; $i < $n; $i++) {
            $a_params[] = & $vars[$i];
        }
      $this->stmt=mysqli_prepare($this->link, $sql);
      call_user_func_array(array($this->stmt, 'bind_param'), $a_params);
      $this->stmt->execute();
      $this->res=$this->stmt->get_result();
      return $this->res;
   }

   public function prepareArray($sql, $vars){
      $a_params = array();
      $param_type = $this->getTypes($vars);
      $n = count($vars);
      $a_params[] = & $param_type;
      for($i = 0; $i < $n; $i++) {
          $a_params[] = & $vars[$i];
      }
      $this->stmt=mysqli_prepare($this->link, $sql);
      call_user_func_array(array($this->stmt, 'bind_param'), $a_params);
      $this->stmt->execute();
      $result=$this->stmt->get_result();
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $resultset[] = $row;
         }
      }
      
      if(!empty($resultset)) {
            return $resultset;
      }
 }

   private function getTypes($var){
       $types = "";
       foreach($var as $v){
           $types .= $this->getTypeAsChar($v);
       }
       return $types;
   }

   private function getTypeAsChar($var){
        switch(gettype($var)){
            case "string": return "s";
            case "integer": return "i";
            case "double": return "d";
            default: return "b";
        }
   }


   public function get($res,$fila=0){
      if ($fila==0){
         $this->array=mysqli_fetch_array($res);
      }else{
         mysqli_data_seek($res,$fila);
         $this->array=mysqli_fetch_array($res);
      }
      return $this->array;
   }

   public function lastID(){
      return mysqli_insert_id($this->link);
   }

   public function real_escape_string($escapestr){
       return mysqli_real_escape_string($this->link, $escapestr);
   }

   public function numRows($res){
       $n=mysqli_num_rows($res);
       return $n;
   }

   public function getProducts(){
		$arr = array();
		$res = $this->prepare("select id, title as product, price from products order by product asc",array());
		while ($row = mysqli_fetch_array($res)){
			$line = new stdClass;
			$line->id = $row['id']; 
			$line->product = $row['product']; 
			$line->price = $row['price'];
			$arr[] = $line;
		}
		return $arr;
	}
	
	public function addToCart(){
		if(isset($_GET["id"])){
         $guidproduct = $_GET["id"];
			if($_SESSION['cart'] != ""){
				$cart = json_decode($_SESSION['cart'], true);
				$found = false;
				for($i=0;$i<count($cart);$i++){
					if($cart[$i]["guidproduct"] == $guidproduct){
						$cart[$i]["count"] = $cart[$i]["count"]+1;
						$found = true;
						break;
					}
				}
				if(!$found){
					$line = new stdClass;
					$line->guidproduct = $guidproduct; 
					$line->count = 1;
					$cart[] = $line;
				}
				$_SESSION['cart'] = json_encode($cart);
			}else{
				$line = new stdClass;
				$line->guidproduct = $guidproduct; 
				$line->count = 1;
				$cart[] = $line;
				$_SESSION['cart'] = json_encode($cart);
			}
		}
	}

   public function addToCartQty(){
		if(isset($_GET["id"]) && isset($_GET["val"])){
         $guidproduct = $_GET["id"];
         $count = intval($_GET["val"]);
			if($_SESSION['cart'] != ""){
				$cart = json_decode($_SESSION['cart'], true);
				$found = false;
				for($i=0;$i<count($cart);$i++){
					if($cart[$i]["guidproduct"] == $guidproduct){
						$cart[$i]["count"] = $cart[$i]["count"]+$count;
						$found = true;
						break;
					}
				}
				if(!$found){
					$line = new stdClass;
					$line->guidproduct = $guidproduct; 
					$line->count = $count;
					$cart[] = $line;
				}
				$_SESSION['cart'] = json_encode($cart);
			}else{
				$line = new stdClass;
				$line->guidproduct = $guidproduct; 
				$line->count = $count;
				$cart[] = $line;
				$_SESSION['cart'] = json_encode($cart);
			}
		}
	}

   public function getPromoCart($trans){
      $errors = array();
      $data = array();
		if(isset($_GET["val"])){
         if(empty($_GET["val"])){
            $_SESSION['promo'] = "";
            $data['message'] = $trans['control_database_notapplied'];
         }else{
            $promocode = intval($_GET["val"]);
            $query = "SELECT promocode, discount, min, max, guidpromo 
            FROM promo
            WHERE isdeleted = 0 AND startDate <= NOW() AND endDate >= NOW() AND promocode = ?";
            $res = $this->prepare($query, array($promocode));
            if($this->numRows($res) > 0){
               $row = mysqli_fetch_array($res);
               $promo = new stdClass;
               $promo->promocode = $row['promocode']; 
               $promo->discount = $row['discount']; 
               $promo->min = $row['min']; 
               $promo->max = $row['max']; 
               $promo->guidpromo = $row['guidpromo']; 
               $data['message'] = $trans['control_database_code']." ".$row['promocode']." ".$trans['control_database_applied'];
               $cart[] = $promo;
               $_SESSION['promo'] = json_encode($cart);
            }else{
               $errors['code'] = $trans['control_database_invalid'];
            }
         }
         
		}else{
         $errors['code'] = $trans['control_database_error'];
      }
      if (!empty($errors)) {
         $data['success'] = false;
         $data['message'] = $errors['code'];
      }else{
         $data['success'] = true;
      }
      return json_encode($data);
	}
	
	public function removeFromCart(){
		if(isset($_GET["id"])){
         $guidproduct = $_GET["id"];
			if($_SESSION['cart'] != ""){
				$cart = json_decode($_SESSION['cart'], true);
				for($i=0;$i<count($cart);$i++){
					if($cart[$i]["guidproduct"] == $guidproduct){
						unset($cart[$i]);
						break;
					}
				}
				$cart = array_values($cart);
				$_SESSION['cart'] = json_encode($cart);
			}
		}
	}

   public function setToCart(){
		if(isset($_GET["id"]) && isset($_GET["val"])){
         $guidproduct = $_GET["id"];
         $count = intval($_GET["val"]);
			if($_SESSION['cart'] != ""){
				$cart = json_decode($_SESSION['cart'], true);
				for($i=0;$i<count($cart);$i++){
					if($cart[$i]["guidproduct"] == $guidproduct){
						$cart[$i]["count"] = $count;
						if($cart[$i]["count"] < 1){
							unset($cart[$i]);
						}
						break;
					}
				}
				$cart = array_values($cart);
				$_SESSION['cart'] = json_encode($cart);
			}
		}
	}
	
	public function emptyCart(){
		$_SESSION['cart'] = "";
	}
	
	public function getCart(){
		$cartArray = array();
      if(!isset($_SESSION['cart'])){
         $_SESSION['cart'] = "";
      }
		if($_SESSION['cart'] != ""){
			$cart = json_decode($_SESSION['cart'], true);
			for($i=0;$i<count($cart);$i++){
				$lines = $this->getProductData($cart[$i]["guidproduct"]);
				$line = new stdClass;
            $line->productid = $lines->productid;
            $line->sku = $lines->sku;
            $line->pricenotax = $lines->pricenotax;
            $line->price = $lines->price;
            $line->tax = $lines->tax;
            $line->discount = $lines->discount;
				$line->guidproduct = $cart[$i]["guidproduct"];
				$line->count = $cart[$i]["count"];
				$line->title = $lines->title;
            $line->finalprice = $lines->finalprice;
            $line->finalpricediscount = $lines->finalpricediscount;
            $line->finalpricetax = $lines->finalpricetax;
            $line->imagename = $lines->imagename;
            $line->extension = $lines->extension;
            $line->summary = $lines->summary;
				$line->total = ($lines->finalprice*$cart[$i]["count"]);
            $line->totaldiscount = ($lines->finalpricediscount*$cart[$i]["count"]);
            $line->totaltax = ($lines->finalpricetax*$cart[$i]["count"]);
				$cartArray[] = $line;
			}
		}
		return $cartArray;
	}

   public function getPromo(){
		$promoArray = array();
      if(!isset($_SESSION['promo'])){
         $_SESSION['promo'] = "";
      }
		if($_SESSION['promo'] != ""){
			$promos = json_decode($_SESSION['promo'], true);
			for($i=0;$i<count($promos);$i++){
				$promo = new stdClass;
				$promo->promocode = $promos[$i]["promocode"];
				$promo->discount = $promos[$i]["discount"];
				$promo->min = $promos[$i]["min"];
            $promo->max = $promos[$i]["max"];
            $promo->guidpromo = $promos[$i]["guidpromo"];
				$promoArray[] = $promo;
			}
		}
		return $promoArray;
	}
	
	private function getProductData($guidproduct){
      $lang = "es";
      if(isset($_COOKIE['language'])){
         $lang = $_COOKIE['language'];
         if($lang != "es" && $lang != "en"){
            $lang = "es";
         }
      }
      $query = "SELECT p.guidproduct
      ,p.id
      ,p.sku
      ,p.price
      ,p.pricenotax
      ,p.tax
      ,p.discount
      ,pt.title
      ,pt.summary
      ,ROUND(p.price*p.discount, 2) as finalpricediscount
      ,ROUND(p.price-p.price*p.discount, 2) as finalprice
      ,ROUND((p.price-p.price*p.discount)*p.tax, 2) as finalpricetax
      ,ltrim(replace(substring(substring_index(pi.image, '.', 1), length(substring_index(pi.image, '.', 1 - 1)) + 1), '.', '')) AS imagename
      ,ltrim(replace(substring(substring_index(pi.image, '.', 2), length(substring_index(pi.image, '.', 2 - 1)) + 1), '.', '')) AS extension 
      FROM product p
      LEFT JOIN product_translation pt ON p.id = pt.productId
      LEFT JOIN (SELECT pi.productId, pi.image FROM product_image pi WHERE pi.isdeleted = 0 GROUP BY productId) pi ON p.id = pi.productId
      WHERE pt.lang = '$lang' AND p.guidproduct = ?";
      $res = $this->prepare($query, array($guidproduct));
		$row = mysqli_fetch_array($res);
		$line = new stdClass;
      $line->productid = $row['id']; 
      $line->sku = $row['sku']; 
      $line->pricenotax = $row['pricenotax']; 
      $line->price = $row['price']; 
      $line->tax = $row['tax']; 
      $line->discount = $row['discount']; 
      $line->guidproduct = $row['guidproduct']; 
		$line->title = $row['title']; 
		$line->finalprice = $row['finalprice'];
      $line->finalpricediscount = $row['finalpricediscount'];
      $line->finalpricetax = $row['finalpricetax'];
      $line->imagename = $row['imagename'];
      $line->extension = $row['extension'];
      $line->summary = $row['summary'];
		return $line;
	}

}
?>