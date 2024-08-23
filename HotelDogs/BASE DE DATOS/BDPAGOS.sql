-- --------------------------------------------------------
-- Host:                         161.132.56.56
-- Versión del servidor:         10.4.34-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para pagosdb
CREATE DATABASE IF NOT EXISTS `pagosdb` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `pagosdb`;

-- Volcando estructura para tabla pagosdb.pagos
CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `monto_total` float NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla pagosdb.pagos: ~5 rows (aproximadamente)
INSERT INTO `pagos` (`id`, `id_reserva`, `id_cliente`, `monto_total`, `fecha_pago`) VALUES
	(1, 10, 1, 300, '2024-07-04 19:06:37'),
	(2, 11, 1, 120, '2024-07-04 19:18:20'),
	(3, 12, 1, 540, '2024-07-04 19:24:49'),
	(4, 13, 1, 240, '2024-07-04 20:12:38'),
	(5, 14, 1, 90, '2024-07-04 20:39:53');

-- Volcando estructura para procedimiento pagosdb.registrarPago
DELIMITER //
CREATE PROCEDURE `registrarPago`(
    IN p_id_reserva INT,
    IN p_id_cliente INT,
    IN p_monto_total FLOAT
)
BEGIN
    INSERT INTO Pagos (id_reserva, id_cliente, monto_total)
    VALUES (p_id_reserva, p_id_cliente, p_monto_total);
END//
DELIMITER ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
