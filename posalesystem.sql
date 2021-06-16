-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2021 at 04:12 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posalesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryid` int(11) NOT NULL,
  `categoryname` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `categoryname`) VALUES
(15, 'Mobile'),
(16, 'Laptop'),
(17, 'Tablet');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoiceid` int(11) NOT NULL,
  `customername` varchar(100) NOT NULL,
  `orderdate` date NOT NULL,
  `ordersubtotal` double NOT NULL,
  `ordertax` double NOT NULL,
  `orderdiscount` double NOT NULL,
  `ordertotal` double NOT NULL,
  `orderpaid` double NOT NULL,
  `orderdue` double NOT NULL,
  `orderpaymentmethod` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoiceid`, `customername`, `orderdate`, `ordersubtotal`, `ordertax`, `orderdiscount`, `ordertotal`, `orderpaid`, `orderdue`, `orderpaymentmethod`) VALUES
(33, 'Asif', '2021-03-21', 122000, 6100, 0, 128100, 128100, 0, 'card'),
(34, 'Nabila', '2021-03-22', 236500, 11825, 0, 248325, 248325, 0, 'cash'),
(35, 'hoku', '2021-03-22', 56997, 2849.85, 0, 59846.85, 59846.85, 0, 'card'),
(36, 'Zunayed', '2021-03-25', 86999, 4349.95, 0, 91348.95, 91348.95, 0, 'card'),
(37, 'Siam', '2021-03-29', 302998, 15149.9, 0, 318147.9, 318147.9, 0, 'check');

-- --------------------------------------------------------

--
-- Table structure for table `invoicedetails`
--

CREATE TABLE `invoicedetails` (
  `invoicedetailsid` int(11) NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `productquantity` int(11) NOT NULL,
  `productprice` double NOT NULL,
  `orderdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoicedetails`
--

INSERT INTO `invoicedetails` (`invoicedetailsid`, `invoiceid`, `productid`, `productname`, `productquantity`, `productprice`, `orderdate`) VALUES
(53, 33, 13, 'Acer ES1-572', 4, 30500, '2021-03-21'),
(54, 34, 14, 'Dell XPS 15 7590', 1, 236500, '2021-03-22'),
(55, 35, 9, 'Samsung Galaxy M21', 3, 18999, '2021-03-22'),
(56, 36, 11, 'Samsung Galaxy Tab S6', 1, 60000, '2021-03-25'),
(57, 36, 12, 'SYMTAB60', 1, 10000, '2021-03-25'),
(58, 36, 10, 'Samsung Galaxy A20s', 1, 16999, '2021-03-25'),
(59, 37, 13, 'Acer ES1-572', 1, 30500, '2021-03-29'),
(60, 37, 14, 'Dell XPS 15 7590', 1, 236500, '2021-03-29'),
(61, 37, 10, 'Samsung Galaxy A20s', 1, 16999, '2021-03-29'),
(62, 37, 9, 'Samsung Galaxy M21', 1, 18999, '2021-03-29');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` int(11) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `productcategory` varchar(200) NOT NULL,
  `productpurchaseprice` float NOT NULL,
  `productsaleprice` float NOT NULL,
  `productstock` int(11) NOT NULL,
  `productdescription` varchar(1000) NOT NULL,
  `productimage` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `productname`, `productcategory`, `productpurchaseprice`, `productsaleprice`, `productstock`, `productdescription`, `productimage`) VALUES
