<?php include ("./controller/mainadmin.php");

if(!isset($_GET['guidorder'])){
    redirect(404);
}

// Include autoloader 
require_once 'dompdf/autoload.inc.php'; 
 
// Reference the Dompdf namespace 
use Dompdf\Dompdf; 
 
// Instantiate and use the dompdf class 
$dompdf = new Dompdf();

/* // Load HTML content 
$dompdf->loadHtml('<h1>Presupuesto PR13000003</h1>'); 
 
// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'portrait'); 
 
// Render the HTML as PDF 
$dompdf->render(); 
 
// Output the generated PDF to Browser 
$dompdf->stream();
?> */
$guidorder = $_GET['guidorder'];
$query = "SELECT CONCAT('FR', LPAD(o.id, 5, 0)) as invoiceid
    FROM `order` o
    WHERE isdeleted = 0 AND guidorder = ?";
    $res=$db->prepare($query, array($guidorder));
    $row = mysqli_fetch_array($res);
    $invoiceid = $row['invoiceid'];

$html = generarpresupuesto($db, $guidorder); 
 
// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'portrait');
$dompdf->loadHtml($html); 
 
// Render the HTML as PDF 
$dompdf->render(); 
 
// Output the generated PDF (1 = download and 0 = preview) 
$dompdf->stream("$invoiceid", array("Attachment" => 0));

