-- Script SQL pour ajouter les champs CV à la table users
ALTER TABLE `users`
ADD COLUMN `birth_date` DATE NULL AFTER `profile_photo`,
ADD COLUMN `birth_place` VARCHAR(255) NULL AFTER `birth_date`,
ADD COLUMN `nationality` VARCHAR(255) NULL AFTER `birth_place`,
ADD COLUMN `address` TEXT NULL AFTER `nationality`,
ADD COLUMN `linkedin` VARCHAR(255) NULL AFTER `address`,
ADD COLUMN `orcid` VARCHAR(255) NULL AFTER `linkedin`,
ADD COLUMN `google_scholar` VARCHAR(255) NULL AFTER `orcid`,
ADD COLUMN `education` JSON NULL AFTER `google_scholar`,
ADD COLUMN `experience` JSON NULL AFTER `education`,
ADD COLUMN `skills` JSON NULL AFTER `experience`,
ADD COLUMN `languages` JSON NULL AFTER `skills`,
ADD COLUMN `publications` JSON NULL AFTER `languages`,
ADD COLUMN `certifications` JSON NULL AFTER `publications`,
ADD COLUMN `references` JSON NULL AFTER `certifications`;
