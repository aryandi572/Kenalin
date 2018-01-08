-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28 Nov 2017 pada 05.23
-- Versi Server: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `NAMA_DEPAN` varchar(50) NOT NULL,
  `NAMA_BELAKANG` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `JENKEL` char(1) NOT NULL,
  `TGL_LAHIR` varchar(30) NOT NULL,
  `KOTA` varchar(40) NOT NULL,
  `USERNAME` varchar(30) NOT NULL,
  `PASSWORD` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`NAMA_DEPAN`, `NAMA_BELAKANG`, `EMAIL`, `JENKEL`, `TGL_LAHIR`, `KOTA`, `USERNAME`, `PASSWORD`) VALUES
('hamba', 'sapa', 'aanfranches@gmail.com', 'L', '18-3-2001', 'Sby', 'hamba', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
('kumat', 'aja', 'mat@gmail.com', 'L', '18-2-2002', 'sby', 'kumat', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
('test', 'satu', 'aanfranches@gmail.com', 'L', '19-1-2000', 'Sby', 'test', '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_teman`
--

CREATE TABLE `akun_teman` (
  `USERNAME` varchar(30) NOT NULL,
  `TEMAN` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akun_teman`
--

INSERT INTO `akun_teman` (`USERNAME`, `TEMAN`) VALUES
('hamba', 'test'),
('test', 'hamba'),
('test', 'kumat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `ID_STATUS` int(11) NOT NULL,
  `USER_STATUS` varchar(30) DEFAULT NULL,
  `ISI_STATUS` text,
  `WAKTU_STATUS` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`ID_STATUS`, `USER_STATUS`, `ISI_STATUS`, `WAKTU_STATUS`) VALUES
(6, 'test', 'hari ini', '2017-11-27 20:55:37'),
(7, 'test', 'malam ini', '2017-11-28 00:13:33'),
(8, 'hamba', 'Hello World Dulu', '2017-11-28 00:22:10'),
(9, 'test', 'selasa', '2017-11-28 10:39:12'),
(10, 'kumat', 'kumat coment', '2017-11-28 10:55:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`USERNAME`);

--
-- Indexes for table `akun_teman`
--
ALTER TABLE `akun_teman`
  ADD PRIMARY KEY (`USERNAME`,`TEMAN`),
  ADD KEY `FK_AKUN_TEMAN2` (`TEMAN`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ID_STATUS`),
  ADD KEY `FK_AKUN_STATUS` (`USER_STATUS`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `ID_STATUS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akun_teman`
--
ALTER TABLE `akun_teman`
  ADD CONSTRAINT `FK_AKUN_TEMAN` FOREIGN KEY (`USERNAME`) REFERENCES `akun` (`USERNAME`),
  ADD CONSTRAINT `FK_AKUN_TEMAN2` FOREIGN KEY (`TEMAN`) REFERENCES `akun` (`USERNAME`);

--
-- Ketidakleluasaan untuk tabel `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `FK_AKUN_STATUS` FOREIGN KEY (`USER_STATUS`) REFERENCES `akun` (`USERNAME`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
