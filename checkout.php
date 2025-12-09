<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/database.php';
start_session_once();

// Carrito vacío → no puede finalizar compra
$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    echo '<p>Carrito vacío.</p>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

// Variables para mantener valores del formulario
$error = '';
$name = $email = $address = $city = $province = $postal = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitizar inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $province = trim($_POST['province'] ?? '');
    $postal = trim($_POST['postal'] ?? '');

    // Validaciones
    if (!$name || !$email || !$address || !$city || !$province || !$postal) {
        $error = 'Completá todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no es válido.';
    } else {

        // Calcular total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        // Guardar orden en la BD
        try {
            $pdo = getPDO();
            $pdo->beginTransaction();

            // Insertar orden
            $stmt = $pdo->prepare('
                INSERT INTO orders (customer_name, email, address, city, province, postal_code, total)
                VALUES (?,?,?,?,?,?,?)
            ');
            $stmt->execute([$name, $email, $address, $city, $province, $postal, $total]);

            $order_id = $pdo->lastInsertId();

            // Insertar items
            $stmtItem = $pdo->prepare('
                INSERT INTO order_items (order_id, product_id, qty, price)
                VALUES (?,?,?,?)
            ');

            foreach ($cart as $it) {
                $stmtItem->execute([$order_id, $it['id'], $it['qty'], $it['price']]);
            }

            $pdo->commit();

            // Vaciar carrito
            unset($_SESSION['cart']);

            // Redirigir a thankyou
            header('Location: thankyou.php?id=' . $order_id);
            exit;

        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();

            // Mensaje profesional y seguro
            $error = 'Error al procesar la orden. Por favor, intentá más tarde.';
            // Si querés, para desarrollo podés usar:
            // $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<h1>Finalizar compra</h1>

<?php if ($error): ?>
    <p style="color:#ff6b6b;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form class="form" method="post" novalidate>
    <div class="flex">
        <input class="input" name="name" placeholder="Nombre y Apellido" required 
            value="<?php echo htmlspecialchars($name); ?>">

        <input class="input" name="email" placeholder="Email" type="email" required 
            value="<?php echo htmlspecialchars($email); ?>">
    </div>

    <input class="input" name="address" placeholder="Dirección" required
        value="<?php echo htmlspecialchars($address); ?>">

    <div class="flex">
        <input class="input" name="city" placeholder="Ciudad" required
            value="<?php echo htmlspecialchars($city); ?>">

        <input class="input" name="province" placeholder="Provincia" required
            value="<?php echo htmlspecialchars($province); ?>">

        <input class="input" name="postal" placeholder="Código Postal" required
            value="<?php echo htmlspecialchars($postal); ?>">
    </div>

    <button class="btn primary" type="submit">Confirmar compra</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
