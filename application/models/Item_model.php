<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:31 AM
 */
class Item_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function select_all(){
        $query = $this->db->get('items');
        $data = $query->result();
        return $data;
    }

    public function insert($data){
        if($this->db->insert('items', $data)){
            return true;
        }
    }

    public function delete($id){
        if($this->db->delete('items', 'id = '. $id)){
            return true;
        }
    }

    public function delete_where_assembled_item_id($assembled_item_id){
        if($this->db->delete('items', 'assembled_item_id = '. $assembled_item_id)){
            return true;
        }
    }

    public function update($data, $old_id){
        $this->db->set($data);
        $this->db->where('id', $old_id);
        return $this->db->update('items', $data);
    }

    public function update_where_assembled_item_id($data, $assembled_item_id){
        $this->db->set($data);
        $this->db->where('assembled_item_id', $assembled_item_id);
        return $this->db->update('items', $data);
    }

}
