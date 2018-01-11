CREATE DATABASE IF NOT EXISTS `bookDB`;
USE `bookdb`;
CREATE USER 'bookuser'@'localhost' IDENTIFIED BY 'bookpass';
GRANT ALL PRIVILEGES 
   ON `bookdb`.* 
   TO 'bookuser'@'%';
Flush Privileges;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `availability` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

INSERT INTO `book` (`id`, `title`, `author`, `price`, `rating`, `course`, `isbn`, `instructor`, `picture`, `availability`) VALUES
(1, 'CompTIA A+ Guide to 801 Managing and Troubleshooting PCs, Fourth Edition (Exam 220-801)', 'Mike Meyers', '82.95', '', 'ITAS 155', '978-0071795913', 'Theo Postulo', '/images/ITAS155.jpg', 3),
(2, 'Windows® 7 Inside Out', 'Ed Bott', '20.21', '', 'ITAS 167', '0735626650', 'John Loewen', '/images/ITAS167.jpg', 3),
(3, 'Starting Out with Java: Early Objects (4th Edition)', 'Tony Gaddis', '76.39', '', 'ITAS 185', '9780132164764', 'Mark Dutchuk', '/images/ITAS185.jpg', 3),
(4, 'Web Development and Design Fundamentals with HTML5, 6th Edition', 'Terry Ann Felke-Morris', '55.99', '', 'ITAS 191', '0132783398', 'David Grant', '/images/ITAS191.jpg', 3),
(5, 'Security+ Guide to Network Security Fundamentals, Fourth Edition', 'Mark Ciampa', '91.98', '', 'ITAS 218', '9781111640125', 'John Loewen', '/images/ITAS218.jpg', 3),
(6, 'MCITP Guide to Microsoft® Windows Server 2008 Administration, Exam #70-646, 1st Edition', 'Michael Palmer', '108.48', '', 'ITAS 233', '9781423902386', 'John Loewen', '/images/ITAS233.jpg', 3),
(7, 'Linux Apache Web Server Administration', 'Charles Aulds', '49.80', '', 'ITAS 257 ', '9780782127348', 'Mark Dutchuk', '/images/ITAS257.jpg', 3),
(8, 'PHP 5 MySQL Programming for the Absolute Beginner', 'Andy Harris', '141.90', '', 'ITAS 255', '9781423902362', 'Mark Dutchuk', '/images/ITAS255.jpg', 3),
(9, 'New Perspectives on Mictosoft Project 2010: Introductory', 'Biheller Bunin', '111.95', '', 'ITAS 164', '9780538746762', 'John Loewen', '/images/ITAS164.jpg', 3),
(10, 'Network+ Guide to Networks - 5th edition', 'Tamara Dean', '71.56', '', 'ITAS 175', '9780619217433', 'John Loewen', '/images/ITAS175.jpg', 3),
(11, ' Linux+ Guide to Linux Certification – 3rd Edition', 'Jason Eckert', '85.95', '', 'ITAS 181', '9781418837211', 'Mark Dutchuk', '/images/ITAS181.jpg', 3),
(12, 'PHP and MySQL Web Development, 4rth Edition\r\n', 'Luke Welling', '54.99', '', 'ITAS 186', '0672329166', 'Dave Croft', '/images/ITAS186.jpg', 3),
(13, 'Android™ Wireless Application Development, Volume 1: Android Essentials, Third Edition', 'Lauren Darcey', '44.99', '', 'ITAS 274', '9780321813831', 'Mark Dutchuk', '/images/ITAS274.jpg', 3),
(14, 'The Accidental Administrator: Linux Server Configuration Guide', 'Don R Crawley', '40.00', '', 'ITAS 278', '9781453689929', 'Mark Dutchuk', '/images/ITAS278.jpg', 3),
(15, 'Microsoft® SharePoint® 2010: Creating and Implementing Real-World Projects, 1st Edition', 'Jennifer Mason', '29.24', '', 'ITAS 280', '9780735662827', 'John Loewen', '/images/ITAS280.jpg', 3),
(16, 'Modern Database Management – 10th Edition', 'Jeffrey A. Hoffer', '26.60', '', 'ITAS 288', '9780136088394', 'Mark Dutchuk', '/images/ITAS288.jpg', 3);

CREATE TABLE `user` (id INT NOT NULL AUTO_INCREMENT, username VARCHAR(20) NOT NULL, password VARCHAR(120) NOT NULL, email VARCHAR(40) NOT NULL, PRIMARY KEY (id));
CREATE TABLE rate (id TINYINT NOT NULL AUTO_INCREMENT, bookid TINYINT NOT NULL, userid VARCHAR(500) NOT NULL, PRIMARY KEY (id));

INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
INSERT INTO bookdb.rate (rating, userid) 
	VALUES ('0', 'id0');
	
CREATE TABLE `cart` (id INT NOT NULL AUTO_INCREMENT, bookid INT NOT NULL, userid INT NOT NULL, PRIMARY KEY (id));