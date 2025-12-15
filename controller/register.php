<?php include ("main.php");
include("phpmailer/PHPMailerAutoload.php");

function enviarEmail($email, $nombre, $asunto, $mensaje){
    include("mailcredentials.php");
    $fromAddress = $infomail;
    $fromName = "Los Llanos";
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
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;font-family:arial, \'helvetica neue\', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
     <head> 
      <meta charset="UTF-8"> 
      <meta content="width=device-width, initial-scale=1" name="viewport"> 
      <meta name="x-apple-disable-message-reformatting"> 
      <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
      <meta content="telephone=no" name="format-detection"> 
      <title>Bienvenido a Farmacia Los Llanos</title> 
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
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"> 
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
    @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1 { font-size:26px!important; text-align:center; line-height:120%!important } h2 { font-size:22px!important; text-align:center; line-height:120%!important } h3 { font-size:18px!important; text-align:center; line-height:120%!important } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:26px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:22px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:18px!important } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:12px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button, button.es-button { font-size:18px!important; display:inline-block!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
    </style> 
     </head> 
     <body style="width:100%;font-family:arial, \'helvetica neue\', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0"> 
      <div class="es-wrapper-color" style="background-color:#F6F6F6"> 
       <!--[if gte mso 9]>
                <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                    <v:fill type="tile" color="#f6f6f6"></v:fill>
                </v:background>
            <![endif]--> 
       <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top"> 
         <tr style="border-collapse:collapse"> 
          <td valign="top" style="padding:0;Margin:0"> 
           <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> 
             <tr style="border-collapse:collapse"> 
              <td class="es-adaptive" align="center" style="padding:0;Margin:0"> 
               <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="padding:10px;Margin:0"> 
                   <!--[if mso]><table style="width:580px"><tr><td style="width:280px" valign="top"><![endif]--> 
                   <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left"> 
                     <tr style="border-collapse:collapse"> 
                      <td align="left" style="padding:0;Margin:0;width:280px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-infoblock es-m-txt-c" align="left" style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px">FARMACIA LOS LLANOS</p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table> 
                   <!--[if mso]></td><td style="width:20px"></td><td style="width:280px" valign="top"><![endif]--> 
                   <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right"> 
                     <tr style="border-collapse:collapse"> 
                      <td align="left" style="padding:0;Margin:0;width:280px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td align="right" class="es-infoblock es-m-txt-c" style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px"><br></p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table> 
                   <!--[if mso]></td></tr></table><![endif]--></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table> 
           <table cellpadding="0" cellspacing="0" class="es-header" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"> 
             <tr style="border-collapse:collapse"> 
              <td align="center" style="padding:0;Margin:0"> 
               <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:560px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td align="center" style="padding:0;Margin:0;font-size:0px"><a href="'.$webroot.'" target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#C04A81;font-size:14px"><img src="'.imageToBase64('img/email/56541618311612724.png').'" alt="Logo Hempleaf" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="162" title="Logo Hempleaf"></a></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
                 <tr style="border-collapse:collapse"> 
                  <td style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;background-color:#333333" bgcolor="#333333" align="left"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td style="padding:0;Margin:0"> 
                           <table class="es-menu" width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                             <tr class="links" style="border-collapse:collapse"> 
                              <td style="Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0" width="25.00%" bgcolor="transparent" align="center"><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;display:block;color:#FFFFFF;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight:normal" href="'.$webroot.'shop">Productos</a></td> 
                              <td style="Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0" width="25.00%" bgcolor="transparent" align="center"><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;display:block;color:#FFFFFF;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight:normal" href="'.$webroot.'wholesales">Wholesales</a></td> 
                              <td style="Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0" width="25.00%" bgcolor="transparent" align="center"><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;display:block;color:#FFFFFF;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight:normal" href="'.$webroot.'aboutus">Nosotros</a></td> 
                              <td style="Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:0px;border:0" width="25.00%" bgcolor="transparent" align="center"><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;display:block;color:#FFFFFF;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-weight:normal" href="'.$webroot.'blog">Blog</a></td> 
                             </tr> 
                           </table></td> 
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
               <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px"> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="padding:0;Margin:0"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:600px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td style="padding:0;Margin:0;position:relative" align="center"><a target="_blank" href="'.$webroot.'" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#C04A81;font-size:16px"><img class="adapt-img" src="'.imageToBase64('img/email/721618313899084.png').'" alt="Welcome" title="Welcome" width="600" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td> 
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
               <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="Margin:0;padding-top:40px;padding-bottom:40px;padding-left:40px;padding-right:40px"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:520px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:20px"><h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#666666">¡Bienvenido a bordo!</h2></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" style="padding:0;Margin:0;padding-bottom:15px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#666666;font-size:16px;text-align:justify">Lo primero, muchas gracias por confiar en nosotros.&nbsp;¡Tu bandeja de entrada está a punto de ser más inspiradora! Te enviaremos información divertida&nbsp;como consejos y trucos para saborear más aún tu experiencia con nuestros productos,&nbsp;invitaciones a eventos, además de promociones y cupones exclusivos.</p></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#666666;font-size:16px;text-align:justify">Antes de nada debes&nbsp;<strong>confirmar tu cuenta</strong> para verificar que eres tú. Solo tienes que presionar el botón de abajo.</p></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="center" style="padding:0;Margin:0"><span class="es-button-border" style="border-style:solid;border-color:transparent;background:#333333;border-width:0px;display:inline-block;border-radius:35px;width:auto"><a href="'.$webroot.'validateregistration?guiduser='.$mensaje.'" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:16px;border-style:solid;border-color:#333333;border-width:15px 25px;display:inline-block;background:#333333;border-radius:35px;font-family:arial, \'helvetica neue\', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center">Confirmar correo</a></span></td> 
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
               <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FAFAFA;width:600px" cellspacing="0" cellpadding="0" bgcolor="#fafafa" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td style="padding:0;Margin:0;padding-top:40px;padding-left:40px;padding-right:40px;background-repeat:no-repeat" align="left"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:520px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0"><h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#666666">¿Qué nos hace únicos?</h2></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="padding:0;Margin:0;padding-top:40px;padding-left:40px;padding-right:40px"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:520px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px"><h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666">Conectados en todo momento</h3></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#666666;font-size:16px;text-align:justify">Somos una empresa de productora y consultora de cáñamo con el objetivo de conectar a los clientes con los productores.</p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="padding:0;Margin:0;padding-top:40px;padding-left:40px;padding-right:40px"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:520px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px"><h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666">Responsabilidad y compromiso</h3></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#666666;font-size:16px;text-align:justify">Somos innovadores, jóvenes y responsables, y tenemos un fuerte compromiso con el medio ambiente.</p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="Margin:0;padding-top:40px;padding-bottom:40px;padding-left:40px;padding-right:40px"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td valign="top" align="center" style="padding:0;Margin:0;width:520px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px"><h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:\'trebuchet ms\', \'lucida grande\', \'lucida sans unicode\', \'lucida sans\', tahoma, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666">Asesoramiento constante</h3></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:24px;color:#666666;font-size:16px;text-align:justify">Brindamos asesoramiento constante sobre todo lo referido al mundo del cáñamo. Si tienes alguna pregunta no dudes en decírnoslo.</p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table> 
           <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top"> 
             <tr style="border-collapse:collapse"> 
              <td align="center" style="padding:0;Margin:0"> 
               <table class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;border-top:1px solid #5FA77F;width:600px" cellspacing="0" cellpadding="0" align="center"> 
                 <tr style="border-collapse:collapse"> 
                  <td align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px"> 
                   <!--[if mso]><table style="width:560px" cellpadding="0"
                                cellspacing="0"><tr><td style="width:171px" valign="top"><![endif]--> 
                   <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left"> 
                     <tr style="border-collapse:collapse"> 
                      <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:171px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td align="center" style="padding:0;Margin:0;padding-bottom:15px;font-size:0px"><a target="_blank" href="'.$webroot.'" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#999999;font-size:12px"><img src="'.imageToBase64('img/email/68601618315015577.png').'" alt="Logo Hempleaf" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" title="Logo Hempleaf" width="135"></a></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:18px;color:#999999;font-size:12px;text-align:center">info<a target="_blank" href="mailto:info@farmacialosllanos.org" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#999999;font-size:12px">@farmacialosllanos.org</a></p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:18px;color:#999999;font-size:12px;text-align:center">© 2021&nbsp;Farmacialosllanos</p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table> 
                   <!--[if mso]></td><td style="width:20px"></td><td style="width:369px" valign="top"><![endif]--> 
                   <table cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                     <tr style="border-collapse:collapse"> 
                      <td align="left" style="padding:0;Margin:0;width:369px"> 
                       <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                         <tr style="border-collapse:collapse"> 
                          <td align="left" style="padding:0;Margin:0;padding-bottom:15px;font-size:0"> 
                           <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"> 
                             <tr style="border-collapse:collapse"> 
                              <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><a target="_blank" href="https://www.facebook.com/FarmaciaLosLlanos/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#999999;font-size:12px"><img title="Facebook" src="'.imageToBase64('img/email/facebook-circle-black.png').'" alt="Fb" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td> 
                              <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><a target="_blank" href="https://www.instagram.com/farmacialosllanosalmeria/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#999999;font-size:12px"><img title="Instagram" src="'.imageToBase64('img/email/instagram-circle-black.png').'" alt="Inst" width="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td> 
                              
                             </tr> 
                           </table></td> 
                         </tr> 
                         <tr style="border-collapse:collapse"> 
                          <td style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, \'helvetica neue\', helvetica, sans-serif;line-height:18px;color:#999999;font-size:12px;text-align:justify">Recibió este correo electrónico porque visitó nuestro&nbsp;sitio o nos preguntó acerca del boletín. Puede darse de baja enviando un correo a info@farmacialosllanos.org o actualizando sus preferencias de suscripción.</p></td> 
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
$data = array();

if(!isset($_POST['firstname']) || empty($_POST['firstname'])){
    $errors['firstname'] = $trans['control_register_error1'];
}else{
    $firstname = $_POST['firstname'];
}

if(!isset($_POST['middlename']) || empty($_POST['middlename'])){
    $errors['middlename'] = $trans['control_register_error2'];
}else{
    $middlename = $_POST['middlename'];
}

if(!isset($_POST['lastname']) || empty($_POST['lastname'])){
    $lastname = NULL;
}else{
    $lastname = $_POST['lastname'];
}

if(!isset($_POST['email']) || empty($_POST['email'])){
    $errors['email'] = $trans['control_register_error3'];
}else if(!emailValidation($_POST['email'])){
    $errors['email'] = $trans['control_register_error4'];
}else{
    $email = $_POST['email'];
}

if(!isset($_POST['mobile']) || empty($_POST['mobile'])){
    $errors['mobile'] = $trans['control_register_error5'];
}else if(!phoneValidation($_POST['mobile'])){
    $errors['mobile'] = $trans['control_register_error6'];
}else{
    $mobile = $_POST['mobile'];
}

if(!isset($_POST['newpass']) || empty($_POST['newpass'])){
    $errors['newpass'] = $trans['control_register_error7'];
}else{
    $newpass = $_POST['newpass'];
}

if(!isset($_POST['confirmpass']) || empty($_POST['confirmpass'])){
    $errors['confirmpass'] = $trans['control_register_error8'];
}else{
    $confirmpass = $_POST['confirmpass'];
}

if(isset($_POST['newpass']) && !empty($_POST['newpass']) && isset($_POST['confirmpass']) && !empty($_POST['confirmpass'])){
    if($newpass != $confirmpass){
        $errors['newpass'] = $trans['control_register_error9'];
        $errors['confirmpass'] = $trans['control_register_error9'];
    }
}

if(!isset($_POST['accept'])){
    $errors['accept'] = $trans['control_register_error10'];
}



if (!empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_register_errormessage'];
}else{
    $args=array($firstname,$middlename,$lastname,$mobile,$email,sha1($newpass),$firstname,$middlename,$lastname,$mobile,$firstname,$middlename,$lastname,$mobile);
    $query = "INSERT INTO `user` (`firstName`, `middleName`, `lastName`, `mobile`, `email`, `password`, `image`, `admin`, `vendor`, `registeredAt`, `lastLogin`, `isdeleted`, `isvalid`, `billfirstName`, `billmiddleName`, `billlastName`, `billmobile`, `shipfirstName`, `shipmiddleName`, `shiplastName`, `shipmobile`, `guiduser`) VALUES 
    (?, ?, ?, ?, ?, ?, 'user1.jpg', 0, 0, NOW(), NOW(), 0, 0, ?, ?, ?, ?, ?, ?, ?, ?, UUID());";
    $db->prepare($query,$args);
    $id = $db->lastID();
    $query = "SELECT guiduser FROM user WHERE id = ? AND isdeleted = 0 AND isvalid = 0";
    $res=$db->prepare($query,array($id));
    if($db->numRows($res) > 0){
        $row = mysqli_fetch_array($res);
        $guiduser = $row['guiduser'];
        $issended = enviarEmail($email, $firstname, "Bienvenido a Farmacia Los Llanos", $guiduser);
    }
    $data['success'] = true;
    $data['errors']  = $errors;
    $data['message'] = $trans['control_register_successmessage'];
    
}
echo json_encode($data);
?>