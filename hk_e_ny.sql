-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Aug 31. 00:42
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `hk_e_ny`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `birth_date` date NOT NULL,
  `phone_number` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `treatment_id` int(11) NOT NULL,
  `status` enum('booked','cancelled','completed') NOT NULL DEFAULT 'booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(42) NOT NULL,
  `country` varchar(128) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `device_type` set('phone','tablet','computer') NOT NULL,
  `proxy` tinyint(1) NOT NULL,
  `isp` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `birth_date` date NOT NULL,
  `registration_token` varchar(255) NOT NULL,
  `registration_token_expires` datetime NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `forgotten_password_token` varchar(255) NOT NULL,
  `forgotten_password_token_expires` datetime NOT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `email_notification` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `owner`
--

INSERT INTO `owner` (`owner_id`, `email`, `password`, `first_name`, `last_name`, `phone_number`, `birth_date`, `registration_token`, `registration_token_expires`, `verified`, `forgotten_password_token`, `forgotten_password_token_expires`, `is_banned`, `email_notification`) VALUES
(1, 'teszt@valami.hu', '$2y$10$Kp4aodpsl9.oiE.z3q5uE.lWSwnH3LFiSJ57SwOZgOWP0IYggcJ3a', '', '', '', '0000-00-00', 'd28bd6487895f2e0a1cf65be9e3876ae7d39c7fd300e9a2f2ca60ee3b932e658', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, 0),
(2, 'pelda@pelda.hu', '$2y$10$jcekjSgzvZD6vMkyfALv6ukzMHF7oucd4FrM9vbm6QtHxU0Yqsoqy', 'Kovács', 'János', '+36301234567', '1990-05-15', '3de9ad73846f8f14e041ac988cc2f41fb594238142e0478f4903dbd1394e133d', '2025-07-07 11:35:21', 0, '', '0000-00-00 00:00:00', 0, 0),
(3, 'pelda@pelda1.hu', '$2y$10$D0HaqRRgD9FgmvvXLjCI3uasQONuNxHHwZhNOV9SIGnbRXiJbJoMS', 'Kovács', 'János', '+36301234567', '1990-05-15', '46c3a7340738e37c7ee66dfe5b0da24af4bbff3bc0e885d2bf9a9c46e4d231c2', '2025-07-07 11:36:15', 0, '', '0000-00-00 00:00:00', 0, 0),
(4, 'pelda@pelda12.hu', '$2y$10$8RQW7emH9kmc3iIlRD8tveacix3nB/DasmCIAQjMPtQnFOI0xyuSe', 'Kovács124123123', 'János', '+36301234567', '1990-05-15', '', '0000-00-00 00:00:00', 1, '', '0000-00-00 00:00:00', 0, 0),
(5, 'pelda@peld123a.hu', '$2y$10$BEs6T6Q8INmmETGq8yOlnejMM5xMU.NXyDFcmZ0j.urDlxZjRNOPm', 'Géza', 'János', '+3630124567', '1990-05-15', '', '0000-00-00 00:00:00', 1, '', '0000-00-00 00:00:00', 0, 0),
(6, 'ujowner@pelda.hu', '$2y$10$RJklv4mgA2IEC9iJ4lolb.jyo45DVxN2UKSoiULy93RMJNqRC2T8m', 'Anna', 'Kovács', '+36201234567', '1985-08-20', '', '0000-00-00 00:00:00', 1, '', '0000-00-00 00:00:00', 0, 0),
(7, 'test1@gmail.com', '$2y$10$LkFty/N3eEPq3amLbgKKd.eUiHky/2wiIwG452ARLluYAIUvnNVea', 'Anna', 'Kovács', '+36201234567', '1985-08-20', '4e0ea3a7d695bf3ce3c448dd23069671a88034d5b13e778dd5dd818ca4f092e5', '2025-08-31 15:09:14', 1, 'b44b31d1093af3a9e95dc58e6bb5cc885ec5d9fac1f703b7b299f0f6531312a0', '2025-08-31 01:11:24', 0, 0),
(8, 'test2@gmail.com', '$2y$10$u5RI43wRrPMBqoWbZ5.hFel8opCY0PZx.6K9g/Yv954y5EbL/Jdr.', 'Test2', 'Test2', '0650975642', '2003-07-08', '', '0000-00-00 00:00:00', 1, '', '0000-00-00 00:00:00', 0, 0),
(9, 'test3@gmail.com', '$2y$10$060JDWhTGfvs.HczZTBMI.lFS.QPILhs/MVFpDuqpyAR2KhNG1Ydq', 'Test3', 'Test3', '1234567891', '2002-11-12', '', '0000-00-00 00:00:00', 1, '', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `owner_pet`
--

CREATE TABLE `owner_pet` (
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `owner_pet`
--

INSERT INTO `owner_pet` (`owner_id`, `pet_id`) VALUES
(5, 7),
(5, 8),
(6, 9);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `pet`
--

CREATE TABLE `pet` (
  `pet_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `species` varchar(50) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `gender` enum('male','female','unknown') NOT NULL DEFAULT 'unknown',
  `birth_date` date NOT NULL,
  `vet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `pet`
--

INSERT INTO `pet` (`pet_id`, `name`, `species`, `breed`, `gender`, `birth_date`, `vet_id`) VALUES
(7, 'Bajnok', 'dog', 'puli', 'male', '2021-05-01', 1),
(8, 'Bodri', 'kutya', 'golden retriever', '', '2021-05-01', 1),
(9, 'Bajnok1', 'dog', 'puli1', 'male', '2021-05-01', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `treatment`
--

CREATE TABLE `treatment` (
  `treatment_id` int(11) NOT NULL,
  `name` varchar(127) NOT NULL,
  `duration_min` int(11) NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `treatment`
--

INSERT INTO `treatment` (`treatment_id`, `name`, `duration_min`, `cost`) VALUES
(1, 'test1', 15, 2500);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vet`
--

CREATE TABLE `vet` (
  `vet_id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `birth_date` date NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `specialization` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `vet`
--

INSERT INTO `vet` (`vet_id`, `email`, `password`, `first_name`, `last_name`, `birth_date`, `phone_number`, `specialization`) VALUES
(1, 'testvet@gmail.com', 'blablabla', 'asdas', 'asdasd', '2019-07-18', '123456789', 'blabla');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vet_schedule`
--

CREATE TABLE `vet_schedule` (
  `schedule_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `weekday` tinyint(4) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_minutes` tinyint(4) NOT NULL DEFAULT 15
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `vet_schedule`
--

INSERT INTO `vet_schedule` (`schedule_id`, `vet_id`, `weekday`, `start_time`, `end_time`, `slot_minutes`) VALUES
(1, 1, 1, '09:00:00', '18:00:00', 30);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD UNIQUE KEY `uq_vet_starts_at` (`vet_id`,`starts_at`),
  ADD KEY `treatment_pet_fk` (`pet_id`),
  ADD KEY `app_treat_fk` (`treatment_id`);

--
-- A tábla indexei `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- A tábla indexei `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `owner_pet`
--
ALTER TABLE `owner_pet`
  ADD KEY `owner_op_fk` (`owner_id`),
  ADD KEY `pet_op_fk` (`pet_id`);

--
-- A tábla indexei `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `pet_vet_fk` (`vet_id`);

--
-- A tábla indexei `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`treatment_id`);

--
-- A tábla indexei `vet`
--
ALTER TABLE `vet`
  ADD PRIMARY KEY (`vet_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `vet_schedule`
--
ALTER TABLE `vet_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `vet_id` (`vet_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `pet`
--
ALTER TABLE `pet`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `treatment`
--
ALTER TABLE `treatment`
  MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `vet`
--
ALTER TABLE `vet`
  MODIFY `vet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `vet_schedule`
--
ALTER TABLE `vet_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `app_treat_fk` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`),
  ADD CONSTRAINT `treatment_pet_fk` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`),
  ADD CONSTRAINT `treatment_vet_fk` FOREIGN KEY (`vet_id`) REFERENCES `vet` (`vet_id`);

--
-- Megkötések a táblához `owner_pet`
--
ALTER TABLE `owner_pet`
  ADD CONSTRAINT `owner_op_fk` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pet_op_fk` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `pet_vet_fk` FOREIGN KEY (`vet_id`) REFERENCES `vet` (`vet_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `vet_schedule`
--
ALTER TABLE `vet_schedule`
  ADD CONSTRAINT `vet_schedule_ibfk_1` FOREIGN KEY (`vet_id`) REFERENCES `vet` (`vet_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
