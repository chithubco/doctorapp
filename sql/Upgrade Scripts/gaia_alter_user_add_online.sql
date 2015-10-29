ALTER TABLE `users`
ADD COLUMN `online` int(1) DEFAUlT 0 COMMENT 'online' AFTER `security_answer`;