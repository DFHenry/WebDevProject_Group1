-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 22, 2026 at 03:01 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web-dev-project-group-assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `catering_orders`
--

CREATE TABLE `catering_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_date` datetime NOT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `event_type` varchar(50) DEFAULT NULL,
  `is_delivery` tinyint(1) DEFAULT '0',
  `delivery_address` varchar(255) DEFAULT NULL,
  `special_instructions` text,
  `order_status` varchar(20) DEFAULT 'Pending',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image_href` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `user_id`, `name`, `description`, `price`, `category`, `image_href`, `date_created`) VALUES
(4, 1, 'Greek Yogurt Cherry Danish', 'Buttery pastry layered with a blend of Greek yogurt and cream cheese, finished with a vibrant cherry filling for the perfect balance of tangy and sweet.', '4.85', 'Pastries & Croissants', 'https://images.pexels.com/photos/30632240/pexels-photo-30632240.jpeg?_gl=1*7y0pqb*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTM4MjUkajEzJGwwJGgw', '2026-04-19 11:45:16'),
(5, 1, 'Pistachio Croissant', 'A flaky croissant filled with smooth pistachio cream for a nutty, indulgent delight.', '4.60', 'Pastries & Croissants', 'https://images.pexels.com/photos/34517053/pexels-photo-34517053.jpeg?_gl=1*kws2dr*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTM3ODgkajUwJGwwJGgw', '2026-04-19 11:47:44'),
(6, 1, 'Spinach Feta Danish', 'Savoury, flaky pastry with spinach and feta filling.', '4.50', 'Pastries & Croissants', 'https://images.pexels.com/photos/18884737/pexels-photo-18884737.jpeg?_gl=1*1oepdds*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTM3MjckajUxJGwwJGgw', '2026-04-19 11:49:00'),
(7, 1, 'Cinnamon Bun', 'Soft, pillowy dough rolled with a rich cinnamon-sugar filling, baked to perfection and finished with a silky glaze that melts into every swirl.', '4.29', 'Pastries & Croissants', 'https://images.pexels.com/photos/5507697/pexels-photo-5507697.jpeg?_gl=1*4jbhr4*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTQwNTAkajEwJGwwJGgw', '2026-04-19 11:54:19'),
(8, 1, 'Chocolate Hazelnut Croissant', 'Flaky croissant filled with creamy chocolate-hazelnut spread for a decadent treat.', '4.25', 'Pastries & Croissants', 'https://images.pexels.com/photos/8023959/pexels-photo-8023959.jpeg?_gl=1*1rhqlu3*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTQxMzkkajU5JGwwJGgw', '2026-04-19 11:55:51'),
(9, 1, 'Bombe Alla Crema', 'Light, soft, and fluffy donuts with a creamy vanilla filling.', '3.25', 'Pastries & Croissants', 'https://images.pexels.com/photos/34427810/pexels-photo-34427810.png?_gl=1*e3lh09*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTQyMzgkajIwJGwwJGgw', '2026-04-19 11:57:27'),
(10, 1, 'Pistachio Chocolate Brownie', 'Fudgy, indulgent brownie topped with rich pistachios and a smooth layer of chocolate, creating a perfectly balanced bite of nutty depth and sweet decadence.', '5.25', 'Cookies, Squares & Tarts', 'https://images.pexels.com/photos/16785689/pexels-photo-16785689.jpeg?_gl=1*gve1mj*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTQ1ODIkajQ1JGwwJGgw', '2026-04-19 12:03:40'),
(11, 1, 'Almond Chocolate Biscotti', 'Crisp, golden biscotti packed with toasted almonds and rich chocolate pieces, delivering the perfect gourmet treat. Served as a pack of two.', '5.00', 'Cookies, Squares & Tarts', 'https://images.pexels.com/photos/33433973/pexels-photo-33433973.jpeg?_gl=1*b9pkf7*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTQ3NTEkajQ1JGwwJGgw', '2026-04-19 12:06:02'),
(12, 1, 'Homemade Rice Crispy Squares', 'Light, chewy squares made with crisped rice folded into a gooey, buttery marshmallow base. Simple, nostalgic, and irresistibly sweet.', '4.00', 'Cookies, Squares & Tarts', 'https://images.pexels.com/photos/36165606/pexels-photo-36165606.jpeg?_gl=1*1xlqfsi*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTQ4MjkkajQ4JGwwJGgw', '2026-04-19 12:07:22'),
(13, 1, 'Portuguese Custard Tarts', 'Golden Portuguese custard with a creamy centre and flaky shell.', '3.25', 'Cookies, Squares & Tarts', 'https://images.pexels.com/photos/36737341/pexels-photo-36737341.jpeg?_gl=1*5vzgcj*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTUxNTIkajQ4JGwwJGgw', '2026-04-19 12:12:40'),
(14, 1, 'Spiced Pumpkin Tarts', 'Warm spiced pumpkin in a cozy tart shell. Seasonal item.', '3.25', 'Cookies, Squares & Tarts', 'https://images.pexels.com/photos/29172208/pexels-photo-29172208.jpeg?_gl=1*6fbc8j*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTUyMjUkajM1JGwwJGgw', '2026-04-19 12:13:53'),
(15, 1, 'Chocolate Chip Cookie', 'Warm, golden-baked cookies loaded with rich chocolate chips, featuring crisp edges and soft, chewy centres for a timeless, crowd-pleasing treat.', '1.85', 'Cookies, Squares & Tarts', 'https://images.pexels.com/photos/13921501/pexels-photo-13921501.jpeg?_gl=1*9qn4h4*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTUyOTQkajQ1JGwwJGgw', '2026-04-19 12:15:04'),
(16, 1, 'Blueberry Lemon Scone', 'Tender scone bursting with blueberries and lemon zest, finished with a light citrus glaze.', '5.25', 'Muffins, Scones & Tea Biscuits', 'https://images.pexels.com/photos/31513671/pexels-photo-31513671.jpeg?_gl=1*1s0yk87*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU0NTgkajM2JGwwJGgw', '2026-04-19 12:18:36'),
(17, 1, 'Buttery Tea Biscuit', 'Tender, golden biscuits with a delicate crumb and rich buttery flavour. Perfectly baked for a light, comforting bite alongside your favourite tea.', '4.35', 'Muffins, Scones & Tea Biscuits', 'https://images.pexels.com/photos/36903813/pexels-photo-36903813.jpeg?_gl=1*14986jh*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU2MDgkajQyJGwwJGgw', '2026-04-19 12:20:20'),
(18, 1, 'Cheddar Scones', 'A savoury, golden scone baked with sharp cheddar cheese for a rich, flavourful bite.', '4.35', 'Muffins, Scones & Tea Biscuits', 'https://images.pexels.com/photos/33788285/pexels-photo-33788285.jpeg?_gl=1*1j5gc4b*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU2NDgkajIkbDAkaDA.', '2026-04-19 12:21:28'),
(19, 1, 'Chocolate Chip Muffin', 'A soft, tender muffin loaded with rich chocolate chips for a sweet and satisfying bite.', '2.75', 'Muffins, Scones & Tea Biscuits', 'https://images.pexels.com/photos/5412341/pexels-photo-5412341.jpeg?_gl=1*13tpf0t*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU3MTQkajQ5JGwwJGgw', '2026-04-19 12:22:21'),
(20, 1, 'Blueberry Muffin', 'A moist, fluffy muffin packed with juicy blueberries and a hint of sweetness, perfect for breakfast or a snack.', '2.75', 'Muffins, Scones & Tea Biscuits', 'https://images.pexels.com/photos/7935282/pexels-photo-7935282.jpeg?_gl=1*1ijdq7i*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU3NjckajU5JGwwJGgw', '2026-04-19 12:23:07'),
(21, 1, 'Lemon Cranberry Muffin', 'A zesty, tender muffin bursting with tart cranberries and bright lemon flavour for a refreshing treat.', '2.75', 'Muffins, Scones & Tea Biscuits', 'https://images.pexels.com/photos/90607/pexels-photo-90607.png?_gl=1*rcl7gh*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU4MjgkajU5JGwwJGgw', '2026-04-19 12:24:14'),
(22, 1, 'Apple Walnut Cake', 'Moist, tender, and perfectly spiced with cinnamon, apples, and crunchy walnuts. Gluten-free.', '5.25', 'Cakes & Loafs', 'https://images.pexels.com/photos/32066570/pexels-photo-32066570.jpeg?_gl=1*e63h2k*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU4ODUkajIkbDAkaDA.', '2026-04-19 12:25:20'),
(23, 1, 'Carrot Cake', 'Classic carrot cake with a light cream cheese finish.', '3.99', 'Cakes & Loafs', 'https://images.pexels.com/photos/11381452/pexels-photo-11381452.jpeg?_gl=1*16jp36s*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU5NDMkajUxJGwwJGgw', '2026-04-19 12:26:07'),
(24, 1, 'Banana Loaf', 'Soft, moist, and naturally sweet with ripe bananas.', '3.99', 'Cakes & Loafs', 'https://images.pexels.com/photos/6803031/pexels-photo-6803031.jpeg?_gl=1*1jx9wck*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTU5OTYkajYwJGwwJGgw', '2026-04-19 12:26:56'),
(25, 1, 'Blueberry Lemon Loaf', 'Bursting with juicy blueberries and a touch of fresh lemon.', '3.99', 'Cakes & Loafs', 'https://images.pexels.com/photos/6923143/pexels-photo-6923143.jpeg?_gl=1*1n1c8tw*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY2MTM3MTgkbzEkZzEkdDE3NzY2MTYwMzQkajIyJGwwJGgw', '2026-04-19 12:27:39'),
(26, 1, 'Drip Coffee', 'Our classic blend. Freshly brewed, smooth, and comforting.', '3.45', 'Beverages', 'https://images.pexels.com/photos/29507967/pexels-photo-29507967.jpeg?_gl=1*1r2b16p*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI0NjQkajI3JGwwJGgw', '2026-04-19 12:47:35'),
(27, 1, 'Latte', 'Our most beloved, best-selling beverage. Balance of bold espresso and silky milk.', '5.45', 'Beverages', 'https://images.pexels.com/photos/894696/pexels-photo-894696.jpeg?_gl=1*16yudan*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI1NjUkajQ4JGwwJGgw', '2026-04-19 12:48:23'),
(28, 1, 'Macchiato', 'Double espresso topped with a touch of foam.', '4.50', 'Beverages', 'https://images.pexels.com/photos/28721317/pexels-photo-28721317.jpeg?_gl=1*1kcmjnv*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI2MDAkajEzJGwwJGgw', '2026-04-19 12:48:43'),
(29, 1, 'Cappuccino', 'Velvety and rich coffee.', '5.00', 'Beverages', 'https://images.pexels.com/photos/10355655/pexels-photo-10355655.jpeg?_gl=1*1fsws64*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI2MzUkajQ5JGwwJGgw', '2026-04-19 12:49:09'),
(30, 1, 'Iced Coffee', 'Simple, bold, and cold coffee.', '4.00', 'Beverages', 'https://images.pexels.com/photos/8980388/pexels-photo-8980388.jpeg?_gl=1*vvh93v*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI2OTAkajYwJGwwJGgw', '2026-04-19 12:49:38'),
(31, 1, 'Tea', 'Selection of soothing hot teas featuring a variety of calming and flavourful blends.', '3.50', 'Beverages', 'https://images.pexels.com/photos/34342941/pexels-photo-34342941.jpeg?_gl=1*1nww598*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI3MzgkajEyJGwwJGgw', '2026-04-19 12:50:26'),
(32, 1, 'London Fog', 'Earl Grey Cream tea with steamed milk and a hint of vanilla.', '5.50', 'Beverages', 'https://images.pexels.com/photos/2262832/pexels-photo-2262832.jpeg?_gl=1*12y8jv7*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI3ODkkajM0JGwwJGgw', '2026-04-19 12:50:43'),
(33, 1, 'Hot Chocolate', 'Rich and creamy hot chocolate.', '3.25', 'Beverages', 'https://images.pexels.com/photos/6119112/pexels-photo-6119112.jpeg?_gl=1*1n8gy8w*_ga*MjA1NDUxNTMyMS4xNzc2NjEzNzE5*_ga_8JE65Q40S6*czE3NzY3MDI0MzEkbzIkZzEkdDE3NzY3MDI4NTEkajU1JGwwJGgw', '2026-04-19 12:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@test.com', '$2y$10$Za7uEwbbktPOYg03mJuGteBR/.99Smkio4PZ3X93h9MubarbQ5wkm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
