<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pets extends ClientsController
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
        
        $data['title'] = 'My Pets';
        $data['client_id'] = $client_id;
        $data['pets'] = $this->mypets_model->get_pets_for_customer($client_id);
        
        $this->load->view('clients/pets_view', $data);
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
        
        $this->load->view('clients/pet_details_view', $data);
    }
}
