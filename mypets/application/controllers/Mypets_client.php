<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mypets_client extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mypets/mypets_model');
    }

    public function index()
    {
        if (!is_client_logged_in()) {
            redirect(site_url('clients/login'));
        }

        $client_id = get_client_user_id();
        
        if ($this->input->is_ajax_request()) {
            $this->my_pets_table($client_id);
            return;
        }

        $data['title'] = _l('mypets_my_pets');
        $data['client_id'] = $client_id;
        $data['pets'] = $this->mypets_model->get_pets_for_customer($client_id);
        
        $this->load->view('mypets/client_pets_view', $data);
    }

    public function my_pets_table($client_id)
    {
        if ($this->input->is_ajax_request()) {
            $pets = $this->mypets_model->get_pets_for_customer($client_id);
            $output = [
                'draw' => intval($this->input->post('draw')),
                'iTotalRecords' => count($pets),
                'iTotalDisplayRecords' => count($pets),
                'aaData' => []
            ];

            foreach ($pets as $pet) {
                $row = [];
                $row[] = $pet['pet_name'];
                $row[] = $pet['breed'];
                $row[] = '<span class="label label-info">' . $pet['pet_type'] . '</span>';
                $row[] = $pet['age'];
                $row[] = $pet['sex'];
                
                // Image
                if (!empty($pet['image'])) {
                    $row[] = '<img src="' . base_url($pet['image']) . '" class="img-responsive img-circle" style="width: 40px; height: 40px;">';
                } else {
                    $row[] = '<span class="text-muted">No image</span>';
                }
                
                $output['aaData'][] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($output);
            die();
        }
    }

    public function view($pet_id)
    {
        if (!is_client_logged_in()) {
            redirect(site_url('clients/login'));
        }

        $client_id = get_client_user_id();
        $pet = $this->mypets_model->get($pet_id);
        
        // Verify pet belongs to this client
        if (!$pet || $pet->customer_id != $client_id) {
            show_404();
        }

        $data['title'] = 'Pet Details: ' . $pet->pet_name;
        $data['pet'] = $pet;
        
        $this->load->view('mypets/client_pet_details_view', $data);
    }
}
