#10-5-2016
ALTER TABLE `properties_events_settings` ADD `attach_type` VARCHAR(30) NOT NULL AFTER `modules`, ADD `custom_link` VARCHAR(500) NOT NULL AFTER `attach_type`, ADD `uploaded_file` VARCHAR(500) NOT NULL AFTER `custom_link`;

#9-12-2016
CREATE TABLE `properties_events_templates` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `properties_events_templates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `properties_events_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `properties_events_templates` ADD `is_default` TINYINT NOT NULL DEFAULT '0' AFTER `content`;
ALTER TABLE `properties_events_templates` ADD `name` VARCHAR(45) NOT NULL AFTER `event_id`;

CREATE TABLE `properties_events_templates_custom` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `properties_events_templates_custom`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `properties_events_templates_custom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

CREATE TABLE `merlinle_mldb`.`properties_events_settings` ( `id` INT NOT NULL AUTO_INCREMENT , `event_id` INT NOT NULL , `template_id` INT NOT NULL , `template_type` VARCHAR(45) NOT NULL , `active` TINYINT NOT NULL DEFAULT '0' , `modules` VARCHAR(100) NOT NULL , `last_update` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `properties_events_settings` ADD `user_id` INT NOT NULL AFTER `id`;
ALTER TABLE `properties_events_settings` CHANGE `template_type` `template_type` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'merlin';
ALTER TABLE `properties_events_settings` CHANGE `active` `active` BOOLEAN NOT NULL DEFAULT FALSE;
  ALTER TABLE `properties_events` ADD `description` VARCHAR(500) NOT NULL AFTER `name`;

CREATE TABLE `merlinle_mldb`.`properties_events` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , `active` TINYINT NOT NULL DEFAULT '1' , `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
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