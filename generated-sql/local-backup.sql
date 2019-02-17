
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- comments
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments`
(
    `comment_id` INTEGER NOT NULL AUTO_INCREMENT,
    `to_post` INTEGER NOT NULL,
    `to_comment` INTEGER,
    `made_by_user` INTEGER NOT NULL,
    `comment` VARCHAR(1000) NOT NULL,
    `active` TINYINT(1) NOT NULL,
    PRIMARY KEY (`comment_id`),
    INDEX `fk_post_id_idx` (`to_post`),
    INDEX `fk_c_user_id_idx` (`made_by_user`),
    INDEX `fk_c_comment_id_idx` (`to_comment`),
    CONSTRAINT `fk_c_comment_id`
        FOREIGN KEY (`to_comment`)
        REFERENCES `comments` (`comment_id`),
    CONSTRAINT `fk_c_post_id`
        FOREIGN KEY (`to_post`)
        REFERENCES `posts` (`post_id`),
    CONSTRAINT `fk_c_user_id`
        FOREIGN KEY (`made_by_user`)
        REFERENCES `users` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- post_details
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `post_details`;

CREATE TABLE `post_details`
(
    `post_details_id` INTEGER NOT NULL AUTO_INCREMENT,
    `post_text` VARCHAR(4000) NOT NULL,
    `post_id` INTEGER NOT NULL,
    `post_sequence` INTEGER,
    PRIMARY KEY (`post_details_id`),
    INDEX `fk_pd_post_id_idx` (`post_id`),
    CONSTRAINT `fk_pd_post_id`
        FOREIGN KEY (`post_id`)
        REFERENCES `posts` (`post_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- posts
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts`
(
    `post_id` INTEGER NOT NULL AUTO_INCREMENT,
    `post_title` VARCHAR(150) NOT NULL,
    `post_image_url` VARCHAR(256),
    `post_date` DATETIME NOT NULL,
    `active` TINYINT(1) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `times_visited` INTEGER,
    PRIMARY KEY (`post_id`),
    INDEX `fk_p_user_id_idx` (`user_id`),
    CONSTRAINT `fk_p_user_id`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sitesettings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sitesettings`;

CREATE TABLE `sitesettings`
(
    `site_name` VARCHAR(45) NOT NULL,
    `site_title` VARCHAR(45) NOT NULL,
    `site_subtitle` VARCHAR(45) NOT NULL,
    `updated` DATETIME NOT NULL,
    `by_user` INTEGER NOT NULL,
    `site_mail` VARCHAR(45),
    `site_activated` TINYINT(1) DEFAULT 0 NOT NULL,
    INDEX `fk_user_id_idx` (`by_user`),
    CONSTRAINT `fk_site_user_id`
        FOREIGN KEY (`by_user`)
        REFERENCES `users` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_details
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_details`;

CREATE TABLE `user_details`
(
    `user_id` INTEGER NOT NULL,
    `firstname` VARCHAR(45),
    `lastname` VARCHAR(45),
    `user_name` VARCHAR(45),
    `current_login` DATETIME NOT NULL,
    `last_login` DATETIME NOT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE INDEX `user_id_UNIQUE` (`user_id`),
    CONSTRAINT `fk_user_id`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `user_id` INTEGER NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(45) NOT NULL,
    `reg_date` DATETIME NOT NULL,
    `password` VARCHAR(256) NOT NULL,
    `role` INTEGER DEFAULT 1 NOT NULL,
    `active` TINYINT(1) DEFAULT 0 NOT NULL,
    `validated` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE INDEX `email_UNIQUE` (`email`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- validation_link
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `validation_link`;

CREATE TABLE `validation_link`
(
    `validation_id` VARCHAR(50) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created` DATETIME NOT NULL,
    `used` DATETIME,
    PRIMARY KEY (`validation_id`),
    UNIQUE INDEX `link_UNIQUE` (`validation_id`),
    INDEX `fk_user_id_idx` (`user_id`),
    CONSTRAINT `fk_val_user_id`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`user_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
