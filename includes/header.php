<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../lib/helpers.php';
start_session_once();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Magic Druida Bakery</title>
  <link rel="stylesheet" href="<?php echo asset('assets/css/styles.css?v=20250815'); ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Cormorant+Garamond&display=swap" rel="stylesheet" />
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
</head>
<body>
  <?php include __DIR__ . '/navbar.php'; ?>
  <main class="container">
