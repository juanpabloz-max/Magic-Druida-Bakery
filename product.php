<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/lib/database.php';
require_once __DIR__ . '/lib/helpers.php';

start_session_once();

// Validar ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo "<div class='container'><p style='color:red;'>Producto no especificado.</p></div>";
    include __DIR__ . '/includes/footer.php';
    exit;
}

// Traer producto
$pdo = getPDO();
$stmt = $pdo->prepare('SELECT id, name, description, price, image FROM products WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<div class='container'><p style='color:red;'>El producto no existe.</p></div>";
    include __DIR__ . '/includes/footer.php';
    exit;
}

// Descripciones personalizadas
$descriptions = [
    'Banana Moon (el inconsciente)' =>
        'Una mezcla suave y dulce que evoca la luna y la dulzura del inconsciente. 
         Imagina sabores que te llevan a un sueño tranquilo, donde la banana caramelizada
         se encuentra con notas de almendra.',
    
    'Cocoa Root (el origen)' =>
        'El sabor profundo y ancestral del cacao que conecta con nuestras raíces.
         Galletitas con cacao puro, con un toque terroso y amargo que rememora la esencia de la tierra.',
    
    'Choco Bliss (el placer)' =>
        'Una explosión de placer que combina chocolate oscuro con notas florales,
         envolviendo tus sentidos en una experiencia natural y aterciopelada.',
];

// Descripción a mostrar
$descriptionToShow = $descriptions[$product['name']] ?? $product['description'];
?>

<div class="container" style="max-width: 900px; margin: 2rem auto; padding: 0 1rem;">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>

    <img src="<?php echo asset($product['image']); ?>"
         alt="<?php echo htmlspecialchars($product['name']); ?>"
         style="width:100%; max-height:400px; object-fit:cover; border-radius:12px; border:1px solid #ccc; margin-bottom:1rem;">

    <p style="color:#7f4f8a; font-style:italic; font-size:1.1rem; line-height:1.5;">
        <?php echo nl2br(htmlspecialchars($descriptionToShow)); ?>
    </p>

    <p class="price" style="font-weight:bold; font-size:1.3rem; margin-top:1rem;">
        <?php echo money_ar($product['price']); ?>
    </p>

    <div style="margin-top:1.5rem;">
        <button class="btn primary" data-add data-id="<?php echo $product['id']; ?>">
            Agregar al carrito
        </button>

        <a href="<?php echo url('products.php'); ?>" class="btn" style="margin-left:1rem;">
            Volver a productos
        </a>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
