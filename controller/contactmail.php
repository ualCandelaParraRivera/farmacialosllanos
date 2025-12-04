<?php include ("main.php");
include("phpmailer/PHPMailerAutoload.php");

function enviarEmail($email, $nombre, $asunto, $mensaje){
    include("mailcredentials.php");
    $fromAddress = $email;
    $fromName = $nombre;
    $toAddress = $contactmail;
    $toName = $contactname;
    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();                            // Set mailer to use SMTP
    $mail->Host = $hostmail;             // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                     // Enable SMTP authentication
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Username = $infomail;            // SMTP username
    $mail->Password = $infopass;            // SMTP password
    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                          // TCP port to connect to
    $mail->addReplyTo($fromAddress, $fromName);
    $mail->setFrom($fromAddress, $fromName);
    $mail->addAddress($toAddress,$toName);   // Add a recipient
    $mail->isHTML(true);  // Set email format to HTML

    $mensaje = generarMensaje($email, $nombre, $asunto, $mensaje);

    $mail->smtpConnect([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ]);
    
    $mail->Subject = $asunto;
    $mail->msgHTML($mensaje);
    return $mail->send();
}

function imageToBase64($relativepath){
    $path = "../".$relativepath;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $encodedimage = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $encodedimage;
}

function generarMensaje($email, $nombre, $asunto, $mensaje){
    if($_SERVER['HTTP_HOST'] == "hempleaf.ddns.net" || $_SERVER['HTTP_HOST'] == "localhost"){
        $webroot = $_SERVER['HTTP_HOST']."/hempleaf/";
    }else{
        $webroot = $_SERVER['HTTP_HOST']."/";
    }
    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;font-family:roboto, \'helvetica neue\', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
     <head> 
      <meta charset="UTF-8"> 
      <meta content="width=device-width, initial-scale=1" name="viewport"> 
      <meta name="x-apple-disable-message-reformatting"> 
      <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
      <meta content="telephone=no" name="format-detection"> 
      <title>Mensaje de contacto</title> 
      <!--[if (mso 16)]>
        <style type="text/css">
        a {text-decoration: none;}
        </style>
        <![endif]--> 
      <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
      <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
        <o:AllowPNG></o:AllowPNG>
        <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]--> 
      <!--[if !mso]><!-- --> 
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet"> 
      <!--<![endif]--> 
      <style type="text/css">
    #outlook a {
        padding:0;
    }
    .ExternalClass {
        width:100%;
    }
    .ExternalClass,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass font,
    .ExternalClass td,
    .ExternalClass div {
        line-height:100%;
    }
    .es-button {
        mso-style-priority:100!important;
        text-decoration:none!important;
    }
    a[x-apple-data-detectors] {
        color:inherit!important;
        text-decoration:none!important;
        font-size:inherit!important;
        font-family:inherit!important;
        font-weight:inherit!important;
        line-height:inherit!important;
    }
    .es-desk-hidden {
        display:none;
        float:left;
        overflow:hidden;
        width:0;
        max-height:0;
        line-height:0;
        mso-hide:all;
    }
    .es-button-border:hover a.es-button, .es-button-border:hover button.es-button {
        background:#3498db!important;
        border-color:#3498db!important;
    }
    .es-button-border:hover {
        border-color:#42d159 #42d159 #42d159 #42d159!important;
        background:#3498db!important;
    }
    @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1 { font-size:26px!important; text-align:center; line-height:120%!important } h2 { font-size:24px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:26px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:24px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-menu td a { font-size:13px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:13px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:13px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:11px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button, button.es-button { font-size:14px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
    </style> 
     </head> 
     <body style="width:100%;font-family:roboto, \'helvetica neue\', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"> 
      <div class="es-wrapper-color" style="background-color:#F6F6F6"> 
       <!--[if gte mso 9]>
                <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                    <v:fill type="tile" color="#f6f6f6"></v:fill>
                </v:background>
            <![endif]--> 
       <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top"> 
         <tr style="border-collapse:collapse"> 
          <td valign="top" style="padding:0;Margin:0"> 
           <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
             <tr style="border-collapse:collapse"> 
              <td align="center" style="padding:0;Margin:0"> 
               <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td style="Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;background-position:center bottom" align="left"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:560px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td align="center" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="'.$webroot.'" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2CB543;font-size:14px"><img src="'.imageToBase64("img/email/32041618330052727.png").'" alt="Hempleaf Logo" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="189" title="Hempleaf Logo"></a></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table> 
           <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
             <tr style="border-collapse:collapse"> 
              <td align="center" style="padding:0;Margin:0"> 
               <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td style="padding:0;Margin:0;padding-bottom:20px;background-position:center top" align="left"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-position:center bottom;background-color:#FFFFFF;border-radius:5px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-l" align="left" style="Margin:0;padding-bottom:15px;padding-top:20px;padding-left:20px;padding-right:20px"><h2 style="Margin:0;line-height:26px;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;font-size:22px;font-style:normal;font-weight:normal;color:#3F3D3D">Nuevo mensaje</h2></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;line-height:23px;color:#3F3D3D;font-size:15px"><strong>Nombre: </strong>'.$nombre.'<br><strong>Correo electrónico:</strong> '.$email.'</p></td> 
                         </tr>
                         <tr style="border-collapse:collapse"> 
                          <td style="Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:25px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;line-height:23px;color:#3F3D3D;font-size:15px;text-align:justify"><strong>Asunto:</strong><br>'.$asunto.'</p></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td style="Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:25px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;line-height:23px;color:#3F3D3D;font-size:15px;text-align:justify"><strong>Mensaje:</strong><br>'.$mensaje.'</p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table> 
           <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"> 
             <tr style="border-collapse:collapse"> 
              <td align="center" style="padding:0;Margin:0"> 
               <table class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td style="Margin:0;padding-top:5px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-position:center top;background-color:transparent" bgcolor="transparent" align="left"> 
                   <!--[if mso]><table style="width:560px" cellpadding="0" cellspacing="0"><tr><td style="width:270px" valign="top"><![endif]--> 
                   <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:270px"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:center top" width="100%" cellspacing="0" cellpadding="0" role="presentation"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-top:5px;padding-bottom:15px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, \'helvetica neue\', helvetica, arial, sans-serif;line-height:21px;color:#999999;font-size:14px">©&nbsp;2021 Hempleaf.</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, \'helvetica neue\', helvetica, arial, sans-serif;line-height:21px;color:#999999;font-size:14px">Todos los Derechos Reservados</p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table> 
                   <!--[if mso]></td><td style="width:20px"></td><td style="width:270px" valign="top"><![endif]--> 
                   <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right"> 
                     <tr style="border-collapse:collapse"> 
                      <td align="left" style="padding:0;Margin:0;width:270px"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:center top" width="100%" cellspacing="0" cellpadding="0" role="presentation"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="right" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0"> 
                           <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                             <tr style="border-collapse:collapse"> 
                              <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><a target="_blank" href="https://www.facebook.com/pages/category/Agriculture/Hempleaf-105464741603213/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#FFFFFF;font-size:14px"><img title="Facebook" src="'.imageToBase64('img/email/facebook-circle-black.png').'" alt="Fb" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td> 
                              <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><a target="_blank" href="https://www.instagram.com/hempleafspain/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#FFFFFF;font-size:14px"><img title="Instagram" src="'.imageToBase64('img/email/instagram-circle-black.png').'" alt="Inst" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td> 
                              <td valign="top" align="center" style="padding:0;Margin:0"><a target="_blank" href="https://www.linkedin.com/company/hempleaf/?originalSubdomain=es" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#FFFFFF;font-size:14px"><img title="Linkedin" src="'.imageToBase64('img/email/linkedin-circle-black.png').'" alt="In" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td> 
                             </tr> 
                           </table></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table> 
                   <!--[if mso]></td></tr></table><![endif]--></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
      </div>  
     </body>
    </html>';
    return $message;

}



$errors = array();
$data = array(); // array para devolver información

// validar las variables ======================================================
    // si alguna de las variables no existe, se agrega un error al array de errores
    if (empty($_POST['name'])){
        $errors['name'] = $trans['control_contactmail_error1'];
    }else{
        $name = $_POST['name'];
    }

	if (empty($_POST['email'])){
        $errors['email'] = $trans['control_contactmail_error2'];
    }else if(!emailValidation($_POST['email'])){
        $errors['email'] = $trans['control_contactmail_error3'];
    }else{
        $email = $_POST['email'];
    }

    if (empty($_POST['subject'])){
        $errors['subject'] = $trans['control_contactmail_error4'];
    }else{
        $subject = $_POST['subject'];
    }
    
    if (empty($_POST['message'])){
        $errors['message'] = $trans['control_contactmail_error5'];
    }else if(strlen($_POST['message']) < 10){
        $errors['message'] = $trans['control_contactmail_error6'];
    }else{
        $message = $_POST['message'];
    }
    
    if(empty($errors)){
        $issended = enviarEmail($email, $name, $subject, $message);
        if(!$issended){
            $errors['pass']=$trans['control_contactmail_error7']; //No se ha enviado un correo
        }
    }

    if (!empty($errors)) {
		$data['success'] = false;
        $data['errors']  = $errors;
        $data['message'] = $trans['control_contactmail_errormessage'];
	} else {
        $data['success'] = true;
        $data['errors']  = $errors;
        $data['message'] = $trans['control_contactmail_successmessage'];
        
    }

/* $email = "kikemjunior@gmail.com";
$nombre = "Enrique";
$apellidos = "Méndez";
$telefono = "658883191";
$asunto = "Test de prueba";
$mensaje = "Mensaje de prueba";

$issended = enviarEmail($email, $nombre, $apellidos, $telefono, $asunto, $mensaje);
if(!$issended){
    echo "NO ENVIADO";
}else{
    echo "ENVIADO";
} */

echo json_encode($data);

?>