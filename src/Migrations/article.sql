# ************************************************************
# Host: 127.0.0.1 (MySQL 8.0.22)
# Database: cubexbase
# Generation Time: 2021-01-18 12:57:21 +0000
# ************************************************************

SET NAMES utf8mb4;


DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
    `id`         int unsigned                                          NOT NULL AUTO_INCREMENT,
    `title`      text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `content`    text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `slug`       text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `active`     tinyint(1) DEFAULT '1',
    `created_at` timestamp                                             NOT NULL,
    `updated_at` timestamp                                             NOT NULL,
    `deleted_at` timestamp,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci;
