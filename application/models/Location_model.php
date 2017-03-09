<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:31 AM
 */
class Location_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function select_all(){
        $query = $this->db->get('locations');
        $data = $query->result();
        return $data;
    }

    public function insert($data){
        if($this->db->insert('locations', $data)){
            return true;
        }
    }

    public function delete($id){
        if($this->db->delete('locations', 'id = '. $id)){
            return true;
        }
    }

    public function update($data, $old_id){
        $this->db->set($data);
        $this->db->where('id', $old_id);
        return $this->db->update('locations', $data);
    }

}
