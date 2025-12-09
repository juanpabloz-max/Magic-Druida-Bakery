<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/database.php';

start_session_once();
$cart = $_SESSION['cart'] ?? [];

// ==============================
// Carrito vacío
// ==============================
if (empty($cart)) {
    echo '<h1 style="margin-top:2rem; text-align:center;">Tu carrito está vacío</h1>';
    echo '<p style="text-align:center; margin:1rem 0;">Todavía no agregaste productos.</p>';
    echo '<div style="text-align:center;"><a href="' . url('products.php') . '" class="btn primary">Ver productos</a></div>';

    include __DIR__ . '/includes/footer.php';
    exit;
}

// ==============================
// Obtener datos de productos
// ==============================
$pdo = getPDO();
$ids = array_keys($cart);
$ids = array_filter($ids, fn($n) => is_numeric($n));

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==============================
// Calcular total
// ==============================
$total = 0;
?>

<h1>Carrito de compras</h1>

<table style="width:100%; border-collapse: collapse;">
  <thead>
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Subtotal</th>
      <th>Acción</th>
    </tr>
  </thead>

  <!-- 👇 Dejo el ID aquí como estaba originalmente -->
  <tbody id="cart-items">
    <?php foreach ($products as $p): 
      $qty = (int) ($cart[$p['id']]['qty'] ?? 0);
      $price = (float) $p['price'];
      $subtotal = $price * $qty;
      $total += $subtotal;
    ?>
    <tr data-id="<?php echo $p['id']; ?>">
      <td><?php echo htmlspecialchars($p['name']); ?></td>
      <td><?php echo $qty; ?></td>
      <td class="price" data-price="<?php echo $price; ?>">
        <?php echo money_ar($price); ?>
      </td>
      <td class="subtotal" data-subtotal="<?php echo $subtotal; ?>">
        <?php echo money_ar($subtotal); ?>
      </td>
      <td>
        <button class="btn btn-delete" data-id="<?php echo $p['id']; ?>">Eliminar</button>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<p><strong>Total: <span id="cart-total"><?php echo money_ar($total); ?></span></strong></p>

<a href="https://wa.me/5491151581480?text=<?php echo urlencode('Hola Magic Druida Bakery, quiero finalizar mi compra. Total: ' . money_ar($total)); ?>"
   class="btn primary finalize-whatsapp-btn"
   target="_blank">
  Finalizar compra por WhatsApp
</a>

<!-- Botones flotantes -->
<div class="floating-contact">
  <a href="https://www.instagram.com/magicdruidabakery/profilecard/?igsh=Mm5ldzdkODV6ODVy" target="_blank" class="contact-btn instagram">
    <img src="<?php echo asset('assets/img/instagram.png'); ?>" alt="Instagram">
  </a>
  <a href="https://wa.me/5491151581480" target="_blank" class="contact-btn whatsapp">
    <img src="<?php echo asset('assets/img/logowp.png'); ?>" alt="WhatsApp">
  </a>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
