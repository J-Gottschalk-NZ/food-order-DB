-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2022 at 04:22 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `00_food_orders`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `Category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Category`) VALUES
(1, 'Trolley Items'),
(2, 'Fresh Herbs'),
(3, 'Herbs & Spices'),
(4, 'Eggs'),
(5, 'Pastry'),
(6, 'Meat'),
(7, 'Frozen Fruit & Veg'),
(8, 'Fruit & Veg'),
(9, 'Pasta'),
(10, 'Sauces,Vinegars,Dressings'),
(11, 'Tins/Jars/Bottles'),
(12, 'Dairy'),
(13, 'Baking Items'),
(14, 'Equipment'),
(16, 'Miscellaneous');

-- --------------------------------------------------------

--
-- Table structure for table `classsession`
--

CREATE TABLE `classsession` (
  `ClassSessionID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `YearLevel` int(2) NOT NULL,
  `Date` date NOT NULL,
  `Period` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classsession`
--

INSERT INTO `classsession` (`ClassSessionID`, `TeacherID`, `YearLevel`, `Date`, `Period`) VALUES
(3, 1, 11, '2022-08-04', 1),
(4, 2, 10, '2022-08-04', 1),
(6, 1, 10, '2022-08-04', 4),
(7, 1, 11, '2022-08-04', 1),
(8, 1, 11, '2022-08-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `SubjectID`, `TeacherID`) VALUES
(6, 5, 1),
(8, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `food_order`
--

CREATE TABLE `food_order` (
  `OrderID` int(11) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `Product` varchar(200) NOT NULL,
  `Comment` text NOT NULL,
  `ClassSessionID` int(11) NOT NULL,
  `Food_Order_Status` varchar(10) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_order`
--

INSERT INTO `food_order` (`OrderID`, `LastName`, `FirstName`, `Product`, `Comment`, `ClassSessionID`, `Food_Order_Status`) VALUES
(3, 'Arnson', 'Arnold', 'Club Sandwiches', '', 3, 'closed'),
(4, 'Lee', 'Megan', 'Salad - Bulk Order', 'This order is for 5 groups.  Each tray needs...\r\n- 100 g mixed salad\r\n- 10 g mayonnaise\r\n- 30 g feta\r\n- 2 g salt\r\n- 1 mL pepper', 4, 'closed'),
(6, 'Daveson', 'Dave', 'Scones', '            ', 6, 'closed'),
(7, 'Frankson', 'Frank', 'Fried Eggs', '', 7, 'closed'),
(8, 'Gregson', 'Greg', 'Ginger Biscuites', '', 8, 'closed');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `IngredientID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Ingredient` varchar(100) NOT NULL,
  `Units` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`IngredientID`, `CategoryID`, `Ingredient`, `Units`) VALUES
(1, 1, 'Salt', 'mL'),
(2, 1, 'Pepper', 'mL'),
(3, 1, 'Flour (plain)', 'g'),
(4, 1, 'Flour (SR)', 'g'),
(5, 1, 'Baking Powder', 'g'),
(6, 1, 'Baking Soda', 'g'),
(7, 1, 'Cocoa', 'g'),
(8, 1, 'Sugar (Caster)', 'g'),
(9, 1, 'Sugar (brown)', 'g'),
(10, 1, 'Sugar (raw)', 'g'),
(11, 1, 'Icing Sugar', 'g'),
(12, 1, 'Rolled Oats', 'g'),
(13, 1, 'Cornflour', 'g'),
(14, 1, 'Rice', 'g'),
(15, 1, 'Breadcrumbs', 'g'),
(16, 1, 'Coconut', 'g'),
(17, 2, 'Thyme - Fresh', 'g'),
(18, 2, 'Basil - Fresh', 'g'),
(19, 2, 'Parsley - Fresh', 'g'),
(20, 2, 'Coriander - Fresh', 'g'),
(21, 2, 'Garlic - Fresh', 'g'),
(22, 2, 'Ginger - Fresh', 'g'),
(23, 3, 'Nutmeg (ground)', 'mL'),
(24, 3, 'Ginger - ground', 'mL'),
(25, 3, 'Oregano - dried', 'mL'),
(26, 3, 'Basil - dried', 'mL'),
(27, 3, 'Thyme - dried', 'mL'),
(28, 3, 'Coriander - dried', 'mL'),
(29, 3, 'Curry Powder', 'mL'),
(30, 3, 'Cinnamon', 'mL'),
(31, 3, 'Cumin', 'mL'),
(32, 3, 'Sage', 'mL'),
(33, 3, 'Parsley - dried', 'mL'),
(34, 3, 'Cayenne Pepper', 'mL'),
(35, 3, 'Paprika', 'mL'),
(36, 3, 'Mixed Herbs', 'mL'),
(37, 3, 'Chilli Powder/Flakes', 'mL'),
(38, 4, 'Eggs', ''),
(39, 5, 'Puff', 'sheet/s'),
(40, 5, 'Flaky', 'sheet/s'),
(41, 5, 'Short Sweet', 'sheet/s'),
(42, 5, 'Savoury', 'sheet/s'),
(43, 5, 'Filo', 'sheet/s'),
(44, 6, 'Bacon', 'g'),
(45, 6, 'Chicken Breast', 'g'),
(46, 6, 'Ham', 'g'),
(47, 6, 'Sausages Beef/Pork', 'g'),
(48, 6, 'Beef', 'g'),
(49, 6, 'Mince Beef', 'g'),
(50, 6, 'Mince Pork', 'g'),
(51, 6, 'Mince Chicken', 'g'),
(52, 7, 'Mixed berries', 'g'),
(53, 7, 'Blueberries', 'g'),
(54, 7, 'Raspberries', 'g'),
(55, 7, 'Peas', 'g'),
(56, 7, 'Beans', 'g'),
(57, 7, 'Corn', 'g'),
(58, 8, 'Lemons', ''),
(59, 8, 'Potatoes', ''),
(60, 8, 'Carrots', ''),
(61, 8, 'Onions', ''),
(62, 8, 'Tomatoes', ''),
(63, 8, 'Cucumber', ''),
(64, 8, 'Capsicum', ''),
(65, 8, 'Spring Onion', ''),
(66, 8, 'Spinach', ''),
(67, 8, 'Lettuce', ''),
(68, 8, 'Mixed Salad', 'g'),
(69, 9, 'Spaghetti', 'g'),
(70, 9, 'Penne', 'g'),
(71, 9, 'Spirals', 'g'),
(72, 9, 'Bows', 'g'),
(73, 9, 'Fettucine', 'g'),
(74, 9, 'Angel Hair', 'g'),
(75, 10, 'Soy', 'mL'),
(76, 10, 'Worcestershire', 'mL'),
(77, 10, 'White Vinegar', 'mL'),
(78, 10, 'Mustard', 'g'),
(79, 10, 'Balsamic', 'mL'),
(80, 10, 'Mayonnaise', 'g'),
(81, 10, 'Teriyaki', 'mL'),
(82, 10, 'BBQ sauce', 'g'),
(83, 10, 'Tomato Sauce', 'g'),
(84, 10, 'Sweet Chilli sauce', 'g'),
(85, 10, 'Crushed Garlic', 'g'),
(86, 10, 'Crushed Ginger', 'g'),
(87, 11, 'Olive Oil/ Canola/Vegetable', 'mL'),
(88, 11, 'Corn Kernels', ''),
(89, 11, 'Creamed Corn', ''),
(90, 11, 'Apples', ''),
(91, 11, 'Peaches', ''),
(92, 11, 'Apricots', ''),
(93, 11, 'Jam - Strawberry', 'g'),
(94, 11, 'Pineapple Rings', ''),
(95, 11, 'Pineapple pieces', ''),
(97, 11, 'Tomato Paste', 'g'),
(98, 11, 'Olives', 'g'),
(99, 11, 'Chickpeas', 'g'),
(100, 11, 'Condensed milk', 'mL'),
(101, 11, 'Lemon Juice', 'mL'),
(102, 11, 'Lime Juice', 'mL'),
(103, 12, 'Butter', 'g'),
(104, 12, 'Milk', 'mL'),
(105, 12, 'Cheese Tasty', 'g'),
(106, 12, 'Mozzarella', 'g'),
(107, 12, 'Parmesan', 'g'),
(108, 12, 'Feta', 'g'),
(109, 12, 'Cream', 'g'),
(110, 12, 'Sour Cream', 'g'),
(111, 12, 'Cream Cheese', 'g'),
(112, 12, 'Yogurt', 'g'),
(113, 13, 'Golden Syrup', 'g'),
(114, 13, 'Choc Chips', 'g'),
(115, 13, 'Choc melts', 'g'),
(116, 13, 'Chocolate Bar', 'g'),
(117, 13, 'Almonds', 'g'),
(118, 13, 'Walnuts', 'g'),
(119, 13, 'Food Colouring', 'mL'),
(120, 13, 'Vanilla Essence', 'mL'),
(121, 13, 'Spray Oil', ''),
(122, 13, 'Muffin Cases', ''),
(123, 14, 'Muffin Tins', ''),
(124, 14, 'Electric Beater', ''),
(125, 14, 'Pie Maker', ''),
(126, 14, 'Waffle Maker', ''),
(127, 14, 'Food Processor', ''),
(128, 14, 'Quiche Tins', ''),
(138, 8, 'Figs', ''),
(139, 11, 'Raspberry Jam', 'g');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `Recipe_IngredientsID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `IngredientID` int(11) NOT NULL,
  `Quantity` decimal(10,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`Recipe_IngredientsID`, `OrderID`, `IngredientID`, `Quantity`) VALUES
(10, 3, 68, '50.0'),
(11, 3, 80, '5.0'),
(12, 3, 108, '40.0'),
(13, 3, 1, '2.0'),
(14, 3, 2, '0.5'),
(16, 4, 68, '500.0'),
(17, 4, 80, '50.0'),
(18, 4, 108, '150.0'),
(19, 4, 1, '10.0'),
(20, 4, 2, '5.0'),
(27, 6, 117, '20.0'),
(28, 6, 4, '100.0'),
(29, 6, 10, '40.0'),
(30, 6, 103, '10.0'),
(31, 6, 90, '0.5'),
(32, 6, 128, '1.0'),
(33, 7, 38, '2.0'),
(34, 7, 103, '5.0'),
(35, 8, 103, '50.0'),
(36, 8, 4, '100.0'),
(37, 8, 38, '1.0'),
(38, 8, 24, '2.0');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID` int(11) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `YearLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectID`, `Code`, `YearLevel`) VALUES
(2, '9TECF', 9),
(3, 'HOS103', 11),
(4, 'HOS203', 12),
(5, 'TFO101', 11);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacherID` int(11) NOT NULL,
  `Teacher` varchar(30) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherID`, `Teacher`, `username`, `password`) VALUES
(1, 'CF', 'jcrawford', '$2y$08$o9IVkuOnxa6L5gHEhGIY0eiYXpvJ/oJ7YJdE8JVaC2DPetaRjl.5G'),
(2, 'LE', 'mlee', '$2y$08$LB0P75OsAvkMLC1JEC0vWO56XE92NK9RT3EwWc4pzw/txr36iiwf.'),
(4, 'HS', 'nhanson', '$2y$08$7FGMkhmPM.UgPcQhkGFf.eVjNDtcDCvUPyTKLae7jokv83xHCpouy'),
(5, 'admin', 'admin', '$2y$09$AjKvrlMa.vOXmAVG6KijY.8a91Ycv8RZhfL0ifPxXuNAOJgBGcfDa'),
(10, 'MU', 'mmudaliar', '$2y$08$OrLB4wI6DxWGqyLYT854luliVwzkdr2vwmwXNZicqjARWl.VvnBP2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `classsession`
--
ALTER TABLE `classsession`
  ADD PRIMARY KEY (`ClassSessionID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseID`);

--
-- Indexes for table `food_order`
--
ALTER TABLE `food_order`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`IngredientID`);

--
-- Indexes for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`Recipe_IngredientsID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacherID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `classsession`
--
ALTER TABLE `classsession`
  MODIFY `ClassSessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `food_order`
--
ALTER TABLE `food_order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `Recipe_IngredientsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `TeacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
