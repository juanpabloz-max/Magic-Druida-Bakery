<?php
// add_to_cart.php (AJAX)
require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/database.php';

header('Content-Type: application/json');

start_session_once();

// =============================
// 1. Sanitizar y validar ID
// =============================
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id < 1) {
    echo json_encode(['ok' => false, 'msg' => 'ID inválido']);
    exit;
}

// =============================
// 2. Buscar producto en BD
// =============================
$pdo = getPDO();
$stmt = $pdo->prepare('SELECT id, name, price, image FROM products WHERE id = ?');
$stmt->execute([$id]);
$prod = $stmt->fetch();

if (!$prod) {
    echo json_encode(['ok' => false, 'msg' => 'Producto no encontrado']);
    exit;
}

// =============================
// 3. Agregar al carrito
// =============================
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = [
        'id' => $prod['id'],
        'name' => $prod['name'],
        'price' => $prod['price'],
        'image' => $prod['image'],
        'qty' => 1
    ];
} else {
    $_SESSION['cart'][$id]['qty'] += 1;
}

// =============================
// 4. Total de unidades
// =============================
$totalItems = array_sum(array_column($_SESSION['cart'], 'qty'));

// =============================
// 5. Respuesta JSON
// =============================
echo json_encode(['ok' => true, 'items' => $totalItems]);
