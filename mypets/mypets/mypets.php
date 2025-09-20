<?php

/**
 * Module Name: My Pets
 * Description: A module to manage pet information.
 * Version: 1.0.0
 * Requires at least: 2.3.0
 */

defined('BASEPATH') or exit('No direct script access allowed');

register_language_files('mypets', ['mypets']);

/**
 * Register the activation hook
 */
register_activation_hook('mypets', 'mypets_activation_hook');

function mypets_activation_hook()
{
    $CI = &get_instance();

    try {
        log_activity('My Pets Module: Starting activation hook');

        // Check if install.php exists
        $install_file = __DIR__ . '/install.php';
        if (!file_exists($install_file)) {
            log_activity('My Pets Module: ERROR - install.php file not found at: ' . $install_file);
            return false;
        }

        log_activity('My Pets Module: Found install.php, including file');
        require_once($install_file);

        // Verify tables were created
        $main_table_exists     = $CI->db->table_exists(db_prefix() . 'mypets');
        $vaccines_table_exists = $CI->db->table_exists(db_prefix() . 'mypets_vaccines');
        $breeds_table_exists   = $CI->db->table_exists(db_prefix() . 'mypets_breeds');

        log_activity('My Pets Module: Main table exists: ' . ($main_table_exists ? 'YES' : 'NO'));
        log_activity('My Pets Module: Vaccines table exists: ' . ($vaccines_table_exists ? 'YES' : 'NO'));
        log_activity('My Pets Module: Breeds table exists: ' . ($breeds_table_exists ? 'YES' : 'NO'));

        if ($vaccines_table_exists) {
            $vaccine_count = $CI->db->count_all(db_prefix() . 'mypets_vaccines');
            log_activity('My Pets Module: Vaccines table has ' . $vaccine_count . ' records');
        }

        if ($breeds_table_exists) {
            $breed_count = $CI->db->count_all(db_prefix() . 'mypets_breeds');
            log_activity('My Pets Module: Breeds table has ' . $breed_count . ' records');
        }

        log_activity('My Pets Module: Activation completed successfully');
    } catch (Exception $e) {
        log_activity('My Pets Module: ERROR during activation - ' . $e->getMessage());
        return false;
    }
}

/**
 * Register the deactivation hook
 */
register_deactivation_hook('mypets', 'mypets_deactivation_hook');

function mypets_deactivation_hook()
{
    log_activity('My Pets Module Deactivated');
}

/**
 * Hook to add the main menu item to the admin sidebar
 */
hooks()->add_action('admin_init', 'mypets_menu_item');

function mypets_menu_item()
{
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('my-pets-parent', [
        'name'     => _l('mypets_module_name'),
        'icon'     => 'fa fa-paw',
        'position' => 15,
    ]);

    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-list',
        'name'     => _l('mypets_pet_list'),
        'href'     => admin_url('mypets'),
        'icon'     => 'fa fa-dog',
        'position' => 1,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-vaccines',
        'name'     => _l('mypets_vaccines'),
        'href'     => admin_url('mypets/vaccines'),
        'icon'     => 'fa fa-syringe',
        'position' => 2,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-breeds',
        'name'     => _l('mypets_breeds'),
        'href'     => admin_url('mypets/breeds'),
        'icon'     => 'fa fa-paw',
        'position' => 3,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-animal-shops',
        'name'     => _l('mypets_animal_shops'),
        'href'     => admin_url('mypets/animal_shops'),
        'icon'     => 'fa fa-store',
        'position' => 4,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-owners',
        'name'     => _l('mypets_pet_owners'),
        'href'     => admin_url('mypets/pet_owners'),
        'icon'     => 'fa fa-users',
        'position' => 5,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-brand',
        'name'     => _l('mypets_brand'),
        'href'     => admin_url('mypets/brand'),
        'icon'     => 'fa fa-building',
        'position' => 6,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-vaccines-type',
        'name'     => _l('mypets_vaccines_type'),
        'href'     => admin_url('mypets/vaccines_type'),
        'icon'     => 'fa fa-list',
        'position' => 7,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-vaccines-name',
        'name'     => _l('mypets_vaccines_name'),
        'href'     => admin_url('mypets/vaccines_name'),
        'icon'     => 'fa fa-cog',
        'position' => 8,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-disease-name',
        'name'     => _l('mypets_disease_name'),
        'href'     => admin_url('mypets/disease_name'),
        'icon'     => 'fa fa-cog',
        'position' => 9,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-veterinarian',
        'name'     => _l('mypets_veterinarian'),
        'href'     => admin_url('mypets/veterinarian'),
        'icon'     => 'fa fa-user-md',
        'position' => 10,
    ]);
    $CI->app_menu->add_sidebar_children_item('my-pets-parent', [
        'slug'     => 'pet-settings',
        'name'     => _l('mypets_settings'),
        'href'     => admin_url('mypets/settings'),
        'icon'     => 'fa fa-cogs',
        'position' => 11,
    ]);
}

/**
 * Hook to add pets tab to customer profile
 */
hooks()->add_filter('customers_profile_tabs', 'mypets_add_customer_profile_tab', 100, 2);

function mypets_add_customer_profile_tab($tabs, $client_id)
{
    $tabs['pets'] = [
        'name' => _l('mypets_pets'),
        'icon' => 'fa fa-paw',
        'view' => 'mypets/views/admin/client_profile_pets',
        'position' => 100,
    ];
    
    return $tabs;
}
