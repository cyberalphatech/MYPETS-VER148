<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'mypets')) {
    return;
}

// Drop all mypets related tables
$CI->db->query('DROP TABLE IF EXISTS `' . db_prefix() . 'mypets_vaccines`');
$CI->db->query('DROP TABLE IF EXISTS `' . db_prefix() . 'mypets_breeds`');
$CI->db->query('DROP TABLE IF EXISTS `' . db_prefix() . 'mypets`');

// Remove any custom fields if they exist
if ($CI->db->table_exists(db_prefix() . 'customfields')) {
    $CI->db->where('fieldto', 'mypets');
    $CI->db->delete(db_prefix() . 'customfields');
}

// Remove any permissions related to mypets
if ($CI->db->table_exists(db_prefix() . 'staff_permissions')) {
    $CI->db->like('feature', 'mypets', 'after');
    $CI->db->delete(db_prefix() . 'staff_permissions');
}
