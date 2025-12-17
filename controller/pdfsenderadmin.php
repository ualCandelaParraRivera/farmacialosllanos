<?php
include ("mainadmin.php");
use Dompdf\Dompdf; 

function sendAttatchment($db, $orderid, $type, $trans, $lang){
    generarPDF($db, $orderid, $type, $trans, $lang);
}

function generarPDF($db, $orderid, $type, $trans, $lang){
   
    if($type==1){
        require_once '../dompdf/autoload.inc.php'; 
    }else{
        require_once './dompdf/autoload.inc.php'; 
    }
    
    $dompdf = new Dompdf();
    $html = rellenarInfoPDF($db, $orderid, $type, $trans, $lang);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->loadHtml($html); 
    $dompdf->render(); 
    enviarPDF($db, $orderid, $type, $dompdf, $trans, $lang);
}

function rellenarInfoPDF($db, $orderid, $type, $trans, $lang) {
    if($type == 1){
        $query = "SELECT CONCAT('IN',LPAD(idinvoice,5,'0')) as id
        ,DATE_FORMAT(updatedAt, '%d/%m/%Y') as createddate 
        ,DATE_FORMAT(updatedAt , '%d/%m/%Y') as duedate
        ,discount
        ,CONCAT(billfirstName, ' ', billmiddlename, CASE WHEN billlastname IS NULL THEN '' ELSE CONCAT(' ',billlastname) END ) as fullname
        ,billline1
        ,billpostalcode
        ,billcity
        ,ROUND(subTotal,2) as subTotal
        ,ROUND(tax,2) as tax
        ,ROUND(shipping,2)  as shipping
        ,ROUND(grandTotal,2) as grandTotal
        ,email
        ,REPLACE(guidorder, '-', '') as guidorder
        ,billmobile FROM `invoice` WHERE orderid = ? AND isdeleted = 0";
    }else{
        $query = "SELECT CONCAT('OR',LPAD(id,5,'0')) as id
        ,DATE_FORMAT(updatedAt, '%d/%m/%Y') as createddate 
        ,DATE_FORMAT(DATE_ADD(updatedAt, interval 72 hour) , '%d/%m/%Y')as duedate
        ,discount
        ,CONCAT(billfirstName, ' ', billmiddlename, CASE WHEN billlastname IS NULL THEN '' ELSE CONCAT(' ',billlastname) END ) as fullname
        ,billline1
        ,billpostalcode
        ,billcity
        ,ROUND(subTotal,2) as subTotal
        ,ROUND(tax,2) as tax
        ,ROUND(shipping,2)  as shipping
        ,ROUND(grandTotal,2) as grandTotal
        ,email
        ,REPLACE(guidorder, '-', '') as guidorder
        ,billmobile FROM `order` WHERE id = ?  AND isdeleted = 0";
    } 

    $res=$db->prepare($query, array($orderid));
    
    $row = mysqli_fetch_array($res);
    $id = $row['id'];
    $createddate = $row['createddate'];
    $duedate = $row['duedate'];
    $fullname = $row['fullname'];
    $billline1 = $row['billline1'];
    $billpostalcode = $row['billpostalcode'];
    $billcity = $row['billcity'];
    $subTotal = $row['subTotal'];
    $tax = $row['tax'];
    $shipping = $row['shipping'];
    $grandTotal = $row['grandTotal'];
    $email = $row['email'];
    $billmobile = $row['billmobile'];
    $discount = $row['discount'];
    $guidorder = $row['guidorder'];

    if($type==1){
    $path = "../img/logo/logof-verde.png";
    $tipo = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo = 'data:image/' . $tipo . ';base64,' . base64_encode($data);
    }else{
        $path = "./img/logo/logof-verde.png";
        $tipo = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $tipo . ';base64,' . base64_encode($data);
    }
    
    $html ='<!doctype html>
    <html><head>
        <meta charset="utf-8">
        <title>'.$trans['pdf_budget_title'].' '.$id.'</title>
        
        <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 13px;
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
        
          .invoice-box table tr td:nth-child(5) {
            text-align: right;
        } 
        
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.top table td.title {
            font-size: 45px;
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
    </head><body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="5">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="'.$logo.'" alt="Los Llanos Logo">
                                </td>
                                <td></td>
                                <td></td>
                                <td style="text-align:right">
                                    <strong>'.($type==1?''.$trans['pdf_budget_invoice'].'':''.$trans['pdf_budget_order'].'').' Nº: '.$id.'</strong><br>
                                    '.$trans['pdf_budget_title_date'].': '.$createddate.'<br>
                                    '.$trans['pdf_budget_title_expire'].': '.$duedate.'
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr class="information">
                    <td colspan="5">
                        <table>
                            <tr>
                                <td>
                                    '.$trans['pdf_address_name'].'<br>
                                    '.$trans['pdf_address_street'].'<br>
                                    '.$trans['pdf_address_province'].'<br>
                                    '.$trans['pdf_address_postalcode'].'<br>
                                    '.$trans['pdf_email'].'
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> <strong>'.$trans['pdf_title_name'].'</strong><br>
                                '.$fullname.'<br>
                                '.$billline1.'<br>
                                '.$email.'<br>
                                '.$billmobile.'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                <td style="text-align: center;">'.($type==1?$trans['pdf_heading_info1']:$trans['pdf_heading_info1_2']).'</td>
                    <td style="text-align: center;">'.($type==1?$trans['pdf_heading_info2']:$trans['pdf_heading_info2_2']).'</td>
                    <td style="text-align: center;">'.($type==1?$trans['pdf_heading_info3']:$trans['pdf_heading_info3_2']).'</td>
                    <td>'.($type==1?$trans['pdf_heading_info4']:$trans['pdf_heading_info4_2']).'</td>
                </tr>
                
                <tr class="details">
                <td style="text-align: center;">'.$id.'</td>
                <td style="text-align: center;">'.$createddate.'</td>
                <td style="text-align: center;">'.$guidorder.'</td>
                <td style="text-align: center;">'.($type==1?$duedate:'--/--/----').'</td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                <td style="text-align: center;">'.$trans['pdf_heading_details1'].'</td>
                <td style="text-align: center;">'.$trans['pdf_heading_details2'].'</td>
                <td style="text-align: center;">'.$trans['pdf_heading_details3'].'</td>
                <td style="text-align: center;">'.$trans['pdf_heading_details4'].'</td>
                <td>'.$trans['pdf_heading_details5'].'</td>
                </tr>
                ';

                $query = "SELECT pt.title
                ,oi.price
                ,ROUND(oi.price*(1-oi.discount),2) as precioitem
                ,oi.quantity
                ,ROUND(oi.price*(1-oi.discount) * oi.quantity,2) as subtotal
                ,oi.sku   
                FROM order_item oi
                LEFT JOIN product p ON oi.productId = p.id
                LEFT JOIN product_translation pt ON p.id = pt.productId
                WHERE oi.orderId = ?  AND pt.lang = ? AND oi.isdeleted = 0";

                $res=$db->prepare($query, array($orderid, $lang));

                while($row = mysqli_fetch_array($res)){
                $productId = $row['title'];
                $quantity = $row['quantity'];
                $price = $row['price']; 
                $precioitem = $row['precioitem'];
                $amount = $row['subtotal']; 
                $sku = $row['sku']; 

                
                
               $html .= '     
                <tr class="item">
                    <td style="text-align: center;">'.$sku.'</td>
                    <td style="text-align: center;">'.$row['title'].'</td>
                    <td style="text-align: center;">'.$quantity.'</td>
                    <td style="text-align: center;">'.$precioitem.' €</td>
                    <td>'.$amount.' €</td>
                </tr>
                ';
                }
                $html.='
            </table>

            <table>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right">
                '.$trans['pdf_checkout_subtotal'].': '.$subTotal.' €<br>
                '.$trans['pdf_checkout_tax'].': '.$tax.' €<br>
                '.$trans['pdf_checkout_shipping'].': '.$shipping.' €<br>
                ';
                if($discount != 0){
                    $html.=''.$trans['pdf_checkout_discount'].': '.$discount.'€<br> ';
                }
                $html.='
                <strong>'.$trans['pdf_checkout_grandtotal'].': '.$grandTotal.' €</strong>
                </td>
             </tr>
            </table> 
            ';

            if($type == 0){
                    $html.='<table>
                    <tr>
                        <td><strong>'.$trans['pdf_checkout_payable'].': </strong><br>
                        '.$trans['pdf_checkout_bank'].': XXXX XXXX XXXX XXXX<br>
                        ESXX XXXX XXXX XXXX XXXX XXXX<br>
                        '.$trans['pdf_checkout_concept'].': '.($type==1?''.$trans['pdf_budget_invoice'].'':''.$trans['pdf_budget_order'].'').' Nº: '.$id.'<br>
                        '.$trans['pdf_checkout_beneficiary'].': FARMACIA LOS LLANOS<br>  
                    </tr>
                </table>';
                }
                $html.='
        </div>
    </body></html>
    ';
    return $html;
}

function enviarPDF($db, $orderid, $type, $dompdf, $trans, $lang){
    if($type == 1){

        $query = "SELECT email
        ,billfirstName
        ,billmiddleName
        ,CONCAT('IN',LPAD(idinvoice,5,'0')) as id 
        ,CONCAT('Factura nº IN',LPAD(idinvoice,5,'0')) as asunto
        FROM `invoice` WHERE orderid = ?";
    }else{
        $query = "SELECT email
        ,billfirstName
        ,billmiddleName
        ,CONCAT('OR',LPAD(id,5,'0')) as id 
        ,CONCAT('Pedido nº OR',LPAD(id,5,'0')) as asunto
        FROM `order` WHERE id = ?";
    }
  
    $res=$db->prepare($query, array($orderid));

    $row = mysqli_fetch_array($res);
    $email = $row['email'];
    $nombre = $row['billfirstName'];
    $apellido = $row['billmiddleName'];
    $id = $row['id'];
    $asunto = $row['asunto'];
    $mensaje = "";




    enviarEmail($email, $nombre.' '.$apellido, $asunto, $mensaje, $orderid, $db, $dompdf, $type, $id, $trans, $lang);

}

function enviarEmail($email, $nombre, $asunto, $mensaje, $orderid, $db, $dompdf, $type, $id, $trans, $lang){
    if($type==1){
        include("./phpmailer/PHPMailerAutoload.php");
        include("mailcredentials.php");
    }else{
        // include("./controller/phpmailer/PHPMailerAutoload.php");
        include("mailcredentials.php");
    };
        if($type==1){
            $file_name = "./".$id.".pdf";
        }else{
            $file_name = "../".$id.".pdf";
        }   
         
        $html_code = '<link rel="stylesheet" href="bootstrap.min.css">';   

        

	$file = $dompdf->output();
	file_put_contents($file_name, $file); 


    $fromAddress = $infomail;
    $fromName = $infoname;
    $toAddress = $email;
    $toName = $nombre;
    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->Host = $hostmail;
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Username = $infomail;
    $mail->Password = $infopass;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->addReplyTo($fromAddress, $fromName);
    $mail->setFrom($fromAddress, $fromName);
    $mail->addAddress($toAddress,$toName);
    $mail->isHTML(true);
    $mail->AddAttachment($file_name);  

    $mensaje = generarMensaje($email, $nombre, $asunto, $mensaje, $type, $lang, $trans);

    $mail->smtpConnect([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ]);
    
    $mail->Subject = $asunto;
    $mail->msgHTML($mensaje);
    
    $r =  $mail->send();
    unlink($file_name);
    return $r;
    
}


function generarMensaje($email, $nombre, $asunto, $mensaje, $type, $lang, $trans){
    if($_SERVER['HTTP_HOST'] == "farmacialosllanos.ddns.net" || $_SERVER['HTTP_HOST'] == "localhost"){
        $webroot = $_SERVER['HTTP_HOST']."/farmacialosllanos/";
    }else{
        $webroot = $_SERVER['HTTP_HOST']."/";
    }

    if($type == 0){
        $mes = $trans['email_message_paypal']; 
        
    }else{
        $mes = $trans['email_message_wiretransfer'];
    }
    return $mes;
    
}
?>