-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 08:31 AM
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
(2, 'Technical'),
(3, 'Accounts'),
(5, 'Cyber Security');

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
  `address` text NOT NULL,
  `avatar` text NOT NULL,
  `joining_date` date NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` int(11) NOT NULL,
  `role` enum('employee','director') NOT NULL DEFAULT 'employee',
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `contact`, `dob`, `address`, `avatar`, `joining_date`, `designation`, `department`, `role`, `status`) VALUES
(1, 'director', 'director@gmail.com', '4297f44b13955235245b2497399d7a93', '588', '1971-09-30', 'Quos ut quisquam odi', 'uploads/966_abc.png', '2019-12-28', 'Est excepturi enim s', 1, 'director', '1'),
(10, 'employee1', 'employee1@gmail.com', '4297f44b13955235245b2497399d7a93', '588', '1971-09-30', 'Quos ut quisquam odi', 'uploads/966_abc.png', '2019-12-28', 'Est excepturi enim s', 3, 'employee', '0'),
(11, 'employee2', 'employee2@gmail.com', '4297f44b13955235245b2497399d7a93', '47841231231231', '1987-03-13', 'Consequuntur beatae ', 'uploads/104_abc.png', '1980-06-07', 'Technical Call Support', 2, 'employee', '0'),
(12, 'employee3', 'employee3@gmail.com', '4297f44b13955235245b2497399d7a93', '47841231231231', '1987-03-13', 'Consequuntur beatae ', 'uploads/104_abc.png', '1980-06-07', 'Technical Call Support', 5, 'employee', '0');

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
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `employee_id`, `department_id`, `task_title`, `task_desc`, `task_priority`, `task_end_date`, `task_progress`, `task_status`, `comments`) VALUES
(10, 10, 3, 'Sales Work', 'check all vendors sales for this month.', 'urgent', '2024-03-15', 100, 'completed', 'Done');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
