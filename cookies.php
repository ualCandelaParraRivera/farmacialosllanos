<!DOCTYPE html>
<?php include ("./controller/main.php");?>
<html class="no-js" lang="<?=$lang?>">
<head>
    <?php sectionhead($db)?>
</head>

<body>
    <?php sectiontopbar($trans);?>

    <?php sectionheader($db, 0, $trans); ?>

    <?php sectionbreadcrumb('|cookies', $trans);?>

    <div class="section section-padding">
        <div class="container">
            <div class="section-title3">
                <h2>Política de Cookies</h2>
                
                <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 30px 0; border-left: 4px solid #00B569;">
                    <h4 style="margin-top: 0;">Gestionar preferencias de cookies</h4>
                    <p>Puede cambiar sus preferencias de cookies en cualquier momento haciendo clic en el siguiente botón:</p>
                    <button onclick="revokeCookieConsent()" style="background: #00B569; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: 600;">
                        Cambiar configuración de cookies
                    </button>
                </div>

                <p><strong>¿QUÉ ES UNA COOKIE?</strong></p>
                <p>Una cookie es un fichero que se descarga en su ordenador al acceder a determinadas páginas web. Las cookies permiten a una página web, entre otras cosas, almacenar y recuperar información sobre los hábitos de navegación de un usuario o de su equipo y, dependiendo de la información que contengan y de la forma en que utilice su equipo, pueden utilizarse para reconocer al usuario.</p>
                
                <p><strong>¿Qué tipos de cookies utiliza farmacialosllanos.org?</strong></p>
                
                <h3>Clasificación según su finalidad</h3>
                
                <h4>1. Cookies Técnicas (Necesarias)</h4>
                <p>Son aquellas imprescindibles para el correcto funcionamiento del sitio web. Permiten al usuario navegar por el sitio web y usar sus funciones, como el carrito de compra o el inicio de sesión.</p>
                <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f0f0f0;">
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Cookie</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Finalidad</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">PHPSESSID</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Identificación de sesión del usuario</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Sesión</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">language</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Idioma preferido del usuario</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">1 año</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">cookie_consent</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Almacena las preferencias de cookies del usuario</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">1 año</td>
                        </tr>
                    </tbody>
                </table>

                <h4>2. Cookies Analíticas</h4>
                <p>Sirven para estudiar el comportamiento de los usuarios de forma anónima al navegar por nuestra web. Así podremos conocer los contenidos más vistos, el número de visitantes, etc. Una información que utilizaremos para mejorar la experiencia de navegación y optimizar nuestros servicios.</p>
                <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f0f0f0;">
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Cookie</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Proveedor</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Finalidad</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">_ga</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Google Analytics</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Distinguir usuarios únicos</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">2 años</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">_gid</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Google Analytics</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Distinguir usuarios únicos</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">24 horas</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">_gat</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Google Analytics</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Limitar la tasa de solicitudes</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">1 minuto</td>
                        </tr>
                    </tbody>
                </table>

                <h4>3. Cookies de Marketing y Publicidad</h4>
                <p>Se utilizan para rastrear a los visitantes en los sitios web con el fin de mostrar anuncios relevantes y personalizados. Estas cookies permiten crear perfiles basados en los hábitos de navegación.</p>
                
                <h3>Clasificación según el plazo de tiempo</h3>
                <ul>
                    <li><em>Cookies de sesión:</em> diseñadas para recabar y almacenar datos mientras el usuario accede a una página web. Se suelen emplear para almacenar información que sólo interesa conservar para la prestación del servicio solicitado por el usuario en una sola ocasión (por ejemplo, una lista de productos adquiridos).</li>
                    <li><em>Cookies persistentes:</em> Son un tipo de cookies por las que los datos siguen almacenados en el terminal y puede accederse a ellos y ser tratados durante un periodo definido. Tienen fecha de borrado. Se utilizan por ejemplo en el proceso de compra o registro para evitar tener que introducir nuestros datos constantemente.</li>
                </ul>
                
                <h3>Clasificación según quien las gestiona</h3>
                <ul>
                    <li><em>Cookies propias:</em>&nbsp;Son aquellas que se envían al dispositivo del usuario gestionadas exclusivamente por nosotros para el mejor funcionamiento del sitio.</li>
                    <li><em>Cookies de terceros:</em>&nbsp;Son aquellas que se envían al dispositivo del usuario desde un equipo o dominio que no es gestionado por nosotros sino por otra entidad, que tratará los datos obtenidos.</li>
                </ul>
                
                <p><strong>Base legal para el tratamiento</strong></p>
                <p>La base legal para el tratamiento de datos mediante cookies técnicas es el interés legítimo del prestador del servicio (artículo 6.1.f del RGPD). Para el resto de cookies, la base legal es el consentimiento del usuario (artículo 6.1.a del RGPD), que puede retirar en cualquier momento.</p>

                <p><strong>Configuración, consulta y desactivación de cookies</strong></p>
                <p>Usted puede permitir, bloquear o eliminar las cookies instaladas en su equipo mediante la configuración de las opciones del navegador instalado en su ordenador:</p>
                <ul>
                    <li><em>Chrome</em>, desde&nbsp;<a href="http://support.google.com/chrome/bin/answer.py?hl=es&amp;answer=95647" target="_blank">http://support.google.com/chrome/bin/answer.py?hl=es&amp;answer=95647</a></li>
                    <li><em>Safari</em>, desde&nbsp;<a href="http://support.apple.com/kb/ph5042" target="_blank">http://support.apple.com/kb/ph5042</a></li>
                    <li><em>Explorer</em>, desde&nbsp;<a href="http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9" target="_blank">http://windows.microsoft.com/es-es/windows7/how-to-manage-cookies-in-internet-explorer-9</a></li>
                    <li><em>Firefox</em>, desde&nbsp;<a href="http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we" target="_blank">http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we</a></li>
                </ul>
                
                <p>Todo lo relativo a las cookies de Google, tanto analíticas como publicitarias, así como su administración y configuración se puede consultar en:</p>
                <ul>
                    <li><a href="http://www.google.es/intl/es/policies/technologies/types/" target="_blank">http://www.google.es/intl/es/policies/technologies/types/</a></li>
                    <li><a href="http://www.google.es/policies/technologies/ads/" target="_blank">http://www.google.es/policies/technologies/ads/</a></li>
                    <li><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage" target="_blank">https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage</a></li>
                </ul>
                
                <p><strong>Consecuencias de desactivar las cookies</strong></p>
                <p>Si decide deshabilitar las cookies no esenciales, algunas funcionalidades del sitio web pueden verse limitadas pero podrá seguir accediendo a las funciones básicas. Si deshabilita todas las cookies incluyendo las técnicas, es posible que no pueda utilizar determinadas funciones del sitio como el carrito de compra o el inicio de sesión.</p>
                
                <p><strong>Actualización de la política de cookies</strong></p>
                <p>Las cookies de <strong><a href="https://farmacialosllanos.org/">https://farmacialosllanos.org/</a></strong>&nbsp;pueden ser actualizadas por lo que aconsejamos que revisen nuestra política de forma periódica.</p>

                <p><strong>Más información</strong></p>
                <p>Para obtener más información sobre cómo tratamos sus datos personales, puede consultar nuestra <a href="privacy">Política de Privacidad</a>.</p>

                <p style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd;"><em>Última modificación: 16 de diciembre de 2025</em></p>
            </div>
        </div>
    </div>

    <?php sectioncookies($trans);?>
    <?php sectionfooter($trans);?>

    <?php sectionjs();?>
</body>