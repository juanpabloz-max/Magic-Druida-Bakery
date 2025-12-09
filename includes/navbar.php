<nav class="site-header">
  <div class="logo">
    <a href="<?php echo url('index.php'); ?>">
      <img src="<?php echo asset('assets/img/logo.jpeg'); ?>" alt="Magic Druida Bakery" style="height:50px; vertical-align: middle; margin-right: 10px;">
      Magic Druida Bakery
    </a>
  </div>
  <div class="nav">
    <a href="<?php echo url('index.php'); ?>">Inicio</a>
    <a href="<?php echo url('products.php'); ?>">Productos</a>
    <a href="<?php echo url('cart.php'); ?>" style="position: relative;">
      Carrito
      <span id="cart-count" style="
        background: var(--accent);
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        border-radius: 999px;
        padding: 2px 8px;
        margin-left: 6px;
        display: inline-block;
        position: relative;
        top: -2px;
      ">
        <?php echo total_cart_items(); ?>
      </span>
    </a>
  </div>
</nav>
