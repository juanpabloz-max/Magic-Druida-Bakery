# Magic Druida Bakery  
### Tienda online de galletitas artesanales — PHP + MySQL + Vanilla JS

Proyecto web fullstack desarrollado para práctica profesional y portfolio.  
Incluye catálogo dinámico, carrito persistente, checkout, almacenamiento de órdenes y envío del total vía WhatsApp.

---

## Tecnologías utilizadas

**Frontend**  
- HTML5  
- CSS3  
- JavaScript Vanilla  
- SwiperJS (carrusel)

**Backend**  
- PHP (procedimental)  
- MySQL / MariaDB (via PDO)  
- Sesiones para carrito

**Entorno local**  
- XAMPP (Apache + MySQL)

---

## Estructura del proyecto

```
Galletitas_Proyecto/
├── assets/
│   ├── css/styles.css
│   ├── js/app.js
│   └── img/
│
├── config/
│   └── config.php
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── navbar.php
│
├── lib/
│   ├── database.php
│   ├── helpers.php
│   ├── add_to_cart.php
│   ├── remove_from_cart.php
│   └── clear_cart.php
│
├── index.php
├── products.php
├── product.php
├── cart.php
├── checkout.php
├── thankyou.php
└── database.sql
```

---

## Instalación en local (XAMPP)

1. Copiar la carpeta del proyecto dentro de:

```
C:/xampp/htdocs/Galletitas_Proyecto/
```

2. Abrir XAMPP y activar:
   - **Apache**
   - **MySQL**

3. Abrir phpMyAdmin:
```
http://localhost/phpmyadmin
```

4. Crear base de datos:
```
tienda_galletitas
```

5. Importar el archivo **database.sql** (tablas + productos de ejemplo).

6. Configurar credenciales en:
```
config/config.php
```

Ejemplo:
```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'tienda_galletitas');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', 'http://localhost/Galletitas_Proyecto');
```

7. Abrir el sitio en el navegador:
```
http://localhost/Galletitas_Proyecto/
```

---

## Funcionalidades principales

- Listado de productos desde MySQL  
- Página de detalle de producto  
- Carrito con persistencia en sesión  
- Agregar / quitar unidades en tiempo real  
- Cálculo automático de subtotal y total  
- Checkout con validaciones  
- Guardado de orden + ítems en base de datos  
- Página de agradecimiento con número de orden  
- Finalización por WhatsApp con mensaje prellenado

---

## Base de datos

El proyecto incluye:

- **products**  
- **orders**  
- **order_items**  

Para cargarla: importar `database.sql`.

---

## Seguridad aplicada

- Conexión PDO + prepared statements  
- Sanitización de entrada con `htmlspecialchars()`  
- Validación de email en checkout  
- Estructura organizada en includes/lib

---

## Mejoras futuras (roadmap)

- Panel admin (ABM de productos)  
- Autenticación de usuarios  
- Email de confirmación de compra  
- Versionado en sesiones o JWT  
- Filtrado y búsqueda en catálogo  
- Carrito persistente en base de datos

---

## Autor

**Juan Pablo Leiva**  
Proyecto de portfolio — Desarrollo Web
