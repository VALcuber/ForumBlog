-- Add google_id field to existing users table
ALTER TABLE `users` ADD COLUMN `google_id` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `status`;

-- Add index for better performance
ALTER TABLE `users` ADD INDEX `idx_google_id` (`google_id`);
ALTER TABLE `users` ADD INDEX `idx_email` (`email`); 