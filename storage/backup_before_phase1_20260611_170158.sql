-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: legalconsaltent
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_uuid_unique` (`uuid`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` VALUES (1,'0e934d65-6ca9-4499-8432-b38af0a79b29','Joshua Rice','joshua-rice','Facilis incidunt co','Modi adipisicing vel',1,'2025-11-05 00:29:39','2025-11-05 00:29:39');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_post_youtube_video`
--

DROP TABLE IF EXISTS `blog_post_youtube_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_post_youtube_video` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_post_id` bigint(20) unsigned NOT NULL,
  `youtube_video_id` bigint(20) unsigned NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_post_youtube_video_blog_post_id_youtube_video_id_unique` (`blog_post_id`,`youtube_video_id`),
  KEY `blog_post_youtube_video_youtube_video_id_foreign` (`youtube_video_id`),
  CONSTRAINT `blog_post_youtube_video_blog_post_id_foreign` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_post_youtube_video_youtube_video_id_foreign` FOREIGN KEY (`youtube_video_id`) REFERENCES `youtube_videos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_post_youtube_video`
--

LOCK TABLES `blog_post_youtube_video` WRITE;
/*!40000 ALTER TABLE `blog_post_youtube_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_post_youtube_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `heading` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `blog_category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `structure` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`structure`)),
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `view_count` int(11) NOT NULL DEFAULT 0,
  `read_time` int(11) NOT NULL DEFAULT 5,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_featured` enum('1','0') DEFAULT '0',
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `banner` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`banner`)),
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`image`)),
  `rich_text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rich_text`)),
  `text_left_image_right` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`text_left_image_right`)),
  `custom_html` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_html`)),
  `canvas_elements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`canvas_elements`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_uuid_unique` (`uuid`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_lawyer_id_foreign` (`lawyer_id`),
  KEY `blog_posts_blog_category_id_foreign` (`blog_category_id`),
  CONSTRAINT `blog_posts_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `blog_posts_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'736eff90-1c76-48b6-8e1a-37bcdf4591e0',1,NULL,NULL,'First Post','first-post','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-1\\/blog\\/images\\/311e8842-2fac-4ae2-be40-aae2aee5bb20.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Caption\"},\"position\":1},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":2}],\"metadata\":{\"created\":\"2025-11-02T18:42:07.872Z\",\"total_elements\":3,\"version\":\"1.0\"}}','Enim voluptatem exe','<h2>New Heading</h2><figure><img src=\"http://localhost/storage/lawyers/lawyer-1/blog/images/311e8842-2fac-4ae2-be40-aae2aee5bb20.jpeg\" alt=\"Image\"><figcaption>Image Caption</figcaption></figure><p>Enter your text content here...</p>','lawyer-one/1762108929.jpg','\"[\\\"Et\\\",\\\"et\\\",\\\"rerum\\\",\\\"animi\\\",\\\"s\\\"]\"',0,5,'published','2025-11-02 13:42:09','0',NULL,NULL,'[]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-1\\/blog\\/images\\/311e8842-2fac-4ae2-be40-aae2aee5bb20.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Caption\"},\"position\":1,\"created_at\":\"2025-11-02T18:42:09.479437Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":2,\"created_at\":\"2025-11-02T18:42:09.479706Z\"}]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-02T18:42:09.478064Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-1\\/blog\\/images\\/311e8842-2fac-4ae2-be40-aae2aee5bb20.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Caption\"},\"position\":1,\"created_at\":\"2025-11-02T18:42:09.479437Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":2,\"created_at\":\"2025-11-02T18:42:09.479706Z\"}]','2025-11-02 13:42:09','2025-11-02 13:42:09'),(2,'405c380f-4656-41e3-a38a-5735b8f7473d',2,NULL,NULL,'Culpa nisi b','culpa-nisi-b','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...zxZx<\\/p>\\n\"},\"position\":1}],\"metadata\":{\"created\":\"2025-11-05T05:30:46.432Z\",\"total_elements\":2,\"version\":\"1.0\"}}','Debitis non ut simil','<h2>New Heading</h2><p>Enter your text content here...zxZx</p>\n','lawyer-one/1762320647.jpg','\"[\\\"Omnis nobis nostrud\\\"]\"',0,5,'draft',NULL,'0',NULL,NULL,'[]','[]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...zxZx<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-05T05:30:47.495924Z\"}]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-05T05:30:47.495671Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...zxZx<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-05T05:30:47.495924Z\"}]','2025-11-04 00:21:07','2025-11-05 00:30:47'),(3,'38c5b3e2-e5bf-4a3e-bcd6-a3c7e3836227',2,NULL,1,'Inventore nobis pari','inventore-nobis-pari','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"Facilis possimus co\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/c49dee36-895c-479b-b846-46021b90baa4.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Caption\"},\"position\":2}],\"metadata\":{\"created\":\"2025-11-05T05:36:17.069Z\",\"total_elements\":3,\"version\":\"1.0\"}}','Elit in porro volup','<h2>Facilis possimus co</h2><p>Enter your text content here...</p><figure><img src=\"http://localhost/storage/http://localhost:8000/website/lawyers/lawyer-2/blog/images/c49dee36-895c-479b-b846-46021b90baa4.jpeg\" alt=\"Image\"><figcaption>Image Caption</figcaption></figure>','lawyer-one/1762251728.jpg','\"[\\\"Unde ullamco asperio\\\"]\"',4,5,'published','2025-11-05 00:36:20','0',NULL,NULL,'[]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/c49dee36-895c-479b-b846-46021b90baa4.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Caption\"},\"position\":2,\"created_at\":\"2025-11-05T05:36:19.029596Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1,\"created_at\":\"2025-11-05T05:36:19.029446Z\"}]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"Facilis possimus co\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-05T05:36:19.029198Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1,\"created_at\":\"2025-11-05T05:36:19.029446Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/c49dee36-895c-479b-b846-46021b90baa4.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Caption\"},\"position\":2,\"created_at\":\"2025-11-05T05:36:19.029596Z\"}]','2025-11-04 05:22:08','2025-11-12 11:06:49'),(4,'25ff31aa-334d-4a33-a0de-83cd0367d640',2,NULL,1,'Error est officia su','error-est-officia-su','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h1\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/f1bd56a5-d00c-4cf3-837b-69eccaae77cc.jpeg\",\"alt\":\"Image\",\"caption\":\"Here is image Cation\"},\"position\":2}],\"metadata\":{\"created\":\"2025-11-08T10:34:25.424Z\",\"total_elements\":3,\"version\":\"1.0\"}}','Eum quia omnis disti','<h1>New Heading</h1><p>Enter your text content here...image</p>\n<figure><img src=\"http://localhost/website/lawyers/lawyer-2/blog/images/f1bd56a5-d00c-4cf3-837b-69eccaae77cc.jpeg\" alt=\"Image\"><figcaption>Here is image Cation</figcaption></figure>','lawyer-two/1762597357.jpg','\"[\\\"Esse aute sit est\\\"]\"',47,5,'published','2025-11-08 02:38:14','0',NULL,NULL,'[]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/f1bd56a5-d00c-4cf3-837b-69eccaae77cc.jpeg\",\"alt\":\"Image\",\"caption\":\"Here is image Cation\"},\"position\":2,\"created_at\":\"2025-11-08T10:34:26.008152Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-08T10:34:26.007909Z\"}]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h1\"},\"position\":0,\"created_at\":\"2025-11-08T10:34:26.007535Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-08T10:34:26.007909Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/f1bd56a5-d00c-4cf3-837b-69eccaae77cc.jpeg\",\"alt\":\"Image\",\"caption\":\"Here is image Cation\"},\"position\":2,\"created_at\":\"2025-11-08T10:34:26.008152Z\"}]','2025-11-08 02:38:15','2025-11-09 07:51:48'),(5,'cffc1151-0bfe-48f9-ae4a-ed749d3571ba',2,NULL,1,'Khalid Blog','khalid-blog','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/f7a6d84c-c143-414e-88e5-9b4d8971e3be.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2}],\"metadata\":{\"created\":\"2025-11-09T11:34:32.283Z\",\"total_elements\":3,\"version\":\"1.0\"}}','Here is excerpt','<h2>New Heading</h2><p>Enter your text content here...image</p>\n<figure><img src=\"ggghttp://localhost/website/lawyers/lawyer-2/blog/images/f7a6d84c-c143-414e-88e5-9b4d8971e3be.jpeg\" alt=\"Image\"></figure>','lawyer-two/1762688073.jpg','\"[\\\"tags\\\",\\\"test\\\",\\\"now\\\",\\\"dd\\\"]\"',1,5,'published','2025-11-09 06:34:33','0',NULL,NULL,'[]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/f7a6d84c-c143-414e-88e5-9b4d8971e3be.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:34:33.487206Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:34:33.486970Z\"}]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T11:34:33.486622Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:34:33.486970Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/f7a6d84c-c143-414e-88e5-9b4d8971e3be.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:34:33.487206Z\"}]','2025-11-09 06:34:33','2025-11-11 06:23:19'),(6,'65a3bce9-9d7d-440c-941f-fbfe6938f567',2,NULL,1,'New post title','new-post-title','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/53e03055-8619-47e0-9981-78fbc8d8ba51.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2}],\"metadata\":{\"created\":\"2025-11-09T11:38:55.777Z\",\"total_elements\":3,\"version\":\"1.0\"}}','sdfasd','<h2>New Heading</h2><p>Enter your text content here...image</p>\n<figure>\n                        <img src=\"http://localhost/website/lawyers/lawyer-2/blog/images/53e03055-8619-47e0-9981-78fbc8d8ba51.jpeg\" alt=\"Image\">\n                        \n                    </figure>','lawyer-two/1762688336.jpg','\"[\\\"asdfasdff\\\"]\"',0,5,'published','2025-11-09 06:38:56','0',NULL,NULL,'[]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/53e03055-8619-47e0-9981-78fbc8d8ba51.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:38:56.658966Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:38:56.658638Z\"}]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T11:38:56.658216Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:38:56.658638Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/53e03055-8619-47e0-9981-78fbc8d8ba51.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:38:56.658966Z\"}]','2025-11-09 06:38:56','2025-11-09 06:38:56'),(7,'32d8961e-6a62-46d8-a738-7fe169960136',2,NULL,1,'asdfasd','asdfasd','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/ccc2ff5e-319d-499b-b9ed-601a73263977.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2},{\"id\":\"element_4\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3}],\"metadata\":{\"created\":\"2025-11-09T11:49:11.124Z\",\"total_elements\":4,\"version\":\"1.0\"}}','sdfasdf','<h2>New Heading</h2><p>Enter your text content here...image</p>\n<figure><img src=\"http://localhost/website/lawyers/lawyer-2/blog/images/ccc2ff5e-319d-499b-b9ed-601a73263977.jpeg\" alt=\"Image\"></figure><div class=\"row\"><div class=\"col-md-6\"><p>Left column content...</p></div><div class=\"col-md-6\"><p>Right column content...</p></div></div>','lawyer-two/1762688952.jpg','\"[\\\"dsfasd\\\"]\"',0,5,'published','2025-11-09 06:49:12','0',NULL,NULL,'[]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/ccc2ff5e-319d-499b-b9ed-601a73263977.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:49:12.116470Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:49:12.116232Z\"}]','[{\"id\":\"element_4\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3,\"created_at\":\"2025-11-09T11:49:12.116692Z\"}]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T11:49:12.115890Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:49:12.116232Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/ccc2ff5e-319d-499b-b9ed-601a73263977.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:49:12.116470Z\"},{\"id\":\"element_4\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3,\"created_at\":\"2025-11-09T11:49:12.116692Z\"}]','2025-11-09 06:49:12','2025-11-09 06:49:12'),(8,'e79cea9f-c10e-4bc6-a611-91356afd8556',2,NULL,NULL,'dsfsad','dsfsad','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/540a9f0f-c6c4-45eb-84a3-cf449557027a.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2},{\"id\":\"element_4\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3}],\"metadata\":{\"created\":\"2025-11-09T11:55:13.281Z\",\"total_elements\":4,\"version\":\"1.0\"}}','adfasd','<h2>New Heading</h2><p>Enter your text content here...image</p>\n<figure><img src=\"http://localhost/website/lawyers/lawyer-2/blog/images/540a9f0f-c6c4-45eb-84a3-cf449557027a.jpeg\" alt=\"Image\"></figure><div class=\"row\"><div class=\"col-md-6\"><p>Left column content...</p></div><div class=\"col-md-6\"><p>Right column content...</p></div></div>','lawyer-two/1762689315.jpg','\"[\\\"adsfasdf\\\"]\"',0,5,'published','2025-11-09 06:55:15','0',NULL,NULL,'[]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/540a9f0f-c6c4-45eb-84a3-cf449557027a.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:55:15.464772Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:55:15.464590Z\"}]','[{\"id\":\"element_4\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3,\"created_at\":\"2025-11-09T11:55:15.464914Z\"}]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T11:55:15.463533Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...image<\\/p>\\n\"},\"position\":1,\"created_at\":\"2025-11-09T11:55:15.464590Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/540a9f0f-c6c4-45eb-84a3-cf449557027a.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":2,\"created_at\":\"2025-11-09T11:55:15.464772Z\"},{\"id\":\"element_4\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3,\"created_at\":\"2025-11-09T11:55:15.464914Z\"}]','2025-11-09 06:55:15','2025-11-09 06:55:15'),(9,'8895a9bf-fc54-466a-ae34-a3162b4c90af',2,NULL,1,'dsvzsxcv','dsvzsxcv','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0}],\"metadata\":{\"created\":\"2025-11-09T11:56:07.290Z\",\"total_elements\":1,\"version\":\"1.0\"}}','xcvz','<h2>New Heading</h2>','lawyer-two/1762689368.jpg','\"[\\\"zxcvzx\\\"]\"',1,5,'published','2025-11-09 06:56:08','0',NULL,NULL,'[]','[]','[]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T11:56:08.033341Z\"}]','2025-11-09 06:56:08','2025-11-11 04:59:44'),(10,'933dbc50-ed2f-44f2-a54a-6a8afdeb35e8',2,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T12:02:53.212175Z\"}]',1,'adsfasd','adsfasd','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0}],\"metadata\":{\"created\":\"2025-11-09T12:02:52.462Z\",\"total_elements\":1,\"version\":\"1.0\"}}','adfas','<h2>New Heading</h2>','lawyer-two/1762689773.jpg','\"[\\\"dadfsd\\\"]\"',12,5,'published','2025-11-09 07:02:53','0',NULL,NULL,'[]','[]','[]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T12:02:53.212175Z\"}]','2025-11-09 07:02:53','2025-11-12 12:11:25'),(11,'c49eaf74-c3b8-476f-be7d-afe7a1343c73',2,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T12:32:01.166242Z\"}]',1,'asdfasdf','asdfasdf','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/d2abf611-803f-45d2-a0ed-a0ddbf253926.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":1}],\"metadata\":{\"created\":\"2025-11-09T12:31:59.975Z\",\"total_elements\":2,\"version\":\"1.0\"}}','asdfasd','<h2>New Heading</h2><figure><img src=\"http://localhost:8000/website/lawyers/lawyer-2/blog/images/d2abf611-803f-45d2-a0ed-a0ddbf253926.jpeg\" alt=\"Image\"></figure>','lawyer-two/1762691521.jpg','\"[\\\"adsfasdfsad\\\"]\"',4,5,'published','2025-11-09 07:32:01','0',NULL,NULL,'[]','[{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/d2abf611-803f-45d2-a0ed-a0ddbf253926.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":1,\"created_at\":\"2025-11-09T12:32:01.166637Z\"}]','[]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T12:32:01.166242Z\"},{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/d2abf611-803f-45d2-a0ed-a0ddbf253926.jpeg\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":1,\"created_at\":\"2025-11-09T12:32:01.166637Z\"}]','2025-11-09 07:32:01','2025-11-11 15:16:09'),(12,'d2b7a2a6-ea6c-475e-b57a-62f886ad96f6',2,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T12:34:45.273174Z\"}]',1,'New Post','new-post','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/5b4df997-dadd-471a-bcb4-193ada8f0bbb.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Cation \"},\"position\":2},{\"id\":\"element_5\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3},{\"id\":\"element_4\",\"type\":\"banner\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/13eec08e-b44f-4e5c-a9a9-d94daea69c3d.jpeg\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":4}],\"metadata\":{\"created\":\"2025-11-09T12:34:44.271Z\",\"total_elements\":5,\"version\":\"1.0\"}}','Here is the brefe description for you post','<h2>New Heading</h2><p>Enter your text content here...</p><figure><img src=\"http://localhost:8000/website/lawyers/lawyer-2/blog/images/5b4df997-dadd-471a-bcb4-193ada8f0bbb.jpeg\" alt=\"Image\"><figcaption>Image Cation </figcaption></figure><div class=\"row\"><div class=\"col-md-6\"><p>Left column content...</p></div><div class=\"col-md-6\"><p>Right column content...</p></div></div><div class=\"banner\"><img src=\"http://localhost:8000/website/lawyers/lawyer-2/blog/images/13eec08e-b44f-4e5c-a9a9-d94daea69c3d.jpeg\" alt=\"Banner\"><div class=\"banner-content\"><h2>Banner Title</h2><p>Banner subtitle</p></div></div>','lawyer-two/1762691685.jpg','\"[\\\"tag one\\\",\\\"tag 2\\\"]\"',60,5,'published','2025-11-09 07:34:45','0',NULL,NULL,'[{\"id\":\"element_4\",\"type\":\"banner\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/13eec08e-b44f-4e5c-a9a9-d94daea69c3d.jpeg\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":4,\"created_at\":\"2025-11-09T12:34:45.274468Z\"}]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/5b4df997-dadd-471a-bcb4-193ada8f0bbb.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Cation \"},\"position\":2,\"created_at\":\"2025-11-09T12:34:45.273897Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1,\"created_at\":\"2025-11-09T12:34:45.273595Z\"}]','[{\"id\":\"element_5\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3,\"created_at\":\"2025-11-09T12:34:45.274185Z\"}]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T12:34:45.273174Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1,\"created_at\":\"2025-11-09T12:34:45.273595Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/5b4df997-dadd-471a-bcb4-193ada8f0bbb.jpeg\",\"alt\":\"Image\",\"caption\":\"Image Cation \"},\"position\":2,\"created_at\":\"2025-11-09T12:34:45.273897Z\"},{\"id\":\"element_5\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":3,\"created_at\":\"2025-11-09T12:34:45.274185Z\"},{\"id\":\"element_4\",\"type\":\"banner\",\"content\":{\"src\":\"lawyers\\/lawyer-2\\/blog\\/images\\/13eec08e-b44f-4e5c-a9a9-d94daea69c3d.jpeg\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":4,\"created_at\":\"2025-11-09T12:34:45.274468Z\"}]','2025-11-09 07:34:45','2025-11-12 14:41:35'),(13,'558f554c-cbcd-4c44-a299-800a4c83a575',2,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"hghhhhh New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T13:39:49.288296Z\"}]',1,'= vnbmnbmnb','vnbmnbmnb','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"hghhhhh New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/acd640a7-341d-48e4-982d-0153f4fb9b11.jpeg\",\"alt\":\"Image\",\"caption\":\"nbjgjhgjhg\"},\"position\":2},{\"id\":\"element_4\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/b9f6fbfc-911a-4244-8653-145b5dab6357.jpeg\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":3},{\"id\":\"element_5\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":4}],\"metadata\":{\"created\":\"2025-11-09T13:39:48.422Z\",\"total_elements\":5,\"version\":\"1.0\"}}','vcbvcbvcbvgjh','<h2>hghhhhh New Heading</h2><p>Enter your text content here...</p><figure><img src=\"http://localhost:8000/website/lawyers/lawyer-2/blog/images/acd640a7-341d-48e4-982d-0153f4fb9b11.jpeg\" alt=\"Image\"><figcaption>nbjgjhgjhg</figcaption></figure><div class=\"banner\"><img src=\"http://localhost:8000/website/lawyers/lawyer-2/blog/images/b9f6fbfc-911a-4244-8653-145b5dab6357.jpeg\" alt=\"Banner\"><div class=\"banner-content\"><h2>Banner Title</h2><p>Banner subtitle</p></div></div><div class=\"row\"><div class=\"col-md-6\"><p>Left column content...</p></div><div class=\"col-md-6\"><p>Right column content...</p></div></div>','lawyer-two/1762693513.jpg','\"[\\\"bhjgjhg\\\"]\"',4,5,'published','2025-11-09 08:05:58','0',NULL,NULL,'[{\"id\":\"element_4\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/b9f6fbfc-911a-4244-8653-145b5dab6357.jpeg\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":3,\"created_at\":\"2025-11-09T13:39:49.289869Z\"}]','[{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/acd640a7-341d-48e4-982d-0153f4fb9b11.jpeg\",\"alt\":\"Image\",\"caption\":\"nbjgjhgjhg\"},\"position\":2,\"created_at\":\"2025-11-09T13:39:49.289469Z\"}]','[{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1,\"created_at\":\"2025-11-09T13:39:49.288973Z\"}]','[{\"id\":\"element_5\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":4,\"created_at\":\"2025-11-09T13:39:49.290277Z\"}]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"hghhhhh New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-09T13:39:49.288296Z\"},{\"id\":\"element_2\",\"type\":\"text\",\"content\":{\"content\":\"<p>Enter your text content here...<\\/p>\"},\"position\":1,\"created_at\":\"2025-11-09T13:39:49.288973Z\"},{\"id\":\"element_3\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/acd640a7-341d-48e4-982d-0153f4fb9b11.jpeg\",\"alt\":\"Image\",\"caption\":\"nbjgjhgjhg\"},\"position\":2,\"created_at\":\"2025-11-09T13:39:49.289469Z\"},{\"id\":\"element_4\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-2\\/blog\\/images\\/b9f6fbfc-911a-4244-8653-145b5dab6357.jpeg\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":3,\"created_at\":\"2025-11-09T13:39:49.289869Z\"},{\"id\":\"element_5\",\"type\":\"columns\",\"content\":{\"left\":\"<p>Left column content...<\\/p>\",\"right\":\"<p>Right column content...<\\/p>\"},\"position\":4,\"created_at\":\"2025-11-09T13:39:49.290277Z\"}]','2025-11-09 08:05:13','2025-11-11 15:16:13'),(14,'7c01a532-e5ad-4793-b593-a28a1e096ff7',3,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-11T20:07:38.135308Z\"}]',1,'Officia et irure aut','officia-et-irure-aut','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0}],\"metadata\":{\"created\":\"2025-11-11T20:07:37.281Z\",\"total_elements\":1,\"version\":\"1.0\"}}','Eum commodo sint se','<h2>New Heading</h2>',NULL,'\"[\\\"fgdsfgdf\\\",\\\"New\\\",\\\"TaGS\\\"]\"',2,5,'published','2025-11-11 14:37:04','0',NULL,NULL,'[]','[]','[]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-11T20:07:38.135308Z\"}]','2025-11-11 14:37:04','2025-11-16 14:29:21'),(15,'b4d99bff-ea62-4edc-b335-17ff315c3589',3,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-11T20:06:31.061957Z\"}]',1,'Provident mollit ad','provident-mollit-ad','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0}],\"metadata\":{\"created\":\"2025-11-11T20:06:30.169Z\",\"total_elements\":1,\"version\":\"1.0\"}}','Irure accusamus nost','<h2>New Heading</h2>',NULL,'\"[\\\"fdgdfgsdfg\\\",\\\"New\\\",\\\"Tags\\\"]\"',10,5,'published','2025-11-11 14:37:52','0',NULL,NULL,'[]','[]','[]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-11T20:06:31.061957Z\"}]','2025-11-11 14:37:52','2025-11-12 06:34:07'),(16,'6e8419fb-dc73-44fc-88d1-4e90ab502fcc',4,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-19T11:50:29.724917Z\"}]',1,'Vel quis distinctio','vel-quis-distinctio','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/efda3e17-0586-4809-900f-195f02ba086b.png\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/ed4050a3-d01c-4fa1-ab2f-294fcebc19fd.png\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":2}],\"metadata\":{\"created\":\"2025-11-19T11:50:28.318Z\",\"total_elements\":3,\"version\":\"1.0\"}}','Fugiat quis corrupti','<h2>New Heading</h2><figure><img src=\"http://localhost:8000/website/lawyers/lawyer-4/blog/images/efda3e17-0586-4809-900f-195f02ba086b.png\" alt=\"Image\"></figure><div class=\"banner\"><img src=\"http://localhost:8000/website/lawyers/lawyer-4/blog/images/ed4050a3-d01c-4fa1-ab2f-294fcebc19fd.png\" alt=\"Banner\"><div class=\"banner-content\"><h2>Banner Title</h2><p>Banner subtitle</p></div></div>',NULL,'\"[\\\"Voluptatum consequat\\\"]\"',4,5,'published','2025-11-19 06:14:51','0',NULL,NULL,'[{\"id\":\"element_3\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/ed4050a3-d01c-4fa1-ab2f-294fcebc19fd.png\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":2,\"created_at\":\"2025-11-19T11:50:29.725435Z\"}]','[{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/efda3e17-0586-4809-900f-195f02ba086b.png\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":1,\"created_at\":\"2025-11-19T11:50:29.725194Z\"}]','[]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Heading\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-19T11:50:29.724917Z\"},{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/efda3e17-0586-4809-900f-195f02ba086b.png\",\"alt\":\"Image\",\"caption\":\"\"},\"position\":1,\"created_at\":\"2025-11-19T11:50:29.725194Z\"},{\"id\":\"element_3\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/ed4050a3-d01c-4fa1-ab2f-294fcebc19fd.png\",\"title\":\"Banner Title\",\"subtitle\":\"Banner subtitle\"},\"position\":2,\"created_at\":\"2025-11-19T11:50:29.725435Z\"}]','2025-11-19 06:14:51','2025-11-19 06:50:33'),(17,'57904f1a-0925-4085-929d-bebee75cabf9',4,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Headingasdfasdfsadfasdfa\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-19T11:52:37.051282Z\"}]',1,'Khalid Testing Update','khalid-testing-update','{\"elements\":[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Headingasdfasdfsadfasdfa\",\"level\":\"h2\"},\"position\":0},{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/46bd0b6a-872a-4e42-9c45-76b295fe7561.png\",\"alt\":\"Image\",\"caption\":\"adfasdfasdgsdgd\"},\"position\":1},{\"id\":\"element_3\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/e6b11e7a-0cd3-41c8-bb63-df8085a72b35.jpeg\",\"title\":\"Banner Titleadsfasdf\",\"subtitle\":\"Banner subtitleasdfasd\"},\"position\":2}],\"metadata\":{\"created\":\"2025-11-19T11:52:36.617Z\",\"total_elements\":3,\"version\":\"1.0\"}}','test','<h2>New Headingasdfasdfsadfasdfa</h2><figure><img src=\"http://localhost:8000/website/lawyers/lawyer-4/blog/images/46bd0b6a-872a-4e42-9c45-76b295fe7561.png\" alt=\"Image\"><figcaption>adfasdfasdgsdgd</figcaption></figure><div class=\"banner\"><img src=\"http://localhost:8000/website/lawyers/lawyer-4/blog/images/e6b11e7a-0cd3-41c8-bb63-df8085a72b35.jpeg\" alt=\"Banner\"><div class=\"banner-content\"><h2>Banner Titleadsfasdf</h2><p>Banner subtitleasdfasd</p></div></div>',NULL,'\"[\\\"Eos sint delectus t\\\"]\"',2,5,'published','2025-11-19 06:51:49','0',NULL,NULL,'[{\"id\":\"element_3\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/e6b11e7a-0cd3-41c8-bb63-df8085a72b35.jpeg\",\"title\":\"Banner Titleadsfasdf\",\"subtitle\":\"Banner subtitleasdfasd\"},\"position\":2,\"created_at\":\"2025-11-19T11:52:37.051649Z\"}]','[{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/46bd0b6a-872a-4e42-9c45-76b295fe7561.png\",\"alt\":\"Image\",\"caption\":\"adfasdfasdgsdgd\"},\"position\":1,\"created_at\":\"2025-11-19T11:52:37.051508Z\"}]','[]','[]',NULL,'[{\"id\":\"element_1\",\"type\":\"heading\",\"content\":{\"text\":\"New Headingasdfasdfsadfasdfa\",\"level\":\"h2\"},\"position\":0,\"created_at\":\"2025-11-19T11:52:37.051282Z\"},{\"id\":\"element_2\",\"type\":\"image\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/46bd0b6a-872a-4e42-9c45-76b295fe7561.png\",\"alt\":\"Image\",\"caption\":\"adfasdfasdgsdgd\"},\"position\":1,\"created_at\":\"2025-11-19T11:52:37.051508Z\"},{\"id\":\"element_3\",\"type\":\"banner\",\"content\":{\"src\":\"http:\\/\\/localhost:8000\\/website\\/lawyers\\/lawyer-4\\/blog\\/images\\/e6b11e7a-0cd3-41c8-bb63-df8085a72b35.jpeg\",\"title\":\"Banner Titleadsfasdf\",\"subtitle\":\"Banner subtitleasdfasd\"},\"position\":2,\"created_at\":\"2025-11-19T11:52:37.051649Z\"}]','2025-11-19 06:51:49','2025-11-19 06:52:40');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-kaleemmahsud@gmail.com|127.0.0.1','i:3;',1763310438),('laravel-cache-kaleemmahsud@gmail.com|127.0.0.1:timer','i:1763310438;',1763310438);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `blog_post_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_blog_post_id_index` (`blog_post_id`),
  KEY `comments_parent_id_index` (`parent_id`),
  KEY `comments_status_index` (`status`),
  KEY `comments_blog_post_id_status_index` (`blog_post_id`,`status`),
  CONSTRAINT `comments_blog_post_id_foreign` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,6,12,NULL,NULL,NULL,'Testing here','approved','2025-11-11 05:48:11','2025-11-12 14:09:21'),(2,6,12,1,NULL,NULL,'here is aonther comment','approved','2025-11-11 05:56:53','2025-11-11 05:56:53'),(3,7,12,1,NULL,NULL,'Hello waseem','approved','2025-11-11 06:00:08','2025-11-11 06:00:08'),(4,7,12,NULL,NULL,NULL,'This is khalid message','approved','2025-11-11 06:00:32','2025-11-11 06:00:32'),(5,4,10,NULL,NULL,NULL,'Testing Comment','approved','2025-11-12 12:07:27','2025-11-12 15:03:56'),(6,4,10,5,NULL,NULL,'Hello lawyere two','pending','2025-11-12 12:07:52','2025-11-12 15:04:02'),(7,4,10,6,NULL,NULL,'I khow You very well','rejected','2025-11-12 12:08:10','2025-11-12 15:02:46'),(8,4,10,7,NULL,NULL,'how Well you know mee','approved','2025-11-12 12:08:30','2025-11-12 15:01:44'),(9,4,10,8,NULL,NULL,'I thing this is last one','approved','2025-11-12 12:08:49','2025-11-12 12:08:49'),(10,4,10,NULL,NULL,NULL,'nop this is 5 charactore','approved','2025-11-12 12:09:25','2025-11-12 12:09:25'),(11,4,10,9,NULL,NULL,'lets check once more','pending','2025-11-12 12:09:41','2025-11-12 15:04:32'),(12,4,10,11,NULL,NULL,'good job','approved','2025-11-12 12:10:32','2025-11-12 12:10:32'),(13,4,10,12,NULL,NULL,'fdgfsgfsg','rejected','2025-11-12 12:11:10','2025-11-12 15:02:27'),(14,4,10,13,NULL,NULL,'adsfasdfasdf','pending','2025-11-12 12:11:25','2025-11-12 15:02:14');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `educations`
--

DROP TABLE IF EXISTS `educations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `educations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `degree` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `graduation_year` year(4) NOT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `educations_uuid_unique` (`uuid`),
  KEY `educations_lawyer_id_foreign` (`lawyer_id`),
  CONSTRAINT `educations_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `educations`
--

LOCK TABLES `educations` WRITE;
/*!40000 ALTER TABLE `educations` DISABLE KEYS */;
INSERT INTO `educations` VALUES (1,'a2ef9019-9873-4657-b908-2b6454ef8830',2,'Corporis est iste si','Quia laudantium vol',1975,'Vel dolor cillum dic',1,'2025-11-04 02:30:36','2025-11-04 02:32:50'),(2,'2312a295-4fb4-4d42-83c8-267ea459e056',2,'Quae officia molesti','Neque cupidatat quo',1982,'Quo consequatur aute',3,'2025-11-04 02:30:53','2025-11-04 02:32:59'),(3,'f89a8014-3252-437f-9344-2f4ebbcec133',2,'Rerum odio labore in','Proident accusamus',1998,'Illum voluptate eaq',2,'2025-11-04 02:32:26','2025-11-04 02:33:06');
/*!40000 ALTER TABLE `educations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `position` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `experiences_uuid_unique` (`uuid`),
  KEY `experiences_lawyer_id_foreign` (`lawyer_id`),
  CONSTRAINT `experiences_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiences`
--

LOCK TABLES `experiences` WRITE;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` VALUES (2,'312da056-ab45-4da4-9b79-934f61793fe7',2,'Voluptatem iusto fug','Clayton Byers Trading','2014-05-08',NULL,1,'Ab aut modi providen',82,'2025-11-04 04:12:31','2025-11-04 04:12:31');
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lawyer_specialization`
--

DROP TABLE IF EXISTS `lawyer_specialization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lawyer_specialization` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `specialization_id` bigint(20) unsigned NOT NULL,
  `years_of_experience` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lawyer_specialization_lawyer_id_specialization_id_unique` (`lawyer_id`,`specialization_id`),
  KEY `lawyer_specialization_specialization_id_foreign` (`specialization_id`),
  CONSTRAINT `lawyer_specialization_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lawyer_specialization_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lawyer_specialization`
--

LOCK TABLES `lawyer_specialization` WRITE;
/*!40000 ALTER TABLE `lawyer_specialization` DISABLE KEYS */;
INSERT INTO `lawyer_specialization` VALUES (1,1,13,0,'2025-11-02 13:38:18','2025-11-02 13:38:18'),(23,2,1,0,'2025-11-05 00:56:47','2025-11-05 00:56:47'),(24,3,1,0,'2025-11-11 12:53:04','2025-11-11 12:53:04'),(25,4,2,0,'2025-11-12 15:38:15','2025-11-12 15:38:15'),(26,5,4,0,'2025-11-12 15:41:01','2025-11-12 15:41:01');
/*!40000 ALTER TABLE `lawyer_specialization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lawyers`
--

DROP TABLE IF EXISTS `lawyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lawyers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  `bar_number` varchar(255) DEFAULT NULL,
  `license_state` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `years_of_experience` int(11) NOT NULL DEFAULT 0,
  `firm_name` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `services` text DEFAULT NULL,
  `awards` text DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lawyers_uuid_unique` (`uuid`),
  UNIQUE KEY `lawyers_bar_number_unique` (`bar_number`),
  KEY `lawyers_user_id_foreign` (`user_id`),
  CONSTRAINT `lawyers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lawyers`
--

LOCK TABLES `lawyers` WRITE;
/*!40000 ALTER TABLE `lawyers` DISABLE KEYS */;
INSERT INTO `lawyers` VALUES (1,3,'391623fe-3e85-4a1c-88d6-08a95f8636a3',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,51,'2025-11-02 13:38:17','2025-11-08 02:06:06',NULL),(2,4,'31d423e1-75fd-40dd-9e01-54be28dfe490','654','Culpa et consectetur','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',2017,'Khan & Associates','https://www.khanassociate.com.au','Gulzara Higree Dawood ragency hourse H.404','Karachi','Pakistan','91310',NULL,9.00,'Labore hic quia vita','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries',1,1,53,'2025-11-02 13:57:59','2025-11-18 10:09:03',NULL),(3,8,'df84cafc-5950-4b42-b393-fb14ed287243',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,0,'2025-11-11 12:53:03','2025-11-11 12:53:03',NULL),(4,9,'ebbbdd31-42c7-4105-a594-0de1a59218f9',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,0,'2025-11-12 15:38:15','2025-11-12 15:38:15',NULL),(5,11,'7f725ad3-e989-4646-ab5c-28a58569a34b',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,'2025-11-12 15:41:01','2025-11-12 15:41:01',NULL);
/*!40000 ALTER TABLE `lawyers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_10_31_101950_create_lawyers_table',1),(5,'2025_10_31_101951_create_specializations_table',1),(6,'2025_10_31_101953_create_education_table',1),(7,'2025_10_31_101954_create_experiences_table',1),(8,'2025_10_31_101955_create_portfolios_table',1),(9,'2025_10_31_101957_create_reviews_table',1),(10,'2025_10_31_101958_create_team_members_table',1),(11,'2025_10_31_101959_create_clients_table',1),(12,'2025_10_31_102000_create_legal_cases_table',1),(13,'2025_10_31_102002_create_case_documents_table',1),(14,'2025_10_31_102003_create_case_notes_table',1),(15,'2025_10_31_102005_create_case_hearings_table',1),(16,'2025_10_31_102007_create_blog_categories_table',1),(17,'2025_10_31_102009_create_blog_posts_table',1),(18,'2025_10_31_102010_create_pages_table',1),(19,'2025_10_31_102012_create_visitors_table',1),(20,'2025_10_31_102517_create_user_activities_table',1),(21,'2025_10_31_105110_lawyer_specialization',1),(22,'2025_10_31_114331_create_permission_tables',1),(23,'2025_11_11_102740_create_comments_table',2),(25,'2025_11_17_164051_create_youtube_videos_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',3),(2,'App\\Models\\User',4),(2,'App\\Models\\User',8),(2,'App\\Models\\User',9),(2,'App\\Models\\User',11),(3,'App\\Models\\User',2),(3,'App\\Models\\User',5),(3,'App\\Models\\User',6),(3,'App\\Models\\User',7),(3,'App\\Models\\User',10);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'manage_users','web','2025-11-02 13:27:21','2025-11-02 13:27:21'),(2,'manage_lawyers','web','2025-11-02 13:27:21','2025-11-02 13:27:21'),(3,'manage_clients','web','2025-11-02 13:27:21','2025-11-02 13:27:21'),(4,'manage_cases','web','2025-11-02 13:27:21','2025-11-02 13:27:21'),(5,'manage_blog','web','2025-11-02 13:27:21','2025-11-02 13:27:21'),(6,'view_dashboard','web','2025-11-02 13:27:21','2025-11-02 13:27:21'),(7,'view_reports','web','2025-11-02 13:27:21','2025-11-02 13:27:21'),(8,'manage_settings','web','2025-11-02 13:27:21','2025-11-02 13:27:21');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolios`
--

DROP TABLE IF EXISTS `portfolios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portfolios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `case_type` varchar(255) DEFAULT NULL,
  `outcome` varchar(255) DEFAULT NULL,
  `year` year(4) NOT NULL,
  `challenges` text DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `case_value` decimal(15,2) DEFAULT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `portfolios_uuid_unique` (`uuid`),
  UNIQUE KEY `portfolios_slug_unique` (`slug`),
  KEY `portfolios_lawyer_id_foreign` (`lawyer_id`),
  CONSTRAINT `portfolios_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolios`
--

LOCK TABLES `portfolios` WRITE;
/*!40000 ALTER TABLE `portfolios` DISABLE KEYS */;
/*!40000 ALTER TABLE `portfolios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `rating` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `review` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_uuid_unique` (`uuid`),
  KEY `reviews_lawyer_id_foreign` (`lawyer_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'9584f5b3-271b-4b5b-a073-04fe1d622c07',1,2,3,'Title Here','You are working greate sir','approved',0,'2025-11-06 05:43:31','2025-11-06 05:43:31'),(3,'b27aecb0-1fa0-4ed3-96d8-006e2551a646',1,5,3,NULL,'sadfasdfasdfsadfasdf','pending',0,'2025-11-07 05:02:12','2025-11-07 05:02:12'),(4,'1006ecf6-5e64-4010-9b1c-8cb675e82f5b',2,5,4,NULL,'asfdsfasdfsadgsdg','pending',0,'2025-11-07 05:08:58','2025-11-07 05:08:58');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(5,2),(6,1),(6,2),(7,1),(8,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','web','2025-11-02 13:27:20','2025-11-02 13:27:20'),(2,'lawyer','web','2025-11-02 13:27:20','2025-11-02 13:27:20'),(3,'client','web','2025-11-02 13:27:20','2025-11-02 13:27:20'),(4,'user','web','2025-11-02 13:27:20','2025-11-02 13:27:20');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6tmUSEJzBwlN9Uf45hdWC2VbfDZ3XWoGxNGhSTGW',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicUkwdFFSQ1F3dUxIVUJpR05IZnNiSzB0ZGc4cmExZk9qbDUySlc1WCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==',1781178368);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specializations`
--

DROP TABLE IF EXISTS `specializations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specializations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `specializations_uuid_unique` (`uuid`),
  UNIQUE KEY `specializations_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specializations`
--

LOCK TABLES `specializations` WRITE;
/*!40000 ALTER TABLE `specializations` DISABLE KEYS */;
INSERT INTO `specializations` VALUES (1,'9297212b-fe60-42ed-9bd3-9cfade25f03f','Criminal Law','criminal-law','Legal practice focused on crimes and criminal offenses','fa-gavel',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(2,'b3d2fb29-9eb0-426a-ad3a-5a5ea550ce0b','Civil Law','civil-law','Legal practice dealing with disputes between individuals and organizations','fa-balance-scale',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(3,'11f0c790-b597-4211-ae97-b8640627dfac','Corporate Law','corporate-law','Legal practice focused on business and corporate matters','fa-building',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(4,'0f0ccc99-eeb6-45d9-ad98-0064431da761','Family Law','family-law','Legal practice dealing with family-related issues and domestic relations','fa-home',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(5,'a23ee877-00c8-41b5-8249-3567c388ff22','Real Estate Law','real-estate-law','Legal practice focused on property and real estate transactions','fa-house-user',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(6,'3f4caafa-6ed6-4cf6-b3a6-f02d4c4e5794','Intellectual Property Law','intellectual-property-law','Legal practice dealing with patents, trademarks, and copyrights','fa-copyright',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(7,'1e467580-a16a-4c38-8d08-6d533afb4934','Employment Law','employment-law','Legal practice focused on workplace rights and employer-employee relations','fa-briefcase',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(8,'ec7f471a-790b-4685-a77f-8a75e798dce4','Immigration Law','immigration-law','Legal practice dealing with immigration and citizenship matters','fa-passport',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(9,'c56aa2b0-5573-49ea-b4e1-b6e473a61a94','Tax Law','tax-law','Legal practice focused on tax-related issues and compliance','fa-receipt',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(10,'e8bf1fc7-4008-4b6a-884a-d39151c98bf1','Banking & Finance Law','banking-finance-law','Legal practice dealing with financial institutions and transactions','fa-university',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(11,'d67d2534-505f-4e03-bed9-d83c1efa8a47','Environmental Law','environmental-law','Legal practice focused on environmental protection and regulations','fa-leaf',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(12,'cd99a502-b3d0-4094-903d-ae3a452928a9','Health Care Law','health-care-law','Legal practice dealing with healthcare regulations and medical issues','fa-heartbeat',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(13,'6e8bea40-a8a9-440e-9527-d5fa0c63bf58','Bankruptcy Law','bankruptcy-law','Legal practice focused on debt relief and financial restructuring','fa-file-invoice-dollar',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(14,'f55fd9ef-728b-424c-b45d-ccd394be9e78','Personal Injury Law','personal-injury-law','Legal practice dealing with injuries and accidents','fa-user-injured',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(15,'775dbbb4-12b9-404e-9775-89bd00edf768','Estate Planning','estate-planning','Legal practice focused on wills, trusts, and estate management','fa-scroll',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(16,'238b7915-c743-41ff-a27d-26f07580dea0','Contract Law','contract-law','Legal practice dealing with agreements and contractual obligations','fa-file-contract',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(17,'29054eb3-bfec-4964-b7a1-b7200e767166','International Law','international-law','Legal practice focused on cross-border and global legal matters','fa-globe',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(18,'48934749-b5f1-4b8a-8f82-fe1529563d65','Constitutional Law','constitutional-law','Legal practice dealing with constitutional rights and government powers','fa-landmark',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(19,'55cc03a6-03f5-44b4-9531-d6ba4d7d7294','Cyber Law','cyber-law','Legal practice focused on internet, technology, and digital rights','fa-laptop-code',1,'2025-11-02 13:27:22','2025-11-02 13:27:22'),(20,'c935f195-1a20-4cf9-99ee-f7a49b95c959','Entertainment Law','entertainment-law','Legal practice dealing with media, entertainment, and arts','fa-film',1,'2025-11-02 13:27:22','2025-11-02 13:27:22');
/*!40000 ALTER TABLE `specializations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_activities`
--

DROP TABLE IF EXISTS `user_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_activities_user_id_foreign` (`user_id`),
  CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activities`
--

LOCK TABLES `user_activities` WRITE;
/*!40000 ALTER TABLE `user_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('super_admin','lawyer','client') NOT NULL DEFAULT 'client',
  `phone` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin',NULL,'abdulkhalidmasood66@gmail.com','super_admin',NULL,NULL,NULL,'$2y$12$af3cyO5RFMEmmBh497kET.L8vByy61NVunSuHNQUJwIzt6zSt7TrW',1,NULL,'2025-11-02 13:27:23','2025-11-02 13:27:23',NULL),(2,'Client one',NULL,'client@gmail.com','client',NULL,NULL,NULL,'$2y$12$NbY.p6UTBN.ZaoUuuK41cewFzt4zYciBjneJDuqjWE/TXKI4BZxBG',1,NULL,'2025-11-02 13:29:27','2025-11-02 13:29:27',NULL),(3,'Lawyer One',NULL,'lawyerone@gmail.com','lawyer',NULL,NULL,NULL,'$2y$12$af3cyO5RFMEmmBh497kET.L8vByy61NVunSuHNQUJwIzt6zSt7TrW',1,NULL,'2025-11-02 13:38:17','2025-11-02 13:38:17',NULL),(4,'lawyer two',NULL,'lawyer@gmail.com','lawyer',NULL,'lawyer-one/1762320743.jpg',NULL,'$2y$12$NbY.p6UTBN.ZaoUuuK41cewFzt4zYciBjneJDuqjWE/TXKI4BZxBG',1,'gEIQhHhX1g6Nk1OVcFt5tYRuDEX6iKadrpylLlfgnj5eBLTR2HEqr3dkJLMV','2025-11-02 13:57:59','2025-11-05 00:32:24',NULL),(5,'client1 one',NULL,'client1@gmail.com','client',NULL,NULL,NULL,'$2y$12$NbY.p6UTBN.ZaoUuuK41cewFzt4zYciBjneJDuqjWE/TXKI4BZxBG',1,NULL,'2025-11-07 04:51:30','2025-11-07 04:51:30',NULL),(6,'waseem khan',NULL,'waseem@gmail.com','client',NULL,'lawyer-one/1762320743.jpg',NULL,'$2y$12$NbY.p6UTBN.ZaoUuuK41cewFzt4zYciBjneJDuqjWE/TXKI4BZxBG',1,'sshocHEJDwml7LslVTgBW94o4OkEOO1PFaZLjOQeo8ir5wTaeB2FQ8ngPXEq','2025-11-11 05:10:05','2025-11-11 05:10:05',NULL),(7,'khalid khalid',NULL,'khalidkhalid@gmail.com','client',NULL,NULL,NULL,'$2y$12$NbY.p6UTBN.ZaoUuuK41cewFzt4zYciBjneJDuqjWE/TXKI4BZxBG',1,NULL,'2025-11-11 05:58:54','2025-11-11 05:58:54',NULL),(8,'Kaleem Mehsud',NULL,'kaleemmehsud@gmail.com','lawyer',NULL,NULL,NULL,'$2y$12$R8mpfx22J5O1vhIeYsNheeNi3WZF9dxnlEwy4zKf9rD5HPNZUgz0.',1,NULL,'2025-11-11 12:53:00','2025-11-11 12:53:00',NULL),(9,'Hakeem Khan',NULL,'hakeem@gmail.com','lawyer',NULL,NULL,NULL,'$2y$12$NbY.p6UTBN.ZaoUuuK41cewFzt4zYciBjneJDuqjWE/TXKI4BZxBG',1,'apYXKIT0eNoEMJ5TjO6US4DkIieYDdizREHP8kBqr6FaOOzvsH1jez24qGkx','2025-11-12 15:38:11','2025-11-12 15:38:11',NULL),(10,'Rahman Rahman',NULL,'rahman@gmail.com','client',NULL,NULL,NULL,'$2y$12$ssDTcAPxSNsgCFNHr69/7eq75JiT7pl3J2GqRowHGJgo7l1AmbhzS',1,NULL,'2025-11-12 15:40:04','2025-11-12 15:40:04',NULL),(11,'kamran kamran',NULL,'kamran@gamil.com','lawyer','02838323432',NULL,NULL,'$2y$12$MyAPeXJA/PryrpwaNoXYPudDeaBd4kR9M6Jqjm1Qb69qAKLxWQ.Iq',1,NULL,'2025-11-12 15:41:00','2025-11-12 15:41:00',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_views`
--

DROP TABLE IF EXISTS `video_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_views` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `youtube_video_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `watch_time` int(11) NOT NULL DEFAULT 0,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_views_youtube_video_id_index` (`youtube_video_id`),
  KEY `video_views_user_id_index` (`user_id`),
  KEY `video_views_ip_address_index` (`ip_address`),
  KEY `video_views_youtube_video_id_user_id_index` (`youtube_video_id`,`user_id`),
  CONSTRAINT `video_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `video_views_youtube_video_id_foreign` FOREIGN KEY (`youtube_video_id`) REFERENCES `youtube_videos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_views`
--

LOCK TABLES `video_views` WRITE;
/*!40000 ALTER TABLE `video_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `page_visited` varchar(255) NOT NULL,
  `time_spent` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitors_lawyer_id_foreign` (`lawyer_id`),
  CONSTRAINT `visitors_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitors`
--

LOCK TABLES `visitors` WRITE;
/*!40000 ALTER TABLE `visitors` DISABLE KEYS */;
INSERT INTO `visitors` VALUES (12,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',450,'2025-11-06 05:08:10','2025-11-06 05:15:42'),(13,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',895,'2025-11-06 05:23:10','2025-11-06 05:23:16'),(14,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',60,'2025-11-06 05:23:43','2025-11-06 05:24:47'),(15,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',450,'2025-11-06 05:25:22','2025-11-06 05:32:54'),(16,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',0,'2025-11-06 05:33:30','2025-11-06 05:33:30'),(17,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',31,'2025-11-06 05:33:51','2025-11-06 05:34:12'),(18,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',90,'2025-11-06 05:34:13','2025-11-06 05:35:46'),(19,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',0,'2025-11-06 05:37:26','2025-11-06 05:37:26'),(20,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',30,'2025-11-06 05:37:58','2025-11-06 05:38:00'),(21,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',31,'2025-11-06 05:38:44','2025-11-06 05:39:20'),(22,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',60,'2025-11-06 05:43:32','2025-11-06 05:44:34'),(23,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',52,'2025-11-06 05:44:46','2025-11-06 05:45:42'),(24,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',210,'2025-11-06 05:48:20','2025-11-06 05:51:54'),(25,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',0,'2025-11-07 04:27:54','2025-11-07 04:27:54'),(26,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',5,'2025-11-07 04:34:22','2025-11-07 04:34:30'),(27,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',0,'2025-11-07 04:38:00','2025-11-07 04:38:00'),(28,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',2,'2025-11-07 04:38:06','2025-11-07 04:38:10'),(29,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',11,'2025-11-07 04:38:51','2025-11-07 04:39:05'),(30,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',0,'2025-11-07 04:39:06','2025-11-07 04:39:06'),(31,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',0,'2025-11-07 04:39:27','2025-11-07 04:39:27'),(32,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',0,'2025-11-07 04:41:57','2025-11-07 04:41:57'),(33,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',0,'2025-11-07 04:44:28','2025-11-07 04:44:28'),(34,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',60,'2025-11-07 04:46:55','2025-11-07 04:47:59'),(35,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',20,'2025-11-07 04:48:17','2025-11-07 04:48:40'),(36,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',30,'2025-11-07 04:49:28','2025-11-07 04:50:01'),(37,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',10,'2025-11-07 04:50:15','2025-11-07 04:50:27'),(38,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',5,'2025-11-07 04:50:30','2025-11-07 04:50:36'),(39,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',1,'2025-11-07 04:50:43','2025-11-07 04:50:46'),(40,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',23,'2025-11-07 04:51:42','2025-11-07 04:52:07'),(41,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',5,'2025-11-07 04:52:11','2025-11-07 04:52:49'),(42,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',17,'2025-11-07 04:52:52','2025-11-07 04:53:11'),(43,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',60,'2025-11-07 04:53:12','2025-11-07 04:54:14'),(44,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',67,'2025-11-07 04:54:22','2025-11-07 04:54:23'),(45,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',26,'2025-11-07 04:54:25','2025-11-07 04:54:50'),(46,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',64,'2025-11-07 04:54:52','2025-11-07 04:55:30'),(47,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',0,'2025-11-07 04:55:31','2025-11-07 04:55:31'),(48,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',60,'2025-11-07 04:55:37','2025-11-07 04:56:33'),(49,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',300,'2025-11-07 04:56:40','2025-11-07 05:01:42'),(50,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',6,'2025-11-07 05:02:02','2025-11-07 05:02:11'),(51,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',26,'2025-11-07 05:02:13','2025-11-07 05:02:41'),(52,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',177,'2025-11-07 05:02:42','2025-11-07 05:05:43'),(53,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',60,'2025-11-07 05:06:49','2025-11-07 05:07:51'),(54,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',19,'2025-11-07 05:08:00','2025-11-07 05:08:23'),(55,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',74,'2025-11-07 05:08:05','2025-11-07 05:08:06'),(56,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',0,'2025-11-07 05:08:24','2025-11-07 05:09:57'),(57,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',28,'2025-11-07 05:08:27','2025-11-07 05:08:57'),(58,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',12,'2025-11-07 05:08:59','2025-11-07 05:09:13'),(59,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',0,'2025-11-07 05:09:14','2025-11-07 05:09:55'),(60,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',120,'2025-11-07 05:09:59','2025-11-07 05:10:29'),(61,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490',14,'2025-11-07 05:10:27','2025-11-07 05:10:42'),(62,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3',146,'2025-11-07 05:10:44','2025-11-07 05:13:12'),(63,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',5,'2025-11-07 05:23:16','2025-11-08 02:27:27'),(64,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3/view',35,'2025-11-08 01:43:39','2025-11-08 01:44:23'),(65,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3/view',171,'2025-11-08 01:54:41','2025-11-08 01:57:38'),(66,1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/391623fe-3e85-4a1c-88d6-08a95f8636a3/view',34,'2025-11-08 02:06:06','2025-11-08 02:06:42'),(67,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',9,'2025-11-09 08:02:41','2025-11-09 08:02:53'),(68,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',60,'2025-11-11 13:00:20','2025-11-11 13:01:24'),(69,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',8,'2025-11-11 13:01:25','2025-11-11 13:01:38'),(70,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',90,'2025-11-11 13:01:39','2025-11-11 13:03:13'),(71,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',30,'2025-11-11 13:03:40','2025-11-11 13:04:14'),(72,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',64,'2025-11-11 13:04:48','2025-11-11 13:04:50'),(73,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',150,'2025-11-11 13:05:04','2025-11-11 13:07:37'),(74,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',7,'2025-11-11 13:08:27','2025-11-11 13:08:38'),(75,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',120,'2025-11-11 13:08:39','2025-11-11 13:10:43'),(76,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',133,'2025-11-11 13:10:56','2025-11-11 13:10:59'),(77,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',134,'2025-11-11 13:13:15','2025-11-11 13:13:18'),(78,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',32,'2025-11-11 13:13:52','2025-11-11 13:13:58'),(79,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',0,'2025-11-11 13:14:11','2025-11-11 13:14:11'),(80,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',41,'2025-11-11 13:14:56','2025-11-11 13:14:59'),(81,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',17,'2025-11-11 13:15:18','2025-11-11 13:15:21'),(82,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',45,'2025-11-11 13:16:08','2025-11-11 13:16:10'),(83,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',60,'2025-11-11 13:16:30','2025-11-11 13:17:36'),(84,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',71,'2025-11-11 13:17:46','2025-11-11 13:17:49'),(85,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',2129,'2025-11-11 13:18:15','2025-11-11 13:53:51'),(86,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',11,'2025-11-12 02:15:40','2025-11-12 02:15:56'),(87,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',84,'2025-11-12 02:19:55','2025-11-12 02:21:24'),(88,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',347,'2025-11-12 02:21:24','2025-11-12 02:27:15'),(89,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',664,'2025-11-12 02:31:18','2025-11-12 02:42:24'),(90,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',27,'2025-11-12 11:07:17','2025-11-12 11:07:47'),(91,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',304,'2025-11-12 11:12:25','2025-11-12 11:12:26'),(92,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',0,'2025-11-12 11:12:59','2025-11-12 11:12:59'),(93,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',60,'2025-11-12 11:13:28','2025-11-12 11:14:32'),(94,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',74,'2025-11-12 11:14:46','2025-11-12 11:14:49'),(95,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/find-lawyers','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',1200,'2025-11-12 11:15:10','2025-11-12 11:35:13'),(96,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',30,'2025-11-16 09:27:58','2025-11-16 09:28:30'),(97,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',608,'2025-11-16 09:38:08','2025-11-16 09:38:09'),(98,2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,NULL,'http://localhost:8000/','http://localhost:8000/lawyer/31d423e1-75fd-40dd-9e01-54be28dfe490/view',3,'2025-11-16 09:38:23','2025-11-18 10:09:09');
/*!40000 ALTER TABLE `visitors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `youtube_videos`
--

DROP TABLE IF EXISTS `youtube_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `youtube_videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `lawyer_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_topic` varchar(255) NOT NULL,
  `youtube_link` text NOT NULL,
  `youtube_video_id` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `display_count` int(11) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `total_view_time` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `thumbnail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`thumbnail`)),
  `duration` int(11) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `youtube_videos_uuid_unique` (`uuid`),
  KEY `youtube_videos_lawyer_id_index` (`lawyer_id`),
  KEY `youtube_videos_display_count_index` (`display_count`),
  KEY `youtube_videos_view_count_index` (`view_count`),
  KEY `youtube_videos_is_active_index` (`is_active`),
  KEY `youtube_videos_is_featured_index` (`is_featured`),
  KEY `youtube_videos_lawyer_id_is_active_index` (`lawyer_id`,`is_active`),
  CONSTRAINT `youtube_videos_lawyer_id_foreign` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `youtube_videos`
--

LOCK TABLES `youtube_videos` WRITE;
/*!40000 ALTER TABLE `youtube_videos` DISABLE KEYS */;
INSERT INTO `youtube_videos` VALUES (1,'3a2d4ea2-da48-4dba-8fb6-cf1994534a7f',4,'Dolorem neque molest','Cum cillum fugit ob','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ARSpBbpu3u4?si=Z8zPQU87Lu9rA_r_\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>','ARSpBbpu3u4','Unde pariatur Ex la',0,6,0,1,1,NULL,NULL,'2025-11-17 12:57:50','2025-11-17 12:57:50','2025-11-18 11:45:04',NULL),(2,'4dbc1f8e-58ca-4419-8088-34c0c19a78c8',2,'Illo culpa ad maiore','Non nostrum laborum','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ARSpBbpu3u4?si=Tb0r94pjfp-NqCmb\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>','ARSpBbpu3u4','Ullam iusto ex occae',2,8,0,1,1,NULL,NULL,'2025-11-18 07:56:08','2025-11-18 07:56:10','2025-11-18 10:14:29',NULL),(3,'bb42e2dc-8f10-42c4-8828-618f99ae5f2e',4,'Repudiandae non do r','Et in necessitatibus','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/bsvxKafcJcE?si=jIoRICJeHzcydr3Z\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>','bsvxKafcJcE','Eum ullam nesciunt',1,5,0,1,1,NULL,NULL,'2025-11-18 10:45:04','2025-11-18 10:45:08','2025-11-18 11:44:51',NULL);
/*!40000 ALTER TABLE `youtube_videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-11 17:02:00
