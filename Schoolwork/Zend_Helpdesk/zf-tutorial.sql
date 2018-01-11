/*
SQLyog Community v11.0 Beta1 (64 bit)
MySQL - 5.6.12-log : Database - zf-helpdesk
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zf-helpdesk` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `zf-helpdesk`;

/*Table structure for table `account_type` */

DROP TABLE IF EXISTS `account_type`;

CREATE TABLE `account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) DEFAULT NULL,
  `enabled` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `account_type` */

insert  into `account_type`(`id`,`description`,`enabled`) values (1,'administrator',0),(2,'Technician',0),(3,'Student',0),(4,'Instructor',0),(5,'spare',1),(6,'police',0),(7,'bob',1),(8,'1234',1);

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `description` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`id`,`description`) values (1,'software'),(2,'monitor'),(3,'printer'),(4,'internet'),(5,'wireless');

/*Table structure for table `priority` */

DROP TABLE IF EXISTS `priority`;

CREATE TABLE `priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `priority` */

insert  into `priority`(`id`,`description`) values (1,'Nonessential'),(2,'Mild'),(3,'Moderate'),(4,'Urgent'),(5,'Severe');

/*Table structure for table `request` */

DROP TABLE IF EXISTS `request`;

CREATE TABLE `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_in` datetime NOT NULL,
  `originator_id` int(3) NOT NULL,
  `assigned_to_id` int(3) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` text,
  `comments` text,
  `date_out` datetime DEFAULT NULL,
  `priority` int(1) DEFAULT NULL,
  `status_id` int(3) DEFAULT NULL,
  `category` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `request` */

insert  into `request`(`id`,`date_in`,`originator_id`,`assigned_to_id`,`subject`,`description`,`comments`,`date_out`,`priority`,`status_id`,`category`) values (2,'2013-11-16 10:57:54',3,2,'aba','aba','bba','2014-11-16 10:57:54',4,2,0),(3,'2013-11-16 14:47:46',3,4,'aa','aa','bleh','0000-00-00 00:00:00',3,3,3),(4,'2013-11-16 15:27:49',3,4,'ab','ab','','2013-12-04 17:31:08',3,3,0),(5,'2013-11-16 16:19:35',3,4,'s','sas','','0000-00-00 00:00:00',3,1,0),(7,'2013-11-16 21:43:59',3,2,'aaaa','aaa','','0000-00-00 00:00:00',3,3,0),(8,'2013-11-16 21:46:13',3,4,'b','b','awe','0000-00-00 00:00:00',3,1,29),(10,'2013-11-29 15:51:06',2,1,'q','q','','0000-00-00 00:00:00',3,1,21),(11,'2013-11-29 16:25:36',3,4,'qq','qq','','0000-00-00 00:00:00',3,2,31);

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) DEFAULT NULL,
  `enabled` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `status` */

insert  into `status`(`id`,`description`,`enabled`) values (1,'new',0),(2,'in progress',0),(3,'completed',0),(4,'cancelled',0),(5,'on hold',0),(6,'bob',1),(7,'sss',1);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(42) DEFAULT NULL,
  `username` varchar(42) DEFAULT NULL,
  `password` varchar(42) DEFAULT NULL,
  `account_type_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`full_name`,`username`,`password`,`account_type_id`) values (1,'unassigned','unassigned','i',1),(2,'admin','admin','21232f297a57a5a743894a0e4a801fc3',1),(3,'a a','a','0cc175b9c0f1b6a831c399e269772661',4),(4,'tech','tech','d9f9133fb120cd6096870bc2b496805b',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
