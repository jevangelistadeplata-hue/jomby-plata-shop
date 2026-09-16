# Jomby Plata Shop

Sistema web de comercio electrónico desarrollado con Laravel como proyecto académico para el INFOTEP.

## Enlaces del proyecto

* 🌐 **Entrar a Jomby Plata Shop:** http://localhost:8000
* 📦 **Repositorio en GitHub:** https://github.com/jevangelistadeplata-hue/jomby-plata-shop

> El enlace de la aplicación funciona cuando el proyecto está ejecutándose en el equipo local.

---

## Descripción del proyecto

Jomby Plata Shop es una aplicación web orientada a la gestión de un comercio electrónico.

El sistema permite que los clientes consulten productos disponibles, agreguen productos al carrito y realicen compras. Los proveedores pueden registrar y administrar sus productos, mientras que el administrador puede gestionar la información general del negocio.

El sistema también incorpora un módulo de devoluciones y un módulo de contabilidad básica para facilitar el seguimiento de las operaciones realizadas.

---

## Problema o necesidad

Jomby Plata Shop busca facilitar la gestión de las operaciones básicas de un comercio electrónico, integrando en una misma aplicación la gestión de productos, proveedores, clientes, inventario, ventas, devoluciones y contabilidad básica.

De esta manera, se centraliza la información del negocio y se facilita el seguimiento de las operaciones realizadas por los diferentes usuarios del sistema.

---

## Roles del sistema

### Administrador / Contador

Tiene acceso a las principales funciones administrativas del sistema:

* Dashboard administrativo.
* Gestión de productos.
* Gestión de proveedores.
* Gestión de clientes.
* Consulta de ventas.
* Contabilidad básica.
* Gestión de devoluciones.
* Aprobación y rechazo de solicitudes de devolución.
* Completar devoluciones y actualizar el inventario.

### Proveedor

Puede:

* Acceder a su dashboard.
* Consultar sus productos.
* Registrar productos.
* Editar sus productos.

Los productos registrados por los proveedores deben pasar por el proceso correspondiente de aprobación antes de estar disponibles para la venta.

### Cliente

Puede:

* Consultar el catálogo de productos.
* Buscar productos.
* Filtrar productos por categoría.
* Agregar productos al carrito.
* Aumentar o disminuir cantidades.
* Eliminar productos del carrito.
* Finalizar compras.
* Consultar sus compras.
* Consultar el detalle de sus compras.
* Solicitar devoluciones.
* Consultar el estado de sus devoluciones.

---

## Funcionalidades principales

### Autenticación

* Registro de usuarios.
* Inicio de sesión.
* Cierre de sesión.
* Control de acceso mediante autenticación.
* Protección de rutas según el rol del usuario.

### Productos

* Catálogo de productos.
* Categorías.
* Búsqueda de productos.
* Filtro por categoría.
* Control de existencia.
* Estados de los productos.
* Aprobación de productos.

### Carrito de compras

* Agregar productos.
* Aumentar cantidades.
* Disminuir cantidades.
* Eliminar productos.
* Visualizar cantidad de productos.
* Finalizar compra.
* Persistencia del carrito asociado al usuario.

### Ventas

Al finalizar una compra, el sistema:

1. Verifica la disponibilidad del producto.
2. Verifica el stock.
3. Registra la venta.
4. Registra los detalles de la venta.
5. Guarda el precio de venta.
6. Guarda el costo del producto.
7. Descuenta las unidades vendidas del inventario.
8. Genera un número de venta.
9. Registra la compra asociada al cliente.

### Devoluciones

El sistema utiliza el siguiente flujo:

**Pendiente → Aprobada → Completada**

También permite:

**Pendiente → Rechazada**

Una devolución completada:

* Actualiza el inventario.
* Queda registrada.
* Se toma en cuenta para la contabilidad.

### Contabilidad básica

El módulo contable permite consultar:

