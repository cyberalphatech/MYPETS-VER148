<?php
/**
 * Debug script to check why "My Pet" submenu is not showing in client profile
 * Access this file directly via: /modules/mypets/debug_client_menu.php
 */

defined('BASEPATH') or exit('No direct script access allowed');

// Initialize CodeIgniter
$CI = &get_instance();

echo "<h2>MyPets Module Debug Report</h2>";
echo "<hr>";

// 1. Check if module is activated
echo "<h3>1. Module Status</h3>";
$modules = get_instance()->app_modules->get();
$mypets_active = false;
foreach ($modules as $module) {
    if ($module['system_name'] == 'mypets') {
        $mypets_active = $module['activated'];
        echo "Module found: " . ($mypets_active ? "ACTIVATED" : "NOT ACTIVATED") . "<br>";
        break;
    }
}

if (!$mypets_active) {
    echo "<strong style='color: red;'>ERROR: MyPets module is not activated!</strong><br>";
}

// 2. Check database tables
echo "<h3>2. Database Tables</h3>";
$tables_to_check = ['mypets', 'mypets_vaccines', 'mypets_breeds'];
foreach ($tables_to_check as $table) {
    $full_table_name = db_prefix() . $table;
    $exists = $CI->db->table_exists($full_table_name);
    echo "Table {$full_table_name}: " . ($exists ? "EXISTS" : "MISSING") . "<br>";
    
    if ($exists) {
        $count = $CI->db->count_all($full_table_name);
        echo "&nbsp;&nbsp;Records: {$count}<br>";
    }
}

// 3. Check hook registration
echo "<h3>3. Hook Registration</h3>";
$hooks = hooks()->get_hooks();
$client_profile_hooks = isset($hooks['clients_profile_tabs']) ? $hooks['clients_profile_tabs'] : [];
echo "clients_profile_tabs hook registered: " . (count($client_profile_hooks) > 0 ? "YES" : "NO") . "<br>";

if (count($client_profile_hooks) > 0) {
    echo "Registered functions:<br>";
    foreach ($client_profile_hooks as $hook) {
        echo "&nbsp;&nbsp;- " . $hook['function'] . "<br>";
    }
}

// 4. Test the hook function directly
echo "<h3>4. Hook Function Test</h3>";
if (function_exists('mypets_client_profile_vertical_submenu_item')) {
    echo "Function mypets_client_profile_vertical_submenu_item: EXISTS<br>";
    
    // Test with sample tabs structure
    $sample_tabs = [
        'profile' => [
            'name' => 'Profile',
            'children' => []
        ]
    ];
    
    try {
        $result = mypets_client_profile_vertical_submenu_item($sample_tabs);
        echo "Function execution: SUCCESS<br>";
        echo "Result structure:<br>";
        echo "<pre>" . print_r($result, true) . "</pre>";
    } catch (Exception $e) {
        echo "Function execution: ERROR - " . $e->getMessage() . "<br>";
    }
} else {
    echo "<strong style='color: red;'>Function mypets_client_profile_vertical_submenu_item: NOT FOUND</strong><br>";
}

// 5. Check language files
echo "<h3>5. Language Files</h3>";
$lang_key = 'mypets_profile_link';
$lang_value = _l($lang_key);
echo "Language key '{$lang_key}': " . ($lang_value != $lang_key ? "FOUND ({$lang_value})" : "MISSING") . "<br>";

// 6. Check current context
echo "<h3>6. Current Context</h3>";
echo "Current URL: " . current_url() . "<br>";
echo "Is admin: " . (is_admin() ? "YES" : "NO") . "<br>";
echo "Is client logged in: " . (is_client_logged_in() ? "YES" : "NO") . "<br>";

if (function_exists('get_client_user_id')) {
    $client_id = get_client_user_id();
    echo "Client ID: " . ($client_id ? $client_id : "NULL") . "<br>";
} else {
    echo "get_client_user_id function: NOT AVAILABLE<br>";
}

// 7. Check if we're in the right context for client profile
echo "<h3>7. Client Profile Context</h3>";
$uri_segments = $CI->uri->segment_array();
echo "URI segments: " . implode(' / ', $uri_segments) . "<br>";

// Check if we're viewing a client profile
$is_client_profile = false;
if (count($uri_segments) >= 3 && $uri_segments[1] == 'admin' && $uri_segments[2] == 'clients' && $uri_segments[3] == 'client') {
    $is_client_profile = true;
    $client_id = isset($uri_segments[4]) ? $uri_segments[4] : null;
    echo "Viewing client profile: YES (Client ID: {$client_id})<br>";
} else {
    echo "Viewing client profile: NO<br>";
}

echo "<hr>";
echo "<h3>Recommendations:</h3>";
if (!$mypets_active) {
    echo "1. Activate the MyPets module from Setup > Modules<br>";
}

$missing_tables = [];
foreach ($tables_to_check as $table) {
    if (!$CI->db->table_exists(db_prefix() . $table)) {
        $missing_tables[] = $table;
    }
}

if (!empty($missing_tables)) {
    echo "2. Missing database tables. Deactivate and reactivate the module to run installation.<br>";
}

if (count($client_profile_hooks) == 0) {
    echo "3. Hook not registered. Check if the module file is being loaded properly.<br>";
}

if (!$is_client_profile) {
    echo "4. To see the 'My Pet' submenu, navigate to a client profile page (Customers > View Client).<br>";
}

echo "<br><strong>Note:</strong> The 'My Pet' submenu only appears when viewing a specific client's profile page.";
?>
