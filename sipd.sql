-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2019 at 06:24 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(15) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `password` varchar(38) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `nama`, `password`) VALUES
('Admin', 'Sunu', 'admin1234');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `NIP` varchar(18) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `TTL` varchar(30) NOT NULL,
  `alamat` varchar(80) NOT NULL,
  `email` varchar(40) NOT NULL,
  `foto` varchar(20) NOT NULL,
  `laboratorium` int(1) NOT NULL,
  `password` varchar(38) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`NIP`, `nama`, `TTL`, `alamat`, `email`, `foto`, `laboratorium`, `password`) VALUES
('199801012001020212', 'Andin Nur Khalifah, S. Si', 'Kepulauan Seribu,2018-02-07', 'Jl. Gerungsari no. 28B, kelurahan Bulusn, Kecamatan Tembalang, Magelang', 'Khallifah.Andin@mail.com', '1998010120010202.jpg', 2, '1998010120010202'),
('199801012001020311', 'Lukas Han Amurba', 'Surabaya,1988-01-10', 'Jl. Doang tapi temenan no. 20, Kalirejo', 'Alukashan@mail.com', '1998010120010203.jpg', 2, '1998010120010203'),
('199801012001020509', 'Nama Dosen, S. Kom', 'Semarang,0087-04-03', 'Jl.  mulu beli motor napa no.44, Salodang', 'Dosen_1@mail.com', '1998010120010205.jpg', 1, '1998010120010205');

-- --------------------------------------------------------

--
-- Table structure for table `karya_dosen`
--

CREATE TABLE `karya_dosen` (
  `id_i_dosen` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `id_karya` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `karya_ilmiah`
--

CREATE TABLE `karya_ilmiah` (
  `id_karya` varchar(9) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `dana` int(10) NOT NULL,
  `pendana` varchar(30) NOT NULL,
  `dokumen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` varchar(6) NOT NULL,
  `judul` varchar(30) NOT NULL,
  `jenis` varchar(4) NOT NULL,
  `tempat` varchar(80) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_dosen`
--

CREATE TABLE `kegiatan_dosen` (
  `id_k_dos` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `id_kegiatan` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium`
--

CREATE TABLE `laboratorium` (
  `id_lab` int(1) NOT NULL,
  `nama_lab` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laboratorium`
--

INSERT INTO `laboratorium` (`id_lab`, `nama_lab`) VALUES
(1, 'kimia'),
(2, 'fisika'),
(3, 'biokimia');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `kode` varchar(8) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `fakultas` varchar(25) NOT NULL,
  `jurusan` varchar(30) NOT NULL,
  `tempat` varchar(80) NOT NULL,
  `hari` varchar(9) NOT NULL,
  `jamawal` time NOT NULL,
  `jamakhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`kode`, `nama`, `fakultas`, `jurusan`, `tempat`, `hari`, `jamawal`, `jamakhir`) VALUES
('PAC23100', 'Teknologi Kimia', 'FSM', 'Kimia', 'B201', 'wednesday', '09:00:00', '10:00:00'),
('PAC32102', 'Penerapan Kimia', 'FSM', 'Kimia', 'D203', 'tuesday', '07:30:00', '08:30:00'),
('PAC33101', 'Kimia Dasar', 'FSM', 'Kimia', 'D202', 'monday', '06:00:00', '07:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mengampu`
--

CREATE TABLE `mengampu` (
  `id_ampu` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `kode` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`NIP`);

--
-- Indexes for table `karya_dosen`
--
ALTER TABLE `karya_dosen`
  ADD PRIMARY KEY (`id_i_dosen`);

--
-- Indexes for table `karya_ilmiah`
--
ALTER TABLE `karya_ilmiah`
  ADD PRIMARY KEY (`id_karya`);

--
-- Indexes for table `kegiatan_dosen`
--
ALTER TABLE `kegiatan_dosen`
  ADD PRIMARY KEY (`id_k_dos`);

--
-- Indexes for table `laboratorium`
--
ALTER TABLE `laboratorium`
  ADD PRIMARY KEY (`id_lab`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `mengampu`
--
ALTER TABLE `mengampu`
  ADD PRIMARY KEY (`id_ampu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karya_dosen`
--
ALTER TABLE `karya_dosen`
  MODIFY `id_i_dosen` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kegiatan_dosen`
--
ALTER TABLE `kegiatan_dosen`
  MODIFY `id_k_dos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mengampu`
--
ALTER TABLE `mengampu`
  MODIFY `id_ampu` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
