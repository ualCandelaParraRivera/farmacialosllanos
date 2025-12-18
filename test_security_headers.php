<!DOCTYPE html>
<?php 
// Este archivo es solo para pruebas - ELIMINAR en producción
include ("./controller/config.php");
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Cabeceras de Seguridad - Farmacia Los Llanos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        h2 {
            color: #34495e;
            margin-top: 30px;
        }
        .header-check {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            background: #ecf0f1;
        }
        .header-check.present {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
        .header-check.missing {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .status {
            font-weight: bold;
            margin-right: 10px;
            min-width: 80px;
        }
        .present .status {
            color: #28a745;
        }
        .missing .status {
            color: #dc3545;
        }
        .header-name {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #2980b9;
            flex: 0 0 300px;
        }
        .header-value {
            font-family: 'Courier New', monospace;
            color: #555;
            flex: 1;
            overflow-wrap: break-word;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid;
        }
        .alert-info {
            background: #d1ecf1;
            border-color: #0c5460;
            color: #0c5460;
        }
        .alert-warning {
            background: #fff3cd;
            border-color: #856404;
            color: #856404;
        }
        .alert-success {
            background: #d4edda;
            border-color: #155724;
            color: #155724;
        }
        .test-section {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .score {
            font-size: 48px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            border-radius: 10px;
        }
        .score.good {
            background: #d4edda;
            color: #155724;
        }
        .score.medium {
            background: #fff3cd;
            color: #856404;
        }
        .score.bad {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔒 Test de Cabeceras de Seguridad HTTP</h1>
        
        <div class="alert alert-info">
            <strong>ℹ️ Información:</strong> Este archivo verifica que las cabeceras de seguridad HTTP estén configuradas correctamente. 
            <strong>ELIMINAR este archivo en producción.</strong>
        </div>

        <?php
        // Verificar si estamos en HTTPS
        $is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $protocol = $is_https ? 'HTTPS' : 'HTTP';
        ?>

        <div class="test-section">
            <h3>📡 Estado de Conexión: <strong><?= $protocol ?></strong></h3>
            <?php if (!$is_https): ?>
                <div class="alert alert-warning">
                    <strong>⚠️ Advertencia:</strong> No estás usando HTTPS. Las cabeceras de seguridad funcionan mejor con HTTPS activado.
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <strong>✅ Excelente:</strong> Conexión segura HTTPS detectada.
                </div>
            <?php endif; ?>
        </div>

        <h2>📋 Cabeceras de Seguridad Esperadas</h2>
        
        <?php
        $expected_headers = [
            'Strict-Transport-Security' => 'Fuerza HTTPS (HSTS)',
            'X-Frame-Options' => 'Protección contra Clickjacking',
            'X-Content-Type-Options' => 'Previene MIME-sniffing',
            'X-XSS-Protection' => 'Filtro XSS del navegador',
            'Referrer-Policy' => 'Control de información de referrer',
            'Content-Security-Policy' => 'Política de seguridad de contenido',
            'Permissions-Policy' => 'Control de permisos del navegador',
            'X-Permitted-Cross-Domain-Policies' => 'Políticas cross-domain'
        ];

        $headers_set = headers_list();
        $found_headers = [];
        
        foreach ($headers_set as $header) {
            $parts = explode(':', $header, 2);
            if (count($parts) == 2) {
                $found_headers[trim($parts[0])] = trim($parts[1]);
            }
        }

        $score = 0;
        $total = count($expected_headers);

        foreach ($expected_headers as $header_name => $description) {
            $is_present = isset($found_headers[$header_name]);
            if ($is_present) $score++;
            
            $class = $is_present ? 'present' : 'missing';
            $status = $is_present ? '✅ ACTIVA' : '❌ AUSENTE';
            $value = $is_present ? $found_headers[$header_name] : 'No configurada';
            
            echo "<div class='header-check {$class}'>";
            echo "<span class='status'>{$status}</span>";
            echo "<span class='header-name'>{$header_name}</span>";
            echo "<span class='header-value'>{$value}</span>";
            echo "</div>";
        }

        $percentage = round(($score / $total) * 100);
        $score_class = $percentage >= 80 ? 'good' : ($percentage >= 50 ? 'medium' : 'bad');
        ?>

        <div class="score <?= $score_class ?>">
            Puntuación: <?= $score ?>/<?= $total ?> (<?= $percentage ?>%)
        </div>

        <h2>🧪 Pruebas Adicionales</h2>

        <div class="test-section">
            <h3>Verificar cabeceras con herramientas online:</h3>
            <ol>
                <li><strong>SecurityHeaders.com:</strong> <a href="https://securityheaders.com/?q=<?= urlencode($_SERVER['HTTP_HOST']) ?>" target="_blank">Analizar sitio</a></li>
                <li><strong>Mozilla Observatory:</strong> <a href="https://observatory.mozilla.org/analyze/<?= $_SERVER['HTTP_HOST'] ?>" target="_blank">Analizar sitio</a></li>
                <li><strong>SSL Labs:</strong> <a href="https://www.ssllabs.com/ssltest/analyze.html?d=<?= $_SERVER['HTTP_HOST'] ?>" target="_blank">Test SSL/TLS</a></li>
            </ol>
        </div>

        <div class="test-section">
            <h3>Verificar en navegador (Chrome/Firefox):</h3>
            <ol>
                <li>Abrir <strong>DevTools</strong> (F12)</li>
                <li>Ir a pestaña <strong>Network</strong></li>
                <li>Recargar la página</li>
                <li>Hacer clic en la solicitud de esta página</li>
                <li>Ver sección <strong>Response Headers</strong></li>
            </ol>
        </div>

        <h2>📚 Información de las Cabeceras</h2>

        <div class="test-section">
            <h3>Strict-Transport-Security (HSTS)</h3>
            <p>Fuerza a los navegadores a usar solo HTTPS durante el tiempo especificado. Previene ataques de downgrade y cookie hijacking.</p>
            <code>Strict-Transport-Security: max-age=31536000; includeSubDomains; preload</code>
        </div>

        <div class="test-section">
            <h3>X-Frame-Options</h3>
            <p>Previene ataques de clickjacking controlando si el sitio puede ser mostrado en un iframe.</p>
            <code>X-Frame-Options: SAMEORIGIN</code>
        </div>

        <div class="test-section">
            <h3>X-Content-Type-Options</h3>
            <p>Previene que el navegador intente adivinar el tipo MIME de los recursos, forzándolo a respetar el Content-Type declarado.</p>
            <code>X-Content-Type-Options: nosniff</code>
        </div>

        <div class="test-section">
            <h3>X-XSS-Protection</h3>
            <p>Activa el filtro XSS integrado de navegadores antiguos (moderna protección viene de CSP).</p>
            <code>X-XSS-Protection: 1; mode=block</code>
        </div>

        <div class="test-section">
            <h3>Content-Security-Policy</h3>
            <p>Define fuentes confiables de contenido, previniendo ataques XSS y de inyección de código.</p>
            <code>Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted.com; ...</code>
        </div>

        <div class="alert alert-warning">
            <strong>⚠️ IMPORTANTE:</strong> Elimina este archivo (<code>test_security_headers.php</code>) después de verificar que todo funciona correctamente. No debe estar accesible en producción.
        </div>

        <div style="text-align: center; margin-top: 30px; color: #7f8c8d;">
            <p><strong>Farmacia Los Llanos - Test de Seguridad</strong></p>
            <p>Fecha: <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>
</body>
</html>
