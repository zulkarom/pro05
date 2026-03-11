CREATE TABLE `slider` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `image_path` VARCHAR(255) NOT NULL,
  `heading_line1` VARCHAR(255) NULL,
  `heading_line2` VARCHAR(255) NULL,
  `heading_line3` VARCHAR(255) NULL,
  `button_type` TINYINT NOT NULL DEFAULT 0,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` INT NULL,
  `updated_at` INT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_slider_is_active_sort` (`is_active`, `sort_order`, `id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
