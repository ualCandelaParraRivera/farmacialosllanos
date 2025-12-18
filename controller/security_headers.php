<?php
/**
 * Cabeceras de Seguridad HTTP
 * 
 * Este archivo aplica cabeceras de seguridad HTTP como respaldo
 * si mod_headers no está disponible en el servidor Apache.
 * 
 * IMPORTANTE: Las cabeceras solo pueden establecerse ANTES de cualquier salida HTML
 * 
 * @version 1.0
 * @date 2025-12-18
 */

// Solo aplicar si no se han enviado cabeceras aún
if (!headers_sent()) {
    
    // Strict-Transport-Security (HSTS)
    // Fuerza HTTPS durante 1 año
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
    
    // X-Frame-Options
    // Previene clickjacking - permite iframe solo del mismo origen
    header('X-Frame-Options: SAMEORIGIN');
    
    // X-Content-Type-Options
    // Previene MIME-sniffing
    header('X-Content-Type-Options: nosniff');
    
    // X-XSS-Protection
    // Activa filtro XSS del navegador
    header('X-XSS-Protection: 1; mode=block');
    
    // Referrer-Policy
    // Controla información de referrer
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // Permissions-Policy
    // Controla características del navegador
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(self), payment=()');
    
    // Content-Security-Policy (CSP)
    // Política de seguridad de contenido
    $csp = "default-src 'self'; " .
           "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://ajax.googleapis.com https://www.paypal.com https://www.sandbox.paypal.com https://www.google.com https://www.gstatic.com https://maps.googleapis.com; " .
           "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
           "font-src 'self' https://fonts.gstatic.com data:; " .
           "img-src 'self' data: https: http:; " .
           "connect-src 'self' https://www.paypal.com https://api.sandbox.paypal.com; " .
           "frame-src 'self' https://www.paypal.com https://www.sandbox.paypal.com https://www.google.com; " .
           "object-src 'none'; " .
           "base-uri 'self'; " .
           "form-action 'self'; " .
           "frame-ancestors 'self';";
    header('Content-Security-Policy: ' . $csp);
    
    // X-Permitted-Cross-Domain-Policies
    // Controla políticas cross-domain
    header('X-Permitted-Cross-Domain-Policies: none');
    
    // Eliminar cabeceras que revelan información del servidor
    header_remove('X-Powered-By');
    header_remove('Server');
}

/**
 * Función auxiliar para verificar si las cabeceras de seguridad están activas
 * Útil para debugging
 * 
 * @return array Lista de cabeceras de seguridad configuradas
 */
function getSecurityHeaders() {
    return [
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-Content-Type-Options' => 'nosniff',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(self), payment=()',
        'Content-Security-Policy' => 'Configurada',
        'X-Permitted-Cross-Domain-Policies' => 'none'
    ];
}
?>
