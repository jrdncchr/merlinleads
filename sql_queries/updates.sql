

#7-18-2016

#7-11-2016
ALTER TABLE `merlinle_mldb`.`scheduler_post`
ADD COLUMN `post_library` VARCHAR(45) NOT NULL DEFAULT 'user' AFTER `post_id`;


CREATE TABLE `merlinle_mldb`.`settings` ( `id` INT NOT NULL AUTO_INCREMENT , `category` VARCHAR(100) NOT NULL , `k` VARCHAR(100) NOT NULL , `v` VARCHAR(500) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `settings` (`id`, `category`, `k`, `v`) VALUES (NULL, 'general', 'trial_period_package', '62');

#delete also the url in merlin post
ALTER TABLE `merlin_post` ADD `post_name` VARCHAR(100) NOT NULL AFTER `post_category_id`;

 # END

  CREATE TABLE `merlinle_mldb`.`city_zipcode_request` ( `czr_id` INT NOT NULL AUTO_INCREMENT , `czr_city` VARCHAR(100) NOT NULL , `czr_zipcode` VARCHAR(20) NOT NULL , `czr_status` VARCHAR(20) NOT NULL , `czr_requested_by` INT NOT NULL , `czr_date_requested` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`czr_id`)) ENGINE = InnoDB;

  ALTER TABLE `merlin_blog_post` CHANGE `bp_status` `bp_status` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'active';

  ALTER TABLE `scheduler_post` ADD `post_name` VARCHAR(150) NOT NULL AFTER `post_id`;

  ALTER TABLE `merlin_blog_post` ADD `bp_subject_line` VARCHAR(200) NOT NULL AFTER `bp_linkedin_snippet`, ADD `bp_email_content` VARCHAR(1000) NOT NULL AFTER `bp_subject_line`;

  ALTER TABLE `scheduler_post` ADD `bp_subject_line` VARCHAR(150) NOT NULL AFTER `bp_keywords`, ADD `bp_email_content` VARCHAR(1000) NOT NULL AFTER `bp_subject_line`;