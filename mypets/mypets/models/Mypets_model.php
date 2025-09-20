<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mypets_model extends App_Model
{
    private $table;
    private $vaccines_table;
    private $breeds_table;

    public function __construct()
    {
        parent::__construct();
        $this->table = db_prefix() . 'mypets';
        $this->vaccines_table = db_prefix() . 'mypets_vaccines';
        $this->breeds_table = db_prefix() . 'mypets_breeds';
    }

    private function vaccines_table_exists()
    {
        $query = $this->db->query("SHOW TABLES LIKE '{$this->vaccines_table}'");
        return $query->num_rows() > 0;
    }

    private function breeds_table_exists()
    {
        $query = $this->db->query("SHOW TABLES LIKE '{$this->breeds_table}'");
        return $query->num_rows() > 0;
    }

    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get($this->table)->row();
        }
        return $this->db->get($this->table)->result_array();
    }

    public function get_pets_with_customers($id = '')
    {
        $this->db->select($this->table . '.*');
        $this->db->from($this->table);
        
        if (is_numeric($id)) {
            $this->db->where($this->table . '.id', $id);
            return $this->db->get()->row_array();
        }
        
        $this->db->order_by($this->table . '.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_pets_for_customer($customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        return $this->db->get($this->table)->result_array();
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function get_vaccines($id = '')
    {
        if (!$this->vaccines_table_exists()) {
            return [];
        }

        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get($this->vaccines_table)->row();
        }
        
        $this->db->order_by('animal_type', 'ASC');
        $this->db->order_by('vaccine_type', 'ASC');
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->vaccines_table)->result_array();
    }

    public function get_vaccines_by_animal($animal_type)
    {
        if (!$this->vaccines_table_exists()) {
            return [];
        }

        $this->db->where('animal_type', $animal_type);
        $this->db->order_by('vaccine_type', 'ASC');
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->vaccines_table)->result_array();
    }

    public function add_vaccine($data)
    {
        if (!$this->vaccines_table_exists()) {
            return false;
        }

        $this->db->insert($this->vaccines_table, $data);
        return $this->db->insert_id();
    }

    public function update_vaccine($id, $data)
    {
        if (!$this->vaccines_table_exists()) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->update($this->vaccines_table, $data);
    }

    public function delete_vaccine($id)
    {
        if (!$this->vaccines_table_exists()) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->vaccines_table);
    }

    public function get_animal_types()
    {
        if (!$this->vaccines_table_exists()) {
            return ['Dog', 'Cat', 'Horse', 'Rabbit', 'Bird'];
        }

        $this->db->select('animal_type');
        $this->db->distinct();
        $this->db->order_by('animal_type', 'ASC');
        $query = $this->db->get($this->vaccines_table);
        $result = array_column($query->result_array(), 'animal_type');
        
        // Return default types if no data found
        return !empty($result) ? $result : ['Dog', 'Cat', 'Horse', 'Rabbit', 'Bird'];
    }

    public function get_breeds($id = '')
    {
        if (!$this->breeds_table_exists()) {
            return [];
        }

        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get($this->breeds_table)->row();
        }
        
        $this->db->order_by('animal_type', 'ASC');
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->breeds_table)->result_array();
    }

    public function get_breeds_by_animal($animal_type)
    {
        if (!$this->breeds_table_exists()) {
            return [];
        }

        $this->db->where('animal_type', $animal_type);
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->breeds_table)->result_array();
    }

    public function add_breed($data)
    {
        if (!$this->breeds_table_exists()) {
            return false;
        }

        $this->db->insert($this->breeds_table, $data);
        return $this->db->insert_id();
    }

    public function add_breed_if_not_exists($data)
    {
        if (!$this->breeds_table_exists()) {
            return ['added' => false, 'reason' => 'Table does not exist'];
        }

        $this->db->where('name', $data['name']);
        $this->db->where('animal_type', $data['animal_type']);
        $existing = $this->db->get($this->breeds_table)->row();

        if ($existing) {
            return ['added' => false, 'reason' => 'Already exists'];
        }

        $this->db->insert($this->breeds_table, $data);
        $insert_id = $this->db->insert_id();
        
        return ['added' => true, 'id' => $insert_id];
    }

    public function update_breed($id, $data)
    {
        if (!$this->breeds_table_exists()) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->update($this->breeds_table, $data);
    }

    public function delete_breed($id)
    {
        if (!$this->breeds_table_exists()) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->breeds_table);
    }

    public function get_breed_groups()
    {
        if (!$this->breeds_table_exists()) {
            return [];
        }

        $this->db->select('size');
        $this->db->distinct();
        $this->db->where('size IS NOT NULL');
        $this->db->order_by('size', 'ASC');
        $query = $this->db->get($this->breeds_table);
        return array_column($query->result_array(), 'size');
    }

    public function count_breeds()
    {
        if (!$this->breeds_table_exists()) {
            return 0;
        }

        return $this->db->count_all_results($this->breeds_table);
    }

    public function count_vaccines()
    {
        if (!$this->vaccines_table_exists()) {
            return 0;
        }

        return $this->db->count_all_results($this->vaccines_table);
    }

    public function add_vaccine_if_not_exists($data)
    {
        if (!$this->vaccines_table_exists()) {
            return ['added' => false, 'reason' => 'Table does not exist'];
        }

        $this->db->where('name', $data['name']);
        $this->db->where('animal_type', $data['animal_type']);
        $existing = $this->db->get($this->vaccines_table)->row();

        if ($existing) {
            return ['added' => false, 'reason' => 'Already exists'];
        }

        $this->db->insert($this->vaccines_table, $data);
        $insert_id = $this->db->insert_id();
        
        return ['added' => true, 'id' => $insert_id];
    }

    public function vaccine_exists($vaccine_name, $animal_type)
    {
        if (!$this->vaccines_table_exists()) {
            return false;
        }

        $this->db->where('name', $vaccine_name);
        $this->db->where('animal_type', $animal_type);
        $query = $this->db->get($this->vaccines_table);
        
        return $query->num_rows() > 0;
    }

    public function breed_exists($breed_name, $animal_type)
    {
        if (!$this->breeds_table_exists()) {
            return false;
        }

        $this->db->where('name', $breed_name);
        $this->db->where('animal_type', $animal_type);
        $query = $this->db->get($this->breeds_table);
        
        return $query->num_rows() > 0;
    }
}
