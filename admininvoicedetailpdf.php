<?php include ("./controller/mainadmin.php");

if(!isset($_GET['guidorder'])){
    redirect(404);
}

require_once 'dompdf/autoload.inc.php'; 
 
use Dompdf\Dompdf; 
 
$dompdf = new Dompdf();

$guidorder = $_GET['guidorder'];
$query = "SELECT CONCAT('FR', LPAD(o.id, 5, 0)) as invoiceid
    FROM `order` o
    WHERE isdeleted = 0 AND guidorder = ?";
    $res=$db->prepare($query, array($guidorder));
    $row = mysqli_fetch_array($res);
    $invoiceid = $row['invoiceid'];

$html = generarpresupuesto($db, $guidorder); 
 
$dompdf->setPaper('A4', 'portrait');
$dompdf->loadHtml($html); 
 
$dompdf->render(); 
 
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
                                <a href="index"><img src="'.$logo.'" alt="Los Llanos Logo"></a>
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
                                    Farmacia Los Llanos<br>
                                    B-02910669<br>
                                    C/ Potasio, 7<br>
                                    Email: info@farmacialosllanos.org<br>
                                    Teléfono: (+34) 950 33 70 53
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
   
}