
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- topic
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `topic`;

CREATE TABLE `topic`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `label` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- priority
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `priority`;

CREATE TABLE `priority`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `label` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `firstname` VARCHAR(50),
    `lastname` VARCHAR(50),
    `fullname` VARCHAR(100),
    `email` VARCHAR(50),
    `enabled` TINYINT(1),
    `salt` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `last_login` DATETIME,
    `locked` TINYINT(1),
    `expired` TINYINT(1),
    `expires_at` DATETIME,
    `roles` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- message
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `topic_id` INTEGER,
    `priority_id` INTEGER,
    `assigned_user_id` INTEGER,
    `username` VARCHAR(32) NOT NULL,
    `subject` VARCHAR(64) NOT NULL,
    `email` VARCHAR(50),
    `phone` VARCHAR(32),
    `header_mail` TEXT,
    `body` TEXT,
    `ip_address` VARCHAR(16),
    `status` VARCHAR(16) DEFAULT 'opened' NOT NULL,
    `source` VARCHAR(16),
    `overdue_date` DATETIME,
    `last_response_date` DATETIME,
    `creation_date` DATETIME,
    `modification_date` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `status_idx` (`status`),
    INDEX `source_idx` (`status`),
    INDEX `subject_idx` (`subject`),
    INDEX `email_idx` (`email`),
    INDEX `FI_sage_ibfk_1` (`topic_id`),
    INDEX `FI_sage_ibfk_2` (`priority_id`),
    INDEX `FI_sage_ibfk_3` (`assigned_user_id`),
    CONSTRAINT `message_ibfk_1`
        FOREIGN KEY (`topic_id`)
        REFERENCES `topic` (`id`),
    CONSTRAINT `message_ibfk_2`
        FOREIGN KEY (`priority_id`)
        REFERENCES `priority` (`id`),
    CONSTRAINT `message_ibfk_3`
        FOREIGN KEY (`assigned_user_id`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- response
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `response`;

CREATE TABLE `response`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `message_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `body` TEXT,
    `ip_address` VARCHAR(16),
    `creation_date` DATETIME NOT NULL,
    `modification_date` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_ponse_ibfk_1` (`message_id`),
    INDEX `FI_ponse_ibfk_2` (`user_id`),
    CONSTRAINT `response_ibfk_1`
        FOREIGN KEY (`message_id`)
        REFERENCES `message` (`id`),
    CONSTRAINT `response_ibfk_2`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
