<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 1:30 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data){
        if($this->db->insert('users', $data)){
            return true;
        }
    }

    public function delete($id){
        if($this->db->delete('users', 'user_id = '. $id)){
            return true;
        }
    }

    public function update($data, $old_id){
        $this->db->set($data);
        $this->db->where('user_id', $old_id);
        return $this->db->update('users', $data);
    }

}
