<?php
include ("mainadmin.php");

//Total Ventas
$query = "SELECT SUM(subtotal) as subtotal FROM `order` 
WHERE YEAR(createdAt) = YEAR(NOW())";
$res=$db->query($query);
$totalventas = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalventas = intval($row['subtotal']);
}

//Total Ventas Porcentaje
$query = "SELECT SUM(subtotal) as subtotal FROM `order` 
WHERE YEAR(createdAt) = YEAR(NOW())-1";
$res=$db->query($query);
$totalventasLY = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalventasLY = intval($row['subtotal']);
}

$porcentajeVentas = $totalventasLY == 0 ? 100 : ($totalventas/$totalventasLY-1)*100;

$ventasporcentajetext = $porcentajeVentas >= 0 ? '<span><i class="fa fa-fw fa-arrow-up"></i></span><span>'.$porcentajeVentas.'%</span>' : '<span><i class="fa fa-fw fa-arrow-down"></i></span><span>'.$porcentajeVentas.'%</span>';

//Ventas
$query = "SELECT SUM(subtotal) as subtotal FROM `order`
WHERE YEAR(createdAt) = YEAR(NOW())
GROUP BY YEAR(createdAt)*100+MONTH(createdAt)
ORDER BY YEAR(createdAt)*100+MONTH(createdAt) ASC";
$res=$db->query($query);
$ventas = array();
while($row = mysqli_fetch_array($res)){
    $ventas[] = intval($row['subtotal']);
}
/////////////////
//Total Pedidos
$query = "SELECT COUNT(*) as pedidos FROM `order`
WHERE YEAR(createdAt) = YEAR(NOW())";
$res=$db->query($query);
$totalpedidos = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalpedidos = intval($row['pedidos']);
}

//Total Pedidos Porcentaje
$query = "SELECT COUNT(*) as pedidos FROM `order` 
WHERE YEAR(createdAt) = YEAR(NOW())-1";
$res=$db->query($query);
$totalpedidosLY = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalpedidosLY = intval($row['pedidos']);
}

$porcentajePedidos = $totalpedidosLY == 0 ? 100 : ($totalpedidos/$totalpedidosLY-1)*100;

$pedidosporcentajetext = $porcentajePedidos >= 0 ? '<span><i class="fa fa-fw fa-arrow-up"></i></span><span>'.$porcentajePedidos.'%</span>' : '<span><i class="fa fa-fw fa-arrow-down"></i></span><span>'.$porcentajePedidos.'%</span>';

//Pedidos
$query = "SELECT COUNT(*) as pedidos FROM `order`
WHERE YEAR(createdAt) = YEAR(NOW())
GROUP BY YEAR(createdAt)*100+MONTH(createdAt)
ORDER BY YEAR(createdAt)*100+MONTH(createdAt) ASC";
$res=$db->query($query);
$pedidos = array();
while($row = mysqli_fetch_array($res)){
    $pedidos[] = intval($row['pedidos']);
}

///////////////////
//Total Ticket Medio
$query = "SELECT AVG(subtotal) as subtotal FROM `order`
WHERE YEAR(createdAt) = YEAR(NOW())";
$res=$db->query($query);
$totalmedio = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalmedio = intval($row['subtotal']);
}

//Total Ticket Medio Porcentaje
$query = "SELECT AVG(subtotal) as subtotal FROM `order` 
WHERE YEAR(createdAt) = YEAR(NOW())-1";
$res=$db->query($query);
$totalmedioLY = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalmedioLY = intval($row['subtotal']);
}

$porcentajeMedio = $totalmedioLY == 0 ? 100 : ($totalmedio/$totalmedioLY-1)*100;

$medioporcentajetext = $porcentajeMedio >= 0 ? '<span><i class="fa fa-fw fa-arrow-up"></i></span><span>'.$porcentajeMedio.'%</span>' : '<span><i class="fa fa-fw fa-arrow-down"></i></span><span>'.$porcentajeMedio.'%</span>';

//Ticket Medio
$query = "SELECT AVG(subtotal) as subtotal FROM `order`
WHERE YEAR(createdAt) = YEAR(NOW())
GROUP BY YEAR(createdAt)*100+MONTH(createdAt)
ORDER BY YEAR(createdAt)*100+MONTH(createdAt) ASC";
$res=$db->query($query);
$ticketmedio = array();
while($row = mysqli_fetch_array($res)){
    $ticketmedio[] = intval($row['subtotal']);
}

///////////////////
//Total Nuevos Clientes
$query = "SELECT COUNT(id) as nusers FROM `user`
WHERE admin = 0 AND vendor = 0 AND YEAR(registeredAt) = YEAR(NOW())";
$res=$db->query($query);
$totalusers = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalusers = intval($row['nusers']);
}

//Total Nuevos Clientes Porcentaje
$query = "SELECT COUNT(id) as nusers FROM `user`
WHERE admin = 0 AND vendor = 0 AND YEAR(registeredAt) = YEAR(NOW())-1";
$res=$db->query($query);
$totalusersLY = 0;
if($db->numRows($res) > 0){
    $row = mysqli_fetch_array($res);
    $totalusersLY = intval($row['nusers']);
}

$porcentajeUsers = $totalusersLY == 0 ? 100 : ($totalusers/$totalusersLY-1)*100;

