<?php
require_once __DIR__ . '/includes/header.php';

// Validar ID de orden
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Si el ID no es válido, mostramos un mensaje genérico
if ($id <= 0) {
    $id = null;
}
?>

<div class="container" style="max-width: 700px; margin: 2rem auto;">
    <section class="card" style="padding:18px; text-align:center;">
        <div class="body">
            <h1>¡Gracias por tu compra! 🎉</h1>

            <?php if ($id): ?>
                <p>Tu número de orden es 
                    <strong>#<?php echo htmlspecialchars($id); ?></strong>.
                </p>
            <?php else: ?>
                <p>Tu orden fue procesada correctamente.</p>
            <?php endif; ?>

            <p>Pronto recibirás un correo con todos los detalles.</p>

            <a class="btn" href="<?php echo url('products.php'); ?>">
                Seguir comprando
            </a>
        </div>
    </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
