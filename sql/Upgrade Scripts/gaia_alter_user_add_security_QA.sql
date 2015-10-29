ALTER TABLE `users`
ADD COLUMN `security_question` varchar(255) DEFAUlT NULL COMMENT 'security question' AFTER `warehouse_id`,
ADD COLUMN `security_answer` varchar(255) DEFAUlT NULL COMMENT 'security answer' AFTER `security_question`;