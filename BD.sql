/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.30-MariaDB : Database - placetopaytest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`placetopaytest` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `placetopaytest`;

/*Table structure for table `paymentlistproccess` */

DROP TABLE IF EXISTS `paymentlistproccess`;

CREATE TABLE `paymentlistproccess` (
  `codpayment` int(11) NOT NULL AUTO_INCREMENT COMMENT 'value for incremeting row',
  `requestId` int(20) DEFAULT NULL COMMENT 'requestId gain by API response',
  `referenceValue` varchar(100) DEFAULT NULL COMMENT 'this value may have not importance in database',
  `status` varchar(10) DEFAULT NULL COMMENT 'request payment status',
  `processUrl` varchar(200) DEFAULT NULL COMMENT 'process url to go when request is still active',
  PRIMARY KEY (`codpayment`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `paymentlistproccess` */

insert  into `paymentlistproccess`(`codpayment`,`requestId`,`referenceValue`,`status`,`processUrl`) values (1,189252,'randomvalue',NULL,NULL),(2,189253,'IpDEyliWwhjaY',NULL,NULL),(3,189254,'randomvalue',NULL,NULL),(4,189267,'HFfC6MxkyVcas',NULL,NULL),(5,189270,'GgyhnjoE8pWnG',NULL,'https://test.placetopay.com/redirection/session/189270/cd33888d087864e8e4075e5b0ea2f613');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
