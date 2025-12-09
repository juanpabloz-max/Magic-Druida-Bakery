<?php
// remove_from_cart.php (AJAX)
require_once __DIR__ . '/helpers.php';
start_session_once();

header('Content-Type: application/json');

// ==============================
// 1. Sanitizar ID
// ==============================
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id < 1) {
    echo json_encode(['ok' => false, 'msg' => 'ID inválido']);
    exit;
}

// ==============================
// 2. Verificar existencia de carrito
// ==============================
if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$id])) {
    echo json_encode(['ok' => false, 'msg' => 'Producto no está en el carrito']);
    exit;
}

// ==============================
// 3. Reducir o eliminar
// ==============================
if ($_SESSION['cart'][$id]['qty'] > 1) {
    $_SESSION['cart'][$id]['qty'] -= 1;
} else {
    unset($_SESSION['cart'][$id]);
}

// ==============================
// 4. Nuevo total
// ==============================
$response = [
    'ok'    => true,
    'items' => total_cart_items()
];

// ==============================
// 5. Responder JSON
// ==============================
echo json_encode($response);
