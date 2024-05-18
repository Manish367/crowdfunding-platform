CREATE DATABASE IF NOT EXISTS fundraiser;
USE fundraiser;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: fundraiser
--

-- --------------------------------------------------------

--
-- Table structure for table Admin
--

CREATE TABLE Admin (
  AdminId int(11),
  Username varchar(20) CHARACTER SET latin1 NOT NULL,
  Password varchar(250) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (AdminId)
);

--
-- Dumping data for table Admin
--

INSERT INTO Admin (AdminId, Username, Password) VALUES
  (1, 'admin', '$2y$10$N3szkYgApyWeN7esBtbyO.0PZshaqST.sJqqgYM5BrRuhK5zWYSle');

-- --------------------------------------------------------

--
-- Table structure for table Donors
--

CREATE TABLE Donors (
  DonorEmail varchar(100),
  PRIMARY KEY (DonorEmail)
);

--
-- Dumping data for table Donors
--

INSERT INTO Donors (DonorEmail) VALUES
('jimjones@xtra.co.nz'),
('j.lo@gmail.com'),
('bokbokyall@hotmail.com'),
('p.pohatu@orcon.co.nz'),
('lizjoseph@gmail.com'),
('sarahknowles32@gmail.com'),
('gmoses@dia.govt.nz'),
('test1@test.co'),
('cate@friend.gc'),
('test2@test.co'),
('timmysmom@extra.co.nz'),
('j@jk.wsd'),
('teacher@test.com'),
('timmy@timmy.tim'),
('email@email.me');

-- --------------------------------------------------------

--
-- Table structure for table Fundraiser
--

CREATE TABLE Fundraiser (
  FundraiserId smallint(6) AUTO_INCREMENT,
  FName varchar(30) NOT NULL,
  LName varchar(30) NOT NULL,
  DoB date NOT NULL,
  Email varchar(255) NOT NULL,
  Password char(60) NOT NULL,
  Charity varchar(50) NOT NULL,
  Blurb varchar(250) NOT NULL,
  Goal smallint(6) NOT NULL,
  PRIMARY KEY (FundraiserId)
);

--
-- Dumping data for table Fundraiser
--

INSERT INTO Fundraiser (FundraiserId, FName, LName, DoB, Email, Password, Charity, Blurb, Goal) VALUES
(1, 'Sam', 'Smith', '1999-06-14', 'sammy@gmail.com', '$2y$10$LeuV3KYopcLiNzOPZUvuQ.5N6k2o/3BjpwH3X1VwmxsAoFV/McYFe', 'Kids Can', 'Please support me as I raise funds for kids can. They&#39;re really cool and I think they deserve our help!', 250),
(2, 'Mike', 'Pohuta', '2005-10-22', 'likeastone@gmail.com', '$2y$10$2pUZp292dgVymUmAdiNzReNl4KM11aCpcMiPq1gVJmCt/giWrmw3e', 'World Vision', 'I want to raise as much as I can this year for World Vision. I&#39;ve been to India and saw one of their child labour projects. Amazing', 750),
(3, 'Adele', 'Emmot', '2002-07-09', 'emmotfamily@gmail.com', '$2y$10$YnCM7YfxkC46F1FhVsh.EufEX/h6HiHwHcLu.lbnP1O2y0lrhiDEe', 'Woman&#39;s Refuge', 'I volunteer here with some amazing people. Please help us raise money for a new freezer to store food in. Or check out their website and volunteer like me', 500),
(4, 'Tim', 'Luck', '1995-06-16', 'timluck@extra.co.nz', '$2y$10$YOriFkizxlROlkEwcoFjWuzAfo1dv6K0hcQN9XGhuMv6ooV2IQ8..', 'Timmy', 'Timmy would like some money please', 500);

-- --------------------------------------------------------

--
-- Table structure for table Pledges
--

CREATE TABLE Pledges (
  DonationId mediumint(6) AUTO_INCREMENT NOT NULL,
  DonorEmail varchar(100) NOT NULL,
  FundraiserId smallint(6) NOT NULL,
  Pledge smallint(6) NOT NULL,
  DisplayName varchar(30) NOT NULL,
  PRIMARY KEY (DonationId),
  FOREIGN KEY (DonorEmail) REFERENCES Donors (DonorEmail) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (FundraiserId) REFERENCES Fundraiser (FundraiserId) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Dumping data for table Pledges
--

INSERT INTO Pledges (DonationId, DonorEmail, FundraiserId, Pledge, DisplayName) VALUES
(1, 'jimjones@xtra.co.nz', 1, 10, 'Jim Jones'),
(2, 'j.lo@gmail.com', 1, 20, 'Jill Lopez'),
(3, 'bokbokyall@hotmail.com', 1, 25, 'Brook Lin'),
(4, 'p.pohatu@orcon.co.nz', 2, 40, 'Piripi Pohatu'),
(5, 'lizjoseph@gmail.com', 2, 30, 'Elizabeth Joseph'),
(6, 'sarahknowles32@gmail.com', 2, 10, 'Sarah Knowles'),
(7, 'gmoses@dia.govt.nz', 3, 100, 'Gary Moses'),
(8, 'test1@test.co', 1, 20, 'Test 1'),
(9, 'jimjones@xtra.co.nz', 1, 5, 'test 2.0'),
(10, 'cate@friend.gc', 1, 5, 'Spog'),
(11, 'test2@test.co', 1, 6, 'Test 3'),
(12, 'timmysmom@extra.co.nz', 4, 1000, 'Timmys Mom'),
(13, 'j@jk.wsd', 1, 111, 'test 2.0'),
(14, 'teacher@test.com', 2, 45, 'Teacher Test'),
(15, 'p.pohatu@orcon.co.nz', 3, 20, 'pohatu'),
(16, 'email@email.me', 3, 5, 'Hello'),
(17, 'email@email.me', 3, 5, 'Hello 2');

-- --------------------------------------------------------

-- AUTO_INCREMENT for table Admin
--
ALTER TABLE Admin
  MODIFY AdminId int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table Pledges
--
ALTER TABLE Pledges
  MODIFY DonationId mediumint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table Fundraiser
--
ALTER TABLE Fundraiser
  MODIFY FundraiserId smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- DATABASE USERS
--
CREATE USER 'public'@'%' IDENTIFIED WITH mysql_native_password BY 'change-me';
GRANT SELECT ON fundraiser.* TO 'public'@'%';

CREATE USER 'admin'@'%' IDENTIFIED WITH mysql_native_password BY 'change-me1';
GRANT ALL PRIVILEGES ON fundraiser.* TO 'admin'@'%';

FLUSH PRIVILEGES;