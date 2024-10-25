/*
SQLyog Community v8.61 
MySQL - 5.5.5-10.4.32-MariaDB : Database - questteach
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`questteach` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `questteach`;

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar_path` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `accounts` */

insert  into `accounts`(`id`,`username`,`email`,`password`,`avatar_path`,`role_id`) values (7,'admin','39bruno@gmail.com','$2y$10$g86iEYmx5c1K1SMljJ9XROYRnDB0Kt63woC1cDrhHKBQuBSmONhpC','../fielovi/avatars/.65d22bb750fe17.03299247.pngquestTeachLogo.png',2),(32,'BrunoPosavec','pyrobrunogb@gmail.com','$2y$10$u751e7S0FIIkXFhK.QhScex2VDdp65tHYCbF5oYbsBFFadDLaYuAi','../fielovi/avatars/.65d3c523e74218.68565925.pngquestTeachLogo.png',1),(34,'hahahahh','12112@gmail.com','$2y$10$ujiU5G59jqxHFKNQ4rdaT.3HpAgwJbahL/0C5WRKTaWhEIzwHMTQ6','',1),(35,'marta','mposavec2016@gmail.com','$2y$10$jjBsamaEKZq6rv/b/M//Yuu6Uii4eIpFLBe4JVeK/Rb7B32iyaQqa','',1);

/*Table structure for table `commentlist` */

DROP TABLE IF EXISTS `commentlist`;

