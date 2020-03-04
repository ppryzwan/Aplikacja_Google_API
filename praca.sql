-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Maj 2019, 15:53
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `praca`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projekt`
--

CREATE TABLE `projekt` (
  `ID_Projektu` int(11) NOT NULL,
  `Nazwa_Projektu` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `Data_Rozpoczecia_Projektu` datetime NOT NULL,
  `Data_Zakonczenia_Projektu` datetime DEFAULT NULL,
  `Link_Dysk_Google` varchar(400) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `projekt`
--

INSERT INTO `projekt` (`ID_Projektu`, `Nazwa_Projektu`, `Data_Rozpoczecia_Projektu`, `Data_Zakonczenia_Projektu`, `Link_Dysk_Google`) VALUES
(1, 'Projekt XYZ', '2018-11-24 00:00:00', '2019-04-27 15:39:00', 'null'),
(3, 'XYZE', '2018-11-25 00:00:00', NULL, 'null'),
(4, 'XYZF', '2018-11-29 00:00:00', NULL, 'null'),
(5, 'Example Project', '2019-04-18 10:22:00', NULL, 'null');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projekty_uzytkownicy`
--

CREATE TABLE `projekty_uzytkownicy` (
  `ID_PU` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `ID_Projektu` int(11) NOT NULL,
  `Uprawnienia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `projekty_uzytkownicy`
--

INSERT INTO `projekty_uzytkownicy` (`ID_PU`, `ID_Uzytkownika`, `ID_Projektu`, `Uprawnienia`) VALUES
(2, 2, 3, 1),
(3, 3, 2, 0),
(36, 4, 3, 0),
(37, 2, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID_Uzytkownika` int(11) NOT NULL,
  `Imie` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `Poziom_Uprawnien` int(11) NOT NULL,
  `Login` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `Haslo` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `Email` varchar(60) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_Uzytkownika`, `Imie`, `Nazwisko`, `Poziom_Uprawnien`, `Login`, `Haslo`, `Email`) VALUES
(1, 'Admin', 'Admin', 3, 'Admin', 'e3afed0047b08059d0fada10f400c1e5', 'admin@gmail.copm'),
(2, 'Jan ', 'Kowalski', 2, 'Test', '0cbc6611f5540bd0809a388dc95a615b', 'Test@gmail.com'),
(3, 'Katarzyna', 'Orzeszek', 1, 'Pracownik_1', '2eb35b3557167494775680c496e66030', 'kasia.orzeszek@gmail.com'),
(4, 'Marian', 'Papat', 1, 'Example', '0a52730597fb4ffa01fc117d9e71e3a9', 'pawel.pryzwan@edu.uekat.pl'),
(5, 'Patryk', 'Bolewicz', 1, 'asdasdsaadasdsadsa', '476ffaf9ca80d80f160d375cbd41101b', 'patryk.bolewicz@gmail.com'),
(6, 'Michał', 'Lipa', 1, 'Pracownik_Testowy', '4c7e3e09d7cdfb205c99a155403c021d', 'm.lipa@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania`
--

CREATE TABLE `zadania` (
  `ID_Zadania` int(11) NOT NULL,
  `Nazwa_Zadania` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zadania`
--

INSERT INTO `zadania` (`ID_Zadania`, `Nazwa_Zadania`) VALUES
(1, 'Stworzenie Modułu 1'),
(2, 'Stworzenie Modułu 2'),
(3, 'Stworzenie Dokumentacji'),
(4, 'Stworzenie Klasy'),
(5, 'Spisanie Danych Osobowych'),
(9, 'Stworzenie Front-End');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania_uzytkownicy`
--

CREATE TABLE `zadania_uzytkownicy` (
  `ID_ZadUzy` int(11) NOT NULL,
  `ID_Projektu` int(11) NOT NULL,
  `ID_Zadania` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Data_Rozpoczecia_Zadania` date NOT NULL,
  `Data_Zakonczenia_Zadania` date DEFAULT NULL,
  `Wykonane_Zadanie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zadania_uzytkownicy`
--

INSERT INTO `zadania_uzytkownicy` (`ID_ZadUzy`, `ID_Projektu`, `ID_Zadania`, `ID_Uzytkownika`, `Data_Rozpoczecia_Zadania`, `Data_Zakonczenia_Zadania`, `Wykonane_Zadanie`) VALUES
(1, 3, 2, 3, '2019-04-09', '2019-04-27', 1),
(2, 3, 1, 2, '2019-04-09', '2019-04-10', 1),
(3, 3, 3, 3, '2019-04-09', '2019-04-27', 1),
(4, 3, 1, 3, '2019-04-28', '2019-04-27', 1),
(5, 3, 2, 2, '2019-04-27', '2019-04-27', 1),
(8, 3, 4, 4, '2019-04-28', '2019-05-09', 1),
(9, 3, 4, 3, '2019-04-28', '2019-05-02', 1),
(10, 32, 1, 3, '2019-04-09', '2019-04-27', 1),
(12, 33, 8, 4, '2019-04-30', NULL, 0),
(13, 33, 7, 6, '2019-04-29', '2019-05-06', 1),
(14, 3, 9, 6, '2019-05-10', '2019-05-02', 1),
(15, 3, 9, 5, '2019-05-10', NULL, 0),
(16, 3, 4, 2, '2019-05-10', NULL, 0),
(17, 3, 3, 2, '2019-05-10', NULL, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdarzenia`
--

CREATE TABLE `zdarzenia` (
  `ID_Zdarzenia` int(11) NOT NULL,
  `Nazwa_Zdarzenia` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `ID_Projektu` int(11) NOT NULL,
  `Data_Zdarzenia` datetime NOT NULL,
  `Przewidywany_Czas` int(11) NOT NULL,
  `LatAtt` double NOT NULL,
  `LongAtt` double NOT NULL,
  `Adres_Google` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdarzenia`
--

INSERT INTO `zdarzenia` (`ID_Zdarzenia`, `Nazwa_Zdarzenia`, `ID_Projektu`, `Data_Zdarzenia`, `Przewidywany_Czas`, `LatAtt`, `LongAtt`, `Adres_Google`) VALUES
(1, 'Spotkanie Organizacyjne', 3, '2019-04-30 08:24:00', 2, 50.3208558, 18.884225, 'Bytomska 2, Ruda Śląska'),
(2, 'Pizza Firmowa', 3, '2019-05-25 12:12:00', 2, 50.3222682, 18.883600800000067, 'Fojkisa 5A, Ruda Śląska, Polska'),
(3, 'Spotkanie Służbowe', 3, '2019-05-26 12:12:00', 4, 52.3991728, 16.96340520000001, 'Katowicka 23, Poznań, Polska'),
(4, 'Spotkanie z firmą XYZ', 3, '2019-05-09 12:12:00', 2, 50.3054332, 18.9481399, 'Plac Mickiewicza, Chorzów, Polska'),
(5, 'Daily Scrum', 3, '2019-05-09 12:12:00', 3, 52.39649470000001, 16.964221700000053, 'Katowicka 50, Poznań, Polska');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `projekt`
--
ALTER TABLE `projekt`
  ADD PRIMARY KEY (`ID_Projektu`);

--
-- Indeksy dla tabeli `projekty_uzytkownicy`
--
ALTER TABLE `projekty_uzytkownicy`
  ADD PRIMARY KEY (`ID_PU`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID_Uzytkownika`);

--
-- Indeksy dla tabeli `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`ID_Zadania`);

--
-- Indeksy dla tabeli `zadania_uzytkownicy`
--
ALTER TABLE `zadania_uzytkownicy`
  ADD PRIMARY KEY (`ID_ZadUzy`);

--
-- Indeksy dla tabeli `zdarzenia`
--
ALTER TABLE `zdarzenia`
  ADD PRIMARY KEY (`ID_Zdarzenia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `projekt`
--
ALTER TABLE `projekt`
  MODIFY `ID_Projektu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `projekty_uzytkownicy`
--
ALTER TABLE `projekty_uzytkownicy`
  MODIFY `ID_PU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_Uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `zadania`
--
ALTER TABLE `zadania`
  MODIFY `ID_Zadania` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `zadania_uzytkownicy`
--
ALTER TABLE `zadania_uzytkownicy`
  MODIFY `ID_ZadUzy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `zdarzenia`
--
ALTER TABLE `zdarzenia`
  MODIFY `ID_Zdarzenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
