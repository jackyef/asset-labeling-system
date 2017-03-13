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


    public function login($username, $password){
        // return false if nothing is found, or more than one record is found
        // else, return the id, username, and is_admin

        $this->db->select('u.username, u.id, u.is_admin');
        $this->db->from('users u');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $user = $this->db->get()->result();

        if(sizeof($user) != 1){
            //return false
            return false;
        }
        return $user;
    }

    public function select_all(){
        $query = $this->db->get('users');
        $data = $query->result();
        return $data;
    }

    public function insert($data){
        if($this->db->insert('users', $data)){
            return true;
        }
    }

    public function delete($id){
        if($this->db->delete('users', 'id = '. $id)){
            return true;
        }
    }

    public function update($data, $old_id){
        $this->db->set($data);
        $this->db->where('id', $old_id);
        return $this->db->update('users', $data);
    }

}
