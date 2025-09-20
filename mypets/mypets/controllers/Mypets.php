<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mypets extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mypets_model');
        $this->load->model('clients_model'); // Load clients_model for customer data
    }

    public function index()
    {
        $data['title'] = _l('mypets_pet_list');
        $data['pets'] = $this->mypets_model->get_pets_with_customers();
        $this->load->view('mypets/pet_list_view', $data);
    }

    public function create()
    {
        if ($this->input->post()) {
            $image_path = '';
            if (!empty($_FILES['image']['name'])) {
                $image_path = $this->handle_image_upload();
            }
            
            $pet_data = array(
                'pet_name' => $this->input->post('pet_name'),
                'pet_type' => $this->input->post('pet_type'),
                'breed' => $this->input->post('breed'),
                'age' => $this->input->post('age'),
                'sex' => $this->input->post('sex'),
                'customer_id' => $this->input->post('customer_id'),
                'image' => $image_path, // Use uploaded image path
                'created_at' => date('Y-m-d H:i:s')
            );
            
            
            $pet_id = $this->mypets_model->add($pet_data);
            
            if ($pet_id) {
                set_alert('success', _l('mypets_pet_added_successfully'));
                redirect(admin_url('mypets'));
            } else {
                set_alert('danger', _l('mypets_pet_add_failed'));
            }
        }
        
        $data['title'] = _l('mypets_add_pet');
        $data['customers'] = $this->db->select('userid, company')->get(db_prefix() . 'clients')->result_array();
        
        $this->load->view('mypets/create_pet_view', $data);
    }

    public function edit($pet_id)
    {
        $pet = $this->mypets_model->get($pet_id);
        
        if (!$pet) {
            show_404();
        }
        
        if ($this->input->post()) {
            $image_path = $pet->image; // Keep existing image by default
            if (!empty($_FILES['image']['name'])) {
                $new_image_path = $this->handle_image_upload();
                if ($new_image_path) {
                    // Delete old image if exists
                    if (!empty($pet->image) && file_exists('./' . $pet->image)) {
                        unlink('./' . $pet->image);
                    }
                    $image_path = $new_image_path;
                }
            }
            
            $pet_data = array(
                'pet_name' => $this->input->post('pet_name'),
                'pet_type' => $this->input->post('pet_type'),
                'breed' => $this->input->post('breed'),
                'age' => $this->input->post('age'),
                'sex' => $this->input->post('sex'),
                'customer_id' => $this->input->post('customer_id'),
                'image' => $image_path, // Use uploaded or existing image path
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            
            $updated = $this->mypets_model->update($pet_id, $pet_data);
            
            if ($updated) {
                set_alert('success', _l('mypets_pet_updated_successfully'));
                redirect(admin_url('mypets'));
            } else {
                set_alert('danger', _l('mypets_pet_update_failed'));
            }
        }
        
        $data['title'] = _l('mypets_edit_pet');
        $data['pet'] = $pet;
        $data['customers'] = $this->db->select('userid, company')->get(db_prefix() . 'clients')->result_array();
        $data['breeds'] = $this->mypets_model->get_breeds();
        $data['animal_types'] = $this->mypets_model->get_animal_types();
        
        $this->load->view('mypets/edit_pet_view', $data);
    }

    public function delete($pet_id)
    {
        $this->db->where('id', $pet_id);
        $deleted = $this->db->delete(db_prefix() . 'mypets');
        
        if ($deleted) {
            set_alert('success', _l('mypets_pet_deleted_successfully'));
        } else {
            set_alert('danger', _l('mypets_pet_delete_failed'));
        }
        
        redirect(admin_url('mypets'));
    }

    public function vaccines()
    {
        $data['vaccines'] = $this->mypets_model->get_vaccines();
        $data['title'] = _l('mypets_vaccines');
        $data['animal_types'] = $this->mypets_model->get_animal_types();
        
        $this->load->view('mypets/vaccines_view', $data);
    }

    public function breeds()
    {
        $data['breeds'] = $this->mypets_model->get_breeds();
        $data['title'] = _l('mypets_breeds');
        $data['animal_types'] = $this->mypets_model->get_animal_types();
        $data['breed_groups'] = $this->mypets_model->get_breed_groups();
        
        $this->load->view('mypets/breeds_view', $data);
    }

    public function animal_shops()
    {
        $data['title'] = _l('mypets_animal_shops');
        $this->load->view('mypets/animal_shops_view', $data);
    }

    public function pet_owners()
    {
        $data['title'] = _l('mypets_pet_owners');
        $data['pet_owners'] = $this->mypets_model->get_pet_owners();
        $this->load->view('mypets/pet_owners_view', $data);
    }

    public function brand()
    {
        $data['title'] = _l('mypets_brand');
        $this->load->view('mypets/brand_view', $data);
    }

    public function vaccines_type()
    {
        $data['title'] = _l('mypets_vaccines_type');
        $this->load->view('mypets/vaccines_type_view', $data);
    }

    public function vaccines_name()
    {
        $data['title'] = _l('mypets_vaccines_name');
        $this->load->view('mypets/vaccines_name_view', $data);
    }

    public function disease_name()
    {
        $data['title'] = _l('mypets_disease_name');
        $this->load->view('mypets/disease_name_view', $data);
    }

    public function veterinarian()
    {
        $data['title'] = _l('mypets_veterinarian');
        $this->load->view('mypets/veterinarian_view', $data);
    }

    public function settings()
    {
        log_message('debug', '[v0] Settings method called');
        log_message('debug', '[v0] Request method: ' . $this->input->server('REQUEST_METHOD'));
        log_message('debug', '[v0] POST data: ' . print_r($this->input->post(), true));
        
        if ($this->input->post('import_breeds_csv')) {
            $this->import_breeds_csv();
            redirect(admin_url('mypets/settings'));
        }
        
        if ($this->input->post('import_vaccines_csv')) {
            $this->import_vaccines_csv();
            redirect(admin_url('mypets/settings'));
        }
        
        if ($this->input->post('import_sample_breeds')) {
            log_message('debug', '[v0] Breeds import POST detected');
            $this->import_sample_breeds();
            set_alert('success', 'Sample breeds imported successfully!');
            redirect(admin_url('mypets/settings'));
        }
        
        if ($this->input->post('import_sample_vaccines')) {
            log_message('debug', '[v0] Vaccines import POST detected');
            $this->import_sample_vaccines();
            set_alert('success', 'Sample vaccines imported successfully!');
            redirect(admin_url('mypets/settings'));
        }
        
        $data['title'] = _l('mypets_settings');
        $data['breeds_count'] = $this->mypets_model->count_breeds();
        $data['vaccines_count'] = $this->mypets_model->count_vaccines();
        
        $this->load->view('mypets/settings_view', $data);
    }

    private function import_breeds_csv()
    {
        $this->load->library('upload');
        
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'breeds_import_' . time();
        
        // Create temp directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }
        
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('breeds_csv_file')) {
            $error = $this->upload->display_errors();
            set_alert('danger', 'Upload failed: ' . $error);
            return;
        }
        
        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];
        
        // Process CSV file
        $imported = 0;
        $skipped = 0;
        
        if (($handle = fopen($file_path, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Skip header row
            
            $this->db->trans_start();
            
            while (($data = fgetcsv($handle)) !== FALSE) {
                if (count($data) >= 3) { // Minimum required columns
                    $breed_data = array(
                        'name' => trim($data[0]),
                        'animal_type' => trim($data[1]),
                        'description' => isset($data[2]) ? trim($data[2]) : '',
                        'size' => isset($data[3]) ? trim($data[3]) : '',
                        'temperament' => isset($data[4]) ? trim($data[4]) : '',
                        'life_span' => isset($data[5]) ? trim($data[5]) : '',
                        'origin' => isset($data[6]) ? trim($data[6]) : ''
                    );
                    
                    // Check if breed already exists
                    $existing = $this->db->get_where('tblmypets_breeds', array(
                        'name' => $breed_data['name'],
                        'animal_type' => $breed_data['animal_type']
                    ))->row();
                    
                    if (!$existing) {
                        $this->db->insert('tblmypets_breeds', $breed_data);
                        $imported++;
                    } else {
                        $skipped++;
                    }
                }
            }
            
            $this->db->trans_complete();
            fclose($handle);
        }
        
        // Clean up uploaded file
        unlink($file_path);
        
        if ($this->db->trans_status() === FALSE) {
            set_alert('danger', 'Import failed due to database error');
        } else {
            set_alert('success', "CSV import completed! Imported: {$imported}, Skipped: {$skipped}");
        }
    }

    private function import_vaccines_csv()
    {
        $this->load->library('upload');
        
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'vaccines_import_' . time();
        
        // Create temp directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }
        
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('vaccines_csv_file')) {
            $error = $this->upload->display_errors();
            set_alert('danger', 'Upload failed: ' . $error);
            return;
        }
        
        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];
        
        // Process CSV file
        $imported = 0;
        $skipped = 0;
        
        if (($handle = fopen($file_path, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Skip header row
            
            $this->db->trans_start();
            
            while (($data = fgetcsv($handle)) !== FALSE) {
                if (count($data) >= 3) { // Minimum required columns
                    $vaccine_data = array(
                        'name' => trim($data[0]),
                        'animal_type' => trim($data[1]),
                        'disease_prevented' => trim($data[2]),
                        'description' => isset($data[3]) ? trim($data[3]) : '',
                        'dosage' => isset($data[4]) ? trim($data[4]) : '',
                        'frequency' => isset($data[5]) ? trim($data[5]) : '',
                        'age_range' => isset($data[6]) ? trim($data[6]) : ''
                    );
                    
                    // Check if vaccine already exists
                    $existing = $this->db->get_where('tblmypets_vaccines', array(
                        'name' => $vaccine_data['name'],
                        'animal_type' => $vaccine_data['animal_type'],
                        'disease_prevented' => $vaccine_data['disease_prevented']
                    ))->row();
                    
                    if (!$existing) {
                        $this->db->insert('tblmypets_vaccines', $vaccine_data);
                        $imported++;
                    } else {
                        $skipped++;
                    }
                }
            }
            
            $this->db->trans_complete();
            fclose($handle);
        }
        
        // Clean up uploaded file
        unlink($file_path);
        
        if ($this->db->trans_status() === FALSE) {
            set_alert('danger', 'Import failed due to database error');
        } else {
            set_alert('success', "CSV import completed! Imported: {$imported}, Skipped: {$skipped}");
        }
    }

    private function import_sample_breeds()
    {
        log_message('debug', '[v0] Starting breed import process...');
        
        $sql_file = APPPATH . 'modules/mypets/upload/insert_sample_breeds.sql';
        
        if (!file_exists($sql_file)) {
            set_alert('danger', 'Sample breeds SQL file not found at: ' . $sql_file);
            return;
        }
        
        $sql_content = file_get_contents($sql_file);
        
        if (empty($sql_content)) {
            set_alert('danger', 'Sample breeds SQL file is empty!');
            return;
        }
        
        $queries = explode(';', $sql_content);
        $executed = 0;
        $errors = array();
        
        $this->db->trans_start();
        
        foreach ($queries as $query) {
            $query = trim($query);
            
            // Skip empty queries (common issue from online solutions)
            if (empty($query) || $query == '') {
                continue;
            }
            
            // Skip comments
            if (strpos($query, '--') === 0 || strpos($query, '#') === 0) {
                continue;
            }
            
            try {
                log_message('debug', '[v0] Executing query: ' . substr($query, 0, 100) . '...');
                $result = $this->db->query($query);
                
                if ($result) {
                    $executed++;
                    log_message('debug', '[v0] Query executed successfully, affected rows: ' . $this->db->affected_rows());
                } else {
                    $error = $this->db->error();
                    $errors[] = 'Query failed: ' . $error['message'];
                    log_message('error', '[v0] Query failed: ' . print_r($error, true));
                }
            } catch (Exception $e) {
                $errors[] = 'Exception: ' . $e->getMessage();
                log_message('error', '[v0] Exception: ' . $e->getMessage());
            }
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE || !empty($errors)) {
            $error_msg = 'Import failed. Errors: ' . implode(', ', $errors);
            set_alert('danger', $error_msg);
            log_message('error', '[v0] ' . $error_msg);
        } else {
            $new_count = $this->mypets_model->count_breeds();
            set_alert('success', "Sample breeds imported successfully! Executed {$executed} queries. Total breeds: {$new_count}");
            log_message('info', "[v0] Import successful. Executed {$executed} queries.");
        }
    }

    private function import_sample_vaccines()
    {
        log_message('debug', '[v0] Starting vaccine import process...');
        
        $sql_file = APPPATH . 'modules/mypets/upload/insert_sample_vaccines.sql';
        
        if (!file_exists($sql_file)) {
            set_alert('danger', 'Sample vaccines SQL file not found at: ' . $sql_file);
            return;
        }
        
        $sql_content = file_get_contents($sql_file);
        
        if (empty($sql_content)) {
            set_alert('danger', 'Sample vaccines SQL file is empty!');
            return;
        }
        
        $queries = explode(';', $sql_content);
        $executed = 0;
        $errors = array();
        
        $this->db->trans_start();
        
        foreach ($queries as $query) {
            $query = trim($query);
            
            // Skip empty queries (common issue from online solutions)
            if (empty($query) || $query == '') {
                continue;
            }
            
            // Skip comments
            if (strpos($query, '--') === 0 || strpos($query, '#') === 0) {
                continue;
            }
            
            try {
                log_message('debug', '[v0] Executing query: ' . substr($query, 0, 100) . '...');
                $result = $this->db->query($query);
                
                if ($result) {
                    $executed++;
                    log_message('debug', '[v0] Query executed successfully, affected rows: ' . $this->db->affected_rows());
                } else {
                    $error = $this->db->error();
                    $errors[] = 'Query failed: ' . $error['message'];
                    log_message('error', '[v0] Query failed: ' . print_r($error, true));
                }
            } catch (Exception $e) {
                $errors[] = 'Exception: ' . $e->getMessage();
                log_message('error', '[v0] Exception: ' . $e->getMessage());
            }
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE || !empty($errors)) {
            $error_msg = 'Import failed. Errors: ' . implode(', ', $errors);
            set_alert('danger', $error_msg);
            log_message('error', '[v0] ' . $error_msg);
        } else {
            $new_count = $this->mypets_model->count_vaccines();
            set_alert('success', "Sample vaccines imported successfully! Executed {$executed} queries. Total vaccines: {$new_count}");
            log_message('info', "[v0] Import successful. Executed {$executed} queries.");
        }
    }

    private function handle_image_upload()
    {
        $this->load->library('upload');
        
        // Create uploads directory if it doesn't exist
        $upload_path = './uploads/mypets/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE; // Generate unique filename
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            return 'uploads/mypets/' . $upload_data['file_name'];
        } else {
            $error = $this->upload->display_errors();
            set_alert('danger', 'Image upload failed: ' . $error);
            return false;
        }
    }
}
