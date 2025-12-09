  </main>
  <footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?> Magic Druida Bakery — El arte de lo natural y lo sagrado.</p>
  </footer>
  <script src="<?php echo asset('assets/js/app.js'); ?>"></script>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".mySwiper", {
      loop: true,
      autoplay: { delay: 3000, disableOnInteraction: false },
      navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
      pagination: { el: ".swiper-pagination", clickable: true },
    });
  </script>
</body>
</html>
