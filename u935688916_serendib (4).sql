-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 09, 2026 at 08:46 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u935688916_serendib`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL,
  `year_name` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `year_name`, `start_date`, `end_date`, `is_active`) VALUES
(1, '2026/2027', '2026-01-01', '2026-12-31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `entity_type` enum('student','teacher') NOT NULL,
  `entity_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` enum('present','absent') DEFAULT 'present',
  `marked_by` int(11) DEFAULT NULL,
  `time_out` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `entity_type`, `entity_id`, `date`, `time_in`, `status`, `marked_by`, `time_out`) VALUES
(482, 'teacher', 14, '2026-01-27', '00:00:00', 'absent', NULL, NULL),
(483, 'teacher', 14, '2026-01-28', '00:00:00', 'absent', NULL, NULL),
(484, 'teacher', 14, '2026-02-11', '00:00:00', 'absent', NULL, NULL),
(485, 'teacher', 27, '2026-02-16', '00:00:00', 'absent', NULL, NULL),
(486, 'teacher', 26, '2026-02-17', '00:00:00', 'absent', NULL, NULL),
(487, 'teacher', 24, '2026-02-16', '00:00:00', 'absent', NULL, NULL),
(488, 'student', 1, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(489, 'student', 2, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(490, 'student', 3, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(491, 'student', 4, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(492, 'student', 5, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(493, 'student', 6, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(494, 'student', 7, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(495, 'student', 8, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(496, 'student', 9, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(497, 'student', 10, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(498, 'student', 11, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(499, 'student', 12, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(500, 'student', 13, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(501, 'student', 14, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(502, 'student', 15, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(503, 'student', 16, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(504, 'student', 17, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(505, 'student', 18, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(506, 'student', 19, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(507, 'student', 20, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(508, 'student', 21, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(509, 'student', 22, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(510, 'student', 23, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(511, 'student', 24, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(512, 'student', 25, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(513, 'student', 26, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(514, 'student', 27, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(515, 'student', 28, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(516, 'student', 29, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(517, 'student', 30, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(518, 'student', 31, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(519, 'student', 32, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(520, 'student', 33, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(521, 'student', 35, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(522, 'student', 37, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(523, 'student', 38, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(524, 'student', 39, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(525, 'student', 40, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(526, 'student', 41, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(527, 'student', 42, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(528, 'student', 43, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(529, 'student', 44, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(530, 'student', 45, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(531, 'student', 46, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(532, 'student', 47, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(533, 'student', 48, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(534, 'student', 49, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(535, 'student', 50, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(536, 'student', 51, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(537, 'student', 53, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(538, 'student', 54, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(539, 'student', 55, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(540, 'student', 56, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(541, 'student', 57, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(542, 'student', 58, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(543, 'student', 59, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(544, 'student', 60, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(545, 'student', 61, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(546, 'student', 62, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(547, 'student', 64, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(548, 'student', 65, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(549, 'student', 66, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(550, 'student', 67, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(551, 'student', 68, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(552, 'student', 69, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(553, 'student', 70, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(554, 'student', 71, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(555, 'student', 72, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(556, 'student', 73, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(557, 'student', 74, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(558, 'student', 75, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(559, 'student', 76, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(560, 'student', 77, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(561, 'student', 78, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(562, 'student', 79, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(563, 'student', 80, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(564, 'student', 81, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(565, 'student', 82, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(566, 'student', 83, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(567, 'student', 84, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(568, 'student', 85, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(569, 'student', 86, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(570, 'student', 87, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(571, 'student', 88, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(572, 'student', 89, '2026-03-01', '00:00:00', 'absent', NULL, NULL),
(573, 'teacher', 30, '2026-02-26', '00:00:00', 'absent', NULL, NULL),
(574, 'teacher', 25, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(575, 'teacher', 27, '2026-03-03', '00:00:00', 'absent', NULL, NULL),
(576, 'student', 1, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(577, 'student', 2, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(578, 'student', 3, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(579, 'student', 4, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(580, 'student', 5, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(581, 'student', 6, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(582, 'student', 7, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(583, 'student', 8, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(584, 'student', 9, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(585, 'student', 10, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(586, 'student', 11, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(587, 'student', 12, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(588, 'student', 13, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(589, 'student', 14, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(590, 'student', 15, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(591, 'student', 16, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(592, 'student', 17, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(593, 'student', 18, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(594, 'student', 19, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(595, 'student', 20, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(596, 'student', 21, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(597, 'student', 22, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(598, 'student', 23, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(599, 'student', 24, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(600, 'student', 25, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(601, 'student', 26, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(602, 'student', 27, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(603, 'student', 28, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(604, 'student', 29, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(605, 'student', 30, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(606, 'student', 31, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(607, 'student', 32, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(608, 'student', 33, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(609, 'student', 35, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(610, 'student', 37, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(611, 'student', 38, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(612, 'student', 39, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(613, 'student', 40, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(614, 'student', 41, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(615, 'student', 42, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(616, 'student', 43, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(617, 'student', 44, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(618, 'student', 45, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(619, 'student', 46, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(620, 'student', 47, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(621, 'student', 48, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(622, 'student', 49, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(623, 'student', 50, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(624, 'student', 51, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(625, 'student', 53, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(626, 'student', 54, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(627, 'student', 55, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(628, 'student', 56, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(629, 'student', 57, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(630, 'student', 58, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(631, 'student', 59, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(632, 'student', 60, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(633, 'student', 61, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(634, 'student', 62, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(635, 'student', 64, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(636, 'student', 65, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(637, 'student', 66, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(638, 'student', 67, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(639, 'student', 68, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(640, 'student', 69, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(641, 'student', 70, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(642, 'student', 71, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(643, 'student', 72, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(644, 'student', 73, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(645, 'student', 74, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(646, 'student', 75, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(647, 'student', 76, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(648, 'student', 77, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(649, 'student', 78, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(650, 'student', 79, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(651, 'student', 80, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(652, 'student', 81, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(653, 'student', 82, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(654, 'student', 83, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(655, 'student', 84, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(656, 'student', 85, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(657, 'student', 86, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(658, 'student', 87, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(659, 'student', 88, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(660, 'student', 89, '2026-03-04', '00:00:00', 'absent', NULL, NULL),
(661, 'teacher', 30, '2026-03-25', '00:00:00', 'absent', NULL, NULL),
(662, 'teacher', 30, '2026-03-26', '00:00:00', 'absent', NULL, NULL),
(663, 'teacher', 25, '2026-04-02', '00:00:00', 'absent', NULL, NULL),
(664, 'teacher', 14, '2026-04-09', '00:00:00', 'absent', NULL, NULL),
(665, 'student', 1, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(666, 'student', 2, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(667, 'student', 3, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(668, 'student', 4, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(669, 'student', 5, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(670, 'student', 6, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(671, 'student', 7, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(672, 'student', 8, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(673, 'student', 9, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(674, 'student', 10, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(675, 'student', 11, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(676, 'student', 12, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(677, 'student', 13, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(678, 'student', 14, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(679, 'student', 15, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(680, 'student', 16, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(681, 'student', 17, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(682, 'student', 18, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(683, 'student', 19, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(684, 'student', 20, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(685, 'student', 21, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(686, 'student', 22, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(687, 'student', 23, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(688, 'student', 24, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(689, 'student', 25, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(690, 'student', 26, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(691, 'student', 27, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(692, 'student', 28, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(693, 'student', 29, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(694, 'student', 30, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(695, 'student', 31, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(696, 'student', 32, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(697, 'student', 33, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(698, 'student', 37, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(699, 'student', 38, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(700, 'student', 39, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(701, 'student', 40, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(702, 'student', 41, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(703, 'student', 42, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(704, 'student', 43, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(705, 'student', 44, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(706, 'student', 45, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(707, 'student', 46, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(708, 'student', 47, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(709, 'student', 48, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(710, 'student', 49, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(711, 'student', 50, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(712, 'student', 51, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(713, 'student', 53, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(714, 'student', 54, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(715, 'student', 55, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(716, 'student', 56, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(717, 'student', 57, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(718, 'student', 58, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(719, 'student', 59, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(720, 'student', 60, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(721, 'student', 61, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(722, 'student', 62, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(723, 'student', 64, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(724, 'student', 65, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(725, 'student', 66, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(726, 'student', 67, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(727, 'student', 68, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(728, 'student', 69, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(729, 'student', 70, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(730, 'student', 71, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(731, 'student', 72, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(732, 'student', 73, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(733, 'student', 74, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(734, 'student', 75, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(735, 'student', 76, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(736, 'student', 77, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(737, 'student', 78, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(738, 'student', 79, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(739, 'student', 80, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(740, 'student', 81, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(741, 'student', 82, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(742, 'student', 83, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(743, 'student', 84, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(744, 'student', 85, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(745, 'student', 86, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(746, 'student', 87, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(747, 'student', 88, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(748, 'student', 89, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(749, 'student', 92, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(750, 'student', 93, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(751, 'student', 94, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(752, 'teacher', 14, '2026-04-21', '00:00:00', 'absent', NULL, NULL),
(753, 'teacher', 27, '2026-04-22', '00:00:00', 'absent', NULL, NULL),
(754, 'teacher', 27, '2026-04-24', '00:00:00', 'absent', NULL, NULL),
(755, 'teacher', 24, '2026-04-28', '00:00:00', 'absent', NULL, NULL),
(756, 'teacher', 27, '2026-05-06', '00:00:00', 'absent', NULL, NULL),
(757, 'teacher', 23, '2026-05-06', '00:00:00', 'absent', NULL, NULL),
(758, 'teacher', 27, '2026-05-12', '00:00:00', 'absent', NULL, NULL),
(759, 'teacher', 27, '2026-05-13', '00:00:00', 'absent', NULL, NULL),
(760, 'teacher', 27, '2026-05-14', '00:00:00', 'absent', NULL, NULL),
(761, 'teacher', 25, '2026-05-18', '00:00:00', 'absent', NULL, NULL),
(762, 'teacher', 33, '2026-05-18', '00:00:00', 'absent', NULL, NULL),
(763, 'teacher', 14, '2026-05-18', '00:00:00', 'absent', NULL, NULL),
(764, 'teacher', 31, '2026-05-18', '00:00:00', 'absent', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_details`
--

CREATE TABLE `attendance_details` (
  `id` int(11) NOT NULL,
  `attendance_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `status` enum('present','absent','late','excused') DEFAULT 'present'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_issues`
--

CREATE TABLE `book_issues` (
  `id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('issued','returned') DEFAULT 'issued'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `description`) VALUES
(1, 'GRADE 6', 'English Medium'),
(2, 'GRADE 7', 'English Medium'),
(3, 'GRADE 8', 'English Medium'),
(4, 'GRADE 9', 'English Medium'),
(5, 'GRADE 10', 'English Medium'),
(6, 'GRADE 11', 'English Medium'),
(7, 'GRADE 12 (2027)', 'English Medium'),
(8, 'GRADE 13(2026)', 'English Medium'),
(9, 'GRADE 12(2028)', 'English Medium');

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_subject_teacher`
--

CREATE TABLE `class_subject_teacher` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_subject_teacher`
--

INSERT INTO `class_subject_teacher` (`id`, `class_id`, `subject_id`, `teacher_id`) VALUES
(8, 8, 18, 5),
(9, 5, 1, 5),
(10, 6, 1, 5),
(12, 8, 20, 13),
(13, 6, 2, 13);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `term` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Active','Closed') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_name`, `term`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(2, '1st Term', '1st Term', '2026-03-30', '2026-04-10', 'Active', '2026-03-30 02:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `exam_marks`
--

CREATE TABLE `exam_marks` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `marks_obtained` decimal(5,2) DEFAULT 0.00,
  `grade` varchar(5) DEFAULT NULL,
  `status` enum('Pass','Fail') DEFAULT 'Fail',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_marks`
--

INSERT INTO `exam_marks` (`id`, `exam_id`, `class_id`, `section_id`, `student_id`, `subject_id`, `marks_obtained`, `grade`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 5, 61, 1, 53.00, 'C', 'Pass', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(2, 2, 5, 5, 81, 1, 28.00, 'F', 'Fail', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(3, 2, 5, 5, 65, 1, NULL, NULL, NULL, '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(4, 2, 5, 5, 39, 1, 25.00, 'F', 'Fail', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(5, 2, 5, 5, 37, 1, 44.00, 'D', 'Pass', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(6, 2, 5, 5, 38, 1, 23.00, 'F', 'Fail', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(7, 2, 5, 5, 64, 1, 24.00, 'F', 'Fail', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(8, 2, 5, 5, 66, 1, 39.00, 'D', 'Pass', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(9, 2, 5, 5, 62, 1, 44.00, 'D', 'Pass', '2026-04-21 03:58:28', '2026-04-21 03:58:28'),
(10, 2, 3, 3, 89, 1, 54.00, 'C', 'Pass', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(11, 2, 3, 3, 87, 1, 41.00, 'D', 'Pass', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(12, 2, 3, 3, 53, 1, NULL, NULL, NULL, '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(13, 2, 3, 3, 59, 1, 27.00, 'F', 'Fail', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(14, 2, 3, 3, 88, 1, 28.00, 'F', 'Fail', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(15, 2, 3, 3, 57, 1, 23.00, 'F', 'Fail', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(16, 2, 3, 3, 54, 1, 22.00, 'F', 'Fail', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(17, 2, 3, 3, 55, 1, 16.00, 'F', 'Fail', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(18, 2, 3, 3, 58, 1, 36.00, 'D', 'Pass', '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(19, 2, 3, 3, 56, 1, NULL, NULL, NULL, '2026-04-21 05:29:05', '2026-04-21 05:29:05'),
(20, 2, 5, 5, 61, 3, 77.00, 'A', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(21, 2, 5, 5, 81, 3, 56.00, 'C', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(22, 2, 5, 5, 65, 3, 56.00, 'C', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(23, 2, 5, 5, 39, 3, 62.00, 'B', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(24, 2, 5, 5, 37, 3, 46.00, 'C', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(25, 2, 5, 5, 38, 3, 65.00, 'B', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(26, 2, 5, 5, 64, 3, 70.00, 'B', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(27, 2, 5, 5, 66, 3, 81.00, 'A', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(28, 2, 5, 5, 62, 3, 80.00, 'A', 'Pass', '2026-04-21 05:43:39', '2026-04-21 05:43:39'),
(29, 2, 5, 5, 61, 25, 89.00, 'A', 'Pass', '2026-04-21 05:46:50', '2026-04-21 05:46:50'),
(30, 2, 5, 5, 81, 25, 68.00, 'B', 'Pass', '2026-04-21 05:46:50', '2026-04-21 05:46:50'),
(31, 2, 5, 5, 65, 25, NULL, NULL, NULL, '2026-04-21 05:46:50', '2026-04-21 07:05:45'),
(32, 2, 5, 5, 39, 25, 77.00, 'A', 'Pass', '2026-04-21 05:46:50', '2026-04-21 05:46:50'),
(33, 2, 5, 5, 37, 25, 63.00, 'B', 'Pass', '2026-04-21 05:46:50', '2026-04-21 05:46:50'),
(34, 2, 5, 5, 38, 25, 79.00, 'A', 'Pass', '2026-04-21 05:46:50', '2026-04-21 05:46:50'),
(35, 2, 5, 5, 64, 25, 32.00, 'F', 'Fail', '2026-04-21 05:46:50', '2026-04-21 07:05:45'),
(36, 2, 5, 5, 66, 25, 52.00, 'C', 'Pass', '2026-04-21 05:46:50', '2026-04-21 07:05:45'),
(37, 2, 5, 5, 62, 25, 81.00, 'A', 'Pass', '2026-04-21 05:46:50', '2026-04-21 05:46:50'),
(38, 2, 4, 4, 92, 8, 89.00, 'A', 'Pass', '2026-04-21 05:49:04', '2026-04-21 05:49:04'),
(39, 2, 4, 4, 60, 8, NULL, NULL, NULL, '2026-04-21 05:49:04', '2026-04-21 05:49:04'),
(40, 2, 4, 4, 93, 8, 86.00, 'A', 'Pass', '2026-04-21 05:49:04', '2026-04-21 05:49:04'),
(41, 2, 4, 4, 92, 10, 80.00, 'A', 'Pass', '2026-04-21 05:53:16', '2026-04-21 05:53:16'),
(42, 2, 4, 4, 60, 10, NULL, NULL, NULL, '2026-04-21 05:53:16', '2026-04-21 05:53:16'),
(43, 2, 4, 4, 93, 10, 91.00, 'A', 'Pass', '2026-04-21 05:53:16', '2026-04-21 05:53:16'),
(44, 2, 3, 3, 89, 8, 66.00, 'B', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(45, 2, 3, 3, 87, 8, 86.00, 'A', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(46, 2, 3, 3, 53, 8, NULL, NULL, NULL, '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(47, 2, 3, 3, 59, 8, 75.00, 'A', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(48, 2, 3, 3, 88, 8, 62.00, 'B', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(49, 2, 3, 3, 57, 8, 39.00, 'D', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(50, 2, 3, 3, 54, 8, 62.00, 'B', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(51, 2, 3, 3, 55, 8, 54.00, 'C', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(52, 2, 3, 3, 58, 8, 80.00, 'A', 'Pass', '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(53, 2, 3, 3, 56, 8, NULL, NULL, NULL, '2026-04-21 05:57:47', '2026-04-21 05:57:47'),
(54, 2, 3, 3, 89, 10, 26.00, 'F', 'Fail', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(55, 2, 3, 3, 87, 10, 81.00, 'A', 'Pass', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(56, 2, 3, 3, 53, 10, NULL, NULL, NULL, '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(57, 2, 3, 3, 59, 10, 37.00, 'D', 'Pass', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(58, 2, 3, 3, 88, 10, 44.00, 'D', 'Pass', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(59, 2, 3, 3, 57, 10, 21.00, 'F', 'Fail', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(60, 2, 3, 3, 54, 10, 51.00, 'C', 'Pass', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(61, 2, 3, 3, 55, 10, 23.00, 'F', 'Fail', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(62, 2, 3, 3, 58, 10, 35.00, 'D', 'Pass', '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(63, 2, 3, 3, 56, 10, NULL, NULL, NULL, '2026-04-21 06:03:13', '2026-04-21 06:03:13'),
(64, 2, 2, 2, 51, 8, 60.00, 'B', 'Pass', '2026-04-21 06:08:08', '2026-04-21 06:08:08'),
(65, 2, 2, 2, 49, 8, 66.00, 'B', 'Pass', '2026-04-21 06:08:08', '2026-04-21 06:08:08'),
(66, 2, 2, 2, 51, 10, 51.00, 'C', 'Pass', '2026-04-21 06:14:21', '2026-04-21 06:14:21'),
(67, 2, 2, 2, 49, 10, 65.00, 'B', 'Pass', '2026-04-21 06:14:21', '2026-04-21 06:14:21'),
(68, 2, 1, 1, 47, 8, 88.00, 'A', 'Pass', '2026-04-21 06:16:43', '2026-04-21 06:16:43'),
(69, 2, 1, 1, 48, 8, 70.00, 'B', 'Pass', '2026-04-21 06:16:43', '2026-04-21 06:16:43'),
(70, 2, 6, 6, 72, 3, 58.00, 'C', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(71, 2, 6, 6, 73, 3, 86.00, 'A', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(72, 2, 6, 6, 70, 3, 80.00, 'A', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(73, 2, 6, 6, 80, 3, 59.00, 'C', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(74, 2, 6, 6, 69, 3, 74.00, 'B', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(75, 2, 6, 6, 68, 3, 72.00, 'B', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(76, 2, 6, 6, 71, 3, 66.00, 'B', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(77, 2, 6, 6, 67, 3, 67.00, 'B', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(78, 2, 6, 6, 76, 3, 47.00, 'C', 'Pass', '2026-04-21 06:31:24', '2026-04-21 06:31:24'),
(79, 2, 6, 6, 72, 25, 53.00, 'C', 'Pass', '2026-04-21 06:35:47', '2026-04-21 06:35:47'),
(80, 2, 6, 6, 73, 25, 47.00, 'C', 'Pass', '2026-04-21 06:35:47', '2026-04-21 07:04:16'),
(81, 2, 6, 6, 70, 25, 78.00, 'A', 'Pass', '2026-04-21 06:35:47', '2026-04-21 06:35:47'),
(82, 2, 6, 6, 80, 25, 28.00, 'F', 'Fail', '2026-04-21 06:35:47', '2026-04-21 07:04:16'),
(83, 2, 6, 6, 69, 25, 57.00, 'C', 'Pass', '2026-04-21 06:35:47', '2026-04-21 07:04:16'),
(84, 2, 6, 6, 68, 25, 60.00, 'B', 'Pass', '2026-04-21 06:35:47', '2026-04-21 07:04:16'),
(85, 2, 6, 6, 71, 25, 59.00, 'C', 'Pass', '2026-04-21 06:35:47', '2026-04-21 06:35:47'),
(86, 2, 6, 6, 67, 25, 56.00, 'C', 'Pass', '2026-04-21 06:35:47', '2026-04-21 07:04:16'),
(87, 2, 6, 6, 76, 25, 39.00, 'D', 'Pass', '2026-04-21 06:35:47', '2026-04-21 07:04:16'),
(88, 2, 4, 4, 92, 2, 50.00, 'C', 'Pass', '2026-04-21 07:07:18', '2026-04-21 07:07:18'),
(89, 2, 4, 4, 60, 2, NULL, NULL, NULL, '2026-04-21 07:07:18', '2026-04-21 07:07:18'),
(90, 2, 4, 4, 93, 2, 55.00, 'C', 'Pass', '2026-04-21 07:07:18', '2026-04-21 07:07:18'),
(91, 2, 3, 3, 89, 22, 36.00, 'D', 'Pass', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(92, 2, 3, 3, 87, 22, 57.00, 'C', 'Pass', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(93, 2, 3, 3, 53, 22, 32.00, 'F', 'Fail', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(94, 2, 3, 3, 59, 22, 30.00, 'F', 'Fail', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(95, 2, 3, 3, 88, 22, 36.00, 'D', 'Pass', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(96, 2, 3, 3, 57, 22, 29.00, 'F', 'Fail', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(97, 2, 3, 3, 54, 22, 46.00, 'C', 'Pass', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(98, 2, 3, 3, 55, 22, 35.00, 'D', 'Pass', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(99, 2, 3, 3, 58, 22, 37.00, 'D', 'Pass', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(100, 2, 3, 3, 56, 22, 53.00, 'C', 'Pass', '2026-04-21 07:09:48', '2026-04-21 07:09:48'),
(101, 2, 2, 2, 51, 2, 38.00, 'D', 'Pass', '2026-04-21 07:10:18', '2026-04-21 07:10:18'),
(102, 2, 2, 2, 49, 2, 21.00, 'F', 'Fail', '2026-04-21 07:10:18', '2026-04-21 07:10:18'),
(103, 2, 1, 1, 47, 2, 25.00, 'F', 'Fail', '2026-04-21 07:11:21', '2026-04-21 07:11:21'),
(104, 2, 1, 1, 48, 2, 59.00, 'C', 'Pass', '2026-04-21 07:11:21', '2026-04-21 07:11:21'),
(105, 2, 1, 1, 47, 9, 12.00, 'F', 'Fail', '2026-04-21 07:12:40', '2026-05-17 20:01:07'),
(106, 2, 1, 1, 48, 9, 41.00, 'D', 'Pass', '2026-04-21 07:12:40', '2026-05-17 20:01:01'),
(107, 2, 2, 2, 51, 9, 48.00, 'C', 'Pass', '2026-04-21 07:13:13', '2026-05-17 20:00:59'),
(108, 2, 2, 2, 49, 9, 54.00, 'C', 'Pass', '2026-04-21 07:13:13', '2026-05-17 20:00:55'),
(109, 2, 3, 3, 89, 9, NULL, NULL, NULL, '2026-04-21 07:14:09', '2026-05-17 20:00:51'),
(110, 2, 3, 3, 87, 9, 78.00, 'A', 'Pass', '2026-04-21 07:14:09', '2026-05-17 20:00:47'),
(111, 2, 3, 3, 53, 9, NULL, NULL, NULL, '2026-04-21 07:14:09', '2026-05-17 20:00:42'),
(112, 2, 3, 3, 59, 9, 46.00, 'C', 'Pass', '2026-04-21 07:14:09', '2026-05-17 20:00:39'),
(113, 2, 3, 3, 88, 9, NULL, NULL, NULL, '2026-04-21 07:14:09', '2026-05-17 20:00:36'),
(114, 2, 3, 3, 57, 9, 28.00, 'F', 'Fail', '2026-04-21 07:14:09', '2026-05-17 20:00:34'),
(115, 2, 3, 3, 54, 9, NULL, NULL, NULL, '2026-04-21 07:14:09', '2026-05-17 20:00:05'),
(116, 2, 3, 3, 55, 9, NULL, NULL, NULL, '2026-04-21 07:14:09', '2026-05-17 19:59:58'),
(117, 2, 3, 3, 58, 9, NULL, NULL, NULL, '2026-04-21 07:14:09', '2026-05-17 19:59:50'),
(118, 2, 3, 3, 56, 9, NULL, NULL, NULL, '2026-04-21 07:14:09', '2026-05-17 19:59:54'),
(119, 2, 4, 4, 92, 9, 73.00, 'B', 'Pass', '2026-04-21 07:14:37', '2026-05-17 19:59:45'),
(120, 2, 4, 4, 60, 9, NULL, NULL, NULL, '2026-04-21 07:14:37', '2026-05-17 19:59:43'),
(121, 2, 4, 4, 93, 9, NULL, NULL, NULL, '2026-04-21 07:14:37', '2026-05-17 19:59:41'),
(122, 2, 5, 5, 61, 9, 75.00, 'A', 'Pass', '2026-04-21 07:15:09', '2026-05-17 19:59:31'),
(123, 2, 5, 5, 81, 9, NULL, NULL, NULL, '2026-04-21 07:15:09', '2026-05-17 19:59:29'),
(124, 2, 5, 5, 65, 9, NULL, NULL, NULL, '2026-04-21 07:15:09', '2026-05-17 19:59:26'),
(125, 2, 5, 5, 39, 9, NULL, NULL, NULL, '2026-04-21 07:15:09', '2026-05-17 19:58:56'),
(126, 2, 5, 5, 37, 9, NULL, NULL, NULL, '2026-04-21 07:15:09', '2026-05-17 19:58:54'),
(127, 2, 5, 5, 38, 9, NULL, NULL, NULL, '2026-04-21 07:15:09', '2026-05-17 19:58:52'),
(128, 2, 5, 5, 64, 9, NULL, NULL, NULL, '2026-04-21 07:15:09', '2026-05-17 19:58:47'),
(129, 2, 5, 5, 66, 9, NULL, NULL, NULL, '2026-04-21 07:15:09', '2026-05-17 19:58:45'),
(130, 2, 5, 5, 62, 9, 75.00, 'A', 'Pass', '2026-04-21 07:15:09', '2026-05-17 19:58:42'),
(131, 2, 6, 6, 72, 9, 60.00, 'B', 'Pass', '2026-04-21 07:15:57', '2026-05-17 19:58:40'),
(132, 2, 6, 6, 73, 9, 57.00, 'C', 'Pass', '2026-04-21 07:15:57', '2026-05-17 19:58:38'),
(133, 2, 6, 6, 70, 9, 55.00, 'C', 'Pass', '2026-04-21 07:15:57', '2026-05-17 19:58:33'),
(134, 2, 6, 6, 80, 9, NULL, NULL, NULL, '2026-04-21 07:15:57', '2026-05-17 19:58:29'),
(135, 2, 6, 6, 69, 9, NULL, NULL, NULL, '2026-04-21 07:15:57', '2026-05-17 19:58:27'),
(136, 2, 6, 6, 68, 9, NULL, NULL, NULL, '2026-04-21 07:15:57', '2026-05-17 19:58:25'),
(137, 2, 6, 6, 71, 9, 69.00, 'B', 'Pass', '2026-04-21 07:15:57', '2026-05-17 19:58:22'),
(138, 2, 6, 6, 67, 9, NULL, NULL, NULL, '2026-04-21 07:15:57', '2026-05-17 19:58:19'),
(139, 2, 6, 6, 76, 9, NULL, NULL, NULL, '2026-04-21 07:15:57', '2026-05-17 19:58:15'),
(140, 2, 3, 3, 89, 9, 72.00, 'B', 'Pass', '2026-04-21 07:17:21', '2026-04-21 07:17:21'),
(141, 2, 3, 3, 87, 9, 97.00, 'A', 'Pass', '2026-04-21 07:17:21', '2026-04-21 11:01:45'),
(142, 2, 3, 3, 53, 9, NULL, NULL, NULL, '2026-04-21 07:17:21', '2026-04-21 11:01:45'),
(143, 2, 3, 3, 59, 9, 95.00, 'A', 'Pass', '2026-04-21 07:17:21', '2026-04-21 11:01:45'),
(144, 2, 3, 3, 88, 9, 56.00, 'C', 'Pass', '2026-04-21 07:17:21', '2026-04-21 07:17:21'),
(145, 2, 3, 3, 57, 9, 85.00, 'A', 'Pass', '2026-04-21 07:17:21', '2026-04-21 11:01:45'),
(146, 2, 3, 3, 54, 9, 72.00, 'B', 'Pass', '2026-04-21 07:17:21', '2026-04-21 07:17:21'),
(147, 2, 3, 3, 55, 9, 43.00, 'D', 'Pass', '2026-04-21 07:17:21', '2026-04-21 07:17:21'),
(148, 2, 3, 3, 58, 9, 78.00, 'A', 'Pass', '2026-04-21 07:17:21', '2026-04-21 07:17:21'),
(149, 2, 3, 3, 56, 9, NULL, NULL, NULL, '2026-04-21 07:17:21', '2026-04-21 11:01:45'),
(150, 2, 4, 4, 92, 9, 96.00, 'A', 'Pass', '2026-04-21 07:17:57', '2026-04-21 11:02:10'),
(151, 2, 4, 4, 60, 9, NULL, NULL, NULL, '2026-04-21 07:17:57', '2026-04-21 11:02:10'),
(152, 2, 4, 4, 93, 9, 95.00, 'A', 'Pass', '2026-04-21 07:17:57', '2026-04-21 07:17:57'),
(153, 2, 5, 5, 61, 23, NULL, NULL, NULL, '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(154, 2, 5, 5, 81, 23, NULL, NULL, NULL, '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(155, 2, 5, 5, 65, 23, NULL, NULL, NULL, '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(156, 2, 5, 5, 39, 23, NULL, NULL, NULL, '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(157, 2, 5, 5, 37, 23, NULL, NULL, NULL, '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(158, 2, 5, 5, 38, 23, NULL, NULL, NULL, '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(159, 2, 5, 5, 64, 23, 56.00, 'C', 'Pass', '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(160, 2, 5, 5, 66, 23, 78.00, 'A', 'Pass', '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(161, 2, 5, 5, 62, 23, NULL, NULL, NULL, '2026-04-21 07:19:26', '2026-04-21 07:19:26'),
(162, 2, 6, 6, 72, 23, NULL, NULL, NULL, '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(163, 2, 6, 6, 73, 23, NULL, NULL, NULL, '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(164, 2, 6, 6, 70, 23, NULL, NULL, NULL, '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(165, 2, 6, 6, 80, 23, NULL, NULL, NULL, '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(166, 2, 6, 6, 69, 23, 74.00, 'B', 'Pass', '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(167, 2, 6, 6, 68, 23, 59.00, 'C', 'Pass', '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(168, 2, 6, 6, 71, 23, NULL, NULL, NULL, '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(169, 2, 6, 6, 67, 23, 57.00, 'C', 'Pass', '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(170, 2, 6, 6, 76, 23, 64.00, 'B', 'Pass', '2026-04-21 07:20:29', '2026-04-21 07:20:29'),
(171, 2, 3, 3, 89, 4, 56.00, 'C', 'Pass', '2026-04-21 08:32:21', '2026-05-17 20:10:33'),
(172, 2, 3, 3, 87, 4, NULL, NULL, NULL, '2026-04-21 08:32:21', '2026-05-17 20:10:31'),
(173, 2, 3, 3, 53, 4, 24.00, 'F', 'Fail', '2026-04-21 08:32:21', '2026-05-17 20:10:27'),
(174, 2, 3, 3, 59, 4, NULL, NULL, NULL, '2026-04-21 08:32:21', '2026-05-17 20:10:25'),
(175, 2, 3, 3, 88, 4, 54.00, 'C', 'Pass', '2026-04-21 08:32:21', '2026-05-17 20:10:23'),
(176, 2, 3, 3, 57, 4, NULL, NULL, NULL, '2026-04-21 08:32:21', '2026-05-17 20:10:21'),
(177, 2, 3, 3, 54, 4, 43.00, 'D', 'Pass', '2026-04-21 08:32:21', '2026-05-17 20:10:19'),
(178, 2, 3, 3, 55, 4, 51.00, 'C', 'Pass', '2026-04-21 08:32:21', '2026-05-17 20:10:16'),
(179, 2, 3, 3, 58, 4, 66.00, 'B', 'Pass', '2026-04-21 08:32:21', '2026-05-17 20:10:06'),
(180, 2, 3, 3, 56, 4, 62.00, 'B', 'Pass', '2026-04-21 08:32:21', '2026-05-17 20:10:02'),
(181, 2, 4, 4, 92, 4, NULL, NULL, NULL, '2026-04-21 08:32:59', '2026-05-17 20:10:00'),
(182, 2, 4, 4, 60, 4, NULL, NULL, NULL, '2026-04-21 08:32:59', '2026-05-17 20:09:58'),
(183, 2, 4, 4, 93, 4, 58.00, 'C', 'Pass', '2026-04-21 08:32:59', '2026-05-17 20:09:32'),
(184, 2, 5, 5, 61, 4, NULL, NULL, NULL, '2026-04-21 10:59:36', '2026-05-17 20:09:28'),
(185, 2, 5, 5, 81, 4, 42.00, 'D', 'Pass', '2026-04-21 10:59:36', '2026-05-17 20:09:26'),
(186, 2, 5, 5, 65, 4, 22.00, 'F', 'Fail', '2026-04-21 10:59:36', '2026-05-17 20:09:24'),
(187, 2, 5, 5, 39, 4, 40.00, 'D', 'Pass', '2026-04-21 10:59:36', '2026-05-17 20:09:22'),
(188, 2, 5, 5, 37, 4, 30.00, 'F', 'Fail', '2026-04-21 10:59:36', '2026-05-17 20:09:20'),
(189, 2, 5, 5, 38, 4, 37.00, 'D', 'Pass', '2026-04-21 10:59:36', '2026-05-17 20:09:17'),
(190, 2, 5, 5, 64, 4, 50.00, 'C', 'Pass', '2026-04-21 10:59:36', '2026-05-17 20:09:15'),
(191, 2, 5, 5, 66, 4, 42.00, 'D', 'Pass', '2026-04-21 10:59:36', '2026-05-17 20:09:12'),
(192, 2, 5, 5, 62, 4, NULL, NULL, NULL, '2026-04-21 10:59:36', '2026-05-17 20:09:07'),
(193, 2, 6, 6, 72, 4, NULL, NULL, NULL, '2026-04-21 11:00:40', '2026-05-17 20:08:50'),
(194, 2, 6, 6, 73, 4, NULL, NULL, NULL, '2026-04-21 11:00:40', '2026-05-17 20:08:48'),
(195, 2, 6, 6, 70, 4, NULL, NULL, NULL, '2026-04-21 11:00:40', '2026-05-17 20:08:46'),
(196, 2, 6, 6, 80, 4, 29.00, 'F', 'Fail', '2026-04-21 11:00:40', '2026-05-17 20:08:40'),
(197, 2, 6, 6, 69, 4, 61.00, 'B', 'Pass', '2026-04-21 11:00:40', '2026-05-17 20:08:37'),
(198, 2, 6, 6, 68, 4, 47.00, 'C', 'Pass', '2026-04-21 11:00:40', '2026-05-17 20:08:34'),
(199, 2, 6, 6, 71, 4, NULL, NULL, NULL, '2026-04-21 11:00:40', '2026-05-17 20:08:30'),
(200, 2, 6, 6, 67, 4, 37.00, 'D', 'Pass', '2026-04-21 11:00:40', '2026-05-17 20:08:28'),
(201, 2, 6, 6, 76, 4, 27.00, 'F', 'Fail', '2026-04-21 11:00:40', '2026-05-17 20:08:17'),
(202, 2, 2, 2, 51, 7, 44.00, 'D', 'Pass', '2026-04-21 11:02:54', '2026-04-21 11:02:54'),
(203, 2, 2, 2, 49, 7, 29.00, 'F', 'Fail', '2026-04-21 11:02:54', '2026-04-21 11:02:54'),
(204, 2, 1, 1, 47, 7, 72.00, 'B', 'Pass', '2026-04-21 11:03:36', '2026-04-21 11:03:36'),
(205, 2, 1, 1, 48, 7, 75.00, 'A', 'Pass', '2026-04-21 11:03:36', '2026-04-21 11:03:36'),
(206, 2, 1, 1, 47, 10, 73.00, 'B', 'Pass', '2026-04-21 11:04:12', '2026-04-21 11:04:12'),
(207, 2, 1, 1, 48, 10, 57.00, 'C', 'Pass', '2026-04-21 11:04:12', '2026-04-21 11:04:12'),
(208, 2, 3, 3, 89, 7, 26.00, 'F', 'Fail', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(209, 2, 3, 3, 87, 7, 71.00, 'B', 'Pass', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(210, 2, 3, 3, 53, 7, 38.00, 'D', 'Pass', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(211, 2, 3, 3, 59, 7, 30.00, 'F', 'Fail', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(212, 2, 3, 3, 88, 7, 37.00, 'D', 'Pass', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(213, 2, 3, 3, 57, 7, 31.00, 'F', 'Fail', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(214, 2, 3, 3, 54, 7, 40.00, 'D', 'Pass', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(215, 2, 3, 3, 55, 7, 25.00, 'F', 'Fail', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(216, 2, 3, 3, 58, 7, 30.00, 'F', 'Fail', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(217, 2, 3, 3, 56, 7, 48.00, 'C', 'Pass', '2026-04-21 11:05:38', '2026-04-21 11:05:38'),
(218, 2, 1, 1, 47, 6, 51.00, 'C', 'Pass', '2026-04-22 03:00:47', '2026-04-22 03:00:47'),
(219, 2, 1, 1, 48, 6, 54.00, 'C', 'Pass', '2026-04-22 03:00:47', '2026-04-22 03:00:47'),
(220, 2, 2, 2, 51, 6, 28.00, 'F', 'Fail', '2026-04-22 06:33:24', '2026-04-22 06:33:24'),
(221, 2, 2, 2, 49, 6, 29.00, 'F', 'Fail', '2026-04-22 06:33:24', '2026-04-22 06:33:24'),
(222, 2, 6, 6, 72, 1, 25.00, 'F', 'Fail', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(223, 2, 6, 6, 73, 1, 37.00, 'D', 'Pass', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(224, 2, 6, 6, 70, 1, 36.00, 'D', 'Pass', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(225, 2, 6, 6, 80, 1, 18.00, 'F', 'Fail', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(226, 2, 6, 6, 69, 1, 26.00, 'F', 'Fail', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(227, 2, 6, 6, 68, 1, 22.00, 'F', 'Fail', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(228, 2, 6, 6, 71, 1, 34.00, 'F', 'Fail', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(229, 2, 6, 6, 67, 1, 21.00, 'F', 'Fail', '2026-04-22 14:02:57', '2026-04-22 14:02:57'),
(230, 2, 6, 6, 76, 1, 25.00, 'F', 'Fail', '2026-04-22 14:02:57', '2026-04-22 14:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `marks_obtained` decimal(5,2) DEFAULT NULL,
  `total_marks` decimal(5,2) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_subjects`
--

CREATE TABLE `exam_subjects` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `max_marks` decimal(5,2) DEFAULT NULL,
  `pass_marks` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_subjects`
--

INSERT INTO `exam_subjects` (`id`, `exam_id`, `class_id`, `subject_id`, `max_marks`, `pass_marks`) VALUES
(3, 2, 5, 3, 100.00, 35.00),
(4, 2, 5, 6, 100.00, 35.00),
(5, 2, 5, 5, 100.00, 35.00),
(6, 2, 5, 2, 100.00, 35.00),
(7, 2, 5, 1, 100.00, 35.00);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `payment_method` enum('Cash','Card','Bank Transfer','Online') DEFAULT 'Cash',
  `remarks` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `category_id`, `title`, `amount`, `expense_date`, `payment_method`, `remarks`, `created_by`, `created_at`) VALUES
(2, 6, 'Cleaning', 6200.00, '2026-02-13', 'Cash', '', 1, '2026-02-17 08:02:30'),
(3, 6, 'cleaning', 4000.00, '2026-02-20', 'Cash', 'cleaning', 1, '2026-02-25 03:18:26'),
(6, 8, 'Salary payment for Amal Ashraff (2026-02)', 50000.00, '2026-03-04', 'Cash', '', 1, '2026-03-04 09:17:37'),
(7, 8, 'Salary payment for Amna Hanas (2026-02)', 27500.00, '2026-03-04', 'Bank Transfer', '', 1, '2026-03-04 09:26:19'),
(8, 6, 'cleanig', 3900.00, '2026-03-07', 'Cash', 'cleaning', 1, '2026-03-07 07:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `description`, `created_at`) VALUES
(2, 'ELECTRICITY BILL', 'INSITUTION', '2025-11-12 10:19:57'),
(3, 'ELECTRICITY BILL', 'HOSTEL', '2025-11-12 10:20:16'),
(4, 'WATER BILL', 'INSITUTION', '2025-11-12 10:20:57'),
(5, 'WATER BILL', 'HOSTEL', '2025-11-12 10:21:18'),
(6, 'CLEANING', 'INSITUTION', '2025-11-12 10:22:08'),
(7, 'MARKER AND INK', '', '2025-11-12 10:24:47'),
(8, 'Teacher Salary', 'Monthly teacher salary payments', '2026-02-17 08:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` int(11) NOT NULL,
  `student_fee_id` int(11) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_date` date NOT NULL,
  `method` varchar(50) DEFAULT 'Cash',
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_payments`
--

INSERT INTO `fee_payments` (`id`, `student_fee_id`, `paid_amount`, `payment_date`, `method`, `remarks`, `created_by`, `created_at`) VALUES
(18, 79, 9000.00, '2026-02-16', 'Cash', 'February', 1, '2026-02-16 07:57:28'),
(19, 34, 7000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 08:50:16'),
(20, 40, 8000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 08:50:54'),
(21, 39, 8000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 08:51:26'),
(22, 42, 8000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 08:51:53'),
(23, 82, 8000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 08:53:43'),
(24, 66, 9000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 08:59:40'),
(25, 69, 9000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 09:00:42'),
(26, 77, 9000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 09:01:41'),
(27, 76, 9000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 09:02:12'),
(28, 80, 9000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 09:02:52'),
(29, 35, 7000.00, '2026-02-22', 'Cash', 'Feb Fee', 1, '2026-02-22 11:59:52'),
(30, 38, 8000.00, '2026-02-23', 'Cash', 'Feb Fee', 1, '2026-02-23 06:44:14'),
(31, 72, 9000.00, '2026-02-23', 'Cash', 'Feb Fee', 1, '2026-02-23 07:13:43'),
(32, 71, 9000.00, '2026-02-23', 'Cash', 'Feb Fee', 1, '2026-02-23 08:09:39'),
(33, 44, 8000.00, '2026-02-23', 'Cash', 'Feb Fee', 1, '2026-02-23 08:09:54'),
(34, 78, 9000.00, '2026-02-23', 'Cash', 'Feb Fee', 1, '2026-02-23 08:10:51'),
(35, 37, 7000.00, '2026-02-24', 'Online', 'Feb Fee', 1, '2026-02-24 09:18:05'),
(36, 74, 9000.00, '2026-02-24', 'Online', 'Feb Fee', 1, '2026-02-24 09:18:40'),
(37, 63, 9000.00, '2026-02-24', 'Online', 'Feb Fee', 1, '2026-02-24 09:19:01'),
(38, 67, 9000.00, '2026-02-25', 'Cash', 'Feb Fee', 1, '2026-02-25 07:19:04'),
(39, 43, 8000.00, '2026-02-25', 'Cash', 'Feb Fee', 1, '2026-02-25 07:59:56'),
(40, 41, 8000.00, '2026-02-25', 'Cash', 'Feb Fee', 1, '2026-02-25 10:26:19'),
(41, 84, 7000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:27:20'),
(42, 127, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:28:52'),
(43, 73, 9000.00, '2026-04-21', 'Cash', 'Feb Fee', 1, '2026-04-21 15:29:23'),
(44, 128, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:29:36'),
(45, 107, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:30:39'),
(46, 125, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:31:01'),
(47, 75, 9000.00, '2026-04-21', 'Cash', 'Feb Fee', 1, '2026-04-21 15:31:30'),
(48, 64, 9000.00, '2026-04-21', 'Cash', 'Feb Fee', 1, '2026-04-21 15:31:55'),
(49, 112, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:32:09'),
(50, 124, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:33:10'),
(51, 88, 5000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:33:59'),
(52, 36, 7000.00, '2026-04-21', 'Cash', 'Feb Fee', 1, '2026-04-21 15:34:39'),
(53, 86, 7000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:34:51'),
(54, 94, 8000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:35:27'),
(55, 95, 8000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:35:55'),
(56, 103, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:36:27'),
(57, 101, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:36:55'),
(58, 92, 8000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:37:31'),
(59, 126, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:37:55'),
(60, 68, 9000.00, '2026-04-21', 'Cash', 'Feb Fee', 1, '2026-04-21 15:38:22'),
(61, 89, 8000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:38:47'),
(62, 90, 8000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:39:00'),
(63, 122, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:39:13'),
(64, 109, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:39:31'),
(65, 70, 9000.00, '2026-04-21', 'Cash', 'Feb Fee', 1, '2026-04-21 15:39:47'),
(66, 111, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:39:59'),
(67, 93, 8000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:40:22'),
(68, 108, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:40:37'),
(69, 131, 9000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:40:52'),
(70, 85, 7000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:42:41'),
(71, 87, 7000.00, '2026-04-21', 'Cash', 'mar fee', 1, '2026-04-21 15:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `fee_types`
--

CREATE TABLE `fee_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `default_amount` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_types`
--

INSERT INTO `fee_types` (`id`, `name`, `description`, `default_amount`, `created_at`) VALUES
(1, 'HIGH SCHOOL ADMISSION', '', 15000.00, '2025-11-22 05:37:57'),
(2, 'HIGH SCHOOL FEE  (FULL)', 'THREE SUBJECTS', 10000.00, '2025-11-22 05:39:02'),
(3, 'HIGH SCHOOL FEE', 'TWO SUBJECTS', 7500.00, '2025-11-22 05:39:37'),
(4, 'SERENDIB HOSTEL', '', 20000.00, '2025-11-22 05:45:21'),
(5, 'Monthly Fee Grade 6 & 7', 'Grade 6 & 7', 7000.00, '2026-02-15 18:51:43'),
(6, 'Monthly Fee Grade 8 & 9', 'Grade 8 & 9', 8000.00, '2026-02-15 18:52:07'),
(7, 'Monthly Fee Grade 10 & 11', 'Monthly Fee Grade 6 & 7', 9000.00, '2026-02-15 18:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `homeworks`
--

CREATE TABLE `homeworks` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `first_language` varchar(50) DEFAULT NULL,
  `second_language` varchar(50) DEFAULT NULL,
  `subject_group` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homeworks`
--

INSERT INTO `homeworks` (`id`, `teacher_id`, `subject_id`, `class_id`, `section_id`, `title`, `note`, `attachment`, `due_date`, `created_at`, `first_language`, `second_language`, `subject_group`) VALUES
(7, 5, 18, 8, 11, 'Differentiation graphs', '2017 AL pure question 14. a', NULL, '2026-01-17', '2026-01-10 08:10:51', NULL, NULL, NULL),
(9, 5, 1, 5, 5, 'Perimeter', 'Do all', 'uploads/homework/hw_1768038154_1946.jpg', '2026-01-17', '2026-01-10 09:42:34', NULL, NULL, NULL),
(10, 5, 1, 6, 6, 'Construction', 'Do 5 ,8 and 9', 'uploads/homework/hw_1768042960_2446.jpg', '2026-01-17', '2026-01-10 11:02:40', NULL, NULL, NULL),
(12, 5, 18, 8, 11, 'Applications of Derivative', 'Do all', 'uploads/homework/hw_1768878932_3165.jpg', '2026-01-24', '2026-01-17 07:56:42', NULL, NULL, NULL),
(13, 5, 18, 7, 7, 'Algebra', 'Do all questions', 'uploads/homework/hw_1768830347_4472.jpg', '2026-01-30', '2026-01-19 13:45:47', NULL, NULL, NULL),
(15, 5, 1, 6, 6, 'Log', 'Do all', 'uploads/homework/hw_1769930972_4658.jpg', '2026-02-07', '2026-02-01 07:29:32', NULL, NULL, NULL),
(16, 5, 1, 5, 5, 'Square root', 'Do 2 a all', 'uploads/homework/hw_1769945520_5782.jpg', '2026-02-07', '2026-02-01 11:32:00', NULL, NULL, NULL),
(17, 26, 6, 6, 6, 'Ancient settlement', 'You all can refer the grade 10 history textbook and complete the tute.', 'uploads/homework/hw_1770001371_1281.pdf', '2026-02-10', '2026-02-02 03:02:51', NULL, NULL, NULL),
(19, 14, 2, 5, 5, 'Science - Assignment 01', 'Read the article carefully and answer the questions in your writing book.', 'uploads/homework/hw_1770812405_4663.pdf', '2026-02-18', '2026-02-11 12:19:04', NULL, NULL, NULL),
(20, 5, 1, 5, 5, 'Fraction', 'Do all', 'uploads/homework/hw_1771054302_4635.jpg', '2026-02-15', '2026-02-14 07:31:42', NULL, NULL, NULL),
(21, 5, 1, 6, 6, 'Logarithm', 'Do all', 'uploads/homework/hw_1771069295_7880.jpg', '2026-02-15', '2026-02-14 11:41:35', NULL, NULL, NULL),
(22, 27, 3, 6, 6, 'Tenses', 'Complete all the questions and submit it on or before 19/02/2026', 'uploads/homework/hw_1771086427_8757.pdf', '2026-02-19', '2026-02-14 16:27:07', NULL, NULL, NULL),
(23, 5, 1, 5, 5, 'Fractions 2', 'Do all', 'uploads/homework/hw_1771155288_7373.jpg', '2026-02-21', '2026-02-15 11:34:48', NULL, NULL, NULL),
(24, 5, 1, 6, 6, 'Surface area and volume', 'Do all', 'uploads/homework/hw_1771182454_6696.jpg', '2026-02-21', '2026-02-15 19:07:34', NULL, NULL, NULL),
(25, 5, 1, 5, 5, 'Quadratic', 'Do all', 'uploads/homework/hw_1776493530_1952.jpg', '2026-04-25', '2026-04-18 06:25:30', NULL, NULL, NULL),
(26, 31, 1, 5, 5, 'Factorization of quadratic expresence', '', 'uploads/homework/hw_1776913919_2874.png', '2026-04-25', '2026-04-23 03:11:59', NULL, NULL, NULL),
(27, 31, 1, 6, 6, 'Percentage questions', '', 'uploads/homework/hw_1777350418_2804.pdf', '2026-04-30', '2026-04-28 04:26:58', NULL, NULL, NULL),
(29, 31, 1, 0, 0, 'Maths theorems', 'Write all the theorems you studied until now and the proof also', 'uploads/homework/hw_1777967006_9502.pdf', '2026-05-08', '2026-05-05 07:43:26', NULL, NULL, NULL),
(30, 31, 1, 6, 6, 'Maths complete theorems', 'Write all the theorems and proofs that you have learned until now', 'uploads/homework/hw_1777967316_2033.pdf', '2026-05-08', '2026-05-05 07:48:36', NULL, NULL, NULL),
(31, 21, 22, 6, 6, 'Health - About football', 'Write all the things about football', 'uploads/homework/hw_1777984254_2722.jpg', '2026-05-07', '2026-05-05 12:30:54', NULL, NULL, NULL),
(32, 27, 10, 5, 5, 'Chapter 02 questions', 'You can copy down this questions in your notebook and complete this work.', 'uploads/homework/hw_1777985890_4314.pdf', '2026-05-12', '2026-05-05 12:58:10', NULL, NULL, NULL),
(33, 24, 4, 5, 5, 'சுருக்கம்', 'Grammar book page number 35, question number 2', NULL, '2026-05-07', '2026-05-05 14:47:38', NULL, NULL, NULL),
(34, 24, 4, 4, 4, 'திருக்குறள்', 'Assignment \" about திருவள்ளுவர் & திருக்குறள்', NULL, '2026-05-11', '2026-05-05 14:49:39', NULL, NULL, NULL),
(35, 24, 4, 6, 6, 'Complete the notes', 'இலட்சியமும் சமநோக்கும், மூத்தம்மா, தற்காலக் கவிதைகள்,', NULL, '2026-05-11', '2026-05-05 14:53:05', NULL, NULL, NULL),
(36, 21, 2, 3, 3, 'Science - assigment 1', 'Assignment on preparing chart', 'uploads/homework/hw_1778050402_5923.jpg', '2026-05-11', '2026-05-06 06:53:22', NULL, NULL, NULL),
(37, 21, 2, 3, 3, 'Science - homework on chemical changes', 'For all the activity write down the observation and the conclusion and fill the below table', 'uploads/homework/hw_1778051092_6291.jpg', '2026-05-11', '2026-05-06 07:04:52', NULL, NULL, NULL),
(38, 31, 1, 6, 6, 'Exam paper recomplete', 'Answer all the questions', 'uploads/homework/hw_1778076112_7307.pdf', '2026-05-08', '2026-05-06 14:01:52', NULL, NULL, NULL),
(39, 31, 1, 5, 5, 'Triangle Proof', 'Complete all the answer within given time', 'uploads/homework/hw_1778210073_6176.pdf', '2026-05-09', '2026-05-08 03:14:33', NULL, NULL, NULL),
(41, 14, 2, 5, 5, 'Science - Friction', 'Write the answers in your writing book and submit them.', 'uploads/homework/hw_1778510313_5202.pdf', '2026-05-13', '2026-05-11 14:38:33', NULL, NULL, NULL),
(42, 26, 6, 6, 6, 'The ancient society of Sri Lanka', 'Refer your grade 10 history text book to complete the tute. try to do the past paper questions on your own', 'uploads/homework/hw_1778512511_8724.pdf', '2026-05-17', '2026-05-11 15:15:11', NULL, NULL, NULL),
(43, 26, 6, 6, 6, 'Sources of studying history', 'refer your grade 10 history textbook to complete the tute. try to do the attached past paper questions on your own.', 'uploads/homework/hw_1778512956_2132.pdf', '2026-05-18', '2026-05-11 15:22:36', NULL, NULL, NULL),
(44, 26, 6, 5, 5, 'ancient settlements', 'refer your history textbooks and notes to complete the tute', 'uploads/homework/hw_1778519669_9249.pdf', '2026-05-18', '2026-05-11 17:14:29', NULL, NULL, NULL),
(45, 21, 22, 6, 6, 'Health - outdoor activity', 'Write the question and answer', 'uploads/homework/hw_1778592503_1247.jpg', '2026-05-14', '2026-05-12 13:28:23', NULL, NULL, NULL),
(46, 24, 4, 5, 5, 'parathiyar suyasarithai', '', 'uploads/homework/hw_1778598665_5690.pdf', '2026-12-05', '2026-05-12 15:11:05', NULL, NULL, NULL),
(54, 21, 22, 3, 3, 'Health - exercise', 'Write the question and answers', 'uploads/homework/hw_1778655453_5127.jpg', '2026-05-15', '2026-05-13 06:57:33', NULL, NULL, NULL),
(55, 21, 2, 3, 3, 'Science -activity', 'Write the material and methods observation and the conclusion', 'uploads/homework/hw_1778655505_4324.jpg', '2026-05-15', '2026-05-13 06:58:25', NULL, NULL, NULL),
(56, 14, 13, 6, 6, 'Art - Embekke Dewalaya', 'Relative notes have been uploaded to the notes section', 'uploads/homework/hw_1778771725_6565.pdf', '2026-05-16', '2026-05-13 11:09:37', NULL, NULL, NULL),
(58, 26, 6, 2, 2, 'King Manawamma', 'you may refer the notes and textbook', 'uploads/homework/hw_1778683896_5979.pdf', '2026-05-15', '2026-05-13 14:51:36', NULL, NULL, NULL),
(59, 25, 14, 6, 6, 'Context paper 1', 'Do all the questions', 'uploads/homework/hw_1778685357_2305.pdf', '2026-05-15', '2026-05-13 15:15:57', NULL, NULL, NULL),
(60, 21, 2, 3, 3, 'Science - activity', 'Write the materials method diagram and the observation and the conclusion', 'uploads/homework/hw_1778726903_9576.jpg', '2026-05-18', '2026-05-14 02:48:23', NULL, NULL, NULL),
(61, 31, 1, 6, 6, 'Stock Market', 'These are complete questions in the chapter on the stock market. Complete the questions.', 'uploads/homework/hw_1778737633_4645.pdf', '2026-05-17', '2026-05-14 05:47:13', NULL, NULL, NULL),
(62, 21, 22, 5, 5, 'Health - exercise', 'Write the answer only', 'uploads/homework/hw_1778741020_3916.jpg', '2026-05-18', '2026-05-14 06:43:40', NULL, NULL, NULL),
(63, 19, 12, 5, 5, 'Assets and liabilities', '', 'uploads/homework/hw_1778747119_7125.jpeg', '2026-05-18', '2026-05-14 08:25:19', NULL, NULL, NULL),
(64, 19, 12, 6, 6, 'Assets and liabilities', '', 'uploads/homework/hw_1778747147_3231.jpeg', '2026-05-18', '2026-05-14 08:25:47', NULL, NULL, NULL),
(65, 23, 5, 1, 1, 'al - islam', 'students, please submit the answers through LMS ,and bring the book to school.', 'uploads/homework/hw_1778770152_7776.pdf', '2026-05-16', '2026-05-14 14:49:12', NULL, NULL, NULL),
(66, 14, 13, 5, 5, 'Art - Embekke Dewalaya', 'Relative notes have been uploaded to the notes section', 'uploads/homework/hw_1778771763_1447.pdf', '2026-05-16', '2026-05-14 15:16:03', NULL, NULL, NULL),
(67, 23, 7, 3, 3, 'unit 1', 'please answer all the questions,submit the answers here ,and bring the book to school.', 'uploads/homework/hw_1778773011_6906.pdf', '2026-05-18', '2026-05-14 15:36:51', NULL, NULL, NULL),
(68, 27, 10, 5, 5, 'Unit Revision', 'Dear students,                                                      you can either take a printout or write the questions number and write only the answers in your writing book.', 'uploads/homework/hw_1778774182_7042.pdf', '2026-05-18', '2026-05-14 15:56:22', NULL, NULL, NULL),
(69, 26, 6, 6, 6, '1818 struggle', '', 'uploads/homework/hw_1778774334_7325.pdf', '2026-05-17', '2026-05-14 15:58:54', NULL, NULL, NULL),
(70, 27, 3, 5, 5, 'Questions', '', 'uploads/homework/hw_1778775271_2648.pdf', '2026-05-17', '2026-05-14 16:14:31', NULL, NULL, NULL),
(71, 27, 3, 6, 6, 'Questions', '', 'uploads/homework/hw_1778775292_6895.pdf', '2026-05-17', '2026-05-14 16:14:52', NULL, NULL, NULL),
(72, 31, 1, 5, 5, 'LCM for Algebraic Expression', 'Complete all the work', 'uploads/homework/hw_1778816074_6193.pdf', '2026-05-16', '2026-05-15 03:34:34', NULL, NULL, NULL),
(73, 25, 3, 2, 2, 'English worksheet 1', 'Do all the questions', 'uploads/homework/hw_1778919125_4976.jpg', '2026-05-18', '2026-05-16 08:12:05', NULL, NULL, NULL),
(74, 21, 22, 6, 6, 'Health -questions', 'Write the question and answer', 'uploads/homework/hw_1778929055_9959.jpg', '2026-05-18', '2026-05-16 10:57:35', NULL, NULL, NULL),
(75, 25, 14, 6, 6, 'Essay question 1', '', 'uploads/homework/hw_1778934399_9287.jpg', '2026-05-18', '2026-05-16 12:26:39', NULL, NULL, NULL),
(76, 25, 14, 5, 5, 'Essay Question 01', '', 'uploads/homework/hw_1778934477_1542.jpg', '2026-05-18', '2026-05-16 12:27:57', NULL, NULL, NULL),
(77, 26, 6, 3, 3, 'Kandyan kingdom', 'you may refer textbook', 'uploads/homework/hw_1778935820_2394.pdf', '2026-05-18', '2026-05-16 12:50:20', NULL, NULL, NULL),
(78, 33, 5, 5, 5, 'Islam : Ibaadah', '', 'uploads/homework/hw_1778936429_2989.pdf', '2026-05-18', '2026-05-16 13:00:29', NULL, NULL, NULL),
(79, 33, 5, 6, 6, 'Islam : Ibadah', '', 'uploads/homework/hw_1778936486_3877.pdf', '2026-05-18', '2026-05-16 13:01:26', NULL, NULL, NULL),
(80, 33, 1, 3, 3, 'Math : HCF', '', 'uploads/homework/hw_1778937360_2462.pdf', '2026-05-18', '2026-05-16 13:16:00', NULL, NULL, NULL),
(81, 14, 13, 6, 6, 'Art', 'Draw the suitable picture and submit', 'uploads/homework/hw_1778938607_8889.png', '2026-05-19', '2026-05-16 13:36:47', NULL, NULL, NULL),
(82, 26, 7, 4, 4, 'social security', '', 'uploads/homework/hw_1779114717_8952.pdf', '2026-05-20', '2026-05-18 14:31:57', NULL, NULL, NULL),
(83, 31, 1, 5, 5, 'Unit exam', 'complete', 'uploads/homework/hw_1779158053_9429.pdf', '2026-05-20', '2026-05-19 02:34:13', NULL, NULL, NULL),
(84, 31, 1, 6, 6, 'unit exam', 'complete', 'uploads/homework/hw_1779158135_1815.pdf', '2026-05-20', '2026-05-19 02:35:35', NULL, NULL, NULL),
(85, 31, 1, 6, 6, 'Practice This QA', 'complete', 'uploads/homework/hw_1779167029_1500.png', '2026-05-20', '2026-05-19 05:03:49', NULL, NULL, NULL),
(86, 27, 3, 6, 6, 'Unit 09 - Enigma', 'Dear students,\r\n\r\nThose who have the English workbook may complete the activity in the workbook itself. Students who do not have the workbook may either copy the activity into their books or obtain a photocopy and complete it.\r\n\r\nPlease bring your completed answer script to school on Friday.', 'uploads/homework/hw_1779187886_6715.pdf', '2026-05-22', '2026-05-19 16:21:26', NULL, NULL, NULL),
(87, 27, 10, 4, 4, 'Unit Revision', 'You may either copy these questions into your book and answer them, or take a printout and complete them directly on it.', 'uploads/homework/hw_1779189224_6601.pdf', '2026-05-24', '2026-05-19 16:43:44', NULL, NULL, NULL),
(88, 27, 10, 4, 4, 'Work book questions', 'Dear students,\r\n\r\nThose who have the workbook may complete the activity in the workbook itself. Students who do not have the workbook may either copy the activity into their books or obtain a photocopy and complete it.\r\n\r\nPlease bring your completed answer script to school on Friday.', 'uploads/homework/hw_1779189812_9522.pdf', '2026-05-25', '2026-05-19 16:53:32', NULL, NULL, NULL),
(89, 33, 1, 4, 4, 'Math : Axiom 4&5', 'Dear students,\r\nplease complete Question 1 and Question 3 only.', 'uploads/homework/hw_1779190668_7363.pdf', '2026-05-20', '2026-05-19 17:07:48', NULL, NULL, NULL),
(90, 27, 10, 1, 1, 'Unit Revision', '', 'uploads/homework/hw_1779196200_8774.pdf', '2026-05-23', '2026-05-19 18:40:00', NULL, NULL, NULL),
(91, 27, 23, 6, 6, 'Operator Precedence', '', 'uploads/homework/hw_1779197665_7384.pdf', '2026-05-23', '2026-05-19 19:04:25', NULL, NULL, NULL),
(92, 21, 2, 3, 3, 'Science - project', 'Copy and paste', 'uploads/homework/hw_1779262103_4600.jpg', '2026-05-22', '2026-05-20 12:58:23', NULL, NULL, NULL),
(93, 33, 1, 3, 3, 'Math : factors', 'students,Do the\r\nQuestion 1 - full\r\n 2.  Question 2 - do a) i-v and b) i-v only', 'uploads/homework/hw_1779287075_9733.pdf', '2026-05-22', '2026-05-20 19:54:35', NULL, NULL, NULL),
(94, 26, 6, 2, 2, 'king Sena', 'you may refer your textbook and notes', 'uploads/homework/hw_1779293032_6885.pdf', '2026-05-23', '2026-05-20 21:33:52', NULL, NULL, NULL),
(95, 23, 7, 2, 2, 'Activity 1.17', '', 'uploads/homework/hw_1779331513_7951.jpg', '2026-05-22', '2026-05-21 08:15:13', NULL, NULL, NULL),
(96, 26, 6, 1, 1, 'Civilizations', '', 'uploads/homework/hw_1779380518_8915.pdf', '2026-05-25', '2026-05-21 21:51:58', NULL, NULL, NULL),
(97, 5, 1, 5, 5, 'Equations', 'Do 1. b,d,f,g,h,j', 'uploads/homework/hw_1779521895_1767.jpg', '2026-05-24', '2026-05-23 13:08:15', NULL, NULL, NULL),
(98, 26, 6, 3, 3, 'Kandyan kingdom 2', '', 'uploads/homework/hw_1779634357_4210.pdf', '2026-05-27', '2026-05-24 20:22:37', NULL, NULL, NULL),
(99, 26, 6, 6, 6, 'National renaissance in sri Lanka', '', 'uploads/homework/hw_1779634659_1271.pdf', '2026-05-27', '2026-05-24 20:27:39', NULL, NULL, NULL),
(100, 33, 1, 3, 3, 'Math : Factors 7.3', 'Please do all the questions in Question Number 1, and try to do the first two questions in Question Number 2', 'uploads/homework/hw_1779715057_3996.pdf', '2026-05-27', '2026-05-25 18:47:37', NULL, NULL, NULL),
(101, 24, 4, 4, 4, 'தமிழ் \"விளம்பரம்\"', 'விளம்பரம் ஒன்றை வடிவமைக்குக', 'uploads/homework/hw_1779766905_7836.jpg', '2026-06-01', '2026-05-26 09:11:45', NULL, NULL, NULL),
(102, 32, 19, 3, 3, 'Sinhala = කාලසටහන පිරවීම', 'Write down these questions in your writing books & answer all the questions.', 'uploads/homework/hw_1780138704_5291.jpg', '2026-06-02', '2026-05-30 16:28:24', NULL, NULL, NULL),
(103, 33, 1, 4, 4, 'Math : vertically opposite angles', 'Do all the questions in review exercise and in activity 8.2 do only 1,2 and 3rd questions.', 'uploads/homework/hw_1780143255_6822.pdf', '2026-06-02', '2026-05-30 17:44:15', NULL, NULL, NULL),
(104, 31, 1, 6, 6, 'Equation', 'Complete fully', 'uploads/homework/hw_1780289739_4104.pdf', '2026-06-03', '2026-06-01 10:25:39', NULL, NULL, NULL),
(105, 33, 5, 6, 6, 'Islam : Zakah', '', 'uploads/homework/hw_1780319201_2819.pdf', '2026-06-02', '2026-06-01 18:36:41', NULL, NULL, NULL),
(106, 33, 1, 3, 3, 'Math : factors (7.4)', 'Question 1 – do the first 5 questions (i to v) only\r\nQuestion 2 – do the first 3 questions (i to iii) only  \r\nNo need to do Question 3', 'uploads/homework/hw_1780320360_7590.pdf', '2026-06-02', '2026-06-01 18:56:00', NULL, NULL, NULL),
(107, 33, 5, 5, 5, 'Islam : Sifatussalah', '', 'uploads/homework/hw_1780322479_4806.pdf', '2026-06-03', '2026-06-01 19:31:19', NULL, NULL, NULL),
(108, 26, 6, 4, 4, 'British', '', 'uploads/homework/hw_1780323610_1622.pdf', '2026-06-04', '2026-06-01 19:50:10', NULL, NULL, NULL),
(109, 27, 10, 1, 1, 'Operating system and  File management Questions', 'Dear students,\r\nYou can either take a printout or copy it in your book and complete it.', 'uploads/homework/hw_1780328174_3775.pdf', '2026-06-05', '2026-06-01 21:06:14', NULL, NULL, NULL),
(110, 27, 10, 3, 3, 'Word processing - theory', 'Dear Students,\r\nYou may write the answers in your exercise book.', 'uploads/homework/hw_1780329099_1733.pdf', '2026-06-06', '2026-06-01 21:21:39', NULL, NULL, NULL),
(111, 23, 5, 4, 4, 'unit 3-5', 'students,copy all the questions into your notebook and answer them using the notes.', 'uploads/homework/hw_1780330508_4017.pdf', '2026-06-03', '2026-06-01 21:45:08', NULL, NULL, NULL),
(112, 26, 7, 4, 4, 'child authority', '', 'uploads/homework/hw_1780331646_1457.pdf', '2026-06-04', '2026-06-01 22:04:06', NULL, NULL, NULL),
(113, 24, 4, 6, 6, 'விளம்பரம்', 'விளம்பரம் ஒன்றை வடிவமைக்கவும்', 'uploads/homework/hw_1780332920_9442.jpg', '2026-06-03', '2026-06-01 22:25:20', NULL, NULL, NULL),
(114, 27, 3, 5, 5, 'Essay Writing', 'Choose one of the topics and complete the work.', 'uploads/homework/hw_1780332965_7062.pdf', '2026-06-08', '2026-06-01 22:26:05', NULL, NULL, NULL),
(115, 24, 4, 5, 5, 'விளம்பரம்', '', 'uploads/homework/hw_1780332975_3495.jpg', '2026-06-03', '2026-06-01 22:26:15', NULL, NULL, NULL),
(116, 26, 6, 5, 5, 'statecraft', '', 'uploads/homework/hw_1780335208_9375.pdf', '2026-06-04', '2026-06-01 23:03:28', NULL, NULL, NULL),
(117, 23, 5, 3, 3, 'unit 1-10', 'please complete only the exercises in units 1-6 except unit 4', 'uploads/homework/hw_1780372877_3001.pdf', '2026-06-04', '2026-06-02 09:31:17', NULL, NULL, NULL),
(118, 32, 19, 4, 4, '06.පාඩම . නරිබෑනා', 'Answer to all the questions\r\n 01 ක්‍රියාකාරකම,03 සහ 04', 'uploads/homework/hw_1780382278_7849.jpg', '2026-06-05', '2026-06-02 12:07:58', NULL, NULL, NULL),
(119, 25, 14, 6, 6, 'Essay Question (The Earthen Goblet)', '', 'uploads/homework/hw_1780386788_9055.jpg', '2026-06-04', '2026-06-02 13:23:08', NULL, NULL, NULL),
(120, 23, 7, 1, 1, 'Activity 17', 'Write the questions in your notebook', 'uploads/homework/hw_1780388147_2125.jpg', '2026-06-04', '2026-06-02 13:45:47', NULL, NULL, NULL),
(121, 31, 1, 6, 6, 'Maths term paper', 'Complete the paper', 'uploads/homework/hw_1780388331_1444.pdf', '2026-06-06', '2026-06-02 13:48:51', NULL, NULL, NULL),
(122, 23, 7, 1, 1, 'Activity 15', 'Prepare the code of rules using an A4 sheet', 'uploads/homework/hw_1780388557_6199.jpeg', '2026-06-04', '2026-06-02 13:52:37', NULL, NULL, NULL),
(123, 14, 20, 6, 6, 'Art - Table cloth', '', 'uploads/homework/hw_1780406950_1383.png', '2026-06-04', '2026-06-02 18:59:10', NULL, NULL, NULL),
(124, 29, 24, 6, 6, 'කාළගුණ වාර්තා සකස් කිරීම', 'ක්‍රියාකාරකම 2 සහ ගංවතුර නිවේදන ආශ්‍රීත කාළගුණ වාර්තාවක් සකස් කරන්න.', 'uploads/homework/hw_1780408396_4234.jpg', '2026-06-02', '2026-06-02 19:23:16', NULL, NULL, NULL),
(125, 14, 2, 5, 5, 'Science - Unit 6', 'Write answers in your writing book and submit', 'uploads/homework/hw_1780408972_2068.pdf', '2026-06-08', '2026-06-02 19:32:52', NULL, NULL, NULL),
(126, 26, 6, 3, 3, 'Kandyan kingdom 3', '', 'uploads/homework/hw_1780409461_1490.pdf', '2026-06-05', '2026-06-02 19:41:01', NULL, NULL, NULL),
(127, 26, 6, 6, 6, 'Buddhist renaissance', '', 'uploads/homework/hw_1780409529_1938.pdf', '2026-06-05', '2026-06-02 19:42:09', NULL, NULL, NULL),
(128, 26, 6, 1, 1, 'Indus valley Civilization 2', '', 'uploads/homework/hw_1780410030_7275.pdf', '2026-06-04', '2026-06-02 19:50:30', NULL, NULL, NULL),
(129, 26, 6, 4, 4, 'British 2', '', 'uploads/homework/hw_1780410480_4281.pdf', '2026-06-05', '2026-06-02 19:58:00', NULL, NULL, NULL),
(130, 33, 1, 1, 1, 'Maths : Quadrilateral', '', 'uploads/homework/hw_1780410864_2434.pdf', '2026-06-04', '2026-06-02 20:04:24', NULL, NULL, NULL),
(131, 33, 1, 4, 4, 'Math : Angles related to parallel lines', '', 'uploads/homework/hw_1780411464_2359.pdf', '2026-06-04', '2026-06-02 20:14:24', NULL, NULL, NULL),
(132, 32, 19, 4, 4, '07. ලෑලි පාලම', 'Write down these questions & write answers to all.', 'uploads/homework/hw_1780462116_2271.jpg', '2026-06-06', '2026-06-03 10:18:36', NULL, NULL, NULL),
(133, 25, 14, 5, 5, 'Essay Question on \'The Lahore attack\'', '', 'uploads/homework/hw_1780470278_8930.jpg', '2026-06-05', '2026-06-03 12:34:38', NULL, NULL, NULL),
(134, 33, 1, 1, 1, 'Math : Decimals', '', 'uploads/homework/hw_1780492958_6704.pdf', '2026-06-04', '2026-06-03 18:52:38', NULL, NULL, NULL),
(135, 33, 1, 3, 3, 'Math : Square Root', '', 'uploads/homework/hw_1780494511_4949.pdf', '2026-06-05', '2026-06-03 19:18:31', NULL, NULL, NULL),
(136, 27, 10, 2, 2, 'Security of the Computer  System', 'Complete this work, in your ICT workbook', 'uploads/homework/hw_1780498603_9807.pdf', '2026-06-08', '2026-06-03 20:26:43', NULL, NULL, NULL),
(137, 26, 6, 5, 5, 'evolution of political power in Sri Lanka', 'take a print out of this tute. you may refer the textbook and complete the tute.', 'uploads/homework/hw_1780502372_5434.pdf', '2026-06-11', '2026-06-03 20:42:25', NULL, NULL, NULL),
(139, 19, 12, 5, 5, 'Cash book', 'Activity in page 2 of Cash book and petty cash book tute', 'uploads/homework/hw_1780500434_3910.jpeg', '2026-06-05', '2026-06-03 20:57:14', NULL, NULL, NULL),
(140, 19, 12, 6, 6, 'Cash book', 'Activity in page no 2 of cash book and petty cash book tute', 'uploads/homework/hw_1780500507_9148.jpeg', '2026-06-05', '2026-06-03 20:58:27', NULL, NULL, NULL),
(141, 27, 3, 6, 6, 'Comprehension question', 'Dear Students,\r\n\r\nYou may write only the question number and the answer in your writing book. There is no need to take a printout.', 'uploads/homework/hw_1780501353_3260.pdf', '2026-06-09', '2026-06-03 21:12:33', NULL, NULL, NULL),
(142, 24, 4, 4, 4, 'ல, ழ, ள பொருள் வேறுபாடு', '', 'uploads/homework/hw_1780501354_5751.pdf', '2026-06-10', '2026-06-03 21:12:34', NULL, NULL, NULL),
(143, 33, 5, 6, 6, 'Islam past paper 2016 - 2018 (Zakah)', '', 'uploads/homework/hw_1780504613_9603.pdf', '2026-06-05', '2026-06-03 22:06:53', NULL, NULL, NULL),
(144, 23, 7, 2, 2, 'Activity 2.3', '', 'uploads/homework/hw_1780541022_1241.jpeg', '2026-06-06', '2026-06-04 08:13:42', NULL, NULL, NULL),
(145, 33, 1, 4, 4, 'Math : Liquid measurements', '', 'uploads/homework/hw_1780547616_1519.pdf', '2026-06-05', '2026-06-04 10:03:36', NULL, NULL, NULL),
(146, 27, 10, 3, 3, 'Word processing practical part I', 'Read the complete document and answer the questions, and please contact me if you have any doubts.', 'uploads/homework/hw_1780568455_3405.pdf', '2026-06-26', '2026-06-04 15:50:55', NULL, NULL, NULL),
(147, 33, 5, 5, 5, 'Past Paper  2016-2017 MCQ', '', 'uploads/homework/hw_1780581092_8834.pdf', '2026-06-08', '2026-06-04 19:21:32', NULL, NULL, NULL),
(148, 27, 8, 4, 4, 'Chapter 01', '', 'uploads/homework/hw_1780582224_1917.pdf', '2026-06-11', '2026-06-04 19:40:24', NULL, NULL, NULL),
(149, 14, 2, 5, 5, 'Science - Plant & Animal cell', 'Refer the instructions mentioned in the PDF clearly and do the work.', 'uploads/homework/hw_1780757273_7370.pdf', '2026-06-13', '2026-06-06 20:17:53', NULL, NULL, NULL),
(150, 5, 1, 6, 6, '2025 volume question', 'Do question no 4', 'uploads/homework/hw_1780817479_7498.jpg', '2026-06-13', '2026-06-07 13:01:19', NULL, NULL, NULL),
(151, 33, 1, 4, 4, 'Math : Liquid measurements', 'Dear students, No need to write the questions', 'uploads/homework/hw_1780840091_6852.pdf', '2026-06-09', '2026-06-07 19:18:11', NULL, NULL, NULL),
(152, 33, 1, 1, 1, 'Math : Decimals', '', 'uploads/homework/hw_1780841068_3436.pdf', '2026-06-09', '2026-06-07 19:34:28', NULL, NULL, NULL),
(153, 25, 3, 1, 1, 'English - Exercise 1', '', 'uploads/homework/hw_1780853343_6568.jpg', '2026-06-09', '2026-06-07 22:59:03', NULL, NULL, NULL),
(154, 25, 3, 3, 3, 'Exercise 1', '', 'uploads/homework/hw_1780853633_2632.jpg', '2026-06-09', '2026-06-07 23:03:53', NULL, NULL, NULL),
(155, 29, 9, 1, 1, 'උක්ත අනුක්ත භේදය', 'ක්‍රියාකාරකම්', 'uploads/homework/hw_1780886918_7823.jpg', '2026-06-10', '2026-06-08 08:18:38', NULL, NULL, NULL),
(156, 31, 1, 6, 6, 'Fraction past paper questions', 'Try to do 2019,2021 and 2022 past paper also', 'uploads/homework/hw_1780893663_7865.pdf', '2026-06-10', '2026-06-08 10:11:03', NULL, NULL, NULL),
(157, 23, 5, 2, 2, 'units 1-9', 'please write down all the questions in your notebook.', 'uploads/homework/hw_1780903385_6096.pdf', '2026-06-12', '2026-06-08 12:53:05', NULL, NULL, NULL),
(158, 29, 9, 4, 4, 'රචනා පුහුණුව', '\"මත් උවදුර තුරන් කරමු\"යන මාතෘකාව යටතේ වචන 150-200 ඇතුළත් රචනාවක් ලියන්න.', 'uploads/homework/hw_1780904094_7529.jpg', '2026-06-11', '2026-06-08 13:04:54', NULL, NULL, NULL),
(159, 33, 1, 1, 1, 'Math : Decimals', '', 'uploads/homework/hw_1780908083_8653.pdf', '2026-06-10', '2026-06-08 14:11:23', NULL, NULL, NULL),
(160, 33, 1, 1, 1, 'Math : Number patterns', '', 'uploads/homework/hw_1780908188_5584.jpeg', '2026-06-09', '2026-06-08 14:13:08', NULL, NULL, NULL),
(161, 33, 1, 2, 2, 'Math : Fractions', '', 'uploads/homework/hw_1780917146_4525.jpeg', '2026-06-09', '2026-06-08 16:42:26', NULL, NULL, NULL),
(162, 33, 1, 3, 3, 'Math : Mass', '', 'uploads/homework/hw_1780917475_7870.jpeg', '2026-06-10', '2026-06-08 16:47:55', NULL, NULL, NULL),
(163, 33, 1, 3, 3, 'Math : mass ( addition and subtraction)', '', 'uploads/homework/hw_1780917636_5061.pdf', '2026-06-10', '2026-06-08 16:50:36', NULL, NULL, NULL),
(164, 26, 7, 4, 4, 'Contemporary Changes 1', '', 'uploads/homework/hw_1780918211_5355.pdf', '2026-06-11', '2026-06-08 17:00:11', NULL, NULL, NULL),
(165, 26, 6, 2, 2, 'Regional Administration', '', 'uploads/homework/hw_1780919845_3008.pdf', '2026-06-11', '2026-06-08 17:27:25', NULL, NULL, NULL),
(166, 26, 6, 1, 1, 'EGYPTIAN CIVILIZATION', '', 'uploads/homework/hw_1780920611_7595.pdf', '2026-06-11', '2026-06-08 17:40:11', NULL, NULL, NULL),
(167, 26, 6, 1, 1, 'REVISION EXERCISE', '', 'uploads/homework/hw_1780921276_2184.pdf', '2026-06-11', '2026-06-08 17:51:16', NULL, NULL, NULL),
(168, 26, 6, 3, 3, 'Kandyan kingdom 4', '', 'uploads/homework/hw_1780924201_2641.pdf', '2026-06-11', '2026-06-08 18:40:01', NULL, NULL, NULL),
(169, 33, 5, 6, 6, 'Islam : zakah (2019 - 2021)', '', 'uploads/homework/hw_1780926560_3073.pdf', '2026-06-10', '2026-06-08 19:19:20', NULL, NULL, NULL),
(170, 33, 5, 6, 6, 'Islam : zakah (2022 - 2025)', '', 'uploads/homework/hw_1780926690_7395.pdf', '2026-06-10', '2026-06-08 19:21:30', NULL, NULL, NULL),
(171, 33, 1, 4, 4, 'Math : Problem solving', '', 'uploads/homework/hw_1780929844_4158.pdf', '2026-06-10', '2026-06-08 20:14:04', NULL, NULL, NULL),
(172, 27, 3, 6, 6, 'For a better tomorrow', 'Dear students,\r\n\r\nIf you have the textbook, you may complete this activity using the book. This lesson is from Chapter 04, pages 44–47.\r\n\r\nStudents who do not have the textbook may simply write down the answers in their exercise books.', 'uploads/homework/hw_1780931769_6952.pdf', '2026-06-12', '2026-06-08 20:46:09', NULL, NULL, NULL),
(173, 27, 10, 4, 4, 'Excel', 'Dear students, \r\nIf you are writing this in your note book can write the question and the correct answer only.', 'uploads/homework/hw_1780937955_3034.pdf', '2026-06-14', '2026-06-08 22:29:15', NULL, NULL, NULL),
(174, 27, 23, 6, 6, 'Pascal Programming', 'Dear students, \r\nIf you are writing it in your notebook write the question number and answers only.', 'uploads/homework/hw_1780941466_3822.pdf', '2026-06-15', '2026-06-08 23:27:46', NULL, NULL, NULL),
(175, 25, 3, 4, 4, 'Advertisement 1', '', 'uploads/homework/hw_1780973124_5293.jpg', '2026-06-10', '2026-06-09 08:15:24', NULL, NULL, NULL),
(176, 25, 3, 2, 2, 'Exercise 2', '', 'uploads/homework/hw_1780974902_6955.jpg', '2026-06-10', '2026-06-09 08:45:02', NULL, NULL, NULL),
(177, 33, 1, 4, 4, 'Math : proportions', '', 'uploads/homework/hw_1780976405_9822.pdf', '2026-06-10', '2026-06-09 09:10:05', NULL, NULL, NULL),
(178, 32, 19, 3, 3, 'අවුරුදු උත්සවය', 'Write answers to all the questions given below', 'uploads/homework/hw_1780982683_8179.jpg', '2026-06-11', '2026-06-09 10:54:43', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `homework_submissions`
--

CREATE TABLE `homework_submissions` (
  `id` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homework_submissions`
--

INSERT INTO `homework_submissions` (`id`, `homework_id`, `student_id`, `file_path`, `note`, `submitted_at`) VALUES
(3, 8, 37, 'uploads/homework_answers/ans_8_1768036452.pdf', 'did all', '2026-01-10 09:14:12'),
(4, 11, 35, NULL, '', '2026-01-10 11:22:01'),
(5, 9, 40, 'uploads/homework_answers/ans_9_1768380786.jpg', '', '2026-01-14 08:53:06'),
(6, 9, 41, 'uploads/homework_answers/ans_9_1768381184.jpg', '', '2026-01-14 09:01:25'),
(7, 10, 45, 'uploads/homework_answers/ans_10_1768485090.jpg', '', '2026-01-15 13:51:30'),
(8, 10, 46, 'uploads/homework_answers/ans_10_1768576122.jpg', 'Only one file can be attached here', '2026-01-16 15:08:42'),
(9, 9, 42, NULL, '', '2026-01-17 06:38:52'),
(10, 9, 39, 'uploads/homework_answers/ans_9_1768633237.jpg', 'Sir done👍', '2026-01-17 07:00:37'),
(11, 13, 35, 'uploads/homework_answers/ans_13_1768830664.jpg', 'Completed', '2026-01-19 13:51:04'),
(12, 9, 66, NULL, '', '2026-01-31 12:06:00'),
(13, 15, 74, 'uploads/homework_answers/ans_15_1769955755.jpg', '', '2026-02-01 14:22:35'),
(14, 15, 70, 'uploads/homework_answers/ans_15_1770051419.jpg', '', '2026-02-02 16:56:59'),
(15, 15, 78, 'uploads/homework_answers/ans_15_1770128636.jpg', 'Done', '2026-02-03 14:23:56'),
(16, 16, 61, 'uploads/homework_answers/ans_16_1770218092.jpg', 'I did the home work', '2026-02-04 15:14:52'),
(18, 9, 37, 'uploads/homework_answers/ans_9_1770278566.png', '', '2026-02-05 08:02:46'),
(19, 15, 69, 'uploads/homework_answers/ans_15_1770300562.jpg', 'Sir i don\'t know to do the questions from e to j . Can you explain in the class sir', '2026-02-05 14:09:22'),
(20, 16, 66, NULL, '', '2026-02-05 15:40:40'),
(21, 16, 41, 'uploads/homework_answers/ans_16_1770382933.jpg', '', '2026-02-06 13:02:13'),
(22, 16, 38, 'uploads/homework_answers/ans_16_1770388763.jpg', 'Done', '2026-02-06 14:39:23'),
(23, 10, 44, 'uploads/homework_answers/ans_10_1770389083.pdf', '', '2026-02-06 14:46:57'),
(24, 15, 44, 'uploads/homework_answers/ans_15_1770389182.pdf', 'Sir cant understand g,i,j. So didnt do them . Other all did', '2026-02-06 14:46:22'),
(25, 15, 45, 'uploads/homework_answers/ans_15_1770390690.jpg', 'Sorry Sir, I had already done the work but I had trouble converting it to a PDF that\'s why it got late', '2026-02-06 15:11:30'),
(26, 16, 40, 'uploads/homework_answers/ans_16_1770390974.jpg', '', '2026-02-06 15:16:42'),
(27, 16, 42, NULL, '', '2026-02-06 16:52:15'),
(28, 15, 75, 'uploads/homework_answers/ans_15_1770396246.jpg', '', '2026-02-06 16:44:06'),
(29, 10, 43, 'uploads/homework_answers/ans_10_1770397883.jpg', '', '2026-02-06 17:11:23'),
(30, 16, 37, 'uploads/homework_answers/ans_16_1770399656.jpg', '', '2026-02-06 17:40:56'),
(31, 15, 79, 'uploads/homework_answers/ans_15_1770429057.jpeg', 'Sir sorry for late h/w', '2026-02-07 01:50:57'),
(32, 15, 68, 'uploads/homework_answers/ans_15_1770471464.jpg', '', '2026-02-07 13:37:44'),
(33, 15, 72, NULL, 'Done', '2026-02-07 14:11:10'),
(34, 17, 73, 'uploads/homework_answers/ans_17_1770570188.pdf', 'Was not able to complete questions- #47, #74, #76', '2026-02-08 17:03:08'),
(35, 17, 69, 'uploads/homework_answers/ans_17_1770648309.jpg', 'Done', '2026-02-09 14:45:09'),
(36, 17, 70, 'uploads/homework_answers/ans_17_1770741762.jpeg', '', '2026-02-10 16:42:42'),
(37, 9, 61, 'uploads/homework_answers/ans_9_1771054330.jpg', '', '2026-02-14 07:32:10'),
(38, 20, 41, 'uploads/homework_answers/ans_20_1771079676.jpg', '', '2026-02-14 14:34:36'),
(39, 21, 45, 'uploads/homework_answers/ans_21_1771082742.jpg', '', '2026-02-14 15:25:42'),
(40, 20, 40, 'uploads/homework_answers/ans_20_1771083433.jpg', '', '2026-02-14 15:37:13'),
(41, 21, 78, 'uploads/homework_answers/ans_21_1771086692.pdf', 'Did not complete question C and E', '2026-02-14 16:31:32'),
(42, 21, 69, 'uploads/homework_answers/ans_21_1771087352.jpg', '', '2026-02-14 16:42:32'),
(43, 16, 65, 'uploads/homework_answers/ans_16_1771093047.pdf', '', '2026-02-14 18:17:27'),
(44, 21, 44, 'uploads/homework_answers/ans_21_1771093965.pdf', '', '2026-02-14 18:32:45'),
(45, 21, 73, 'uploads/homework_answers/ans_21_1771093990.pdf', '', '2026-02-14 18:33:10'),
(46, 21, 43, 'uploads/homework_answers/ans_21_1771131114.pdf', 'Didn’t understand c and e', '2026-02-15 04:51:54'),
(47, 21, 68, 'uploads/homework_answers/ans_21_1771131892.jpg', '👍 done', '2026-02-15 05:04:52'),
(48, 21, 79, 'uploads/homework_answers/ans_21_1771131966.jpeg', '', '2026-02-15 05:06:06'),
(49, 20, 37, 'uploads/homework_answers/ans_20_1771146117.jpg', '', '2026-02-15 09:01:57'),
(50, 20, 61, 'uploads/homework_answers/ans_20_1771167037.jpg', '', '2026-02-15 14:50:37'),
(51, 23, 65, 'uploads/homework_answers/ans_23_1771177374.jpg', 'I submited the work.', '2026-02-15 17:42:54'),
(52, 20, 65, 'uploads/homework_answers/ans_20_1771178856.jpg', 'Sorry for late sir.', '2026-02-15 18:07:36'),
(53, 19, 65, 'uploads/homework_answers/ans_19_1771182326.jpg', 'Submited.', '2026-02-15 19:05:26'),
(54, 24, 45, 'uploads/homework_answers/ans_24_1771235073.jpg', 'Sir, the last question is based on Sphere so I didn\'t do it', '2026-02-16 09:44:33'),
(55, 24, 78, 'uploads/homework_answers/ans_24_1771255707.pdf', '', '2026-02-16 15:28:28'),
(56, 16, 62, 'uploads/homework_answers/ans_16_1771257978.jpg', 'I have done my homework, I didn\'t do the last question method, because I don\'t know', '2026-02-16 16:06:18'),
(57, 21, 70, 'uploads/homework_answers/ans_21_1771259672.jpg', '', '2026-02-16 16:34:32'),
(58, 24, 70, 'uploads/homework_answers/ans_24_1771263039.jpg', '', '2026-02-16 17:30:39'),
(59, 10, 70, 'uploads/homework_answers/ans_10_1771263205.jpg', '', '2026-02-16 17:33:25'),
(60, 10, 80, 'uploads/homework_answers/ans_10_1771338578.jpg', '', '2026-02-17 14:29:38'),
(61, 19, 61, 'uploads/homework_answers/ans_19_1771347890.jpg', 'Could only take one picture', '2026-02-17 17:04:50'),
(62, 20, 62, 'uploads/homework_answers/ans_20_1771420085.jpg', '', '2026-02-18 13:08:05'),
(64, 24, 69, 'uploads/homework_answers/ans_24_1771596272.jpg', '', '2026-02-20 14:04:32'),
(65, 23, 41, 'uploads/homework_answers/ans_23_1771598319.jpg', '', '2026-02-20 14:38:39'),
(66, 24, 46, 'uploads/homework_answers/ans_24_1771605498.jpg', '', '2026-02-20 16:38:18'),
(67, 23, 40, 'uploads/homework_answers/ans_23_1771607898.jpg', '', '2026-02-20 17:18:18'),
(68, 24, 44, 'uploads/homework_answers/ans_24_1771611352.jpeg', 'Can’t understand the last one other all did.', '2026-02-20 18:15:52'),
(69, 23, 62, 'uploads/homework_answers/ans_23_1771631620.jpg', '', '2026-02-20 23:53:40'),
(70, 24, 74, 'uploads/homework_answers/ans_24_1771633008.jpg', 'C question i don\'t know sir', '2026-02-21 00:16:48'),
(71, 23, 64, 'uploads/homework_answers/ans_23_1771634471.jpg', 'Done', '2026-02-21 00:41:11'),
(72, 19, 64, 'uploads/homework_answers/ans_19_1771634692.jpg', '', '2026-02-21 00:44:52'),
(73, 20, 64, 'uploads/homework_answers/ans_20_1771634812.jpg', '', '2026-02-21 00:46:52'),
(74, 24, 72, 'uploads/homework_answers/ans_24_1771647936.jpg', 'Done', '2026-02-21 04:25:36'),
(75, 24, 43, 'uploads/homework_answers/ans_24_1771660318.jpg', 'Don’t know how to do the last one', '2026-02-21 07:51:58'),
(76, 23, 61, 'uploads/homework_answers/ans_23_1771684787.jpg', '', '2026-02-21 14:39:47'),
(77, 22, 70, 'uploads/homework_answers/ans_22_1771827882.jpg', '', '2026-02-23 06:24:42'),
(78, 25, 40, 'uploads/homework_answers/ans_25_1776523082.jpg', '', '2026-04-18 14:38:02'),
(79, 25, 81, 'uploads/homework_answers/ans_25_1776707066.jpg', '', '2026-04-20 17:44:26'),
(80, 25, 61, 'uploads/homework_answers/ans_25_1776867316.jpg', 'Other 2 sums in next page', '2026-04-22 14:15:16'),
(81, 26, 61, 'uploads/homework_answers/ans_26_1776955549.jpg', 'I did the home work', '2026-04-23 14:45:49'),
(82, 26, 38, 'uploads/homework_answers/ans_26_1777035762.jpg', 'Done', '2026-04-24 13:02:42'),
(83, 25, 38, 'uploads/homework_answers/ans_25_1777039327.jpg', '', '2026-04-24 14:02:07'),
(84, 25, 41, 'uploads/homework_answers/ans_25_1777040523.pdf', '', '2026-04-24 14:22:03'),
(85, 25, 39, 'uploads/homework_answers/ans_25_1777045455.jpg', 'Sir did', '2026-04-24 15:44:15'),
(86, 26, 62, 'uploads/homework_answers/ans_26_1777107399.jpg', 'Sir I did the fill in the blanks and the factor the following algebraic expression', '2026-04-25 08:56:39'),
(87, 27, 69, 'uploads/homework_answers/ans_27_1777386645.jpg', 'Sir I have some confusion in these questions so could you please explain it in the class sir', '2026-04-28 14:30:45'),
(88, 27, 67, 'uploads/homework_answers/ans_27_1777473127.jpg', '', '2026-04-29 14:32:07'),
(89, 27, 68, 'uploads/homework_answers/ans_27_1777561337.jpg', 'Sir I have only sensed the answers but methods are with me i am not able to send it is unable to send more pictures', '2026-04-30 15:02:17'),
(90, 30, 68, 'uploads/homework_answers/ans_30_1777979466.jpg', '', '2026-05-05 11:11:06'),
(91, 31, 68, 'uploads/homework_answers/ans_31_1777985510.jpg', 'Done madam', '2026-05-05 12:51:50'),
(92, 27, 70, 'uploads/homework_answers/ans_27_1777987867.jpg', '', '2026-05-05 13:31:07'),
(93, 31, 70, 'uploads/homework_answers/ans_31_1777987984.jpg', '', '2026-05-05 13:33:04'),
(94, 30, 70, 'uploads/homework_answers/ans_30_1777988082.jpg', '', '2026-05-05 13:34:42'),
(95, 31, 69, 'uploads/homework_answers/ans_31_1777990156.pdf', 'Done', '2026-05-05 14:09:16'),
(96, 31, 67, 'uploads/homework_answers/ans_31_1777995060.jpg', '', '2026-05-05 15:31:00'),
(97, 30, 67, 'uploads/homework_answers/ans_30_1777996604.jpg', 'Done sir ✅', '2026-05-05 15:56:44'),
(98, 31, 73, 'uploads/homework_answers/ans_31_1777997794.pdf', '', '2026-05-05 16:16:34'),
(99, 24, 68, 'uploads/homework_answers/ans_24_1777999233.jpg', '', '2026-05-05 16:40:33'),
(100, 17, 68, 'uploads/homework_answers/ans_17_1777999398.jpg', '', '2026-05-05 16:43:18'),
(102, 22, 68, 'uploads/homework_answers/ans_22_1777999663.jpg', 'Done', '2026-05-05 16:47:43'),
(103, 37, 54, 'uploads/homework_answers/ans_37_1778076104.jpg', 'Done on time', '2026-05-06 14:01:44'),
(104, 38, 69, 'uploads/homework_answers/ans_38_1778077328.jpg', '', '2026-05-06 14:22:08'),
(105, 38, 68, 'uploads/homework_answers/ans_38_1778077404.jpg', 'I have done it in the paper', '2026-05-06 14:23:24'),
(106, 37, 88, 'uploads/homework_answers/ans_37_1778080675.jpg', '', '2026-05-06 15:17:55'),
(107, 36, 54, 'uploads/homework_answers/ans_36_1778086762.jpg', 'Assignment', '2026-05-06 16:59:22'),
(108, 38, 67, 'uploads/homework_answers/ans_38_1778166909.jpg', '', '2026-05-07 15:15:09'),
(110, 30, 71, 'uploads/homework_answers/ans_30_1778174366.pdf', 'Completed', '2026-05-07 17:19:26'),
(111, 37, 59, 'uploads/homework_answers/ans_37_1778203200.jpg', '', '2026-05-08 01:20:00'),
(112, 36, 96, 'uploads/homework_answers/ans_36_1778222395.jpg', 'My Types of magnet assigment', '2026-05-08 06:39:55'),
(113, 30, 69, 'uploads/homework_answers/ans_30_1778233247.jpg', '', '2026-05-08 09:40:47'),
(114, 39, 62, 'uploads/homework_answers/ans_39_1778347503.pdf', 'I did the homework', '2026-05-09 17:25:03'),
(115, 30, 72, 'uploads/homework_answers/ans_30_1778417920.pdf', 'Did the homework', '2026-05-10 12:58:40'),
(116, 36, 59, 'uploads/homework_answers/ans_36_1778427330.jpg', '', '2026-05-10 15:35:30'),
(117, 36, 89, 'uploads/homework_answers/ans_36_1778428287.jpeg', '', '2026-05-10 15:51:27'),
(118, 37, 89, 'uploads/homework_answers/ans_37_1778428970.jpeg', '', '2026-05-10 16:02:50'),
(120, 37, 96, 'uploads/homework_answers/ans_37_1778436842.pdf', '', '2026-05-10 18:14:02'),
(121, 37, 57, 'uploads/homework_answers/ans_37_1778503980.jpg', '', '2026-05-11 12:53:00'),
(123, 42, 68, 'uploads/homework_answers/ans_42_1778513158.jpg', 'Done', '2026-05-11 15:25:58'),
(124, 43, 68, 'uploads/homework_answers/ans_43_1778513261.jpg', 'Done', '2026-05-11 15:27:41'),
(125, 41, 62, 'uploads/homework_answers/ans_41_1778514455.pdf', 'I did all', '2026-05-11 15:47:35'),
(126, 19, 62, 'uploads/homework_answers/ans_19_1778514775.pdf', 'Sorry for inconvenience', '2026-05-11 15:52:55'),
(127, 42, 67, 'uploads/homework_answers/ans_42_1778516391.jpg', '', '2026-05-11 16:19:51'),
(128, 17, 67, 'uploads/homework_answers/ans_17_1778516575.jpg', '', '2026-05-11 16:22:55'),
(131, 15, 67, 'uploads/homework_answers/ans_15_1778517553.jpg', '', '2026-05-11 16:39:13'),
(132, 31, 80, 'uploads/homework_answers/ans_31_1778520087.jpeg', '', '2026-05-11 17:21:27'),
(133, 25, 62, 'uploads/homework_answers/ans_25_1778520107.jpg', '', '2026-05-11 17:21:47'),
(134, 36, 88, 'uploads/homework_answers/ans_36_1778521034.jpg', '', '2026-05-11 17:37:14'),
(135, 17, 80, 'uploads/homework_answers/ans_17_1778521353.jpeg', '', '2026-05-11 17:42:33'),
(136, 41, 61, 'uploads/homework_answers/ans_41_1778581074.pdf', '', '2026-05-12 10:17:54'),
(137, 38, 70, 'uploads/homework_answers/ans_38_1778585269.jpg', '', '2026-05-12 11:27:49'),
(138, 42, 70, 'uploads/homework_answers/ans_42_1778588431.jpg', '', '2026-05-12 12:20:31'),
(139, 43, 70, 'uploads/homework_answers/ans_43_1778588475.jpg', '', '2026-05-12 12:21:15'),
(140, 45, 67, 'uploads/homework_answers/ans_45_1778593202.jpg', '', '2026-05-12 13:40:02'),
(142, 45, 68, 'uploads/homework_answers/ans_45_1778594701.jpg', 'Done madam👍♥️', '2026-05-12 14:05:01'),
(144, 44, 62, 'uploads/homework_answers/ans_44_1778598613.jpg', '', '2026-05-12 15:10:13'),
(145, 43, 67, 'uploads/homework_answers/ans_43_1778599082.jpg', '', '2026-05-12 15:18:02'),
(146, 45, 69, 'uploads/homework_answers/ans_45_1778599459.jpg', '', '2026-05-12 15:24:19'),
(147, 46, 61, 'uploads/homework_answers/ans_46_1778599931.jpg', '', '2026-05-12 15:32:11'),
(148, 41, 81, 'uploads/homework_answers/ans_41_1778605342.jpg', 'Did', '2026-05-12 17:02:22'),
(149, 44, 61, 'uploads/homework_answers/ans_44_1778606215.pdf', 'I did all questions !', '2026-05-12 17:16:55'),
(151, 45, 73, 'uploads/homework_answers/ans_45_1778611528.jpg', '', '2026-05-12 18:45:28'),
(153, 35, 70, 'uploads/homework_answers/ans_35_1778637849.jpg', '', '2026-05-13 02:04:09'),
(154, 33, 61, 'uploads/homework_answers/ans_33_1778637931.jpg', 'I\'m a sinhala student', '2026-05-13 02:05:31'),
(155, 35, 69, 'uploads/homework_answers/ans_35_1778648903.jpg', '', '2026-05-13 05:08:23'),
(156, 43, 69, 'uploads/homework_answers/ans_43_1778656229.jpg', '', '2026-05-13 07:10:29'),
(157, 42, 69, 'uploads/homework_answers/ans_42_1778656523.jpg', '', '2026-05-13 07:15:23'),
(158, 46, 81, 'uploads/homework_answers/ans_46_1778663483.jpg', '', '2026-05-13 09:11:23'),
(159, 54, 54, 'uploads/homework_answers/ans_54_1778666038.jpg', 'Done', '2026-05-13 09:53:58'),
(160, 35, 68, 'uploads/homework_answers/ans_35_1778666226.jpg', 'Done', '2026-05-13 09:57:06'),
(161, 45, 76, 'uploads/homework_answers/ans_45_1778666428.jpg', '', '2026-05-13 10:00:28'),
(162, 31, 76, 'uploads/homework_answers/ans_31_1778666480.jpg', '', '2026-05-13 10:01:20'),
(163, 53, 69, 'uploads/homework_answers/ans_53_1778667315.jpg', 'Madam iam not able to send a pdf to this so, I\'ll show the others in the school', '2026-05-13 10:15:15'),
(164, 53, 70, 'uploads/homework_answers/ans_53_1778668047.jpg', 'This is the context questions,right?', '2026-05-13 10:27:27'),
(165, 55, 54, 'uploads/homework_answers/ans_55_1778670036.jpg', 'Done', '2026-05-13 11:00:36'),
(166, 35, 67, 'uploads/homework_answers/ans_35_1778674101.jpg', '', '2026-05-13 12:08:21'),
(167, 53, 67, 'uploads/homework_answers/ans_53_1778676021.jpg', '', '2026-05-13 12:40:21'),
(168, 54, 57, 'uploads/homework_answers/ans_54_1778683099.jpg', '', '2026-05-13 14:38:19'),
(169, 41, 38, 'uploads/homework_answers/ans_41_1778684320.pdf', '', '2026-05-13 14:58:40'),
(170, 42, 72, 'uploads/homework_answers/ans_42_1778684489.jpg', 'Done', '2026-05-13 15:01:29'),
(171, 43, 72, 'uploads/homework_answers/ans_43_1778684563.jpg', 'Done', '2026-05-13 15:02:43'),
(172, 17, 72, 'uploads/homework_answers/ans_17_1778684870.jpg', 'Done', '2026-05-13 15:07:50'),
(173, 22, 72, 'uploads/homework_answers/ans_22_1778685661.jpg', 'Dome', '2026-05-13 15:21:01'),
(174, 55, 57, 'uploads/homework_answers/ans_55_1778685962.jpg', '', '2026-05-13 15:26:02'),
(175, 59, 72, 'uploads/homework_answers/ans_59_1778687097.jpg', 'Done', '2026-05-13 15:44:57'),
(176, 56, 68, 'uploads/homework_answers/ans_56_1778687445.jpg', 'Done madam I have did it it is hard to convert to pdf', '2026-05-13 15:50:45'),
(177, 42, 76, 'uploads/homework_answers/ans_42_1778687776.jpg', '', '2026-05-13 15:56:16'),
(178, 54, 59, 'uploads/homework_answers/ans_54_1778687804.jpg', '', '2026-05-13 15:56:44'),
(179, 43, 76, 'uploads/homework_answers/ans_43_1778688077.jpg', '', '2026-05-13 16:01:17'),
(180, 33, 81, 'uploads/homework_answers/ans_33_1778688383.jpg', '', '2026-05-13 16:06:23'),
(181, 59, 76, 'uploads/homework_answers/ans_59_1778688607.jpg', '', '2026-05-13 16:10:07'),
(182, 55, 59, 'uploads/homework_answers/ans_55_1778688632.jpg', '', '2026-05-13 16:10:32'),
(183, 59, 70, 'uploads/homework_answers/ans_59_1778688699.pdf', '', '2026-05-13 16:11:39'),
(187, 19, 81, 'uploads/homework_answers/ans_19_1778690534.jpg', '', '2026-05-13 16:42:14'),
(188, 39, 81, 'uploads/homework_answers/ans_39_1778690530.jpg', '', '2026-05-13 16:42:10'),
(189, 41, 39, 'uploads/homework_answers/ans_41_1778690893.jpg', '', '2026-05-13 16:48:13'),
(190, 55, 96, 'uploads/homework_answers/ans_55_1778691149.pdf', 'Is this the work', '2026-05-13 16:52:29'),
(191, 54, 88, NULL, '', '2026-05-13 17:10:14'),
(193, 41, 66, 'uploads/homework_answers/ans_41_1778692463.pdf', '', '2026-05-13 17:14:23'),
(194, 54, 96, 'uploads/homework_answers/ans_54_1778692637.jpg', 'Is this the homework?', '2026-05-13 17:17:17'),
(195, 55, 88, NULL, '', '2026-05-13 17:28:37'),
(196, 58, 51, 'uploads/homework_answers/ans_58_1778694610.jpg', '', '2026-05-13 17:50:10'),
(197, 46, 65, 'uploads/homework_answers/ans_46_1778694684.jpg', '', '2026-05-13 17:51:24'),
(198, 41, 65, 'uploads/homework_answers/ans_41_1778694803.jpg', '', '2026-05-13 17:53:23'),
(201, 32, 61, 'uploads/homework_answers/ans_32_1778719571.pdf', '', '2026-05-14 00:46:11'),
(202, 64, 70, 'uploads/homework_answers/ans_64_1778752115.jpg', '', '2026-05-14 09:48:35'),
(203, 60, 96, 'uploads/homework_answers/ans_60_1778757121.pdf', 'Is this the homework?', '2026-05-14 11:12:01'),
(204, 34, 93, 'uploads/homework_answers/ans_34_1778758035.pdf', '', '2026-05-14 11:27:15'),
(205, 61, 68, 'uploads/homework_answers/ans_61_1778758234.jpg', 'Done', '2026-05-14 11:30:34'),
(206, 60, 59, 'uploads/homework_answers/ans_60_1778759130.jpg', '', '2026-05-14 11:45:30'),
(207, 59, 69, 'uploads/homework_answers/ans_59_1778759495.jpg', '', '2026-05-14 11:51:35'),
(208, 61, 70, 'uploads/homework_answers/ans_61_1778761215.pdf', '', '2026-05-14 12:20:15'),
(209, 60, 54, 'uploads/homework_answers/ans_60_1778762185.jpg', 'Science', '2026-05-14 12:36:25'),
(210, 61, 69, 'uploads/homework_answers/ans_61_1778764276.jpg', 'Sir I\'ll show the other on school because IAM unable to send the pdf', '2026-05-14 13:11:16'),
(211, 44, 101, 'uploads/homework_answers/ans_44_1778766984.pdf', 'Work done', '2026-05-14 13:56:25'),
(212, 54, 87, 'uploads/homework_answers/ans_54_1778767095.jpg', '', '2026-05-14 13:58:15'),
(213, 55, 87, 'uploads/homework_answers/ans_55_1778767309.jpg', '', '2026-05-14 14:01:49'),
(214, 63, 61, 'uploads/homework_answers/ans_63_1778768081.jpg', '', '2026-05-14 14:14:41'),
(215, 63, 101, 'uploads/homework_answers/ans_63_1778768555.jpg', '', '2026-05-14 14:22:35'),
(216, 43, 71, 'uploads/homework_answers/ans_43_1778769657.jpg', '', '2026-05-14 14:40:57'),
(217, 42, 71, 'uploads/homework_answers/ans_42_1778769692.jpg', '', '2026-05-14 14:41:32'),
(219, 45, 80, 'uploads/homework_answers/ans_45_1778770030.jpeg', '', '2026-05-14 14:47:10'),
(220, 60, 87, 'uploads/homework_answers/ans_60_1778770345.jpg', '', '2026-05-14 14:52:25'),
(221, 54, 89, 'uploads/homework_answers/ans_54_1778770490.jpeg', '', '2026-05-14 14:54:50'),
(223, 64, 72, 'uploads/homework_answers/ans_64_1778770659.jpg', '', '2026-05-14 14:57:39'),
(224, 65, 47, 'uploads/homework_answers/ans_65_1778770810.jpg', '', '2026-05-14 15:00:10'),
(225, 64, 71, 'uploads/homework_answers/ans_64_1778770873.jpg', '', '2026-05-14 15:01:13'),
(226, 17, 71, 'uploads/homework_answers/ans_17_1778770971.jpg', '', '2026-05-14 15:02:51'),
(227, 62, 66, 'uploads/homework_answers/ans_62_1778771534.pdf', '', '2026-05-14 15:12:14'),
(228, 55, 89, 'uploads/homework_answers/ans_55_1778771556.jpg', '', '2026-05-14 15:12:36'),
(229, 61, 76, 'uploads/homework_answers/ans_61_1778771592.jpg', '', '2026-05-14 15:13:12'),
(230, 38, 76, 'uploads/homework_answers/ans_38_1778771704.jpg', '', '2026-05-14 15:15:04'),
(231, 30, 76, 'uploads/homework_answers/ans_30_1778771758.jpg', '', '2026-05-14 15:15:58'),
(232, 27, 76, 'uploads/homework_answers/ans_27_1778771807.jpg', '', '2026-05-14 15:16:47'),
(233, 60, 88, 'uploads/homework_answers/ans_60_1778772240.jpg', '', '2026-05-14 15:24:00'),
(234, 64, 73, 'uploads/homework_answers/ans_64_1778772403.jpg', '', '2026-05-14 15:26:43'),
(235, 66, 81, 'uploads/homework_answers/ans_66_1778773106.jpg', '', '2026-05-14 15:38:26'),
(236, 61, 72, 'uploads/homework_answers/ans_61_1778772887.jpg', 'Sir I couldn\'t make PDF \r\nOn school I will show the work', '2026-05-14 15:34:47'),
(239, 65, 99, 'uploads/homework_answers/ans_65_1778774056.pdf', '', '2026-05-14 15:54:16'),
(240, 61, 73, 'uploads/homework_answers/ans_61_1778774157.pdf', '', '2026-05-14 15:55:57'),
(241, 54, 58, 'uploads/homework_answers/ans_54_1778774482.jpg', '', '2026-05-14 16:01:22'),
(242, 55, 58, 'uploads/homework_answers/ans_55_1778774567.jpg', '', '2026-05-14 16:02:47'),
(243, 37, 58, 'uploads/homework_answers/ans_37_1778774755.jpg', '', '2026-05-14 16:05:55'),
(244, 60, 58, 'uploads/homework_answers/ans_60_1778774848.jpg', '', '2026-05-14 16:07:28'),
(245, 59, 73, 'uploads/homework_answers/ans_59_1778775488.pdf', '', '2026-05-14 16:18:08'),
(246, 59, 67, 'uploads/homework_answers/ans_59_1778775591.jpg', '', '2026-05-14 16:19:51'),
(247, 69, 69, 'uploads/homework_answers/ans_69_1778776082.jpg', 'I\'ll show the other in the school madam', '2026-05-14 16:28:02'),
(248, 63, 62, 'uploads/homework_answers/ans_63_1778776394.jpg', '', '2026-05-14 16:33:15'),
(250, 71, 67, 'uploads/homework_answers/ans_71_1778777584.jpg', '', '2026-05-14 16:53:04'),
(251, 67, 96, 'uploads/homework_answers/ans_67_1778778974.pdf', 'Full 15 question fenish', '2026-05-14 17:16:14'),
(252, 71, 73, 'uploads/homework_answers/ans_71_1778779901.jpg', '', '2026-05-14 17:31:41'),
(253, 69, 68, 'uploads/homework_answers/ans_69_1778780426.jpg', 'Done', '2026-05-14 17:40:26'),
(254, 71, 68, 'uploads/homework_answers/ans_71_1778780459.jpg', 'Done', '2026-05-14 17:40:59'),
(255, 69, 67, 'uploads/homework_answers/ans_69_1778780629.jpg', '', '2026-05-14 17:43:49'),
(257, 61, 67, 'uploads/homework_answers/ans_61_1778781061.jpg', '', '2026-05-14 17:51:01'),
(259, 69, 73, 'uploads/homework_answers/ans_69_1778781812.pdf', '', '2026-05-14 18:03:32'),
(262, 43, 73, 'uploads/homework_answers/ans_43_1778782995.jpg', '', '2026-05-14 18:23:15'),
(263, 60, 57, 'uploads/homework_answers/ans_60_1778783352.pdf', '', '2026-05-14 18:29:12'),
(264, 42, 73, 'uploads/homework_answers/ans_42_1778783545.jpg', '', '2026-05-14 18:32:25'),
(265, 70, 65, 'uploads/homework_answers/ans_70_1778784008.jpg', 'Submitted', '2026-05-14 18:40:08'),
(267, 46, 38, 'uploads/homework_answers/ans_46_1778784464.pdf', 'Done 👍', '2026-05-14 18:47:44'),
(269, 64, 80, 'uploads/homework_answers/ans_64_1778784779.jpg', '', '2026-05-14 18:52:59'),
(271, 61, 80, 'uploads/homework_answers/ans_61_1778785089.pdf', '', '2026-05-14 18:58:09'),
(274, 71, 69, 'uploads/homework_answers/ans_71_1778803270.jpeg', '', '2026-05-15 00:01:10'),
(275, 63, 38, 'uploads/homework_answers/ans_63_1778818435.jpg', 'Done all', '2026-05-15 04:13:55'),
(276, 70, 61, 'uploads/homework_answers/ans_70_1778826231.pdf', '', '2026-05-15 06:23:51'),
(277, 67, 54, 'uploads/homework_answers/ans_67_1778829168.jpg', 'Civics', '2026-05-15 07:12:48'),
(278, 71, 70, 'uploads/homework_answers/ans_71_1778837765.jpg', '', '2026-05-15 09:36:05'),
(279, 69, 70, 'uploads/homework_answers/ans_69_1778838041.pdf', '', '2026-05-15 09:40:41'),
(280, 65, 48, 'uploads/homework_answers/ans_65_1778839855.jpg', '', '2026-05-15 10:10:55'),
(282, 19, 37, 'uploads/homework_answers/ans_19_1778850894.pdf', '', '2026-05-15 13:14:54'),
(284, 26, 37, 'uploads/homework_answers/ans_26_1778851643.jpg', 'Done', '2026-05-15 13:27:23'),
(286, 41, 37, 'uploads/homework_answers/ans_41_1778851798.jpg', '', '2026-05-15 13:29:58'),
(287, 63, 37, 'uploads/homework_answers/ans_63_1778851878.jpg', '', '2026-05-15 13:31:18'),
(289, 68, 101, 'uploads/homework_answers/ans_68_1778853355.pdf', '', '2026-05-15 13:55:55'),
(291, 67, 58, 'uploads/homework_answers/ans_67_1778858852.jpg', '', '2026-05-15 15:27:32'),
(292, 68, 62, 'uploads/homework_answers/ans_68_1778859953.jpg', '', '2026-05-15 15:45:53'),
(293, 69, 72, 'uploads/homework_answers/ans_69_1778860843.jpg', 'DONE', '2026-05-15 16:00:43'),
(294, 72, 62, 'uploads/homework_answers/ans_72_1778861262.pdf', '', '2026-05-15 16:07:42'),
(295, 19, 38, 'uploads/homework_answers/ans_19_1778861352.pdf', '👍🏼', '2026-05-15 16:09:12'),
(296, 67, 59, 'uploads/homework_answers/ans_67_1778861676.pdf', '', '2026-05-15 16:14:36'),
(297, 63, 81, 'uploads/homework_answers/ans_63_1778861827.jpg', '', '2026-05-15 16:17:07'),
(298, 68, 38, 'uploads/homework_answers/ans_68_1778861699.pdf', 'Done 👍', '2026-05-15 16:14:59'),
(300, 16, 81, 'uploads/homework_answers/ans_16_1778862060.jpg', '', '2026-05-15 16:21:00'),
(301, 23, 81, 'uploads/homework_answers/ans_23_1778862144.jpg', '', '2026-05-15 16:22:24'),
(303, 72, 81, 'uploads/homework_answers/ans_72_1778862899.jpg', '', '2026-05-15 16:34:59'),
(304, 70, 38, 'uploads/homework_answers/ans_70_1778862948.pdf', 'Done', '2026-05-15 16:35:48'),
(306, 67, 88, 'uploads/homework_answers/ans_67_1778865370.jpg', '', '2026-05-15 17:16:10'),
(307, 72, 38, 'uploads/homework_answers/ans_72_1778869618.jpg', 'Done 👍👍🏼', '2026-05-15 18:26:58'),
(308, 67, 89, 'uploads/homework_answers/ans_67_1778895707.jpeg', 'Done', '2026-05-16 01:41:47'),
(311, 74, 68, 'uploads/homework_answers/ans_74_1778930266.jpg', '👍 done', '2026-05-16 11:17:46'),
(312, 74, 67, 'uploads/homework_answers/ans_74_1778931320.jpg', '', '2026-05-16 11:35:20'),
(313, 21, 67, 'uploads/homework_answers/ans_21_1778931558.jpg', '', '2026-05-16 11:39:18'),
(314, 24, 67, 'uploads/homework_answers/ans_24_1778931742.jpg', '', '2026-05-16 11:42:22'),
(315, 44, 39, 'uploads/homework_answers/ans_44_1778932238.jpg', '', '2026-05-16 11:50:38'),
(316, 79, 68, 'uploads/homework_answers/ans_79_1778937646.jpg', 'Done', '2026-05-16 13:20:46'),
(317, 74, 69, 'uploads/homework_answers/ans_74_1778937909.jpg', '', '2026-05-16 13:25:09'),
(318, 75, 69, 'uploads/homework_answers/ans_75_1778938999.jpg', '', '2026-05-16 13:43:19'),
(319, 72, 64, 'uploads/homework_answers/ans_72_1778939286.jpg', '', '2026-05-16 13:48:06'),
(320, 79, 69, 'uploads/homework_answers/ans_79_1778940001.jpg', '', '2026-05-16 14:00:01'),
(321, 77, 54, 'uploads/homework_answers/ans_77_1778940908.jpg', 'History', '2026-05-16 14:15:08'),
(322, 41, 64, 'uploads/homework_answers/ans_41_1778941346.jpeg', '', '2026-05-16 14:22:26'),
(323, 78, 38, 'uploads/homework_answers/ans_78_1778941807.jpg', 'Done', '2026-05-16 14:30:07'),
(324, 68, 61, 'uploads/homework_answers/ans_68_1778942963.pdf', '', '2026-05-16 14:49:23'),
(327, 80, 54, 'uploads/homework_answers/ans_80_1778943817.jpg', 'Maths', '2026-05-16 15:03:37'),
(328, 80, 58, 'uploads/homework_answers/ans_80_1778945636.jpg', '', '2026-05-16 15:33:56'),
(329, 36, 58, 'uploads/homework_answers/ans_36_1778945998.jpg', '', '2026-05-16 15:39:58'),
(330, 79, 67, 'uploads/homework_answers/ans_79_1778946437.jpg', '', '2026-05-16 15:47:17'),
(331, 77, 58, 'uploads/homework_answers/ans_77_1778947466.jpg', '', '2026-05-16 16:04:26'),
(332, 75, 67, 'uploads/homework_answers/ans_75_1778948922.jpg', '', '2026-05-16 16:28:42'),
(333, 72, 39, 'uploads/homework_answers/ans_72_1778949015.jpg', '', '2026-05-16 16:30:15'),
(334, 80, 96, 'uploads/homework_answers/ans_80_1778950427.pdf', '', '2026-05-16 16:53:47'),
(335, 77, 96, 'uploads/homework_answers/ans_77_1778950475.pdf', '', '2026-05-16 16:54:35'),
(336, 70, 37, 'uploads/homework_answers/ans_70_1778951075.pdf', 'Done', '2026-05-16 17:04:35'),
(339, 72, 37, 'uploads/homework_answers/ans_72_1778951457.pdf', 'Done', '2026-05-16 17:10:57'),
(341, 44, 38, 'uploads/homework_answers/ans_44_1778953495.pdf', 'All drove. 👍🏼👍🏼👍🏼👍🏼👍🏼', '2026-05-16 17:44:55'),
(342, 72, 61, 'uploads/homework_answers/ans_72_1778956449.jpg', '', '2026-05-16 18:34:09'),
(343, 79, 73, 'uploads/homework_answers/ans_79_1778957185.jpg', '', '2026-05-16 18:46:25'),
(344, 75, 73, 'uploads/homework_answers/ans_75_1778958052.jpg', '', '2026-05-16 19:00:52'),
(345, 76, 61, 'uploads/homework_answers/ans_76_1778981886.jpg', '', '2026-05-17 01:38:06'),
(346, 79, 70, 'uploads/homework_answers/ans_79_1778988509.jpg', '', '2026-05-17 03:28:29'),
(347, 73, 51, 'uploads/homework_answers/ans_73_1778992609.jpg', '', '2026-05-17 04:36:49'),
(348, 75, 70, 'uploads/homework_answers/ans_75_1778993720.jpg', '', '2026-05-17 04:55:20'),
(349, 78, 66, 'uploads/homework_answers/ans_78_1779020747.pdf', '', '2026-05-17 12:25:47'),
(350, 77, 59, 'uploads/homework_answers/ans_77_1779027017.jpg', '', '2026-05-17 14:10:17'),
(351, 79, 71, 'uploads/homework_answers/ans_79_1779028966.jpg', '', '2026-05-17 14:42:46'),
(352, 76, 101, 'uploads/homework_answers/ans_76_1779029314.jpg', '', '2026-05-17 14:48:34'),
(353, 71, 71, 'uploads/homework_answers/ans_71_1779029880.pdf', '', '2026-05-17 14:58:00'),
(354, 78, 101, 'uploads/homework_answers/ans_78_1779030310.jpg', '', '2026-05-17 15:05:10'),
(355, 60, 89, 'uploads/homework_answers/ans_60_1779030908.jpeg', 'Done', '2026-05-17 15:15:08'),
(356, 77, 89, 'uploads/homework_answers/ans_77_1779030993.jpeg', 'Done', '2026-05-17 15:16:33'),
(357, 80, 89, 'uploads/homework_answers/ans_80_1779030983.jpeg', 'Done', '2026-05-17 15:16:23'),
(358, 78, 62, 'uploads/homework_answers/ans_78_1779031919.jpg', 'Teacher 8 have done all but I have put the first page only', '2026-05-17 15:31:59'),
(359, 67, 57, 'uploads/homework_answers/ans_67_1779032051.pdf', '', '2026-05-17 15:34:11'),
(360, 46, 62, 'uploads/homework_answers/ans_46_1779032084.jpg', '', '2026-05-17 15:34:44'),
(361, 80, 59, 'uploads/homework_answers/ans_80_1779032158.jpg', '', '2026-05-17 15:35:58'),
(362, 74, 73, 'uploads/homework_answers/ans_74_1779033202.jpg', '', '2026-05-17 15:53:22'),
(363, 80, 57, 'uploads/homework_answers/ans_80_1779033474.pdf', '', '2026-05-17 15:57:54'),
(364, 77, 57, 'uploads/homework_answers/ans_77_1779034772.jpg', '', '2026-05-17 16:19:32'),
(365, 70, 62, 'uploads/homework_answers/ans_70_1779036901.pdf', '', '2026-05-17 16:55:01'),
(366, 78, 81, 'uploads/homework_answers/ans_78_1779037027.jpg', '', '2026-05-17 16:57:07'),
(367, 44, 81, 'uploads/homework_answers/ans_44_1779037353.jpg', '', '2026-05-17 17:02:33'),
(368, 44, 37, 'uploads/homework_answers/ans_44_1779037733.pdf', 'Done', '2026-05-17 17:08:53'),
(369, 77, 88, 'uploads/homework_answers/ans_77_1779038104.jpg', '', '2026-05-17 17:15:04'),
(370, 70, 66, 'uploads/homework_answers/ans_70_1779039075.pdf', '', '2026-05-17 17:31:15'),
(371, 62, 61, 'uploads/homework_answers/ans_62_1779039883.jpg', '', '2026-05-17 17:44:43'),
(372, 80, 88, 'uploads/homework_answers/ans_80_1779041898.jpg', '', '2026-05-17 18:18:18'),
(373, 77, 87, 'uploads/homework_answers/ans_77_1779066985.png', '', '2026-05-18 01:16:25'),
(374, 80, 87, 'uploads/homework_answers/ans_80_1779112947.jpg', '', '2026-05-18 14:02:28'),
(375, 79, 72, 'uploads/homework_answers/ans_79_1779114085.pdf', '', '2026-05-18 14:21:25'),
(376, 78, 61, 'uploads/homework_answers/ans_78_1779117959.pdf', '', '2026-05-18 15:25:59'),
(380, 75, 72, 'uploads/homework_answers/ans_75_1779121109.pdf', '', '2026-05-18 16:18:29'),
(382, 76, 62, 'uploads/homework_answers/ans_76_1779127904.pdf', '', '2026-05-18 18:11:44'),
(383, 82, 103, 'uploads/homework_answers/ans_82_1779152135.jpg', '', '2026-05-19 00:55:35'),
(385, 84, 68, 'uploads/homework_answers/ans_84_1779190509.jpg', '', '2026-05-19 17:05:09'),
(386, 84, 69, 'uploads/homework_answers/ans_84_1779193525.jpg', 'Sir IAM not able to send the pdf I\'ll show at school', '2026-05-19 17:55:25'),
(387, 86, 69, 'uploads/homework_answers/ans_86_1779195008.jpg', 'I don\'t know the table to do', '2026-05-19 18:20:08'),
(388, 82, 93, 'uploads/homework_answers/ans_82_1779195738.pdf', 'Done all', '2026-05-19 18:32:18'),
(389, 88, 93, 'uploads/homework_answers/ans_88_1779196574.pdf', 'Done all', '2026-05-19 18:46:14'),
(390, 85, 69, 'uploads/homework_answers/ans_85_1779197952.pdf', 'I\'ll do other and show you at school sir', '2026-05-19 19:09:12'),
(392, 81, 68, 'uploads/homework_answers/ans_81_1779199284.jpg', '', '2026-05-19 19:31:24'),
(393, 85, 68, 'uploads/homework_answers/ans_85_1779200358.jpg', '', '2026-05-19 19:49:18'),
(394, 89, 93, 'uploads/homework_answers/ans_89_1779200444.pdf', 'Done all', '2026-05-19 19:50:44'),
(395, 86, 67, 'uploads/homework_answers/ans_86_1779201698.jpg', '', '2026-05-19 20:11:38'),
(396, 87, 93, 'uploads/homework_answers/ans_87_1779203249.pdf', 'The short answers have written down', '2026-05-19 20:37:29'),
(397, 82, 102, 'uploads/homework_answers/ans_82_1779204467.pdf', '', '2026-05-19 20:57:47'),
(398, 90, 47, 'uploads/homework_answers/ans_90_1779204693.jpg', '', '2026-05-19 21:01:33'),
(399, 37, 87, 'uploads/homework_answers/ans_37_1779204946.jpg', '', '2026-05-19 21:05:46'),
(400, 86, 68, 'uploads/homework_answers/ans_86_1779205163.jpg', '', '2026-05-19 21:09:23'),
(401, 88, 103, 'uploads/homework_answers/ans_88_1779205554.jpg', '', '2026-05-19 21:15:54'),
(402, 82, 100, 'uploads/homework_answers/ans_82_1779205772.jpg', '', '2026-05-19 21:19:32'),
(403, 78, 37, 'uploads/homework_answers/ans_78_1779206103.jpg', '', '2026-05-19 21:25:03'),
(404, 82, 105, 'uploads/homework_answers/ans_82_1779207049.pdf', '', '2026-05-19 21:40:49'),
(405, 84, 67, 'uploads/homework_answers/ans_84_1779207128.jpg', '', '2026-05-19 21:42:08'),
(407, 24, 80, 'uploads/homework_answers/ans_24_1779207622.jpg', '', '2026-05-19 21:50:22'),
(408, 85, 67, 'uploads/homework_answers/ans_85_1779208081.jpg', 'Done 2 questions rest of the questions doubt sir 👍🏻', '2026-05-19 21:58:01'),
(409, 89, 100, 'uploads/homework_answers/ans_89_1779208653.jpg', '', '2026-05-19 22:07:33'),
(410, 82, 92, 'uploads/homework_answers/ans_82_1779208678.pdf', '', '2026-05-19 22:07:58'),
(411, 89, 104, 'uploads/homework_answers/ans_89_1779209584.pdf', '', '2026-05-19 22:23:04'),
(412, 89, 92, 'uploads/homework_answers/ans_89_1779210679.pdf', '', '2026-05-19 22:41:19'),
(413, 87, 92, 'uploads/homework_answers/ans_87_1779210697.pdf', '', '2026-05-19 22:41:37'),
(414, 88, 92, 'uploads/homework_answers/ans_88_1779210717.pdf', '', '2026-05-19 22:41:57'),
(415, 89, 105, 'uploads/homework_answers/ans_89_1779210774.pdf', '', '2026-05-19 22:42:54'),
(416, 87, 105, 'uploads/homework_answers/ans_87_1779210792.pdf', '', '2026-05-19 22:43:12'),
(417, 88, 105, 'uploads/homework_answers/ans_88_1779210812.pdf', '', '2026-05-19 22:43:32'),
(418, 89, 102, 'uploads/homework_answers/ans_89_1779210982.pdf', '', '2026-05-19 22:46:22'),
(419, 84, 71, 'uploads/homework_answers/ans_84_1779211259.jpg', '', '2026-05-19 22:50:59'),
(420, 86, 80, 'uploads/homework_answers/ans_86_1779211738.jpg', '', '2026-05-19 22:58:58'),
(421, 42, 80, 'uploads/homework_answers/ans_42_1779212078.jpg', '', '2026-05-19 23:04:38'),
(422, 84, 70, 'uploads/homework_answers/ans_84_1779212450.jpg', '', '2026-05-19 23:10:50'),
(423, 84, 73, 'uploads/homework_answers/ans_84_1779213039.pdf', '', '2026-05-19 23:20:39'),
(424, 43, 80, 'uploads/homework_answers/ans_43_1779214018.jpg', '', '2026-05-19 23:36:58'),
(425, 85, 73, 'uploads/homework_answers/ans_85_1779214108.pdf', '', '2026-05-19 23:38:28'),
(426, 69, 80, 'uploads/homework_answers/ans_69_1779214287.jpg', '', '2026-05-19 23:41:27'),
(427, 87, 104, 'uploads/homework_answers/ans_87_1779214941.pdf', '', '2026-05-19 23:52:21'),
(429, 85, 70, 'uploads/homework_answers/ans_85_1779216811.jpg', '', '2026-05-20 00:23:31'),
(431, 89, 103, 'uploads/homework_answers/ans_89_1779240561.jpg', '', '2026-05-20 06:59:21'),
(432, 84, 76, 'uploads/homework_answers/ans_84_1779248244.pdf', '', '2026-05-20 09:07:24'),
(433, 44, 64, 'uploads/homework_answers/ans_44_1779259329.jpeg', '', '2026-05-20 12:12:09'),
(434, 46, 64, 'uploads/homework_answers/ans_46_1779259507.jpeg', '', '2026-05-20 12:15:07'),
(435, 92, 54, 'uploads/homework_answers/ans_92_1779269284.png', 'Science', '2026-05-20 14:58:04'),
(436, 82, 104, 'uploads/homework_answers/ans_82_1779270129.pdf', '', '2026-05-20 15:12:09'),
(437, 92, 59, 'uploads/homework_answers/ans_92_1779279422.jpg', '', '2026-05-20 17:47:02'),
(438, 92, 96, 'uploads/homework_answers/ans_92_1779280498.jpg', '', '2026-05-20 18:04:58'),
(439, 88, 104, 'uploads/homework_answers/ans_88_1779281617.pdf', '', '2026-05-20 18:23:37'),
(440, 87, 103, 'uploads/homework_answers/ans_87_1779282586.jpg', '', '2026-05-20 18:39:46'),
(441, 92, 87, 'uploads/homework_answers/ans_92_1779285636.jpg', '', '2026-05-20 19:30:36'),
(443, 46, 37, 'uploads/homework_answers/ans_46_1779286192.jpg', '', '2026-05-20 19:39:52'),
(444, 86, 70, 'uploads/homework_answers/ans_86_1779286957.pdf', '', '2026-05-20 19:52:37'),
(445, 91, 70, 'uploads/homework_answers/ans_91_1779286974.pdf', '', '2026-05-20 19:52:54'),
(446, 90, 48, 'uploads/homework_answers/ans_90_1779288693.jpg', '', '2026-05-20 20:21:33'),
(447, 92, 89, 'uploads/homework_answers/ans_92_1779288878.jpeg', 'Done', '2026-05-20 20:24:38'),
(448, 88, 100, 'uploads/homework_answers/ans_88_1779290087.pdf', '', '2026-05-20 20:44:47'),
(449, 93, 54, 'uploads/homework_answers/ans_93_1779290202.jpg', 'Maths', '2026-05-20 20:46:42'),
(450, 38, 72, 'uploads/homework_answers/ans_38_1779290736.jpg', 'Done sir', '2026-05-20 20:55:36'),
(451, 84, 72, 'uploads/homework_answers/ans_84_1779290909.jpg', '', '2026-05-20 20:58:29'),
(454, 92, 57, 'uploads/homework_answers/ans_92_1779291556.jpg', '', '2026-05-20 21:09:16'),
(455, 78, 64, 'uploads/homework_answers/ans_78_1779291616.jpg', 'Done', '2026-05-20 21:10:16'),
(456, 85, 72, 'uploads/homework_answers/ans_85_1779292292.jpg', '', '2026-05-20 21:21:32'),
(457, 86, 72, 'uploads/homework_answers/ans_86_1779292678.jpg', 'Done', '2026-05-20 21:27:58'),
(458, 71, 72, 'uploads/homework_answers/ans_71_1779293024.jpg', 'Done', '2026-05-20 21:33:44'),
(459, 93, 57, 'uploads/homework_answers/ans_93_1779293083.jpg', '', '2026-05-20 21:34:43'),
(460, 93, 89, 'uploads/homework_answers/ans_93_1779293421.jpg', '', '2026-05-20 21:40:21'),
(461, 92, 58, 'uploads/homework_answers/ans_92_1779293489.jpg', '', '2026-05-20 21:41:29'),
(462, 93, 58, 'uploads/homework_answers/ans_93_1779293621.jpg', '', '2026-05-20 21:43:41'),
(463, 62, 65, 'uploads/homework_answers/ans_62_1779293698.jpg', '', '2026-05-20 21:44:58'),
(464, 86, 71, 'uploads/homework_answers/ans_86_1779293806.pdf', '', '2026-05-20 21:46:46'),
(465, 91, 72, 'uploads/homework_answers/ans_91_1779293811.jpg', '', '2026-05-20 21:46:51'),
(466, 92, 88, 'uploads/homework_answers/ans_92_1779293829.jpg', '', '2026-05-20 21:47:09'),
(467, 91, 71, 'uploads/homework_answers/ans_91_1779294614.pdf', '', '2026-05-20 22:00:14'),
(468, 27, 72, 'uploads/homework_answers/ans_27_1779294794.jpg', '', '2026-05-20 22:03:14'),
(469, 93, 88, 'uploads/homework_answers/ans_93_1779296290.jpg', '', '2026-05-20 22:28:10'),
(471, 78, 65, 'uploads/homework_answers/ans_78_1779299467.jpg', '', '2026-05-20 23:21:07'),
(472, 76, 65, 'uploads/homework_answers/ans_76_1779299565.jpg', '', '2026-05-20 23:22:45'),
(473, 79, 80, 'uploads/homework_answers/ans_79_1779300701.jpg', '', '2026-05-20 23:41:41'),
(474, 84, 80, 'uploads/homework_answers/ans_84_1779300834.jpg', '', '2026-05-20 23:43:54'),
(475, 93, 87, 'uploads/homework_answers/ans_93_1779303195.jpg', '', '2026-05-21 00:23:15'),
(476, 62, 81, 'uploads/homework_answers/ans_62_1779304301.jpg', '', '2026-05-21 00:41:41'),
(477, 87, 100, 'uploads/homework_answers/ans_87_1779331919.pdf', '', '2026-05-21 08:21:59'),
(478, 94, 51, 'uploads/homework_answers/ans_94_1779333948.jpeg', '', '2026-05-21 08:55:48'),
(479, 94, 107, 'uploads/homework_answers/ans_94_1779357889.jpg', '', '2026-05-21 15:34:49'),
(480, 58, 107, 'uploads/homework_answers/ans_58_1779359063.jpg', '', '2026-05-21 15:54:23'),
(481, 73, 107, 'uploads/homework_answers/ans_73_1779360166.jpg', '', '2026-05-21 16:12:46'),
(482, 95, 107, 'uploads/homework_answers/ans_95_1779360984.jpg', '', '2026-05-21 16:26:24'),
(483, 83, 61, 'uploads/homework_answers/ans_83_1779367884.pdf', '', '2026-05-21 18:21:24'),
(484, 62, 64, 'uploads/homework_answers/ans_62_1779370757.jpg', '', '2026-05-21 19:09:17'),
(485, 23, 37, 'uploads/homework_answers/ans_23_1779372384.jpg', '', '2026-05-21 19:36:24'),
(486, 25, 37, 'uploads/homework_answers/ans_25_1779372710.jpg', '', '2026-05-21 19:41:50'),
(487, 93, 59, 'uploads/homework_answers/ans_93_1779373187.jpg', '', '2026-05-21 19:49:47'),
(488, 39, 64, 'uploads/homework_answers/ans_39_1779374376.jpg', '', '2026-05-21 20:09:36'),
(489, 16, 39, 'uploads/homework_answers/ans_16_1779376531.jpg', '', '2026-05-21 20:45:31'),
(490, 83, 62, 'uploads/homework_answers/ans_83_1779377155.pdf', '', '2026-05-21 20:55:55'),
(491, 20, 39, 'uploads/homework_answers/ans_20_1779377637.jpg', '', '2026-05-21 21:03:57'),
(492, 19, 39, 'uploads/homework_answers/ans_19_1779378084.pdf', '', '2026-05-21 21:11:24'),
(493, 23, 39, 'uploads/homework_answers/ans_23_1779380068.jpg', '', '2026-05-21 21:44:28'),
(494, 93, 96, 'uploads/homework_answers/ans_93_1779380726.pdf', '', '2026-05-21 21:55:26'),
(495, 83, 65, 'uploads/homework_answers/ans_83_1779385192.jpg', '', '2026-05-21 23:09:52'),
(496, 39, 65, 'uploads/homework_answers/ans_39_1779385514.jpg', '', '2026-05-21 23:15:14'),
(497, 44, 65, 'uploads/homework_answers/ans_44_1779388118.jpg', '', '2026-05-21 23:58:38'),
(498, 72, 65, 'uploads/homework_answers/ans_72_1779388665.jpg', '', '2026-05-22 00:07:45'),
(499, 33, 37, 'uploads/homework_answers/ans_33_1779411805.jpg', '', '2026-05-22 06:33:25'),
(500, 39, 37, 'uploads/homework_answers/ans_39_1779412040.jpg', '', '2026-05-22 06:37:20'),
(501, 95, 51, 'uploads/homework_answers/ans_95_1779413051.jpg', '', '2026-05-22 06:54:11'),
(502, 70, 39, 'uploads/homework_answers/ans_70_1779446017.pdf', '', '2026-05-22 16:03:37'),
(503, 32, 39, 'uploads/homework_answers/ans_32_1779447611.pdf', '', '2026-05-22 16:30:11'),
(504, 73, 49, 'uploads/homework_answers/ans_73_1779457553.jpg', '', '2026-05-22 19:15:53'),
(505, 95, 49, 'uploads/homework_answers/ans_95_1779461078.jpg', '', '2026-05-22 20:14:38'),
(506, 94, 49, 'uploads/homework_answers/ans_94_1779462130.jpg', '', '2026-05-22 20:32:10'),
(507, 15, 80, 'uploads/homework_answers/ans_15_1779469729.jpg', '', '2026-05-22 22:38:49'),
(508, 96, 47, NULL, '', '2026-05-23 13:36:42'),
(510, 76, 38, 'uploads/homework_answers/ans_76_1779548681.pdf', 'Done👍', '2026-05-23 20:34:41'),
(511, 97, 101, 'uploads/homework_answers/ans_97_1779549148.pdf', '', '2026-05-23 20:42:28'),
(512, 97, 110, 'uploads/homework_answers/ans_97_1779549584.pdf', 'Q: Why can\'t I select multiple photos in my gallery?', '2026-05-23 20:49:44'),
(513, 26, 39, 'uploads/homework_answers/ans_26_1779550696.pdf', '', '2026-05-23 21:08:16'),
(514, 97, 62, 'uploads/homework_answers/ans_97_1779551155.pdf', 'Equations', '2026-05-23 21:15:55'),
(515, 39, 39, 'uploads/homework_answers/ans_39_1779552063.pdf', '', '2026-05-23 21:31:03'),
(516, 83, 39, 'uploads/homework_answers/ans_83_1779552348.pdf', '', '2026-05-23 21:35:48'),
(517, 97, 39, 'uploads/homework_answers/ans_97_1779555945.jpg', '', '2026-05-23 22:35:45'),
(518, 97, 81, 'uploads/homework_answers/ans_97_1779560562.jpg', 'Sir i do know how make a PDF so i will show the balance in tomorrow’s class', '2026-05-23 23:52:42'),
(519, 26, 81, 'uploads/homework_answers/ans_26_1779560693.jpg', '', '2026-05-23 23:54:53'),
(520, 97, 65, 'uploads/homework_answers/ans_97_1779561026.jpg', '', '2026-05-24 00:00:26'),
(522, 26, 65, 'uploads/homework_answers/ans_26_1779561801.jpg', '', '2026-05-24 00:13:21'),
(523, 33, 65, 'uploads/homework_answers/ans_33_1779561921.jpg', '', '2026-05-24 00:15:21'),
(525, 88, 102, 'uploads/homework_answers/ans_88_1779596456.jpg', 'Madam more than I can\'t so the remaining balance I\'ll show in the school', '2026-05-24 09:50:56'),
(526, 96, 48, 'uploads/homework_answers/ans_96_1779628997.jpg', '', '2026-05-24 18:53:17'),
(527, 79, 76, 'uploads/homework_answers/ans_79_1779631529.jpg', '', '2026-05-24 19:35:29'),
(528, 85, 76, 'uploads/homework_answers/ans_85_1779632127.jpg', '', '2026-05-24 19:45:27'),
(529, 86, 76, 'uploads/homework_answers/ans_86_1779632718.jpg', '', '2026-05-24 19:55:18'),
(530, 17, 76, 'uploads/homework_answers/ans_17_1779633024.jpg', '', '2026-05-24 20:00:24'),
(531, 69, 76, 'uploads/homework_answers/ans_69_1779633203.jpg', '', '2026-05-24 20:03:23'),
(532, 87, 108, 'uploads/homework_answers/ans_87_1779634399.pdf', '', '2026-05-24 20:23:19'),
(533, 33, 39, 'uploads/homework_answers/ans_33_1779634922.jpg', '', '2026-05-24 20:32:02'),
(534, 99, 68, 'uploads/homework_answers/ans_99_1779637414.jpg', '', '2026-05-24 21:13:34'),
(535, 68, 39, 'uploads/homework_answers/ans_68_1779637457.pdf', '', '2026-05-24 21:14:17'),
(536, 98, 54, 'uploads/homework_answers/ans_98_1779637773.png', 'History', '2026-05-24 21:19:33'),
(537, 78, 39, 'uploads/homework_answers/ans_78_1779638411.pdf', '', '2026-05-24 21:30:11'),
(538, 63, 39, 'uploads/homework_answers/ans_63_1779639638.jpg', '', '2026-05-24 21:50:39'),
(539, 98, 58, 'uploads/homework_answers/ans_98_1779639879.jpg', '', '2026-05-24 21:54:39'),
(540, 99, 73, 'uploads/homework_answers/ans_99_1779642594.jpg', '', '2026-05-24 22:39:54'),
(541, 46, 39, 'uploads/homework_answers/ans_46_1779644275.pdf', '', '2026-05-24 23:07:55'),
(542, 99, 70, 'uploads/homework_answers/ans_99_1779646529.jpg', '', '2026-05-24 23:45:29'),
(543, 99, 69, 'uploads/homework_answers/ans_99_1779712766.pdf', 'Done madam', '2026-05-25 18:09:26'),
(544, 100, 54, 'uploads/homework_answers/ans_100_1779716901.jpg', 'Maths', '2026-05-25 19:18:21'),
(545, 99, 76, 'uploads/homework_answers/ans_99_1779719065.jpg', '', '2026-05-25 19:54:25'),
(546, 98, 87, 'uploads/homework_answers/ans_98_1779720706.jpg', '', '2026-05-25 20:21:46'),
(547, 99, 106, 'uploads/homework_answers/ans_99_1779721322.pdf', '', '2026-05-25 20:32:02'),
(549, 79, 106, 'uploads/homework_answers/ans_79_1779724981.pdf', '', '2026-05-25 21:33:01'),
(550, 99, 72, 'uploads/homework_answers/ans_99_1779724275.jpg', '', '2026-05-25 21:21:15'),
(551, 74, 106, 'uploads/homework_answers/ans_74_1779724970.pdf', '', '2026-05-25 21:32:50'),
(552, 100, 58, 'uploads/homework_answers/ans_100_1779725043.jpg', 'Madam I can\'t understand 2nd 4th 5th 6th question', '2026-05-25 21:34:03'),
(553, 99, 67, 'uploads/homework_answers/ans_99_1779725499.jpg', '', '2026-05-25 21:41:39'),
(555, 101, 100, 'uploads/homework_answers/ans_101_1779790630.jpg', '', '2026-05-26 15:47:10'),
(556, 98, 59, 'uploads/homework_answers/ans_98_1779799961.jpg', '', '2026-05-26 18:22:41'),
(557, 101, 93, 'uploads/homework_answers/ans_101_1779807065.jpg', 'Finished', '2026-05-26 20:21:05'),
(558, 83, 81, 'uploads/homework_answers/ans_83_1779808460.jpg', '', '2026-05-26 20:44:20'),
(559, 100, 57, 'uploads/homework_answers/ans_100_1779816117.jpg', '', '2026-05-26 22:51:57'),
(560, 98, 57, 'uploads/homework_answers/ans_98_1779816156.jpg', '', '2026-05-26 22:52:36'),
(561, 98, 88, 'uploads/homework_answers/ans_98_1779819459.jpg', '', '2026-05-26 23:47:39'),
(562, 100, 88, 'uploads/homework_answers/ans_100_1779819728.jpg', '', '2026-05-26 23:52:08'),
(563, 100, 59, 'uploads/homework_answers/ans_100_1779841029.jpg', '', '2026-05-27 05:47:09'),
(564, 101, 108, 'uploads/homework_answers/ans_101_1780064415.pdf', '', '2026-05-29 19:50:15'),
(565, 103, 104, 'uploads/homework_answers/ans_103_1780168282.pdf', '', '2026-05-31 00:41:22'),
(566, 103, 100, 'uploads/homework_answers/ans_103_1780201725.jpg', '', '2026-05-31 09:58:45'),
(567, 102, 54, 'uploads/homework_answers/ans_102_1780213202.jpg', 'Sinhala', '2026-05-31 13:10:02'),
(568, 97, 64, 'uploads/homework_answers/ans_97_1780239161.jpg', 'Done', '2026-05-31 20:22:41'),
(569, 103, 105, 'uploads/homework_answers/ans_103_1780244586.jpg', '', '2026-05-31 21:53:06'),
(570, 102, 58, 'uploads/homework_answers/ans_102_1780312974.jpg', '', '2026-06-01 16:52:54'),
(571, 103, 93, 'uploads/homework_answers/ans_103_1780316097.pdf', 'I did not do the the third question third part because i did not understand', '2026-06-01 17:44:57'),
(572, 104, 68, 'uploads/homework_answers/ans_104_1780318716.jpg', 'Done', '2026-06-01 18:28:36'),
(573, 105, 68, 'uploads/homework_answers/ans_105_1780320096.jpg', '', '2026-06-01 18:51:36'),
(574, 98, 96, 'uploads/homework_answers/ans_98_1780321850.jpg', '', '2026-06-01 19:20:50'),
(575, 105, 72, 'uploads/homework_answers/ans_105_1780322104.jpg', 'Dear teacher I will show the remaining work tomorrow on school \r\n\r\n\r\nKABEER', '2026-06-01 19:25:04'),
(576, 103, 103, 'uploads/homework_answers/ans_103_1780323011.jpg', '', '2026-06-01 19:40:11'),
(577, 100, 96, 'uploads/homework_answers/ans_100_1780323282.jpg', '', '2026-06-01 19:44:42'),
(578, 106, 112, 'uploads/homework_answers/ans_106_1780323498.pdf', '', '2026-06-01 19:48:18'),
(579, 104, 69, 'uploads/homework_answers/ans_104_1780323984.pdf', 'Sir I don\'t know the b part', '2026-06-01 19:56:24'),
(580, 106, 54, 'uploads/homework_answers/ans_106_1780324070.jpg', 'Maths', '2026-06-01 19:57:50'),
(581, 106, 96, 'uploads/homework_answers/ans_106_1780324190.jpg', '', '2026-06-01 19:59:50'),
(582, 104, 72, 'uploads/homework_answers/ans_104_1780324386.jpg', 'Sir I will show the remaining works on the school', '2026-06-01 20:03:06'),
(583, 105, 69, 'uploads/homework_answers/ans_105_1780324672.jpg', 'I don\'t the two questions answer', '2026-06-01 20:07:52'),
(584, 105, 70, 'uploads/homework_answers/ans_105_1780325041.pdf', '', '2026-06-01 20:14:01'),
(585, 104, 67, 'uploads/homework_answers/ans_104_1780325658.jpg', 'Done with the questions sir couldn\'t upload the pdf sir', '2026-06-01 20:24:18'),
(586, 105, 106, 'uploads/homework_answers/ans_105_1780325870.pdf', '', '2026-06-01 20:27:50'),
(587, 106, 57, 'uploads/homework_answers/ans_106_1780326503.jpg', '', '2026-06-01 20:38:23'),
(588, 107, 65, 'uploads/homework_answers/ans_107_1780327020.jpg', 'Done', '2026-06-01 20:47:00'),
(589, 108, 103, 'uploads/homework_answers/ans_108_1780327375.jpg', '', '2026-06-01 20:52:55'),
(590, 106, 59, 'uploads/homework_answers/ans_106_1780327654.jpg', '', '2026-06-01 20:57:34'),
(591, 108, 105, 'uploads/homework_answers/ans_108_1780328150.jpg', '', '2026-06-01 21:05:50'),
(592, 108, 93, 'uploads/homework_answers/ans_108_1780328354.pdf', 'Finished everything', '2026-06-01 21:09:14');
INSERT INTO `homework_submissions` (`id`, `homework_id`, `student_id`, `file_path`, `note`, `submitted_at`) VALUES
(593, 102, 88, 'uploads/homework_answers/ans_102_1780328388.jpg', '', '2026-06-01 21:09:48'),
(594, 106, 89, 'uploads/homework_answers/ans_106_1780328713.jpg', '', '2026-06-01 21:15:13'),
(595, 107, 81, 'uploads/homework_answers/ans_107_1780328774.jpg', '', '2026-06-01 21:16:14'),
(596, 105, 67, 'uploads/homework_answers/ans_105_1780328774.jpg', '', '2026-06-01 21:16:14'),
(597, 9, 81, 'uploads/homework_answers/ans_9_1780328827.jpg', '', '2026-06-01 21:17:07'),
(598, 106, 88, NULL, '', '2026-06-01 21:33:09'),
(599, 107, 38, 'uploads/homework_answers/ans_107_1780330065.pdf', 'Done', '2026-06-01 21:37:45'),
(600, 110, 57, 'uploads/homework_answers/ans_110_1780330620.jpg', '', '2026-06-01 21:47:00'),
(601, 110, 59, 'uploads/homework_answers/ans_110_1780331151.jpg', '', '2026-06-01 21:55:51'),
(603, 83, 64, 'uploads/homework_answers/ans_83_1780331581.jpg', 'Done', '2026-06-01 22:03:01'),
(604, 102, 89, 'uploads/homework_answers/ans_102_1780331600.jpg', 'Done', '2026-06-01 22:03:20'),
(605, 26, 64, 'uploads/homework_answers/ans_26_1780331637.jpg', 'Done', '2026-06-01 22:03:57'),
(606, 107, 61, 'uploads/homework_answers/ans_107_1780331967.jpg', '', '2026-06-01 22:09:27'),
(607, 112, 105, 'uploads/homework_answers/ans_112_1780333178.jpg', '', '2026-06-01 22:29:38'),
(608, 108, 104, 'uploads/homework_answers/ans_108_1780333450.pdf', '', '2026-06-01 22:34:10'),
(609, 107, 64, 'uploads/homework_answers/ans_107_1780333617.jpg', 'Done', '2026-06-01 22:36:57'),
(610, 104, 73, 'uploads/homework_answers/ans_104_1780333642.pdf', 'Sir I’m finding difficulties in doing part 2. Need a thorough explanation', '2026-06-01 22:37:22'),
(611, 111, 105, 'uploads/homework_answers/ans_111_1780334278.jpg', '', '2026-06-01 22:47:58'),
(612, 103, 92, 'uploads/homework_answers/ans_103_1780334907.pdf', '', '2026-06-01 22:58:27'),
(613, 105, 80, 'uploads/homework_answers/ans_105_1780335372.jpg', '', '2026-06-01 23:06:12'),
(614, 107, 62, 'uploads/homework_answers/ans_107_1780335677.pdf', '', '2026-06-01 23:11:17'),
(615, 105, 73, 'uploads/homework_answers/ans_105_1780335894.pdf', '', '2026-06-01 23:14:54'),
(616, 111, 104, 'uploads/homework_answers/ans_111_1780338066.pdf', '', '2026-06-01 23:51:06'),
(618, 114, 65, 'uploads/homework_answers/ans_114_1780339562.jpeg', '', '2026-06-02 00:16:02'),
(620, 112, 104, 'uploads/homework_answers/ans_112_1780340449.pdf', '', '2026-06-02 00:30:49'),
(621, 111, 92, 'uploads/homework_answers/ans_111_1780340834.pdf', '', '2026-06-02 00:37:14'),
(622, 112, 92, 'uploads/homework_answers/ans_112_1780340865.pdf', '', '2026-06-02 00:37:45'),
(623, 107, 39, 'uploads/homework_answers/ans_107_1780343605.pdf', '', '2026-06-02 01:23:25'),
(624, 116, 101, 'uploads/homework_answers/ans_116_1780361561.jpg', '', '2026-06-02 06:22:41'),
(625, 107, 101, 'uploads/homework_answers/ans_107_1780362286.jpg', '', '2026-06-02 06:34:46'),
(626, 114, 101, 'uploads/homework_answers/ans_114_1780363459.jpg', '', '2026-06-02 06:54:19'),
(627, 106, 87, 'uploads/homework_answers/ans_106_1780363868.jpg', '', '2026-06-02 07:01:08'),
(628, 107, 37, 'uploads/homework_answers/ans_107_1780365500.jpg', '', '2026-06-02 07:28:20'),
(629, 106, 58, 'uploads/homework_answers/ans_106_1780380499.jpg', '', '2026-06-02 11:38:19'),
(630, 110, 96, 'uploads/homework_answers/ans_110_1780393708.jpg', 'Madam.I did activity 3.3 I can\'t make pdf', '2026-06-02 15:18:28'),
(631, 113, 68, 'uploads/homework_answers/ans_113_1780394522.jpg', 'Done', '2026-06-02 15:32:02'),
(632, 117, 59, 'uploads/homework_answers/ans_117_1780394588.pdf', '', '2026-06-02 15:33:08'),
(633, 110, 54, 'uploads/homework_answers/ans_110_1780396144.jpg', 'ICT', '2026-06-02 15:59:04'),
(634, 116, 65, 'uploads/homework_answers/ans_116_1780396274.jpg', 'Done madam', '2026-06-02 16:01:14'),
(635, 112, 93, 'uploads/homework_answers/ans_112_1780398620.pdf', 'Finished', '2026-06-02 16:40:20'),
(636, 115, 65, 'uploads/homework_answers/ans_115_1780401082.jpg', 'Done', '2026-06-02 17:21:22'),
(637, 122, 47, 'uploads/homework_answers/ans_122_1780402417.jpg', '', '2026-06-02 17:43:37'),
(638, 120, 47, 'uploads/homework_answers/ans_120_1780402483.jpg', '', '2026-06-02 17:44:43'),
(639, 121, 68, 'uploads/homework_answers/ans_121_1780403334.jpg', '', '2026-06-02 17:58:54'),
(640, 107, 110, 'uploads/homework_answers/ans_107_1780403804.pdf', '', '2026-06-02 18:06:44'),
(641, 117, 54, 'uploads/homework_answers/ans_117_1780404733.jpg', 'Islam', '2026-06-02 18:22:13'),
(642, 118, 93, 'uploads/homework_answers/ans_118_1780405493.pdf', '1st excercise 3rd question i dont know', '2026-06-02 18:34:53'),
(643, 116, 110, 'uploads/homework_answers/ans_116_1780405790.pdf', '', '2026-06-02 18:39:50'),
(644, 112, 103, 'uploads/homework_answers/ans_112_1780405844.jpg', '', '2026-06-02 18:40:44'),
(645, 112, 108, 'uploads/homework_answers/ans_112_1780406845.pdf', '', '2026-06-02 18:57:25'),
(646, 123, 68, 'uploads/homework_answers/ans_123_1780407267.jpg', '', '2026-06-02 19:04:27'),
(647, 111, 103, 'uploads/homework_answers/ans_111_1780407368.jpg', '', '2026-06-02 19:06:08'),
(649, 109, 47, 'uploads/homework_answers/ans_109_1780408305.jpg', '', '2026-06-02 19:21:45'),
(650, 112, 100, 'uploads/homework_answers/ans_112_1780408342.jpg', '', '2026-06-02 19:22:22'),
(651, 117, 58, 'uploads/homework_answers/ans_117_1780408581.jpg', '', '2026-06-02 19:26:21'),
(652, 102, 96, 'uploads/homework_answers/ans_102_1780409032.jpg', 'Sorry madam .I can\'t make pdf ther is a error', '2026-06-02 19:33:52'),
(653, 108, 113, 'uploads/homework_answers/ans_108_1780409097.jpg', '', '2026-06-02 19:34:57'),
(654, 110, 58, 'uploads/homework_answers/ans_110_1780409132.jpg', '', '2026-06-02 19:35:32'),
(655, 126, 58, 'uploads/homework_answers/ans_126_1780410206.jpg', '', '2026-06-02 19:53:26'),
(656, 111, 93, 'uploads/homework_answers/ans_111_1780410451.pdf', 'Done all the questions', '2026-06-02 19:57:31'),
(657, 124, 68, 'uploads/homework_answers/ans_124_1780410570.jpg', 'Done', '2026-06-02 19:59:30'),
(658, 117, 57, 'uploads/homework_answers/ans_117_1780410784.jpg', '', '2026-06-02 20:03:04'),
(659, 104, 70, 'uploads/homework_answers/ans_104_1780411095.pdf', '', '2026-06-02 20:08:15'),
(660, 117, 88, 'uploads/homework_answers/ans_117_1780411264.jpg', '', '2026-06-02 20:11:04'),
(661, 116, 61, 'uploads/homework_answers/ans_116_1780411557.pdf', '', '2026-06-02 20:15:57'),
(662, 126, 57, 'uploads/homework_answers/ans_126_1780411769.jpg', '', '2026-06-02 20:19:29'),
(663, 124, 67, 'uploads/homework_answers/ans_124_1780411893.jpg', '', '2026-06-02 20:21:33'),
(664, 118, 53, 'uploads/homework_answers/ans_118_1780412385.jpg', '', '2026-06-02 20:29:45'),
(665, 112, 113, 'uploads/homework_answers/ans_112_1780412490.jpg', '', '2026-06-02 20:31:30'),
(666, 127, 68, 'uploads/homework_answers/ans_127_1780412742.jpg', 'Done', '2026-06-02 20:35:42'),
(667, 131, 113, 'uploads/homework_answers/ans_131_1780412893.jpg', '', '2026-06-02 20:38:13'),
(668, 97, 61, 'uploads/homework_answers/ans_97_1780412902.pdf', '', '2026-06-02 20:38:22'),
(669, 109, 48, 'uploads/homework_answers/ans_109_1780412983.jpg', 'For the 4th question to draw the images it was not clear so I didn\'t draw it.', '2026-06-02 20:39:43'),
(670, 129, 104, 'uploads/homework_answers/ans_129_1780413177.pdf', '', '2026-06-02 20:42:57'),
(671, 116, 38, 'uploads/homework_answers/ans_116_1780413280.jpg', 'Done', '2026-06-02 20:44:40'),
(672, 108, 108, 'uploads/homework_answers/ans_108_1780413292.pdf', '', '2026-06-02 20:44:52'),
(673, 126, 88, 'uploads/homework_answers/ans_126_1780413402.jpg', '', '2026-06-02 20:46:42'),
(674, 127, 106, 'uploads/homework_answers/ans_127_1780413653.pdf', '', '2026-06-02 20:50:53'),
(675, 114, 64, 'uploads/homework_answers/ans_114_1780413738.jpg', 'Done', '2026-06-02 20:52:18'),
(677, 101, 53, 'uploads/homework_answers/ans_101_1780413992.jpg', '', '2026-06-02 20:56:32'),
(678, 129, 113, 'uploads/homework_answers/ans_129_1780414117.jpg', '', '2026-06-02 20:58:37'),
(679, 128, 48, 'uploads/homework_answers/ans_128_1780414433.jpg', '', '2026-06-02 21:03:53'),
(680, 131, 103, 'uploads/homework_answers/ans_131_1780414627.jpg', '', '2026-06-02 21:07:07'),
(681, 126, 59, 'uploads/homework_answers/ans_126_1780414712.jpg', '', '2026-06-02 21:08:32'),
(682, 119, 106, 'uploads/homework_answers/ans_119_1780414905.pdf', '', '2026-06-02 21:11:45'),
(683, 126, 89, 'uploads/homework_answers/ans_126_1780415072.jpg', 'Done', '2026-06-02 21:14:32'),
(684, 116, 64, 'uploads/homework_answers/ans_116_1780415421.jpg', 'Done', '2026-06-02 21:20:21'),
(685, 127, 73, 'uploads/homework_answers/ans_127_1780415480.pdf', '', '2026-06-02 21:21:20'),
(686, 121, 67, 'uploads/homework_answers/ans_121_1780415585.jpg', '', '2026-06-02 21:23:05'),
(687, 107, 66, 'uploads/homework_answers/ans_107_1780415701.pdf', '', '2026-06-02 21:25:01'),
(688, 113, 67, 'uploads/homework_answers/ans_113_1780415800.jpg', '', '2026-06-02 21:26:40'),
(689, 115, 38, 'uploads/homework_answers/ans_115_1780415981.jpg', '', '2026-06-02 21:29:41'),
(690, 126, 54, 'uploads/homework_answers/ans_126_1780416063.jpg', '', '2026-06-02 21:31:03'),
(691, 116, 39, 'uploads/homework_answers/ans_116_1780416191.pdf', '', '2026-06-02 21:33:11'),
(693, 128, 47, 'uploads/homework_answers/ans_128_1780416285.jpg', '', '2026-06-02 21:34:45'),
(694, 115, 81, 'uploads/homework_answers/ans_115_1780416386.jpg', '', '2026-06-02 21:36:26'),
(695, 20, 81, 'uploads/homework_answers/ans_20_1780416416.jpg', '', '2026-06-02 21:36:56'),
(696, 114, 81, 'uploads/homework_answers/ans_114_1780416456.jpeg', '', '2026-06-02 21:37:36'),
(697, 125, 62, 'uploads/homework_answers/ans_125_1780416598.pdf', '', '2026-06-02 21:39:58'),
(698, 129, 100, 'uploads/homework_answers/ans_129_1780416723.jpg', '', '2026-06-02 21:42:03'),
(699, 129, 103, 'uploads/homework_answers/ans_129_1780416850.jpg', '', '2026-06-02 21:44:10'),
(700, 130, 48, 'uploads/homework_answers/ans_130_1780417223.jpg', '', '2026-06-02 21:50:23'),
(701, 116, 66, 'uploads/homework_answers/ans_116_1780417752.pdf', '', '2026-06-02 21:59:12'),
(702, 108, 100, 'uploads/homework_answers/ans_108_1780417775.jpg', '', '2026-06-02 21:59:35'),
(704, 9, 65, 'uploads/homework_answers/ans_9_1780418207.jpg', '', '2026-06-02 22:06:47'),
(705, 130, 47, 'uploads/homework_answers/ans_130_1780418293.jpg', '', '2026-06-02 22:08:13'),
(706, 125, 101, 'uploads/homework_answers/ans_125_1780418438.pdf', '', '2026-06-02 22:10:38'),
(707, 114, 38, 'uploads/homework_answers/ans_114_1780418678.pdf', '👍🏼', '2026-06-02 22:14:38'),
(708, 116, 81, 'uploads/homework_answers/ans_116_1780418913.jpeg', '', '2026-06-02 22:18:33'),
(709, 113, 69, 'uploads/homework_answers/ans_113_1780419194.jpg', 'Done', '2026-06-02 22:23:14'),
(710, 124, 69, 'uploads/homework_answers/ans_124_1780419290.jpg', '', '2026-06-02 22:24:50'),
(711, 114, 61, 'uploads/homework_answers/ans_114_1780419554.jpg', '', '2026-06-02 22:29:14'),
(712, 119, 67, 'uploads/homework_answers/ans_119_1780420187.jpg', '', '2026-06-02 22:39:47'),
(713, 116, 37, 'uploads/homework_answers/ans_116_1780420243.jpg', '', '2026-06-02 22:40:43'),
(714, 131, 100, 'uploads/homework_answers/ans_131_1780420314.jpg', '', '2026-06-02 22:41:54'),
(715, 103, 53, 'uploads/homework_answers/ans_103_1780420408.jpg', '', '2026-06-02 22:43:28'),
(716, 111, 113, 'uploads/homework_answers/ans_111_1780420427.jpg', '', '2026-06-02 22:43:47'),
(717, 115, 101, 'uploads/homework_answers/ans_115_1780420466.jpg', '', '2026-06-02 22:44:26'),
(718, 127, 69, 'uploads/homework_answers/ans_127_1780420561.pdf', '', '2026-06-02 22:46:01'),
(719, 115, 66, 'uploads/homework_answers/ans_115_1780420690.jpg', '', '2026-06-02 22:48:10'),
(720, 39, 61, 'uploads/homework_answers/ans_39_1780420786.jpg', '', '2026-06-02 22:49:46'),
(722, 114, 37, 'uploads/homework_answers/ans_114_1780421097.jpg', '', '2026-06-02 22:54:57'),
(723, 127, 67, 'uploads/homework_answers/ans_127_1780421247.jpg', '', '2026-06-02 22:57:27'),
(725, 62, 37, 'uploads/homework_answers/ans_62_1780421417.jpg', '', '2026-06-02 23:00:17'),
(726, 68, 37, 'uploads/homework_answers/ans_68_1780421603.jpg', '', '2026-06-02 23:03:23'),
(727, 76, 37, 'uploads/homework_answers/ans_76_1780421740.jpg', '', '2026-06-02 23:05:40'),
(728, 127, 70, 'uploads/homework_answers/ans_127_1780421767.pdf', '', '2026-06-02 23:06:07'),
(729, 131, 104, 'uploads/homework_answers/ans_131_1780423392.pdf', '', '2026-06-02 23:33:12'),
(730, 115, 37, 'uploads/homework_answers/ans_115_1780423477.jpg', '', '2026-06-02 23:34:37'),
(731, 113, 106, 'uploads/homework_answers/ans_113_1780423629.pdf', '', '2026-06-02 23:37:09'),
(732, 115, 39, 'uploads/homework_answers/ans_115_1780423741.jpg', '', '2026-06-02 23:39:01'),
(734, 83, 37, 'uploads/homework_answers/ans_83_1780424142.jpg', '', '2026-06-02 23:45:42'),
(735, 125, 61, 'uploads/homework_answers/ans_125_1780424980.pdf', '', '2026-06-02 23:59:40'),
(736, 97, 37, 'uploads/homework_answers/ans_97_1780425308.jpg', '', '2026-06-03 00:05:08'),
(737, 126, 112, 'uploads/homework_answers/ans_126_1780457473.jpeg', '', '2026-06-03 09:01:13'),
(738, 129, 93, 'uploads/homework_answers/ans_129_1780457953.jpeg', '', '2026-06-03 09:09:13'),
(739, 108, 102, 'uploads/homework_answers/ans_108_1780458047.jpg', '', '2026-06-03 09:10:47'),
(740, 118, 100, 'uploads/homework_answers/ans_118_1780458242.jpeg', '', '2026-06-03 09:14:02'),
(741, 129, 102, 'uploads/homework_answers/ans_129_1780462367.jpg', '', '2026-06-03 10:22:47'),
(742, 131, 102, 'uploads/homework_answers/ans_131_1780465591.jpeg', '', '2026-06-03 11:16:31'),
(743, 131, 53, 'uploads/homework_answers/ans_131_1780476710.pdf', '', '2026-06-03 14:21:50'),
(744, 129, 105, 'uploads/homework_answers/ans_129_1780479017.jpg', '', '2026-06-03 15:00:17'),
(745, 54, 112, 'uploads/homework_answers/ans_54_1780479131.jpg', '', '2026-06-03 15:02:11'),
(746, 111, 53, 'uploads/homework_answers/ans_111_1780479211.pdf', '', '2026-06-03 15:03:31'),
(747, 92, 112, 'uploads/homework_answers/ans_92_1780479433.jpg', '', '2026-06-03 15:07:13'),
(748, 100, 112, 'uploads/homework_answers/ans_100_1780479629.jpg', '', '2026-06-03 15:10:29'),
(749, 58, 49, 'uploads/homework_answers/ans_58_1780480433.jpg', '', '2026-06-03 15:23:53'),
(750, 110, 112, 'uploads/homework_answers/ans_110_1780481635.jpg', '', '2026-06-03 15:43:55'),
(751, 126, 96, 'uploads/homework_answers/ans_126_1780481879.jpg', '', '2026-06-03 15:47:59'),
(752, 77, 112, 'uploads/homework_answers/ans_77_1780482619.jpg', '', '2026-06-03 16:00:19'),
(753, 112, 53, 'uploads/homework_answers/ans_112_1780483550.pdf', '', '2026-06-03 16:15:50'),
(755, 117, 96, 'uploads/homework_answers/ans_117_1780486065.jpg', 'Sorry madam . I can\'t pdf there is a error', '2026-06-03 16:57:45'),
(756, 117, 112, 'uploads/homework_answers/ans_117_1780486356.jpg', 'Sorry . I can\'t  make a pdf there is a error', '2026-06-03 17:02:36'),
(757, 108, 53, 'uploads/homework_answers/ans_108_1780487002.pdf', '', '2026-06-03 17:13:22'),
(758, 129, 53, 'uploads/homework_answers/ans_129_1780487085.pdf', '', '2026-06-03 17:14:45'),
(759, 131, 105, 'uploads/homework_answers/ans_131_1780487482.jpg', '', '2026-06-03 17:21:22'),
(760, 33, 101, 'uploads/homework_answers/ans_33_1780487729.jpg', '', '2026-06-03 17:25:29'),
(761, 46, 101, 'uploads/homework_answers/ans_46_1780487918.jpeg', '', '2026-06-03 17:28:38'),
(762, 26, 101, 'uploads/homework_answers/ans_26_1780487953.jpg', '', '2026-06-03 17:29:13'),
(763, 72, 101, 'uploads/homework_answers/ans_72_1780487991.jpg', '', '2026-06-03 17:29:51'),
(764, 39, 101, 'uploads/homework_answers/ans_39_1780488031.jpg', '', '2026-06-03 17:30:31'),
(765, 62, 101, 'uploads/homework_answers/ans_62_1780488124.jpg', '', '2026-06-03 17:32:04'),
(766, 83, 101, 'uploads/homework_answers/ans_83_1780488178.jpg', '', '2026-06-03 17:32:58'),
(767, 127, 76, 'uploads/homework_answers/ans_127_1780489447.jpg', '', '2026-06-03 17:54:07'),
(768, 105, 76, 'uploads/homework_answers/ans_105_1780490117.jpg', '', '2026-06-03 18:05:17'),
(769, 125, 38, 'uploads/homework_answers/ans_125_1780490261.pdf', 'Done', '2026-06-03 18:07:41'),
(770, 133, 101, 'uploads/homework_answers/ans_133_1780490642.jpg', '', '2026-06-03 18:14:02'),
(771, 33, 62, 'uploads/homework_answers/ans_33_1780491601.jpeg', '', '2026-06-03 18:30:01'),
(773, 62, 62, 'uploads/homework_answers/ans_62_1780492358.jpeg', '', '2026-06-03 18:42:38'),
(774, 131, 93, 'uploads/homework_answers/ans_131_1780492395.pdf', 'In ex 8.4 i dont know how to do 1st question and 4th', '2026-06-03 18:43:15'),
(775, 99, 71, 'uploads/homework_answers/ans_99_1780494270.png', '', '2026-06-03 19:14:30'),
(776, 105, 71, 'uploads/homework_answers/ans_105_1780494552.png', '', '2026-06-03 19:19:12'),
(777, 133, 61, 'uploads/homework_answers/ans_133_1780495508.jpg', '', '2026-06-03 19:35:08'),
(778, 119, 69, 'uploads/homework_answers/ans_119_1780495918.pdf', '', '2026-06-03 19:41:58'),
(779, 16, 101, 'uploads/homework_answers/ans_16_1780496351.jpg', '', '2026-06-03 19:49:11'),
(780, 19, 101, 'uploads/homework_answers/ans_19_1780496393.jpg', '', '2026-06-03 19:49:53'),
(781, 25, 101, 'uploads/homework_answers/ans_25_1780496482.jpg', '', '2026-06-03 19:51:22'),
(783, 23, 101, 'uploads/homework_answers/ans_23_1780496695.jpg', '', '2026-06-03 19:54:55'),
(784, 20, 101, 'uploads/homework_answers/ans_20_1780496732.jpg', '', '2026-06-03 19:55:32'),
(785, 9, 101, 'uploads/homework_answers/ans_9_1780496775.jpg', '', '2026-06-03 19:56:15'),
(786, 19, 66, 'uploads/homework_answers/ans_19_1780497176.jpg', '', '2026-06-03 20:02:56'),
(787, 76, 66, 'uploads/homework_answers/ans_76_1780497701.jpg', '', '2026-06-03 20:11:41'),
(788, 85, 71, 'uploads/homework_answers/ans_85_1780497829.jpg', '', '2026-06-03 20:13:49'),
(790, 31, 71, 'uploads/homework_answers/ans_31_1780497910.jpg', '', '2026-06-03 20:15:10'),
(791, 45, 71, 'uploads/homework_answers/ans_45_1780497953.jpg', '', '2026-06-03 20:15:53'),
(792, 59, 71, 'uploads/homework_answers/ans_59_1780497975.jpg', '', '2026-06-03 20:16:15'),
(793, 134, 47, 'uploads/homework_answers/ans_134_1780498015.jpg', '', '2026-06-03 20:16:55'),
(794, 69, 71, 'uploads/homework_answers/ans_69_1780498049.jpg', '', '2026-06-03 20:17:29'),
(795, 74, 71, 'uploads/homework_answers/ans_74_1780498123.jpg', '', '2026-06-03 20:18:43'),
(796, 83, 66, 'uploads/homework_answers/ans_83_1780498124.jpg', '', '2026-06-03 20:18:44'),
(797, 75, 71, 'uploads/homework_answers/ans_75_1780498193.jpg', '', '2026-06-03 20:19:53'),
(798, 97, 66, 'uploads/homework_answers/ans_97_1780498341.jpg', '', '2026-06-03 20:22:21'),
(799, 125, 110, 'uploads/homework_answers/ans_125_1780498599.pdf', '', '2026-06-03 20:26:39'),
(800, 135, 88, 'uploads/homework_answers/ans_135_1780498701.jpg', '', '2026-06-03 20:28:21'),
(801, 121, 69, 'uploads/homework_answers/ans_121_1780498847.jpg', 'Sir I\'ll show the other at school sir', '2026-06-03 20:30:47'),
(802, 111, 102, 'uploads/homework_answers/ans_111_1780498921.pdf', '', '2026-06-03 20:32:01'),
(803, 135, 54, 'uploads/homework_answers/ans_135_1780499168.jpg', 'Maths', '2026-06-03 20:36:08'),
(804, 87, 102, 'uploads/homework_answers/ans_87_1780499730.jpg', '', '2026-06-03 20:45:30'),
(805, 119, 72, 'uploads/homework_answers/ans_119_1780499950.jpg', '', '2026-06-03 20:49:10'),
(806, 135, 58, 'uploads/homework_answers/ans_135_1780500019.jpg', '', '2026-06-03 20:50:19'),
(807, 127, 71, 'uploads/homework_answers/ans_127_1780500182.jpg', '', '2026-06-03 20:53:02'),
(810, 112, 102, 'uploads/homework_answers/ans_112_1780500957.pdf', '', '2026-06-03 21:05:57'),
(811, 127, 72, 'uploads/homework_answers/ans_127_1780501385.jpg', 'Teacher I have done the homework , I will show the remaining answers on school,', '2026-06-03 21:13:05'),
(812, 132, 100, 'uploads/homework_answers/ans_132_1780501975.jpg', '', '2026-06-03 21:22:55'),
(813, 135, 96, 'uploads/homework_answers/ans_135_1780502483.jpg', 'Sorry madam. I can\'t make pdf', '2026-06-03 21:31:23'),
(814, 141, 68, 'uploads/homework_answers/ans_141_1780502535.jpg', 'Done', '2026-06-03 21:32:15'),
(815, 125, 81, 'uploads/homework_answers/ans_125_1780502749.jpeg', '', '2026-06-03 21:35:49'),
(817, 111, 108, 'uploads/homework_answers/ans_111_1780502961.pdf', '', '2026-06-03 21:39:21'),
(818, 116, 62, 'uploads/homework_answers/ans_116_1780503207.pdf', '', '2026-06-03 21:43:27'),
(819, 140, 73, 'uploads/homework_answers/ans_140_1780503333.pdf', '', '2026-06-03 21:45:33'),
(820, 135, 57, 'uploads/homework_answers/ans_135_1780503446.jpg', '', '2026-06-03 21:47:26'),
(821, 141, 67, 'uploads/homework_answers/ans_141_1780503557.jpg', '', '2026-06-03 21:49:17'),
(822, 133, 65, 'uploads/homework_answers/ans_133_1780503578.jpg', '', '2026-06-03 21:49:38'),
(823, 139, 101, 'uploads/homework_answers/ans_139_1780503652.jpg', '', '2026-06-03 21:50:52'),
(824, 119, 70, 'uploads/homework_answers/ans_119_1780503913.jpg', '', '2026-06-03 21:55:13'),
(825, 137, 65, 'uploads/homework_answers/ans_137_1780504186.jpg', '', '2026-06-03 21:59:46'),
(826, 119, 73, 'uploads/homework_answers/ans_119_1780504401.jpg', '', '2026-06-03 22:03:21'),
(827, 141, 69, 'uploads/homework_answers/ans_141_1780504788.jpg', 'I\'ll show the other at school', '2026-06-03 22:09:48'),
(828, 139, 61, 'uploads/homework_answers/ans_139_1780504982.jpg', 'I did the work', '2026-06-03 22:13:02'),
(829, 139, 62, 'uploads/homework_answers/ans_139_1780505154.jpg', '', '2026-06-03 22:15:54'),
(831, 136, 51, 'uploads/homework_answers/ans_136_1780505329.jpg', '', '2026-06-03 22:18:49'),
(833, 125, 66, 'uploads/homework_answers/ans_125_1780505562.jpg', '', '2026-06-03 22:22:42'),
(834, 143, 68, 'uploads/homework_answers/ans_143_1780505587.jpg', '', '2026-06-03 22:23:07'),
(835, 135, 59, 'uploads/homework_answers/ans_135_1780505708.jpg', '', '2026-06-03 22:25:08'),
(836, 108, 92, 'uploads/homework_answers/ans_108_1780505712.pdf', '', '2026-06-03 22:25:12'),
(837, 129, 92, 'uploads/homework_answers/ans_129_1780505760.pdf', '', '2026-06-03 22:26:00'),
(838, 141, 73, 'uploads/homework_answers/ans_141_1780506064.jpg', '', '2026-06-03 22:31:04'),
(839, 119, 71, 'uploads/homework_answers/ans_119_1780506459.jpg', '', '2026-06-03 22:37:39'),
(840, 133, 62, 'uploads/homework_answers/ans_133_1780507546.jpg', 'Is it correct 😁', '2026-06-03 22:55:46'),
(841, 117, 89, 'uploads/homework_answers/ans_117_1780508426.pdf', 'Done', '2026-06-03 23:10:26'),
(843, 114, 66, 'uploads/homework_answers/ans_114_1780511365.jpg', '', '2026-06-03 23:59:25'),
(844, 115, 62, 'uploads/homework_answers/ans_115_1780511795.jpg', '', '2026-06-04 00:06:35'),
(845, 139, 81, 'uploads/homework_answers/ans_139_1780511746.jpg', '', '2026-06-04 00:05:46'),
(846, 137, 81, 'uploads/homework_answers/ans_137_1780512315.jpg', '', '2026-06-04 00:15:15'),
(848, 133, 37, 'uploads/homework_answers/ans_133_1780535295.jpg', '', '2026-06-04 06:38:15'),
(849, 141, 71, 'uploads/homework_answers/ans_141_1780540314.jpg', '', '2026-06-04 08:01:54'),
(850, 141, 76, 'uploads/homework_answers/ans_141_1780540408.jpg', '', '2026-06-04 08:03:28'),
(851, 143, 71, 'uploads/homework_answers/ans_143_1780541536.jpg', '', '2026-06-04 08:22:16'),
(852, 143, 70, 'uploads/homework_answers/ans_143_1780543861.jpg', '', '2026-06-04 09:01:01'),
(853, 104, 71, 'uploads/homework_answers/ans_104_1780544016.jpg', '', '2026-06-04 09:03:36'),
(854, 145, 100, 'uploads/homework_answers/ans_145_1780548440.jpg', '', '2026-06-04 10:17:20'),
(855, 135, 112, 'uploads/homework_answers/ans_135_1780550672.jpg', '', '2026-06-04 10:54:32'),
(856, 145, 105, 'uploads/homework_answers/ans_145_1780573824.jpg', '', '2026-06-04 17:20:24'),
(857, 9, 62, 'uploads/homework_answers/ans_9_1780576948.jpeg', '', '2026-06-04 18:12:28'),
(858, 141, 70, 'uploads/homework_answers/ans_141_1780577308.jpg', '', '2026-06-04 18:18:28'),
(859, 145, 53, 'uploads/homework_answers/ans_145_1780577888.pdf', '', '2026-06-04 18:28:08'),
(860, 136, 49, 'uploads/homework_answers/ans_136_1780577998.jpg', '', '2026-06-04 18:29:58'),
(861, 143, 67, 'uploads/homework_answers/ans_143_1780578232.jpg', '', '2026-06-04 18:33:52'),
(862, 133, 38, 'uploads/homework_answers/ans_133_1780579192.jpg', 'Done', '2026-06-04 18:49:52'),
(863, 135, 89, 'uploads/homework_answers/ans_135_1780579336.jpg', '', '2026-06-04 18:52:16'),
(864, 100, 89, 'uploads/homework_answers/ans_100_1780579494.jpg', 'Done', '2026-06-04 18:54:54'),
(865, 139, 110, 'uploads/homework_answers/ans_139_1780579721.pdf', '', '2026-06-04 18:58:41'),
(866, 145, 104, 'uploads/homework_answers/ans_145_1780580076.pdf', '', '2026-06-04 19:04:36'),
(867, 10, 76, 'uploads/homework_answers/ans_10_1780580233.jpg', '', '2026-06-04 19:07:13'),
(868, 145, 103, 'uploads/homework_answers/ans_145_1780580265.jpg', '', '2026-06-04 19:07:45'),
(869, 15, 76, 'uploads/homework_answers/ans_15_1780580274.jpg', '', '2026-06-04 19:07:54'),
(871, 35, 76, 'uploads/homework_answers/ans_35_1780580348.jpg', '', '2026-06-04 19:09:08'),
(873, 74, 76, 'uploads/homework_answers/ans_74_1780580443.jpg', '', '2026-06-04 19:10:43'),
(874, 143, 69, 'uploads/homework_answers/ans_143_1780581642.jpg', '', '2026-06-04 19:30:42'),
(875, 119, 76, 'uploads/homework_answers/ans_119_1780581904.jpg', '', '2026-06-04 19:35:04'),
(876, 113, 76, 'uploads/homework_answers/ans_113_1780581981.jpg', '', '2026-06-04 19:36:21'),
(877, 143, 76, 'uploads/homework_answers/ans_143_1780582339.jpg', '', '2026-06-04 19:42:19'),
(878, 104, 76, 'uploads/homework_answers/ans_104_1780582971.jpg', '', '2026-06-04 19:52:51'),
(879, 140, 70, 'uploads/homework_answers/ans_140_1780583491.pdf', '', '2026-06-04 20:01:31'),
(880, 114, 110, 'uploads/homework_answers/ans_114_1780584006.pdf', '', '2026-06-04 20:10:06'),
(881, 136, 107, 'uploads/homework_answers/ans_136_1780584316.jpg', '', '2026-06-04 20:15:16'),
(882, 148, 104, 'uploads/homework_answers/ans_148_1780584570.pdf', '', '2026-06-04 20:19:30'),
(884, 134, 48, 'uploads/homework_answers/ans_134_1780585066.jpg', '', '2026-06-04 20:27:46'),
(886, 144, 107, 'uploads/homework_answers/ans_144_1780585296.jpg', '', '2026-06-04 20:31:36'),
(887, 132, 93, 'uploads/homework_answers/ans_132_1780586099.pdf', 'I have a doubt in excercise 04', '2026-06-04 20:44:59'),
(888, 145, 93, 'uploads/homework_answers/ans_145_1780586188.pdf', 'Done all the questions in review excercise', '2026-06-04 20:46:28'),
(889, 110, 89, 'uploads/homework_answers/ans_110_1780586560.jpg', 'Done', '2026-06-04 20:52:40'),
(890, 74, 80, 'uploads/homework_answers/ans_74_1780589321.jpg', '', '2026-06-04 21:38:41'),
(891, 99, 80, 'uploads/homework_answers/ans_99_1780589487.jpg', '', '2026-06-04 21:41:27'),
(892, 145, 102, 'uploads/homework_answers/ans_145_1780589732.pdf', '', '2026-06-04 21:45:32'),
(893, 21, 80, 'uploads/homework_answers/ans_21_1780589925.jpg', '', '2026-06-04 21:48:45'),
(894, 120, 48, 'uploads/homework_answers/ans_120_1780590325.jpg', '', '2026-06-04 21:55:25'),
(895, 148, 102, 'uploads/homework_answers/ans_148_1780591474.pdf', '', '2026-06-04 22:14:34'),
(896, 147, 65, 'uploads/homework_answers/ans_147_1780591713.jpeg', '', '2026-06-04 22:18:33'),
(897, 22, 80, 'uploads/homework_answers/ans_22_1780591762.jpg', '', '2026-06-04 22:19:22'),
(899, 144, 49, 'uploads/homework_answers/ans_144_1780591933.jpg', '', '2026-06-04 22:22:13'),
(901, 147, 62, 'uploads/homework_answers/ans_147_1780592087.jpg', 'I did the selected ones only', '2026-06-04 22:24:47'),
(902, 122, 48, 'uploads/homework_answers/ans_122_1780592673.jpg', '', '2026-06-04 22:34:33'),
(903, 140, 71, 'uploads/homework_answers/ans_140_1780593156.jpg', '', '2026-06-04 22:42:36'),
(904, 133, 39, 'uploads/homework_answers/ans_133_1780593417.pdf', '', '2026-06-04 22:46:57'),
(905, 131, 92, 'uploads/homework_answers/ans_131_1780595103.pdf', '', '2026-06-04 23:15:03'),
(906, 145, 92, 'uploads/homework_answers/ans_145_1780595178.pdf', '', '2026-06-04 23:16:18'),
(907, 127, 80, 'uploads/homework_answers/ans_127_1780595570.jpg', '', '2026-06-04 23:22:50'),
(908, 143, 80, 'uploads/homework_answers/ans_143_1780595719.jpeg', '', '2026-06-04 23:25:19'),
(909, 147, 61, 'uploads/homework_answers/ans_147_1780620305.jpg', '', '2026-06-05 06:15:05'),
(910, 144, 51, 'uploads/homework_answers/ans_144_1780622293.jpg', '', '2026-06-05 06:48:13'),
(911, 139, 38, 'uploads/homework_answers/ans_139_1780623101.jpg', 'Done', '2026-06-05 07:01:41'),
(912, 148, 105, 'uploads/homework_answers/ans_148_1780639247.jpg', '', '2026-06-05 11:30:47'),
(913, 146, 59, 'uploads/homework_answers/ans_146_1780646650.pdf', '', '2026-06-05 13:34:10'),
(914, 147, 81, 'uploads/homework_answers/ans_147_1780648733.jpeg', '', '2026-06-05 14:08:53'),
(915, 145, 113, 'uploads/homework_answers/ans_145_1780651995.jpg', '', '2026-06-05 15:03:15'),
(916, 148, 113, 'uploads/homework_answers/ans_148_1780659709.jpg', '', '2026-06-05 17:11:49'),
(917, 133, 110, 'uploads/homework_answers/ans_133_1780667667.pdf', '', '2026-06-05 19:24:27'),
(918, 141, 72, 'uploads/homework_answers/ans_141_1780669884.jpeg', '', '2026-06-05 20:01:24'),
(920, 137, 37, 'uploads/homework_answers/ans_137_1780676503.jpg', '', '2026-06-05 21:51:43'),
(921, 121, 70, 'uploads/homework_answers/ans_121_1780678035.pdf', '', '2026-06-05 22:17:15'),
(922, 147, 37, 'uploads/homework_answers/ans_147_1780678754.jpg', '', '2026-06-05 22:29:14'),
(923, 125, 37, 'uploads/homework_answers/ans_125_1780678924.jpg', '', '2026-06-05 22:32:04'),
(924, 140, 80, 'uploads/homework_answers/ans_140_1780690190.jpg', '', '2026-06-06 01:39:50'),
(925, 110, 88, NULL, '', '2026-06-06 15:02:20'),
(926, 147, 38, 'uploads/homework_answers/ans_147_1780755298.jpg', 'Done', '2026-06-06 19:44:58'),
(927, 68, 81, 'uploads/homework_answers/ans_68_1780816106.jpg', '', '2026-06-07 12:38:26'),
(928, 32, 81, 'uploads/homework_answers/ans_32_1780816131.jpg', '', '2026-06-07 12:38:51'),
(929, 146, 58, 'uploads/homework_answers/ans_146_1780825832.jpg', '', '2026-06-07 15:20:32'),
(930, 150, 68, 'uploads/homework_answers/ans_150_1780839024.jpg', 'Done', '2026-06-07 19:00:24'),
(931, 126, 87, 'uploads/homework_answers/ans_126_1780842895.jpg', '', '2026-06-07 20:04:55'),
(932, 117, 87, 'uploads/homework_answers/ans_117_1780843262.jpg', '', '2026-06-07 20:11:02'),
(933, 148, 93, 'uploads/homework_answers/ans_148_1780844195.pdf', 'Done all\r\nThe third and fourth questions order is changed', '2026-06-07 20:26:35'),
(934, 114, 62, 'uploads/homework_answers/ans_114_1780845021.pdf', '', '2026-06-07 20:40:21'),
(935, 152, 47, 'uploads/homework_answers/ans_152_1780845364.jpg', '', '2026-06-07 20:46:04'),
(936, 100, 87, 'uploads/homework_answers/ans_100_1780847944.jpg', '', '2026-06-07 21:29:04'),
(937, 151, 93, 'uploads/homework_answers/ans_151_1780847983.pdf', 'Done all questions in9.1 & 9.2', '2026-06-07 21:29:43'),
(938, 135, 87, 'uploads/homework_answers/ans_135_1780849717.jpg', '', '2026-06-07 21:58:37'),
(939, 151, 104, 'uploads/homework_answers/ans_151_1780850295.pdf', '', '2026-06-07 22:08:15'),
(940, 149, 39, 'uploads/homework_answers/ans_149_1780854561.jpg', '', '2026-06-07 23:19:21'),
(941, 149, 37, 'uploads/homework_answers/ans_149_1780854645.jpg', '', '2026-06-07 23:20:45'),
(942, 153, 47, 'uploads/homework_answers/ans_153_1780888779.jpg', '', '2026-06-08 08:49:39'),
(943, 153, 48, 'uploads/homework_answers/ans_153_1780888866.jpg', 'I also did this in school', '2026-06-08 08:51:06'),
(944, 152, 48, 'uploads/homework_answers/ans_152_1780905695.jpeg', '', '2026-06-08 13:31:35'),
(945, 146, 89, 'uploads/homework_answers/ans_146_1780907143.pdf', '', '2026-06-08 13:55:43'),
(946, 155, 47, 'uploads/homework_answers/ans_155_1780907322.jpg', '', '2026-06-08 13:58:42'),
(947, 146, 54, 'uploads/homework_answers/ans_146_1780907471.pdf', '', '2026-06-08 14:01:11'),
(948, 146, 88, 'uploads/homework_answers/ans_146_1780909864.pdf', '', '2026-06-08 14:41:04'),
(949, 142, 53, 'uploads/homework_answers/ans_142_1780910842.pdf', '', '2026-06-08 14:57:22'),
(950, 82, 53, 'uploads/homework_answers/ans_82_1780912007.jpg', '', '2026-06-08 15:16:47'),
(951, 151, 53, 'uploads/homework_answers/ans_151_1780915095.pdf', '', '2026-06-08 16:08:15'),
(952, 89, 53, 'uploads/homework_answers/ans_89_1780915326.jpg', '', '2026-06-08 16:12:06'),
(953, 157, 107, 'uploads/homework_answers/ans_157_1780919056.jpg', '', '2026-06-08 17:14:16'),
(954, 161, 107, 'uploads/homework_answers/ans_161_1780920523.jpg', '', '2026-06-08 17:38:43'),
(955, 165, 107, 'uploads/homework_answers/ans_165_1780921185.jpg', 'Madam in otherside of the page madam', '2026-06-08 17:49:45'),
(956, 156, 69, 'uploads/homework_answers/ans_156_1780921403.pdf', 'Done', '2026-06-08 17:53:25'),
(957, 148, 53, 'uploads/homework_answers/ans_148_1780921545.pdf', '', '2026-06-08 17:55:51'),
(958, 164, 53, 'uploads/homework_answers/ans_164_1780921642.pdf', '', '2026-06-08 17:57:28'),
(959, 151, 113, 'uploads/homework_answers/ans_151_1780921726.jpg', '', '2026-06-08 17:58:47'),
(960, 166, 47, 'uploads/homework_answers/ans_166_1780923087.jpg', '', '2026-06-08 18:21:27'),
(961, 158, 105, 'uploads/homework_answers/ans_158_1780923130.jpg', '', '2026-06-08 18:22:10'),
(962, 164, 105, 'uploads/homework_answers/ans_164_1780923147.jpg', '', '2026-06-08 18:22:27'),
(963, 151, 105, 'uploads/homework_answers/ans_151_1780923171.jpg', '', '2026-06-08 18:22:51'),
(964, 167, 47, 'uploads/homework_answers/ans_167_1780923994.jpg', '', '2026-06-08 18:36:34'),
(965, 146, 112, 'uploads/homework_answers/ans_146_1780924808.pdf', '', '2026-06-08 18:50:08'),
(966, 142, 93, 'uploads/homework_answers/ans_142_1780925310.pdf', '', '2026-06-08 18:58:30'),
(967, 151, 103, 'uploads/homework_answers/ans_151_1780926174.jpg', '', '2026-06-08 19:12:54'),
(968, 164, 113, 'uploads/homework_answers/ans_164_1780926242.jpg', '', '2026-06-08 19:14:02'),
(969, 160, 47, 'uploads/homework_answers/ans_160_1780926558.jpg', '', '2026-06-08 19:19:18'),
(970, 162, 112, 'uploads/homework_answers/ans_162_1780926609.pdf', '', '2026-06-08 19:20:09'),
(971, 22, 71, 'uploads/homework_answers/ans_22_1780927247.jpg', '', '2026-06-08 19:30:47'),
(972, 61, 71, 'uploads/homework_answers/ans_61_1780927557.jpg', '', '2026-06-08 19:35:57'),
(973, 163, 112, 'uploads/homework_answers/ans_163_1780927575.pdf', '', '2026-06-08 19:36:15'),
(974, 154, 112, 'uploads/homework_answers/ans_154_1780928117.pdf', '', '2026-06-08 19:45:17'),
(975, 170, 76, 'uploads/homework_answers/ans_170_1780928620.jpg', '', '2026-06-08 19:53:40'),
(976, 169, 76, 'uploads/homework_answers/ans_169_1780929023.jpg', '', '2026-06-08 20:00:23'),
(977, 159, 47, 'uploads/homework_answers/ans_159_1780929065.jpg', '', '2026-06-08 20:01:05'),
(978, 154, 87, 'uploads/homework_answers/ans_154_1780929253.jpg', '', '2026-06-08 20:04:13'),
(979, 156, 67, 'uploads/homework_answers/ans_156_1780929518.jpg', '', '2026-06-08 20:08:38'),
(980, 154, 89, 'uploads/homework_answers/ans_154_1780929819.jpg', 'Done', '2026-06-08 20:13:39'),
(981, 168, 54, 'uploads/homework_answers/ans_168_1780930350.jpg', 'History', '2026-06-08 20:22:30'),
(982, 90, 99, 'uploads/homework_answers/ans_90_1780930416.pdf', '', '2026-06-08 20:23:36'),
(983, 162, 87, 'uploads/homework_answers/ans_162_1780931348.jpg', '', '2026-06-08 20:39:08'),
(984, 164, 103, 'uploads/homework_answers/ans_164_1780931423.jpg', '', '2026-06-08 20:40:23'),
(985, 168, 89, 'uploads/homework_answers/ans_168_1780931472.jpg', 'Done', '2026-06-08 20:41:12'),
(986, 158, 113, 'uploads/homework_answers/ans_158_1780931519.jpg', '', '2026-06-08 20:41:59'),
(987, 171, 100, 'uploads/homework_answers/ans_171_1780931631.pdf', '', '2026-06-08 20:43:51'),
(988, 156, 73, 'uploads/homework_answers/ans_156_1780931635.pdf', 'Difficulty in completing tha last 2 sub question. Need an explanation pls', '2026-06-08 20:43:55'),
(989, 164, 93, 'uploads/homework_answers/ans_164_1780931775.pdf', 'Done all', '2026-06-08 20:46:15'),
(990, 154, 88, 'uploads/homework_answers/ans_154_1780931985.jpg', '', '2026-06-08 20:49:45'),
(991, 163, 87, 'uploads/homework_answers/ans_163_1780932096.jpg', '', '2026-06-08 20:51:36'),
(992, 168, 88, 'uploads/homework_answers/ans_168_1780932130.jpg', '', '2026-06-08 20:52:10'),
(993, 171, 105, 'uploads/homework_answers/ans_171_1780932373.jpg', '', '2026-06-08 20:56:13'),
(994, 172, 76, 'uploads/homework_answers/ans_172_1780932686.jpg', '', '2026-06-08 21:01:26'),
(995, 169, 68, 'uploads/homework_answers/ans_169_1780933012.jpg', 'Done', '2026-06-08 21:06:52'),
(996, 171, 113, 'uploads/homework_answers/ans_171_1780933086.jpg', '', '2026-06-08 21:08:06'),
(997, 161, 51, 'uploads/homework_answers/ans_161_1780933698.jpg', '', '2026-06-08 21:18:18'),
(998, 171, 103, 'uploads/homework_answers/ans_171_1780933738.jpg', '', '2026-06-08 21:18:58'),
(999, 168, 87, 'uploads/homework_answers/ans_168_1780933774.jpg', '', '2026-06-08 21:19:34'),
(1000, 156, 68, 'uploads/homework_answers/ans_156_1780934332.jpg', 'Done', '2026-06-08 21:28:52'),
(1001, 151, 100, 'uploads/homework_answers/ans_151_1780934510.pdf', '', '2026-06-08 21:31:50'),
(1002, 170, 68, 'uploads/homework_answers/ans_170_1780934678.jpg', 'Done', '2026-06-08 21:34:38'),
(1003, 171, 93, 'uploads/homework_answers/ans_171_1780934737.pdf', 'Done all questions in 10.1 and 10.2', '2026-06-08 21:35:37'),
(1004, 162, 58, 'uploads/homework_answers/ans_162_1780935448.jpg', '', '2026-06-08 21:47:28'),
(1005, 164, 104, 'uploads/homework_answers/ans_164_1780935518.pdf', '', '2026-06-08 21:48:38'),
(1006, 172, 68, 'uploads/homework_answers/ans_172_1780935532.jpg', 'Done madam', '2026-06-08 21:48:52'),
(1007, 156, 70, 'uploads/homework_answers/ans_156_1780936181.pdf', '', '2026-06-08 21:59:41'),
(1008, 143, 106, 'uploads/homework_answers/ans_143_1780936569.pdf', '', '2026-06-08 22:06:09'),
(1009, 163, 58, 'uploads/homework_answers/ans_163_1780936783.jpg', '', '2026-06-08 22:09:43'),
(1011, 154, 58, 'uploads/homework_answers/ans_154_1780937055.jpg', '', '2026-06-08 22:14:15'),
(1012, 147, 39, 'uploads/homework_answers/ans_147_1780937761.pdf', '', '2026-06-08 22:26:01'),
(1013, 162, 89, 'uploads/homework_answers/ans_162_1780937817.jpeg', 'Done', '2026-06-08 22:26:57'),
(1014, 163, 89, 'uploads/homework_answers/ans_163_1780937850.jpeg', 'Dine', '2026-06-08 22:27:30'),
(1015, 162, 59, 'uploads/homework_answers/ans_162_1780938407.jpg', '', '2026-06-08 22:36:47'),
(1016, 147, 66, 'uploads/homework_answers/ans_147_1780938600.jpg', '', '2026-06-08 22:40:00'),
(1017, 163, 88, 'uploads/homework_answers/ans_163_1780938661.jpg', '', '2026-06-08 22:41:01'),
(1018, 137, 39, 'uploads/homework_answers/ans_137_1780938696.pdf', '', '2026-06-08 22:41:36'),
(1019, 150, 70, 'uploads/homework_answers/ans_150_1780939375.jpg', '', '2026-06-08 22:52:55'),
(1020, 171, 104, 'uploads/homework_answers/ans_171_1780939666.pdf', '', '2026-06-08 22:57:46'),
(1021, 137, 61, 'uploads/homework_answers/ans_137_1780939734.pdf', '', '2026-06-08 22:58:54'),
(1022, 151, 92, 'uploads/homework_answers/ans_151_1780939975.pdf', '', '2026-06-08 23:02:55'),
(1023, 163, 59, 'uploads/homework_answers/ans_163_1780939993.jpg', '', '2026-06-08 23:03:13'),
(1024, 171, 92, 'uploads/homework_answers/ans_171_1780940003.pdf', '', '2026-06-08 23:03:23'),
(1025, 154, 57, 'uploads/homework_answers/ans_154_1780940204.jpg', '', '2026-06-08 23:06:44'),
(1026, 162, 57, 'uploads/homework_answers/ans_162_1780940274.jpg', '', '2026-06-08 23:07:54'),
(1027, 168, 58, 'uploads/homework_answers/ans_168_1780940866.jpg', '', '2026-06-08 23:17:46'),
(1028, 163, 57, 'uploads/homework_answers/ans_163_1780940889.jpg', '', '2026-06-08 23:18:09'),
(1029, 168, 57, 'uploads/homework_answers/ans_168_1780940943.jpg', '', '2026-06-08 23:19:03'),
(1030, 169, 106, 'uploads/homework_answers/ans_169_1780941048.pdf', '', '2026-06-08 23:20:48'),
(1031, 162, 88, 'uploads/homework_answers/ans_162_1780941565.jpg', '', '2026-06-08 23:29:25'),
(1032, 146, 57, 'uploads/homework_answers/ans_146_1780942737.pdf', '', '2026-06-08 23:48:57'),
(1033, 173, 105, 'uploads/homework_answers/ans_173_1780943589.jpg', '', '2026-06-09 00:03:09'),
(1034, 125, 65, 'uploads/homework_answers/ans_125_1780946026.jpg', '', '2026-06-09 00:43:46'),
(1035, 173, 92, 'uploads/homework_answers/ans_173_1780949134.pdf', '', '2026-06-09 01:35:34'),
(1036, 164, 92, 'uploads/homework_answers/ans_164_1780949186.pdf', '', '2026-06-09 01:36:26'),
(1037, 148, 92, 'uploads/homework_answers/ans_148_1780949208.pdf', '', '2026-06-09 01:36:48'),
(1038, 147, 101, 'uploads/homework_answers/ans_147_1780966861.jpg', '', '2026-06-09 06:31:01'),
(1039, 137, 101, 'uploads/homework_answers/ans_137_1780979680.jpeg', '', '2026-06-09 10:04:40'),
(1041, 168, 59, 'uploads/homework_answers/ans_168_1780986778.jpeg', '', '2026-06-09 12:02:58'),
(1042, 162, 54, 'uploads/homework_answers/ans_162_1780992193.jpg', 'Maths', '2026-06-09 13:33:13'),
(1043, 163, 54, 'uploads/homework_answers/ans_163_1780993786.jpg', 'Maths', '2026-06-09 13:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `homework_submission_files`
--

CREATE TABLE `homework_submission_files` (
  `id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `homework_submission_files`
--

INSERT INTO `homework_submission_files` (`id`, `submission_id`, `file_path`, `created_at`) VALUES
(1, 4, 'uploads/homework-submit/hw_11/student_35/ans_6962365978366.jpg', '2026-01-10 11:22:01'),
(2, 4, 'uploads/homework-submit/hw_11/student_35/ans_696236597881f.jpg', '2026-01-10 11:22:01'),
(3, 4, 'uploads/homework-submit/hw_11/student_35/ans_6962365978ae0.jpg', '2026-01-10 11:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#333',
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`id`, `name`, `color`, `logo`) VALUES
(1, 'Serendor', '#001640', 'serendor.png'),
(2, 'Luminara', '#156B43', 'luminara.png'),
(3, 'Nagathorn', '#9C231C', 'nagathorn.png');

-- --------------------------------------------------------

--
-- Table structure for table `house_members`
--

CREATE TABLE `house_members` (
  `id` int(11) NOT NULL,
  `entity_type` enum('student','teacher') NOT NULL,
  `entity_id` int(11) NOT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `house_id` int(11) NOT NULL,
  `assigned_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `house_members`
--

INSERT INTO `house_members` (`id`, `entity_type`, `entity_id`, `grade_id`, `house_id`, `assigned_at`) VALUES
(2, 'student', 47, 1, 2, '2026-03-09 11:18:35'),
(3, 'student', 49, 2, 1, '2026-03-09 11:19:47'),
(4, 'student', 51, 2, 3, '2026-03-09 11:20:57'),
(5, 'student', 58, 3, 2, '2026-03-09 11:21:46'),
(6, 'student', 57, 3, 1, '2026-03-09 11:22:34'),
(7, 'student', 56, 3, 2, '2026-03-09 11:23:20'),
(8, 'student', 59, 3, 3, '2026-03-09 11:24:03'),
(9, 'student', 89, 3, 3, '2026-03-09 11:24:51'),
(10, 'student', 55, 3, 2, '2026-03-09 11:25:38'),
(11, 'student', 88, 3, 1, '2026-03-09 11:26:27'),
(12, 'student', 53, 3, 2, '2026-03-09 11:27:10'),
(13, 'student', 54, 3, 1, '2026-03-09 11:27:55'),
(14, 'student', 61, 5, 3, '2026-03-09 11:29:36'),
(15, 'student', 39, 5, 1, '2026-03-09 11:30:21'),
(16, 'student', 81, 5, 2, '2026-03-09 11:31:08'),
(17, 'student', 62, 5, 3, '2026-03-09 11:31:55'),
(18, 'student', 37, 5, 1, '2026-03-09 11:32:44'),
(19, 'student', 64, 5, 1, '2026-03-09 11:33:33'),
(20, 'student', 66, 5, 3, '2026-03-09 11:34:22'),
(21, 'student', 65, 5, 2, '2026-03-09 11:35:12'),
(22, 'student', 92, 4, 2, '2026-03-09 11:35:57'),
(23, 'student', 93, 4, 1, '2026-03-09 11:36:40'),
(24, 'student', 73, 6, 3, '2026-03-09 11:37:28'),
(25, 'student', 80, 6, 3, '2026-03-09 11:38:17'),
(26, 'student', 76, 6, 2, '2026-03-09 11:39:04'),
(27, 'student', 72, 6, 3, '2026-03-09 11:39:52'),
(28, 'student', 71, 6, 2, '2026-03-09 11:40:32'),
(29, 'student', 70, 6, 2, '2026-03-09 11:41:17'),
(30, 'student', 67, 6, 1, '2026-03-09 11:42:11'),
(31, 'student', 69, 6, 3, '2026-03-09 11:42:56'),
(32, 'student', 68, 6, 2, '2026-03-09 11:43:46'),
(33, 'teacher', 24, NULL, 1, '2026-03-09 11:57:26'),
(34, 'teacher', 14, NULL, 3, '2026-03-09 11:58:05'),
(35, 'teacher', 13, NULL, 1, '2026-03-09 11:59:19'),
(36, 'teacher', 19, NULL, 3, '2026-03-09 12:00:08'),
(37, 'teacher', 27, NULL, 2, '2026-03-09 12:00:51'),
(38, 'teacher', 26, NULL, 1, '2026-03-09 12:01:23'),
(39, 'teacher', 23, NULL, 1, '2026-03-09 12:01:56'),
(41, 'teacher', 21, NULL, 2, '2026-03-09 12:03:06'),
(42, 'teacher', 25, NULL, 3, '2026-03-09 12:03:44'),
(43, 'teacher', 30, NULL, 1, '2026-03-09 12:04:16'),
(44, 'teacher', 29, NULL, 3, '2026-03-09 12:04:57'),
(45, 'student', 87, 3, 1, '2026-03-30 03:19:46'),
(46, 'student', 38, 5, 1, '2026-03-30 03:20:13'),
(47, 'student', 48, 1, 3, '2026-03-30 03:20:41'),
(48, 'teacher', 31, NULL, 3, '2026-04-28 15:39:59'),
(49, 'student', 60, 4, 2, '2026-04-28 15:40:18'),
(50, 'student', 96, 3, 2, '2026-05-11 07:59:50'),
(51, 'student', 94, 4, 3, '2026-05-11 08:00:22'),
(52, 'student', 97, 4, 1, '2026-05-11 08:00:49'),
(53, 'student', 99, 1, 3, '2026-05-14 05:21:21'),
(56, 'student', 100, 4, 1, '2026-05-14 06:11:28'),
(57, 'student', 98, 5, 1, '2026-05-14 06:11:53'),
(58, 'teacher', 33, NULL, 2, '2026-05-14 06:14:01'),
(59, 'teacher', 32, NULL, 2, '2026-05-14 06:14:52'),
(60, 'student', 101, 5, 2, '2026-05-14 08:09:47'),
(62, 'student', 102, 4, 3, '2026-05-14 08:19:28'),
(64, 'student', 104, 4, 3, '2026-05-14 08:26:26'),
(65, 'student', 103, 4, 1, '2026-05-14 14:38:59'),
(66, 'student', 105, 4, 2, '2026-05-15 05:54:21'),
(68, 'student', 106, 6, 1, '2026-05-20 05:57:47'),
(69, 'student', 107, 2, 3, '2026-05-21 02:16:55'),
(73, 'student', 108, 4, 2, '2026-05-21 04:32:12'),
(74, 'student', 109, 6, 1, '2026-05-22 03:54:33'),
(75, 'student', 110, 5, 3, '2026-05-23 07:03:36'),
(76, 'student', 112, 3, 2, '2026-05-25 03:39:39'),
(77, 'student', 113, 4, 3, '2026-06-01 05:04:36'),
(78, 'student', 114, 6, 2, '2026-06-08 05:47:25'),
(84, 'student', 115, 6, 1, '2026-06-08 05:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `house_points`
--

CREATE TABLE `house_points` (
  `id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `total_points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `house_points`
--

INSERT INTO `house_points` (`id`, `house_id`, `academic_year_id`, `total_points`) VALUES
(1, 1, 1, 767),
(3, 2, 1, 864),
(5, 3, 1, 761);

-- --------------------------------------------------------

--
-- Table structure for table `house_point_logs`
--

CREATE TABLE `house_point_logs` (
  `id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `entity_type` enum('student','teacher','system') DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `homework_id` int(11) DEFAULT NULL,
  `points` int(11) NOT NULL,
  `action` enum('ADD','DEDUCT') DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `source` enum('ADMIN','TEACHER','SYSTEM','HOMEWORK') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `house_point_logs`
--

INSERT INTO `house_point_logs` (`id`, `house_id`, `academic_year_id`, `entity_type`, `entity_id`, `homework_id`, `points`, `action`, `reason`, `source`, `created_at`) VALUES
(5, 3, 1, 'student', 61, 25, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-04-22 14:15:16'),
(6, 3, 1, 'student', 61, 26, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-04-23 14:45:49'),
(7, 1, 1, 'student', 38, 26, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-04-24 13:02:42'),
(8, 1, 1, 'student', 38, 25, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-04-24 14:02:07'),
(9, 1, 1, 'student', 39, 25, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-04-24 15:44:15'),
(10, 3, 1, 'student', 62, 26, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-04-25 08:56:39'),
(11, 3, 1, 'student', 69, 27, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-04-28 14:30:45'),
(12, 1, 1, 'student', 67, 27, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-04-29 14:32:07'),
(13, 2, 1, 'student', 68, 27, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-04-30 15:02:17'),
(14, 2, 1, 'student', 68, 30, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 11:11:06'),
(15, 2, 1, 'student', 68, 31, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 12:51:47'),
(16, 2, 1, 'student', 70, 27, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-05 13:31:07'),
(17, 2, 1, 'student', 70, 31, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 13:33:04'),
(18, 2, 1, 'student', 70, 30, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 13:34:42'),
(19, 3, 1, 'student', 69, 31, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 14:09:16'),
(20, 1, 1, 'student', 67, 31, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 15:31:00'),
(21, 1, 1, 'student', 67, 30, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 15:56:44'),
(22, 3, 1, 'student', 73, 31, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-05 16:16:34'),
(23, 2, 1, 'student', 68, 24, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-05 16:40:33'),
(24, 2, 1, 'student', 68, 17, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-05 16:43:18'),
(26, 2, 1, 'student', 68, 22, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-05 16:47:07'),
(27, 1, 1, 'student', 54, 37, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-06 14:01:44'),
(28, 3, 1, 'student', 69, 38, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-06 14:22:08'),
(29, 2, 1, 'student', 68, 38, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-06 14:23:24'),
(30, 1, 1, 'student', 88, 37, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-06 15:17:55'),
(31, 1, 1, 'student', 54, 36, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-06 16:59:22'),
(32, 1, 1, 'student', 67, 38, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-07 15:15:09'),
(34, 2, 1, 'student', 71, 30, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-07 17:19:26'),
(35, 3, 1, 'student', 59, 37, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-08 01:20:00'),
(36, 3, 1, 'student', 69, 30, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-08 09:40:47'),
(37, 3, 1, 'student', 62, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-09 17:24:12'),
(38, 3, 1, 'student', 72, 30, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-10 12:58:40'),
(39, 3, 1, 'student', 59, 36, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-10 15:35:30'),
(40, 3, 1, 'student', 89, 36, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-10 15:51:27'),
(41, 3, 1, 'student', 89, 37, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-10 16:02:44'),
(43, 1, 1, 'student', 57, 37, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 12:53:00'),
(45, 2, 1, 'student', 68, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-11 15:25:58'),
(46, 2, 1, 'student', 68, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-11 15:27:41'),
(47, 3, 1, 'student', 62, 41, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-11 15:44:28'),
(48, 3, 1, 'student', 62, 19, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 15:52:55'),
(49, 1, 1, 'student', 67, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-11 16:19:51'),
(50, 1, 1, 'student', 67, 17, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 16:22:55'),
(53, 1, 1, 'student', 67, 15, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 16:39:13'),
(54, 3, 1, 'student', 80, 31, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 17:20:41'),
(55, 3, 1, 'student', 62, 25, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 17:21:30'),
(56, 1, 1, 'student', 88, 36, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 17:36:14'),
(57, 3, 1, 'student', 80, 17, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-11 17:42:33'),
(58, 3, 1, 'student', 61, 41, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 10:17:51'),
(59, 2, 1, 'student', 70, 38, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-12 11:27:49'),
(60, 2, 1, 'student', 70, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 12:20:31'),
(61, 2, 1, 'student', 70, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 12:21:15'),
(62, 1, 1, 'student', 67, 45, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 13:39:53'),
(64, 2, 1, 'student', 68, 45, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 14:05:01'),
(66, 3, 1, 'student', 62, 44, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 15:10:13'),
(67, 1, 1, 'student', 67, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 15:17:14'),
(68, 3, 1, 'student', 69, 45, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 15:24:19'),
(69, 3, 1, 'student', 61, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 15:32:11'),
(70, 2, 1, 'student', 81, 41, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 17:02:22'),
(71, 3, 1, 'student', 61, 44, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 17:16:55'),
(73, 3, 1, 'student', 73, 45, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-12 18:45:28'),
(75, 2, 1, 'student', 70, 35, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 02:04:09'),
(76, 3, 1, 'student', 61, 33, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 02:05:31'),
(77, 3, 1, 'student', 69, 35, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 05:08:23'),
(78, 3, 1, 'student', 69, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 07:10:29'),
(79, 3, 1, 'student', 69, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 07:15:23'),
(80, 2, 1, 'student', 81, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 09:11:13'),
(81, 1, 1, 'student', 54, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 09:53:58'),
(82, 2, 1, 'student', 68, 35, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 09:57:06'),
(83, 2, 1, 'student', 76, 45, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 10:00:28'),
(84, 2, 1, 'student', 76, 31, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 10:01:08'),
(85, 3, 1, 'student', 69, 53, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 10:15:15'),
(86, 2, 1, 'student', 70, 53, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 10:27:27'),
(87, 1, 1, 'student', 54, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 11:00:36'),
(88, 1, 1, 'student', 67, 35, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 12:08:21'),
(89, 1, 1, 'student', 67, 53, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 12:40:21'),
(90, 1, 1, 'student', 57, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 14:38:19'),
(91, 1, 1, 'student', 38, 41, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 14:58:40'),
(92, 3, 1, 'student', 72, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 15:01:29'),
(93, 3, 1, 'student', 72, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 15:02:43'),
(94, 3, 1, 'student', 72, 17, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 15:07:50'),
(95, 3, 1, 'student', 72, 22, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 15:21:01'),
(96, 1, 1, 'student', 57, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 15:26:02'),
(97, 3, 1, 'student', 72, 59, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 15:44:57'),
(98, 2, 1, 'student', 68, 56, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 15:50:45'),
(99, 2, 1, 'student', 76, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 15:55:26'),
(100, 3, 1, 'student', 59, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 15:56:44'),
(101, 2, 1, 'student', 76, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 16:01:17'),
(102, 2, 1, 'student', 81, 33, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 16:06:13'),
(103, 2, 1, 'student', 76, 59, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 16:10:07'),
(104, 3, 1, 'student', 59, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 16:10:32'),
(105, 2, 1, 'student', 70, 59, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 16:11:39'),
(109, 2, 1, 'student', 81, 19, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 16:40:52'),
(110, 2, 1, 'student', 81, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 16:41:47'),
(111, 1, 1, 'student', 39, 41, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 16:48:13'),
(112, 2, 1, 'student', 96, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 16:52:29'),
(113, 1, 1, 'student', 88, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 17:10:14'),
(115, 3, 1, 'student', 66, 41, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 17:14:23'),
(116, 2, 1, 'student', 96, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 17:16:56'),
(117, 1, 1, 'student', 88, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 17:28:37'),
(118, 3, 1, 'student', 51, 58, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 17:50:10'),
(119, 2, 1, 'student', 65, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-13 17:51:24'),
(120, 2, 1, 'student', 65, 41, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-13 17:53:23'),
(123, 3, 1, 'student', 61, 32, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 00:46:11'),
(124, 2, 1, 'student', 70, 64, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 09:48:35'),
(125, 2, 1, 'student', 96, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 11:10:28'),
(126, 1, 1, 'student', 93, 34, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 11:27:15'),
(127, 2, 1, 'student', 68, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 11:30:34'),
(128, 3, 1, 'student', 59, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 11:45:30'),
(129, 3, 1, 'student', 69, 59, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 11:51:35'),
(130, 2, 1, 'student', 70, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 12:20:15'),
(131, 1, 1, 'student', 54, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 12:36:25'),
(132, 3, 1, 'student', 69, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 13:11:16'),
(133, 2, 1, 'student', 101, 44, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 13:56:25'),
(134, 1, 1, 'student', 87, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 13:57:36'),
(135, 1, 1, 'student', 87, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:00:48'),
(136, 3, 1, 'student', 61, 63, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:14:41'),
(137, 2, 1, 'student', 101, 63, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:22:18'),
(138, 2, 1, 'student', 71, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:40:57'),
(139, 2, 1, 'student', 71, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:41:32'),
(141, 3, 1, 'student', 80, 45, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 14:47:10'),
(142, 1, 1, 'student', 87, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:52:25'),
(143, 3, 1, 'student', 89, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:53:52'),
(145, 3, 1, 'student', 72, 64, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 14:57:39'),
(146, 2, 1, 'student', 47, 65, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:00:10'),
(147, 2, 1, 'student', 71, 64, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:01:13'),
(148, 2, 1, 'student', 71, 17, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 15:02:51'),
(149, 3, 1, 'student', 66, 62, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:12:14'),
(150, 3, 1, 'student', 89, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:12:36'),
(151, 2, 1, 'student', 76, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:13:12'),
(152, 2, 1, 'student', 76, 38, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 15:15:04'),
(153, 2, 1, 'student', 76, 30, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 15:15:58'),
(154, 2, 1, 'student', 76, 27, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 15:16:47'),
(155, 1, 1, 'student', 88, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:24:00'),
(156, 3, 1, 'student', 73, 64, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:26:43'),
(157, 2, 1, 'student', 81, 66, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:32:10'),
(158, 3, 1, 'student', 72, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:34:47'),
(161, 3, 1, 'student', 99, 65, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:53:45'),
(162, 3, 1, 'student', 73, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 15:55:57'),
(163, 2, 1, 'student', 58, 54, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:01:22'),
(164, 2, 1, 'student', 58, 55, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:02:47'),
(165, 2, 1, 'student', 58, 37, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-14 16:05:55'),
(166, 2, 1, 'student', 58, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:07:28'),
(167, 3, 1, 'student', 73, 59, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:18:08'),
(168, 1, 1, 'student', 67, 59, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:19:51'),
(169, 3, 1, 'student', 69, 69, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:28:02'),
(170, 3, 1, 'student', 62, 63, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:32:49'),
(172, 1, 1, 'student', 67, 71, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 16:53:04'),
(173, 2, 1, 'student', 96, 67, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 17:16:14'),
(174, 3, 1, 'student', 73, 71, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 17:31:41'),
(175, 2, 1, 'student', 68, 69, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 17:40:26'),
(176, 2, 1, 'student', 68, 71, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 17:40:59'),
(177, 1, 1, 'student', 67, 69, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 17:43:49'),
(179, 1, 1, 'student', 67, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 17:51:01'),
(181, 3, 1, 'student', 73, 69, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:03:32'),
(184, 3, 1, 'student', 73, 43, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:23:15'),
(185, 1, 1, 'student', 57, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:29:12'),
(186, 3, 1, 'student', 73, 42, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:32:25'),
(187, 2, 1, 'student', 65, 70, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:40:08'),
(189, 1, 1, 'student', 38, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:47:44'),
(191, 3, 1, 'student', 80, 64, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:52:59'),
(193, 3, 1, 'student', 80, 61, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-14 18:58:09'),
(196, 3, 1, 'student', 69, 71, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 00:01:10'),
(197, 1, 1, 'student', 38, 63, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 04:13:55'),
(198, 3, 1, 'student', 61, 70, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 06:23:51'),
(199, 1, 1, 'student', 54, 67, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 07:12:48'),
(200, 2, 1, 'student', 70, 71, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 09:36:05'),
(201, 2, 1, 'student', 70, 69, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 09:40:41'),
(202, 3, 1, 'student', 48, 65, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 10:10:42'),
(204, 1, 1, 'student', 37, 19, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-15 13:14:54'),
(206, 1, 1, 'student', 37, 26, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-15 13:27:23'),
(208, 1, 1, 'student', 37, 41, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-15 13:29:58'),
(209, 1, 1, 'student', 37, 63, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 13:31:18'),
(211, 2, 1, 'student', 101, 68, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 13:55:55'),
(213, 2, 1, 'student', 58, 67, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 15:27:32'),
(214, 3, 1, 'student', 62, 68, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 15:45:53'),
(215, 3, 1, 'student', 72, 69, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 16:00:43'),
(216, 3, 1, 'student', 62, 72, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 16:07:42'),
(217, 1, 1, 'student', 38, 19, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-15 16:09:12'),
(218, 3, 1, 'student', 59, 67, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 16:14:36'),
(219, 2, 1, 'student', 81, 63, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 16:14:52'),
(220, 1, 1, 'student', 38, 68, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 16:14:59'),
(222, 2, 1, 'student', 81, 16, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-15 16:21:00'),
(223, 2, 1, 'student', 81, 23, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-15 16:22:24'),
(225, 2, 1, 'student', 81, 72, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 16:34:59'),
(226, 1, 1, 'student', 38, 70, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 16:35:48'),
(228, 1, 1, 'student', 88, 67, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 17:16:10'),
(229, 1, 1, 'student', 38, 72, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-15 18:26:58'),
(230, 3, 1, 'student', 89, 67, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 01:41:20'),
(233, 2, 1, 'student', 68, 74, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 11:17:46'),
(234, 1, 1, 'student', 67, 74, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 11:35:20'),
(235, 1, 1, 'student', 67, 21, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 11:39:18'),
(236, 1, 1, 'student', 67, 24, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 11:42:22'),
(237, 1, 1, 'student', 39, 44, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 11:50:38'),
(238, 2, 1, 'student', 68, 79, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 13:20:46'),
(239, 3, 1, 'student', 69, 74, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 13:25:09'),
(240, 3, 1, 'student', 69, 75, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 13:43:19'),
(241, 1, 1, 'student', 64, 72, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 13:45:13'),
(242, 3, 1, 'student', 69, 79, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 14:00:01'),
(243, 1, 1, 'student', 54, 77, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 14:15:08'),
(244, 1, 1, 'student', 64, 41, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 14:22:26'),
(245, 1, 1, 'student', 38, 78, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 14:30:07'),
(246, 3, 1, 'student', 61, 68, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 14:49:23'),
(249, 1, 1, 'student', 54, 80, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 15:03:37'),
(250, 2, 1, 'student', 58, 80, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 15:33:56'),
(251, 2, 1, 'student', 58, 36, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 15:39:58'),
(252, 1, 1, 'student', 67, 79, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 15:47:17'),
(253, 2, 1, 'student', 58, 77, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 16:04:26'),
(254, 1, 1, 'student', 67, 75, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 16:28:42'),
(255, 1, 1, 'student', 39, 72, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 16:30:15'),
(256, 2, 1, 'student', 96, 80, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 16:53:47'),
(257, 2, 1, 'student', 96, 77, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 16:54:35'),
(258, 1, 1, 'student', 37, 70, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 17:04:35'),
(261, 1, 1, 'student', 37, 72, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 17:10:57'),
(263, 1, 1, 'student', 38, 44, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 17:44:55'),
(264, 3, 1, 'student', 61, 72, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-16 18:34:09'),
(265, 3, 1, 'student', 73, 79, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 18:46:25'),
(266, 3, 1, 'student', 73, 75, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-16 19:00:52'),
(267, 3, 1, 'student', 61, 76, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 01:38:06'),
(268, 2, 1, 'student', 70, 79, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 03:28:29'),
(269, 3, 1, 'student', 51, 73, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 04:36:49'),
(270, 2, 1, 'student', 70, 75, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 04:55:20'),
(271, 3, 1, 'student', 66, 78, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 12:25:47'),
(272, 3, 1, 'student', 59, 77, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 14:10:17'),
(273, 2, 1, 'student', 71, 79, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 14:42:46'),
(274, 2, 1, 'student', 101, 76, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 14:48:34'),
(275, 2, 1, 'student', 71, 71, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-17 14:58:00'),
(276, 2, 1, 'student', 101, 78, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:05:01'),
(277, 3, 1, 'student', 89, 60, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:15:08'),
(278, 3, 1, 'student', 89, 77, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:15:29'),
(279, 3, 1, 'student', 89, 80, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:16:07'),
(280, 3, 1, 'student', 62, 78, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:31:59'),
(281, 1, 1, 'student', 57, 67, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:34:11'),
(282, 3, 1, 'student', 62, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:34:44'),
(283, 3, 1, 'student', 59, 80, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:35:58'),
(284, 3, 1, 'student', 73, 74, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:53:22'),
(285, 1, 1, 'student', 57, 80, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 15:57:54'),
(286, 1, 1, 'student', 57, 77, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 16:19:32'),
(287, 3, 1, 'student', 62, 70, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-17 16:55:01'),
(288, 2, 1, 'student', 81, 78, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 16:57:07'),
(289, 2, 1, 'student', 81, 44, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 17:02:28'),
(290, 1, 1, 'student', 37, 44, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 17:08:53'),
(291, 1, 1, 'student', 88, 77, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 17:14:41'),
(292, 3, 1, 'student', 66, 70, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-17 17:31:15'),
(293, 3, 1, 'student', 61, 62, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 17:44:43'),
(294, 1, 1, 'student', 88, 80, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-17 18:18:18'),
(295, 1, 1, 'student', 87, 77, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-18 01:16:25'),
(296, 1, 1, 'student', 87, 80, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-18 14:02:28'),
(297, 3, 1, 'student', 72, 79, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-18 14:21:25'),
(298, 3, 1, 'student', 61, 78, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-18 15:25:59'),
(302, 3, 1, 'student', 72, 75, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-18 16:18:29'),
(304, 3, 1, 'student', 62, 76, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-18 18:10:38'),
(305, 1, 1, 'student', 103, 82, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 00:55:35'),
(307, 2, 1, 'student', 68, 84, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 17:05:09'),
(308, 3, 1, 'student', 69, 84, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 17:55:25'),
(309, 3, 1, 'student', 69, 86, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 18:20:08'),
(310, 1, 1, 'student', 93, 82, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 18:31:09'),
(311, 1, 1, 'student', 93, 88, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 18:46:14'),
(312, 3, 1, 'student', 69, 85, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 19:09:12'),
(314, 2, 1, 'student', 68, 81, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-19 19:31:24'),
(315, 2, 1, 'student', 68, 85, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 19:49:18'),
(316, 1, 1, 'student', 93, 89, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 19:50:39'),
(317, 1, 1, 'student', 67, 86, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 20:11:38'),
(318, 1, 1, 'student', 93, 87, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 20:37:29'),
(319, 3, 1, 'student', 102, 82, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 20:57:47'),
(320, 2, 1, 'student', 47, 90, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 21:01:33'),
(321, 1, 1, 'student', 87, 37, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-19 21:05:46'),
(322, 2, 1, 'student', 68, 86, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 21:09:23'),
(323, 1, 1, 'student', 103, 88, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 21:15:54'),
(324, 1, 1, 'student', 100, 82, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 21:19:32'),
(325, 1, 1, 'student', 37, 78, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-19 21:24:23'),
(326, 2, 1, 'student', 105, 82, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 21:40:49'),
(327, 1, 1, 'student', 67, 84, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 21:42:08'),
(329, 3, 1, 'student', 80, 24, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-19 21:50:22'),
(330, 1, 1, 'student', 67, 85, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 21:58:01'),
(331, 1, 1, 'student', 100, 89, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:07:33'),
(332, 2, 1, 'student', 92, 82, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:07:58'),
(333, 3, 1, 'student', 104, 89, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:23:04'),
(334, 2, 1, 'student', 92, 89, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:41:19'),
(335, 2, 1, 'student', 92, 87, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:41:37'),
(336, 2, 1, 'student', 92, 88, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:41:57'),
(337, 2, 1, 'student', 105, 89, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:42:54'),
(338, 2, 1, 'student', 105, 87, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:43:12'),
(339, 2, 1, 'student', 105, 88, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:43:32'),
(340, 3, 1, 'student', 102, 89, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:46:22'),
(341, 2, 1, 'student', 71, 84, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:50:59'),
(342, 3, 1, 'student', 80, 86, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 22:58:58'),
(343, 3, 1, 'student', 80, 42, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-19 23:04:38'),
(344, 2, 1, 'student', 70, 84, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 23:10:50'),
(345, 3, 1, 'student', 73, 84, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 23:20:39'),
(346, 3, 1, 'student', 80, 43, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-19 23:36:58'),
(347, 3, 1, 'student', 73, 85, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 23:38:28'),
(348, 3, 1, 'student', 80, 69, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-19 23:41:27'),
(349, 3, 1, 'student', 104, 87, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-19 23:52:21'),
(351, 2, 1, 'student', 70, 85, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 00:23:31'),
(353, 1, 1, 'student', 103, 89, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 06:59:21'),
(354, 2, 1, 'student', 76, 84, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 09:07:24'),
(355, 1, 1, 'student', 64, 44, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 12:12:09'),
(356, 1, 1, 'student', 64, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 12:15:07'),
(357, 1, 1, 'student', 54, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 14:58:04'),
(358, 3, 1, 'student', 104, 82, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 15:11:34'),
(359, 3, 1, 'student', 59, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 17:47:02'),
(360, 2, 1, 'student', 96, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 18:04:50'),
(361, 3, 1, 'student', 104, 88, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 18:23:37'),
(362, 1, 1, 'student', 103, 87, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 18:39:46'),
(363, 1, 1, 'student', 87, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 19:30:36'),
(365, 1, 1, 'student', 37, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 19:39:52'),
(366, 2, 1, 'student', 70, 86, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 19:52:37'),
(367, 2, 1, 'student', 70, 91, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 19:52:54'),
(368, 3, 1, 'student', 48, 90, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 20:21:33'),
(369, 3, 1, 'student', 89, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 20:24:38'),
(370, 1, 1, 'student', 100, 88, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 20:44:47'),
(371, 1, 1, 'student', 54, 93, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 20:46:42'),
(372, 3, 1, 'student', 72, 38, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 20:55:36'),
(373, 3, 1, 'student', 72, 84, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 20:58:29'),
(376, 1, 1, 'student', 57, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:09:16'),
(377, 1, 1, 'student', 64, 78, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 21:10:01'),
(378, 3, 1, 'student', 72, 85, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 21:21:32'),
(379, 3, 1, 'student', 72, 86, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:27:58'),
(380, 3, 1, 'student', 72, 71, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 21:33:44'),
(381, 1, 1, 'student', 57, 93, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:34:43'),
(382, 3, 1, 'student', 89, 93, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:39:32'),
(383, 2, 1, 'student', 58, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:41:29'),
(384, 2, 1, 'student', 58, 93, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:43:41'),
(385, 2, 1, 'student', 65, 62, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 21:44:58'),
(386, 2, 1, 'student', 71, 86, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:46:46'),
(387, 3, 1, 'student', 72, 91, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:46:51'),
(388, 1, 1, 'student', 88, 92, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 21:47:09'),
(389, 2, 1, 'student', 71, 91, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 22:00:14'),
(390, 3, 1, 'student', 72, 27, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 22:03:14'),
(391, 1, 1, 'student', 88, 93, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-20 22:28:10'),
(393, 2, 1, 'student', 65, 78, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 23:21:07'),
(394, 2, 1, 'student', 65, 76, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 23:22:45'),
(395, 3, 1, 'student', 80, 79, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 23:41:41'),
(396, 3, 1, 'student', 80, 84, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-20 23:43:54'),
(397, 1, 1, 'student', 87, 93, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 00:23:15'),
(398, 2, 1, 'student', 81, 62, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 00:41:35'),
(399, 1, 1, 'student', 100, 87, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-21 08:21:59'),
(400, 3, 1, 'student', 51, 94, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-21 08:55:48'),
(401, 3, 1, 'student', 107, 94, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-21 15:34:49'),
(402, 3, 1, 'student', 107, 58, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 15:54:23'),
(403, 3, 1, 'student', 107, 73, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 16:12:46'),
(404, 3, 1, 'student', 107, 95, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-21 16:26:24'),
(405, 3, 1, 'student', 61, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 18:21:24'),
(406, 1, 1, 'student', 64, 62, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 19:09:08'),
(407, 1, 1, 'student', 37, 23, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 19:36:24'),
(408, 1, 1, 'student', 37, 25, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 19:41:50'),
(409, 3, 1, 'student', 59, 93, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-21 19:49:47'),
(410, 1, 1, 'student', 64, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 20:09:26'),
(411, 1, 1, 'student', 39, 16, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 20:45:31'),
(412, 3, 1, 'student', 62, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 20:55:55'),
(413, 1, 1, 'student', 39, 20, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 21:03:57'),
(414, 1, 1, 'student', 39, 19, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 21:11:24'),
(415, 1, 1, 'student', 39, 23, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 21:44:28'),
(416, 2, 1, 'student', 96, 93, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-21 21:55:14'),
(417, 2, 1, 'student', 65, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 23:09:52'),
(418, 2, 1, 'student', 65, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 23:15:14'),
(419, 2, 1, 'student', 65, 44, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-21 23:58:38'),
(420, 2, 1, 'student', 65, 72, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 00:07:45'),
(421, 1, 1, 'student', 37, 33, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 06:33:09'),
(422, 1, 1, 'student', 37, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 06:37:20'),
(423, 3, 1, 'student', 51, 95, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 06:54:11'),
(424, 1, 1, 'student', 39, 70, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 16:03:37'),
(425, 1, 1, 'student', 39, 32, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 16:30:11'),
(426, 1, 1, 'student', 49, 73, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 19:15:53'),
(427, 1, 1, 'student', 49, 95, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 20:14:38'),
(428, 1, 1, 'student', 49, 94, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-22 20:32:10'),
(429, 3, 1, 'student', 80, 15, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-22 22:38:49'),
(430, 3, 1, 'student', 61, NULL, 15, 'ADD', 'Hydro pressure rocket submission', 'ADMIN', '2026-05-23 12:26:12'),
(431, 2, 1, 'student', 47, 96, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-23 13:36:42'),
(433, 3, 1, 'student', 73, NULL, -5, 'DEDUCT', 'Absence for the class', 'ADMIN', '2026-05-23 15:32:03'),
(435, 2, 1, 'student', 76, NULL, -5, 'DEDUCT', 'Absence for the class', 'ADMIN', '2026-05-23 15:33:05'),
(438, 1, 1, 'student', 38, 76, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-23 20:34:41'),
(439, 2, 1, 'student', 101, 97, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-23 20:42:28'),
(440, 3, 1, 'student', 110, 97, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-23 20:49:44'),
(441, 1, 1, 'student', 39, 26, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-23 21:08:16'),
(442, 3, 1, 'student', 62, 97, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-23 21:15:55'),
(443, 1, 1, 'student', 39, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-23 21:31:03'),
(444, 1, 1, 'student', 39, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-23 21:35:48'),
(445, 1, 1, 'student', 39, 97, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-23 22:35:45'),
(446, 2, 1, 'student', 81, 97, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-23 23:52:35'),
(447, 2, 1, 'student', 81, 26, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-23 23:54:49'),
(448, 2, 1, 'student', 65, 97, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 00:00:26'),
(450, 2, 1, 'student', 65, 26, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 00:13:21'),
(451, 2, 1, 'student', 65, 33, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 00:15:21'),
(453, 3, 1, 'student', 102, 88, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 09:50:09'),
(458, 3, 1, 'student', 48, 96, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 18:53:17'),
(459, 2, 1, 'student', 76, 79, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 19:34:54'),
(460, 2, 1, 'student', 76, 85, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 19:44:54'),
(461, 2, 1, 'student', 76, 86, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 19:55:18'),
(462, 2, 1, 'student', 76, 17, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 20:00:24'),
(463, 2, 1, 'student', 76, 69, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 20:03:23'),
(464, 2, 1, 'student', 108, 87, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 20:23:19'),
(465, 1, 1, 'student', 39, 33, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 20:32:02'),
(466, 2, 1, 'student', 68, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 21:13:34'),
(467, 1, 1, 'student', 39, 68, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 21:14:17'),
(468, 1, 1, 'student', 54, 98, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 21:19:33'),
(469, 1, 1, 'student', 39, 78, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 21:30:11'),
(470, 1, 1, 'student', 39, 63, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-24 21:50:39'),
(471, 2, 1, 'student', 58, 98, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 21:54:39'),
(472, 3, 1, 'student', 73, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 22:39:54'),
(473, 1, 1, 'student', 39, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 23:07:55'),
(474, 2, 1, 'student', 70, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-24 23:45:29'),
(475, 3, 1, 'student', 69, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 18:09:26'),
(476, 1, 1, 'student', 54, 100, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 19:18:21'),
(477, 2, 1, 'student', 76, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 19:54:25'),
(478, 1, 1, 'student', 87, 98, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 20:21:46'),
(479, 1, 1, 'student', 106, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 20:32:02'),
(481, 1, 1, 'student', 106, 79, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-25 21:09:57'),
(482, 3, 1, 'student', 72, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 21:19:51'),
(483, 1, 1, 'student', 106, 74, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-25 21:32:50'),
(484, 2, 1, 'student', 58, 100, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 21:34:03'),
(485, 1, 1, 'student', 67, 99, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-25 21:41:39'),
(488, 1, 1, 'student', 100, 101, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-26 15:47:10'),
(489, 3, 1, 'student', 59, 98, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-26 18:22:41'),
(490, 1, 1, 'student', 93, 101, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-26 20:21:05'),
(491, 2, 1, 'student', 81, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-26 20:44:07'),
(492, 1, 1, 'student', 57, 100, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-26 22:51:57'),
(493, 1, 1, 'student', 57, 98, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-26 22:52:36'),
(494, 1, 1, 'student', 88, 98, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-26 23:47:39'),
(495, 1, 1, 'student', 88, 100, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-26 23:52:08'),
(496, 3, 1, 'student', 59, 100, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-27 05:47:09'),
(497, 2, 1, 'student', 108, 101, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-29 19:50:15'),
(498, 3, 1, 'student', 104, 103, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-31 00:41:22'),
(499, 1, 1, 'student', 100, 103, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-31 09:58:45'),
(500, 1, 1, 'student', 54, 102, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-31 13:10:02'),
(501, 1, 1, 'student', 64, 97, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-05-31 20:22:26'),
(502, 2, 1, 'student', 105, 103, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-05-31 21:53:06'),
(503, 2, 1, 'student', 58, 102, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 16:52:54'),
(504, 1, 1, 'student', 93, 103, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 17:44:48'),
(505, 2, 1, 'student', 68, 104, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 18:28:36'),
(506, 2, 1, 'student', 68, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 18:51:36'),
(507, 2, 1, 'student', 96, 98, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-01 19:20:50'),
(508, 3, 1, 'student', 72, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 19:25:04'),
(509, 1, 1, 'student', 103, 103, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 19:40:11'),
(510, 2, 1, 'student', 96, 100, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-01 19:44:34'),
(511, 2, 1, 'student', 112, 106, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 19:48:18'),
(512, 3, 1, 'student', 69, 104, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 19:56:24'),
(513, 1, 1, 'student', 54, 106, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 19:57:50'),
(514, 2, 1, 'student', 96, 106, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 19:59:50'),
(515, 3, 1, 'student', 72, 104, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:03:06'),
(516, 3, 1, 'student', 69, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:07:52'),
(517, 2, 1, 'student', 70, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:13:52'),
(518, 1, 1, 'student', 67, 104, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:24:18'),
(519, 1, 1, 'student', 106, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:27:50'),
(520, 1, 1, 'student', 57, 106, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:38:23'),
(521, 2, 1, 'student', 65, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:47:00'),
(522, 1, 1, 'student', 103, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:52:55'),
(523, 3, 1, 'student', 59, 106, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 20:57:34'),
(524, 2, 1, 'student', 105, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:05:50'),
(525, 1, 1, 'student', 93, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:09:14'),
(526, 1, 1, 'student', 88, 102, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:09:48'),
(527, 3, 1, 'student', 89, 106, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:15:13'),
(528, 2, 1, 'student', 81, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:16:01'),
(529, 1, 1, 'student', 67, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:16:14'),
(530, 2, 1, 'student', 81, 9, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-01 21:17:07'),
(531, 1, 1, 'student', 88, 106, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:33:09'),
(532, 1, 1, 'student', 38, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:37:45'),
(533, 1, 1, 'student', 57, 110, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:47:00'),
(534, 3, 1, 'student', 59, 110, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 21:55:51'),
(536, 1, 1, 'student', 64, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-01 22:03:01'),
(537, 3, 1, 'student', 89, 102, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:03:20'),
(538, 1, 1, 'student', 64, 26, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-01 22:03:57'),
(539, 3, 1, 'student', 61, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:09:27'),
(540, 2, 1, 'student', 105, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:29:38'),
(541, 3, 1, 'student', 104, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:34:10'),
(542, 1, 1, 'student', 64, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:36:57'),
(543, 3, 1, 'student', 73, 104, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:37:22'),
(544, 2, 1, 'student', 105, 111, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:47:58'),
(545, 2, 1, 'student', 92, 103, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 22:58:27'),
(546, 3, 1, 'student', 80, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 23:06:12'),
(547, 3, 1, 'student', 62, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 23:11:17'),
(548, 3, 1, 'student', 73, 105, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 23:14:54'),
(549, 3, 1, 'student', 104, 111, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-01 23:51:06');
INSERT INTO `house_point_logs` (`id`, `house_id`, `academic_year_id`, `entity_type`, `entity_id`, `homework_id`, `points`, `action`, `reason`, `source`, `created_at`) VALUES
(551, 2, 1, 'student', 65, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 00:16:02'),
(553, 3, 1, 'student', 104, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 00:30:49'),
(554, 2, 1, 'student', 92, 111, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 00:37:14'),
(555, 2, 1, 'student', 92, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 00:37:45'),
(556, 1, 1, 'student', 39, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 01:23:25'),
(557, 2, 1, 'student', 101, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 06:22:41'),
(558, 2, 1, 'student', 101, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 06:34:46'),
(559, 2, 1, 'student', 101, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 06:54:19'),
(560, 1, 1, 'student', 87, 106, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 07:01:08'),
(561, 1, 1, 'student', 37, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 07:28:20'),
(562, 2, 1, 'student', 58, 106, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 11:36:46'),
(563, 2, 1, 'student', 96, 110, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 15:18:28'),
(564, 2, 1, 'student', 68, 113, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 15:32:02'),
(565, 3, 1, 'student', 59, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 15:33:08'),
(566, 1, 1, 'student', 54, 110, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 15:59:04'),
(567, 2, 1, 'student', 65, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 16:01:14'),
(568, 1, 1, 'student', 93, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 16:40:20'),
(569, 2, 1, 'student', 65, 115, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 17:21:22'),
(570, 2, 1, 'student', 47, 122, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 17:43:37'),
(571, 2, 1, 'student', 47, 120, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 17:44:43'),
(572, 2, 1, 'student', 68, 121, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 17:58:54'),
(573, 3, 1, 'student', 110, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 18:06:44'),
(574, 1, 1, 'student', 54, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 18:22:13'),
(575, 1, 1, 'student', 93, 118, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 18:34:37'),
(576, 3, 1, 'student', 110, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 18:39:50'),
(577, 1, 1, 'student', 103, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 18:40:44'),
(578, 2, 1, 'student', 108, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 18:57:25'),
(579, 2, 1, 'student', 68, 123, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:04:27'),
(580, 1, 1, 'student', 103, 111, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:06:08'),
(582, 2, 1, 'student', 47, 109, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:21:45'),
(583, 1, 1, 'student', 100, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:22:22'),
(584, 2, 1, 'student', 58, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:26:21'),
(585, 2, 1, 'student', 96, 102, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 19:33:52'),
(586, 3, 1, 'student', 113, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:34:57'),
(587, 2, 1, 'student', 58, 110, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:35:32'),
(588, 2, 1, 'student', 58, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:53:26'),
(589, 1, 1, 'student', 93, 111, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 19:57:31'),
(590, 2, 1, 'student', 68, 124, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 19:59:30'),
(591, 1, 1, 'student', 57, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:03:04'),
(592, 2, 1, 'student', 70, 104, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:08:15'),
(593, 1, 1, 'student', 88, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:11:04'),
(594, 3, 1, 'student', 61, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:15:57'),
(595, 1, 1, 'student', 57, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:19:29'),
(596, 1, 1, 'student', 67, 124, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 20:21:33'),
(597, 2, 1, 'student', 53, 118, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:29:45'),
(598, 3, 1, 'student', 113, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:31:30'),
(599, 2, 1, 'student', 68, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:35:42'),
(600, 3, 1, 'student', 113, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:38:13'),
(601, 3, 1, 'student', 61, 97, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 20:38:22'),
(602, 3, 1, 'student', 48, 109, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:39:44'),
(603, 3, 1, 'student', 104, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:42:57'),
(604, 1, 1, 'student', 38, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:44:40'),
(605, 2, 1, 'student', 108, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:44:52'),
(606, 1, 1, 'student', 88, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:46:42'),
(607, 1, 1, 'student', 106, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:50:53'),
(608, 1, 1, 'student', 64, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:52:18'),
(610, 2, 1, 'student', 53, 101, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 20:56:32'),
(611, 3, 1, 'student', 113, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 20:58:37'),
(612, 3, 1, 'student', 48, 128, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:03:53'),
(613, 1, 1, 'student', 103, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:07:07'),
(614, 3, 1, 'student', 59, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:08:32'),
(615, 1, 1, 'student', 106, 119, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:11:45'),
(616, 3, 1, 'student', 89, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:14:32'),
(617, 1, 1, 'student', 64, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:20:21'),
(618, 3, 1, 'student', 73, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:21:15'),
(619, 1, 1, 'student', 67, 121, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:23:05'),
(620, 3, 1, 'student', 66, 107, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:25:01'),
(621, 1, 1, 'student', 67, 113, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:26:40'),
(622, 1, 1, 'student', 38, 115, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:29:41'),
(623, 1, 1, 'student', 54, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:31:03'),
(624, 1, 1, 'student', 39, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:33:11'),
(626, 2, 1, 'student', 47, 128, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:34:45'),
(627, 2, 1, 'student', 81, 115, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:36:26'),
(628, 2, 1, 'student', 81, 20, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 21:36:56'),
(629, 2, 1, 'student', 81, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:37:23'),
(630, 3, 1, 'student', 62, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:39:34'),
(631, 1, 1, 'student', 100, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:42:03'),
(632, 1, 1, 'student', 103, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:44:10'),
(633, 3, 1, 'student', 48, 130, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:50:23'),
(634, 3, 1, 'student', 66, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:59:12'),
(635, 1, 1, 'student', 100, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 21:59:35'),
(637, 2, 1, 'student', 65, 9, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 22:06:47'),
(638, 2, 1, 'student', 47, 130, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:08:13'),
(639, 2, 1, 'student', 101, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:10:38'),
(640, 1, 1, 'student', 38, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:14:38'),
(641, 2, 1, 'student', 81, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:18:30'),
(642, 3, 1, 'student', 69, 113, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:23:14'),
(643, 3, 1, 'student', 69, 124, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 22:24:50'),
(644, 3, 1, 'student', 61, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:29:14'),
(645, 1, 1, 'student', 67, 119, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:39:47'),
(646, 1, 1, 'student', 37, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:40:43'),
(647, 1, 1, 'student', 100, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:41:54'),
(648, 2, 1, 'student', 53, 103, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 22:43:28'),
(649, 3, 1, 'student', 113, 111, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:43:47'),
(650, 2, 1, 'student', 101, 115, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:44:26'),
(651, 3, 1, 'student', 69, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:46:01'),
(652, 3, 1, 'student', 66, 115, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:48:10'),
(653, 3, 1, 'student', 61, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 22:49:46'),
(654, 1, 1, 'student', 37, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:54:57'),
(655, 1, 1, 'student', 67, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 22:57:27'),
(657, 1, 1, 'student', 37, 62, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 23:00:17'),
(658, 1, 1, 'student', 37, 68, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 23:03:23'),
(659, 1, 1, 'student', 37, 76, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 23:05:40'),
(660, 2, 1, 'student', 70, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 23:06:07'),
(661, 3, 1, 'student', 104, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 23:33:12'),
(662, 1, 1, 'student', 37, 115, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 23:34:37'),
(663, 1, 1, 'student', 106, 113, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 23:37:09'),
(664, 1, 1, 'student', 39, 115, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 23:39:01'),
(666, 1, 1, 'student', 37, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-02 23:45:42'),
(667, 3, 1, 'student', 61, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-02 23:59:40'),
(668, 1, 1, 'student', 37, 97, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 00:05:08'),
(669, 2, 1, 'student', 112, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 09:01:13'),
(670, 1, 1, 'student', 93, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 09:09:13'),
(671, 3, 1, 'student', 102, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 09:10:47'),
(672, 1, 1, 'student', 100, 118, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 09:14:02'),
(673, 3, 1, 'student', 102, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 10:22:47'),
(674, 3, 1, 'student', 102, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 11:16:31'),
(675, 2, 1, 'student', 53, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 14:21:50'),
(676, 2, 1, 'student', 105, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 15:00:17'),
(677, 2, 1, 'student', 112, 54, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 15:02:11'),
(678, 2, 1, 'student', 53, 111, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 15:03:31'),
(679, 2, 1, 'student', 112, 92, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 15:07:13'),
(680, 2, 1, 'student', 112, 100, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 15:10:29'),
(681, 1, 1, 'student', 49, 58, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 15:23:53'),
(682, 2, 1, 'student', 112, 110, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 15:43:55'),
(683, 2, 1, 'student', 96, 126, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 15:47:59'),
(684, 2, 1, 'student', 112, 77, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 16:00:19'),
(685, 2, 1, 'student', 53, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 16:15:50'),
(687, 2, 1, 'student', 96, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 16:57:45'),
(688, 2, 1, 'student', 112, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 17:01:13'),
(689, 2, 1, 'student', 53, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 17:13:22'),
(690, 2, 1, 'student', 53, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 17:14:45'),
(691, 2, 1, 'student', 105, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 17:21:22'),
(692, 2, 1, 'student', 101, 33, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 17:25:29'),
(693, 2, 1, 'student', 101, 46, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 17:28:38'),
(694, 2, 1, 'student', 101, 26, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 17:29:13'),
(695, 2, 1, 'student', 101, 72, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 17:29:51'),
(696, 2, 1, 'student', 101, 39, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 17:30:31'),
(697, 2, 1, 'student', 101, 62, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 17:32:04'),
(698, 2, 1, 'student', 101, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 17:32:58'),
(699, 2, 1, 'student', 76, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 17:54:07'),
(700, 2, 1, 'student', 76, 105, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 18:05:17'),
(701, 1, 1, 'student', 38, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 18:07:41'),
(702, 2, 1, 'student', 101, 133, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 18:14:02'),
(703, 3, 1, 'student', 62, 33, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 18:30:01'),
(705, 3, 1, 'student', 62, 62, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 18:42:38'),
(706, 1, 1, 'student', 93, 131, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 18:43:08'),
(707, 2, 1, 'student', 71, 99, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:14:30'),
(708, 2, 1, 'student', 71, 105, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:19:12'),
(709, 3, 1, 'student', 61, 133, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 19:35:08'),
(710, 3, 1, 'student', 69, 119, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 19:41:58'),
(711, 2, 1, 'student', 101, 16, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:49:11'),
(712, 2, 1, 'student', 101, 19, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:49:53'),
(713, 2, 1, 'student', 101, 25, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:51:22'),
(715, 2, 1, 'student', 101, 23, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:54:55'),
(716, 2, 1, 'student', 101, 20, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:55:32'),
(717, 2, 1, 'student', 101, 9, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 19:56:15'),
(718, 3, 1, 'student', 66, 19, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:02:56'),
(719, 3, 1, 'student', 66, 76, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:11:41'),
(720, 2, 1, 'student', 71, 85, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:13:49'),
(722, 2, 1, 'student', 71, 31, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:15:10'),
(723, 2, 1, 'student', 71, 45, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:15:53'),
(724, 2, 1, 'student', 71, 59, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:16:15'),
(725, 2, 1, 'student', 47, 134, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:16:55'),
(726, 2, 1, 'student', 71, 69, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:17:29'),
(727, 2, 1, 'student', 71, 74, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:18:43'),
(728, 3, 1, 'student', 66, 83, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:18:44'),
(729, 2, 1, 'student', 71, 75, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:19:43'),
(730, 3, 1, 'student', 66, 97, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:22:21'),
(731, 3, 1, 'student', 110, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:26:39'),
(732, 1, 1, 'student', 88, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:28:21'),
(733, 3, 1, 'student', 69, 121, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:30:47'),
(734, 3, 1, 'student', 102, 111, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:32:01'),
(735, 1, 1, 'student', 54, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:36:08'),
(736, 3, 1, 'student', 102, 87, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 20:45:30'),
(737, 3, 1, 'student', 72, 119, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:49:10'),
(738, 2, 1, 'student', 58, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:50:19'),
(739, 2, 1, 'student', 71, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 20:53:02'),
(742, 3, 1, 'student', 102, 112, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:05:57'),
(743, 3, 1, 'student', 72, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:13:05'),
(744, 1, 1, 'student', 100, 132, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:22:55'),
(745, 2, 1, 'student', 96, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:31:23'),
(746, 2, 1, 'student', 68, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:32:15'),
(747, 2, 1, 'student', 81, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:35:49'),
(749, 2, 1, 'student', 108, 111, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-03 21:39:21'),
(750, 3, 1, 'student', 62, 116, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:43:27'),
(751, 3, 1, 'student', 73, 140, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:45:33'),
(752, 1, 1, 'student', 57, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:47:26'),
(753, 1, 1, 'student', 67, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:49:17'),
(754, 2, 1, 'student', 65, 133, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:49:38'),
(755, 2, 1, 'student', 101, 139, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:50:52'),
(756, 2, 1, 'student', 70, 119, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:53:44'),
(757, 2, 1, 'student', 65, 137, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 21:59:46'),
(758, 3, 1, 'student', 73, 119, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:03:02'),
(759, 3, 1, 'student', 69, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:09:48'),
(760, 3, 1, 'student', 61, 139, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:13:02'),
(761, 3, 1, 'student', 62, 139, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:14:18'),
(763, 3, 1, 'student', 51, 136, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:18:49'),
(765, 3, 1, 'student', 66, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:22:42'),
(766, 2, 1, 'student', 68, 143, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:23:07'),
(767, 3, 1, 'student', 59, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:25:08'),
(768, 2, 1, 'student', 92, 108, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:25:12'),
(769, 2, 1, 'student', 92, 129, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:26:00'),
(770, 3, 1, 'student', 73, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:31:04'),
(771, 2, 1, 'student', 71, 119, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:37:39'),
(772, 3, 1, 'student', 62, 133, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 22:55:46'),
(773, 3, 1, 'student', 89, 117, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 23:10:26'),
(775, 3, 1, 'student', 66, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-03 23:59:25'),
(776, 3, 1, 'student', 62, 115, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 00:05:39'),
(777, 2, 1, 'student', 81, 139, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 00:05:46'),
(778, 2, 1, 'student', 81, 137, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 00:15:15'),
(780, 1, 1, 'student', 37, 133, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 06:38:15'),
(781, 2, 1, 'student', 71, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 08:01:09'),
(782, 2, 1, 'student', 76, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 08:03:04'),
(783, 2, 1, 'student', 71, 143, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 08:22:16'),
(784, 2, 1, 'student', 70, 143, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 09:00:48'),
(785, 2, 1, 'student', 71, 104, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 09:03:36'),
(786, 1, 1, 'student', 100, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 10:17:15'),
(787, 2, 1, 'student', 112, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 10:54:18'),
(788, 2, 1, 'student', 105, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 17:20:24'),
(789, 3, 1, 'student', 62, 9, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 18:12:28'),
(790, 2, 1, 'student', 70, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 18:18:28'),
(791, 2, 1, 'student', 53, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 18:28:08'),
(792, 1, 1, 'student', 49, 136, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 18:29:58'),
(793, 1, 1, 'student', 67, 143, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 18:33:52'),
(794, 1, 1, 'student', 38, 133, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 18:49:52'),
(795, 3, 1, 'student', 89, 135, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 18:50:42'),
(796, 3, 1, 'student', 89, 100, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 18:54:54'),
(797, 3, 1, 'student', 110, 139, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 18:58:41'),
(798, 3, 1, 'student', 104, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 19:04:36'),
(799, 2, 1, 'student', 76, 10, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 19:07:13'),
(800, 1, 1, 'student', 103, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 19:07:45'),
(801, 2, 1, 'student', 76, 15, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 19:07:54'),
(803, 2, 1, 'student', 76, 35, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 19:09:08'),
(805, 2, 1, 'student', 76, 74, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 19:10:43'),
(806, 3, 1, 'student', 69, 143, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 19:30:42'),
(807, 2, 1, 'student', 76, 119, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 19:35:04'),
(808, 2, 1, 'student', 76, 113, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 19:36:21'),
(809, 2, 1, 'student', 76, 143, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 19:42:19'),
(810, 2, 1, 'student', 76, 104, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 19:52:51'),
(811, 2, 1, 'student', 70, 140, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:01:31'),
(812, 3, 1, 'student', 110, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:10:06'),
(813, 3, 1, 'student', 107, 136, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:14:50'),
(814, 3, 1, 'student', 104, 148, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:19:30'),
(816, 3, 1, 'student', 48, 134, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 20:27:46'),
(818, 3, 1, 'student', 107, 144, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:31:36'),
(819, 1, 1, 'student', 93, 132, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:43:47'),
(820, 1, 1, 'student', 93, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:46:22'),
(821, 3, 1, 'student', 89, 110, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 20:52:40'),
(822, 3, 1, 'student', 80, 74, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 21:38:41'),
(823, 3, 1, 'student', 80, 99, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 21:41:27'),
(824, 3, 1, 'student', 102, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 21:45:32'),
(825, 3, 1, 'student', 80, 21, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 21:48:45'),
(826, 3, 1, 'student', 48, 120, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 21:55:25'),
(827, 3, 1, 'student', 102, 148, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 22:14:34'),
(828, 2, 1, 'student', 65, 147, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 22:18:25'),
(829, 3, 1, 'student', 80, 22, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 22:19:22'),
(831, 1, 1, 'student', 49, 144, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 22:22:13'),
(833, 3, 1, 'student', 62, 147, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 22:24:47'),
(834, 3, 1, 'student', 48, 122, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 22:34:33'),
(835, 2, 1, 'student', 71, 140, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 22:42:36'),
(836, 1, 1, 'student', 39, 133, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 22:46:57'),
(837, 2, 1, 'student', 92, 131, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-04 23:15:03'),
(838, 2, 1, 'student', 92, 145, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 23:16:18'),
(839, 3, 1, 'student', 80, 127, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 23:22:50'),
(840, 3, 1, 'student', 80, 143, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-04 23:25:19'),
(841, 3, 1, 'student', 61, 147, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 06:15:05'),
(842, 3, 1, 'student', 51, 144, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 06:48:13'),
(843, 1, 1, 'student', 38, 139, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-05 07:01:41'),
(844, 2, 1, 'student', 105, 148, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 11:30:47'),
(845, 3, 1, 'student', 59, 146, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 13:34:10'),
(847, 2, 1, '', 0, NULL, 30, 'ADD', 'Wesak lantern 2nd place', 'ADMIN', '2026-06-05 13:50:48'),
(848, 1, 1, '', 0, NULL, 50, 'ADD', 'Wesak lantern. 1st place', 'ADMIN', '2026-06-05 13:51:12'),
(849, 3, 1, '', 0, NULL, 10, 'ADD', 'Wesak lantern 3rd place', 'ADMIN', '2026-06-05 13:51:30'),
(850, 2, 1, 'student', 81, 147, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 14:08:53'),
(851, 3, 1, 'student', 113, 145, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-05 15:03:15'),
(852, 3, 1, 'student', 113, 148, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 17:11:49'),
(853, 3, 1, 'student', 110, 133, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-05 19:24:27'),
(854, 3, 1, 'student', 72, 141, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 20:01:24'),
(856, 1, 1, 'student', 37, 137, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 21:51:43'),
(857, 2, 1, 'student', 70, 121, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 22:17:15'),
(858, 1, 1, 'student', 37, 147, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 22:29:14'),
(859, 1, 1, 'student', 37, 125, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-05 22:32:04'),
(860, 3, 1, 'student', 80, 140, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-06 01:39:50'),
(861, 1, 1, 'student', 88, 110, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-06 15:02:20'),
(862, 1, 1, 'student', 38, 147, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-06 19:44:58'),
(863, 2, 1, 'student', 81, 68, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-07 12:38:26'),
(864, 2, 1, 'student', 81, 32, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-07 12:38:45'),
(868, 2, 1, 'student', 58, 146, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 15:20:04'),
(869, 2, 1, 'student', 68, 150, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 19:00:24'),
(870, 1, 1, 'student', 87, 126, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-07 20:04:55'),
(871, 1, 1, 'student', 87, 117, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-07 20:11:02'),
(872, 1, 1, 'student', 93, 148, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 20:26:26'),
(873, 3, 1, 'student', 62, 114, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 20:39:07'),
(874, 2, 1, 'student', 47, 152, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 20:46:04'),
(875, 1, 1, 'student', 87, 100, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-07 21:29:04'),
(876, 1, 1, 'student', 93, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 21:29:43'),
(877, 1, 1, 'student', 87, 135, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-07 21:58:37'),
(878, 3, 1, 'student', 104, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 22:08:15'),
(879, 1, 1, 'student', 39, 149, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 23:19:21'),
(880, 1, 1, 'student', 37, 149, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-07 23:20:45'),
(881, 2, 1, 'student', 47, 153, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 08:49:39'),
(882, 3, 1, 'student', 48, 153, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 08:51:06'),
(885, 3, 1, 'student', 48, 152, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 13:31:35'),
(888, 1, 1, 'student', 37, NULL, 10, 'ADD', 'Student of the Week', 'ADMIN', '2026-06-08 13:43:39'),
(889, 3, 1, 'student', 89, 146, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 13:55:43'),
(890, 2, 1, 'student', 47, 155, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 13:58:42'),
(891, 1, 1, 'student', 54, 146, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 14:01:11'),
(892, 1, 1, 'student', 88, 146, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 14:41:04'),
(893, 2, 1, 'student', 53, 142, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 14:57:22'),
(894, 2, 1, 'student', 53, 82, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 15:16:47'),
(895, 2, 1, 'student', 53, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 16:08:15'),
(896, 2, 1, 'student', 53, 89, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 16:10:53'),
(897, 3, 1, 'student', 107, 157, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 17:14:16'),
(898, 3, 1, 'student', 107, 161, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 17:38:43'),
(899, 3, 1, 'student', 107, 165, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 17:49:45'),
(900, 3, 1, 'student', 69, 156, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 17:53:25'),
(901, 2, 1, 'student', 53, 148, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 17:54:01'),
(902, 2, 1, 'student', 53, 164, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 17:57:28'),
(903, 3, 1, 'student', 113, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 17:58:47'),
(904, 2, 1, 'student', 47, 166, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 18:21:27'),
(905, 2, 1, 'student', 105, 158, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 18:22:10'),
(906, 2, 1, 'student', 105, 164, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 18:22:27'),
(907, 2, 1, 'student', 105, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 18:22:51'),
(908, 2, 1, 'student', 47, 167, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 18:36:34'),
(909, 2, 1, 'student', 112, 146, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 18:50:08'),
(910, 1, 1, 'student', 93, 142, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 18:58:30'),
(911, 1, 1, 'student', 103, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 19:12:54'),
(912, 3, 1, 'student', 113, 164, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 19:14:02'),
(913, 2, 1, 'student', 47, 160, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 19:19:18'),
(914, 2, 1, 'student', 112, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 19:20:09'),
(915, 2, 1, 'student', 71, 22, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 19:30:47'),
(916, 2, 1, 'student', 71, 61, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 19:35:57'),
(917, 2, 1, 'student', 112, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 19:36:15'),
(918, 2, 1, 'student', 112, 154, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 19:45:17'),
(919, 2, 1, 'student', 76, 170, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 19:53:40'),
(920, 2, 1, 'student', 76, 169, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:00:23'),
(921, 2, 1, 'student', 47, 159, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:01:05'),
(922, 1, 1, 'student', 87, 154, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:04:13'),
(923, 1, 1, 'student', 67, 156, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:08:38'),
(924, 3, 1, 'student', 89, 154, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:13:39'),
(925, 1, 1, 'student', 54, 168, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:22:30'),
(926, 3, 1, 'student', 99, 90, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 20:23:36'),
(927, 1, 1, 'student', 87, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:39:08'),
(928, 1, 1, 'student', 103, 164, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:40:23'),
(929, 3, 1, 'student', 89, 168, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:41:12'),
(930, 3, 1, 'student', 113, 158, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:41:59'),
(931, 1, 1, 'student', 100, 171, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:43:51'),
(932, 3, 1, 'student', 73, 156, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:43:55'),
(933, 1, 1, 'student', 93, 164, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:46:15'),
(934, 1, 1, 'student', 88, 154, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:48:56'),
(935, 1, 1, 'student', 87, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:51:36'),
(936, 1, 1, 'student', 88, 168, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:52:10'),
(937, 2, 1, 'student', 105, 171, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 20:56:13'),
(938, 2, 1, 'student', 76, 172, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:01:26'),
(939, 2, 1, 'student', 68, 169, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:06:52'),
(940, 3, 1, 'student', 113, 171, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:08:06'),
(941, 3, 1, 'student', 51, 161, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:18:18'),
(942, 1, 1, 'student', 103, 171, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:18:58'),
(943, 1, 1, 'student', 87, 168, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:19:34'),
(944, 2, 1, 'student', 68, 156, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:28:52'),
(945, 1, 1, 'student', 100, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:31:50'),
(946, 2, 1, 'student', 68, 170, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:34:38'),
(947, 1, 1, 'student', 93, 171, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:35:37'),
(948, 2, 1, 'student', 58, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:47:28'),
(949, 3, 1, 'student', 104, 164, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:48:38'),
(950, 2, 1, 'student', 68, 172, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:48:52'),
(951, 2, 1, 'student', 70, 156, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 21:59:41'),
(952, 1, 1, 'student', 106, 143, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 22:06:09'),
(953, 2, 1, 'student', 58, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:09:43'),
(955, 2, 1, 'student', 58, 154, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:14:15'),
(956, 1, 1, 'student', 39, 147, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 22:26:01'),
(957, 3, 1, 'student', 89, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:26:57'),
(958, 3, 1, 'student', 89, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:27:22'),
(959, 3, 1, 'student', 59, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:36:47'),
(960, 3, 1, 'student', 66, 147, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-08 22:40:00'),
(961, 1, 1, 'student', 88, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:41:01'),
(962, 1, 1, 'student', 39, 137, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:41:36'),
(963, 2, 1, 'student', 70, 150, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:52:55'),
(964, 3, 1, 'student', 104, 171, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:57:46'),
(965, 3, 1, 'student', 61, 137, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 22:58:54'),
(966, 2, 1, 'student', 92, 151, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:02:55'),
(967, 3, 1, 'student', 59, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:03:13'),
(968, 2, 1, 'student', 92, 171, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:03:23'),
(969, 1, 1, 'student', 57, 154, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:06:44'),
(970, 1, 1, 'student', 57, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:07:54'),
(971, 2, 1, 'student', 58, 168, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:16:40'),
(972, 1, 1, 'student', 57, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:18:09'),
(973, 1, 1, 'student', 57, 168, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:19:03'),
(974, 1, 1, 'student', 106, 169, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:20:48'),
(975, 1, 1, 'student', 88, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:29:25'),
(976, 1, 1, 'student', 57, 146, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-08 23:48:57'),
(977, 2, 1, 'student', 105, 173, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 00:03:09'),
(978, 2, 1, 'student', 65, 125, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-09 00:43:46'),
(979, 2, 1, 'student', 92, 173, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 01:35:34'),
(980, 2, 1, 'student', 92, 164, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 01:36:26'),
(981, 2, 1, 'student', 92, 148, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 01:36:48'),
(982, 2, 1, 'student', 101, 147, 1, 'ADD', 'Late homework submission', 'HOMEWORK', '2026-06-09 06:31:01'),
(983, 2, 1, 'student', 101, 137, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 10:04:40'),
(985, 3, 1, 'student', 59, 168, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 12:02:58'),
(986, 1, 1, 'student', 54, 162, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 13:33:13'),
(987, 1, 1, 'student', 54, 163, 3, 'ADD', 'On-time homework submission', 'HOMEWORK', '2026-06-09 13:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `code`) VALUES
(1, 'Sick Leave', 'SICK'),
(2, 'Casual Leave', 'CASUAL'),
(3, 'Annual Leave', 'ANNUAL');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `full_name`, `user_id`, `email`, `phone`, `occupation`, `address`, `password`, `created_at`) VALUES
(3, 'Ziyard', 54, 'ziyard@gmail.com', '94778535552', '', '', NULL, '2026-01-08 10:15:03'),
(4, 'Test', 55, 'test2@gmail.com', '94776994569', '', '', NULL, '2026-01-08 11:52:24'),
(5, 'Mohamed Azwer', 57, 'mohatheeb64@gmail.com', '94774198440', '', '', NULL, '2026-01-08 13:11:52'),
(6, 'M.A.M.Naizer', 77, 'hala.nazleen@gmail', '94768489163', '', '148/4 illangamwatta gampola', NULL, '2026-01-14 05:29:27'),
(7, 'Roshana mashoor', 78, 'roshanazmy1979@gmail.com', '94778401550', '', '45/A kadugannawa road gampola', NULL, '2026-01-14 06:30:51'),
(8, 'Fathima shabrina fowzy', 81, 'fathimasabrina72@gmail.com', '94777152045', '', '38B gampolawela road gampola', NULL, '2026-01-17 07:49:11'),
(9, 'A.c.m.Ajmal', 85, 'Acmajmal@gmail.com', '94773071788', '', 'NO,226/d dellange gelioya', NULL, '2026-01-19 03:20:25'),
(10, 'M.S.M.Ziyard', 87, 'queenfazee7789@gmail.com', '94775247751', '', 'no,159/21 kandy road gampola', NULL, '2026-01-19 05:55:12'),
(11, 'Mohamed Shafraz', 89, 'mshafraz62@gmail.com', '94721555092', '', 'No,1/14V,Dewaraja mawaththa,kahatapitiya gampola', NULL, '2026-01-19 06:33:36'),
(12, 'Mohamed Kayam', 91, 'kayammohamed9@gmail.com', '94772206063', '', 'A15,mariyawatta gampola', NULL, '2026-01-19 06:39:57'),
(13, 'Fazal Mohamed', 93, 'comfadlabhulfathah@gmail.com', '94766131298', '', 'No,240 21/A,kandy road gampola', NULL, '2026-01-19 06:48:13'),
(14, 'shiyana anees', 95, 'rukaiyahanees@gmail.com', '94741226692', '', 'Bebila,kahatapittiya,gampola', NULL, '2026-01-19 07:04:10'),
(15, 'M.Mihlar Muhaideen', 97, 'shamimihlar@gmail.com', '94728559696', '', '1866/50/8Kandy Road,Gampola', NULL, '2026-01-19 07:12:11'),
(16, 'Mohammed Raseen', 99, 'raseen.naz@gmail.com', '94771825588', '', '31/A,Udambuwa Road,Kahatapittiya,Gampola', NULL, '2026-01-19 07:18:50'),
(17, 'Mohamed Irfan', 101, 'irfangampola8@gmail.com', '94777220747', '', '464/B2,Kalugamuwa,Gampola', NULL, '2026-01-19 07:27:16'),
(18, 'M.T.M.Rizvan', 103, 'amrahrizann72@gmail.com', '94776388359', '', 'No,78/1,illawathura gampola', NULL, '2026-01-19 07:38:20'),
(19, 'S.M.Faris', 104, 'asmathullahfaris890@gmail.com', '94779774908', '', 'NO 7/A ANDIYAKADAWATHTHA GAMPOLA', NULL, '2026-01-28 04:07:46'),
(20, 'Mohamed Rizwan', 105, 'rizwanaaqifmohammad@gmail.com', '940788882040', '', '37/A ANDIYAKADAWATTAE GAMPOLA', NULL, '2026-01-28 05:01:48'),
(21, 'mohamed iqbal', 108, 'mohamediqbql985723@gmail.com', '94758898100', '', '263/1/1 kahatapitiya gampola', NULL, '2026-01-28 05:26:40'),
(22, 'H.M.Irfan', 110, 'raziyarazik1985@gmail.com', '94777748212', '', '31/4 hill street gampola', NULL, '2026-01-28 05:38:17'),
(23, 'Nashath', 112, 'nashath2007@gmail.com', '94779779099', '', '510/1 kalugamuwa, gelioya', NULL, '2026-01-28 05:44:55'),
(24, 'M.M.M.FARZAN', 114, 'hamdhifarzan700@gmail.com', '94743103700', '', '422/5/A/1 KALUGAMUWA GELIOYA', NULL, '2026-01-28 07:38:00'),
(25, 'M.Rilwan', 116, 'mohamedrilwan040@gmail.com', '94779160842', '', '340/38kahatapitiya,Gampola', NULL, '2026-01-28 07:45:03'),
(26, 'M.M.Mumthaz begum', 118, 'bmumthaj5353@gmail.com', '94753103112', '', '', NULL, '2026-02-01 05:37:05'),
(27, 'Mohammed Kayam', 120, 'kayammohomed9@gmail.com', '94772206063', '', 'A/15 Mariyawatte Gampola', NULL, '2026-02-01 05:43:55'),
(28, 'Mohamed Junaideen Fathima Rizmiya', 122, 'Fahma853@gmail.com', '94761010477', '', '281/B2, Ihalawela\r\nNaranvita\r\nGampola', NULL, '2026-02-01 06:20:59'),
(29, 'Mohammed Munawwar', 125, 'mhmdahnaaf123@gmail.com', '94776054886', '', '57/6 Daskara Muruthagahamula', NULL, '2026-02-01 06:29:21'),
(30, 'M.S.F Shafrana', 132, 'AaqibEhsan1987@gmail.com', '94743033093', '', '108/A/1 ketakumbura leemagahakotuwa', NULL, '2026-02-01 07:17:41'),
(31, 'Imran Hussain', 133, 'naseerafathima56@gmail.com', '94774484115', '', '273,Mosque Road\r\nDellanga', NULL, '2026-02-01 07:19:00'),
(32, 'Mohamed Rafeek', 139, 'mohamedarkam19@gmail.com', '94777538046', '', '25/D/2 DASKARA MURUTHAGAHAMULLA', NULL, '2026-02-07 06:36:41'),
(33, 'Mohammed irshad', 0, 'irshadimasha@gmail.com', '0777329670', 'Business', '340/23 kandy road gampola', '$2y$10$FnkfpMohr84zhMSZztTYUedIn68clskl13EPpc2BdGbzhdJqv/2V2', '2026-05-20 05:55:46');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT 'male',
  `joining_grade` varchar(50) NOT NULL,
  `medium` varchar(50) DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `parent_phone` varchar(50) DEFAULT NULL,
  `previous_school` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('new','checked') DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `full_name`, `dob`, `gender`, `joining_grade`, `medium`, `parent_name`, `parent_email`, `parent_phone`, `previous_school`, `address`, `remarks`, `status`, `created_at`) VALUES
(7, 'Aaqib Ehsan', '2010-12-04', 'male', '11', '0', 'M.S.F Shafrana', 'AaqibEhsan1987@gmail.com', '0743033093', 'Evergreen academy', '108/A/1 ketakumbura leemagahakotuwa', 'Joining the SERENDiB mid school', 'checked', '2025-11-20 03:49:54'),
(8, 'Mohamed Munawwar Mohamed Shadhir', '2010-03-29', 'male', '11', '0', 'Mohammed Munawwar', 'mhmdahnaaf123@gmail.com', '0776054886', 'Benhill College Gelioya', '57/6 Daskara Muruthagahamula', '', 'checked', '2025-11-21 08:11:16'),
(9, 'YAHYA', '2011-01-17', 'male', '11', '0', 'MOHAMMED HUSSAIN', '', '0779270570', 'BENHIL COLLEGE GELIOYA', '486/1/1 KALUGAMUWA GELIOYA', '', 'checked', '2025-11-23 09:36:55'),
(10, 'Mohamed Nawshard fathima Zuha', '2010-03-22', 'female', '11', '0', 'MOHAMED JUNAIDEEN FATHIMA RIZMIYA', '', '0761010477', 'Benhill college', '281/B2, Ihalawela\r\nNaranvita\r\nGampola', '', 'checked', '2025-11-23 12:05:09'),
(11, 'Mohammed Kayam Hikma', '2011-01-18', 'female', '11', '0', 'Mohammed Kayam', 'kayammohomed9@gmail.com', '0772206063', 'Benhil college Gampola', 'A/15 Mariyawatte Gampola', '', 'checked', '2025-11-23 12:46:26'),
(12, 'Mohammed Kayam Nuha', '2013-09-24', 'female', '8', '0', 'Mohammed Kayam', 'kayammohomed9@gmail.com', '0772206063', 'Benhil college Gampola', 'A/15 Mariyawatte Gampola', '', 'checked', '2025-11-23 12:48:21'),
(13, 'Mohammed aaqif', '2011-03-13', 'male', '9', '0', 'Mohammed Rizwan', 'rizwanaaqifmohammad@gmail.com', '0787486337', 'Gampola international school', '37/a andiyakadawatte gampola', '', 'checked', '2025-11-23 12:55:14'),
(16, 'Shara Nashath', '2011-03-15', 'male', '10', '0', 'Nashath', 'nashath2007@gmail.com', '0779779099', 'Benhill college gampola', '510/1 kalugamuwa, gelioya', '', 'checked', '2025-11-26 07:14:24'),
(17, 'M.Z.F SHADHAF', '2013-07-31', 'female', '8', '0', 'Mohamed sameen Mohamed ziyaad', 'queenfazee7789@gmail.com', '0775247751', 'G.Z.C', '159/21 Kandy road gampola', '', 'checked', '2025-12-10 09:05:30'),
(18, 'Mohamed Rizan Hajarah', '2012-11-17', 'female', '9', '0', 'M T M Rizan', 'amrahrizann72@gmail.com', '0776388359', 'Benhill College', '78/1, Illawathura, Gampola', '', 'checked', '2025-12-15 06:03:10'),
(19, 'M.R.M.Raqib', '2014-11-20', 'male', '7', '0', 'P.Rinooza', '', '0771154321', '', '178/14 Kandy Road gampola', '', 'checked', '2025-12-17 13:25:00'),
(20, 'anees mohamad yusuf', '2013-09-11', 'male', '8', '0', 'Shiyana Anees', 'rukaiyahanees@gmail.com', '0741226692', '.', 'Bebila, Kahatapitiya,gampola', '.', 'checked', '2025-12-18 16:03:20'),
(21, 'Mohammed Suhaan', '2013-03-12', 'male', '8', '0', 'Mohammed Razeen', 'razeen.naz@gmail.com', '0771825588', 'Hill Country International School Madawela', '31/A,Unambuwa Road, Kahatapitiya,Gampola', '', 'checked', '2025-12-20 17:17:52'),
(22, 'I.H.A.KABEER', '2025-10-15', 'male', '11', '0', 'Imran Hussain', 'naseerafathima56@gmail.com', '0774484115', 'Evergreen International School', '273,Mosque Road \r\nDellanga', '', 'checked', '2025-12-22 10:02:29'),
(26, 'Umar Shaheem  Irfan', '2011-04-06', 'male', '10', 'English', 'M. L. M. Irfan', 'irfangampola8@gmail.com', '0777220747', 'Evergreen international school', '464/B/2, Kalugamuwa  Gelioya', '', 'checked', '2025-12-27 06:48:07'),
(27, 'Imaan Ahmed irfan', '2013-11-30', 'male', '8', 'English', 'M.L.M. Irfam', 'irfangampola8@gmail.com', '0777220747', '', '464/B/2, Kalugamuwa, Gelioya', '', 'checked', '2025-12-27 06:51:22'),
(29, 'Oshadi lavanya hewasinha', '2009-03-13', 'female', '11', 'English', 'Nisansala kumudu kumari', '', '0776383030', 'Gampola international school', '507/11 ududeniya, gampola', '', 'checked', '2025-12-29 14:47:04'),
(30, 'Mohamed Jinna Reema', '2010-08-05', 'female', '11', 'English', 'M.M.Mumthaz begum', 'bmumthaj5353@gmail.com', '0753103112', 'Benhill College Gelioya', '493, Kalugamuwa Gelioya', '', 'checked', '2025-12-30 12:53:54'),
(31, 'Mohamed shafraz fathima hikma', '2011-01-10', 'female', '8', 'English', 'Mohamed shafraz', 'mshafraz62@gmail.com', '072055592', 'Benhill collage', '1/14 b devaraja mw, kahatapitiya gampola', '', 'new', '2025-12-30 14:11:14'),
(33, 'IBADH FOWZY', '2014-01-06', 'male', '7', 'English', 'FATHIMA SABRINA FOWZY', 'fathimasabrina72@gmail.com', '0777152045', 'GAMPOLA INTERNATIONAL', 'No 38 B, GAMPOLAWELA ROAD, GAMPOLA', '', 'checked', '2025-12-31 14:50:33'),
(34, 'Shafran Irshad', '2012-01-09', 'male', '10', 'English', 'Fathima Farhana', 'farhanairshad680@gmail.com', '0773287511', 'Benhill college Gampola', 'No 133 new elpitiya gelioya', '', 'checked', '2026-01-01 13:22:22'),
(35, 'Abdul haleem shafin nadhvi', '2012-02-03', 'male', '8', 'English', 'Abdul haleem (fazal)', 'fazalfazalfa4@gmail.com', '0776741717', 'GIS', '340/23 kandy rd kahatapitiya gampola', '', 'checked', '2026-01-02 04:51:19'),
(44, 'Mohamed Irfan shaima', '2013-08-13', 'female', '8', 'English', 'H.M.Irfan', 'raziyarazik1985@gmail.com', '0777748212', '', '31/4 hill street gampola\r\n36/1 hill street gampola', '', 'checked', '2026-01-02 15:27:08'),
(45, 'Mohamed Irfan Amna', '2011-11-15', 'female', '10', 'English', 'H.M. Irfan', 'raziyarazik1985@gmail.com', '0778495595', '', '31/4 hill street gampola\r\n36/1 hill street gampola', '', 'checked', '2026-01-02 15:30:15'),
(46, 'Muadh ahamed', '2012-01-03', 'male', '10', 'English', 'Mr Mohammed riyadh', '', '0778597874', 'Gampola international school', '28 andiyakadawatte gampola', 'Yess', 'checked', '2026-01-03 05:57:49'),
(47, 'M. Mishal', '2013-02-27', 'male', '8', 'English', 'M. Mihlar mohideen', 'shamimihlar@gmail.com', '0728559696', 'G. I. S', '1866/50/8 kandy road gampola', '', 'checked', '2026-01-03 07:10:58'),
(48, 'Yoonus Nazmy', '2016-07-22', 'male', '6', 'English', 'Roshana Mashoor', 'roshanazmy1979@gmail.com', '0778401550', 'GIS', '45/A Kadugannawa Road, Gampola', '', 'checked', '2026-01-04 04:41:02'),
(49, 'Mohamed infaz mohamed misbullah', '2011-01-28', 'male', '8', 'English', 'Fathima rushka', 'mshafraz62@gmail.com', '0757893740', 'Alexor international collage', '177/c ilangawatta kahatapitiya gampola', '', 'checked', '2026-01-04 15:41:20'),
(50, 'FAZAL MUHAMMAD RAFAH', '2013-02-15', 'female', '8', 'Tamil', 'FAZAL MUHAMMAD', 'www.comfadlabdulfathah@gmail.com', '0773146205', 'GAMPOLA ZAHIRA COLLEGE', '240 21/A KANDY ROAD GAMPOLA', '', 'checked', '2026-01-08 09:08:00'),
(53, 'Akmal Rila Shariff', '2010-10-18', 'male', '11', 'English', 'Farsana', 'musicgamer96ab@gmail.com', '0765631714', '', 'Gelioya, Muruthagahamulla Angalathenna 342-B', 'Interested', 'checked', '2026-01-09 19:19:56'),
(55, 'Mohammed aaqif', '2011-03-13', 'male', '10', 'English', 'Mohammed rizwan', 'rizwanaaqifmohammad@gmail.com', '0788882040', '', '37/a andiyakadawatte gampola', '', 'checked', '2026-01-10 13:33:45'),
(56, 'M.N.Sabith', '2016-01-29', 'male', '6', 'English', 'M.A.M .Naizar', 'hala.nazleen@gmail.com', '0768489163', 'Benhill collage', '148/4 illangawatha gampola', '-', 'checked', '2026-01-11 10:28:44'),
(58, 'Sheyma Rilwan', '2011-03-14', 'female', '10', 'English', 'M.Rilwan', 'mohamedrilwan040@gmail.com', '0779160842', '', '340/38kahatapitiya,Gampola', '', 'checked', '2026-01-28 07:00:27'),
(59, 'Izma Rilwan', '2013-04-29', 'female', '8', 'English', 'Rilwan', 'mohamedrilwan040@gamil.com', '0779160842', '', '340/38Kahatapitiya,Gampola', '', 'checked', '2026-01-28 07:11:08'),
(60, 'Sharaf Fathima Umaira', '2010-12-18', 'female', '11', 'English', 'Mohamed Sharaf', '', '0768998409', 'benhill collage', '186/2/1 i kandy road gampola', '', 'new', '2026-02-23 02:21:49'),
(61, 'Mohamed Mubarak', '2009-02-24', 'male', '11', 'English', 'Fathima Riza', 'fathimariza1973@icloud.com', '0777286763', 'Benhill boys school', '306/8/4/9, Weegulawatta, Gampola', 'Mohmed Mubarak expecting to join commerce A/L', 'checked', '2026-03-03 12:00:33'),
(70, 'Amani Arshad', '2009-07-14', 'female', '2028_physical_science', 'English', 'A P Marhama', 'akbardeenmarhama@gmail.com', '0775023806', 'Badhuriya College Mawanella', 'D 92/2, Madulbowa, Hemmatagama', '', 'checked', '2026-03-12 17:10:12'),
(71, 'Abdullah M. Riyas', '2008-04-01', 'male', '2028_physical_science', 'English', 'Mohamed Riyas', 'abdullahriyas8@gmail.com', '0754092845', 'OVINRO COLLEGE', '110,Horana Road, Eluwila,Panadura', 'Need the Accommodation facilities', 'checked', '2026-03-26 13:17:34'),
(72, 'Abdullah M. Riyas', '2008-04-01', 'male', '2028_physical_science', 'English', 'Mohamed Riyas', 'abdullahriyas8@gmail.com', '0754092845', 'OVINRO COLLEGE', '110,Horana Road, Eluwila,Panadura', 'Need the Accommodation facilities', 'checked', '2026-03-26 13:17:38'),
(73, 'OMER SHAREEF KADHEEJA', '2011-04-28', 'female', '9', 'English', 'NAGOOR PICHCHAI MOHAMED RAZICK INUL YAKEENA', 'YAKEENA2011@GMAIL.COM', '0787805154', 'Pearls Of Paradise', 'NO 172/D4 ILANKAWATHA KAHATAPITIYA, GAMPOLA', '', 'checked', '2026-04-25 00:25:00'),
(74, 'Yoonus Nazmy', '2016-07-22', 'male', '6', 'English', 'Roshana Mashoor', 'roshanazmy1979@gmail.com', '0778401550', 'Gampola International School', '45/A Kadugannawa Road Gampola', '', 'checked', '2026-05-16 06:37:36'),
(75, 'Yoonus Nazmy', '2016-07-22', 'male', '6', 'English', 'Roshana Mashoor', 'roshanazmy1979@gmail.com', '0778401550', 'Gampola International School', '45/A Kadugannawa Road Gampola', '', 'new', '2026-05-16 06:37:38'),
(76, 'Yoonus Nazmy', '2016-07-22', 'male', '6', 'English', 'Roshana Mashoor', 'roshanazmy1979@gmail.com', '0778401550', 'Gampola International School', '45/A Kadugannawa Road Gampola', '', 'new', '2026-05-16 06:37:41'),
(77, 'Yoonus Nazmy', '2016-07-22', 'male', '6', 'English', 'Roshana Mashoor', 'roshanazmy1979@gmail.com', '0778401550', 'Gampola International School', '45/A Kadugannawa Road Gampola', '', 'new', '2026-05-16 06:37:42'),
(78, 'Yoonus Nazmy', '2016-07-22', 'male', '6', 'English', 'Roshana Mashoor', 'roshanazmy1979@gmail.com', '0778401550', 'Gampola International School', '45/A Kadugannawa Road Gampola', '', 'new', '2026-05-16 06:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'admin'),
(2, 'student', 'student'),
(3, 'teacher', 'teacher'),
(4, 'parent', 'parent');

-- --------------------------------------------------------

--
-- Table structure for table `school_settings`
--

CREATE TABLE `school_settings` (
  `id` int(11) NOT NULL,
  `academic_year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_settings`
--

INSERT INTO `school_settings` (`id`, `academic_year`) VALUES
(1, '2025 / 2026');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name`, `class_id`) VALUES
(1, 'A', 1),
(2, 'A', 2),
(3, 'A', 3),
(4, 'A', 4),
(5, 'A', 5),
(6, 'A', 6),
(7, 'PS', 7),
(8, 'BS', 7),
(9, 'ARTS', 7),
(10, 'COM', 7),
(11, 'PS', 8),
(13, 'BS', 8),
(14, 'ARTS', 8);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `school_name` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smart_announcements`
--

CREATE TABLE `smart_announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `target_type` enum('ALL','CLASS','SECTION') NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `sound_file` varchar(255) DEFAULT NULL,
  `priority` enum('normal','urgent') DEFAULT 'normal',
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smart_announcements`
--

INSERT INTO `smart_announcements` (`id`, `title`, `message`, `target_type`, `class_id`, `section_id`, `sound_file`, `priority`, `expires_at`, `created_at`) VALUES
(12, 'Announcement for all the teachers', 'Staff meeting at 1.30pm', 'ALL', NULL, NULL, 'audio_69726c1821afb7.25664917_bell.mp3', 'normal', '2026-01-31 13:30:00', '2026-01-31 07:15:45'),
(13, 'Special Meeting for all Students', 'Please be at the auditorium at 12.30 pm', 'ALL', NULL, NULL, 'audio_69726c1821afb7.25664917_bell.mp3', 'urgent', '2026-02-12 12:30:00', '2026-02-12 03:45:20'),
(14, 'aw', 'aw', 'ALL', NULL, NULL, 'audio_69a406e17093c3.67899313_bell.shtml', 'normal', '0000-00-00 00:00:00', '2026-03-01 09:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `smart_audio_events`
--

CREATE TABLE `smart_audio_events` (
  `id` int(11) NOT NULL,
  `event_type` varchar(50) DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smart_audio_events`
--

INSERT INTO `smart_audio_events` (`id`, `event_type`, `audio_file`, `class_id`, `created_at`) VALUES
(10, 'bell', 'audio_69726c1821afb7.25664917_bell.mp3', NULL, '2026-01-22 18:27:36'),
(11, 'bell', 'audio_69a40354d05674.19909460_bell.php', NULL, '2026-03-01 09:13:57'),
(12, 'bell', 'audio_69a406e17093c3.67899313_bell.shtml', NULL, '2026-03-01 09:29:07'),
(16, 'music', 'audio_69a407af2fa2e9.87939572_music.php', NULL, '2026-03-01 09:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admission_no` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `medium` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `status` enum('active','inactive','left') DEFAULT 'active',
  `isSchool` tinyint(1) NOT NULL DEFAULT 0,
  `first_language` varchar(50) DEFAULT NULL,
  `second_language` varchar(50) DEFAULT NULL,
  `subject_group` varchar(10) DEFAULT NULL,
  `group_subject_id` int(11) DEFAULT NULL,
  `g1_subject_id` int(11) DEFAULT NULL,
  `g2_subject_id` int(11) DEFAULT NULL,
  `g3_subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `admission_no`, `first_name`, `last_name`, `gender`, `dob`, `class_id`, `section_id`, `medium`, `address`, `parent_id`, `photo`, `admission_date`, `status`, `isSchool`, `first_language`, `second_language`, `subject_group`, `group_subject_id`, `g1_subject_id`, `g2_subject_id`, `g3_subject_id`) VALUES
(1, 2, 'S1001', 'AMEENA', 'ANWARSADADH', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 3, 'S1002', 'HAFSA', 'IRFAN', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 4, 'S1003', 'HIQMA', 'AYYOB', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2024-01-06', 'inactive', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 5, 'S1004', 'HIQMA', 'ASHRAFKHAN', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, 'S1005', 'AARA', 'FAREED', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 7, 'S1006', 'M.A.MOHAMED', 'ADEEB', 'male', '0000-00-00', 8, 11, 'English', '', 5, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 8, 'S1007', 'I.A', 'AZEEF', 'male', '0000-00-00', 8, 11, 'English', '', NULL, 'student_6962072df08990.82142141.jpg', '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 9, 'S1008', 'M.A', 'SHAHID', 'male', '0000-00-00', 8, 11, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 10, 'S1009', 'FATHIMA', 'SHADAH', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 11, 'S1010', 'SHAMEEHA', 'SAMAD', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2026-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 12, 'S1011', 'M.MOHAMED', 'YASAR', 'male', '0000-00-00', 8, 11, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 13, 'S1012', 'Sara', 'Siraj', 'female', '0000-00-00', 8, 11, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 14, 'S1013', 'Fathima', 'Rimasha', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2024-01-06', 'left', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 15, 'S1014', 'Aysha', 'Shahani', 'female', '0000-00-00', 8, 13, 'English', '', NULL, NULL, '2025-01-02', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 16, 'S1015', 'Mohammed', 'Ammar', 'male', '0000-00-00', 7, 7, 'English', '', NULL, NULL, '2025-01-06', 'inactive', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 17, 'S1016', 'M.F', 'Arkam', 'male', '0000-00-00', 7, 7, 'English', '', NULL, 'student_6962078dee6c00.47562031.jpg', '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 18, 'S1017', 'Zaina', 'Shaiwaz', 'female', '0000-00-00', 7, 8, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 19, 'S1018', 'Amra', 'Rafeeq', 'female', '0000-00-00', 7, 8, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 20, 'S1019', 'Fathima', 'Zackiya', 'female', '0000-00-00', 7, 8, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 21, 'S1020', 'Sadha', 'Ameen', 'female', '0000-00-00', 7, 8, 'English', '', NULL, NULL, '2025-01-06', 'inactive', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 22, 'S1021', 'Fathima', 'Shaheema', 'female', '0000-00-00', 7, 8, 'English', '', NULL, NULL, '2025-01-06', 'inactive', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 23, 'S1022', 'A.I.', 'Shafa', 'female', '0000-00-00', 7, 8, 'English', '', NULL, NULL, '2025-01-06', 'inactive', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 24, 'S1023', 'Fathima', 'Shazra', 'female', '0000-00-00', 7, 8, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 25, 'S1024', 'Mohammed', 'Luqman', 'male', '0000-00-00', 7, 10, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 26, 'S1025', 'Fathima', 'Noora', 'female', '0000-00-00', 7, 10, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 27, 'S1026', 'Mohammed', 'Arafath', 'male', '0000-00-00', 7, 10, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 28, 'S1027', 'Dev', 'Rukshan', 'male', '0000-00-00', 7, 10, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 29, 'S1028', 'Mohammed', 'Fuhaim', 'male', '0000-00-00', 7, 10, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 31, 'S1029', 'Aysha', 'Shahani', 'female', '0000-00-00', 7, 9, 'English', '', NULL, NULL, '2025-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 32, 'S1030', 'Fathima', 'Hafsa', 'female', '0000-00-00', 7, 9, 'English', '', NULL, NULL, '2025-01-06', 'left', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 33, 'S1031', 'Fathima', 'Salma', 'female', '0000-00-00', 8, 14, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 34, 'S1032', 'Fathima', 'Ashifa', 'female', '0000-00-00', 8, 14, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 35, 'S1033', 'Fathima', 'Ashra', 'female', '0000-00-00', 8, 14, 'English', '', NULL, NULL, '2024-01-06', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 58, 'S1037', 'M I M', 'Muadh', 'male', '2010-06-26', 5, 5, 'English', 'NO 263/1/1 KAHATAPITIYA GAMPOLA', 21, 'student_6992a55818b1b3.06688517.jpeg', '2026-01-10', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 12, 14, 23),
(38, 59, 'S1038', 'Mohammed', 'Aaqif', 'male', '2011-03-13', 5, 5, 'English', '37/A ANDIYAKADAWATTE GAMPOLA', 20, 'student_699406e3b99894.76208551.jpeg', '2026-01-10', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 12, 14, 23),
(39, 60, 'S1039', 'M F', 'Abdurrahman', 'male', '2011-04-08', 5, 5, 'English', 'NO 7/ A ANDIYAKADAWATHTHA GAMPOLA', 19, 'student_6992a526b8ba07.30873955.jpeg', '2026-01-10', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 12, 14, 23),
(40, 61, 'S1040', 'Fathima', 'Rizma', 'female', '2011-10-08', 5, 5, 'English', '', NULL, NULL, '2026-01-10', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 62, 'S1041', 'Fathima', 'Arsha', 'female', '2011-11-28', 5, 5, 'English', '', NULL, NULL, '2026-01-10', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 63, 'S1042', 'M R', 'Hamdha', 'female', '2011-04-11', 5, 5, 'English', '', NULL, NULL, '2026-01-10', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 64, 'S1043', 'Bilal', 'Inshaf', 'male', '2010-12-27', 6, 6, 'English', '', NULL, NULL, '2026-01-10', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 65, 'S1044', 'Shamry', 'Ahamed', 'male', '2010-03-24', 6, 6, 'English', '', NULL, 'student_69652d97e4a6a8.57047639.jpeg', '2026-01-10', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 66, 'S1045', 'Nishath', 'Nazmy', 'female', '2011-01-31', 6, 6, 'English', '', NULL, NULL, '2026-01-10', 'active', 0, 'Sinhala', 'Tamil', NULL, NULL, 24, 14, 23),
(46, 67, 'S1046', 'Hikma', 'Iqbal', 'female', '2010-02-04', 6, 6, 'English', '', NULL, NULL, '2026-01-10', 'active', 0, 'Tamil', 'Sinhala', NULL, NULL, 24, 14, 21),
(47, 76, 'S1047', 'Sabith', 'Naizar', 'male', '2016-01-29', 1, 1, 'English', '148/4,illangamwatta,Gampola', 6, 'student_6992a6407a85d1.76524174.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(48, 79, 'S1048', 'Yunoos', 'Nazmy', 'male', '2016-07-22', 1, 1, 'English', '45/A Kadugannawa road gampola', 7, 'student_699406beeb35a7.94153211.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(49, 80, 'S1049', 'Ibadh', 'Fowzy', 'male', '2014-01-06', 2, 2, 'English', 'No 38 B gampola wela road gampola', 8, 'student_6992a69931aca2.56120066.jpeg', '2026-01-01', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(50, 82, 'S1050', 'Nithaf', 'Razan', 'male', '2006-08-06', 8, 11, 'English', '', NULL, NULL, '2026-01-17', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 84, 'S1051', 'Abdhul Azeez', 'Ajmal', 'male', '2015-01-20', 2, 2, 'English', 'No,226/d dellange gelioya', 9, 'student_6992a7adea1b18.71860167.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(53, 88, 'S1052', 'Hikma', 'Shafraz', 'female', '2011-01-10', 4, 4, 'English', 'No,1/14V Dewaraja mawaththa,kahatatapitiya Gampola', 11, 'student_6992a79f356fb1.89889153.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(54, 90, 'S1054', 'Nuha', 'Kayam', 'female', '2013-09-24', 3, 3, 'English', 'No,A15 mariyawatta gampola', 12, 'student_6992a78a035267.66560139.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(55, 92, 'S1055', 'Rafah', 'Fazal', 'female', '2013-02-15', 3, 3, 'English', 'No,240 21/A,kandy road gampola', 13, 'student_6992a7700ecb06.08644579.jpeg', '2026-01-12', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 94, 'S1056', 'yusuf', 'aneez', 'male', '2013-09-11', 3, 3, 'English', 'bebila,kahatapittiya,gampola', 14, 'student_6992a74fc02ee5.21181539.jpeg', '2026-01-19', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 96, 'S1057', 'Mishal', 'Mihlar Muhaideen', 'male', '2013-02-27', 3, 3, 'English', '1866/50/8 Kandy Road,Gampola', 15, 'student_6992a7297f9bb1.41896522.jpeg', '2026-01-19', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(58, 98, 'S1058', 'Suhaan', 'Raseen', 'male', '2013-03-12', 3, 3, 'English', '31/A,Unambuwa Road,Kahatapittiya,Gampola', 16, 'student_6992a7103c5961.76103601.jpeg', '2026-01-19', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(59, 100, 'S1059', 'Imaan', 'Irfan', 'male', '2013-11-30', 3, 3, 'English', '464/B/2,Kalugamuwa,Gampola', 17, 'student_6992a5d55fcf41.96285357.jpeg', '2026-01-19', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(60, 102, 'S1060', 'Hajara', 'Rizvan', 'female', '2012-11-17', 4, 4, 'English', 'No,78/1,illawathura gampola', 18, NULL, '2026-01-12', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 106, 'S1061', 'Ahamed Muzain', 'Ajmal', 'male', '2011-10-01', 5, 5, 'English', '226/d dellange gelioya', 9, 'student_6992a50f1a6114.53985059.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, 12, 14, 23),
(62, 107, 'S1062', 'Umar Shaheem', 'Irfan', 'male', '2011-04-06', 5, 5, 'English', '464/B/2, Kalugamuwa Gelioya', 17, 'student_6992a4dfbcc744.63290875.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 12, 14, 23),
(64, 111, 'S1064', 'Shara', 'Nashath', 'female', '2011-03-15', 5, 5, 'English', '510/1 kalugamuwa, gelioya', 23, 'student_6992a4c6db2943.78703846.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 24, 20, 21),
(65, 113, 'S1065', 'Hajara', 'Farzan', 'female', '2011-12-13', 5, 5, 'English', '422/5/A/1', 24, 'student_6992a49da6b558.12469931.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 24, 14, 21),
(66, 115, 'S1066', 'Sheyma', 'Rilwan', 'female', '2011-03-14', 5, 5, 'English', '340/38kahatapitiya,Gampola', 25, 'student_6992a47f976793.81607422.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 24, 14, 21),
(67, 117, 'S1067', 'Reema', 'Mohamed Jinna', 'female', '2010-05-05', 6, 6, 'English', '493, Kalugamuwa Gelioya', 26, 'student_6992a46402dc01.98897020.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 24, 14, 21),
(68, 119, 'S1068', 'Hikma', 'Mohammed Kayam', 'female', '2011-12-01', 6, 6, 'English', '', 12, 'student_6992a449f2d4e5.96681494.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 24, 20, 21),
(69, 121, 'S1069', 'fathima Zuha', 'Mohamed Nawshard', 'female', '2010-03-22', 6, 6, 'English', '281/B2, Ihalawela\r\nNaranvita\r\nGampola', 28, 'student_6992a3afac7867.70816435.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 24, 14, 21),
(70, 123, 'S1070', 'Ahamed Mujthaba', 'Ajmal', 'male', '2010-03-04', 6, 6, 'English', '226/d dellange gelioya', 9, 'student_6992a396883eb9.82842649.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, 12, 14, 23),
(71, 124, 'S1071', 'Mohamed Shadhir', 'Mohamed Munawwar', 'male', '2010-03-29', 6, 6, 'English', '57/6 Daskara Muruthagahamula', 29, 'student_6992a367ba5544.45665207.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, 12, 14, 23),
(72, 126, 'S1072', 'A.Kabeer', 'Husain', 'male', '2010-10-15', 6, 6, 'English', '273,Mosque Road\r\nDellanga', 31, 'student_6992a34ab0c1f0.37235412.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, 12, 14, 23),
(73, 127, 'S1073', 'Aaqib', 'Ehsan', 'male', '2010-12-04', 6, 6, 'English', '108/A/1 ketakumbura leemagahakotuwa', NULL, 'student_6992a2eeb957f0.25308944.jpeg', '2026-01-12', 'active', 1, 'Sinhala', 'Sinhala', NULL, NULL, 12, 14, 21),
(74, 128, 'S1074', 'MJM', 'Hamdhan', 'male', '2010-06-17', 6, 6, 'English', '', NULL, NULL, '2026-02-01', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 129, 'S1075', 'MTA', 'Malik', 'male', '2010-02-26', 6, 6, 'English', '', NULL, NULL, '2026-02-01', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 130, 'S076', 'Yahya', 'Hussain', 'male', '2011-01-17', 6, 6, 'English', '486/1/1 KALUGAMUWA GELIOYA', NULL, 'student_6992a321c89b70.46888368.jpeg', '2026-01-12', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 24, 14, 21),
(77, 131, 'S1076', 'MI', 'Abdul kareem', 'male', '2010-06-17', 6, 6, 'English', '', NULL, NULL, '2026-02-01', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 134, 'S1078', 'Iyaadh', 'Ahamedh', 'male', '2010-11-19', 6, 6, 'English', '', NULL, 'student_69a3e28b586264.23918569.jpg', '2026-02-01', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 135, 'S1079', 'Shami', 'Shafrin', 'male', '2010-10-02', 6, 6, 'English', '', NULL, 'student_69a3e278a12b03.88209690.jpg', '2026-02-01', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 136, 'S1080', 'Arafath', 'Hafi', 'male', '2009-11-15', 6, 6, 'English', '', NULL, 'student_6992a5866ba4a1.83095124.jpeg', '2026-02-01', 'active', 1, 'Tamil', 'Tamil', NULL, NULL, 12, 14, 21),
(81, 138, 'S1081', 'Arkam', 'Rafeek', 'male', '2010-08-08', 5, 5, 'English', '25/D/2 DASKARA MURUTHAGAHAMULLA', 32, 'student_6992a2ff713152.70474225.jpeg', '2026-02-07', 'active', 1, 'Tamil', 'Tamil', NULL, NULL, 12, 20, 23),
(82, 140, 'S1082', 'Thahani', 'Rizmi', 'female', '2011-06-23', 5, 5, 'English', '', NULL, NULL, '2026-02-07', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 141, 'S1083', 'MR', 'Hamdhi', 'male', '2009-09-15', 5, 5, 'English', '', NULL, NULL, '2026-02-07', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 142, 'S1084', 'Hyman', 'Zamani', 'female', '2010-08-15', 5, 5, 'English', '', NULL, NULL, '2026-02-07', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 143, 'S1085', 'Raiza', 'Akbar', 'female', '2010-08-07', 5, 5, 'English', '', NULL, NULL, '2026-02-07', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 144, 'S1086', 'Nazrina', 'Naushad', 'female', '2009-08-08', 5, 5, 'English', '', NULL, NULL, '2026-02-07', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 146, 'S1087', 'Halaa', 'Naizer', 'female', '0000-00-00', 3, 3, 'English', '148/4,illangamwatta,Gampola', 6, 'student_6992a9d27988c7.63270667.jpeg', '2026-02-01', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(88, 147, 'S1088', 'Izma', 'Rilwan', 'female', '2013-04-29', 3, 3, 'English', '340/38Kahatapitiya,Gampola', 25, 'student_6992ab1bd6abb2.37252682.jpeg', '2026-02-01', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(89, 148, 'S1089', 'F Shadaf', 'Ziyard', 'female', '2013-07-31', 3, 3, 'English', '159/21 Kandy road gampola', 10, 'student_69f0d573ab4c79.05611518.jpg', '2026-02-16', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(92, 151, 'S1090', 'Bilal', 'Ahamed', 'male', '2026-03-09', 4, 4, 'English', '', NULL, NULL, '2026-03-09', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(93, 152, 'S1093', 'Yahya', 'Insaf', 'male', '2012-12-20', 4, 4, 'English', '59/2, Daskara, Muruthagahamula, Gelioya', NULL, NULL, '2026-03-09', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(94, 153, 'S1094', 'Fathima', 'farah', 'female', '0000-00-00', 4, 4, 'English', '', NULL, NULL, '2026-03-30', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 158, 'S1096', 'Ahnaf', 'Rizvin', 'male', '2012-08-20', 3, 3, 'English', '', NULL, NULL, '2026-04-25', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(97, 159, 'S1097', 'Imran', 'Mohomad', 'male', '2012-01-26', 4, 4, 'English', '', NULL, NULL, '2026-04-06', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 160, 'S1098', 'M.N Nabeel', 'AHAMED', 'male', '2011-06-19', 5, 5, 'English', '', NULL, NULL, '2026-05-13', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 161, 'S1099', 'Aahil', 'Rizwin', 'male', '2016-06-25', 1, 1, 'English', '1/35 w/3 Fathima garden Bothalapitiya Gampola', NULL, NULL, '2026-05-14', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(100, 162, 'S1100', 'Katheeja', 'Omershareef', 'female', '2011-04-28', 4, 4, 'English', '152/D,  Ilangawaththa, Kahatapitiya, Gampola', NULL, NULL, '2026-05-14', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(101, 163, 'S1101', 'Nabeel Ahamed', 'Nister', 'male', '2011-06-19', 5, 5, 'English', '', NULL, NULL, '2026-05-14', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 12, 14, 23),
(102, 164, 'S1102', 'Azeez', 'Fawaz', 'male', '2012-06-02', 4, 4, 'English', '22/19, Bothalapitya, Parathota Road, Gampola', NULL, NULL, '2026-05-14', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(103, 165, 'S1103', 'Imran', 'Inam', 'male', '2012-01-26', 4, 4, 'English', '219/1/5, Pahala kudamake, Gampola', NULL, NULL, '2026-05-14', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(104, 166, 'S1104', 'Hamidh', 'Ibrahim', 'male', '2012-01-19', 4, 4, 'English', '1/10, Fathima gardens, Bothalapitiya, Gampola', NULL, NULL, '2026-05-14', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(105, 167, 'S1105', 'Iman', 'Inshaf', 'male', '2012-03-24', 4, 4, 'English', '55, Gampola', NULL, NULL, '2026-05-15', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(106, 169, 'S1106', 'Imasha', 'Irshad', 'female', '2009-11-02', 6, 6, 'English', '340\\23 kandy road gampola', 33, NULL, '2026-05-20', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, 12, 14, 21),
(107, 170, 'S1107', 'Sarah', 'Fahad', 'female', '2014-02-21', 2, 2, 'English', '14/12 bebila road kahatapitiya gampola', NULL, NULL, '2026-05-01', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(108, 171, 'S1108', 'Ishfaq', 'Irshad', 'male', '2012-01-01', 4, 4, 'English', '320/23/2, Kandy Road, Gampola', 33, NULL, '2026-05-21', 'active', 1, 'Tamil', 'Sinhala', NULL, NULL, NULL, NULL, NULL),
(109, 172, 'S1109', 'Abdul Malik', 'Ishak', 'male', '2009-02-04', 6, 6, 'English', '', NULL, NULL, '2026-05-22', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 173, 'S1110', 'Imaad', 'Sufiyan', 'male', '2010-03-10', 5, 5, 'English', '', NULL, NULL, '2026-05-23', 'active', 1, 'Tamil', 'Tamil', NULL, NULL, 12, 14, 23),
(111, 174, 'S1111', 'Hafsa', 'Musthaq', 'female', '2011-12-08', 5, 5, 'English', '', NULL, NULL, '2026-05-23', 'active', 0, 'Sinhala', 'Sinhala', NULL, NULL, 24, 15, 21),
(112, 175, 'S1112', 'Shafin', 'Nadvi', 'male', '2012-02-03', 3, 3, 'English', '340/24, dewaraja mawatha Gampola', NULL, NULL, '2026-05-22', 'active', 0, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(113, 176, 'S1113', 'Maryam', 'Sharifdeen', 'female', '2013-01-21', 4, 4, 'English', '4/2, Parathota Road, Bothalapitiya, Gampola', NULL, NULL, '2026-06-01', 'active', 1, 'Sinhala', 'Tamil', NULL, NULL, NULL, NULL, NULL),
(114, 177, 'S1114', 'Hafsa', 'Fawas', 'female', '2010-06-02', 6, 6, 'English', '', NULL, NULL, '2026-06-08', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 178, 'S1115', 'Rukaiya', 'Munawfer', 'female', '2010-08-22', 6, 6, 'English', '', NULL, NULL, '2026-06-08', 'active', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE `student_fees` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `term` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `status` enum('Pending','Paid','Partial') DEFAULT 'Pending',
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_fees`
--

INSERT INTO `student_fees` (`id`, `student_id`, `fee_type_id`, `term`, `amount`, `status`, `due_date`) VALUES
(34, 47, 5, 'February', 7000.00, 'Paid', '2026-02-20'),
(35, 48, 5, 'February', 7000.00, 'Paid', '2026-02-20'),
(36, 49, 5, 'February', 7000.00, 'Paid', '2026-02-20'),
(37, 51, 5, 'February', 7000.00, 'Paid', '2026-02-20'),
(38, 53, 6, 'February', 8000.00, 'Paid', '2026-02-20'),
(39, 54, 6, 'February', 8000.00, 'Paid', '2026-02-20'),
(40, 55, 6, 'February', 8000.00, 'Paid', '2026-02-20'),
(41, 56, 6, 'February', 8000.00, 'Paid', '2026-02-20'),
(42, 57, 6, 'February', 8000.00, 'Paid', '2026-02-20'),
(43, 58, 6, 'February', 8000.00, 'Paid', '2026-02-20'),
(44, 59, 6, 'February', 8000.00, 'Paid', '2026-02-20'),
(45, 60, 6, 'February', 8000.00, 'Pending', '2026-02-20'),
(63, 61, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(64, 81, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(65, 65, 7, 'February', 9000.00, 'Pending', '2026-02-20'),
(66, 39, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(67, 37, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(68, 38, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(69, 64, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(70, 66, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(71, 62, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(72, 72, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(73, 73, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(74, 70, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(75, 80, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(76, 69, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(77, 68, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(78, 71, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(79, 67, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(80, 76, 7, 'February', 9000.00, 'Paid', '2026-02-20'),
(82, 87, 6, '', 8000.00, 'Paid', '2026-02-25'),
(84, 47, 5, '', 7000.00, 'Paid', '2026-04-30'),
(85, 48, 5, '', 7000.00, 'Paid', '2026-04-30'),
(86, 49, 5, '', 7000.00, 'Paid', '2026-04-30'),
(87, 51, 5, '', 7000.00, 'Paid', '2026-04-30'),
(88, 53, 6, '', 8000.00, 'Partial', '2026-04-30'),
(89, 54, 6, '', 8000.00, 'Paid', '2026-04-30'),
(90, 55, 6, '', 8000.00, 'Paid', '2026-04-30'),
(91, 56, 6, '', 8000.00, 'Pending', '2026-04-30'),
(92, 57, 6, '', 8000.00, 'Paid', '2026-04-30'),
(93, 58, 6, '', 8000.00, 'Paid', '2026-04-30'),
(94, 59, 6, '', 8000.00, 'Paid', '2026-04-30'),
(95, 88, 6, '', 8000.00, 'Paid', '2026-04-30'),
(96, 89, 6, '', 8000.00, 'Pending', '2026-04-30'),
(97, 60, 6, '', 8000.00, 'Pending', '2026-04-30'),
(98, 92, 6, '', 8000.00, 'Pending', '2026-04-30'),
(99, 93, 6, '', 8000.00, 'Pending', '2026-04-30'),
(100, 94, 6, '', 8000.00, 'Pending', '2026-04-30'),
(101, 37, 7, '', 9000.00, 'Paid', '2026-04-30'),
(102, 38, 7, '', 9000.00, 'Pending', '2026-04-30'),
(103, 39, 7, '', 9000.00, 'Paid', '2026-04-30'),
(104, 40, 7, '', 9000.00, 'Pending', '2026-04-30'),
(105, 41, 7, '', 9000.00, 'Pending', '2026-04-30'),
(106, 42, 7, '', 9000.00, 'Pending', '2026-04-30'),
(107, 61, 7, '', 9000.00, 'Paid', '2026-04-30'),
(108, 62, 7, '', 9000.00, 'Paid', '2026-04-30'),
(109, 64, 7, '', 9000.00, 'Paid', '2026-04-30'),
(110, 65, 7, '', 9000.00, 'Pending', '2026-04-30'),
(111, 66, 7, '', 9000.00, 'Paid', '2026-04-30'),
(112, 81, 7, '', 9000.00, 'Paid', '2026-04-30'),
(113, 82, 7, '', 9000.00, 'Pending', '2026-04-30'),
(114, 83, 7, '', 9000.00, 'Pending', '2026-04-30'),
(115, 84, 7, '', 9000.00, 'Pending', '2026-04-30'),
(116, 85, 7, '', 9000.00, 'Pending', '2026-04-30'),
(117, 86, 7, '', 9000.00, 'Pending', '2026-04-30'),
(118, 43, 7, '', 9000.00, 'Pending', '2026-04-30'),
(119, 44, 7, '', 9000.00, 'Pending', '2026-04-30'),
(120, 45, 7, '', 9000.00, 'Pending', '2026-04-30'),
(121, 46, 7, '', 9000.00, 'Pending', '2026-04-30'),
(122, 67, 7, '', 9000.00, 'Paid', '2026-04-30'),
(123, 68, 7, '', 9000.00, 'Pending', '2026-04-30'),
(124, 69, 7, '', 9000.00, 'Paid', '2026-04-30'),
(125, 70, 7, '', 9000.00, 'Paid', '2026-04-30'),
(126, 71, 7, '', 9000.00, 'Paid', '2026-04-30'),
(127, 72, 7, '', 9000.00, 'Paid', '2026-04-30'),
(128, 73, 7, '', 9000.00, 'Paid', '2026-04-30'),
(129, 74, 7, '', 9000.00, 'Pending', '2026-04-30'),
(130, 75, 7, '', 9000.00, 'Pending', '2026-04-30'),
(131, 76, 7, '', 9000.00, 'Paid', '2026-04-30'),
(132, 77, 7, '', 9000.00, 'Pending', '2026-04-30'),
(133, 78, 7, '', 9000.00, 'Pending', '2026-04-30'),
(134, 79, 7, '', 9000.00, 'Pending', '2026-04-30'),
(135, 80, 7, '', 9000.00, 'Pending', '2026-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `student_of_the_week`
--

CREATE TABLE `student_of_the_week` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `week_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `points_awarded` int(11) DEFAULT 0,
  `awarded_by` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_of_the_week`
--

INSERT INTO `student_of_the_week` (`id`, `student_id`, `title`, `description`, `image`, `week_date`, `is_active`, `created_at`, `points_awarded`, `awarded_by`, `status`) VALUES
(4, 37, 'Student of the Week', 'Congratulations to our Student of the Week for demonstrating outstanding dedication, responsibility, and commitment to learning. Your hard work and positive attitude continue to inspire your fellow students.\r\n\r\nKeep shining and making your House proud! 👏🏆', 'sow_1780906408_6a2679a80fc7f.png', '2026-06-08', 1, '2026-06-08 08:13:28', 10, 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_code` varchar(50) DEFAULT NULL,
  `is_basket` tinyint(1) DEFAULT 0,
  `subject_type` varchar(50) DEFAULT NULL,
  `basket_group` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`, `is_basket`, `subject_type`, `basket_group`) VALUES
(1, 'Maths', '001', 0, NULL, NULL),
(2, 'Science', '002', 0, NULL, NULL),
(3, 'English', '003', 0, NULL, NULL),
(4, 'Tamil', '004', 0, 'First Language', NULL),
(5, 'Islam', '005', 0, NULL, NULL),
(6, 'History', '006', 0, NULL, NULL),
(7, 'Civics', '007', 0, NULL, NULL),
(8, 'Geography', '008', 0, NULL, NULL),
(9, 'Sinhala', '009', 0, 'First Language', NULL),
(10, 'ICT', '010', 0, 'Normal', NULL),
(11, 'PTS', '011', 0, NULL, NULL),
(12, 'Commerce', '012', 0, 'Group Subject', 'G1'),
(13, 'Art', '013', 0, NULL, NULL),
(14, 'English lit', '014', 0, 'Group Subject', 'G2'),
(15, 'Tamil lit', '015', 0, 'Group Subject', 'G2'),
(17, 'Tamil', '016', 0, 'Second Language', NULL),
(18, 'Combained maths', '017', 0, NULL, NULL),
(19, 'Sinhala', '018', 0, 'Second Language', NULL),
(20, 'Art', '019', 0, 'Group Subject', 'G2'),
(21, 'Health', '020', 0, 'Group Subject', 'G3'),
(22, 'Health', '021', 0, NULL, NULL),
(23, 'ICT', '022', 0, 'Group Subject', 'G3'),
(24, 'Sinhala', '023', 0, 'Group Subject', 'G1'),
(25, 'Tamil', '024', 0, 'Group Subject', 'G1'),
(26, 'Library', '025', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_notes`
--

CREATE TABLE `subject_notes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_notes`
--

INSERT INTO `subject_notes` (`id`, `teacher_id`, `class_id`, `section_id`, `subject_id`, `title`, `description`, `created_at`) VALUES
(15, 5, 6, NULL, 1, 'LogBook', '', '2026-01-27 10:47:14'),
(16, 27, 6, NULL, 3, 'English Tenses', '', '2026-02-04 15:55:26'),
(18, 26, 6, NULL, 6, 'River map', '', '2026-02-05 06:56:09'),
(19, 14, 5, NULL, 2, 'Chemical Basis of Life - Unit 01', '', '2026-02-06 20:02:30'),
(24, 24, 5, NULL, 4, 'நாவலர் எழுந்தார்', '', '2026-02-12 03:05:57'),
(25, 24, 5, NULL, 4, 'நீதிப்பாடல்கள்', '', '2026-02-12 03:17:04'),
(26, 27, 5, NULL, 3, 'Prefixes and Suffixes', '', '2026-03-04 12:27:38'),
(31, 27, 5, NULL, 3, 'Essay writing', '', '2026-03-04 12:29:34'),
(34, 27, 6, NULL, 3, 'Essay Writing', '', '2026-03-04 12:33:08'),
(35, 27, 5, NULL, 3, 'Active and passive voice', '', '2026-03-04 12:33:59'),
(37, 27, 5, NULL, 3, 'Tenses', '', '2026-03-04 12:36:45'),
(40, 27, 5, NULL, 10, 'Chapter 01-Information and Communication Technology', '', '2026-03-26 13:25:07'),
(41, 27, 5, NULL, 10, 'Chapter 01- Slides', '', '2026-03-26 13:26:01'),
(42, 27, 5, NULL, 10, 'Chapter 01 - Revision Sheet', '', '2026-03-26 13:28:22'),
(43, 27, 5, NULL, 10, 'Chapter-01 Questions', '', '2026-03-26 13:32:43'),
(44, 27, 5, NULL, 10, 'Chapter 02- Fundamentals of a computer system', '', '2026-03-26 13:36:19'),
(45, 27, 5, NULL, 3, 'Letter writing', '', '2026-03-26 13:37:32'),
(46, 27, 5, NULL, 3, 'Notice', '', '2026-03-26 13:40:29'),
(47, 27, 6, NULL, 3, 'Letter writing', '', '2026-03-26 13:51:21'),
(48, 27, 6, NULL, 3, 'Graphs', '', '2026-03-26 13:53:22'),
(49, 27, 6, NULL, 10, 'Gr 10 Chapter 01 Revision sheet', '', '2026-03-26 13:57:43'),
(50, 27, 5, NULL, 3, 'Mock paper', '', '2026-03-28 06:30:49'),
(51, 27, 6, NULL, 3, 'Mock paper', '', '2026-03-28 06:31:22'),
(52, 14, 5, NULL, 2, 'Unit 5 - Friction', 'Textbook', '2026-05-11 14:27:41'),
(53, 26, 6, NULL, 6, 'Industrial Revolution', 'Industrial Revolution complete notes', '2026-05-11 15:35:07'),
(54, 26, 5, NULL, 6, 'growth of kingship', '2026/05/12', '2026-05-12 15:21:48'),
(59, 14, 5, NULL, 13, 'Embekke Dewalaya', '', '2026-05-14 15:18:50'),
(60, 14, 6, NULL, 13, 'Embekke Dewalaya', '', '2026-05-14 15:28:35'),
(61, 24, 5, NULL, 4, 'marabu thodar', '', '2026-05-16 18:03:11'),
(62, 24, 5, NULL, 4, 'computer', '', '2026-05-16 18:05:26'),
(63, 26, 6, NULL, 6, '1848 rebel', '', '2026-05-18 15:27:13'),
(64, 25, 5, NULL, 14, 'The Huntsman Notes', '', '2026-05-20 08:14:41'),
(65, 25, 6, NULL, 14, 'The Huntsman', '', '2026-05-20 08:15:21'),
(66, 25, 5, NULL, 14, 'The Clown’s wife notes', '', '2026-05-20 10:09:19'),
(67, 25, 6, NULL, 14, 'The Clown\'s Wife Notes', '', '2026-05-20 10:09:48'),
(70, 33, 6, NULL, 5, 'Zakah(new)', '', '2026-05-31 20:38:27'),
(71, 23, 4, NULL, 5, 'unit 1-5', '', '2026-06-01 21:13:52'),
(72, 23, 3, NULL, 5, 'units 1-10', '', '2026-06-02 09:10:14'),
(73, 24, 5, NULL, 4, 'ல, ழ, ள பொருள் வேறுபாடு', '', '2026-06-03 21:14:29'),
(74, 24, 6, NULL, 4, 'ல, ழ, ள பொருள் வேறுபாடு', '', '2026-06-03 21:15:08'),
(92, 27, 4, NULL, 8, 'Chapter 01', '', '2026-06-04 16:36:22'),
(94, 33, 5, NULL, 5, '2017 past paper', '', '2026-06-04 19:23:45'),
(95, 33, 6, NULL, 5, 'past paper - 2019', '', '2026-06-08 19:27:22'),
(96, 33, 6, NULL, 5, 'Islam past paper 2020', '', '2026-06-08 19:28:48'),
(97, 33, 6, NULL, 5, 'past paper - 2021', '', '2026-06-08 19:30:04'),
(98, 33, 6, NULL, 5, 'past paper - 2017', '', '2026-06-08 19:33:42'),
(99, 33, 6, NULL, 5, 'past paper - 2018', '', '2026-06-08 19:34:34'),
(100, 33, 6, NULL, 5, 'past paper - 2022', '', '2026-06-08 19:35:39'),
(101, 33, 6, NULL, 5, 'past paper - 2023', '', '2026-06-08 19:46:16'),
(102, 33, 6, NULL, 5, 'past paper - 2024', '', '2026-06-08 19:48:15'),
(103, 33, 6, NULL, 5, 'past paper - 2025', '', '2026-06-08 19:49:25');

-- --------------------------------------------------------

--
-- Table structure for table `subject_note_files`
--

CREATE TABLE `subject_note_files` (
  `id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `drive_file_id` varchar(100) DEFAULT NULL,
  `drive_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_note_files`
--

INSERT INTO `subject_note_files` (`id`, `note_id`, `file_path`, `created_at`, `drive_file_id`, `drive_link`) VALUES
(12, 15, '', '2026-01-27 10:47:19', '10TGYP73SE3uJ6uB1d3H7A3JKsWppc3tM', 'https://drive.google.com/file/d/10TGYP73SE3uJ6uB1d3H7A3JKsWppc3tM/preview'),
(13, 16, '', '2026-02-04 15:55:32', '1Hi61lmqM9IHKUnHnax49l37vU3jZ62Lg', 'https://drive.google.com/file/d/1Hi61lmqM9IHKUnHnax49l37vU3jZ62Lg/preview'),
(14, 18, '', '2026-02-05 06:56:15', '1hQ3PY31O0QvO7OUkt4vo_lvytsMH7Zv4', 'https://drive.google.com/file/d/1hQ3PY31O0QvO7OUkt4vo_lvytsMH7Zv4/preview'),
(15, 19, '', '2026-02-06 20:02:36', '1LXzzJrcrVinb51rBPyTz710Fg_vN7TF-', 'https://drive.google.com/file/d/1LXzzJrcrVinb51rBPyTz710Fg_vN7TF-/preview'),
(20, 24, '', '2026-02-12 03:06:03', '1xzMUQbyp1k7mb-PTDljdiuX7RguCTERM', 'https://drive.google.com/file/d/1xzMUQbyp1k7mb-PTDljdiuX7RguCTERM/preview'),
(21, 25, '', '2026-02-12 03:17:09', '1a6HkXxitnOThBiFT16mpDUPasWESutxj', 'https://drive.google.com/file/d/1a6HkXxitnOThBiFT16mpDUPasWESutxj/preview'),
(22, 26, '', '2026-03-04 12:27:43', '1vmhdgzR4oAQFdkRRbbv8hNhSyxqR1btH', 'https://drive.google.com/file/d/1vmhdgzR4oAQFdkRRbbv8hNhSyxqR1btH/preview'),
(23, 31, '', '2026-03-04 12:29:39', '1lZlh7DXZ1RF8MXkXFLlA1WuzseYkP1fA', 'https://drive.google.com/file/d/1lZlh7DXZ1RF8MXkXFLlA1WuzseYkP1fA/preview'),
(24, 34, '', '2026-03-04 12:33:15', '1lrMMXMXmlA848y8gAyS1xKVS4uitO-Ll', 'https://drive.google.com/file/d/1lrMMXMXmlA848y8gAyS1xKVS4uitO-Ll/preview'),
(25, 35, '', '2026-03-04 12:34:03', '1dKLLTI8wARe4gyjJ8EiX09vfdylJ1vGR', 'https://drive.google.com/file/d/1dKLLTI8wARe4gyjJ8EiX09vfdylJ1vGR/preview'),
(26, 37, '', '2026-03-04 12:36:49', '1-SRF1dm8vv-4Zuwf1NoOhzMUKiGveBtH', 'https://drive.google.com/file/d/1-SRF1dm8vv-4Zuwf1NoOhzMUKiGveBtH/preview'),
(27, 40, '', '2026-03-26 13:25:12', '1f9Pui1RQSOg4aq8d2Oj185Bazl2RDUhn', 'https://drive.google.com/file/d/1f9Pui1RQSOg4aq8d2Oj185Bazl2RDUhn/preview'),
(28, 41, '', '2026-03-26 13:26:06', '15icpjHBiA87kf857hv5-EoYCrKvFbX4F', 'https://drive.google.com/file/d/15icpjHBiA87kf857hv5-EoYCrKvFbX4F/preview'),
(29, 42, '', '2026-03-26 13:28:27', '1SperzKBoW-Dd7EawWgW69bCwBOuMqTEg', 'https://drive.google.com/file/d/1SperzKBoW-Dd7EawWgW69bCwBOuMqTEg/preview'),
(30, 43, '', '2026-03-26 13:32:46', '11YVlUJhimCwmz2QQmJEjLz0Ndnpm-UHS', 'https://drive.google.com/file/d/11YVlUJhimCwmz2QQmJEjLz0Ndnpm-UHS/preview'),
(31, 44, '', '2026-03-26 13:36:23', '1MYSd9fRKz7CE712Qx4mzo89X6sS5W-wL', 'https://drive.google.com/file/d/1MYSd9fRKz7CE712Qx4mzo89X6sS5W-wL/preview'),
(32, 45, '', '2026-03-26 13:37:36', '1Pdc74wkHmbGo4tbOiqBjOlT0xzc-8_Dq', 'https://drive.google.com/file/d/1Pdc74wkHmbGo4tbOiqBjOlT0xzc-8_Dq/preview'),
(33, 46, '', '2026-03-26 13:40:32', '13gOEEia-cxWUCwoeXYEc7-cQoylFfyWg', 'https://drive.google.com/file/d/13gOEEia-cxWUCwoeXYEc7-cQoylFfyWg/preview'),
(34, 47, '', '2026-03-26 13:51:25', '12XNjRB-NHHOc_zQdYbUDibcvRlSdYMnl', 'https://drive.google.com/file/d/12XNjRB-NHHOc_zQdYbUDibcvRlSdYMnl/preview'),
(35, 48, '', '2026-03-26 13:53:26', '1BFAgJXbkx8vzRZX4eMXOtBXJc4WQZTXo', 'https://drive.google.com/file/d/1BFAgJXbkx8vzRZX4eMXOtBXJc4WQZTXo/preview'),
(36, 49, '', '2026-03-26 13:57:50', '1SEbh8bA6OyNu3Q9eCPdHbpqjsUeQIrhq', 'https://drive.google.com/file/d/1SEbh8bA6OyNu3Q9eCPdHbpqjsUeQIrhq/preview'),
(37, 50, '', '2026-03-28 06:30:53', '1VLxLZIVNSiFJxa7OnmvAaLXPHO6JAY8R', 'https://drive.google.com/file/d/1VLxLZIVNSiFJxa7OnmvAaLXPHO6JAY8R/preview'),
(38, 51, '', '2026-03-28 06:31:25', '1l_Qg8eynfiRW_e8PeRYBXUC2_glML1cS', 'https://drive.google.com/file/d/1l_Qg8eynfiRW_e8PeRYBXUC2_glML1cS/preview'),
(39, 52, '', '2026-05-11 14:27:45', '1Owsovus96Uis4yljgtuU5E63dRxFAAtr', 'https://drive.google.com/file/d/1Owsovus96Uis4yljgtuU5E63dRxFAAtr/preview'),
(40, 53, '', '2026-05-11 15:35:11', '1Sj9EP_VBwbvkHqxLuL3Lyh0mAO4t0QC5', 'https://drive.google.com/file/d/1Sj9EP_VBwbvkHqxLuL3Lyh0mAO4t0QC5/preview'),
(41, 54, '', '2026-05-12 15:21:53', '1ajH9NZIw_RR2AjGLA-qvjbZfxHoSMoLc', 'https://drive.google.com/file/d/1ajH9NZIw_RR2AjGLA-qvjbZfxHoSMoLc/preview'),
(45, 59, '', '2026-05-14 15:18:54', '1WoXWCLhBOD35LujVqCIINnQYOxPe5X8k', 'https://drive.google.com/file/d/1WoXWCLhBOD35LujVqCIINnQYOxPe5X8k/preview'),
(46, 60, '', '2026-05-14 15:28:39', '1dLdJdaWX2x52ib0C2H0TfqvypimUiYP6', 'https://drive.google.com/file/d/1dLdJdaWX2x52ib0C2H0TfqvypimUiYP6/preview'),
(47, 61, '', '2026-05-16 18:03:15', '1aGK4qFTgE7z5CQmP9W2v8JFQmp3STOeo', 'https://drive.google.com/file/d/1aGK4qFTgE7z5CQmP9W2v8JFQmp3STOeo/preview'),
(48, 62, '', '2026-05-16 18:05:30', '1uQtyJau9cnfnfI2wL29vpkB0rliJrCCQ', 'https://drive.google.com/file/d/1uQtyJau9cnfnfI2wL29vpkB0rliJrCCQ/preview'),
(49, 63, '', '2026-05-18 15:27:17', '17VEdyyGb5A8Jt1C0sBWQ1QHkWIimdHy6', 'https://drive.google.com/file/d/17VEdyyGb5A8Jt1C0sBWQ1QHkWIimdHy6/preview'),
(50, 64, '', '2026-05-20 08:14:46', '1s3DOAuwOZdKlwncSRDiB0ZkIWvB_Xt6E', 'https://drive.google.com/file/d/1s3DOAuwOZdKlwncSRDiB0ZkIWvB_Xt6E/preview'),
(51, 65, '', '2026-05-20 08:15:25', '1ce2jYbNV3ywJX19Yq0cxDmIiaufBmaFJ', 'https://drive.google.com/file/d/1ce2jYbNV3ywJX19Yq0cxDmIiaufBmaFJ/preview'),
(52, 66, '', '2026-05-20 10:09:22', '1ornyvaAFEEjhpXOlrY9O68MsJcL83B2J', 'https://drive.google.com/file/d/1ornyvaAFEEjhpXOlrY9O68MsJcL83B2J/preview'),
(53, 67, '', '2026-05-20 10:09:51', '1FlYdbShFzApLPdXp38jihxrncbdBNGtY', 'https://drive.google.com/file/d/1FlYdbShFzApLPdXp38jihxrncbdBNGtY/preview'),
(55, 92, '', '2026-06-04 16:36:27', '1mo5OmXv9VFwJ9NsB4QIBsql1GRb1vZb9', 'https://drive.google.com/file/d/1mo5OmXv9VFwJ9NsB4QIBsql1GRb1vZb9/preview'),
(57, 94, '', '2026-06-04 19:23:51', '1OCxnH3v3iu85L3Jz7uAUxMuJOtoU365i', 'https://drive.google.com/file/d/1OCxnH3v3iu85L3Jz7uAUxMuJOtoU365i/preview'),
(58, 95, '', '2026-06-08 19:27:27', '1WMqPdxQ5nIKpmR0ULfNTdroHWA7LBFWf', 'https://drive.google.com/file/d/1WMqPdxQ5nIKpmR0ULfNTdroHWA7LBFWf/preview'),
(59, 96, '', '2026-06-08 19:28:52', '1Uf4l2lJltYfSsKpQLIw-KqQGBGlX9Vuv', 'https://drive.google.com/file/d/1Uf4l2lJltYfSsKpQLIw-KqQGBGlX9Vuv/preview'),
(60, 97, '', '2026-06-08 19:30:07', '1EhzMX9mYbW7Qcscke4XMTmhgpBcp9qh3', 'https://drive.google.com/file/d/1EhzMX9mYbW7Qcscke4XMTmhgpBcp9qh3/preview'),
(61, 98, '', '2026-06-08 19:33:46', '1p1OuBg5bNF8bNnnkJnej1gjqu_NPe_MH', 'https://drive.google.com/file/d/1p1OuBg5bNF8bNnnkJnej1gjqu_NPe_MH/preview'),
(62, 99, '', '2026-06-08 19:34:38', '1TEj-EU6Y3vr4-yYJR_A1gw4AMqGt7dET', 'https://drive.google.com/file/d/1TEj-EU6Y3vr4-yYJR_A1gw4AMqGt7dET/preview'),
(63, 100, '', '2026-06-08 19:35:43', '1nQ1RK3ZIahRUIcFgJkd4IaDYAhRr26i9', 'https://drive.google.com/file/d/1nQ1RK3ZIahRUIcFgJkd4IaDYAhRr26i9/preview'),
(64, 101, '', '2026-06-08 19:46:20', '1g1vrZM2xFLev6sWIrPSoNDVUyMMWIXGj', 'https://drive.google.com/file/d/1g1vrZM2xFLev6sWIrPSoNDVUyMMWIXGj/preview'),
(65, 102, '', '2026-06-08 19:48:19', '180VGQzkYImweZj4ct2oDwtEvMKlfoJy7', 'https://drive.google.com/file/d/180VGQzkYImweZj4ct2oDwtEvMKlfoJy7/preview'),
(66, 103, '', '2026-06-08 19:49:29', '14Em3wfGGWlk_dZ6pZ2GbbuKBgf54mZcY', 'https://drive.google.com/file/d/14Em3wfGGWlk_dZ6pZ2GbbuKBgf54mZcY/preview');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_code` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('male','female','other') DEFAULT 'male',
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT curdate(),
  `status` enum('active','inactive','left') DEFAULT 'active',
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_code`, `user_id`, `first_name`, `last_name`, `gender`, `email`, `phone`, `subject_id`, `photo`, `join_date`, `status`, `class_id`, `section_id`) VALUES
(5, 'T001', 30, 'Shareeq', 'Ahamedh', 'male', 'shareeqajward@gmail.com', '0778535552', 1, 'teacher_691d884e2bf916.03026403.png', '2025-11-19', 'active', NULL, NULL),
(7, 'T007', 38, 'Shaham', 'Ahamed', 'male', 'shahamajward@gmail.com', '0776994569', NULL, NULL, '2025-11-19', 'active', NULL, NULL),
(9, 'T009', 40, 'Nizvardeen', 'sir', 'male', 'mail2scienceacademy@gmail.com', '0772260093', NULL, NULL, '2025-11-19', 'active', NULL, NULL),
(13, 'T013', 44, 'Amal', 'Ashraff', 'female', 'mail2scienceacademy@gmail.com', '0777533437', 28, 'teacher_69e887392eaf55.88014867.png', '2025-11-19', 'active', NULL, NULL),
(14, 'T014', 45, 'Fazrin', 'Kamiss', 'female', 'mail2scienceacademy@gmail.com', '0767047075', NULL, 'teacher_696e3d93928611.64084842.jpg', '2025-11-19', 'active', NULL, NULL),
(19, 'T019', 50, 'Fathima', 'Zeenath', 'female', 'mail2scienceacademy@gmail.com', '0787555148', NULL, NULL, '2025-11-19', 'active', NULL, NULL),
(20, 'T020', 51, 'Imna', 'Inthan', 'female', 'mail2scienceacademy@gmail.com', '0760066652', NULL, NULL, '2025-11-19', 'active', NULL, NULL),
(21, 'T021', 69, 'SANHA', 'SHAMS', 'female', 'mail2scienceacademy@gmail.com', '0711551979', 2, NULL, '2026-01-14', 'active', NULL, NULL),
(23, 'T023', 71, 'Amna', 'Hanas', 'female', 'mail2scienceacademy@gmail.com', '0760160047', 10, NULL, '2026-01-14', 'active', NULL, NULL),
(24, 'T024', 72, 'Shahla', 'Ansar', 'female', 'mail2scienceacademy@gmail.com', '0779447727', 4, NULL, '2026-01-14', 'active', NULL, NULL),
(25, 'T025', 73, 'Hikma', 'Awzin', 'female', 'mail2scienceacademy@gmail.com', '0743563838', 14, NULL, '2026-01-14', 'active', NULL, NULL),
(26, 'T026', 74, 'Maryam', 'Ilyas', 'female', 'mail2scienceacademy@gmail.com', '0740427752', 6, NULL, '2026-01-14', 'active', NULL, NULL),
(27, 'T027', 75, 'Faraza', 'Ishaq', 'female', 'mail2scienceacademy@gmail.com', '0766603026', 10, NULL, '2026-01-14', 'active', NULL, NULL),
(29, 'T029', 137, 'DINUSHI', 'SAMARAKOON', 'female', 'mail2scienceacademy@gmail.com', '0703488890', 4, NULL, '2026-02-02', 'active', NULL, NULL),
(30, 'T030', 145, 'ISHRA', 'MAFAZ', 'female', 'mail2scienceacademy@gmail.com', '0755662034', NULL, NULL, '2026-02-11', 'active', NULL, NULL),
(31, 'T031', 154, 'Arun', 'Jeganathan', 'male', 'jeganathanarun1105@gmail.com', '0775959641', 18, NULL, '2026-04-09', 'active', NULL, NULL),
(32, 'T032', 156, 'Nivarthana', 'Thathsarani', 'female', 'mail2scienceacademy@gmail.com', '0764836833', NULL, NULL, '2026-05-05', 'active', NULL, NULL),
(33, 'T033', 157, 'Azka', 'Ikram', 'female', 'mail2scienceacademy@gmail.com', '0740599038', 5, NULL, '2026-05-06', 'active', NULL, NULL),
(34, 'T034', 168, 'Test', 'Test', 'male', 'test@gmail.com', '', NULL, NULL, '2026-05-17', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_attendance`
--

CREATE TABLE `teacher_attendance` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Late') DEFAULT 'Present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE `teacher_classes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_classes`
--

INSERT INTO `teacher_classes` (`id`, `teacher_id`, `class_id`, `section_id`, `created_at`) VALUES
(2, 24, 1, 1, '2026-01-14 04:29:14'),
(3, 5, 7, 7, '2026-01-14 07:49:15'),
(4, 31, 5, 5, '2026-04-09 04:30:40');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_leave_quota`
--

CREATE TABLE `teacher_leave_quota` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `sick_leave` int(11) DEFAULT 0,
  `casual_leave` int(11) DEFAULT 0,
  `annual_leave` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_leave_quota`
--

INSERT INTO `teacher_leave_quota` (`id`, `teacher_id`, `year`, `sick_leave`, `casual_leave`, `annual_leave`, `created_at`, `updated_at`) VALUES
(4, 5, 2026, 14, 14, 14, '2026-01-19 03:12:34', '2026-01-19 03:12:34'),
(6, 13, 2026, 14, 14, 0, '2026-01-19 05:35:38', '2026-01-19 05:35:38'),
(7, 23, 2026, 14, 14, 0, '2026-01-19 05:35:55', '2026-01-19 05:35:55'),
(8, 22, 2026, 14, 14, 0, '2026-01-19 05:36:08', '2026-01-19 05:36:08'),
(9, 27, 2026, 14, 14, 0, '2026-01-19 05:36:24', '2026-01-19 05:36:24'),
(10, 19, 2026, 14, 14, 0, '2026-01-19 05:36:40', '2026-01-19 05:36:40'),
(11, 14, 2026, 14, 14, 0, '2026-01-19 05:36:55', '2026-01-19 05:36:55'),
(12, 25, 2026, 14, 14, 0, '2026-01-19 05:37:05', '2026-01-19 05:37:05'),
(13, 26, 2026, 14, 14, 0, '2026-01-19 05:37:21', '2026-01-19 05:37:21'),
(14, 17, 2026, 14, 14, 0, '2026-01-19 05:37:33', '2026-01-19 05:37:33'),
(15, 15, 2026, 14, 14, 0, '2026-01-19 05:37:48', '2026-01-19 05:37:48'),
(16, 21, 2026, 14, 14, 0, '2026-01-19 05:38:00', '2026-01-19 05:38:00'),
(17, 24, 2026, 14, 14, 0, '2026-01-19 05:38:18', '2026-01-19 05:38:18'),
(19, 30, 2026, 14, 14, 0, '2026-02-11 05:45:19', '2026-02-11 05:45:19'),
(20, 31, 2026, 14, 14, 0, '2026-04-09 04:22:42', '2026-04-09 04:22:42'),
(21, 33, 2026, 14, 14, 0, '2026-05-06 05:42:04', '2026-05-06 05:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_leave_requests`
--

CREATE TABLE `teacher_leave_requests` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `leave_type` enum('SICK','CASUAL','ANNUAL') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days` int(11) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_leave_requests`
--

INSERT INTO `teacher_leave_requests` (`id`, `teacher_id`, `leave_type`, `start_date`, `end_date`, `days`, `reason`, `status`, `created_at`) VALUES
(1, 14, 'CASUAL', '2026-01-20', '2026-01-20', 1, 'Dear Sir, \r\nI request a day off tomorrow for some personal works. \r\n\r\nThank you.', 'Approved', '2026-01-19 14:19:25'),
(2, 14, 'SICK', '2026-01-27', '2026-01-27', 1, 'Fever', 'Approved', '2026-01-27 00:35:01'),
(14, 14, 'SICK', '2026-01-28', '2026-01-28', 1, 'Fever', 'Approved', '2026-01-27 18:18:02'),
(15, 14, 'CASUAL', '2026-02-11', '2026-02-11', 1, 'Personal works', 'Approved', '2026-02-11 01:12:43'),
(16, 27, 'CASUAL', '2026-02-16', '2026-02-16', 1, 'Personal reasons.', 'Approved', '2026-02-15 13:52:08'),
(17, 26, 'CASUAL', '2026-02-17', '2026-02-17', 1, 'Personal reasons', 'Approved', '2026-02-16 12:52:49'),
(18, 24, 'SICK', '2026-02-16', '2026-02-16', 1, 'Sick', 'Approved', '2026-02-17 13:25:26'),
(19, 30, 'SICK', '2026-02-26', '2026-02-26', 1, 'Due to a scheduled medical checkup', 'Approved', '2026-02-25 14:44:01'),
(20, 27, 'CASUAL', '2026-03-03', '2026-03-03', 1, 'Personal reasons.', 'Approved', '2026-03-02 14:04:48'),
(21, 25, 'SICK', '2026-03-04', '2026-03-04', 1, 'Having Cold', 'Approved', '2026-03-03 23:47:13'),
(22, 30, 'CASUAL', '2026-03-25', '2026-03-26', 2, 'Family emergency', 'Approved', '2026-03-24 11:36:00'),
(23, 25, 'CASUAL', '2026-04-02', '2026-04-02', 1, 'Personal purpose', 'Approved', '2026-04-02 00:29:59'),
(26, 14, 'SICK', '2026-04-09', '2026-04-09', 1, 'Severe migraine & vomiting', 'Approved', '2026-04-09 00:58:54'),
(27, 14, 'SICK', '2026-04-21', '2026-04-21', 1, 'Fever', 'Approved', '2026-04-21 04:47:30'),
(28, 27, 'CASUAL', '2026-04-22', '2026-04-22', 1, 'Personal Reasons', 'Approved', '2026-04-21 15:54:53'),
(29, 27, 'SICK', '2026-04-24', '2026-04-24', 1, 'Medical reasons', 'Approved', '2026-04-23 18:53:47'),
(30, 24, 'SICK', '2026-04-28', '2026-04-28', 1, 'Sick', 'Approved', '2026-04-28 04:18:32'),
(31, 27, 'CASUAL', '2026-05-06', '2026-05-06', 1, 'Personal reasons.', 'Approved', '2026-05-05 14:53:34'),
(32, 23, 'SICK', '2026-05-06', '2026-05-06', 1, 'Feeling unwell today and won’t be able to attend school today', 'Approved', '2026-05-06 01:28:04'),
(33, 27, 'CASUAL', '2026-05-12', '2026-05-14', 3, 'Exam Preparation.', 'Approved', '2026-05-14 15:58:47'),
(34, 25, 'CASUAL', '2026-05-18', '2026-05-18', 1, 'Due to an exam', 'Approved', '2026-05-16 13:12:23'),
(35, 31, 'CASUAL', '2026-05-18', '2026-05-18', 1, 'Personal work', 'Approved', '2026-05-17 05:56:11'),
(36, 14, 'SICK', '2026-05-18', '2026-05-18', 1, 'Hand injury', 'Approved', '2026-05-17 13:36:59'),
(37, 33, 'CASUAL', '2026-05-18', '2026-05-18', 1, 'Assalamu alaikum sir,  \r\n\r\nI have a sudden medical emergency and need to go to the hospital.so I won’t be able to come to school today.  \r\nPlease approve emergency leave for today. \r\n\r\nJazakumullah khair.', 'Approved', '2026-05-18 00:41:12'),
(38, 24, 'SICK', '2026-05-20', '2026-05-20', 1, 'Leg injured', 'Pending', '2026-05-19 18:21:08'),
(39, 25, 'CASUAL', '2026-05-21', '2026-05-21', 1, 'Because one of my sibling is hospitalised', 'Pending', '2026-05-21 00:19:31'),
(40, 14, 'CASUAL', '2026-06-01', '2026-06-01', 1, 'Personal works', 'Pending', '2026-06-01 03:49:53'),
(41, 27, 'CASUAL', '2026-06-02', '2026-06-02', 1, 'Personal Reasons', 'Pending', '2026-06-01 12:53:58'),
(42, 26, 'SICK', '2026-06-04', '2026-06-04', 1, 'Not well', 'Pending', '2026-06-03 14:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_payments`
--

CREATE TABLE `teacher_payments` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `month_year` varchar(20) NOT NULL,
  `base_salary` decimal(10,2) NOT NULL,
  `bonus` decimal(10,2) DEFAULT 0.00,
  `deductions` decimal(10,2) DEFAULT 0.00,
  `total_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(10,2) NOT NULL,
  `payment_date` date DEFAULT curdate(),
  `method` varchar(50) DEFAULT 'Cash',
  `remarks` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_payments`
--

INSERT INTO `teacher_payments` (`id`, `teacher_id`, `month_year`, `base_salary`, `bonus`, `deductions`, `total_paid`, `net_salary`, `payment_date`, `method`, `remarks`, `created_by`, `created_at`) VALUES
(4, 13, '2026-02', 50000.00, 0.00, 0.00, 50000.00, 0.00, '2026-03-04', 'Cash', '', 1, '2026-03-04 09:17:37'),
(5, 23, '2026-02', 27500.00, 0.00, 0.00, 27500.00, 0.00, '2026-03-04', 'Bank Transfer', '', 1, '2026-03-04 09:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `period_number` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `basket_group` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `class_id`, `section_id`, `day_of_week`, `period_number`, `subject_id`, `teacher_id`, `start_time`, `end_time`, `basket_group`) VALUES
(276, 7, 7, 'Sunday', 9, 18, 5, '13:20:00', '14:00:00', NULL),
(277, 7, 7, 'Sunday', 10, 18, 5, '14:00:00', '14:40:00', NULL),
(278, 8, 11, 'Saturday', 8, 18, 5, '12:40:00', '13:20:00', NULL),
(279, 8, 11, 'Saturday', 10, 18, 5, '14:00:00', '14:40:00', NULL),
(280, 5, 5, 'Saturday', 6, 1, 5, '11:20:00', '12:00:00', NULL),
(281, 5, 5, 'Saturday', 7, 1, 5, '12:00:00', '12:40:00', NULL),
(282, 6, 6, 'Sunday', 6, 1, 5, '11:20:00', '12:00:00', NULL),
(283, 6, 6, 'Sunday', 7, 1, 5, '12:00:00', '12:40:00', NULL),
(284, 5, 5, 'Sunday', 11, 1, 5, '14:40:00', '15:20:00', NULL),
(285, 5, 5, 'Sunday', 12, 1, 5, '15:20:00', '16:00:00', NULL),
(342, 5, 5, 'Saturday', 1, 25, 34, '07:40:00', '08:20:00', 'G1'),
(343, 6, 6, 'Saturday', 2, 24, 34, '08:20:00', '09:00:00', 'G1'),
(344, 6, 6, 'Saturday', 3, 12, 34, '09:00:00', '09:40:00', 'G1'),
(345, 6, 6, 'Saturday', 4, 14, 34, '09:40:00', '10:20:00', 'G2'),
(346, 6, 6, 'Saturday', 5, 20, 34, '10:20:00', '11:00:00', 'G2'),
(347, 6, 6, 'Saturday', 6, 15, 34, '11:20:00', '12:00:00', 'G2'),
(348, 6, 6, 'Saturday', 7, 21, 34, '12:00:00', '12:40:00', 'G3'),
(350, 6, 6, 'Saturday', 8, 23, 34, '12:40:00', '13:20:00', 'G3'),
(351, 6, 6, 'Monday', 1, 6, 26, '07:40:00', '08:20:00', NULL),
(352, 6, 6, 'Monday', 2, 1, 31, '08:20:00', '09:00:00', NULL),
(353, 6, 6, 'Monday', 3, 1, 31, '09:00:00', '09:40:00', NULL),
(354, 6, 6, 'Monday', 4, 12, 19, '09:40:00', '10:20:00', 'G1'),
(355, 6, 6, 'Monday', 5, 3, 27, '10:20:00', '11:00:00', NULL),
(356, 6, 6, 'Monday', 6, 4, 24, '11:20:00', '12:00:00', NULL),
(357, 6, 6, 'Monday', 6, 9, 29, '11:20:00', '12:00:00', NULL),
(358, 6, 6, 'Monday', 7, 23, 27, '12:00:00', '12:40:00', 'G3'),
(359, 6, 6, 'Monday', 7, 21, 21, '12:00:00', '12:40:00', 'G3'),
(360, 6, 6, 'Monday', 8, 5, 33, '12:40:00', '13:20:00', NULL),
(361, 6, 6, 'Monday', 9, 14, 25, '13:20:00', '14:00:00', 'G2'),
(362, 6, 6, 'Monday', 9, 20, 14, '13:20:00', '14:00:00', 'G2'),
(363, 6, 6, 'Monday', 4, 24, 29, '09:40:00', '10:20:00', 'G1'),
(364, 6, 6, 'Monday', 4, 25, 24, '09:40:00', '10:20:00', 'G1'),
(365, 6, 6, 'Monday', 9, 15, 34, '13:20:00', '14:00:00', 'G2'),
(366, 5, 5, 'Monday', 1, 1, 31, '07:40:00', '08:20:00', NULL),
(367, 5, 5, 'Monday', 2, 12, 19, '08:20:00', '09:00:00', 'G1'),
(368, 5, 5, 'Monday', 2, 24, 29, '08:20:00', '09:00:00', 'G1'),
(370, 5, 5, 'Monday', 3, 3, 27, '09:00:00', '09:40:00', NULL),
(371, 5, 5, 'Monday', 4, 3, 27, '09:40:00', '10:20:00', NULL),
(372, 5, 5, 'Monday', 5, 6, 26, '10:20:00', '11:00:00', NULL),
(373, 5, 5, 'Monday', 6, 5, 33, '11:20:00', '12:00:00', NULL),
(374, 5, 5, 'Monday', 7, 2, 14, '12:00:00', '12:40:00', NULL),
(375, 5, 5, 'Monday', 8, 20, 14, '12:40:00', '13:20:00', 'G2'),
(376, 5, 5, 'Monday', 8, 14, 25, '12:40:00', '13:20:00', 'G2'),
(378, 5, 5, 'Monday', 9, 4, 24, '13:20:00', '14:00:00', NULL),
(379, 5, 5, 'Monday', 9, 9, 29, '13:20:00', '14:00:00', NULL),
(380, 4, 4, 'Monday', 1, 10, 27, '07:40:00', '08:20:00', NULL),
(381, 4, 4, 'Monday', 2, 13, 32, '08:20:00', '09:00:00', NULL),
(382, 4, 4, 'Monday', 3, 1, 33, '09:00:00', '09:40:00', NULL),
(384, 4, 4, 'Monday', 4, 3, 25, '09:40:00', '10:20:00', NULL),
(385, 4, 4, 'Monday', 5, 2, 21, '10:20:00', '11:00:00', NULL),
(386, 4, 4, 'Monday', 6, 26, 32, '11:20:00', '12:00:00', NULL),
(387, 4, 4, 'Monday', 7, 3, 25, '12:00:00', '12:40:00', NULL),
(388, 5, 5, 'Monday', 8, 15, 34, '12:40:00', '13:20:00', 'G2'),
(389, 4, 4, 'Monday', 8, 4, 24, '12:40:00', '13:20:00', NULL),
(390, 4, 4, 'Monday', 8, 9, 29, '12:40:00', '13:20:00', NULL),
(391, 4, 4, 'Monday', 9, 7, 26, '13:20:00', '14:00:00', NULL),
(392, 3, 3, 'Monday', 1, 2, 21, '07:40:00', '08:20:00', NULL),
(393, 5, 5, 'Monday', 2, 25, 34, '08:20:00', '09:00:00', 'G1'),
(394, 3, 3, 'Monday', 2, 8, 24, '08:20:00', '09:00:00', NULL),
(395, 3, 3, 'Monday', 3, 4, 24, '09:00:00', '09:40:00', NULL),
(396, 3, 3, 'Monday', 3, 9, 29, '09:00:00', '09:40:00', NULL),
(397, 3, 3, 'Monday', 4, 1, 33, '09:40:00', '10:20:00', NULL),
(398, 3, 3, 'Monday', 5, 1, 33, '10:20:00', '11:00:00', NULL),
(399, 3, NULL, 'Monday', 6, 6, 26, '11:20:00', '12:00:00', NULL),
(400, 3, 3, 'Monday', 7, 13, 32, '12:00:00', '12:40:00', NULL),
(401, 3, 3, 'Monday', 8, 22, 21, '12:40:00', '13:20:00', NULL),
(402, 3, 3, 'Monday', 9, 10, 27, '13:20:00', '14:00:00', NULL),
(404, 2, 2, 'Monday', 2, 1, 33, '08:20:00', '09:00:00', NULL),
(405, 2, 2, 'Monday', 3, 2, 21, '09:00:00', '09:40:00', NULL),
(406, 2, 2, 'Monday', 4, 2, 21, '09:40:00', '10:20:00', NULL),
(407, 2, 2, 'Monday', 5, 8, 24, '10:20:00', '11:00:00', NULL),
(409, 2, 2, 'Monday', 1, 17, 25, '07:40:00', '08:20:00', NULL),
(410, 2, 2, 'Monday', 1, 19, 32, '07:40:00', '08:20:00', NULL),
(411, 2, 2, 'Monday', 6, 3, 25, '11:20:00', '12:00:00', NULL),
(412, 2, 2, 'Monday', 7, 4, 24, '12:00:00', '12:40:00', NULL),
(413, 2, 2, 'Monday', 7, 9, 29, '12:00:00', '12:40:00', NULL),
(414, 2, 2, 'Monday', 8, 6, 26, '12:40:00', '13:20:00', NULL),
(415, 2, 2, 'Monday', 9, 13, 32, '13:20:00', '14:00:00', NULL),
(416, 1, 1, 'Monday', 1, 9, 29, '07:40:00', '08:20:00', NULL),
(418, 1, 1, 'Monday', 2, 2, 21, '08:20:00', '09:00:00', NULL),
(419, 1, 1, 'Monday', 3, 3, 25, '09:00:00', '09:40:00', NULL),
(420, 1, 1, 'Monday', 4, 6, 26, '09:40:00', '10:20:00', NULL),
(421, 1, 1, 'Monday', 5, 13, 32, '10:20:00', '11:00:00', NULL),
(422, 1, 1, 'Monday', 6, 10, 27, '11:20:00', '12:00:00', NULL),
(423, 1, 1, 'Monday', 7, 1, 33, '12:00:00', '12:40:00', NULL),
(424, 1, 1, 'Monday', 8, 26, 32, '12:40:00', '13:20:00', NULL),
(425, 1, 1, 'Monday', 9, 22, 21, '13:20:00', '14:00:00', NULL),
(426, 5, 5, 'Sunday', 1, 23, 34, '07:40:00', '08:20:00', 'G3'),
(427, 5, 5, 'Sunday', 3, 21, 34, '09:00:00', '09:40:00', 'G3'),
(434, 1, 1, 'Monday', 1, 4, 33, '07:40:00', '08:20:00', NULL),
(451, 1, 1, 'Thursday', 1, 4, 33, '07:40:00', '08:20:00', NULL),
(452, 1, 1, 'Thursday', 1, 9, 29, '07:40:00', '08:20:00', NULL),
(453, 1, 1, 'Thursday', 2, 2, 21, '08:20:00', '09:00:00', NULL),
(454, 1, 1, 'Thursday', 3, 11, 26, '09:00:00', '09:40:00', NULL),
(455, 1, 1, 'Thursday', 4, 4, 33, '09:40:00', '10:20:00', NULL),
(456, 1, 1, 'Thursday', 4, 9, 29, '09:40:00', '10:20:00', NULL),
(457, 1, 1, 'Thursday', 5, 3, 25, '10:20:00', '11:00:00', NULL),
(458, 1, 1, 'Thursday', 6, 6, 26, '11:20:00', '12:00:00', NULL),
(459, 1, 1, 'Thursday', 7, 1, 33, '12:00:00', '12:40:00', NULL),
(460, 1, 1, 'Thursday', 8, 1, 33, '12:40:00', '13:20:00', NULL),
(462, 1, 1, 'Friday', 1, 6, 26, '07:40:00', '08:20:00', NULL),
(463, 1, 1, 'Friday', 2, 10, 27, '08:20:00', '09:00:00', NULL),
(464, 1, 1, 'Friday', 3, 3, 25, '09:00:00', '09:40:00', NULL),
(465, 1, 1, 'Friday', 4, 13, 32, '09:40:00', '10:20:00', NULL),
(466, 1, 1, 'Friday', 5, 11, 26, '10:20:00', '11:00:00', NULL),
(498, 4, 4, 'Friday', 5, 11, 23, '10:20:00', '11:00:00', NULL),
(499, 3, 3, 'Thursday', 4, 17, 23, '09:40:00', '10:20:00', NULL),
(503, 1, 1, 'Thursday', 9, 5, 23, '13:20:00', '14:00:00', NULL),
(506, 2, 2, 'Thursday', 1, 7, 23, '07:40:00', '08:20:00', NULL),
(507, 2, 2, 'Thursday', 2, 6, 26, '08:20:00', '09:00:00', NULL),
(508, 2, 2, 'Thursday', 3, 2, 21, '09:00:00', '09:40:00', NULL),
(509, 2, 2, 'Thursday', 4, 3, 25, '09:40:00', '10:20:00', NULL),
(510, 2, 2, 'Thursday', 5, 4, 24, '10:20:00', '11:00:00', NULL),
(511, 2, 2, 'Thursday', 5, 9, 29, '10:20:00', '11:00:00', NULL),
(512, 2, 2, 'Thursday', 6, 10, 27, '11:20:00', '12:00:00', NULL),
(513, 2, 2, 'Thursday', 7, 5, 23, '12:00:00', '12:40:00', NULL),
(514, 2, 2, 'Thursday', 8, 22, 21, '12:40:00', '13:20:00', NULL),
(515, 2, 2, 'Thursday', 9, 1, 33, '13:20:00', '14:00:00', NULL),
(516, 2, 2, 'Friday', 1, 3, 25, '07:40:00', '08:20:00', NULL),
(517, 2, 2, 'Friday', 2, 26, 32, '08:20:00', '09:00:00', NULL),
(518, 2, 2, 'Friday', 3, 13, 32, '09:00:00', '09:40:00', NULL),
(519, 2, 2, 'Friday', 4, 5, 23, '09:40:00', '10:20:00', NULL),
(520, 2, 2, 'Friday', 5, 4, 24, '10:20:00', '11:00:00', NULL),
(521, 2, 2, 'Friday', 5, 9, 29, '10:20:00', '11:00:00', NULL),
(539, 3, 3, 'Thursday', 1, 2, 21, '07:40:00', '08:20:00', NULL),
(540, 3, 3, 'Thursday', 2, 4, 24, '08:20:00', '09:00:00', NULL),
(541, 3, 3, 'Thursday', 2, 9, 29, '08:20:00', '09:00:00', NULL),
(542, 3, 3, 'Thursday', 3, 26, 32, '09:00:00', '09:40:00', NULL),
(544, 3, 3, 'Thursday', 4, 19, 32, '09:40:00', '10:20:00', NULL),
(545, 3, 3, 'Thursday', 5, 1, 33, '10:20:00', '11:00:00', NULL),
(546, 3, 3, 'Thursday', 6, 5, 23, '11:20:00', '12:00:00', NULL),
(547, 3, 3, 'Thursday', 7, 11, 26, '12:00:00', '12:40:00', NULL),
(548, 3, 3, 'Thursday', 8, 7, 23, '12:40:00', '13:20:00', NULL),
(549, 3, 3, 'Thursday', 9, 3, 25, '13:20:00', '14:00:00', NULL),
(550, 3, 3, 'Friday', 1, 17, 23, '07:40:00', '08:20:00', NULL),
(551, 3, 3, 'Friday', 1, 19, 32, '07:40:00', '08:20:00', NULL),
(552, 3, NULL, 'Friday', 2, 4, 24, '08:20:00', '09:00:00', NULL),
(553, 3, 3, 'Friday', 2, 9, 29, '08:20:00', '09:00:00', NULL),
(554, 3, 3, 'Friday', 3, 5, 23, '09:00:00', '09:40:00', NULL),
(555, 3, 3, 'Friday', 4, 4, 24, '09:40:00', '10:20:00', NULL),
(556, 3, 3, 'Friday', 4, 9, 29, '09:40:00', '10:20:00', NULL),
(557, 3, 3, 'Friday', 5, 3, 25, '10:20:00', '11:00:00', NULL),
(578, 4, 4, 'Thursday', 1, 8, 27, '07:40:00', '08:20:00', NULL),
(579, 4, 4, 'Thursday', 2, 5, 23, '08:20:00', '09:00:00', NULL),
(580, 4, 4, 'Thursday', 3, 1, 33, '09:00:00', '09:40:00', NULL),
(581, 4, 4, 'Thursday', 4, 2, 21, '09:40:00', '10:20:00', NULL),
(582, 4, 4, 'Thursday', 5, 2, 21, '10:20:00', '11:00:00', NULL),
(583, 4, 4, 'Thursday', 6, 4, 24, '11:20:00', '12:00:00', NULL),
(584, 4, 4, 'Thursday', 6, 9, 29, '11:20:00', '12:00:00', NULL),
(585, 4, 4, 'Thursday', 7, 4, 24, '12:00:00', '12:40:00', NULL),
(586, 4, 4, 'Thursday', 8, 3, 25, '12:40:00', '13:20:00', NULL),
(587, 4, 4, 'Thursday', 9, 22, 21, '13:20:00', '14:00:00', NULL),
(588, 4, 4, 'Thursday', 7, 9, 29, '12:00:00', '12:40:00', NULL),
(589, 4, 4, 'Friday', 1, 10, 27, '07:40:00', '08:20:00', NULL),
(590, 4, 4, 'Friday', 2, 5, 23, '08:20:00', '09:00:00', NULL),
(591, 4, 4, 'Friday', 3, 6, 26, '09:00:00', '09:40:00', NULL),
(592, 4, 4, 'Friday', 4, 3, 25, '09:40:00', '10:20:00', NULL),
(626, 5, 5, 'Thursday', 1, 1, 31, '07:40:00', '08:20:00', NULL),
(627, 5, 5, 'Thursday', 2, 14, 25, '08:20:00', '09:00:00', 'G2'),
(628, 5, 5, 'Thursday', 2, 20, 14, '08:20:00', '09:00:00', 'G2'),
(629, 5, 5, 'Thursday', 2, 15, 34, '08:20:00', '09:00:00', 'G2'),
(630, 5, 5, 'Thursday', 3, 4, 24, '09:00:00', '09:40:00', NULL),
(631, 5, 5, 'Thursday', 3, 9, 29, '09:00:00', '09:40:00', NULL),
(632, 5, 5, 'Thursday', 4, 2, 14, '09:40:00', '10:20:00', NULL),
(633, 5, 5, 'Thursday', 5, 2, 14, '10:20:00', '11:00:00', NULL),
(634, 5, 5, 'Thursday', 6, 5, 33, '11:20:00', '12:00:00', NULL),
(635, 5, 5, 'Thursday', 7, 23, 27, '12:00:00', '12:40:00', 'G3'),
(636, 5, 5, 'Thursday', 7, 21, 21, '12:00:00', '12:40:00', 'G3'),
(637, 5, 5, 'Thursday', 8, 3, 27, '12:40:00', '13:20:00', NULL),
(638, 5, 5, 'Thursday', 9, 3, 27, '13:20:00', '14:00:00', NULL),
(639, 5, 5, 'Friday', 1, 1, 31, '07:40:00', '08:20:00', NULL),
(640, 5, 5, 'Friday', 2, 1, 31, '08:20:00', '09:00:00', NULL),
(641, 5, 5, 'Friday', 3, 4, 24, '09:00:00', '09:40:00', NULL),
(642, 5, 5, 'Friday', 3, 9, 29, '09:00:00', '09:40:00', NULL),
(643, 5, 5, 'Friday', 4, 6, 26, '09:40:00', '10:20:00', NULL),
(644, 5, 5, 'Friday', 5, 3, 27, '10:20:00', '11:00:00', NULL),
(664, 6, 6, 'Thursday', 1, 6, 26, '07:40:00', '08:20:00', NULL),
(665, 6, 6, 'Thursday', 2, 5, 33, '08:20:00', '09:00:00', NULL),
(666, 6, 6, 'Thursday', 3, 14, 25, '09:00:00', '09:40:00', 'G2'),
(667, 6, 6, 'Thursday', 3, 20, 14, '09:00:00', '09:40:00', 'G2'),
(668, 6, 6, 'Thursday', 3, 15, 34, '09:00:00', '09:40:00', 'G2'),
(669, 6, 6, 'Thursday', 4, 3, 27, '09:40:00', '10:20:00', NULL),
(670, 6, 6, 'Thursday', 5, 1, 31, '10:20:00', '11:00:00', NULL),
(673, 6, 6, 'Thursday', 8, 4, 24, '12:40:00', '13:20:00', NULL),
(674, 6, 6, 'Thursday', 8, 9, 29, '12:40:00', '13:20:00', NULL),
(675, 6, 6, 'Thursday', 9, 4, 24, '13:20:00', '14:00:00', NULL),
(676, 6, 6, 'Thursday', 9, 9, 29, '13:20:00', '14:00:00', NULL),
(677, 6, 6, 'Friday', 1, 4, 24, '07:40:00', '08:20:00', NULL),
(678, 6, 6, 'Friday', 1, 9, 29, '07:40:00', '08:20:00', NULL),
(679, 6, 6, 'Friday', 2, 6, 26, '08:20:00', '09:00:00', NULL),
(680, 6, 6, 'Friday', 3, 3, 27, '09:00:00', '09:40:00', NULL),
(681, 6, 6, 'Friday', 4, 2, 13, '09:40:00', '10:20:00', NULL),
(682, 6, 6, 'Friday', 5, 2, 13, '10:20:00', '11:00:00', NULL),
(683, 6, 6, 'Thursday', 6, 2, 13, '11:20:00', '12:00:00', NULL),
(684, 6, 6, 'Thursday', 7, 2, 13, '12:00:00', '12:40:00', NULL),
(685, 4, 4, 'Sunday', 1, 1, 5, '07:40:00', '08:20:00', NULL),
(686, 3, 3, 'Sunday', 2, 1, 5, '08:20:00', '09:00:00', NULL),
(687, 2, 2, 'Sunday', 3, 1, 5, '09:00:00', '09:40:00', NULL),
(688, 1, 1, 'Sunday', 4, 1, 5, '09:40:00', '10:20:00', NULL),
(689, 6, 6, 'Tuesday', 1, 3, 27, '07:40:00', '08:20:00', NULL),
(690, 6, 6, 'Tuesday', 2, 12, 19, '08:20:00', '09:00:00', 'G1'),
(691, 6, 6, 'Tuesday', 2, 24, 29, '08:20:00', '09:00:00', 'G1'),
(692, 6, 6, 'Tuesday', 2, 25, 34, '08:20:00', '09:00:00', 'G1'),
(693, 6, 6, 'Tuesday', 3, 1, 31, '09:00:00', '09:40:00', NULL),
(694, 6, 6, 'Tuesday', 4, 2, 13, '09:40:00', '10:20:00', NULL),
(695, 6, 6, 'Tuesday', 5, 2, 13, '10:20:00', '11:00:00', NULL),
(696, 6, 6, 'Tuesday', 6, 21, 21, '11:20:00', '12:00:00', 'G3'),
(697, 6, 6, 'Tuesday', 6, 23, 27, '11:20:00', '12:00:00', 'G3'),
(698, 6, 6, 'Tuesday', 7, 3, 27, '12:00:00', '12:40:00', NULL),
(699, 6, 6, 'Tuesday', 8, 5, 33, '12:40:00', '13:20:00', NULL),
(700, 6, 6, 'Tuesday', 9, 4, 24, '13:20:00', '14:00:00', NULL),
(701, 6, 6, 'Tuesday', 9, 9, 29, '13:20:00', '14:00:00', NULL),
(702, 6, 6, 'Wednesday', 1, 6, 26, '07:40:00', '08:20:00', NULL),
(703, 6, 6, 'Wednesday', 2, 1, 31, '08:20:00', '09:00:00', NULL),
(704, 6, 6, 'Wednesday', 3, 5, 33, '09:00:00', '09:40:00', NULL),
(705, 6, 6, 'Wednesday', 4, 1, 31, '09:40:00', '10:20:00', NULL),
(706, 6, 6, 'Wednesday', 5, 12, 19, '10:20:00', '11:00:00', 'G1'),
(707, 6, 6, 'Wednesday', 5, 24, 29, '10:20:00', '11:00:00', 'G1'),
(708, 6, 6, 'Wednesday', 5, 25, 34, '10:20:00', '11:00:00', 'G1'),
(709, 6, 6, 'Wednesday', 6, 4, 24, '11:20:00', '12:00:00', NULL),
(710, 6, 6, 'Wednesday', 6, 9, 29, '11:20:00', '12:00:00', NULL),
(711, 6, 6, 'Wednesday', 7, 21, 21, '12:00:00', '12:40:00', 'G3'),
(712, 6, 6, 'Wednesday', 7, 23, 27, '12:00:00', '12:40:00', 'G3'),
(713, 6, 6, 'Wednesday', 8, 14, 25, '12:40:00', '13:20:00', 'G2'),
(714, 6, 6, 'Wednesday', 8, 20, 14, '12:40:00', '13:20:00', 'G2'),
(715, 6, 6, 'Wednesday', 8, 15, 34, '12:40:00', '13:20:00', 'G2'),
(716, 6, 6, 'Wednesday', 9, 3, 27, '13:20:00', '14:00:00', NULL),
(717, 5, 5, 'Tuesday', 1, 1, 31, '07:40:00', '08:20:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `must_reset_password` tinyint(1) DEFAULT 1,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `must_reset_password`, `full_name`, `email`, `phone`, `status`, `created_at`) VALUES
(1, 1, 'admin', '$2y$10$u0nkFTBq1x.2XiTr2xyZY.P1aZVkEZ5k3e4/s6AVhAC0/ZujBDVf.', 0, 'Admin', NULL, NULL, 'active', '2025-11-19 06:20:08'),
(2, 2, 'S1001', '$2y$10$dZTXMTZJn9JoEwv1x/JesOhzNG1zFVf0.5my8qPZYjJy0K3EPkfAi', 1, 'AMEENA ANWARSADADH', NULL, NULL, 'active', '2025-11-19 06:43:31'),
(3, 2, 'S1002', '$2y$10$Le0AghtJLkNx3naJYCNkHe2ATKPz2CORRwdorD1iESKI.9Wwfr7v6', 1, 'HAFSA IRFAN', NULL, NULL, 'active', '2025-11-19 06:44:18'),
(4, 2, 'S1003', '$2y$10$SZPIXp4jhxDkRGQEuj2w6uVWRWhBA4snlYkTEHJXZlkG4WbVg.HLK', 1, 'HIQMA AYYOB', NULL, NULL, 'active', '2025-11-19 06:45:10'),
(5, 2, 'S1004', '$2y$10$riyWqtyGN3A4vdPM4uM21.28RBzKpR4waXz8IEpJJtiIf0eF.vFrG', 1, 'HIQMA ASHRAFKHAN', NULL, NULL, 'active', '2025-11-19 06:45:48'),
(6, 2, 'S1005', '$2y$10$1wzMWcdokRQMtn2h2vheE.0qh5BS3vvL4TumkRB178b7IssA4Zu6W', 1, 'AARA FAREED', NULL, NULL, 'active', '2025-11-19 06:47:47'),
(7, 2, 'S1006', '$2y$10$yVFzGA6v9M98e4BFq83apOxa.GATbPRBufn8PyZOzc0rXI..3QHz2', 0, 'M.A.MOHAMED ADEEB', NULL, NULL, 'active', '2025-11-19 06:48:36'),
(8, 2, 'S1007', '$2y$10$ZfBMfuFrF.waT2J3nF5fcehqJnCZCfau7ywvXm5L9JEiEqft6gzpO', 0, 'I.A AZEEF', NULL, NULL, 'active', '2025-11-19 06:49:18'),
(9, 2, 'S1008', '$2y$10$mRyMGdE.zWZOCnNxU185FOLos1VcGC7SmsvhBeK7BOZMOj1voPdnq', 0, 'M.A SHAHID', NULL, NULL, 'active', '2025-11-19 06:50:06'),
(10, 2, 'S1009', '$2y$10$xOhcV/yrlp9gSmRx9z5Oge6OKnsUwxO4ck7h06P3Ui9Bcy37C0pfu', 1, 'FATHIMA SHADAH', NULL, NULL, 'active', '2025-11-19 06:50:45'),
(11, 2, 'S1010', '$2y$10$PO1YPDCgiY5MtZR9657m3ePrb5Gofrbs6Z0J7YZSJcVOEZEECyuK.', 1, 'SHAMEEHA SAMAD', NULL, NULL, 'active', '2025-11-19 06:51:56'),
(12, 2, 'S1011', '$2y$10$nuEtb88TTHB6pECsLtE4Be48f.Lb5HEd1jjJ50Zc7MT8HCrsCOofq', 0, 'M.MOHAMED YASAR', NULL, NULL, 'active', '2025-11-19 06:53:32'),
(13, 2, 'S1012', '$2y$10$EeClEs5Q3bLpGZl1TaE.m.TmxSrdobjpyzC6BZv0R20lBWvD/56Tm', 0, 'SARA SIRAJ', NULL, NULL, 'active', '2025-11-19 06:55:23'),
(14, 2, 'S1013', '$2y$10$HTF2YJm0rRgNN5YHiQ7VqegP8HVpxbO4FEcLE.xIkHPoDIojNX8uC', 1, 'M.N.FATHIMA RIMASHA', NULL, NULL, 'active', '2025-11-19 06:56:08'),
(15, 2, 'S1014', '$2y$10$Tdevpy0LrvOTZLBea36Gp.RzPP42MooHXV/1ZhR4YWGWk7ZtSdogm', 1, 'AYSHA SHAHANI', NULL, NULL, 'active', '2025-11-19 06:57:31'),
(16, 2, 'S1015', '$2y$10$Y8tB8qXknVD43g/DWGsnTu1LSMFz7chVVVMnrWGrOc7K4xe8PaewW', 1, 'M.A.MOHAMED AMMAR', NULL, NULL, 'active', '2025-11-19 07:12:56'),
(17, 2, 'S1016', '$2y$10$NZ6GO4qrCfwWQFgSRyBwOu0o3StBHB4QefdlDdp5z9Z3OXF1a12kW', 0, 'M.F ARQAM', NULL, NULL, 'active', '2025-11-19 07:13:33'),
(18, 2, 'S1017', '$2y$10$CC.Q3OlnfT8D.KCxNZb5wO8uJlqApqHErzqrAaV6INsUbT8owm8WS', 1, 'ZAINA SHAIWAZ', NULL, NULL, 'active', '2025-11-19 07:14:13'),
(19, 2, 'S1018', '$2y$10$3HeAK9L5XaHfdBGFIXEBce.tcLoPQdkueV/M5ixa0f1SUN7UHCjzS', 1, 'AMRA RAFEEQ', NULL, NULL, 'active', '2025-11-19 07:14:49'),
(20, 2, 'S1019', '$2y$10$x4qhJ6725k2398OtPYNvNuDmE2MavgmvS.RaApq8isixcGZIGJYa2', 1, 'FATHIMA ZACKIYA', NULL, NULL, 'active', '2025-11-19 07:15:24'),
(21, 2, 'S1020', '$2y$10$NtZSaDJiks0lasXC/Zullue1rSogWePGBMOYStOzryHpNR14JvBG6', 1, 'SADHA AMEEN', NULL, NULL, 'active', '2025-11-19 07:16:02'),
(22, 2, 'S1021', '$2y$10$0VfSjMcVN1BJkvcohFBuKuwzQlaE2yJbiou1tpjhS8MoOTAnwH2yW', 1, 'M.S.FATHIMA SHAHEEMA', NULL, NULL, 'active', '2025-11-19 07:16:40'),
(23, 2, 'S1022', '$2y$10$2yEkz6Fd8vRb94BINz1bBOENX7ileVKP2aTSBQ40LsdRMddMIMwzi', 1, 'A.I. SHAFA', NULL, NULL, 'active', '2025-11-19 07:17:28'),
(24, 2, 'S1023', '$2y$10$9vg.lP79Uwez9QB4DZEELOe5VVO3wX/LCmVPzn7iOZl8Ic31v39cO', 1, 'FATHIMA SHAZRA', NULL, NULL, 'active', '2025-11-19 07:17:59'),
(25, 2, 'S1024', '$2y$10$IAWfvyb2LWQhagtYzV.z/eKCJIH4nD8gqYqs05hBN5/W7bmlePsdm', 1, 'MOHAMMED LUQMAN', NULL, NULL, 'active', '2025-11-19 07:19:25'),
(26, 2, 'S1025', '$2y$10$qeIUwc7L3fn.rpm7cuAfPu34C3khxlVMFoBg6PNDgshknunOBdsyO', 1, 'FATHIMA NOORA', NULL, NULL, 'active', '2025-11-19 07:20:12'),
(27, 2, 'S1026', '$2y$10$eVB.D80s3KFjitrIEJVReOJuIz3cirs/RNErmbxKlasiCGxUvbCru', 1, 'MOHAMMED ARAFATH', NULL, NULL, 'active', '2025-11-19 07:22:37'),
(28, 2, 'S1027', '$2y$10$h9fx4v/QBpkIC9Deg.7ZVuBh3F.hW/WDRbM.lSzlr48hzN0Qm.SjC', 1, 'DEV RUKSHAN', NULL, NULL, 'active', '2025-11-19 07:23:20'),
(29, 2, 'S1028', '$2y$10$YWvVHdPbaNtDPnAsBZi14Ot99Bj1M5wqMs6AxaG2pT3f1/ZSu3Xpa', 1, 'MOHAMMED FUHAIM', NULL, NULL, 'active', '2025-11-19 07:24:20'),
(30, 3, 'T001', '$2y$10$e7/D1zgfofWyMeALDerRg.c7jozwFPAs2MLPffy6O5Zj42zDV4ynO', 0, 'Shareeq Ahamedh', 'shareeqajward@gmail.com', NULL, 'active', '2025-11-19 08:54:39'),
(31, 2, 'S1029', '$2y$10$RzfmrxCx8y7lo8PE/5OcLuLDqQeVViT055UnSneim5du8F1WwSeli', 1, 'AYSHA SHAHANI', NULL, NULL, 'active', '2025-11-19 09:06:06'),
(32, 2, 'S1030', '$2y$10$FiQ1uIfR7QRpyhgt8oaflOcEC9khMcOGnyiXMaI6ubDpHCrtGihMu', 0, 'FATHIMA HAFSA', NULL, NULL, 'active', '2025-11-19 09:08:00'),
(33, 2, 'S1031', '$2y$10$Vzzl6ml8qF1KjDxeyUMDLeRcy30BgFB2v.zjpWDj0.cKvNn0OSRiu', 0, 'M.U.FATHIMA SALMA', NULL, NULL, 'active', '2025-11-19 09:08:58'),
(34, 2, 'S1032', '$2y$10$FDmo7fTy7akUFgbm3R3U6.txdGuYXA.be5B7ePxnzDwCe/ZeDxRNu', 0, 'M.F.FATHIMA ASHIFA', NULL, NULL, 'active', '2025-11-19 09:09:33'),
(35, 2, 'S1033', '$2y$10$EgmEAG0Oh47VLXG8PAjS2u.4rNYM/ftFRwy40Xfs5fJg/GDMkfEgu', 0, 'FATHIMA ASHRA', NULL, NULL, 'active', '2025-11-19 09:10:13'),
(37, 3, 'T006', '$2y$10$IrewlUwNSakmo.S8UTfu0O3i9NYo6I57fu9acaaDeVm0kirCICUDm', 1, 'test test', 'test@gmail.com', NULL, 'inactive', '2025-11-19 09:25:34'),
(38, 3, 'T007', '$2y$10$Jga42XYgSyvyxA9TL7GTnevX1/KyR1Zhtenm/SSnW7MoQ8nwBmptO', 0, 'Shaham Ahamed', 'shahamajward@gmail.com', NULL, 'active', '2025-11-19 09:26:31'),
(39, 3, 'T008', '$2y$10$gU9qKXb71OgmnedS3nTvwOLUFLilvmPJL9MTNawhJRn7OmS8BHxYO', 1, 'Nizam sir', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:04:19'),
(40, 3, 'T009', '$2y$10$cWkmrSaQcF6Z7a1ciKXG0.jv6cvB.SILW5InxHBYq9sxdmGRWnQ2u', 1, 'Nizvardeen sir', 'mail2scienceacademy@gmail.com', NULL, 'active', '2025-11-19 10:05:35'),
(41, 3, 'T010', '$2y$10$JpxBoZC/v1oCn65IeyddCeGulvNWKJ1Y8OkJhSEzF7e/.LCcsp8JS', 1, 'M Rifadh', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:06:30'),
(42, 3, 'T011', '$2y$10$pIYG45C0gl4gnRZ792I92eZc1cdUiz6IpALXe5dVLNCu53Dy6.k3e', 1, 'Inshaf Nizar', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:06:56'),
(43, 3, 'T012', '$2y$10$waH5Sbi5iLTac5CRngXwxec9QusGNxpjz.Mkg7U5wSkl/cxd0JpOC', 0, 'M Inam', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:09:05'),
(44, 3, 'T013', '$2y$10$cJB6J8rCIumGzFp.qQdtTOq9BjESuaasPhuArYlW/imHrSIMT8kGq', 0, 'Amal Ashraff', 'mail2scienceacademy@gmail.com', NULL, 'active', '2025-11-19 10:10:15'),
(45, 3, 'T014', '$2y$10$DlgAE.aSJWmQR6yIK.Z6yuzTGmUY0icF.XP0qt3rRCwGIhl82EuDO', 0, 'Fazrin Kamiss', 'mail2scienceacademy@gmail.com', NULL, 'active', '2025-11-19 10:13:42'),
(46, 3, 'T015', '$2y$10$O6mh7Z2eDV6URna2gvjuj.36HJ8DakLcDvdJqusrN/YemlcCk5eUS', 1, 'Salamiya Shams', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:14:40'),
(47, 3, 'T016', '$2y$10$JMossqUk5CcxsBfiSPKiGOWt32cBXGGl5SlQP0xx4RBoBVh/RTZoC', 1, 'Fathima Rabdha', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:15:27'),
(48, 3, 'T017', '$2y$10$G3T3Cn89r7v3U/3GOtw86uzg6zNh.5vWaelIR9flH1v3dxyd0MN0W', 0, 'Miska Minhaj', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:16:56'),
(49, 3, 'T018', '$2y$10$Af9gdoyJuKmOBmed9ndzW.fw7adWbfk2F1S2C3GYuAF6QsvWB6Pfm', 1, 'Abrar Ahamed', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2025-11-19 10:17:55'),
(50, 3, 'T019', '$2y$10$r.Du1sczRGI/FU9E7aybquzFMmv7xja6sX5ou0IHumt5PHnjjJ5GS', 0, 'Fathima Zeenath', 'mail2scienceacademy@gmail.com', NULL, 'active', '2025-11-19 10:19:09'),
(51, 3, 'T020', '$2y$10$oc2rBRvRrNg7TT62uP6ysuZQbzM4tWkaw5/420GgXqMWgI4AsedL2', 1, 'Imna Inthan', 'mail2scienceacademy@gmail.com', NULL, 'active', '2025-11-19 10:20:21'),
(54, 4, 'ziyard@gmail.com', '$2y$10$UtpEMaQvYOwmVQ9WzWxBfeNbdbKyK3YI4ePzT2qJN22gUMGv4Ggti', 0, 'Ziyard', 'ziyard@gmail.com', '94778535552', 'active', '2026-01-08 10:15:03'),
(55, 4, 'test2@gmail.com', '$2y$10$rF2jJoUM6Gr.WPsD0QyJd.g8E4LBiWlrx/4NzpXk.CfqVLIYeTVy.', 1, 'Test', 'test2@gmail.com', '94776994569', 'active', '2026-01-08 11:52:24'),
(56, 2, 'S1036', '$2y$10$.PiU4rK8RXZtGfSuQgTzDObcbD/oZao7PgqfqgYPJQH7fm.8Z6iMq', 0, 'Test Test', NULL, NULL, 'active', '2026-01-08 11:54:17'),
(57, 4, 'mohatheeb64@gmail.com', '$2y$10$notp5Uqc2RsB3Gri3KQV6efhGlyodG8RQnvGt1.09c1CgeR/LVUgO', 0, 'Mohamed Azwer', 'mohatheeb64@gmail.com', NULL, 'active', '2026-01-08 13:11:52'),
(58, 2, 'S1037', '$2y$10$23EnjfkKvNgV3Zhi5DTYtuGVHv2/a1cuAWK6nh2Xk5H/OIZZxnube', 0, 'M I M Muadh', NULL, NULL, 'active', '2026-01-10 08:18:45'),
(59, 2, 'S1038', '$2y$10$heK/qcqnoWjk02DSF2M0N.byYktCIhfLvvSWpsjyYoSgtT5HONGI6', 0, 'Mohammed Aaqif', NULL, NULL, 'active', '2026-01-10 08:20:28'),
(60, 2, 'S1039', '$2y$10$wVcUdpYUZunYadfWd0y4L.Us0evBG8h/NumuQH2zDagRiOQYEvX2K', 0, 'M F Abdurrahman', NULL, NULL, 'active', '2026-01-10 08:21:40'),
(61, 2, 'S1040', '$2y$10$PZfvqXiiiUCg8ykM1GFbIONcNNYMI0T0AUPGF9V0pkXA92d9EZxxO', 0, 'Fathima Rizma', NULL, NULL, 'active', '2026-01-10 08:22:20'),
(62, 2, 'S1041', '$2y$10$WGzj7ce/P2D0VE6HZAPIS.G9Irg6juNxSJN1pM50Qj5P332fZgaY2', 0, 'Fathima Arsha', NULL, NULL, 'active', '2026-01-10 08:23:01'),
(63, 2, 'S1042', '$2y$10$STZ/CspL9Wsx4PiMf8l73.gFQGA.7kV4DmKpvN9im/fVvaEJJA.e2', 0, 'M R Hamdha', NULL, NULL, 'active', '2026-01-10 08:23:46'),
(64, 2, 'S1043', '$2y$10$5L/ZLbOaaJsSjJSQkBfivO5VjeodGzLu.kOAGrkGMmzA2Yk.uG/hm', 0, 'Bilal Inshaf', NULL, NULL, 'active', '2026-01-10 09:46:51'),
(65, 2, 'S1044', '$2y$10$640jn/Ekb0lIa7.wi/jxBOafapPYUE/iLEeK7nTH8TacFFeeSK0xi', 0, 'Shamry Ahamed', NULL, NULL, 'active', '2026-01-10 09:47:50'),
(66, 2, 'S1045', '$2y$10$.fHJiiVhBxC77VyQ/H61W.G.3E8h.o0fzveeKSDnfcj0d6clm7kdW', 0, 'Nishath Nazmy', NULL, NULL, 'active', '2026-01-10 09:48:23'),
(67, 2, 'S1046', '$2y$10$Vx6AA7IqPJp6JQG4fGmyIezLwkhpxov/tCyvVfsBZ.04by90gxRqm', 0, 'Hikma Iqbal', NULL, NULL, 'active', '2026-01-10 09:49:01'),
(68, 1, 'test_admin', '$2y$10$u0nkFTBq1x.2XiTr2xyZY.P1aZVkEZ5k3e4/s6AVhAC0/ZujBDVf.', 0, 'test_admin', NULL, NULL, 'active', '2026-01-13 20:47:11'),
(69, 3, 'T021', '$2y$10$FqNRU7VHMsC5n3KzdhIIKOfpfwv9rPrQhYfUjICLT8GArX/dQSJ7O', 0, 'SANHA SHAMS', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-01-14 02:46:27'),
(70, 3, 'T022', '$2y$10$90LzIGwcdV.VRjP2mPjoru4Qtd9WVNky9zPxMgfu/0pLt..cAPpxa', 0, 'AMRA RIZVI', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2026-01-14 02:49:52'),
(71, 3, 'T023', '$2y$10$y/Is8JVeZi1LDSr6LJyANOJdVxoXOxPNHO7puLqcILFliymIUVkUW', 0, 'Amna Hanas', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-01-14 02:50:57'),
(72, 3, 'T024', '$2y$10$MJQs/YTKAysGqxvVu6T2YOWvHZbAZaMGysP6DUI8OxmYQaYLHZS9u', 0, 'Shahla Ansar', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-01-14 02:52:20'),
(73, 3, 'T025', '$2y$10$weF.DCQB4W43TKPYqEmnZeH6duuXuw6r.Z.kcWFMWAXr4RKwA1VwO', 0, 'Hikma Awzin', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-01-14 02:53:26'),
(74, 3, 'T026', '$2y$10$CE/kSOn0KMSLCTEQAqIkXu7cwUTea1Qtzv.mF8r.Zj82DDy5Lv5aq', 0, 'Maryam Ilyas', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-01-14 02:54:13'),
(75, 3, 'T027', '$2y$10$j5J09hpY3ymD/DbRNG8K3u8wbpus6aYhAcmiIzklKefgxL6MUuAFm', 0, 'Faraza Ishaq', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-01-14 02:56:08'),
(76, 2, 'S1047', '$2y$10$OTOlA5g5WT.CGj.yFKy7nud8.wW7SoifrJiA8U/RT5WulbgUHk8u6', 0, 'Shabith Nizar', NULL, NULL, 'active', '2026-01-14 05:25:26'),
(77, 4, 'hala.nazleen@gmail', '$2y$10$7gtImQV9f7wqQTNA5R88SOAXlQ1F0t.7hfoBx6Tq3MLrOM4uEl.rC', 1, 'M.A.M.Naizer', 'hala.nazleen@gmail', '94768489163', 'active', '2026-01-14 05:29:27'),
(78, 4, 'roshanazmy1979@gmail.com', '$2y$10$sHPG4xQEFdS/W9AHBOplQO21eRWVstsBRaFiskAEC/N/L6FoDTs8e', 1, 'Roshana mashoor', 'roshanazmy1979@gmail.com', NULL, 'active', '2026-01-14 06:30:51'),
(79, 2, 'S1048', '$2y$10$4GVTLGWXX8jJHt6SXjaxR.6jRDmUk2pkP3Xqs4B5GHPCq6hSwJlJG', 0, 'Yunoos Nazmy', NULL, NULL, 'active', '2026-01-14 07:00:22'),
(80, 2, 'S1049', '$2y$10$YEBHvGEOfPpdcduipc6Kw.uurbXisSR1X6q.I2HO7r8Qr3kSh8.6G', 0, 'Ibadh Fowzy', NULL, NULL, 'active', '2026-01-17 07:44:35'),
(81, 4, 'fathimasabrina72@gmail.com', '$2y$10$82j/lR8wHZO/bc6fXVM.G.chTN7fPm566AkgX9SjiqAPlkPQwkQ.W', 1, 'Fathima shabrina fowzy', 'fathimasabrina72@gmail.com', NULL, 'active', '2026-01-17 07:49:11'),
(82, 2, 'S1050', '$2y$10$v39xfJEMzCyU2ujOez34ie65Jz/b74A3X9GgVnuCzOTXMT6SbVYsC', 0, 'Nithaf Razan', NULL, NULL, 'active', '2026-01-17 07:58:04'),
(83, 3, 'T028', '$2y$10$uBPC2czYAdnORhkTExHZeeJHLoZqVBgMLtmlyCDp3RuTfSja3b7pq', 0, 'NM Majidh', 'mail2scienceacademy@gmail.com', NULL, 'inactive', '2026-01-19 03:02:17'),
(84, 2, 'S1051', '$2y$10$NFWFdI0e16N1gxI9ZDFzou2IkSIWEyAemInKJArFQGvMVP45LZMVy', 0, 'Abdhul Azeez Ajmal', NULL, NULL, 'active', '2026-01-19 03:18:46'),
(85, 4, 'Acmajmal@gmail.com', '$2y$10$guIFQqfkVU2gP3pmFXGExeMN0OdpHko/aMQeCi46n3PRTNoTc.jvy', 1, 'A.c.m.Ajmal', 'Acmajmal@gmail.com', NULL, 'active', '2026-01-19 03:20:25'),
(87, 4, 'queenfazee7789@gmail.com', '$2y$10$kfiFIBdH8ay8ZPn4mWfvU.ePBmbcPxwoK7ONX560EafHKAJO8DZ.W', 1, 'M.S.M.Ziyard', 'queenfazee7789@gmail.com', NULL, 'active', '2026-01-19 05:55:12'),
(88, 2, 'S1052', '$2y$10$.7eqDNCFdDuNsnbQXLal6edBGD23Dvjw7u92HhYgfoyw6WoTGQPma', 0, 'Hikma Shafraz', NULL, NULL, 'active', '2026-01-19 06:31:58'),
(89, 4, 'mshafraz62@gmail.com', '$2y$10$unWYUxko0v2z1.lI3SImz.a/GKjLD2ibYMk4Fn6N.B.3QAspvP3la', 1, 'Mohamed Shafraz', 'mshafraz62@gmail.com', NULL, 'active', '2026-01-19 06:33:36'),
(90, 2, 'S1054', '$2y$10$HNqJuATcj/oklGfYbUK/R.DeS9tUs.NwhUSIupFrqsgoTcNAJ4k4q', 0, 'Nuha Kayam', NULL, NULL, 'active', '2026-01-19 06:38:26'),
(91, 4, 'kayammohamed9@gmail.com', '$2y$10$OuCQtpw6/IXqHVoUO4hkheppom3hEgDexRJ3tTlWMierC/8NokZ6q', 1, 'Mohamed Kayam', 'kayammohamed9@gmail.com', NULL, 'active', '2026-01-19 06:39:57'),
(92, 2, 'S1055', '$2y$10$ouA6qf.YL7ouCxXwSUU9HOd/DfkZ.BBqBhHUv1lGeUcJ7kdd.Gq/K', 1, 'Rafah Fazal', NULL, NULL, 'active', '2026-01-19 06:41:49'),
(93, 4, 'comfadlabhulfathah@gmail.com', '$2y$10$MsRhQPoN2gaF4XluhtkOqOEjO8jNTpoJuF.nb7V6MSX.XNJawWhL6', 1, 'Fazal Mohamed', 'comfadlabhulfathah@gmail.com', NULL, 'active', '2026-01-19 06:48:13'),
(94, 2, 'S1056', '$2y$10$DwmzHonfvwLVLbYKM8P8ROYXWiJytgq7yN3Usp3TG4yuozUosihR.', 0, 'yusuf aneez', NULL, NULL, 'active', '2026-01-19 06:58:01'),
(95, 4, 'rukaiyahanees@gmail.com', '$2y$10$iUYyJPeRaSEDDLsYc7lOmOfhu5Qo6d6t8kwRE08.gvkJImeDB5.uK', 1, 'shiyana anees', 'rukaiyahanees@gmail.com', NULL, 'active', '2026-01-19 07:04:10'),
(96, 2, 'S1057', '$2y$10$vb2wVsz6/.4pJEuOVZTlUepyQst.GgThm/MnGumpcEv7f96brcWgO', 0, 'Mishal Mihlar Muhaideen', NULL, NULL, 'active', '2026-01-19 07:10:20'),
(97, 4, 'shamimihlar@gmail.com', '$2y$10$vBBa3Yhi/unrusYJ1koUOe.1rv9AYOcbwIXv5wlCwNloTwSX6Lady', 1, 'M.Mihlar Muhaideen', 'shamimihlar@gmail.com', NULL, 'active', '2026-01-19 07:12:11'),
(98, 2, 'S1058', '$2y$10$6C4vUN274iHrN31c0ckt5.PHvMiA9Vv9XhkN7bJFArdjMC6S6WbIq', 0, 'Suhaan Raseen', NULL, NULL, 'active', '2026-01-19 07:16:44'),
(99, 4, 'raseen.naz@gmail.com', '$2y$10$UrEDs1e4ES86.9lQibojeedvfNnrhYm1Bnw4MINa32r0IMI7ryazq', 1, 'Mohammed Raseen', 'raseen.naz@gmail.com', NULL, 'active', '2026-01-19 07:18:50'),
(100, 2, 'S1059', '$2y$10$KOqCZQ4wkc2P8Zxi7q72Ee9Vawn5/xE92ww1Z2FQDY5f24UqtCQrS', 0, 'Imaan Irfan', NULL, NULL, 'active', '2026-01-19 07:25:28'),
(101, 4, 'irfangampola8@gmail.com', '$2y$10$bPEJHnyk/qgvAoGiQunqBuj3lW7LW1/IcwpX1nqEUhqvKaaxq/TGe', 1, 'Mohamed Irfan', 'irfangampola8@gmail.com', NULL, 'active', '2026-01-19 07:27:16'),
(102, 2, 'S1060', '$2y$10$iVLlna02nvL0z30GgZnNPOzM3pczx6hCb.jc5.IXnK6.MDs2mZND6', 0, 'Hajara Rizvan', NULL, NULL, 'active', '2026-01-19 07:36:37'),
(103, 4, 'amrahrizann72@gmail.com', '$2y$10$ezgxXDY/081eQzJXz8eUtu.LL2S9lRYdkcWVZ/XkzdiPAIV/BA3y2', 1, 'M.T.M.Rizvan', 'amrahrizann72@gmail.com', NULL, 'active', '2026-01-19 07:38:20'),
(104, 4, 'asmathullahfaris890@gmail.com', '$2y$10$7UNcc0glOEBVjQ2HHi4rA.elOb3ka22fDnxMb4difZqt3fOQ05mEG', 1, 'S.M.Faris', 'asmathullahfaris890@gmail.com', '94779774908', 'active', '2026-01-28 04:07:46'),
(105, 4, 'rizwanaaqifmohammad@gmail.com', '$2y$10$rcws2wn7pcrbILeoRaNtre8rU8/QmshKn9G2JU6ahhZKqJRSCvN.2', 1, 'Mohamed Rizwan', 'rizwanaaqifmohammad@gmail.com', '940788882040', 'active', '2026-01-28 05:01:48'),
(106, 2, 'S1061', '$2y$10$hfHQVVJaAQTOSxbunKnn9uA91OVFKHCdPUuq1fuR/CZflR9piwIku', 0, 'Ahamed Muzain Ajmal', NULL, NULL, 'active', '2026-01-28 05:12:43'),
(107, 2, 'S1062', '$2y$10$VSnTsksa7Hsih7FIKYHQq.td66tdwhGXZe5UUssui2eGAbhSn31ei', 0, 'Umar Shaheem Irfan', NULL, NULL, 'active', '2026-01-28 05:17:12'),
(108, 4, 'mohamediqbql985723@gmail.com', '$2y$10$cuOCu1RTbSMx3GqLXDgL/uvhDsnyQb7ZtjUDj4mkeY1pHDnkBz5f2', 1, 'mohamed iqbal', 'mohamediqbql985723@gmail.com', NULL, 'active', '2026-01-28 05:26:40'),
(109, 2, 'S1063', '$2y$10$0DsPe9s/xD7qMSpqSB1FR.jzr7LoEyrhFIh9orLM4Jzr0Ro4f1y5e', 0, 'shaima Mohamed Irfan', NULL, NULL, 'active', '2026-01-28 05:29:08'),
(110, 4, 'raziyarazik1985@gmail.com', '$2y$10$1Qig9PDv0S2C2TBJPxCX/.8bgQvhwikNjbgzxZHw3mthWQ0gCUSXO', 1, 'H.M.Irfan', 'raziyarazik1985@gmail.com', NULL, 'active', '2026-01-28 05:38:17'),
(111, 2, 'S1064', '$2y$10$ROxwY/DEZpVpIPVz2C9aO.zF7/Z48vcAPTEdwM2zycC88foo32J2C', 0, 'Shara Nashath', NULL, NULL, 'active', '2026-01-28 05:43:55'),
(112, 4, 'nashath2007@gmail.com', '$2y$10$XhJ2/flsHQuZpxM5u2wiNOMuctCt38WPBLwfrbMFt08YcvSV9DOom', 1, 'Nashath', 'nashath2007@gmail.com', NULL, 'active', '2026-01-28 05:44:55'),
(113, 2, 'S1065', '$2y$10$ll7BIZa7aXHJZGIz6GM9nu4J87kgN566eFlz3jmSkskB27L4zW9nK', 0, 'HAJARA FARZAN', NULL, NULL, 'active', '2026-01-28 07:09:53'),
(114, 4, 'hamdhifarzan700@gmail.com', '$2y$10$5jOQGZ/9q8Um6QVAs8nPHOFmMQpxbXDFXtMg/hj7QUf26tBzYbO4e', 1, 'M.M.M.FARZAN', 'hamdhifarzan700@gmail.com', NULL, 'active', '2026-01-28 07:38:00'),
(115, 2, 'S1066', '$2y$10$2ZU7gZZp8/WbKMMC9d0ooetywE4WHL.pXtXttKXycfzmXZapBTswi', 0, 'Sheyma Rilwan', NULL, NULL, 'active', '2026-01-28 07:41:55'),
(116, 4, 'mohamedrilwan040@gmail.com', '$2y$10$zGQNL0fYWj6h84fq1xeMfuiW1u1tkV.r3JsKhNsrzkRqdO8qi7WxG', 1, 'M.Rilwan', 'mohamedrilwan040@gmail.com', NULL, 'active', '2026-01-28 07:45:03'),
(117, 2, 'S1067', '$2y$10$hNZUQJYaazqJsE.avB772OvFBGUVkpD8YP7DrtiuVJLHG64z2W3p.', 0, 'Reema Mohamed Jinna', NULL, NULL, 'active', '2026-02-01 05:36:12'),
(118, 4, 'bmumthaj5353@gmail.com', '$2y$10$uVIg63O4Uy4nQagH3Bwi0O3os/pGQBeE00OdldlgPhg6TlpiiWf72', 1, 'M.M.Mumthaz begum', 'bmumthaj5353@gmail.com', NULL, 'active', '2026-02-01 05:37:05'),
(119, 2, 'S1068', '$2y$10$J5k.IfldbVZqntO8rHCuy.rzrwLeFbRTlOwLNb8QzBbx.qihC4oiO', 0, 'Hikma Mohammed Kayam', NULL, NULL, 'active', '2026-02-01 05:40:18'),
(120, 4, 'kayammohomed9@gmail.com', '$2y$10$uTrK/iwPvrn725j/yvM.lORugCthLMnl6xrbe85OR53qlXGPx5rwC', 1, 'Mohammed Kayam', 'kayammohomed9@gmail.com', NULL, 'active', '2026-02-01 05:43:55'),
(121, 2, 'S1069', '$2y$10$QT8o54i3kYizoPbnNz.yv.uSPdwK0li6kiNOoKotFkbGq7i9p6v32', 0, 'fathima Zuha Mohamed Nawshard', NULL, NULL, 'active', '2026-02-01 06:14:18'),
(122, 4, 'Fahma853@gmail.com', '$2y$10$9piy5NADsM3SrYvmKBCAjeFeWZXptj2zb1Y2vEQyjHOSuItGCVX2i', 1, 'Mohamed Junaideen Fathima Rizmiya', 'Fahma853@gmail.com', '94761010477', 'active', '2026-02-01 06:20:59'),
(123, 2, 'S1070', '$2y$10$6w56Br/VOoi2T1.wt2kYN.9SWJ12GYMBAvUIhPsuA9ZoWwJ1Tdhh2', 0, 'Ahamed Mujthaba Ajmal', NULL, NULL, 'active', '2026-02-01 06:24:53'),
(124, 2, 'S1071', '$2y$10$/rV3aWKhLaEAwnkmbt/EvedZqR2Sc7GtpXa1BsVAaxBn//iCh4wGC', 0, 'Mohamed Shadhir Mohamed Munawwar', NULL, NULL, 'active', '2026-02-01 06:26:55'),
(125, 4, 'mhmdahnaaf123@gmail.com', '$2y$10$GQFxq3yx7PYDXnFjufe.6.d4E8UEimyDt8BAjsIWihH5rM.kWQtbG', 1, 'Mohammed Munawwar', 'mhmdahnaaf123@gmail.com', NULL, 'active', '2026-02-01 06:29:21'),
(126, 2, 'S1072', '$2y$10$KHmmhh1HEYv6nKt4vAwe3OTiSoKY6XKMtXtpV6Bgy.uYKPNh1JzuG', 0, 'A.KABEER HUSAIN', NULL, NULL, 'active', '2026-02-01 07:10:27'),
(127, 2, 'S1073', '$2y$10$JmODCTvR1Mxerm3TKXY4L.Rr7kX/Sm/VvmE3D6lobjGbm2cGjMC/q', 0, 'Aaqib Ehsan', NULL, NULL, 'active', '2026-02-01 07:12:03'),
(128, 2, 'S1074', '$2y$10$RLcSKFGmet939msigJ5F..MP1n/BPmaasO1IeEHvOv1135COGM1kG', 0, 'MJM Hamdhan', NULL, NULL, 'active', '2026-02-01 07:14:41'),
(129, 2, 'S1075', '$2y$10$hYiL6AUAO70LMBu.f4jgTeMJ2/IozgP/v13BPt8A/CVl1BW2eW426', 0, 'MTA Malik', NULL, NULL, 'active', '2026-02-01 07:15:28'),
(130, 2, 'S076', '$2y$10$lHWVxx2RT4v8TR4A8vpz5eom2j2ty8EeN4h2gNll/a6CM4DoB490K', 0, 'YAHYA HUSSAIN', NULL, NULL, 'active', '2026-02-01 07:15:39'),
(131, 2, 'S1076', '$2y$10$7iXciZvWpmUAzy8OW.XWveA0.xpdES5lFmHIfomBwV7YkBE6PB.0a', 0, 'MI Abdul kareem', NULL, NULL, 'active', '2026-02-01 07:16:24'),
(132, 4, 'AaqibEhsan1987@gmail.com', '$2y$10$YiGlYjxVqanoXU83qnpnxuMRhLlhVaG/irfqGMxMhwoSpZH5vcchq', 1, 'M.S.F Shafrana', 'AaqibEhsan1987@gmail.com', NULL, 'active', '2026-02-01 07:17:41'),
(133, 4, 'naseerafathima56@gmail.com', '$2y$10$NT6kkM8QfN6ehFUa3Z0DSuCkYUd/ioBc4C2OXt2KvElAznnvJzgkS', 1, 'Imran Hussain', 'naseerafathima56@gmail.com', NULL, 'active', '2026-02-01 07:19:00'),
(134, 2, 'S1078', '$2y$10$Oc2J/0VkKd2BsSdgTBPaVetBNAj.XGaFXFfTflzxCScRRDusIYcE.', 0, 'Iyaadh Ahamedh', NULL, NULL, 'active', '2026-02-01 07:22:09'),
(135, 2, 'S1079', '$2y$10$oFP/DP2U/DB.188qwhaZ1.8oLqsVaRjCcpS.1ib2XtBGtHwJ4mR7e', 0, 'Shami Shafrin', NULL, NULL, 'active', '2026-02-01 07:23:28'),
(136, 2, 'S1080', '$2y$10$bxGyaYy52xJ3SSkYmKGuqOYLz4GSTxsC591TgRdwPdGkowAUIqezq', 0, 'Arafath Hafi', NULL, NULL, 'active', '2026-02-01 07:24:37'),
(137, 3, 'T029', '$2y$10$qMh6NplkOJbthOrMzyeGDOFA6WC16SaBsLt3VZYtXLJusJ3zugAKa', 0, 'DINUSHI SAMARAKOON', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-02-02 06:51:12'),
(138, 2, 'S1081', '$2y$10$yimD9Sd0qH0Q/hs1fen.Rux2OB7vl9/jtJ0URpPLTR5YiwsvL16jq', 0, 'ARKAM RAFEEK', NULL, NULL, 'active', '2026-02-07 06:35:13'),
(139, 4, 'mohamedarkam19@gmail.com', '$2y$10$4lC5CXL.JSqC4o8I/PqN4ObL3eK8GFc0yWXyUkc4qgCfy869X694e', 1, 'Mohamed Rafeek', 'mohamedarkam19@gmail.com', '94777538046', 'active', '2026-02-07 06:36:41'),
(140, 2, 'S1082', '$2y$10$JA1arulT7LsBoTVefrIp9OkFr/juV40l6hevS/MD6AhTSI7foZU4W', 1, 'Thahani Rizmi', NULL, NULL, 'active', '2026-02-07 06:38:18'),
(141, 2, 'S1083', '$2y$10$7R4X2jk1vpglOQHoeI22qOAFpquYADujZsnnAicWTHhDS.Fz4Obkq', 0, 'MR Hamdhi', NULL, NULL, 'active', '2026-02-07 06:39:05'),
(142, 2, 'S1084', '$2y$10$QoOxufy4Y1pqYjwQuHCi4OvXSYY0lWPr0I3hHW/ZMrfT0irPzkwTK', 1, 'Hyman Zamani', NULL, NULL, 'active', '2026-02-07 06:40:09'),
(143, 2, 'S1085', '$2y$10$gGPpF2/9khgINwLEqUVijesXJxvv9RBurkYxCU37zdfZ.NvGaThrK', 0, 'Raiza Akbar', NULL, NULL, 'active', '2026-02-07 06:41:16'),
(144, 2, 'S1086', '$2y$10$yyo2wQgYmoztDw8AK1bY9udc6wDjDZbCgnCzC1V6BdHFFeMaedA5K', 1, 'Nazrina Naushad', NULL, NULL, 'active', '2026-02-07 06:42:21'),
(145, 3, 'T030', '$2y$10$Yp8XA8BEyBfSTk7HyLk2v.vQoyS1yulHN1tdX8cnXecEQ3q11rSqK', 0, 'ISHRA MAFAZ', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-02-11 05:45:00'),
(146, 2, 'S1087', '$2y$10$CKIcUCk8v1JUcSsBUBmF4e3GjntyK5DdI3VzpyyJLzBRyrvem8fze', 0, 'Halaa Naizer', NULL, NULL, 'active', '2026-02-16 05:23:30'),
(147, 2, 'S1088', '$2y$10$7mZj7H5mrHTbYar5pQpeZeI6ykweYtms7YjEXIKBG6VD1zDUOHoMy', 0, 'Izma Rilwan', NULL, NULL, 'active', '2026-02-16 05:28:59'),
(148, 2, 'S1089', '$2y$10$/WUrEptgcyNg9J6FkH94aumuivpLp91s.pyIGkeyRSGXHl6rxldQ.', 0, 'F SHADHAF ZIYARD', NULL, NULL, 'active', '2026-02-16 06:17:59'),
(151, 2, 'S1090', '$2y$10$TmlYW.J.VzYJJ0lF5wsFnO1ACZ8gZ44hH4f0Nc7A6IfJkK7B2oUPG', 0, 'Bilal Ahamed', NULL, NULL, 'active', '2026-03-09 11:30:39'),
(152, 2, 'S1093', '$2y$10$q9mkMwDMVtjFixFiLzaQeO7Y.Jx7u7K1maIIF6rhMUoig4b29Je22', 0, 'Yahya Ahamed', NULL, NULL, 'active', '2026-03-09 11:33:13'),
(153, 2, 'S1094', '$2y$10$MY0edkfcxWmXxqhd9D2JM..pvI80ABVTf/rWBO71yNa01.tjUoeEq', 1, 'Fathima farah', NULL, NULL, 'active', '2026-03-30 04:47:37'),
(154, 3, 'T031', '$2y$10$s/TvGFP1jPg5xpQIi7ge1ezGUQIJLBBCA7T66ZyYJdQDa.DtCWqAa', 0, 'Arun Jeganathan', 'jeganathanarun1105@gmail.com', NULL, 'active', '2026-04-09 04:22:12'),
(155, 2, 'S1095', '$2y$10$lmxrtiGt0UJunPaIQkwjh.eLWxrEp9NLIfUtDqVnJLPGKjhg/f83S', 1, 'asd asd', NULL, NULL, 'active', '2026-04-22 08:31:48'),
(156, 3, 'T032', '$2y$10$s0v8wgER1maKHwbH9X0pzuGWhs2HEziXelaqZ3gi2B.wQZW9yMyyK', 0, 'Nivarthana Thathsarani', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-05-05 03:42:30'),
(157, 3, 'T033', '$2y$10$w11TiWNJ2wLqaAd12/uYcexA88WZc2tWp5flG6YTpKrkbUK4Fz6GW', 0, 'Azka Ikram', 'mail2scienceacademy@gmail.com', NULL, 'active', '2026-05-06 05:41:44'),
(158, 2, 'S1096', '$2y$10$VZfyJ1nNJ/gtNo4Sq5iqFujdFO2p2FsnNovOlwwNDVh50B860raxO', 0, 'Ahnaf Rizvin', NULL, NULL, 'active', '2026-05-06 05:47:08'),
(159, 2, 'S1097', '$2y$10$3XVVgZHAdA3Kj5ffVRRte.jgU6bmZAXjDaen1tyBFWnHLZoXZrfim', 1, 'Imran Mohomad', NULL, NULL, 'active', '2026-05-06 05:53:32'),
(160, 2, 'S1098', '$2y$10$VCYjakuiQHCDYG8eiCAi3udFAZ5ScfIwwEy/aZf5cLEswBnbz8Jw.', 1, 'M.N Nabeel AHAMED', NULL, NULL, 'active', '2026-05-13 07:29:10'),
(161, 2, 'S1099', '$2y$10$Yn/zn.2hMasAFmUsR3UFwOpYSTjI8t3jyS3QBA8Yf8Qkwhf6gghe.', 0, 'Aahil Rizwin', NULL, NULL, 'active', '2026-05-14 03:49:04'),
(162, 2, 'S1100', '$2y$10$I3QoylJWLcMMVumgA7qAgO0cnrFRLAATxhzVkK8PWw6H855XY.Cny', 0, 'Katheeja Omershareef', NULL, NULL, 'active', '2026-05-14 05:33:51'),
(163, 2, 'S1101', '$2y$10$15FwlgdCvWwZcrxW5njrMOd42MWsdakdE5lacuG2Zc/wRzuSXWCvm', 0, 'Nabeel Ahamed Nister', NULL, NULL, 'active', '2026-05-14 08:08:26'),
(164, 2, 'S1102', '$2y$10$BWhIzj0lNmG2p7XbmG0go.PVXhrH7BY.rcgyu6RB0RxTy7nZ6PZ3.', 0, 'Azeez Fawaz', NULL, NULL, 'active', '2026-05-14 08:17:06'),
(165, 2, 'S1103', '$2y$10$ys9VnuBwloOOdEa.fOURP.0tI0Uqbr5C5o6SIdAaOPFnDhvsLxQby', 0, 'Imran Inam', NULL, NULL, 'active', '2026-05-14 08:22:45'),
(166, 2, 'S1104', '$2y$10$GawqH/H.wLo2PuvaTFkY.ezw5iALxuDMiaJKh73Wr0Pck5JJY2TuG', 0, 'Hamidh Ibrahim', NULL, NULL, 'active', '2026-05-14 08:26:06'),
(167, 2, 'S1105', '$2y$10$FUBLM47pDb4GOvzi4GEX/enww4QM9WA3m5NsFnUccd3Fe.JqG1DCu', 0, 'Iman Inshaf', NULL, NULL, 'active', '2026-05-15 05:54:00'),
(168, 3, 'T034', '$2y$10$KcAp0bg02eqJm8LmxC5HJeMcX4aKDeiXmJ0sxqFMZ5vZKacht9cOW', 1, 'Test Test', 'test@gmail.com', NULL, 'active', '2026-05-17 19:37:15'),
(169, 2, 'S1106', '$2y$10$i1bY7vjelTICV6fxC6FU3u2W6Tl2XjdXXZsbm3PwTDefESPLIF8CS', 0, 'Imasha Irshad', NULL, NULL, 'active', '2026-05-20 11:23:59'),
(170, 2, 'S1107', '$2y$10$bmnEU1377jZeMyKQff1GNu/6A8wouMzqV3KMBIuRyMswTrGLSLCRe', 0, 'Sarah Fahad', NULL, NULL, 'active', '2026-05-20 11:30:21'),
(171, 2, 'S1108', '$2y$10$mUbrVzKoV2tGjaE574ZReeeS6wY3/MH.OvDoAYddIEsiPrEuA0k/a', 0, 'Ishfaq Irshad', NULL, NULL, 'active', '2026-05-21 09:58:58'),
(172, 2, 'S1109', '$2y$10$55htOQu.KpsAKgCOPLV7r.6ElDJbE.JzzWBs2L.SEX2R1y2FB1.ye', 0, 'Abdul Malik Ishak', NULL, NULL, 'active', '2026-05-22 09:24:14'),
(173, 2, 'S1110', '$2y$10$XtJAAmejx09TOx98mU3CzejwiIg/wagIl3xV67RAYPKSHsp1DpO1W', 0, 'Imaad Sufiyan', NULL, NULL, 'active', '2026-05-23 12:33:12'),
(174, 2, 'S1111', '$2y$10$lUErSzpF508sqfLUlZBJf.gCbR4CWg9IFtDqe0NhoBjLNOWWM6/V2', 0, 'Hafsa Musthaq', NULL, NULL, 'active', '2026-05-23 13:01:38'),
(175, 2, 'S1112', '$2y$10$wLjq95/KzMlvPoNnOoySx.GyHKWSJOpsgH3dN1.T9UC1ibysB1prO', 0, 'Shafin Nadvi', NULL, NULL, 'active', '2026-05-25 09:07:03'),
(176, 2, 'S1113', '$2y$10$2AAXYT0kjltWXenRiIXQ8.tNqWVVnDaZqlHDZ1kKHDfVG/IKzPt0G', 0, 'Maryam Sharifdeen', NULL, NULL, 'active', '2026-06-01 10:34:15'),
(177, 2, 'S1114', '$2y$10$fDq7xn6BplWwniEurUThNOxwLCsITW3Feq1U5/onAbEdpRqNGoaMe', 0, 'Hafsa Fawas', NULL, NULL, 'active', '2026-06-08 11:14:45'),
(178, 2, 'S1115', '$2y$10$OLJGMdOoPGIyq1kbklnpYO/ohXsCU.QoL1nlbleWYCaxHrZ5hGBrW', 0, 'Rukaiya Munawfer', NULL, NULL, 'active', '2026-06-08 11:21:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_attendance` (`entity_type`,`entity_id`,`date`);

--
-- Indexes for table `attendance_details`
--
ALTER TABLE `attendance_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_id` (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `class_subject_teacher`
--
ALTER TABLE `class_subject_teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_fee_id` (`student_fee_id`);

--
-- Indexes for table `fee_types`
--
ALTER TABLE `fee_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homeworks`
--
ALTER TABLE `homeworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework_submissions`
--
ALTER TABLE `homework_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_submission` (`homework_id`,`student_id`);

--
-- Indexes for table `homework_submission_files`
--
ALTER TABLE `homework_submission_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- Indexes for table `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `house_members`
--
ALTER TABLE `house_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_member` (`entity_type`,`entity_id`);

--
-- Indexes for table `house_points`
--
ALTER TABLE `house_points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `house_id` (`house_id`,`academic_year_id`);

--
-- Indexes for table `house_point_logs`
--
ALTER TABLE `house_point_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_settings`
--
ALTER TABLE `school_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smart_announcements`
--
ALTER TABLE `smart_announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smart_audio_events`
--
ALTER TABLE `smart_audio_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admission_no` (`admission_no`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_students_class` (`class_id`),
  ADD KEY `fk_students_section` (`section_id`),
  ADD KEY `fk_parent_student` (`parent_id`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fee_type_id` (`fee_type_id`);

--
-- Indexes for table `student_of_the_week`
--
ALTER TABLE `student_of_the_week`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`);

--
-- Indexes for table `subject_notes`
--
ALTER TABLE `subject_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subject_note_files`
--
ALTER TABLE `subject_note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note_id` (`note_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_code` (`teacher_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_teacher_date` (`teacher_id`,`date`);

--
-- Indexes for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `teacher_leave_quota`
--
ALTER TABLE `teacher_leave_quota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_teacher_year` (`teacher_id`,`year`);

--
-- Indexes for table `teacher_leave_requests`
--
ALTER TABLE `teacher_leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_leave_teacher` (`teacher_id`);

--
-- Indexes for table `teacher_payments`
--
ALTER TABLE `teacher_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=765;

--
-- AUTO_INCREMENT for table `attendance_details`
--
ALTER TABLE `attendance_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_issues`
--
ALTER TABLE `book_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_subject_teacher`
--
ALTER TABLE `class_subject_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_marks`
--
ALTER TABLE `exam_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `fee_types`
--
ALTER TABLE `fee_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `homeworks`
--
ALTER TABLE `homeworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `homework_submissions`
--
ALTER TABLE `homework_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1044;

--
-- AUTO_INCREMENT for table `homework_submission_files`
--
ALTER TABLE `homework_submission_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `house_members`
--
ALTER TABLE `house_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `house_points`
--
ALTER TABLE `house_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=982;

--
-- AUTO_INCREMENT for table `house_point_logs`
--
ALTER TABLE `house_point_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=988;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `school_settings`
--
ALTER TABLE `school_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smart_announcements`
--
ALTER TABLE `smart_announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `smart_audio_events`
--
ALTER TABLE `smart_audio_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `student_of_the_week`
--
ALTER TABLE `student_of_the_week`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `subject_notes`
--
ALTER TABLE `subject_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `subject_note_files`
--
ALTER TABLE `subject_note_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teacher_leave_quota`
--
ALTER TABLE `teacher_leave_quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teacher_leave_requests`
--
ALTER TABLE `teacher_leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `teacher_payments`
--
ALTER TABLE `teacher_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=718;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_details`
--
ALTER TABLE `attendance_details`
  ADD CONSTRAINT `attendance_details_ibfk_1` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`),
  ADD CONSTRAINT `attendance_details_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD CONSTRAINT `book_issues_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `book_issues_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD CONSTRAINT `class_subjects_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `class_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `class_subject_teacher`
--
ALTER TABLE `class_subject_teacher`
  ADD CONSTRAINT `class_subject_teacher_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_subject_teacher_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_subject_teacher_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD CONSTRAINT `exam_marks_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_marks_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_marks_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_marks_ibfk_4` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_marks_ibfk_5` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `exam_results_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD CONSTRAINT `exam_subjects_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`);

--
-- Constraints for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD CONSTRAINT `fee_payments_ibfk_1` FOREIGN KEY (`student_fee_id`) REFERENCES `student_fees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `homework_submission_files`
--
ALTER TABLE `homework_submission_files`
  ADD CONSTRAINT `homework_submission_files_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `homework_submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_parent_student` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_students_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_students_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `students_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`);

--
-- Constraints for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD CONSTRAINT `student_fees_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_fees_ibfk_2` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_of_the_week`
--
ALTER TABLE `student_of_the_week`
  ADD CONSTRAINT `student_of_the_week_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `subject_notes`
--
ALTER TABLE `subject_notes`
  ADD CONSTRAINT `subject_notes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `subject_notes_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `subject_notes_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `subject_note_files`
--
ALTER TABLE `subject_note_files`
  ADD CONSTRAINT `subject_note_files_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `subject_notes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_leave_requests`
--
ALTER TABLE `teacher_leave_requests`
  ADD CONSTRAINT `fk_leave_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
