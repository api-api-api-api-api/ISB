/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.4.18-MariaDB : Database - tripleadb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `tripleadb`;

/*Table structure for table `groups` */

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `namaGroup` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `groups` */

insert  into `groups`(`ID`,`namaGroup`) values 
(1,'ADMIN2'),
(2,'SALESMAN'),
(3,'ADMIN CABANG'),
(4,'dfdasfdasf'),
(5,'fdasfds'),
(6,'fdafdsf'),
(7,'fdasfdsfsa'),
(8,'SALESMAN'),
(12,'fdafdsf');

/*Table structure for table `kantorcabang` */

CREATE TABLE `kantorcabang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `kodecabang` varchar(10) DEFAULT NULL,
  `kontakPerson` varchar(50) DEFAULT NULL,
  `kantorCabangId` varchar(100) DEFAULT NULL,
  UNIQUE KEY `kantorcabang_x` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `kantorcabang` */

insert  into `kantorcabang`(`id`,`nama`,`alamat`,`kota`,`kodecabang`,`kontakPerson`,`kantorCabangId`) values 
(1,'semarang','semarang','semarang','smg','lilik',NULL),
(2,'surabaya','surabaya','surabaya','sby','evi',NULL),
(3,'jakarta1','jakarta1','jakarta1','jk1','djati',NULL),
(4,'bandung','bandung','bandung','bdg','indra c',NULL),
(5,'medan','medan','medan','mdn','chrisma',NULL),
(6,'makasar','makasar','makasar','mks','jefri',NULL),
(7,'padang','padang','padang','pdg','robianto',NULL),
(8,'samarinda','kaltim','samarinda','smd','vacant',NULL),
(9,'lampung','lampung','lampung','lpg','fandri',NULL),
(10,'palembang','palembang','palembang','plb','pether',NULL),
(11,'pekanbaru','pekanbaru','pekanbaru','pkb','ogi w',NULL),
(12,'denpasar','denpasar','denpasar','dps','erick',NULL),
(13,'balikpapan','Kaltim','balikpapan','blp','arco blp',NULL),
(14,'banjarmasin','Kalsel','banjarmasin','bjm','bobby',NULL),
(15,'jakarta2','jakarta2','jakarta2','jk2','x',NULL),
(16,'jakarta3','jakarta3','jakarta3','jk3','fedri k',NULL),
(17,'jakarta4','jakarta4','jakarta4','jk4','michael',NULL),
(18,'jambi','jambi','jambi','jmb','frans',NULL),
(19,'malang','malang','malang','mlg','michael',NULL),
(20,'pontianak','Kalbar','pontianak','pnk','suryanto',NULL),
(21,'yogya','yogya','yogya','ygy','candra',NULL),
(22,'resign',NULL,NULL,NULL,NULL,NULL),
(23,'pusat','jakarta','jakarta','pst',NULL,NULL),
(24,'cirebon','cirebon','cirebon','crb','wilson',NULL),
(26,'transisi','transisi','transisi',NULL,NULL,NULL),
(27,'batam','batam','batam','batam','pramita',NULL),
(28,'manado','manado','manado','mdo','lucius erick',NULL),
(29,'palangkaraya','kalteng','palangkaraya','plkr',NULL,NULL),
(30,'papua','papua','papua','papua','irwin lewa',NULL),
(31,'solo','solo','solo','solo','afandi',NULL),
(32,'kediri','kediri','kediri','kdr','david sanjaya',NULL),
(33,'aceh','aceh','aceh','aceh','chrisma',NULL),
(34,'bogor','bogor','bogor','bgr','dennis',NULL),
(35,'tangerang','tangerang','tangerang','tgr','steven',NULL),
(36,'bukittinggi','bukittinggi','bukittinggi','bkt','suryanto',NULL),
(37,'babel','pangkalpinang','pangkalpinang','babel',NULL,NULL),
(38,'karawang','karawang','karawang','krw','firdhian',NULL),
(39,'merauke1','merauke1','merauke1','mke','merauke1',NULL),
(40,'abc1','1abc','1abc','abc1','abc1',NULL),
(41,'bca1','bca1','1bca','bca','bca1',NULL),
(42,'sample','sample1','sample1','sample1','sample12','101'),
(43,'testedit','testedit','testedit','testedit','testedit','102'),
(44,'test2','test2','test2','test2','test2','103');

/*Table structure for table `principals` */

CREATE TABLE `principals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kodePrincipal` varchar(50) DEFAULT NULL,
  `namaPrincipal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `principals` */

