<?php
defined('BASEPATH') or exit('No direct script access allowed');

function handle_upload($path, $input_name)
{
    $CI = &get_instance();
    if (isset($_FILES[$input_name]['name']) && $_FILES[$input_name]['name'] != '') {
        $full_path = FCPATH . $path;
        
        $config['upload_path'] = $full_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '2048'; // 2MB
        $config['encrypt_name'] = TRUE; // Generate unique filename
        
        // Create the directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            if (!mkdir($config['upload_path'], 0755, true)) {
                set_alert('danger', 'Failed to create upload directory');
                return false;
            }
        }

        $CI->load->library('upload', $config);

        if (!$CI->upload->do_upload($input_name)) {
            $error = $CI->upload->display_errors('', '');
            set_alert('danger', 'Upload failed: ' . $error);
            return false;
        } else {
            return $CI->upload->data();
        }
    }
    return false;
}