CREATE TABLE `commentlist` (
  `commid` int(11) NOT NULL AUTO_INCREMENT,
  `courseId` int(11) NOT NULL,
  `comment` text NOT NULL,
  `senderId` int(11) NOT NULL,
  PRIMARY KEY (`commid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `commentlist` */

/*Table structure for table `course` */

DROP TABLE IF EXISTS `course`;

CREATE TABLE `course` (
  `courseId` int(11) NOT NULL AUTO_INCREMENT,
  `courseImg` text NOT NULL,
  `courseTitle` text NOT NULL,
  `courseDesc` text NOT NULL,
  `authorId` int(11) NOT NULL,
  `courseTypeId` int(11) NOT NULL,
  PRIMARY KEY (`courseId`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `course` */

insert  into `course`(`courseId`,`courseImg`,`courseTitle`,`courseDesc`,`authorId`,`courseTypeId`) values (152,'../fielovi/courseFiles/.65d37ec5b9a973.12222055.pngquestTeachLogo.png','DEMO1','this is demonstration of all pages',7,0),(154,'../fielovi/courseFiles/.65d37fcda882c9.21991412.jpgIMG_20221029_103419.jpg','Galerija','malo slika/videa za demonstraciju s puno stranici',7,0),(156,'../fielovi/courseFiles/.65d3b7cab0d978.17656597.pngmainBackground1.png','New User Guide','kako koristiti stranicu / važno',7,0);

/*Table structure for table `courselist` */

DROP TABLE IF EXISTS `courselist`;

CREATE TABLE `courselist` (
  `cListId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  PRIMARY KEY (`cListId`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `courselist` */

insert  into `courselist`(`cListId`,`userId`,`courseId`) values (43,7,152),(44,7,154),(47,7,156),(50,35,152),(51,35,154);

/*Table structure for table `coursepages` */

DROP TABLE IF EXISTS `coursepages`;

CREATE TABLE `coursepages` (
  `cPageListId` int(11) NOT NULL AUTO_INCREMENT,
  `courseID` int(11) NOT NULL,
  `pageNum` int(11) NOT NULL,
  `video` text NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `pageTypeId` int(11) NOT NULL,
  PRIMARY KEY (`cPageListId`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `coursepages` */

insert  into `coursepages`(`cPageListId`,`courseID`,`pageNum`,`video`,`title`,`text`,`pageTypeId`) values (191,152,1,'../fielovi/courseFiles/.65d37ef269b994.28675236.jpgIMG_20230907_040408.jpg','ImagePage','the image page obiosly has image',1),(192,152,2,'../fielovi/courseFiles/.65d37f0a15e7b6.80760557.mp4rtz.mp4','video page','video',2),(193,152,3,'https://www.youtube.com/embed/dnkoG55XfHo','youtube video','',3),(195,154,1,'../fielovi/courseFiles/.65d38448637bd2.66169666.jpgSolarSystemAlmostAccurate.jpg','3d printani suncev sustav','kameniti planeti nisu tocni ',1),(196,154,2,'../fielovi/courseFiles/.65d381634215b3.78284648.jpgIMG_20230820_113611.jpg','Sunce','',1),(197,154,3,'../fielovi/courseFiles/.65d380edf087c3.85065439.pngGX014137_pipp_lapl5_ap3.png','Venera','',1),(198,154,4,'../fielovi/courseFiles/.65d380bc4e0a81.17151570.pngMars12.12.png','Mars','',1),(199,154,5,'../fielovi/courseFiles/.65d380576e3a86.33352965.pngjhup.png','Jupiter','',1),(200,154,6,'../fielovi/courseFiles/.65d3807d588805.90097995.png1.png','Saturn','',1),(201,154,7,'../fielovi/courseFiles/.65d38155043c22.44201090.pngUranus.png','Uran','',1),(202,154,8,'../fielovi/courseFiles/.65d3819013e3a8.16426129.jpgBEST.jpg','M42 orionova maglica','',1),(203,154,9,'../fielovi/courseFiles/.65d381ac20e0b0.74740967.jpgm13.jpg','M13 veliki herkulov skup','',1),(204,154,10,'../fielovi/courseFiles/.65d3821f4b2e12.51258851.jpgIMG_20230808_225101.jpg','sevid-night','',1),(206,154,11,'../fielovi/courseFiles/.65d384ea470948.61282954.pngPWEVIL.png','pwevl1','',1),(207,154,12,'../fielovi/courseFiles/.65d384f3eb2531.13190620.pngPWEVIL2.png','pwevl remastered','',1),(208,154,13,'../fielovi/courseFiles/.65d384fd221192.88117830.pngPW3.png','pwconceptart1','',1),(209,154,14,'../fielovi/courseFiles/.65d3850a735db3.36125896.pngSKYPOW.png','skypower','',1),(210,154,15,'../fielovi/courseFiles/.65d3870d789144.35818986.mp4Fnaf secutrity breach animation 1.mp4','prva','1godinu trajala izrada 2021-2022',2),(211,154,16,'../fielovi/courseFiles/.65d3854c4fd6e3.34524887.jpg1.jpg','230V DC','boost converter',1),(212,154,17,'../fielovi/courseFiles/.65d3856919e969.61855808.jpgIMG_20221220_000955.jpg','sezona 2022/23','',1),(213,154,18,'../fielovi/courseFiles/.65d3859f3565e4.65175279.jpgIMG_20220624_182143.jpg','','',1),(214,154,19,'../fielovi/courseFiles/.65d385aaad16c8.72857468.jpgIMG_20220616_200606.jpg','','',1),(215,154,20,'../fielovi/courseFiles/.65d385b7d5b767.18054834.jpgIMG_20230730_202504.jpg','mammatus oblaci','',1),(216,154,21,'../fielovi/courseFiles/.65d3a234c6d5e8.14576576.pnggroka.png','Groma','',1),(219,154,22,'../fielovi/courseFiles/.65d38f81bac7d6.57313808.mp4vz2006.mp4','varaždin 2006','',2),(222,154,23,'../fielovi/courseFiles/.65d3a1572b3924.68480357.mp4cakovec2006.mp4','Čakovec 2006','',2),(223,154,24,'../fielovi/courseFiles/.65d3a165e59be7.91267988.mp4ck2007.mp4','Čakovec 2007','',2),(224,154,25,'../fielovi/courseFiles/.65d3a1740ed715.35713233.mp4ck2008.mp4','Čakovec 2008','',2),(225,154,26,'../fielovi/courseFiles/.65d388e3c3b598.76080186.mp4ciav2018.mp4','ciav2018','',2),(226,154,27,'../fielovi/courseFiles/.65d3a184e8baa1.59886364.mp4AP2019.mp4','Air Power 2019','',2),(229,154,28,'../fielovi/courseFiles/.65d3a1d42a1635.85422580.mp423sr.mp4','XXIII. Susreti za rudija','',2),(233,154,29,'../fielovi/courseFiles/.65d3a2b28102d5.52939275.jpgIMG-ee5eda3c72b15e0a574057fdfc129e4f-V.jpg','','',1),(234,154,30,'../fielovi/courseFiles/.65d3a31cb20790.38691069.jpgGOPR5910.JPG','','',1),(235,154,31,'../fielovi/courseFiles/.65d3a368811630.16591159.mp4tpobecontionudedlastedit.mp4','','',2),(236,156,1,'../fielovi/courseFiles/.65d3c10aeb9d37.98539491.png','My','',1),(237,156,2,'../fielovi/courseFiles/.65d3c03c377b96.40220434.pngp2.png','My Classes','na početnoj se prikazuju va&scaron;i tečaji\r\nremove-maknut će tečaja \r\nopen-otvorite tečaj\r\nmine-prikazi tečaje koje ste napravili\r\n',1),(238,156,3,'../fielovi/courseFiles/.65d3c1409ba040.75199453.png','My Classes mine','prikaz tečaja koje ste napravili\r\n-&gt; + novi tečaj\r\ndelete -&gt;bri&scaron;e tečaj odmah , i sve njegove stranice + datoteke\r\nedit-&gt; uredite tečaj',1),(239,156,4,'../fielovi/courseFiles/.65d3c3946c2337.37776847.png','Kreiraj novi tečaj','dopu&scaron;teni fielovi: png,jpeg,jpg max-veličina 35MB ,\r\n\r\nNASLOV I TEKST su obavezni\r\n\r\nBack-&gt;nazad na stranicu my classes\r\n',1),(240,156,5,'../fielovi/courseFiles/.65d3c43c84a811.68567071.png','','',1),(241,156,6,'../fielovi/courseFiles/.65d3c4461514d3.38953292.png','ff','ff',1),(242,156,7,'../fielovi/courseFiles/.65d3c44fb52ad2.63723278.png','','',1),(243,156,8,'../fielovi/courseFiles/.65d3c45701b491.36360975.png','','',1),(244,156,9,'../fielovi/courseFiles/.65d3c45cb223d5.54181964.png','','',1),(245,156,10,'../fielovi/courseFiles/.65d3c466e77b42.09441625.png','','',1),(246,156,11,'../fielovi/courseFiles/.65d3c46d9a2a82.69944918.png','','',1),(247,156,12,'../fielovi/courseFiles/.65d3c4742e2b39.89302606.png','','',1),(248,156,13,'../fielovi/courseFiles/.65d3c4798cfa89.88697920.png','','',1);

/*Table structure for table `coursetypes` */

DROP TABLE IF EXISTS `coursetypes`;

CREATE TABLE `coursetypes` (
  `courseTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`courseTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `coursetypes` */

insert  into `coursetypes`(`courseTypeId`,`description`) values (0,'undefined'),(1,'engineering'),(2,'science');

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `notificationId` int(11) NOT NULL AUTO_INCREMENT,
  `cmtId` int(11) NOT NULL,
  `checked` tinyint(1) NOT NULL,
  PRIMARY KEY (`notificationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `notifications` */

/*Table structure for table `pagetypes` */

DROP TABLE IF EXISTS `pagetypes`;

CREATE TABLE `pagetypes` (
  `pageTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`pageTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `pagetypes` */

insert  into `pagetypes`(`pageTypeId`,`name`) values (1,'img'),(2,'video'),(3,'youtubevideo');

/*Table structure for table `rating` */

DROP TABLE IF EXISTS `rating`;

CREATE TABLE `rating` (
  `rateId` int(11) NOT NULL AUTO_INCREMENT,
  `courseListId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`rateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `rating` */

/*Table structure for table `userroles` */

DROP TABLE IF EXISTS `userroles`;

CREATE TABLE `userroles` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(5) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `userroles` */

insert  into `userroles`(`roleId`,`role`) values (1,'user'),(2,'admin');

/* Function  structure for function  `createNewCourse` */

/*!50003 DROP FUNCTION IF EXISTS `createNewCourse` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `createNewCourse`(uid INT , path TEXT ,title TEXT, decr TEXT, typesV TEXT ) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE pgType INT;
    DECLARE newId INT;
    SELECT getPageTypeBN(typesV) INTO pgType LIMIT 1;
    IF pgType IS NULL THEN
        SET pgType = 0;
    END IF;
    INSERT INTO course(courseImg, courseTitle, courseDesc, authorId, courseTypeId) 
    VALUES (path, title, decr, uid, pgType);
    SELECT LAST_INSERT_ID() INTO newId;
    RETURN newId;
END */$$
DELIMITER ;

/* Function  structure for function  `createNewCourseTX` */

/*!50003 DROP FUNCTION IF EXISTS `createNewCourseTX` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `createNewCourseTX`(userId INT, courseTypeV TEXT, path TEXT, title TEXT, txt TEXT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE ctId INT;
    -- Declare handler for no rows found
   
    -- Attempt to select the courseTypeId
    SELECT courseTypeId INTO ctId FROM courseTypes WHERE description = courseTypeV;
if ctId is null  then
set ctId=0;
end if;
    -- Insert into course table
    INSERT INTO course (courseImg, courseTitle, courseDesc, authorId, courseTypeId)
    VALUES (path, title, txt, userId, ctId);
    -- Return the ID of the newly inserted course
    RETURN LAST_INSERT_ID();
END */$$
DELIMITER ;

/* Function  structure for function  `createNewUser` */

/*!50003 DROP FUNCTION IF EXISTS `createNewUser` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `createNewUser`(usernameV VARCHAR(255), emailV VARCHAR(255), avatar VARCHAR(255), passwordV VARCHAR(255)) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE result INT;
    INSERT INTO accounts(username, email, PASSWORD, avatar_path) VALUES (usernameV, emailV, passwordV, avatar);
    SET result = LAST_INSERT_ID();
    RETURN result;
END */$$
DELIMITER ;

/* Function  structure for function  `deleteCourse` */

/*!50003 DROP FUNCTION IF EXISTS `deleteCourse` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `deleteCourse`(cid INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DELETE FROM coursepages WHERE courseId = cid;
    DELETE FROM course WHERE courseId = cid;
    DELETE FROM courselist WHERE courselist.courseId = cid;
    RETURN 1;
END */$$
DELIMITER ;

/* Function  structure for function  `deletePage` */

/*!50003 DROP FUNCTION IF EXISTS `deletePage` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `deletePage`(cid INT, num INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DELETE FROM coursepages WHERE courseId = cid AND num = coursepages.pageNum;
    UPDATE coursepages SET pageNum = pageNum - 1 WHERE courseId = cid AND coursepages.pageNum > num;
    RETURN 1;
END */$$
DELIMITER ;

/* Function  structure for function  `deleteUser` */

/*!50003 DROP FUNCTION IF EXISTS `deleteUser` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `deleteUser`(userId int) RETURNS int(11)
    DETERMINISTIC
begin
DELETE FROM accounts WHERE id=userId;
return 1;
end */$$
DELIMITER ;

/* Function  structure for function  `emailExists` */

/*!50003 DROP FUNCTION IF EXISTS `emailExists` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `emailExists`(p_email VARCHAR(255)) RETURNS tinyint(1)
BEGIN
    DECLARE emailCount INT;
    SELECT COUNT(*) INTO emailCount
    FROM accounts
    WHERE email = p_email;
    RETURN emailCount > 0;
END */$$
DELIMITER ;

/* Function  structure for function  `enroll` */

/*!50003 DROP FUNCTION IF EXISTS `enroll` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `enroll`(uid INT, courseIdV INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE alreadyEnrolled INT;
    -- Check if the user has already enrolled in the course
    SELECT IFNULL(COUNT(*), 0) INTO alreadyEnrolled
    FROM courselist
    WHERE userId = uid AND courseId = courseIdV;
    -- If the user is not enrolled yet, insert the enrollment
    IF alreadyEnrolled = 0 THEN
        INSERT INTO courselist(userId, courseId) VALUES (uid, courseIdV);
        RETURN 1; -- Successfully enrolled
    ELSE
        RETURN 0; -- User is already enrolled
    END IF;
END */$$
DELIMITER ;

/* Function  structure for function  `getCourseAuthor` */

/*!50003 DROP FUNCTION IF EXISTS `getCourseAuthor` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `getCourseAuthor`(cid INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE aId INT;
    SELECT authorId INTO aId FROM course WHERE courseId=cid;
    IF aId IS NULL THEN
        RETURN -1;
    END IF;
    RETURN aId;
END */$$
DELIMITER ;

/* Function  structure for function  `getMaxPageNum` */

/*!50003 DROP FUNCTION IF EXISTS `getMaxPageNum` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `getMaxPageNum`(Id INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE numPages INT;
    SELECT COUNT(pageNum) INTO numPages FROM coursepages WHERE courseID =Id;
    RETURN numPages;
END */$$
DELIMITER ;

/* Function  structure for function  `getNewCourseId` */

/*!50003 DROP FUNCTION IF EXISTS `getNewCourseId` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `getNewCourseId`(userId INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE maxCourseId INT;
    
    SELECT MAX(courseId) INTO maxCourseId
    FROM course
    WHERE authorId = userId
    LIMIT 1;
    RETURN maxCourseId;
END */$$
DELIMITER ;

/* Function  structure for function  `getNumOfPages` */

/*!50003 DROP FUNCTION IF EXISTS `getNumOfPages` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `getNumOfPages`(courseIdV INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
  DECLARE output INT;
  SELECT COUNT(pageNum)  INTO output FROM coursePages WHERE courseID = courseIdV;
  RETURN output;
END */$$
DELIMITER ;

/* Function  structure for function  `getPageTypeBN` */

/*!50003 DROP FUNCTION IF EXISTS `getPageTypeBN` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `getPageTypeBN`(txt TEXT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE output INT;
    SELECT pageTypeId INTO output FROM pageTypes WHERE NAME=txt;
    IF output IS NULL THEN
        SET output = 0;
    END IF;
    RETURN output;
END */$$
DELIMITER ;

/* Function  structure for function  `getUserRole` */

/*!50003 DROP FUNCTION IF EXISTS `getUserRole` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `getUserRole`(uid INT) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
    DETERMINISTIC
BEGIN
    DECLARE output VARCHAR(255);
    SELECT userroles.role INTO output
    FROM userroles
    JOIN accounts ON accounts.role_id = userroles.roleId
    WHERE accounts.id = uid;
    RETURN output;
END */$$
DELIMITER ;

/* Function  structure for function  `isUserEnroled` */

/*!50003 DROP FUNCTION IF EXISTS `isUserEnroled` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `isUserEnroled`(courseIdV INT, userIdV INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE isEnroled INT;
    SELECT COUNT(*) INTO isEnroled FROM courselist WHERE userId = userIdV AND courseId = courseIdV;
    RETURN isEnroled; -- Return 1 if enrolled, 0 if not enrolled
END */$$
DELIMITER ;

/* Function  structure for function  `movePageDown` */

/*!50003 DROP FUNCTION IF EXISTS `movePageDown` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `movePageDown`(cid INT, pageNumV INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
DECLARE nextPageNum INT ;
DECLARE maxPageNum INT;
DECLARE nextId INT;
DECLARE pageId INT;
declare temporaryId int;
SELECT MAX(cPageListId) into temporaryId FROM coursepages;
set temporaryId =temporaryId+2;
SET nextPageNum = pageNumV + 1;
SELECT getMaxPageNum(cid) INTO maxPageNum;
SELECT cPageListId INTO pageId FROM coursepages WHERE courseId = cid AND pageNum = pageNumV;
SELECT cPageListId INTO nextId FROM coursepages WHERE courseId = cid AND pageNum = nextPageNum;
IF nextPageNum <= maxPageNum THEN
      UPDATE coursepages SET pageNum = nextPageNum WHERE cPageListId = pageId;
    UPDATE coursepages SET pageNum = pageNumV WHERE cPageListId = nextId;
  
      
  UPDATE coursepages SET cPageListId = temporaryId WHERE pageNum = nextPageNum AND courseId=cid;  
  UPDATE coursepages SET cPageListId = pageId WHERE pageNum = pageNumV  AND courseId=cid;
   UPDATE coursepages SET cPageListId = nextId WHERE pageNum = nextPageNum AND courseId=cid;  
 
END IF;
RETURN 1;
END */$$
DELIMITER ;

/* Function  structure for function  `movePageUp` */

/*!50003 DROP FUNCTION IF EXISTS `movePageUp` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `movePageUp`(cid INT, pageNumV INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
DECLARE nextPageNum INT ;
DECLARE maxPageNum INT;
DECLARE nextId INT;
DECLARE pageId INT;
declare temporaryId int;
SELECT MAX(cPageListId) into temporaryId FROM coursepages;
set temporaryId =temporaryId+2;
SET nextPageNum = pageNumV - 1;
SELECT getMaxPageNum(cid) INTO maxPageNum;
SELECT cPageListId INTO pageId FROM coursepages WHERE courseId = cid AND pageNum = pageNumV;
SELECT cPageListId INTO nextId FROM coursepages WHERE courseId = cid AND pageNum = nextPageNum;
IF  nextPageNum>=1 THEN
    UPDATE coursepages SET pageNum = pageNumV WHERE cPageListId = nextId;
      UPDATE coursepages SET pageNum = nextPageNum WHERE cPageListId = pageId;
  UPDATE coursepages SET cPageListId = temporaryId WHERE pageNum = nextPageNum AND courseId=cid; 
    UPDATE coursepages SET cPageListId = pageId WHERE pageNum = pageNumV  AND courseId=cid;
   UPDATE coursepages SET cPageListId = nextId WHERE pageNum = nextPageNum AND courseId=cid;   
  
 
END IF;
RETURN 1;
END */$$
DELIMITER ;

/* Function  structure for function  `newCoursePage` */

/*!50003 DROP FUNCTION IF EXISTS `newCoursePage` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `newCoursePage`(courseIDV INT, 
    courseImgV TEXT, 
    courseTitleV TEXT, 
    courseTextV TEXT, 
    courseType TEXT
) RETURNS int(11)
BEGIN
    DECLARE maxpgnum INT;
    DECLARE courseTypeId INT;
    SET maxpgnum = 0;
    SET courseTypeId = 0;
    SELECT pageTypeId INTO courseTypeId FROM pagetypes WHERE NAME = courseType;
    SELECT MAX(pageNum) INTO maxpgnum FROM coursepages WHERE courseId = courseIDV;
    SET maxpgnum = COALESCE(maxpgnum, 0) + 1;
    IF maxpgnum IS NULL THEN
        SET maxpgnum = 1;
    END IF;
    INSERT INTO coursepages(courseID, pageNum, video, title, TEXT, pageTypeId)
    VALUES(courseIDV, maxpgnum, courseImgV, courseTitleV, courseTextV, courseTypeId);
    RETURN 1;  -- Adjust the return value as needed
END */$$
DELIMITER ;

/* Function  structure for function  `updateCourse` */

/*!50003 DROP FUNCTION IF EXISTS `updateCourse` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `updateCourse`(cid int ,path text , title text , txt text) RETURNS int(11)
    DETERMINISTIC
begin
UPDATE course SET courseImg=path,courseTitle=title , courseDesc=txt WHERE courseId=cid;
return 1; 
end */$$
DELIMITER ;

/* Function  structure for function  `updatePageData` */

/*!50003 DROP FUNCTION IF EXISTS `updatePageData` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `updatePageData`(cid INT, pageN INT, filePth TEXT, titleV TEXT, tekst TEXT, pgType TEXT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE pageTypeNm INT;
    SELECT pageTypeId INTO pageTypeNm FROM pageTypes WHERE NAME = pgType;
    UPDATE coursepages SET video = filePth, title = titleV, TEXT = tekst, pageTypeId = pageTypeNm WHERE courseId = cid AND pageNum = pageN;
    RETURN 1;
END */$$
DELIMITER ;

/* Function  structure for function  `updateUserAccount` */

/*!50003 DROP FUNCTION IF EXISTS `updateUserAccount` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `updateUserAccount`(userId INT,
    usernameIn TEXT,
    emailIn TEXT,
    avatarPthIn TEXT,
    passwordIn TEXT,
    roleTxt VARCHAR(5)
) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE roleIdVar INT;
    -- Check if roleTxt is provided, if not, set it to NULL
    IF roleTxt IS NULL OR roleTxt = '' THEN
        -- Retrieve the current role ID
        SELECT role_id INTO roleIdVar FROM accounts WHERE id = userId;
    ELSE
        -- Find roleId from userroles table
        SELECT roleId INTO roleIdVar FROM userroles WHERE role = roleTxt;
        -- If role is not found, roleIdVar will remain NULL
    END IF;
    -- Update only if the parameter is provided
    IF usernameIn <> '' THEN
        SET @username = usernameIn;
    ELSE
        SET @username = NULL; -- Keep the existing value
    END IF;
    IF emailIn <> '' THEN
        SET @email = emailIn;
    ELSE
        SET @email = NULL; -- Keep the existing value
    END IF;
    IF avatarPthIn <> '' THEN
        SET @avatar_path = avatarPthIn;
    ELSE
        SET @avatar_path = NULL; -- Keep the existing value
    END IF;
    IF passwordIn <> '' THEN
        SET @password = passwordIn;
    ELSE
        SET @password = NULL; -- Keep the existing value
    END IF;
    -- Update accounts table with the provided or existing values
    UPDATE accounts
    SET
        username = IFNULL(@username, username),
        email = IFNULL(@email, email),
        avatar_path = IFNULL(@avatar_path, avatar_path),
        password = IFNULL(@password, password),
        role_id = IFNULL(roleIdVar, role_id)
    WHERE id = userId;
    -- Return the affected row count
    RETURN ROW_COUNT();
END */$$
DELIMITER ;

/* Function  structure for function  `usernameExists` */

/*!50003 DROP FUNCTION IF EXISTS `usernameExists` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `usernameExists`(p_username VARCHAR(255)) RETURNS tinyint(1)
BEGIN
    DECLARE userCount INT;
    SELECT COUNT(*) INTO userCount
    FROM accounts
    WHERE username = p_username;
    RETURN userCount > 0;
END */$$
DELIMITER ;

/* Function  structure for function  `withdrawEnrollment` */

/*!50003 DROP FUNCTION IF EXISTS `withdrawEnrollment` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `withdrawEnrollment`(uid INT, courseIdV INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    DECLARE isEnrolled INT;
    -- Check if the user is enrolled in the course
    SELECT COUNT(*) INTO isEnrolled
    FROM courselist
    WHERE userId = uid AND courseId = courseIdV;
    -- If the user is enrolled, withdraw the enrollment
    IF isEnrolled > 0 THEN
        DELETE FROM courselist WHERE userId = uid AND courseId = courseIdV;
        RETURN 1; -- Successfully withdrawn enrollment
    ELSE
        RETURN 0; -- User is not enrolled
    END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `createNewUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `createNewUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `createNewUser`(IN usernameVar TEXT, IN emailVar TEXT, IN passwordVar TEXT)
BEGIN
 INSERT INTO accounts (username, email, PASSWORD) VALUES (usernameVar, emailVar, passwordVar);
END */$$
DELIMITER ;

/* Procedure structure for procedure `deletePage` */

/*!50003 DROP PROCEDURE IF EXISTS  `deletePage` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePage`(IN courseIdV INT, IN page INT)
BEGIN
   
    DELETE FROM coursepages WHERE pageNum = page AND courseID = courseIdV;
     UPDATE coursepages SET pageNum = pageNum - 1 WHERE pageNum > page AND courseID = courseIdV;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getAllUserAccounts` */

/*!50003 DROP PROCEDURE IF EXISTS  `getAllUserAccounts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllUserAccounts`()
begin
select * from accounts ;
end */$$
DELIMITER ;

/* Procedure structure for procedure `getAllUserAccountsOffset` */

/*!50003 DROP PROCEDURE IF EXISTS  `getAllUserAccountsOffset` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllUserAccountsOffset`(IN limitV INT, IN offsetV INT)
BEGIN
    SELECT * FROM accounts
    LIMIT limitV
    OFFSET offsetV;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCourse` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCourse` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCourse`(IN id INT)
BEGIN
    SELECT * FROM course WHERE courseId = id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCoursePage` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCoursePage` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCoursePage`(in cid int , in pageN int)
begin
SELECT * FROM coursepages left join pageTypes on coursepages.pageTypeId=pageTypes.pageTypeId  WHERE courseID=cid AND pageNum=pageN;
end */$$
DELIMITER ;

/* Procedure structure for procedure `getCoursePages` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCoursePages` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCoursePages`(IN courseIdV INT)
BEGIN
    SELECT * FROM coursepages left JOIN pagetypes ON coursepages.pageTypeId = pagetypes.pageTypeId  WHERE courseId =courseIdV;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCoursesFromTo` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCoursesFromTo` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCoursesFromTo`(
    IN fromN INT, 
    IN toN INT, 
    IN shrcFilter TEXT,
    IN courseType TEXT
)
BEGIN
    IF NULLIF(shrcFilter, '') IS NOT NULL AND NULLIF(courseType, '') IS NOT NULL THEN
        SELECT * FROM course 
        JOIN coursetypes ON course.courseTypeId = coursetypes.courseTypeId 
        WHERE course.courseTitle LIKE CONCAT('%', NULLIF(shrcFilter, ''), '%') 
        AND coursetypes.description = NULLIF(courseType, '') 
        LIMIT fromN, toN;
    ELSEIF NULLIF(shrcFilter, '') IS NOT NULL THEN
        SELECT * FROM course 
        JOIN coursetypes ON course.courseTypeId = coursetypes.courseTypeId 
        WHERE course.courseTitle LIKE CONCAT('%', NULLIF(shrcFilter, ''), '%') 
        LIMIT fromN, toN;
    ELSEIF NULLIF(courseType, '') IS NOT NULL THEN
        SELECT * FROM course 
        JOIN coursetypes ON course.courseTypeId = coursetypes.courseTypeId 
        WHERE coursetypes.description = NULLIF(courseType, '') 
        LIMIT fromN, toN;
    ELSE
        SELECT * FROM course 
        JOIN coursetypes ON course.courseTypeId = coursetypes.courseTypeId 
        LIMIT fromN, toN;
    END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getEnrolledCourses` */

/*!50003 DROP PROCEDURE IF EXISTS  `getEnrolledCourses` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getEnrolledCourses`(in uid int)
begin
SELECT course.courseId ,courseImg,courseTitle,courseDesc,authorId FROM course JOIN courselist ON course.courseId =courselist.courseId WHERE userId=uid;
end */$$
DELIMITER ;

/* Procedure structure for procedure `getPageFilePaths` */

/*!50003 DROP PROCEDURE IF EXISTS  `getPageFilePaths` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getPageFilePaths`(cid int)
begin
SELECT video AS filePaths FROM coursepages WHERE courseId=cid;
end */$$
DELIMITER ;

/* Procedure structure for procedure `getPageTypeNames` */

/*!50003 DROP PROCEDURE IF EXISTS  `getPageTypeNames` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getPageTypeNames`()
BEGIN
    SELECT NAME FROM pageTypes;
END */$$
DELIMITER ;

/* Procedure structure for procedure `GetUserByCredentials` */

/*!50003 DROP PROCEDURE IF EXISTS  `GetUserByCredentials` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserByCredentials`(IN p_identifier VARCHAR(255))
BEGIN
    DECLARE user_id INT;
 
    SELECT id INTO user_id FROM accounts WHERE email = p_identifier;
  
    IF user_id IS NULL THEN
        SELECT id INTO user_id FROM accounts WHERE username = p_identifier;
    END IF;
  
    SELECT user_id AS user_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getUserPassword` */

/*!50003 DROP PROCEDURE IF EXISTS  `getUserPassword` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserPassword`(in userId int)
begin
select password  from accounts where id=userId;
end */$$
DELIMITER ;

/* Procedure structure for procedure `newCourse` */

/*!50003 DROP PROCEDURE IF EXISTS  `newCourse` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `newCourse`(
    IN courseImgV TEXT,
    IN courseTitleV TEXT,
    IN courseTextV TEXT,
    IN authorIdV INT,
    IN courseTypeIdV INT
)
BEGIN
    INSERT INTO course(courseImg, courseTitle, courseDesc, authorId, courseTypeId)
    VALUES(courseImgV, courseTitleV, courseTextV, authorIdV, courseTypeIdV);
END */$$
DELIMITER ;

/* Procedure structure for procedure `newCoursePage` */

/*!50003 DROP PROCEDURE IF EXISTS  `newCoursePage` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `newCoursePage`(
    IN courseIDV INT, 
    IN courseImgV TEXT, 
    IN courseTitleV TEXT, 
    IN courseTextV TEXT, 
    IN courseType TEXT
)
BEGIN
    DECLARE maxpgnum INT;
    DECLARE courseTypeId INT;
    SET maxpgnum = 0;
    SET courseTypeId = 0;
    SELECT COALESCE(pageTypeId, 0) INTO courseTypeId FROM pagetypes WHERE NAME = courseType;
    SELECT MAX(pageNum) INTO maxpgnum FROM coursepages WHERE courseId = courseIDV;
    SET maxpgnum = COALESCE(maxpgnum, 0) + 1;
    IF maxpgnum IS NULL THEN
        SET maxpgnum = 1;
    END IF;
    INSERT INTO coursepages(courseID, pageNum, video, title, TEXT, pageTypeId)
    VALUES(courseIDV, maxpgnum, courseImgV, courseTitleV, courseTextV, courseTypeId);
END */$$
DELIMITER ;

/* Procedure structure for procedure `newCourseV2` */

/*!50003 DROP PROCEDURE IF EXISTS  `newCourseV2` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `newCourseV2`(
    IN courseImgV TEXT,
    IN courseTitleV TEXT,
    IN courseTextV TEXT,
    IN authorIdV INT,
    IN courseTypeV TEXT
)
BEGIN
declare courseTypeIdV int;
select  courseTypeId into courseTypeIdV from coursetypes where description=courseTypeV;
    INSERT INTO course(courseImg, courseTitle, courseDesc, authorId, courseTypeId)
    VALUES(courseImgV, courseTitleV, courseTextV, authorIdV, courseTypeIdV);
END */$$
DELIMITER ;

/* Procedure structure for procedure `readCourseDataID` */

/*!50003 DROP PROCEDURE IF EXISTS  `readCourseDataID` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `readCourseDataID`(in uid int)
begin
SELECT * FROM course WHERE courseId=uid ;
end */$$
DELIMITER ;

/* Procedure structure for procedure `readUserData` */

/*!50003 DROP PROCEDURE IF EXISTS  `readUserData` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `readUserData`(in userId int)
begin
select id , username,email,avatar_path,role from accounts join userroles on accounts.role_Id=userroles.roleId where id=userId;
end */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
