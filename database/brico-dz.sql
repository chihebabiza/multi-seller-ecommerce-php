-- phpMyAdmin SQL Dump
-- version 5.2.1-4.fc40
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 06, 2024 at 10:28 AM
-- Server version: 10.11.6-MariaDB
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ch`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_id` int(100) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `wilaya` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `quantity` int(100) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `vendor_id`, `client_name`, `city`, `wilaya`, `phone`, `order_date`, `quantity`, `status`) VALUES
(38, 43, 12, 'chiheb abiza', 'Bougaa', 'setif', '0657842205', '2024-04-27', 3, 'shipped'),
(39, 43, 16, 'saadoudi idris', 'bab ezzouar', 'Alger', '0567230912', '2024-04-27', 1, 'cancelled'),
(40, 52, 16, 'chiheb abiza', 'Bougaa', 'setif', '0657842205', '2024-04-29', 2, 'shipped'),
(41, 43, 12, 'saadoudi idris', 'bab ezzouar', 'Alger', '0567230912', '2024-04-27', 1, 'cancelled'),
(42, 43, 12, 'belkis hamza', 'bejaia', 'bejaia', '0567230912', '2024-04-27', 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(100) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `status` varchar(256) NOT NULL,
  `create_date` date NOT NULL,
  `update_date` date NOT NULL,
  `quantity` int(100) UNSIGNED NOT NULL DEFAULT 0,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `vendor_id`, `product_name`, `description`, `price`, `image`, `status`, `create_date`, `update_date`, `quantity`, `category`) VALUES
