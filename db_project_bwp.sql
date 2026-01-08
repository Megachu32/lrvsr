/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 8.4.3 : Database - db_project_bwp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_project_bwp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_project_bwp`;

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `parent_comment_id` int DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `parent_comment_id` (`parent_comment_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `comments` */

insert  into `comments`(`comment_id`,`post_id`,`user_id`,`parent_comment_id`,`content`,`created_at`) values 
(1,1,1,NULL,'Yes! It is still widely used.','2026-01-08 15:45:57'),
(2,1,3,1,'I agree with Alice, especially with Laravel.','2026-01-08 15:45:57'),
(3,1,4,NULL,'I prefer Python personally.','2026-01-08 15:45:57'),
(4,4,5,NULL,'This never happens to me lol','2026-01-08 15:45:57'),
(5,4,1,NULL,'Relatable content.','2026-01-08 15:45:57');

/*Table structure for table `communities` */

DROP TABLE IF EXISTS `communities`;

CREATE TABLE `communities` (
  `community_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `creator_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`community_id`),
  UNIQUE KEY `name` (`name`),
  KEY `creator_id` (`creator_id`),
  CONSTRAINT `communities_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `communities` */

insert  into `communities`(`community_id`,`name`,`description`,`creator_id`,`created_at`) values 
(1,'r/TechTalk','Discussing the latest gadgets and code.',1,'2026-01-08 15:45:57'),
(2,'r/Memes','Daily dose of internet humor.',2,'2026-01-08 15:45:57');

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `community_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `community_id` (`community_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `posts` */

insert  into `posts`(`post_id`,`user_id`,`community_id`,`title`,`content`,`image_url`,`created_at`) values 
(1,2,1,'Is PHP still worth learning in 2026?','I see a lot of mixed opinions. Thoughts?',NULL,'2026-01-08 15:45:57'),
(2,4,1,'My new mechanical keyboard','It has blue switches and is very loud!',NULL,'2026-01-08 15:45:57'),
(3,1,1,'Database Schema Help','I need help designing an 8-table DB.',NULL,'2026-01-08 15:45:57'),
(4,3,2,'When the code works on the first try','Image of a surprised cat.',NULL,'2026-01-08 15:45:57'),
(5,5,2,'Monday Mornings be like','Just a sad coffee cup image.',NULL,'2026-01-08 15:45:57'),
(6,2,2,'Expectation vs Reality','Ordering items online.',NULL,'2026-01-08 15:45:57');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `roles` */

insert  into `roles`(`role_id`,`role_name`,`description`) values 
(1,'Admin','Global site administrator'),
(2,'Member','Regular user');

/*Table structure for table `rules` */

DROP TABLE IF EXISTS `rules`;

CREATE TABLE `rules` (
  `rule_id` int NOT NULL AUTO_INCREMENT,
  `community_id` int NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rule_id`),
  KEY `community_id` (`community_id`),
  CONSTRAINT `rules_ibfk_1` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `rules` */

insert  into `rules`(`rule_id`,`community_id`,`title`,`description`,`created_at`) values 
(1,1,'No Spam','Do not post self-promotion links.','2026-01-08 15:45:57'),
(2,1,'Be Civil','Respect other developers.','2026-01-08 15:45:57'),
(3,2,'No Reposts','Check if the meme was posted recently.','2026-01-08 15:45:57'),
(4,2,'Funny Content Only','Serious posts will be removed.','2026-01-08 15:45:57');

/*Table structure for table `subscriptions` */

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `subscription_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `community_id` int NOT NULL,
  `joined_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`subscription_id`),
  UNIQUE KEY `user_id` (`user_id`,`community_id`),
  KEY `community_id` (`community_id`),
  CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`community_id`) REFERENCES `communities` (`community_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `subscriptions` */

insert  into `subscriptions`(`subscription_id`,`user_id`,`community_id`,`joined_at`) values 
(1,1,1,'2026-01-08 15:45:57'),
(2,1,2,'2026-01-08 15:45:57'),
(3,2,1,'2026-01-08 15:45:57'),
(4,3,2,'2026-01-08 15:45:57'),
(5,4,1,'2026-01-08 15:45:57'),
(6,4,2,'2026-01-08 15:45:57');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT '2',
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`role_id`,`username`,`email`,`password_hash`,`avatar_url`,`created_at`) values 
(1,1,'Alice_Admin','alice@example.com','hash123',NULL,'2026-01-08 15:45:57'),
(2,2,'Bob_Builder','bob@example.com','hash456',NULL,'2026-01-08 15:45:57'),
(3,2,'Charlie_Cat','charlie@example.com','hash789',NULL,'2026-01-08 15:45:57'),
(4,2,'Dave_Dev','dave@example.com','hash321',NULL,'2026-01-08 15:45:57'),
(5,2,'Eve_Explorer','eve@example.com','hash654',NULL,'2026-01-08 15:45:57');

/*Table structure for table `votes` */

DROP TABLE IF EXISTS `votes`;

CREATE TABLE `votes` (
  `vote_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `comment_id` int DEFAULT NULL,
  `vote_type` tinyint NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`vote_id`),
  UNIQUE KEY `user_id` (`user_id`,`post_id`),
  UNIQUE KEY `user_id_2` (`user_id`,`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `comment_id` (`comment_id`),
  CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE,
  CONSTRAINT `votes_chk_1` CHECK ((((`post_id` is not null) and (`comment_id` is null)) or ((`post_id` is null) and (`comment_id` is not null))))
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `votes` */

insert  into `votes`(`vote_id`,`user_id`,`post_id`,`comment_id`,`vote_type`,`created_at`) values 
(1,1,1,NULL,1,'2026-01-08 15:45:57'),
(2,3,1,NULL,1,'2026-01-08 15:45:57'),
(3,5,1,NULL,-1,'2026-01-08 15:45:57'),
(4,1,4,NULL,1,'2026-01-08 15:45:57'),
(5,4,2,NULL,1,'2026-01-08 15:45:57'),
(6,2,NULL,1,1,'2026-01-08 15:45:57'),
(7,4,NULL,1,-1,'2026-01-08 15:45:57'),
(8,1,NULL,4,1,'2026-01-08 15:45:57');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