* Ventas totales.
* Devoluciones.
* Ventas netas.
* Costo de ventas.
* Costo asociado a devoluciones.
* Utilidad bruta.
* Margen bruto.
* Detalle de ventas.
* Detalle de devoluciones.

---

## Tecnologías utilizadas

* **PHP 8.2**
* **Laravel 12**
* **MySQL / MariaDB**
* **Blade**
* **Bootstrap**
* **Bootstrap Icons**
* **JavaScript**
* **Vite**
* **Chart.js**
* **Eloquent ORM**
* **Git / GitHub**

---

## Requisitos

Para ejecutar el proyecto se requiere:

* PHP 8.2 o superior.
* Composer.
* Node.js y npm.
* MySQL o MariaDB.
* Git.
* Un entorno de servidor local como XAMPP.
* Extensiones de PHP requeridas por Laravel.

Para este proyecto se utiliza MySQL/MariaDB mediante el puerto `3307`.

---

## Base de datos

El sistema utiliza una base de datos relacional para almacenar la información de:

* Usuarios.
* Categorías.
* Productos.
* Órdenes de compra.
* Detalles de órdenes.
* Carritos de compra.
* Devoluciones.

Las operaciones de base de datos se gestionan mediante los modelos de Laravel y Eloquent ORM.

---

## Seguridad

El proyecto utiliza diferentes mecanismos proporcionados por Laravel:

* Autenticación de usuarios.
* Middleware para protección de rutas.
* Control de acceso según roles.
* Protección CSRF en formularios.
* Validación de datos.
* Control de sesiones.
* Protección contra intentos excesivos de inicio de sesión.

---

## Interfaz

La interfaz fue desarrollada utilizando Bootstrap y está diseñada para facilitar la navegación de los diferentes tipos de usuarios.

El sistema incluye:

* Menú de navegación.
* Tablas.
* Formularios.
* Botones de acción.
* Mensajes de éxito y error.
* Indicadores de estado.
* Tarjetas informativas.
* Dashboard administrativo.
* Catálogo de productos.
* Indicador de cantidad del carrito.

---

## Instalación

### 1. Clonar el proyecto

```bash
git clone https://github.com/jevangelistadeplata-hue/jomby-plata-shop.git
```

### 2. Entrar al proyecto

```bash
cd jomby-plata-shop
```

### 3. Instalar dependencias de PHP

```bash
composer install
```

### 4. Instalar dependencias de JavaScript

```bash
npm install
```

### 5. Crear el archivo `.env`

```bash
copy .env.example .env
```

### 6. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 7. Configurar la base de datos

Editar el archivo `.env` con los datos correspondientes de la base de datos.

Ejemplo:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=jomby_plata_shop
DB_USERNAME=root
DB_PASSWORD=
```

### 8. Ejecutar las migraciones

```bash
php artisan migrate
```

### 9. Crear el enlace de almacenamiento

```bash
php artisan storage:link
```

### 10. Ejecutar Vite

```bash
npm run dev
```

### 11. Ejecutar Laravel

En otra terminal:

```bash
php artisan serve
```

La aplicación estará disponible en:

**http://localhost:8000**

---

## Estructura general

```text
app/
├── Http/
│   └── Controllers/
├── Models/
└── ...

database/
├── migrations/
└── ...

resources/
├── css/
├── js/
└── views/
    ├── admin/
    ├── cliente/
    ├── layouts/
    └── ...

routes/
└── web.php
```

---

## Proyecto académico

**Proyecto:** Jomby Plata Shop

**Institución:** INFOTEP

**Programa:** Técnico en Programación de Páginas Web

**Módulo:** Frameworks Back-End

**Tecnología principal:** Laravel

---

## Autor

**José Angel Evangelista De Plata**

Proyecto desarrollado con fines académicos para la formación técnica en desarrollo de aplicaciones web.

### GitHub

https://github.com/jevangelistadeplata-hue/jomby-plata-shop
