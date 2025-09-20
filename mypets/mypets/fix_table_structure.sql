-- Fix the mypets table structure to match the form
-- This script will update the existing table to use customer_id instead of owner fields

-- First, check if customer_id column exists, if not add it
ALTER TABLE `tblmypets` 
ADD COLUMN IF NOT EXISTS `customer_id` int(11) NOT NULL AFTER `id`;

-- Update existing records to use customer_id (if you have existing data)
-- This assumes you want to keep existing pets but need to link them to customers
-- You may need to manually map owner_email to customer userid values

-- Remove old columns if they exist
ALTER TABLE `tblmypets` 
DROP COLUMN IF EXISTS `owner_name`,
DROP COLUMN IF EXISTS `owner_email`, 
DROP COLUMN IF EXISTS `owner_phone`;

-- Rename columns to match the form
ALTER TABLE `tblmypets` 
CHANGE COLUMN `name` `pet_name` varchar(255) NOT NULL,
CHANGE COLUMN `animal_type` `pet_type` varchar(100) NOT NULL;

-- Add missing columns if they don't exist
ALTER TABLE `tblmypets` 
ADD COLUMN IF NOT EXISTS `sex` varchar(10) DEFAULT NULL AFTER `age`,
ADD COLUMN IF NOT EXISTS `image` varchar(255) DEFAULT NULL AFTER `sex`;

-- Remove unnecessary columns
ALTER TABLE `tblmypets` 
DROP COLUMN IF EXISTS `weight`,
DROP COLUMN IF EXISTS `color`,
DROP COLUMN IF EXISTS `medical_notes`;