function generarpresupuesto($db, $guidorder){
    $query = "SELECT o.id
    ,CONCAT('FR', LPAD(o.id, 5, 0)) as invoiceid
    ,DATE_FORMAT(createdAt, '%d/%m/%Y') as date
    ,CONCAT(billfirstname, ' ', billmiddlename) as user
    ,billline1 as address
    ,CONCAT(billpostalcode,', ',billcity,', ',billprovince,', ',billcountry) as city
    ,email
    ,billmobile as phone
    ,CONCAT(ROUND(subtotal, 2),'€') as subtotal
    ,CONCAT(ROUND(discount, 2),'€') as discount
    ,CONCAT(ROUND(tax, 2),'€') as tax
    ,CONCAT(ROUND(shipping, 2),'€') as shipping
    ,CONCAT(ROUND(grandTotal, 2),'€') as grandtotal
    ,guidorder
    FROM `order` o
    WHERE isdeleted = 0 AND guidorder = ?";
    $res=$db->prepare($query, array($guidorder));

    $row = mysqli_fetch_array($res);
    $invoiceid = $row['invoiceid'];
    $date = $row['date'];
    $user = $row['user'];
    $address = $row['address'];
    $city = $row['city'];
    $email = $row['email'];
    $phone = $row['phone'];
    $subtotal = $row['subtotal'];
    $discount = $row['discount'];
    $tax = $row['tax'];
    $shipping = $row['shipping'];
    $grandtotal = $row['grandtotal'];

    $path = "assets/images/logo-2.png";
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $s = '<!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Prespupuesto '.$invoiceid.'</title>
        
        <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 12px;
            line-height: 24px;
            font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
            color: #555;
        }
        
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        
        <!--.invoice-box table tr td:nth-child(2) {
            text-align: right;
        }-->
        
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.top table td.title {
            font-size: 20px;
            line-height: 45px;
            color: #333;
        }
        
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        
        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
        }
        
        .rtl table {
            text-align: right;
        }
        
        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
        .logo{
            color: red;
            font-size: 90px;
            margin: 15px 0px;
        
        }
        .logo span{
            color: black;
        }
        </style>
    </head>
    
    <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                <a href="index"><img src="'.$logo.'" alt="Hempleaf Logo"></a>
                                </td>
                                
                                <td style="text-align: right;">
                                Factura #'.$invoiceid.'<br>
                                Fecha: '.$date.'
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    Hempleaf S.L.<br>
                                    B-02910669<br>
                                    C/ Chillida, 4, Planta 1, Oficina 6<br>
                                    Email: info@hempleaf.es<br>
                                    Teléfono: (+34) 671 39 39 24
                                </td>
                                
                                <td style="text-align: right;">
                                '.$user.'<br>
                                '.$address.'<br>
                                '.$city.'<br>
                                '.$email.'<br>
                                '.$phone.'
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td>#</td>
                    <td>SKU</td>
                    <td>Descripcion</td>
                    <td>Precio Unitario</td>
                    <td>Descuento</td>
                    <td>Cantidad</td>
                    <td>Total</td>
                </tr>
                ';
                $query = "SELECT sku
                ,oi.content as producto
                ,CONCAT(ROUND(price,2),'€') as preciounitario
                ,CONCAT(ROUND(oi.discount*100,2),'%') as descuento
                ,quantity as cantidad
                ,CONCAT(ROUND((1-oi.discount)*price*quantity, 2),'€') as subtotal
                FROM `order` o
                LEFT JOIN order_item oi ON o.id = oi.orderid
                WHERE oi.isdeleted = 0 AND o.guidorder = ?";
                $res=$db->prepare($query, array($guidorder));
                $i = 1;
                while($row = mysqli_fetch_array($res)){
                $s.='<tr class="item">
                    <td>'.$i.'</td>
                    <td>'.$row['sku'].'</td>
                    <td>'.$row['producto'].'</td>
                    <td>'.$row['preciounitario'].'</td>
                    <td>'.$row['descuento'].'</td>
                    <td>'.$row['cantidad'].'</td>
                    <td>'.$row['subtotal'].'</td>
                </tr>';
                $i++;
                }
            $s.='</table>
            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td style="width:50%"></td>
                    <td></td>
                    <td>Resumen</td>
                    <td></td>
                </tr>
                
                <tr class="detail">
                    <td></td>
                    <td></td>
                    <td><strong>Subtotal</strong></td>
                    <td style="text-align: right;">'.$subtotal.'</td>
                </tr>
                <tr class="detail">
                    <td></td>
                    <td></td>
                    <td><strong>Promoción</strong></td>
                    <td style="text-align: right;">'.$discount.'</td>
                </tr>
                <tr class="detail">
                    <td></td>
                    <td></td>
                    <td><strong>Impuestos</strong></td>
                    <td style="text-align: right;">'.$tax.'</td>
                </tr>
                <tr class="detail">
                    <td></td>
                    <td></td>
                    <td><strong>Gastos de envío</strong></td>
                    <td style="text-align: right;">'.$shipping.'</td>
                </tr>
                <tr class="detail">
                    <td></td>
                    <td></td>
                    <td><strong>Total</strong></td>
                    <td style="text-align: right;">'.$grandtotal.'</td>
                </tr>
            </table>
        </div>
    </body>
    </html>';

    return $s;
    // $ninguna = $lang == 'es' ? 'Ninguna' : 'None';
    // $pendiente = $lang == 'es' ? 'Pendiente' : 'Pending';
    // $enrevision = $lang == 'es' ? 'En revisión' : 'Under review';
    // $minutos = $lang=='es'?'minutos':'minutes';
    // $horas = $lang=='es'?'horas':'hours';
    // $dias = $lang=='es'?'dias':'days';
    // $semanas = $lang=='es'?'semanas':'weeks';
    // $meses = $lang=='es'?'meses':'months';
    // $sujeto = $lang=='es'?'Sujeto a presupuesto':'Dependent on budget';
    // $query = "SELECT p.uuidpresupuesto
    // ,CONCAT('PR',(13000000+p.idpresupuesto)) as numpresupuesto
    // ,p.direccion
    // ,p.codigopostal
    // ,p.tamano
    // ,p.peso
    // ,CASE WHEN p.observaciones IS NULL THEN '$ninguna' ELSE p.observaciones END as observaciones
    // ,CASE p.estado WHEN 0 THEN '$pendiente'
    //     WHEN 1 THEN '$enrevision' END as estado
    // ,DATE_FORMAT(p.fecharegistro,'%d/%m/%Y') as fecha
    // ,DATE_FORMAT(DATE_ADD(p.fecharegistro, INTERVAL 30 DAY),'%d/%m/%Y') as vencimiento
    // ,u.uuidusuario
    // ,u.nombre
    // ,u.apellido1
    // ,u.apellido2
    // ,u.telefono
    // ,u.email
    // ,s.nombre as servicio
    // ,s.descripcion
    // ,CASE WHEN precio IS NULL THEN '$sujeto' ELSE CONCAT(precio,' €') END as precio
    // ,CASE WHEN tiempo IS NULL THEN '$sujeto'
    //     WHEN tiempo < 60 THEN CONCAT(tiempo,' $minutos')
    //     WHEN tiempo < 1440 THEN CONCAT(TRUNCATE(tiempo/60,0),' $horas')
    //     WHEN tiempo < 10080 THEN CONCAT(TRUNCATE(tiempo/1440,0),' $dias')
    //     WHEN tiempo < 40320 THEN CONCAT(TRUNCATE(tiempo/10080,0),' $semanas')
    //     ELSE CONCAT(TRUNCATE(tiempo/40320,0),' $meses') END as tiempo
    // ,t.tiposervicio
    // ,m.municipio
    // ,pr.provincia
    // FROM presupuesto p    
    // LEFT JOIN usuario u ON p.idusuario = u.idusuario
    // LEFT JOIN (SELECT idservicio, tr.traduccion as nombre, tr.traduccion2 as descripcion, idtiposervicio, precio, tiempo, imagen, destacado, fecharegistro, uuidservicio FROM servicio s LEFT JOIN traduccion tr ON s.idtraduccion = tr.idtraduccion WHERE idioma = '$lang') as s ON p.idservicio = s.idservicio
    // LEFT JOIN (SELECT idtiposervicio, tr.traduccion as tiposervicio, uuidtiposervicio FROM tiposervicio t LEFT JOIN traduccion tr ON t.idtraduccion = tr.idtraduccion WHERE idioma = '$lang') as t ON s.idtiposervicio = t.idtiposervicio
    // LEFT JOIN municipios m ON m.idmunicipio = p.idmunicipio
    // LEFT JOIN provincias pr ON m.idprovincia = pr.idprovincia
    // WHERE p.uuidpresupuesto = ?";
    // $res=$db->prepare($query, array($uuidpresupuesto));
    // if($db->numRows($res) == 0){
    //     header("location: index");
    // }
    // $row= mysqli_fetch_array($res);
    // $html ='<!doctype html>
    // <html>
    // <head>
    //     <meta charset="utf-8">
    //     <title>Prespupuesto '.$row['numpresupuesto'].'</title>
        
    //     <style>
    //     .invoice-box {
    //         max-width: 800px;
    //         margin: auto;
    //         padding: 30px;
    //         border: 1px solid #eee;
    //         box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    //         font-size: 16px;
    //         line-height: 24px;
    //         font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
    //         color: #555;
    //     }
        
    //     .invoice-box table {
    //         width: 100%;
    //         line-height: inherit;
    //         text-align: left;
    //     }
        
    //     .invoice-box table td {
    //         padding: 5px;
    //         vertical-align: top;
    //     }
        
    //     .invoice-box table tr td:nth-child(2) {
    //         text-align: right;
    //     }
        
    //     .invoice-box table tr.top table td {
    //         padding-bottom: 20px;
    //     }
        
    //     .invoice-box table tr.top table td.title {
    //         font-size: 45px;
    //         line-height: 45px;
    //         color: #333;
    //     }
        
    //     .invoice-box table tr.information table td {
    //         padding-bottom: 40px;
    //     }
        
    //     .invoice-box table tr.heading td {
    //         background: #eee;
    //         border-bottom: 1px solid #ddd;
    //         font-weight: bold;
    //     }
        
    //     .invoice-box table tr.details td {
    //         padding-bottom: 20px;
    //     }
        
    //     .invoice-box table tr.item td{
    //         border-bottom: 1px solid #eee;
    //     }
        
    //     .invoice-box table tr.item.last td {
    //         border-bottom: none;
    //     }
        
    //     .invoice-box table tr.total td:nth-child(2) {
    //         border-top: 2px solid #eee;
    //         font-weight: bold;
    //     }
        
    //     @media only screen and (max-width: 600px) {
    //         .invoice-box table tr.top table td {
    //             width: 100%;
    //             display: block;
    //             text-align: center;
    //         }
            
    //         .invoice-box table tr.information table td {
    //             width: 100%;
    //             display: block;
    //             text-align: center;
    //         }
    //     }
        
    //     /** RTL **/
    //     .rtl {
    //         direction: rtl;
    //         font-family: Tahoma, \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
    //     }
        
    //     .rtl table {
    //         text-align: right;
    //     }
        
    //     .rtl table tr td:nth-child(2) {
    //         text-align: left;
    //     }
    //     .logo{
    //         color: red;
    //         font-size: 90px;
    //         margin: 15px 0px;
        
    //     }
    //     .logo span{
    //         color: black;
    //     }
    //     </style>
    // </head>
    
    // <body>
    //     <div class="invoice-box">
    //         <table cellpadding="0" cellspacing="0">
    //             <tr class="top">
    //                 <td colspan="2">
    //                     <table>
    //                         <tr>
    //                             <td class="title">
    //                                 <p class="logo">I<span>p</span>A</p>
    //                             </td>
                                
    //                             <td>
    //                             '.$trans['presupuestonumero'].': '.$row['numpresupuesto'].'<br>
    //                             '.$trans['fecha'].': '.$row['fecha'].'<br>
    //                             '.$trans['vencimiento'].': '.$row['vencimiento'].'
    //                             </td>
    //                         </tr>
    //                     </table>
    //                 </td>
    //             </tr>
                
    //             <tr class="information">
    //                 <td colspan="2">
    //                     <table>
    //                         <tr>
    //                             <td>
    //                                 IpA S.L.<br>
    //                                 Ctra. Almería, 86, Oficina 10<br>
    //                                 04230 Huércal de Almería
    //                             </td>
                                
    //                             <td>
    //                             '.$row['nombre'].' '.$row['apellido1'].'<br>
    //                             '.$row['email'].'<br>
    //                             '.$row['telefono'].'
    //                             </td>
    //                         </tr>
    //                     </table>
    //                 </td>
    //             </tr>
                
    //             <tr class="heading">
    //                 <td>'.$trans['tiposervicio'].'</td>
    //                 <td>'.$row['tiposervicio'].'</td>
    //             </tr>
                
    //             <tr class="details">
    //                 <td>'.$trans['servicio'].'</td>
    //                 <td>'.$row['servicio'].'</td>
    //             </tr>
                
    //             <tr class="heading">
    //                 <td>'.$trans['informaciondetallada'].'</td>
    //                 <td></td>
    //             </tr>
                
    //             <tr class="item">
    //                 <td>'.$trans['municipio'].'</td>
    //                 <td>'.$row['municipio'].'</td>
    //             </tr>
    //             <tr class="item">
    //                 <td>'.$trans['provincia'].'</td>
    //                 <td>'.$row['provincia'].'</td>
    //             </tr>
    //             <tr class="item">
    //                 <td>'.$trans['direccion'].'</td>
    //                 <td>'.$row['direccion'].'</td>
    //             </tr>
    //             <tr class="item">
    //                 <td>'.$trans['codigopostal'].'</td>
    //                 <td>'.$row['codigopostal'].'</td>
    //             </tr>
    //             <tr class="item">
    //                 <td>'.$trans['tamaño'].'</td>
    //                 <td>'.$row['tamano'].'</td>
    //             </tr>
    //             <tr class="item">
    //                 <td>'.$trans['peso'].'</td>
    //                 <td>'.$row['peso'].'</td>
    //             </tr>
    //             <tr class="item">
    //                 <td>'.$trans['estado'].'</td>
    //                 <td>'.$row['estado'].'</td>
    //             </tr>
    //             <tr class="item">
    //                 <td>'.$trans['observaciones'].'</td>
    //                 <td>'.$row['observaciones'].'</td>
    //             </tr>
            
    //         </table>
    //     </div>
    // </body>
    // </html>
    
    // ';
    // return $html;
}