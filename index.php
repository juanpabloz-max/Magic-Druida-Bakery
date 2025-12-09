<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/lib/database.php';

// Conexión a la base de datos
$pdo = getPDO();

// Obtener productos (consulta segura y profesional)
$stmt = $pdo->query('SELECT id, name, price, image FROM products ORDER BY id ASC');
$products = $stmt->fetchAll();
?>

<div class="container">

  <!-- Carrusel Swiper -->
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="<?php echo asset('assets/img/banana.jpg'); ?>" alt="Banana Moon (el inconsciente)">
        <div class="slide-caption">Banana Moon – Dulzura y sueños</div>
      </div>

      <div class="swiper-slide">
        <img src="<?php echo asset('assets/img/cocoa.JPG'); ?>" alt="Cocoa Root (el origen)">
        <div class="slide-caption">Cocoa Root – Conexión ancestral</div>
      </div>

      <div class="swiper-slide">
        <img src="<?php echo asset('assets/img/chocob.jpeg'); ?>" alt="Choco Bliss (el placer)">
        <div class="slide-caption">Choco Bliss – Placer absoluto</div>
      </div>
    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>

  <!-- Sección Hero -->
  <section class="hero">

    <div class="hero-card hero-left">
      <h1>Galletitas naturales, deliciosas y saludables</h1>
      <p>Recetas frescas, ingredientes reales, sin conservantes. Probá nuestras variedades mágicas y exclusivas.</p>

      <img src="<?php echo asset('assets/img/piedras.jpeg'); ?>" alt="Naturaleza en estado puro">

      <a class="cta" href="<?php echo url('products.php'); ?>">Ingresá a un bosque de sabores</a>
    </div>

    <div class="hero-card hero-right">
      <img src="<?php echo asset('assets/img/banana.jpeg'); ?>" alt="Galletitas">
    </div>

  </section>

  <!-- Productos Destacados -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; margin-bottom: 1rem;">
    <h2 style="margin: 0;">Un rincón mágico y floral</h2>
    <a href="<?php echo url('products.php'); ?>" class="btn primary" style="flex: none; width: auto;">Ver todos</a>
  </div>

  <div class="grid">
    <?php foreach ($products as $p): ?>
    <article class="card">
      <div class="img">
        <img src="<?php echo asset($p['image']); ?>" 
             alt="<?php echo htmlspecialchars($p['name']); ?>" 
             style="width:100%; height:100%; object-fit:cover;">
      </div>
      <div class="body">
        <h3><?php echo htmlspecialchars($p['name']); ?></h3>
        <p class="price"><?php echo money_ar($p['price']); ?></p>

        <div class="flex">
          <a class="btn" href="<?php echo url('product.php?id=' . $p['id']); ?>">Ver</a>
          <button class="btn primary" data-add data-id="<?php echo $p['id']; ?>">Agregar</button>
        </div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>

</div>

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
