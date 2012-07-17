-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2012 at 11:33 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `kotaksaran`
--
CREATE DATABASE `kotaksaran` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kotaksaran`;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namaKategori` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `namaKategori`) VALUES
(1, 'bagian a'),
(2, 'bagian b');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE IF NOT EXISTS `kota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namaKota` varchar(255) NOT NULL,
  `idPropinsi` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id`, `namaKota`, `idPropinsi`) VALUES
(1, 'Cirebon', 1),
(2, 'Situ Bondo', 2),
(3, 'Tegal', 3);

-- --------------------------------------------------------

--
-- Table structure for table `propinsi`
--

CREATE TABLE IF NOT EXISTS `propinsi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namaPropinsi` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `propinsi`
--

INSERT INTO `propinsi` (`id`, `namaPropinsi`) VALUES
(1, 'Jawa Barat'),
(2, 'Jawa Timur'),
(3, 'Jawa Tengah');

-- --------------------------------------------------------

--
-- Table structure for table `saran`
--

CREATE TABLE IF NOT EXISTS `saran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namaLengkap` varchar(255) NOT NULL,
  `profesi` varchar(255) DEFAULT NULL,
  `instansi` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `isiSaran` text NOT NULL,
  `idKota` int(11) NOT NULL,
  `idKategori` int(11) NOT NULL,
  `saranDate` datetime NOT NULL,
  `published` tinyint(4) NOT NULL,
  `mark` varchar(50) NOT NULL,
  `respon` text,
  `responBy` varchar(50) DEFAULT NULL,
  `responDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `saran`
--

INSERT INTO `saran` (`id`, `namaLengkap`, `profesi`, `instansi`, `alamat`, `phone`, `fax`, `email`, `perihal`, `isiSaran`, `idKota`, `idKategori`, `saranDate`, `published`, `mark`, `respon`, `responBy`, `responDate`) VALUES
(4, 'Fahmi Ardi', '', '', '', '', '', 'f4hem.net@gmail.com', 'Testing', 'Testing aja', 1, 1, '2012-06-16 14:02:56', 1, 'nosend', 'direspon lagi', 'admin', '2012-06-16 22:51:18'),
(5, 'Bana', '', '', '', '', '', 'fahmiardi@facebook.com', 'Test juga', 'tes tes', 3, 2, '2012-06-16 14:32:42', 1, 'nosend', 'rrrrrrrr', 'admin', '2012-06-16 20:29:29'),
(6, 'Fahhhhhh', '', '', '', '', '', 'ddd@hh.co', 'frttttt', 'dwwwwwwwwwwwwwww', 3, 2, '2012-06-17 12:07:12', 1, 'nosend', 'vggggggggggggg', 'admin', '2012-06-17 12:08:56'),
(7, 'masmian', '', '', '', '', '', 'masmian@google.com', 'Kritik', 'kritikan', 1, 1, '2012-06-19 00:28:53', 1, 'failedsent', 'oh iya. terima kasih', 'admin', '2012-06-19 00:29:33');

