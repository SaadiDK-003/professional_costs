-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2024 at 12:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `professional_costs`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `check_meetings` ()   SELECT
m.id,
m.meeting_title AS 'title',
m.joining_date AS 'jd',
m.employee_ids AS 'empIDs',
m.meeting_link AS 'link',
m.status
FROM meeting m
WHERE m.status = 'available'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_completed_task` ()   SELECT
t.id,
t.employee_id,
t.department_id,
t.task_title AS 'title',
t.task_desc AS 'desc',
t.task_priority AS 'pri',
t.task_end_date AS 'end_date',
t.task_progress AS 'progress',
t.task_points AS 'points',
t.task_status,
t.comments,
e.name,
e.designation
FROM
task t
INNER JOIN employees e
WHERE t.task_status = 'completed' AND t.employee_id = e.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_in_complete_task` ()   SELECT
t.id,
t.employee_id,
t.department_id,
t.task_title AS 'title',
t.task_desc AS 'desc',
t.task_priority AS 'pri',
t.task_end_date AS 'end_date',
t.task_progress AS 'progress',
t.task_points AS 'points',
t.task_status,
t.comments,
e.name,
e.designation
FROM
task t
INNER JOIN employees e
WHERE t.task_status != 'completed' AND t.employee_id = e.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_departments` ()   SELECT
*
FROM departments$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_dept_by_emp_id` (IN `emp_id` BIGINT)   SELECT
d.id,
d.department_name
FROM employees e
INNER JOIN departments d
WHERE e.id=emp_id AND e.department=d.id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_emp_data_by_id` (IN `emp_id` BIGINT)   SELECT
e.id,
e.name,
e.email,
e.password,
e.contact,
e.dob,
e.address,
e.avatar,
e.joining_date,
e.designation,
e.department,
e.role,
e.status,
d.department_name AS 'D_Name'
FROM employees e
INNER JOIN departments d
WHERE e.role = 'employee' AND e.department = d.id AND e.id = emp_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_list_employees` ()   SELECT
e.id,
e.name,
e.email,
e.contact,
e.designation,
e.status,
d.department_name
FROM employees e
INNER JOIN departments d
WHERE e.department = d.id AND role != 'director'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_meetings_by_ids` (IN `emp_ids` TEXT)   SELECT
*
FROM meeting WHERE FIND_IN_SET(emp_ids, employee_ids)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_task_by_id` (IN `emp_id` BIGINT)   SELECT
*
FROM task t
WHERE t.employee_id=emp_id AND t.task_status !='completed'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_task_by_id_completed` (IN `emp_id` BIGINT)   SELECT
*
FROM task t
WHERE t.employee_id=emp_id AND t.task_status ='completed'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_emp_points` (IN `emp_id` BIGINT)   SELECT
SUM(t.task_points) AS 'total_points'
FROM task t
WHERE t.task_status = 'completed' AND t.employee_id = emp_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`) VALUES
(1, 'HR'),
(2, 'Intern'),
(6, 'Accounts'),
(7, 'Cyber Security');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `address` text DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `department` int(11) DEFAULT 2,
  `role` enum('employee','director') NOT NULL DEFAULT 'employee',
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `contact`, `dob`, `address`, `avatar`, `joining_date`, `designation`, `department`, `role`, `status`) VALUES
(1, 'director', 'director@gmail.com', '4297f44b13955235245b2497399d7a93', '588523465234', '1993-12-20', 'Quos ut quisquam odi', 'uploads/966_abc.png', '2019-12-28', 'Human Resources', 1, 'director', '1'),
(16, 'employee1', 'employee1@gmail.com', '4297f44b13955235245b2497399d7a93', '123123123', '2015-01-09', 'a', 'uploads/306_abc.png', '2024-03-14', 'Security Guy', 7, 'employee', '0'),
(17, 'employee2', 'employee2@gmail.com', '4297f44b13955235245b2497399d7a93', '123154123123', '2024-03-15', 'test xyz', 'uploads/716_abc.png', '2024-03-13', 'Accountant', 6, 'employee', '0'),
(19, 'employee3', 'employee3@gmail.com', '4297f44b13955235245b2497399d7a93', '154123123123', '2016-01-16', 'adadsasdas', NULL, NULL, NULL, 2, 'employee', '0');

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `id` int(11) NOT NULL,
  `meeting_title` varchar(255) NOT NULL,
  `joining_date` datetime NOT NULL,
  `employee_ids` text NOT NULL,
  `meeting_link` text NOT NULL,
  `status` enum('available','end') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`id`, `meeting_title`, `joining_date`, `employee_ids`, `meeting_link`, `status`) VALUES
(1, 'test_meeting123', '2024-03-21 22:25:00', '17,16', 'https://google.com/', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `department_id` int(11) NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `task_desc` text NOT NULL,
  `task_priority` enum('normal','medium','urgent') NOT NULL DEFAULT 'normal',
  `task_end_date` date NOT NULL,
  `task_progress` int(11) NOT NULL,
  `task_status` enum('pending','progress','completed') NOT NULL DEFAULT 'pending',
  `comments` text NOT NULL,
  `task_points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `employee_id`, `department_id`, `task_title`, `task_desc`, `task_priority`, `task_end_date`, `task_progress`, `task_status`, `comments`, `task_points`) VALUES
(2, 16, 7, 'test_task', 'this is a task that needs to be done urgent because the client was is ASAP.', 'urgent', '2024-03-16', 100, 'completed', 'done', 50),
(3, 16, 7, 'test_task', 'this is a task that needs to be done urgent because the client was is ASAP.', 'urgent', '2024-03-16', 70, 'progress', 'working.', 40),
(4, 17, 6, 'check account sheets ', 'check them all please.', 'medium', '2024-03-17', 100, 'completed', 'done', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id_2` (`employee_id`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department`) REFERENCES `departments` (`id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