(41, 12, 'Motherboard MSI B250 GAMING M3', 'Dominate the battlefield with the MSI B250 GAMING M3 motherboard! This ATX powerhouse is packed with features to elevate your gaming experience, all at a budget-friendly price.\r\n\r\nPower Up for Performance: Supports 6th and 7th gen Intel Core processors (LGA 1151 socket) for smooth gameplay.\r\nBlazing-Fast Memory: Equipped with four DDR4 DIMM slots, allowing for up to 64GB of high-speed memory for seamless multitasking and intense games.\r\nStorage That Screams: Features six SATA III ports for traditional storage drives and two M.2 slots for lightning-fast NVMe SSDs â€“ load games and applications in a flash!\r\nDual Graphics Power: Boasts two PCI-Express 3.0 x16 slots for multi-GPU configurations (AMD CrossFire compatible) to crank up the graphics settings.\r\nKiller Networking: Equipped with a Killer E2500 Gigabit Ethernet controller for ultra-low latency and lag-free online gaming.\r\nImmersive Audio: Audio Boost 4 with Nahimic 2 sound enhancement delivers crystal-clear audio and realistic in-game soundscapes.\r\nBuilt to Last: MSI\'s Military Class 5 components ensure rock-solid stability and durability for marathon gaming sessions.', 43000, '662d1d05e6a59_product-01.png', 'active', '2024-04-27', '2024-04-27', 4, 'Computer Components'),
(42, 12, 'Adjustable Desk Fan', 'Beat the heat and stay productive with this versatile Adjustable Desk Fan! This compact powerhouse offers a refreshing breeze to keep you comfortable throughout the day.\r\n\r\nFeatures:\r\n\r\nAdjustable Head: Direct the airflow exactly where you need it with the pivoting head that tilts for customized comfort.\r\nMultiple Speed Settings: Choose from low, medium, and high settings to personalize the airflow intensity based on your preference and the surrounding temperature.\r\nSturdy Base: The wide and stable base ensures the fan stays securely in place on your desk, even at higher speeds.\r\nQuiet Operation: Focus on your work or unwind without distraction. This fan operates at a whisper-quiet level, keeping you cool without creating unwanted noise. (Optional: Mention specific noise level in decibels if available)\r\nCompact Design: This space-saving fan fits comfortably on desks of all sizes without taking up valuable workspace.\r\nBenefits:\r\n\r\nEnhanced Comfort: Enjoy a cool and refreshing breeze that combats heat and keeps you comfortable throughout the day.\r\nImproved Focus: Reduce fatigue and stay alert with a steady stream of cool air, promoting concentration and productivity.\r\nReduced Noise Levels: Compared to traditional air conditioners, this fan offers a quieter cooling solution.\r\nIncreased Air Circulation: Improve air quality and prevent stagnant air by circulating fresh air in your workspace.\r\nPortability (Optional): If the fan is USB-powered, mention its portability for use on desks or tables anywhere.\r\nIdeal for:\r\n\r\nHome offices\r\nWork cubicles\r\nDorm rooms\r\nStudy areas\r\nBedrooms (as a bedside table fan)', 9400, '662d1ce03fedd_product-03.png', 'active', '2024-04-27', '2024-04-27', 8, 'Home Appliances'),
(43, 12, 'Vacuum Cleaner', 'Say goodbye to dust bunnies and hello to spotless floors with the all-new CleanTech 5000! This powerful and versatile vacuum cleaner is designed to tackle any cleaning challenge, from carpets and hard floors to upholstery and pet hair.\r\n\r\nEffortless Cleaning:\r\n\r\nLightweight and maneuverable design for effortless cleaning throughout your home.\r\nAdvanced HEPA filter captures dust, allergens, and pet dander for a healthier home environment.\r\nThree cleaning modes to customize the cleaning for different floor types and messes.\r\nPowerful Performance:\r\n\r\nHigh-performance motor ensures a deep clean, removing dirt and debris from even the toughest messes.\r\n2000-watt motor delivers powerful suction that picks up everything in its path.\r\nVersatile Cleaning:\r\n\r\nIncludes a crevice tool and upholstery brush for cleaning hard-to-reach areas and furniture.\r\nEasily converts to a handheld vacuum for convenient cleaning of furniture, stairs, and upholstery.\r\nThis CleanTech 5000 vacuum cleaner is your ultimate cleaning companion, making cleaning tasks a breeze and leaving your home sparkling clean.', 8600, '662d1cce03d65_footer-copy-0.png', 'active', '2024-04-27', '2024-04-27', 13, 'Home Appliances'),
(44, 12, 'TitanRear Differential', 'Experience unparalleled performance with the TitanRear Differential, meticulously engineered for the rear axle of your vehicle. This cutting-edge differential is the epitome of precision and power, delivering unrivaled control and traction when you need it most.\r\n\r\nDominant Rear Differential:\r\n\r\nTailored for Power: The TitanRear Differential is specifically designed for the rear axle, harnessing the full potential of your vehicle\'s rear-wheel drive system.\r\nOptimized Performance: Experience smoother cornering and enhanced stability as the TitanRear Differential efficiently distributes power to the rear wheels.\r\nEnhanced Traction:\r\n\r\nMaximum Grip: With advanced traction technology, the TitanRear Differential ensures superior traction, even in challenging road conditions.\r\nUnmatched Control: Enjoy confident driving in all situations, thanks to the TitanRear Differential\'s precise control over wheel spin and torque distribution.\r\nBuilt to Last:\r\n\r\nRugged Construction: Crafted from high-strength materials, the TitanRear Differential is built to withstand the rigors of heavy-duty use.\r\nReliable Performance: Count on the TitanRear Differential for consistent performance and durability mile after mile, ensuring peace of mind on every journey.\r\nUpgrade Your Drive:\r\n\r\nUpgrade your vehicle with the TitanRear Differential and unlock the true potential of your rear axle. Dominate the road with unparalleled power, traction, and control. Experience the difference with the TitanRear Differential today.\r\n\r\nPro Tip:\r\n\r\nProvide detailed specifications and compatibility information to help customers determine if the TitanRear Differential is suitable for their vehicle.\r\nInclude customer testimonials or reviews to showcase the real-world performance of the TitanRear Differential.\r\nOffer installation services or guidance to assist customers in upgrading their vehicle\'s rear axle with the TitanRear Differential.', 21000, '662d1cfc029ca_product-02.png', 'active', '2024-04-27', '2024-04-27', 2, 'Auto Parts'),
(52, 16, 'Video graphics cardd', 'Description: A video graphics card, is a crucial component in a computer system responsible for rendering images, videos, and animations on a display. It is designed to handle complex graphical computations quickly and efficiently, enhancing the visual performance of a computer.\r\nElevate your computing experience to new heights with our state-of-the-art video graphics card. Designed to deliver unparalleled performance and stunning visuals, this GPU is the perfect companion for gamers, content creators, and professionals who demand the best.', 43000, '662ebaeb05fba_photo_2024-04-28_22-04-32-removebg-preview.png', 'active', '2024-04-28', '2024-04-28', 5, 'Computer Components'),
(53, 16, 'Electric motor', 'An electric motor driven by alternating current (AC), which includes two basic parts: stator and rotor.\r\nComponents\r\nConsists of an outside stator with coils for AC to produce a rotating magnetic field, and an inside rotor attached to the output shaft creating a second magnetic field.\r\nRotor Magnetic Field\r\nThe rotor magnetic field can be generated by permanent magnets, reluctance saliency, or DC or AC electrical windings.', 56000, '662ebb898c8bd_photo_2024-04-28_22-10-09-removebg-preview.png', 'active', '2024-04-28', '2024-04-28', 2, 'Auto Parts'),
(54, 16, 'Gear metal wheels isolated', 'Based on this description, it seems like you\'re looking at or looking for metal gear wheels, which are mechanical components commonly used in various machinery and equipment, such as industrial machinery, automobiles, robotics, and more. These gear wheels are typically made of metal for durability and strength, and they are used to transmit power and motion between rotating shafts. The term \"isolated\" likely refers to the way the gear wheels are presented in the image or described, possibly without any other objects or distractions in the background.', 1200, '662ebfcaceacf_gear-metal-wheels-isolated-white-background__1_-removebg-preview (1).png', 'awaiting', '2024-04-28', '2024-04-28', 13, 'Auto Parts'),
(55, 16, 'Gear metal wheels isolated', 'Based on this description, it seems like you\'re looking at or looking for metal gear wheels, which are mechanical components commonly used in various machinery and equipment, such as industrial machinery, automobiles, robotics, and more. These gear wheels are typically made of metal for durability and strength, and they are used to transmit power and motion between rotating shafts. The term \"isolated\" likely refers to the way the gear wheels are presented in the image or described, possibly without any other objects or distractions in the background.', 1200, '662ebfcaceacf_gear-metal-wheels-isolated-white-background__1_-removebg-preview (1).png', 'active', '2024-04-28', '2024-04-28', 13, 'Auto Parts'),
(56, 16, 'Electric motor', '', 56000, '662ebb898c8bd_photo_2024-04-28_22-10-09-removebg-preview.png', 'inactive', '2024-04-28', '2024-04-28', 2, 'Auto Parts');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `vendor_email` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `vendor_status` varchar(100) NOT NULL,
  `vendor_password` varchar(256) NOT NULL,
  `points` int(255) UNSIGNED NOT NULL DEFAULT 0,
  `balance` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_name`, `vendor_email`, `register_date`, `vendor_status`, `vendor_password`, `points`, `balance`, `role`) VALUES
(12, 'amine kerour', 'amine@gmail.com', '2024-04-06', 'active', '$2y$10$EaD5BZFiCj5rHz2C2dnvt.FE2pu5g/endFp0ZDh04sDSrQDxU9dM.', 20, 10, 'vendor'),
(15, 'admin', 'o@admin.com', '2024-04-15', 'active', '$2y$10$0./d3wTML9GXT2MOHoQHPe93dqYmQVuccDKZeTZhXTTHJG7EVvBxu', 0, 0, 'admin'),
(16, 'chiheb abiza', 'chiheb@gmail.com', '2024-04-16', 'active', '$2y$10$uSKiNBCwQ7QNOV4VJLB97ObhYpK1/iwPUKf9FMydIO19fZf4AK6ZG', 10, 10, 'vendor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
