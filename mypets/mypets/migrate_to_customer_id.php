<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

try {
    // Check if the table exists and what columns it has
    $table_name = db_prefix() . 'mypets';
    
    if ($CI->db->table_exists($table_name)) {
        // Check if customer_id column already exists
        $fields = $CI->db->field_data($table_name);
        $has_customer_id = false;
        $has_owner_name = false;
        
        foreach ($fields as $field) {
            if ($field->name == 'customer_id') {
                $has_customer_id = true;
            }
            if ($field->name == 'owner_name') {
                $has_owner_name = true;
            }
        }
        
        // If we have owner_name but not customer_id, we need to migrate
        if ($has_owner_name && !$has_customer_id) {
            echo "Migrating table structure from owner fields to customer_id...\n";
            
            // Add customer_id column
            $CI->db->query("ALTER TABLE `{$table_name}` ADD COLUMN `customer_id` int(11) NOT NULL DEFAULT 1 AFTER `color`");
            
            // Add index for customer_id
            $CI->db->query("ALTER TABLE `{$table_name}` ADD KEY `customer_id` (`customer_id`)");
            
            // Drop the old owner columns
            $CI->db->query("ALTER TABLE `{$table_name}` DROP COLUMN `owner_name`");
            $CI->db->query("ALTER TABLE `{$table_name}` DROP COLUMN `owner_email`");
            $CI->db->query("ALTER TABLE `{$table_name}` DROP COLUMN `owner_phone`");
            
            echo "Migration completed successfully!\n";
            
        } elseif ($has_customer_id) {
            echo "Table already has customer_id column. No migration needed.\n";
        } else {
            echo "Table structure is unexpected. Please check manually.\n";
        }
        
    } else {
        echo "Table does not exist. Run install.php first.\n";
    }
    
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
?>
