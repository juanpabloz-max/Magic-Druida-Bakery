<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/database.php';

start_session_once();

// --- CONSULTA PROFESIONAL (solo columnas necesarias + prepared) ---
$pdo = getPDO();
$stmt = $pdo->prepare('SELECT id, name, description, price, image FROM products ORDER BY id ASC');
$stmt->execute();
$products = $stmt->fetchAll();

// --- Descripciones personalizadas opcionales ---
$descriptions = [
  'Banana Moon (el inconsciente)' => 'Una mezcla suave y dulce que evoca la luna y la dulzura del inconsciente. Imagina sabores que te llevan a un sueño tranquilo, donde la banana caramelizada se encuentra con notas de almendra.',
  'Cocoa Root (el origen)' => 'El sabor profundo y ancestral del cacao conecta con nuestras raíces. Galletitas con cacao puro, con un toque terroso y amargo que recuerda la fuerza de la tierra.',
  'Choco Bliss (el placer)' => 'Una experiencia aterciopelada, rica e intensa. Chocolate oscuro con notas florales, ideal para un momento de calma y disfrute absoluto.',
];
?>

<h1 style="text-align:center; margin-bottom: 2rem;">Todos los productos</h1>

<div class="container">
  <div class="grid">

    <?php foreach ($products as $p): ?>
      <article class="card">
        <div class="img">
          <img 
            src="<?php echo asset($p['image']); ?>" 
            alt="<?php echo htmlspecialchars($p['name']); ?>" 
            style="width:100%; height:100%; object-fit:cover;"
          >
        </div>

        <div class="body">
          <h3><?php echo htmlspecialchars($p['name']); ?></h3>

          <p class="description" style="color:#7f4f8a; font-style: italic; font-size: 0.9rem; margin-bottom: 0.5rem;">
            <?php
              $key = $p['name'];
              $text = $descriptions[$key] ?? $p['description'];
              echo nl2br(htmlspecialchars($text));
            ?>
          </p>

          <p class="price"><?php echo money_ar($p['price']); ?></p>

          <div class="flex">
            <a class="btn" href="<?php echo url('product.php?id=' . $p['id']); ?>">Ver</a>
            <button class="btn primary" data-add data-id="<?php echo $p['id']; ?>">Agregar</button>
          </div>
        </div>
      </article>
    <?php endforeach; ?>

  </div> <!-- cierre grid -->

  <!-- Botones flotantes de contacto -->
  <div class="floating-contact">
    <a href="https://www.instagram.com/magicdruidabakery/profilecard/?igsh=Mm5ldzdkODV6ODVy" target="_blank" class="contact-btn instagram">
      <img src="<?php echo asset('assets/img/instagram.png'); ?>" alt="Instagram">
    </a>
    <a href="https://wa.me/5491151581480" target="_blank" class="contact-btn whatsapp">
      <img src="<?php echo asset('assets/img/logowp.png'); ?>" alt="WhatsApp">
    </a>
  </div>

</div> <!-- cierre container -->

<?php include __DIR__ . '/includes/footer.php'; ?>