insert  into `principals`(`id`,`kodePrincipal`,`namaPrincipal`) values 
(1,'BRN','BERNOFARM'),
(2,'KLB','KALBE FARMA'),
(3,'PHP','PHAPROS');

/*Table structure for table `users` */

CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `namaUser` varchar(255) DEFAULT NULL,
  `pword` varchar(255) DEFAULT NULL,
  `groupId` int(11) DEFAULT NULL,
  `statusLog` varchar(255) DEFAULT NULL,
  `idUser` varchar(255) DEFAULT NULL,
  `penanggungJawab` varchar(225) DEFAULT NULL,
  `keterangan` varchar(225) DEFAULT NULL,
  `pejabatId` varchar(10) DEFAULT NULL,
  `perusahaanId` int(11) DEFAULT NULL,
  `divisi` varchar(20) DEFAULT NULL,
  `comId` int(11) DEFAULT NULL,
  `arcoId` varchar(11) DEFAULT NULL,
  `subDivisi` varchar(15) DEFAULT NULL,
  `reg` varchar(10) DEFAULT NULL,
  `inisial` varchar(10) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `namaKary` varchar(255) DEFAULT NULL,
  `tglLahir` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `groupid` (`groupId`),
  KEY `idUser` (`idUser`),
  KEY `login` (`namaUser`,`pword`),
  KEY `groupId_2` (`groupId`,`comId`),
  KEY `penanggungJawab` (`penanggungJawab`),
  KEY `pejabatId` (`pejabatId`),
  KEY `groupId_3` (`groupId`,`divisi`,`namaUser`,`pword`),
  KEY `divisi` (`divisi`),
  KEY `pejabatPJwb` (`penanggungJawab`,`pejabatId`)
) ENGINE=InnoDB AUTO_INCREMENT=748 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`ID`,`namaUser`,`pword`,`groupId`,`statusLog`,`idUser`,`penanggungJawab`,`keterangan`,`pejabatId`,`perusahaanId`,`divisi`,`comId`,`arcoId`,`subDivisi`,`reg`,`inisial`,`nik`,`namaKary`,`tglLahir`) values 
(1,'admin','edp12345',1,NULL,'1','administrator','','',1,'',NULL,NULL,'','Y',NULL,NULL,NULL,NULL),
(738,'sales1','12345',2,NULL,NULL,'sales 1 ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(739,'admincbg','12345',3,'','','admin cabang','','',1,'',1,'','','Y','',NULL,NULL,NULL),
(740,'sales2','12345',2,'','1','sales jakarta','','',1,'',3,'','','','',NULL,NULL,NULL),
(741,'agus','agus123',2,'true','1','Agus','agus','1',1,'1',33,'1','1','Y','1','12345','agus','2021-05-04'),
(742,'ria trisna','05052011',2,NULL,NULL,'abc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NIK','KAR2','2011-05-05'),
(743,'boba','05052004',2,NULL,NULL,'boba boba',NULL,NULL,NULL,NULL,101,NULL,NULL,NULL,NULL,'NIKBOBA','BOBANAMA2','2004-05-05'),
(744,'BIBO','01052011',2,NULL,NULL,'BIBOBIBO',NULL,NULL,NULL,NULL,102,NULL,NULL,NULL,NULL,'BIBONIK','BIBONAMA','2011-05-01'),
(745,'ria trisna','',1,NULL,NULL,'boba boba',NULL,NULL,NULL,NULL,101,NULL,NULL,NULL,NULL,'','',NULL),
(746,'df','',3,NULL,NULL,'abc',NULL,NULL,NULL,NULL,103,NULL,NULL,NULL,NULL,'','',NULL),
(747,'ria trisna','',3,NULL,NULL,'boba boba',NULL,NULL,NULL,NULL,103,NULL,NULL,NULL,NULL,'','',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
