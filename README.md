-- Create database
CREATE DATABASE IF NOT EXISTS `campingrentaldb`;
USE `campingrentaldb`;

-- Create customer table
CREATE TABLE `customer` (
  `cust_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`cust_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create staff table
CREATE TABLE `staff` (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create Item table
CREATE TABLE `Item` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `item_type` varchar(100) NOT NULL,
  `item_fee` double NOT NULL,
  `item_quantity` int NOT NULL,
  `item_image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create Rent table
CREATE TABLE `Rent` (
  `rent_id` int NOT NULL AUTO_INCREMENT,
  `rent_date` date NOT NULL,
  `return_date` date NOT NULL,
  `rent_status` boolean NOT NULL,
  `cust_id` int NOT NULL,
  `payment_image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`rent_id`),
  FOREIGN KEY (`cust_id`) REFERENCES `customer`(`cust_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create RentalDetail table
CREATE TABLE `RentalDetail` (
  `RD_id` int NOT NULL AUTO_INCREMENT,
  `RD_quantity` int NOT NULL,
  `rd_fee` double NOT NULL,
  `rent_id` int NOT NULL,
  `item_id` int NOT NULL,
  PRIMARY KEY (`RD_id`),
  FOREIGN KEY (`rent_id`) REFERENCES `Rent`(`rent_id`),
  FOREIGN KEY (`item_id`) REFERENCES `Item`(`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create Payment table
CREATE TABLE `Payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `total_fee` double NOT NULL,
  `payment_date` date NOT NULL,
  `rent_id` int NOT NULL,
  PRIMARY KEY (`payment_id`),
  FOREIGN KEY (`rent_id`) REFERENCES `Rent`(`rent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Create contactUS table
CREATE TABLE `contactUS` (
  `comp_phoneNo` varchar(20) NOT NULL,
  `comp_email` varchar(50) NOT NULL,
  `comp_address` varchar(255) NOT NULL,
  `comp_webAdd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
