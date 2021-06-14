CREATE TABLE IF NOT EXISTS `list_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `is_absen` tinyint(4) NOT NULL,
  `is_kas` tinyint(4) NOT NULL,
  `week` int(11) NOT NULL,
  `hour_work_start` time NOT NULL,
  `hour_work_end` time NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_setting` (`setting_id`, `is_absen`, `is_kas`, `week`, `hour_work_start`, `hour_work_end`) VALUES
	(1, 1, 1, 1, '07:00:00', '18:00:00');

  CREATE TABLE IF NOT EXISTS `list_kelas_kategori` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_kelas_kategori` (`kategori_id`, `kategori`) VALUES
	(1, 'Alumni'),
	(2, 'XII'),
	(3, 'XI'),
	(4, 'X');

CREATE TABLE IF NOT EXISTS `list_kelas` (
  `kelas_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  PRIMARY KEY (`kelas_id`),
  KEY `FK__list_kelas_kategori` (`kategori_id`),
  CONSTRAINT `FK__list_kelas_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `list_kelas_kategori` (`kategori_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_kelas` (`kelas_id`, `kategori_id`, `kelas`) VALUES
	(1, 1, 'Alumni'),
	(2, 2, 'XII AK 1'),
	(3, 3, 'XI AK 1'),
	(5, 4, 'X AK 1');

CREATE TABLE IF NOT EXISTS `list_divisi` (
  `divisi_id` int(11) NOT NULL AUTO_INCREMENT,
  `division_name` varchar(50) NOT NULL,
  PRIMARY KEY (`divisi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_divisi` (`divisi_id`, `division_name`) VALUES
	(1, 'Super Admin'),
	(2, 'Struktural Olpres'),
	(3, 'Struktural Cabang'),
	(4, 'Siswa');

  CREATE TABLE IF NOT EXISTS `list_code` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `code_for` varchar(50) NOT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `list_code` (`code_id`, `code`, `code_for`) VALUES
	(1, 65979, 'Absen');

  CREATE TABLE IF NOT EXISTS `list_cabang` (
  `cabang_id` int(11) NOT NULL AUTO_INCREMENT,
  `cabang` varchar(50) NOT NULL,
  PRIMARY KEY (`cabang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_cabang` (`cabang_id`, `cabang`) VALUES
	(1, 'Futsal'),
	(2, 'Basket'),
	(3, 'Voli'),
	(4, 'Badminton');

CREATE TABLE IF NOT EXISTS `list_angkatan` (
  `angkatan_id` int(11) NOT NULL AUTO_INCREMENT,
  `angkatan` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`angkatan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_angkatan` (`angkatan_id`, `angkatan`) VALUES
	(1, '2020');

CREATE TABLE IF NOT EXISTS `list_absen_status` (
  `absen_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `absen_status` varchar(20) NOT NULL,
  PRIMARY KEY (`absen_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_absen_status` (`absen_status_id`, `absen_status`) VALUES
	(1, 'Masuk'),
	(2, 'Izin'),
	(3, 'Sakit'),
	(4, 'Tidak ada keterangan');

CREATE TABLE IF NOT EXISTS `list_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_level` varchar(50) NOT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `level_title` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`),
  KEY `FK_list_role_list_divisi` (`divisi_id`),
  CONSTRAINT `FK_list_role_list_divisi` FOREIGN KEY (`divisi_id`) REFERENCES `list_divisi` (`divisi_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_role` (`role_id`, `admin_level`, `divisi_id`, `level_title`) VALUES
	(1, '100', 1, 'Administrator'),
	(2, '90', 2, 'Ketua Olpres'),
	(3, '85', 2, 'Sekretaris Olpres'),
	(4, '80', 2, 'Bendahara Olpres'),
	(5, '70', 3, 'Ketua Cabang'),
	(6, '60', 3, 'Sekretaris Cabang'),
	(7, '50', 3, 'Bendahara Cabang'),
	(8, '20', 4, 'Siswa / Anggota');

CREATE TABLE IF NOT EXISTS `list_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nama` varchar(100) NOT NULL,
  `user_gender` varchar(100) NOT NULL,
  `user_username` varchar(150) NOT NULL,
  `user_password` text NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `user_image` text DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `angkatan_id` int(11) NOT NULL,
  `cabang_id` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK__list_role` (`role_id`),
  KEY `FK_list_user_list_angkatan` (`angkatan_id`),
  KEY `cabang_id` (`cabang_id`),
  KEY `FK_list_user_list_kelas` (`kelas_id`),
  CONSTRAINT `FK__list_role` FOREIGN KEY (`role_id`) REFERENCES `list_role` (`role_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_list_user_list_angkatan` FOREIGN KEY (`angkatan_id`) REFERENCES `list_angkatan` (`angkatan_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_list_user_list_cabang` FOREIGN KEY (`cabang_id`) REFERENCES `list_cabang` (`cabang_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_list_user_list_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `list_kelas` (`kelas_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `list_user` (`user_id`, `user_nama`, `user_gender`, `user_username`, `user_password`, `user_email`, `is_active`, `user_image`, `role_id`, `kelas_id`, `angkatan_id`, `cabang_id`, `last_login`) VALUES
	(1, 'Mohammad Ricky Sanjaya', 'Laki-laki', 'sanjaya', '$2y$10$5eroXeYt6FWjkJ3u9ZPYVut24ig4xI34XRo50hIHm1ZdIyDujOQf6', 'rickysanjaya411@gmail.com', 1, 'http://localhost/CI/web_olpres/assets/img/user/Title_(1).jpg', 1, 1, 1, 2, '2020-12-03 20:11:35');

  CREATE TABLE IF NOT EXISTS `list_absen` (
  `absen_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `absen_status_id` int(11) NOT NULL,
  `absen_date` datetime NOT NULL,
  `absen_week` int(11) NOT NULL,
  `absen_note` text DEFAULT NULL,
  PRIMARY KEY (`absen_id`),
  KEY `FK__list_user` (`user_id`),
  KEY `FK_list_absen_list_absen_status` (`absen_status_id`),
  CONSTRAINT `FK__list_user` FOREIGN KEY (`user_id`) REFERENCES `list_user` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_list_absen_list_absen_status` FOREIGN KEY (`absen_status_id`) REFERENCES `list_absen_status` (`absen_status_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `list_setting`
	ADD COLUMN `is_register` TINYINT(4) NOT NULL AFTER `is_kas`;

-- Added date 19 Desember 2020
ALTER TABLE `list_code`
	ADD COLUMN `cabang_id` INT NULL DEFAULT NULL AFTER `code_for`,
	ADD CONSTRAINT `FK_list_code_list_cabang` FOREIGN KEY (`cabang_id`) REFERENCES `list_cabang` (`cabang_id`) ON UPDATE CASCADE;

-- Added date 9 Januari 2021
CREATE TABLE IF NOT EXISTS `list_kas_status` (
  `kas_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `kas_status` varchar(50) NOT NULL,
  PRIMARY KEY (`kas_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `list_kas_status` (`kas_status_id`, `kas_status`) VALUES
	(1, 'Lunas'),
	(2, 'Belum Lunas');

CREATE TABLE IF NOT EXISTS `list_kas` (
  `kas_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `week` int(11) NOT NULL,
  `price_kas` int(11) NOT NULL,
  `kas_status_id` int(11) NOT NULL,
  PRIMARY KEY (`kas_id`),
  KEY `FK_list_kas_list_user` (`user_id`),
  KEY `FK_list_kas_list_kas_status` (`kas_status_id`),
  CONSTRAINT `FK_list_kas_list_kas_status` FOREIGN KEY (`kas_status_id`) REFERENCES `list_kas_status` (`kas_status_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_list_kas_list_user` FOREIGN KEY (`user_id`) REFERENCES `list_user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;