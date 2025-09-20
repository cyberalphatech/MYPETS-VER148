<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

/**
 * Run a SQL seed file
 */
function run_sql_seed($file) {
    $CI = &get_instance();
    $path = module_dir_path('mypets', 'seeds/' . $file);

    if (file_exists($path)) {
        $sql = file_get_contents($path);

        // Replace prefix placeholder {PREFIX} with real db prefix
        $sql = str_replace("{PREFIX}", db_prefix(), $sql);

        if (!$CI->db->simple_query($sql)) {
            $error = $CI->db->error();
            log_activity("Mypets: Failed seed file {$file} - " . $error['message']);
            return 0;
        } else {
            log_activity("Mypets: Seed file {$file} executed successfully.");
            return 1;
        }
    } else {
        log_activity("Mypets: Seed file {$file} not found.");
    }
    return 0;
}

try {
    // --- Check migration of old structure ---
    if ($CI->db->table_exists(db_prefix() . 'mypets')) {
        $fields = $CI->db->field_data(db_prefix() . 'mypets');
        $has_customer_id = false;
        $has_old_structure = false;

        foreach ($fields as $field) {
            if ($field->name == 'customer_id') {
                $has_customer_id = true;
            }
            if (in_array($field->name, ['owner_name', 'owner_email', 'owner_phone', 'name', 'animal_type'])) {
                $has_old_structure = true;
            }
        }

        if (!$has_customer_id && $has_old_structure) {
            log_message('info', 'Migrating mypets table to new structure...');

            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` ADD COLUMN `customer_id` int(11) NOT NULL DEFAULT 0 AFTER `age`');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` CHANGE `name` `pet_name` varchar(191) NOT NULL');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` CHANGE `animal_type` `pet_type` varchar(50) NOT NULL');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` ADD COLUMN `sex` varchar(10) DEFAULT NULL AFTER `age`');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` ADD COLUMN `image` varchar(255) DEFAULT NULL AFTER `customer_id`');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` DROP COLUMN `owner_name`');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` DROP COLUMN `owner_email`');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` DROP COLUMN `owner_phone`');
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'mypets` ADD KEY `customer_id` (`customer_id`)');

            log_message('info', 'Successfully migrated mypets table structure');
        }
    }

    // --- Create main pets table ---
    if (!$CI->db->table_exists(db_prefix() . 'mypets')) {
        $query = 'CREATE TABLE `' . db_prefix() . "mypets` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `pet_name` varchar(191) NOT NULL,
            `pet_type` varchar(50) NOT NULL,
            `breed` varchar(100) DEFAULT NULL,
            `age` int(11) DEFAULT NULL,
            `sex` varchar(10) DEFAULT NULL,
            `customer_id` int(11) NOT NULL,
            `image` varchar(255) DEFAULT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `customer_id` (`customer_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';';

        $CI->db->query($query);
    }

    // --- Create breeds table ---
    if (!$CI->db->table_exists(db_prefix() . 'mypets_breeds')) {
        $query = 'CREATE TABLE `' . db_prefix() . "mypets_breeds` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `animal_type` varchar(50) NOT NULL,
            `breed_group` varchar(50) DEFAULT NULL,
            `size` varchar(20) DEFAULT NULL,
            `temperament` varchar(255) DEFAULT NULL,
            `life_span` varchar(50) DEFAULT NULL,
            `weight_range` varchar(50) DEFAULT NULL,
            `height_range` varchar(50) DEFAULT NULL,
            `coat_type` varchar(100) DEFAULT NULL,
            `exercise_needs` varchar(50) DEFAULT NULL,
            `grooming_needs` varchar(50) DEFAULT NULL,
            `good_with_children` tinyint(1) DEFAULT NULL,
            `good_with_pets` tinyint(1) DEFAULT NULL,
            `origin_country` varchar(100) DEFAULT NULL,
            `description` text DEFAULT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';';

        $CI->db->query($query);
    }

    // --- Create vaccines table ---
    if (!$CI->db->table_exists(db_prefix() . 'mypets_vaccines')) {
        $query = 'CREATE TABLE `' . db_prefix() . "mypets_vaccines` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `animal_type` varchar(50) NOT NULL,
            `vaccine_type` varchar(50) DEFAULT NULL,
            `description` text DEFAULT NULL,
            `frequency` varchar(50) DEFAULT NULL,
            `age_range` varchar(50) DEFAULT NULL,
            `manufacturer` varchar(100) DEFAULT NULL,
            `dosage` varchar(100) DEFAULT NULL,
            `route` varchar(50) DEFAULT NULL,
            `notes` text DEFAULT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';';

        $CI->db->query($query);
    }

    // --- Run seeds ---
    $seeds = [
        'breeds.sql'      => 'mypets_breeds',
        'vaccines.sql'    => 'mypets_vaccines',
        'sample_pets.sql' => 'mypets',
    ];

    foreach ($seeds as $file => $table) {
        $table_name = db_prefix() . $table;
        if ($CI->db->table_exists($table_name)) {
            if ($CI->db->count_all($table_name) == 0) {
                run_sql_seed($file);
            } else {
                log_activity("Mypets: Table {$table_name} already has data, skipping seed.");
            }
        } else {
            log_activity("Mypets: Table {$table_name} does not exist, skipping seed {$file}.");
        }
    }

} catch (Exception $e) {
    log_activity("Mypets: Error during installation - " . $e->getMessage());
}
