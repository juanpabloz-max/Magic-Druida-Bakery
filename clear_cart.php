<?php
require_once __DIR__ . '/lib/helpers.php';
start_session_once();

$token = $_GET['csrf'] ?? '';
if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
    header('Location: cart.php');
    exit;
}

unset($_SESSION['cart']);
header('Location: cart.php');
exit;