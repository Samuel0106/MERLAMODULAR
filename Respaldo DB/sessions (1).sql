-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-04-2025 a las 14:43:36
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
-- Base de datos: `merla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0SmcxuuDaGUdFuKjzzJnQdAJ3IPZsaaV8kDzDILS', 12603, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiMjcxcFBnSlNnZFZLa1huVzVpc3I0QVhDa2FycmN2MFdtandBa2tmdSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjYwMztzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJhJDEyJElQbkJ6Z3NKV1hiM3pjNTZBM24uZmVLbE9WZTQ3SGpLVkF2UGNxNEE0ZUxhTE92ejJLb1g2IjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyYSQxMiRJUG5CemdzSldYYjN6YzU2QTNuLmZlS2xPVmU0N0hqS1ZBdlBjcTRBNGVMYUxPdnoyS29YNiI7fQ==', 1742493232),
('kZsbqQh22gXb2YyVOpN8jXeS8SWTaxFxC0Oomxe2', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiZXlkcWRkZWJGeEppT0FuNDE5N2plbEpYUzhDVnlWallhM1lPeVFjTSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcm9sZXMvNi9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJhJDEyJFU2VnhVRmw5cklvbFpCMGJzS0Q0TWVGaEU2NHA0a1dwa2x6VFVvUXg2dGoySDhiaEMvRTl5IjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyYSQxMiRVNlZ4VUZsOXJJb2xaQjBic0tENE1lRmhFNjRwNGtXcGtselRVb1F4NnRqMkg4YmhDL0U5eSI7fQ==', 1742970622),
('r7KyhHseogv21Z0v52D6L5TtgEnrcdBJy25wxlre', 12600, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoieXFZZEZOUk15OFlyaEpEVWZUWXhJcWQwb2RidjU1clI5dFF3VnV4eSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJvZHVjdG9zL2ludmVudGFyaW8vZWxpbWluYXIiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjYwMDtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJhJDEyJFU2VnhVRmw5cklvbFpCMGJzS0Q0TWVGaEU2NHA0a1dwa2x6VFVvUXg2dGoySDhiaEMvRTl5IjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyYSQxMiRVNlZ4VUZsOXJJb2xaQjBic0tENE1lRmhFNjRwNGtXcGtselRVb1F4NnRqMkg4YmhDL0U5eSI7fQ==', 1742968415);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
