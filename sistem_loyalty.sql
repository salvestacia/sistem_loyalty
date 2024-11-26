/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `hadiah` (
  `id_hadiah` int(10) NOT NULL AUTO_INCREMENT,
  `nama_hadiah` varchar(100) DEFAULT NULL,
  `harga_produk_satuan` int(20) DEFAULT NULL,
  PRIMARY KEY (`id_hadiah`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `hak_akses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL,
  `role_name` varchar(50) DEFAULT NULL,
  `fitur` varchar(50) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `produk` (
  `id_produk` int(10) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga_produk_satuan` int(20) DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaksi_poin_loyalty` (
  `id_transaksi` int(10) NOT NULL AUTO_INCREMENT,
  `tgl` datetime DEFAULT current_timestamp(),
  `user` int(10) NOT NULL,
  `item` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `customer` (`user`),
  KEY `item` (`item`),
  CONSTRAINT `transaksi_poin_loyalty_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `transaksi_poin_loyalty_ibfk_2` FOREIGN KEY (`item`) REFERENCES `hadiah` (`id_hadiah`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaksi_sales` (
  `id_transaksi` int(10) NOT NULL AUTO_INCREMENT,
  `tgl` datetime DEFAULT current_timestamp(),
  `user` int(10) NOT NULL,
  `item` int(10) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `customer` (`user`),
  KEY `item` (`item`),
  CONSTRAINT `transaksi_sales_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `transaksi_sales_ibfk_2` FOREIGN KEY (`item`) REFERENCES `produk` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `poin_loyalty` int(20) DEFAULT NULL,
  `membership` varchar(50) DEFAULT NULL,
  `role` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `hadiah` (`id_hadiah`, `nama_hadiah`, `harga_produk_satuan`) VALUES
(1, 'DISKON 10%', 20);
INSERT INTO `hadiah` (`id_hadiah`, `nama_hadiah`, `harga_produk_satuan`) VALUES
(2, 'DISKON 25%', 30);
INSERT INTO `hadiah` (`id_hadiah`, `nama_hadiah`, `harga_produk_satuan`) VALUES
(3, 'Voucher Gratis Ongkir', 25);
INSERT INTO `hadiah` (`id_hadiah`, `nama_hadiah`, `harga_produk_satuan`) VALUES
(4, 'Tiket Nonton Bioskop', 50),
(5, 'Tiket ke Yogya', 100),
(6, 'DISKON 50%', 60);

INSERT INTO `hak_akses` (`id`, `role_id`, `role_name`, `fitur`, `link`) VALUES
(1, 1, 'Pelanggan', 'Profile', 'http://localhost/sistem_loyalty/profile.php');
INSERT INTO `hak_akses` (`id`, `role_id`, `role_name`, `fitur`, `link`) VALUES
(2, 1, 'Pelanggan', 'Penukaran Poin Loyalty', 'http://localhost/sistem_loyalty/tukar_poin/loyaltyShop.php');
INSERT INTO `hak_akses` (`id`, `role_id`, `role_name`, `fitur`, `link`) VALUES
(3, 2, 'Admin', 'Profile', 'http://localhost/sistem_loyalty/profile.php');
INSERT INTO `hak_akses` (`id`, `role_id`, `role_name`, `fitur`, `link`) VALUES
(4, 2, 'Admin', 'Manajemen Data User', 'http://localhost/sistem_loyalty/data_user/read.php'),
(5, 2, 'Admin', 'Halaman CRM', 'http://localhost/sistem_loyalty/crm/halaman_crm.php'),
(6, 2, 'Admin', 'Penukaran Poin Loyalty & Edit Hadiah', 'http://localhost/sistem_loyalty/tukar_poin/loyaltyShop.php'),
(7, 2, 'Admin', 'Edit Hadiah', 'http://localhost/sistem_loyalty/data_hadiah/read.php');

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_produk_satuan`) VALUES
(1, 'sabun cuci muka', 35000);
INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_produk_satuan`) VALUES
(2, 'minyak goreng', 30000);
INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_produk_satuan`) VALUES
(3, 'semangka', 50000);
INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_produk_satuan`) VALUES
(4, 'mangga', 45000),
(5, 'betadine', 20000),
(6, 'daging ayam', 50000),
(7, 'daging sapi', 80000),
(8, 'daging kambing', 250000),
(14, 'bimoli', 50000),
(15, 'sarden', 25000),
(16, 'santan', 25000);

INSERT INTO `transaksi_poin_loyalty` (`id_transaksi`, `tgl`, `user`, `item`) VALUES
(1, '2024-10-21 14:03:08', 1, 1);
INSERT INTO `transaksi_poin_loyalty` (`id_transaksi`, `tgl`, `user`, `item`) VALUES
(2, '2024-10-21 14:03:10', 1, 2);
INSERT INTO `transaksi_poin_loyalty` (`id_transaksi`, `tgl`, `user`, `item`) VALUES
(3, '2024-10-21 14:03:12', 1, 3);
INSERT INTO `transaksi_poin_loyalty` (`id_transaksi`, `tgl`, `user`, `item`) VALUES
(4, '2024-10-21 14:03:13', 1, 4),
(5, '2024-10-21 14:03:15', 1, 5),
(6, '2024-10-21 14:08:13', 3, 1),
(7, '2024-10-21 14:08:16', 3, 2),
(8, '2024-10-21 14:08:19', 3, 3),
(9, '2024-10-21 14:08:21', 3, 4),
(10, '2024-10-21 14:08:22', 3, 5),
(11, '2024-10-21 14:08:24', 3, 6),
(46, '2024-10-24 08:54:47', 1, 5),
(47, '2024-10-24 08:54:52', 1, 5),
(48, '2024-10-24 08:54:55', 1, 2),
(49, '2024-10-24 08:55:18', 3, 5),
(50, '2024-10-24 08:55:20', 3, 5),
(51, '2024-10-24 08:55:22', 3, 5),
(52, '2024-10-24 08:56:06', 2, 3),
(53, '2024-10-24 08:56:29', 5, 5),
(54, '2024-10-25 12:40:13', 1, 5),
(55, '2024-10-25 12:40:18', 1, 5),
(56, '2024-10-25 12:42:57', 16, 2);

INSERT INTO `transaksi_sales` (`id_transaksi`, `tgl`, `user`, `item`, `qty`) VALUES
(1, '2024-10-21 12:20:03', 1, 8, 5);
INSERT INTO `transaksi_sales` (`id_transaksi`, `tgl`, `user`, `item`, `qty`) VALUES
(2, '2024-10-21 12:24:21', 2, 7, 5);
INSERT INTO `transaksi_sales` (`id_transaksi`, `tgl`, `user`, `item`, `qty`) VALUES
(3, '2024-10-21 12:24:21', 3, 6, 3);
INSERT INTO `transaksi_sales` (`id_transaksi`, `tgl`, `user`, `item`, `qty`) VALUES
(4, '2024-10-21 12:24:21', 4, 3, 6),
(5, '2024-10-21 12:24:21', 5, 4, 8),
(6, '2024-10-21 12:24:21', 5, 1, 2),
(7, '2024-10-21 12:39:10', 3, 7, 20),
(8, '2024-10-21 12:41:52', 3, 8, 5),
(9, '2024-10-21 13:11:44', 1, 14, 10),
(10, '2024-10-21 13:13:01', 1, 15, 17),
(11, '2024-10-21 13:13:51', 5, 3, 15),
(12, '2024-10-21 13:17:40', 1, 16, 5),
(13, '2024-10-21 13:24:09', 6, 3, 2),
(66, '2024-10-25 12:28:15', 16, 7, 12),
(67, '2024-10-25 12:45:05', 18, 5, 30);

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `poin_loyalty`, `membership`, `role`) VALUES
(1, 'darren', '123456', 'darrenchrist2@gmail.com', 230, 'Silver', 2);
INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `poin_loyalty`, `membership`, `role`) VALUES
(2, 'rachel', '123456', 'darrenchrist2@gmail.com', 40, 'None', 2);
INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `poin_loyalty`, `membership`, `role`) VALUES
(3, 'jessi', '123456', 'darrenchrist2@gmail.com', 300, 'Gold', 1);
INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `poin_loyalty`, `membership`, `role`) VALUES
(4, 'fiony', '123456', 'darrenchrist2@gmail.com', 30, 'None', 1),
(5, 'lufty', '123456', 'abdillahlufty@gmail.com', 110, 'Bronze', 1),
(6, 'dionisius', '123456', 'darrenchrist2@gmail.com', 10, 'None', 1),
(16, 'ollali', '123456', 'darrenchrist2@gmail.com', 90, 'None', 1),
(18, 'bayu', '123456', 'darrenchrist2@gmail.com', 60, 'None', 1);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;