(9, 'Samsung Galaxy M21', 'Mobile', 16999, 18999, 494, 'First Release	March 2020\r\nColors	Midnight Blue, Raven Black\r\n  Connectivity	 \r\nNetwork	2G, 3G, 4G\r\nSIM	Dual Nano SIM\r\nWLAN	? dual-band, Wi-Fi direct, Wi-Fi hotspot\r\nBluetooth	? v5.0, A2DP, LE\r\nGPS	? A-GPS, GLONASS, BDS\r\nRadio	? FM, RDS, recording\r\nUS', '605a25d9bf994.jpg'),
(10, 'Samsung Galaxy A20s', 'Mobile', 15499, 16999, 334, 'Network	2G, 3G, 4G\r\nOperating System	Android Pie v9.0 (One UI)\r\nChipset	Qualcomm Snapdragon 450 (14 nm)\r\nRAM	3 / 4 GB\r\nProcessor	Octa core, 1.8 GHz\r\nGPU	Adreno 506\r\nROM	32 / 64 GB\r\nMicroSD Slot	? up to 512 GB (dedicated slot)\r\nBack Camera	 \r\nResoluti', '605a26987a912.jpg'),
(11, 'Samsung Galaxy Tab S6', 'Tablet', 58000, 60000, 232, 'Network\r\nTechnology\r\nGSM / HSPA / LTE\r\n2G bands\r\nGSM 850 / 900 / 1800 / 1900\r\n3G bands\r\nHSDPA 850 / 900 / 1700(AWS) / 1900 / 2100\r\n4G bands\r\nLTE (unspecified)\r\nSpeed\r\nHSPA 42.2/5.76 Mbps, LTE-A (6CA) Cat20 2048/150 Mbps\r\nGPRS\r\nEDGE\r\nBody\r\nDimensions\r\n244.5 x 159.5 x 5.7 mm (9.63 x 6.28 x 0.22 in)\r\nWeight\r\n420 g (14.82 oz)\r\nBuild\r\nFront glass, aluminum body\r\nSIM\r\nNano-SIMStylus support (Bluetooth integration; magnetic)\r\nDisplay\r\nType\r\nSuper AMOLED capacitive touchscreen, 16M colors\r\nSize\r\n10.5 inches, 321.9 cm2 (~82.5% screen-to-body ratio)\r\nResolution\r\n1600 x 2560 pixels, 16:10 ratio (~287 ppi density)\r\nMultitouch\r\nPlatform\r\nOS\r\nAndroid 9.0 (Pie); One UI\r\nChipset\r\nQualcomm SDM855 Snapdragon 855 (7 nm)\r\nCPU\r\nOcta-core (1x2.84 GHz Kryo 485 & 3x2.42 GHz Kryo 485 & 4x1.78 GHz Kryo 485)\r\nGPU\r\nAdreno 640\r\nMemory\r\nCard slot\r\nmicroSD, up to 1 TB (dedicated slot)\r\nInternal\r\n128/256 GB\r\nRAM\r\n6/8 GB\r\nCamera\r\nPrimary camera\r\n13 MP, f/2.0, 26mm (wide), 1/3.4\", 1.0µm, AF\r\n5 MP, f/2.2, 12mm (ultrawid', '605a282be4451.jpg'),
(12, 'SYMTAB60', 'Tablet', 8500, 10000, 39, 'Hardware\r\nDesign\r\nscreen\r\n8\" IPS 800 x 1280(~300ppi pixel density)\r\ndimension\r\n219.4 X 126.8 X 9.4 mm\r\nweight\r\n367 gm\r\nMemory\r\nexpandable\r\n32 GB\r\nRAM\r\n2 GB\r\nROM\r\n16 GB\r\nProcessor\r\nnumber of cores\r\n4 core\r\nCPU\r\nCortex-A7 1.3GHz\r\nGPU\r\nMali 400 GHz\r\nCamera\r\nprimary\r\n5 MP AF\r\nsecondary\r\n2 MP\r\nBattery\r\ncapacity\r\n4200mAh Li-Polymer\r\nConnectivity\r\nWi-Fi\r\n802.11 b/g/n\r\nUSB\r\nmicroUSB v2.0\r\nbluetooth\r\nYes, v4.0\r\nAudio\r\nradio\r\nFM\r\nOthers\r\nsensors\r\nG-Sensor, GPS\r\nManufacturer\r\nfirst arrival\r\nOctober, 2017\r\nManufactured By\r\nsymphony\r\navailability\r\navailable', '605a288b4c047.jpg'),
(13, 'Acer ES1-572', 'Laptop', 25000, 30500, 4, 'Laptop Type	Standard\r\nProcessor Type	Core i3 6th Gen\r\nProcessor Speed	2.3 Ghz, 3Mb Cache\r\nChipset	Intel\r\nScreen Size	15.6\" Screen\r\nRAM	4GB DDR3\r\nHard Disk	1TB HDD\r\nDisk Type	HDD\r\nOptical Drive	Yes\r\nGraphics Card	Intel Hd Graphics\r\nAudio/Speaker	HD Sound\r\nNetworking	10 / 100 / Integrated\r\nWebcam	Yes\r\nCard Reader	Yes\r\nBattery	4 Cell Battery', '605a28eb77c7d.jpg'),
(14, 'Dell XPS 15 7590', 'Laptop', 230000, 236500, 774, 'Features\r\nModel: Dell XPS 15 7590\r\nIntel Core i7-9750H Processor (12M Cache, 2.60 GHz up to 4.50 GHz)\r\n16GB Ram + 512GB SSD\r\n15.6\'\' 4K UHD(3840 x 2160) IPS Display\r\nGeForce GTX 1650 4GB Graphics', '605a294844e66.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `useremail`, `password`, `role`) VALUES
(17, 'asif', 'asif48708698@gmail.com', 'asif123', 'Admin'),
(18, 'zunayed', 'zunayedsyed0@gmail.com', 'zunayed123', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoiceid`);

--
-- Indexes for table `invoicedetails`
--
ALTER TABLE `invoicedetails`
  ADD PRIMARY KEY (`invoicedetailsid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoiceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `invoicedetails`
--
ALTER TABLE `invoicedetails`
  MODIFY `invoicedetailsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
