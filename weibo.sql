CREATE TABLE `weibo`
(
    `id`              int(11) unsigned NOT NULL AUTO_INCREMENT,
    `userid`          int(11) unsigned,
    `visible`         tinyint(4)                        DEFAULT '0' COMMENT '0公开 1自己可见 6好友圈可见',
    `mblogid`         varchar(100) CHARACTER SET utf8mb4   DEFAULT NULL COMMENT '形如Jxy7Ek5Mw',
    `created_at`      varchar(100) CHARACTER SET utf8mb4   DEFAULT NULL,
    `text_raw`        text CHARACTER SET utf8mb4,
    `text`            text CHARACTER SET utf8mb4,
    `long_text`       longtext CHARACTER SET utf8mb4,
    `source`          varchar(50) CHARACTER SET utf8mb4    DEFAULT NULL,
    `attitudes_count` int(11)                           DEFAULT NULL,
    `reads_count`     int(11)                           DEFAULT NULL,
    `comments_count`  int(11)                           DEFAULT NULL,
    `pic_num`         int(11)                           DEFAULT NULL,
    `pic_ids`         varchar(1000) CHARACTER SET utf8mb4  DEFAULT NULL COMMENT ',分隔',
    `pic_urls`        varchar(10000) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT ',分隔',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 301
  DEFAULT CHARSET = utf8mb4mb4;