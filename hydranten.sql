-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: whemper.store.d0m.de:3779
-- Erstellungszeit: 22. Okt 2019 um 11:41
-- Server-Version: 5.6.42-log
-- PHP-Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `DB3923699`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hydranten`
--

CREATE TABLE `hydranten` (
  `id` int(11) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `groesse` varchar(50) NOT NULL,
  `bemerkung` text NOT NULL,
  `zeitstempel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `hydranten`
--

INSERT INTO `hydranten` (`id`, `lat`, `lon`, `groesse`, `bemerkung`, `zeitstempel`) VALUES
(1, 49.2645, 8.13734, '100', 'Auf dem Hof der Feuerwehr Edesheim.', '2019-10-22 09:40:48');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `hydranten`
--
ALTER TABLE `hydranten`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `hydranten`
--
ALTER TABLE `hydranten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
