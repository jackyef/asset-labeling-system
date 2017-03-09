<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 1:59 PM
 */
class Model_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_all(){
        $query = $this->db->get('models');
        $data = $query->result();
        return $data;
    }

    public function insert($data){
        if($this->db->insert('models', $data)){
            return true;
        }
    }

    public function delete($id){
        if($this->db->delete('models', 'id = '. $id)){
            return true;
        }
    }

    public function update($data, $old_id){
        $this->db->set($data);
        $this->db->where('id', $old_id);
        return $this->db->update('models', $data);
    }

}