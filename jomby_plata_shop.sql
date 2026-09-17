-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2026 a las 00:29:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jomby_plata_shop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:2;', 1789597287),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1789597287;', 1789597287);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 10, 9, 1, '2026-09-17 01:41:43', '2026-09-17 01:41:43'),
(2, 10, 10, 1, '2026-09-17 01:41:44', '2026-09-17 01:41:44'),
(3, 10, 18, 1, '2026-09-17 01:41:44', '2026-09-17 01:41:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Oficina', 'Artículos y suministros necesarios para las actividades de oficina.', 'categories/oficina.jpg', 'active', '2026-09-11 01:14:26', '2026-09-16 19:36:51'),
(2, 'Higiene', 'Productos para la higiene personal y el cuidado de los espacios.', 'categories/higiene.jpg', 'active', '2026-09-11 01:14:26', '2026-09-16 19:36:22'),
(3, 'Hogar', 'Productos y artículos para el hogar y las necesidades cotidianas.', 'categories/hogar.jpg', 'active', '2026-09-11 01:14:26', '2026-09-16 19:36:31'),
(4, 'Alimentos', 'Productos alimenticios para el consumo y abastecimiento de su empresa.', 'categories/alimentos.jpg', 'active', '2026-09-11 01:14:26', '2026-09-16 19:36:14'),
(5, 'Tecnología', 'Equipos y accesorios tecnológicos para facilitar sus actividades.', 'categories/tecnologia.jpg', 'active', '2026-09-11 01:14:26', '2026-09-16 19:37:06'),
(6, 'Limpieza', 'Productos y soluciones para la limpieza y mantenimiento de sus espacios.', 'categories/limpieza.jpg', 'active', '2026-09-11 01:14:26', '2026-09-16 19:36:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_09_192052_create_roles_table', 1),
(5, '2026_09_09_194142_add_role_id_to_users_table', 1),
(6, '2026_09_09_200923_create_suppliers_table', 1),
(7, '2026_09_09_203145_create_categories_table', 1),
(8, '2026_09_09_204648_create_products_table', 1),
(9, '2026_09_09_212052_add_image_to_products_table', 1),
(10, '2026_09_11_221827_create_order_items_table', 2),
(11, '2026_09_11_222857_create_orders_table', 2),
(12, '2026_09_15_173539_add_cost_price_to_order_items_table', 3),
(13, '2026_09_15_200131_create_returns_table', 4),
(14, '2026_09_16_142825_add_image_to_categories_table', 5),
(15, '2026_09_16_213406_create_cart_items_table', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` enum('cash','card','transfer') NOT NULL DEFAULT 'cash',
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `status`, `payment_method`, `subtotal`, `tax`, `total`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD-LEEPSDZT', 10, 'confirmed', 'cash', 1008.00, 0.00, 1008.00, NULL, '2026-09-14 23:15:36', '2026-09-14 23:15:36'),
(2, 'ORD-7YLTDFNI', 10, 'confirmed', 'cash', 2316.00, 0.00, 2316.00, NULL, '2026-09-14 23:16:51', '2026-09-14 23:16:51'),
(3, 'ORD-KGZMYL31', 10, 'confirmed', 'cash', 3176.64, 0.00, 3176.64, NULL, '2026-09-14 23:17:56', '2026-09-14 23:17:56'),
(4, 'ORD-XCTQFNJJ', 10, 'confirmed', 'cash', 1872.00, 0.00, 1872.00, NULL, '2026-09-16 01:36:55', '2026-09-16 01:36:55'),
(5, 'ORD-3VA0XAUM', 10, 'confirmed', 'cash', 1716.00, 0.00, 1716.00, NULL, '2026-09-17 00:41:06', '2026-09-17 00:41:06'),
(6, 'ORD-ORAS9J5R', 10, 'confirmed', 'cash', 918.00, 0.00, 918.00, NULL, '2026-09-17 00:46:12', '2026-09-17 00:46:12'),
(7, 'ORD-MDMBTIFB', 13, 'confirmed', 'cash', 1820.00, 0.00, 1820.00, NULL, '2026-09-17 02:12:44', '2026-09-17 02:12:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` decimal(12,2) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `cost_price`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 180.00, 234.00, 234.00, '2026-09-14 23:15:36', '2026-09-15 21:45:59'),
(2, 1, 4, 1, 275.00, 358.00, 358.00, '2026-09-14 23:15:36', '2026-09-15 21:45:59'),
(3, 1, 5, 1, 320.00, 416.00, 416.00, '2026-09-14 23:15:36', '2026-09-15 21:45:59'),
(4, 2, 6, 2, 195.00, 254.00, 508.00, '2026-09-14 23:16:51', '2026-09-15 21:45:59'),
(5, 2, 7, 2, 425.00, 553.00, 1106.00, '2026-09-14 23:16:51', '2026-09-15 21:45:59'),
(6, 2, 8, 3, 180.00, 234.00, 702.00, '2026-09-14 23:16:51', '2026-09-15 21:45:59'),
(7, 3, 32, 4, 201.77, 794.16, 3176.64, '2026-09-14 23:17:56', '2026-09-15 21:45:59'),
(8, 4, 2, 8, 180.00, 234.00, 1872.00, '2026-09-16 01:36:55', '2026-09-16 01:36:55'),
(9, 5, 3, 6, 220.00, 286.00, 1716.00, '2026-09-17 00:41:06', '2026-09-17 00:41:06'),
(10, 6, 16, 3, 95.00, 124.00, 372.00, '2026-09-17 00:46:12', '2026-09-17 00:46:12'),
(11, 6, 17, 2, 210.00, 273.00, 546.00, '2026-09-17 00:46:12', '2026-09-17 00:46:12'),
(12, 7, 28, 1, 700.00, 910.00, 910.00, '2026-09-17 02:12:44', '2026-09-17 02:12:44'),
(13, 7, 10, 1, 400.00, 520.00, 520.00, '2026-09-17 02:12:44', '2026-09-17 02:12:44'),
(14, 7, 19, 1, 300.00, 390.00, 390.00, '2026-09-17 02:12:44', '2026-09-17 02:12:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cost_price` decimal(12,2) NOT NULL,
  `sale_price` decimal(12,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('pending','approved','inactive') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `supplier_id`, `category_id`, `name`, `description`, `image`, `cost_price`, `sale_price`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 6, 'Detergente líquido multiuso 1 L', 'Detergente líquido para limpieza general de superficies.', NULL, 350.00, 455.00, 35, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(2, 2, 2, 'Jabón líquido para manos 500 ml', 'Jabón líquido para higiene y lavado frecuente de manos.', NULL, 180.00, 234.00, 19, 'approved', '2026-09-11 01:14:26', '2026-09-16 01:57:00'),
(3, 2, 2, 'Papel higiénico 4 rollos', 'Paquete de papel higiénico para uso doméstico y comercial.', NULL, 220.00, 286.00, 73, 'approved', '2026-09-11 01:14:26', '2026-09-17 00:41:06'),
(4, 2, 6, 'Desinfectante para pisos 1 L', 'Desinfectante líquido para limpieza y desinfección de pisos.', NULL, 275.00, 358.00, 15, 'approved', '2026-09-11 01:14:26', '2026-09-14 23:15:36'),
(5, 4, 2, 'Toallas de papel', 'Toallas de papel absorbentes para uso en oficinas y comercios.', NULL, 320.00, 416.00, 49, 'approved', '2026-09-11 01:14:26', '2026-09-14 23:15:36'),
(6, 3, 6, 'Limpiador de cristales 500 ml', 'Limpiador para cristales, ventanas y superficies de vidrio.', NULL, 195.00, 254.00, 97, 'approved', '2026-09-11 01:14:26', '2026-09-14 23:16:51'),
(7, 5, 1, 'Resma de papel 8 ½ x 11', 'Papel blanco para impresión y uso general de oficina.', NULL, 425.00, 553.00, 77, 'approved', '2026-09-11 01:14:26', '2026-09-14 23:16:51'),
(8, 2, 1, 'Bolígrafo azul caja x12', 'Caja de bolígrafos de tinta azul para uso de oficina.', NULL, 180.00, 234.00, 36, 'approved', '2026-09-11 01:14:26', '2026-09-14 23:16:51'),
(9, 2, 5, 'Teclado USB', 'Teclado USB para computadoras de escritorio y oficina.', NULL, 650.00, 845.00, 18, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(10, 4, 5, 'Mouse óptico USB', 'Mouse óptico USB para equipos de escritorio y portátiles.', NULL, 400.00, 520.00, 60, 'approved', '2026-09-11 01:14:26', '2026-09-17 02:12:44'),
(11, 1, 6, 'Limpiador desengrasante 1 L', 'Producto para remover grasa y suciedad de diferentes superficies.', NULL, 290.00, 377.00, 17, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(12, 4, 6, 'Cloro líquido 1 galón', 'Producto para limpieza y desinfección de superficies.', NULL, 300.00, 390.00, 87, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(13, 5, 2, 'Alcohol líquido 1 L', 'Alcohol para limpieza y desinfección de superficies.', NULL, 350.00, 455.00, 95, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(14, 3, 6, 'Guantes de limpieza', 'Guantes reutilizables para labores de limpieza.', NULL, 150.00, 195.00, 65, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(15, 3, 6, 'Esponja para limpieza paquete x3', 'Paquete de esponjas para limpieza general.', NULL, 120.00, 156.00, 24, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(16, 4, 1, 'Carpeta plástica tamaño carta', 'Carpeta plástica para organización y almacenamiento de documentos.', NULL, 95.00, 124.00, 68, 'approved', '2026-09-11 01:14:26', '2026-09-17 00:46:12'),
(17, 3, 1, 'Marcadores permanentes caja x4', 'Caja de marcadores permanentes para oficina y almacén.', NULL, 210.00, 273.00, 32, 'approved', '2026-09-11 01:14:26', '2026-09-17 00:46:12'),
(18, 5, 5, 'Memoria USB 64 GB', 'Memoria USB para almacenamiento y transferencia de archivos.', NULL, 550.00, 715.00, 100, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(19, 2, 5, 'Cable USB tipo C', 'Cable USB tipo C para carga y transferencia de datos.', NULL, 300.00, 390.00, 42, 'approved', '2026-09-11 01:14:26', '2026-09-17 02:12:44'),
(20, 3, 1, 'Calculadora de escritorio', 'Calculadora electrónica para operaciones de oficina.', NULL, 275.00, 358.00, 100, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(21, 3, 6, 'Limpiador de baños 1 L', 'Limpiador especializado para baños y superficies sanitarias.', NULL, 280.00, 364.00, 66, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(22, 1, 3, 'Ambientador en aerosol 400 ml', 'Ambientador para oficinas, comercios y espacios cerrados.', NULL, 240.00, 312.00, 44, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(23, 4, 3, 'Servilletas de papel paquete x100', 'Paquete de servilletas de papel para uso comercial y doméstico.', NULL, 160.00, 208.00, 27, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(24, 3, 3, 'Bolsas para basura paquete x20', 'Bolsas resistentes para recolección de residuos.', NULL, 250.00, 325.00, 96, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(25, 4, 1, 'Archivador tamaño carta', 'Archivador para organización y almacenamiento de documentos.', NULL, 350.00, 455.00, 96, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(26, 4, 1, 'Grapadora de escritorio', 'Grapadora metálica para trabajos de oficina.', NULL, 275.00, 358.00, 23, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(27, 1, 5, 'Almohadilla para mouse', 'Almohadilla para mejorar el desplazamiento del mouse.', NULL, 180.00, 234.00, 27, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(28, 5, 5, 'Audífonos con conexión USB', 'Audífonos USB para computadora y reuniones virtuales.', NULL, 700.00, 910.00, 34, 'approved', '2026-09-11 01:14:26', '2026-09-17 02:12:44'),
(29, 1, 4, 'Café molido paquete 500 g', 'Café molido para consumo en oficinas y hogares.', NULL, 450.00, 585.00, 61, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(30, 4, 4, 'Azúcar blanca paquete 2 lb', 'Azúcar blanca para consumo y preparación de bebidas.', NULL, 120.00, 156.00, 76, 'approved', '2026-09-11 01:14:26', '2026-09-12 01:04:45'),
(31, 6, 6, 'BOWL CARE', 'Es un limpiador ácido de inodoro, urinales y superficies vítreas o porcelana.', NULL, 109.08, 546.00, 12, 'pending', '2026-09-14 17:15:03', '2026-09-14 17:15:03'),
(32, 6, 6, 'ALGA LESS CARE', 'Es un efectivo algicida, bactericida y fungicida, efectivo donde se requiera la desinfección o el control de algas y hongos.', NULL, 201.77, 794.16, 20, 'approved', '2026-09-14 17:18:27', '2026-09-17 00:33:02'),
(33, 6, 6, 'L. BOOSTER CARE', 'Es un reforzador alcalino para los procesos de lavado de tejidos. Está compuesto por alcalinos fuertes, secuestrantes y humectantes, que mantienen el sucio en suspensión, evitando la redeposición.', NULL, 166.20, 332.40, 28, 'pending', '2026-09-14 17:29:31', '2026-09-14 18:04:41'),
(34, 6, 5, '4G ROUTER NAM, NAM POWER SUPPLY', 'Rúter tecnología', NULL, 5000.00, 8000.00, 10, 'pending', '2026-09-17 02:19:58', '2026-09-17 02:19:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `returns`
--

CREATE TABLE `returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `returns`
--

INSERT INTO `returns` (`id`, `order_id`, `user_id`, `product_id`, `quantity`, `reason`, `status`, `processed_at`, `created_at`, `updated_at`) VALUES
(1, 3, 10, 32, 2, 'Producto llego pinchado', 'completed', '2026-09-17 00:33:02', '2026-09-16 00:36:15', '2026-09-17 00:33:02'),
(2, 2, 10, 8, 1, 'Incompleta.', 'rejected', '2026-09-16 02:02:04', '2026-09-16 00:40:31', '2026-09-16 02:02:04'),
(3, 4, 10, 2, 2, 'producto averiado', 'completed', '2026-09-16 01:57:00', '2026-09-16 01:46:23', '2026-09-16 01:57:00'),
(4, 5, 10, 3, 1, 'Orden solo era por 5', 'approved', NULL, '2026-09-17 00:42:40', '2026-09-17 00:48:55'),
(5, 7, 13, 28, 1, 'Producto imcompleto', 'pending', NULL, '2026-09-17 02:14:12', '2026-09-17 02:14:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '2026-09-11 01:14:25', '2026-09-11 01:14:25'),
(2, 'Proveedor', '2026-09-11 01:14:25', '2026-09-11 01:14:25'),
(3, 'Cliente', '2026-09-11 01:14:25', '2026-09-11 01:14:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jrPQxPR7ELZbCIJVWKMmnJxVRz6QCURgrJjp8g2a', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTU9VTjRmRHYyRnZCZk85SWV0aFd2SkpBajVzQVlWZDE2enhLRk1obiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1789597515);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `business_name`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Stark, Dickinson and Rodriguez', '809-421-1741', '7088 Hand Lodge Apt. 165\nPort Adam, OK 06215-4209', 'approved', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(2, 3, 'Zboncak, Willms and White', '809-979-7748', '771 Ankunding Divide Suite 766\nRebaside, TX 60121-6802', 'approved', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(3, 4, 'Gaylord, Baumbach and Simonis', '809-756-3512', '276 Enola Light\nLake Seanton, AZ 43105-6125', 'approved', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(4, 5, 'Botsford-Cruickshank', '809-683-2221', '2145 Daphney Ports\nKieraport, AL 03534', 'approved', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(5, 6, 'Thiel and Sons', '809-811-3708', '7271 Donnelly View Apt. 364\nWest Turner, NE 02838-1673', 'approved', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(6, 9, 'Caredom', '8092178357', 'Calle 1era No.23 Holguín', 'approved', '2026-09-11 19:47:28', '2026-09-12 00:07:54'),
(7, 11, 'Mineros del Norte', '8092178358', 'Monte Cristi', 'rejected', '2026-09-11 19:54:41', '2026-09-12 00:08:52'),
(8, 12, 'Mecánicos Industriales', '8092308357', 'km 17 Autopista Duarte', 'pending', '2026-09-12 00:13:06', '2026-09-12 00:13:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Administrador', 'admin@jomby.test', '2026-09-11 01:14:25', '$2y$12$BO0zILdb27ud9wkWwMuPF.XdTx0nO41fOLRDvqTOnSBOUWICYuVsG', 'w3HSPXG7IM1p4I1uyQDYoW7Hsp3U6gGHeXPPXFaVhueCqXw04mvmJn7iz5bU', '2026-09-11 01:14:26', '2026-09-11 20:52:14'),
(2, 2, 'Amani Wintheiser IV', 'lowe.erick@example.com', '2026-09-11 01:14:26', '$2y$12$cbgb..7942KFkNP94zPKkecKNJm5S0iz5vw63evojUxJlIu97n6TO', 'PkrXfkAgO5', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(3, 2, 'Gust Treutel', 'schmidt.roderick@example.net', '2026-09-11 01:14:26', '$2y$12$cbgb..7942KFkNP94zPKkecKNJm5S0iz5vw63evojUxJlIu97n6TO', 'mKTrOAuFcw', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(4, 2, 'Jennyfer Sipes', 'deron.nienow@example.com', '2026-09-11 01:14:26', '$2y$12$cbgb..7942KFkNP94zPKkecKNJm5S0iz5vw63evojUxJlIu97n6TO', '6gur2DmJPH', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(5, 2, 'Annabell Gislason', 'ubalistreri@example.net', '2026-09-11 01:14:26', '$2y$12$cbgb..7942KFkNP94zPKkecKNJm5S0iz5vw63evojUxJlIu97n6TO', 'fCevJ4OyIG', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(6, 2, 'Olaf Johns', 'rogahn.trever@example.org', '2026-09-11 01:14:26', '$2y$12$cbgb..7942KFkNP94zPKkecKNJm5S0iz5vw63evojUxJlIu97n6TO', 'rlfleIFNnX', '2026-09-11 01:14:26', '2026-09-11 01:14:26'),
(8, 3, 'Narda Desiree', 'desireeguante@gmail.com', NULL, '$2y$12$Fpl0qn4HbBiN6Yol.CO7sepObMdtX6/Gbq9oVe7AOCyZAKyzzhOI.', NULL, '2026-09-11 19:37:25', '2026-09-11 19:37:25'),
(9, 2, 'Jose evangelista', 'jevangelista.caredom@gmail.com', NULL, '$2y$12$W5/VjQrl8zBleArT0bOFeOHZkjbWV5s8GVbSKDme55pdNNlDS/78i', NULL, '2026-09-11 19:47:28', '2026-09-11 19:47:28'),
(10, 3, 'Lara E guaras', 'laramarit@gmail.com', NULL, '$2y$12$nDhQFQyvD5lYzoa07oVL4eaFkE0BW.s.XKSISqv.KgpJBMPJ9QS42', NULL, '2026-09-11 19:50:54', '2026-09-11 19:50:54'),
(11, 2, 'Miguel Reinoso', 'miguelreinoso@gmail.com', NULL, '$2y$12$YOi45qEJ.iGdlTxEDj9coeBguXAFM/idRVICzFwv0H3Wo55RNRIVi', NULL, '2026-09-11 19:54:41', '2026-09-11 19:54:41'),
(12, 2, 'Jose Ramón', 'ramonr@gamil.com', NULL, '$2y$12$AOqSj8BJef3lP.rCkJRZKOi9uGmDe8e3FaPt664kgJhK.ubWxAcVG', NULL, '2026-09-12 00:13:06', '2026-09-12 00:13:06'),
(13, 3, 'Jose Plata', 'jevangelistadeplata@gmail.com', NULL, '$2y$12$zhkOrseKV5HReIy48rbDluflRGDo2l6I4n42YEkg.HG1/WrEQxcma', NULL, '2026-09-17 02:08:45', '2026-09-17 02:08:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`),
  ADD KEY `products_category_id_status_index` (`category_id`,`status`);

--
-- Indices de la tabla `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `returns_order_id_foreign` (`order_id`),
  ADD KEY `returns_user_id_foreign` (`user_id`),
  ADD KEY `returns_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_user_id_unique` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `returns`
--
ALTER TABLE `returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `returns_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