$usersporcentajetext = $porcentajeUsers >= 0 ? '<span><i class="fa fa-fw fa-arrow-up"></i></span><span>'.$porcentajeUsers.'%</span>' : '<span><i class="fa fa-fw fa-arrow-down"></i></span><span>'.$porcentajeUsers.'%</span>';


//Nuevos Clientes
$query = "SELECT COUNT(id) as nusers FROM `user`
WHERE admin = 0 AND vendor = 0 AND YEAR(registeredAt) = YEAR(NOW())
GROUP BY YEAR(registeredAt)*100+MONTH(registeredAt)
ORDER BY YEAR(registeredAt)*100+MONTH(registeredAt) ASC";
$res=$db->query($query);
$users = array();
while($row = mysqli_fetch_array($res)){
    $users[] = intval($row['nusers']);
}

//Pedidos por Día de la semana
$query = "SELECT CASE wd WHEN 0 THEN 'Lun'
WHEN 1 THEN 'Mar'
WHEN 2 THEN 'Mie'
WHEN 3 THEN 'Jue'
WHEN 4 THEN 'Vie'
WHEN 5 THEN 'Sab'
WHEN 6 THEN 'Dom' END as day
, COUNT(o.userId) as registeredorders
, COUNT(o2.userId) as nonregisteredorders
FROM(
	SELECT 0 as wd 
    UNION ALL SELECT 1 as wd 
    UNION ALL SELECT 2 as wd 
    UNION ALL SELECT 3 as wd 
    UNION ALL SELECT 4 as wd 
    UNION ALL SELECT 5 as wd 
    UNION ALL SELECT 6 as wd) wd
LEFT JOIN `order` o ON wd.wd = WEEKDAY(o.createdAt) AND o.isdeleted = 0 AND o.userId IS NOT NULL
LEFT JOIN `order` o2 ON wd.wd = WEEKDAY(o2.createdAt) AND o.isdeleted = 0 AND o2.userId IS NULL
GROUP BY wd.wd
ORDER BY wd.wd";
$res=$db->query($query);
$days = array();
$registeredorders = array();
$nonregisteredorders = array();
while($row = mysqli_fetch_array($res)){
    $days[] = $row['day'];
    $registeredorders[] = intval($row['registeredorders']);
    $nonregisteredorders[] = intval($row['nonregisteredorders']);
}

//Pedidos por Categoría
$query = "SELECT ct.title as category, COUNT(oi.id) as count FROM order_item oi
LEFT JOIN `order` o ON oi.orderId = o.id 
LEFT JOIN product_category pc ON oi.productId = pc.productId
LEFT JOIN category c ON pc.categoryId = c.id
LEFT JOIN category_translation ct ON c.id = ct.categoryId
WHERE ct.lang = 'es' AND o.isdeleted = 0
GROUP BY ct.title
ORDER BY COUNT(oi.id) DESC";
$res=$db->query($query);
$category = array();
$categoryorders = array();
while($row = mysqli_fetch_array($res)){
    $category[] = $row['category'];
    $categoryorders[] = intval($row['count']);
}

//Ventas por Mes
$query = "SELECT CASE m.m WHEN 1 THEN 'Ene'
WHEN 2 THEN 'Feb'
WHEN 3 THEN 'Mar'
WHEN 4 THEN 'Abr'
WHEN 5 THEN 'May'
WHEN 6 THEN 'Jun'
WHEN 7 THEN 'Jul'
WHEN 8 THEN 'Ago'
WHEN 9 THEN 'Sep'
WHEN 10 THEN 'Oct'
WHEN 11 THEN 'Nov'
WHEN 12 THEN 'Dic'
END as month
,CASE WHEN o.subtotal IS NULL THEN 0 ELSE SUM(o.subtotal) END as subtotal 
FROM (
	SELECT 1 as m 
	UNION ALL SELECT 2 as m
	UNION ALL SELECT 3 as m
	UNION ALL SELECT 4 as m
	UNION ALL SELECT 5 as m
	UNION ALL SELECT 6 as m
	UNION ALL SELECT 7 as m
	UNION ALL SELECT 8 as m
	UNION ALL SELECT 9 as m
	UNION ALL SELECT 10 as m
	UNION ALL SELECT 11 as m
	UNION ALL SELECT 12 as m
) m
LEFT JOIN `order` o ON m.m = MONTH(o.createdAt) AND o.createdAt BETWEEN NOW() - INTERVAL 365 DAY AND NOW()
GROUP BY m.m
ORDER BY m.m ASC";
$res=$db->query($query);
$chart_data = array();
while($row = mysqli_fetch_array($res)){
    $chart_data[] = array('x' => $row["month"], 'y' => $row["subtotal"]);
}

echo json_encode(array("totalventas" => $totalventas,
                        "ventasporcentaje" => $ventasporcentajetext,
                        "ventas" => $ventas,
                        "totalpedidos" => $totalpedidos,
                        "pedidosporcentaje" => $pedidosporcentajetext,
                        "pedidos" => $pedidos,
                        "totalmedio" => $totalmedio,
                        "medioporcentaje" => $medioporcentajetext,
                        "ticketmedio" => $ticketmedio,
                        "totalusers" => $totalusers,
                        "usersporcentaje" => $usersporcentajetext,
                        "users" => $users,
                        "days" => $days,
                        "registeredorders" => $registeredorders,
                        "nonregisteredorders" => $nonregisteredorders,
                        "category" => $category,
                        "categoryorders" => $categoryorders,
                        "totalpermonth" => $chart_data
                        )
                    );
?>