<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:31 AM
 */
class User_permission_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function select_all(){
        $query = $this->db->get('user_permissions');
        $data = $query->result();
        return $data;
    }

    public function select_by_id($user_id){
        $array = array('user_id' => $user_id);
        $query = $this->db->get_where('user_permissions', $array);
        $data = $query->result();
        return $data;
    }

    public function insert($data){
        if($this->db->insert('user_permissions', $data)){
            return true;
        }
    }

    public function delete($id){
        if($this->db->delete('user_permissions', 'id = '. $id)){
            return true;
        }
    }

    public function update($data, $user_id, $permission_id){
        $this->db->set($data);
        $array = array('user_id' => $user_id, 'permission_id' => $permission_id);
        $this->db->where($array);
        return $this->db->update('user_permissions', $data);
    }

}
