document.addEventListener('DOMContentLoaded', () => {

  // ===============================
  // Utilidad: Formateo ARS
  // ===============================
  function formatMoneyAR(number) {
    return new Intl.NumberFormat('es-AR', {
      style: 'currency',
      currency: 'ARS',
      minimumFractionDigits: 2
    }).format(number);
  }


  // ===============================
  // 1. Agregar producto al carrito
  // ===============================
  document.addEventListener('click', (e) => {
    const addBtn = e.target.closest('[data-add]');
    if (!addBtn) return;

    e.preventDefault();
    const id = addBtn.dataset.id;

    fetch(`add_to_cart.php?id=${encodeURIComponent(id)}`)
      .then(r => r.json())
      .then(data => {
        if (data.ok) {
          showToast('Producto agregado al carrito');

          const cartCount = document.querySelector('#cart-count');
          if (cartCount) cartCount.textContent = data.items;
        } else {
          showToast('No se pudo agregar el producto');
        }
      })
      .catch(err => {
        console.error('Error agregando producto:', err);
        showToast('Error de red. Intentalo nuevamente.');
      });
  });


  // ===============================
  // 2. Eliminar unidades desde carrito
  // ===============================
  const cartItemsTbody = document.querySelector('#cart-items');
  const cartCountElem = document.querySelector('#cart-count');
  const cartTotalElem = document.querySelector('#cart-total');

  function actualizarContador(nuevoTotal) {
    if (cartCountElem) cartCountElem.textContent = nuevoTotal;
  }

  function actualizarTotal() {
    let total = 0;
    cartItemsTbody?.querySelectorAll('tr').forEach(row => {
      const subtotalTd = row.querySelector('td:nth-child(4)');
      total += Number(subtotalTd.dataset.subtotal) || 0;
    });
    if (cartTotalElem) cartTotalElem.textContent = formatMoneyAR(total);
  }

  if (cartItemsTbody) {
    cartItemsTbody.addEventListener('click', (e) => {
      const btn = e.target.closest('.btn-delete');
      if (!btn) return;

      if (btn.dataset.deleting === 'true') return;
      btn.dataset.deleting = 'true';

      const id = btn.dataset.id;

      if (!confirm('¿Querés eliminar una unidad de este producto?')) {
        btn.dataset.deleting = 'false';
        return;
      }

      fetch(`lib/remove_from_cart.php?id=${encodeURIComponent(id)}`)
        .then(r => r.json())
        .then(data => {
          if (data.ok) {
            const row = btn.closest('tr');
            if (!row) return;

            const qtyTd = row.querySelector('td:nth-child(2)');
            const priceTd = row.querySelector('td:nth-child(3)');
            const subtotalTd = row.querySelector('td:nth-child(4)');

            let qty = Number(qtyTd.textContent) - 1;
            if (qty > 0) {
              qtyTd.textContent = qty;
              const price = Number(priceTd.dataset.price);
              const subtotal = price * qty;
              subtotalTd.textContent = formatMoneyAR(subtotal);
              subtotalTd.dataset.subtotal = subtotal;
            } else {
              row.remove();
            }

            actualizarContador(data.items);
            actualizarTotal();
            showToast('Producto eliminado');
          }
        })
        .catch(err => {
          console.error('Error eliminando producto:', err);
          showToast('Error de red.');
        })
        .finally(() => btn.dataset.deleting = 'false');
    });
  }
});


// ===============================
// 3. Toast flotante
// ===============================
function showToast(message) {
  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.textContent = message;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => toast.remove(), 500);
  }, 2500);
}
