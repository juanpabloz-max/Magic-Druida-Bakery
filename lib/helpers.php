<?php
// lib/helpers.php

/**
 * Inicia sesión solo si no fue iniciada previamente
 */
function start_session_once() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Formatea un número como precio en pesos argentinos
 *
 * @param float $value
 * @return string
 */
function money_ar($value) {
    if (!is_numeric($value)) $value = 0;
    return '$ ' . number_format((float)$value, 2, ',', '.');
}

/**
 * Obtiene la base del sitio según configuración
 *
 * @return string
 */
function base_url() {
    if (defined('BASE_URL') && BASE_URL !== '') {
        return rtrim(BASE_URL, '/');
    }

    // Fallback automático (funciona en localhost y hosting)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Detecta el directorio del proyecto
    $dir = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
    $dir = $dir ? '/' . $dir : '';

    return $protocol . $host . $dir;
}

/**
 * Genera la ruta completa para archivos estáticos (CSS, imágenes, etc.)
 *
 * @param string $path
 * @return string
 */
function asset($path) {
    return base_url() . '/' . ltrim($path, '/');
}

/**
 * Genera URL absoluta dentro del sitio
 *
 * @param string $path
 * @return string
 */
function url($path) {
    return base_url() . '/' . ltrim($path, '/');
}

/**
 * Cuenta ítems totales del carrito
 *
 * @return int
 */
function total_cart_items() {
    start_session_once();
    if (!isset($_SESSION['cart'])) return 0;

    return array_sum(array_map(function($item) {
        return $item['qty'] ?? 0;
    }, $_SESSION['cart']));
}
