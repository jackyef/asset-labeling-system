<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:31 AM
 */
class Mutation_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function select_all(){
        $query = $this->db->get('mutations');
        $data = $query->result();
        return $data;
    }

    public function insert($data){
        if($this->db->insert('mutations', $data)){
            return true;
        }
    }

    public function delete($id){
        if($this->db->delete('mutations', 'id = '. $id)){
            return true;
        }
    }

    public function delete_where_item_id($id){
        if($this->db->delete('mutations', 'item_id = '. $id)){
            return true;
        }
    }

    public function update($data, $old_id){
        $this->db->set($data);
        $this->db->where('id', $old_id);
        return $this->db->update('mutations', $data);
    }

    function make_query()
    {
        $query = $this->db->query("
                (
                SELECT mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, m.name as model_name,
                            i.operating_system_id
                FROM mutations mu, items i, item_types it, brands b, models m
                WHERE mu.item_id = i.id AND i.model_id = m.id AND 
                        m.brand_id = b.id AND b.item_type_id = it.id AND 
                        assembled_item_id = 0
                ORDER BY mu.id desc
                )
                UNION 
                (
                SELECT mu.*, it.name as item_type_name, it.id as item_type_id, 
                            b.name as brand_name, ai.product_name as model_name,
                            ai.operating_system_id as operating_system_id
                FROM mutations mu, assembled_items ai, item_types it, brands b
                WHERE mu.item_id = ai.id AND ai.brand_id = b.id AND b.item_type_id = it.id
                ORDER BY mu.id desc
                )
        ");

        return $query;
//        if(isset($_POST["search"]["value"]))
//        {
//            $this->db->like("mu.id", $_POST["search"]["value"]);
//            $this->db->or_like("model_name", $_POST["search"]["value"]);
//        }
//        if(isset($_POST["order"]))
//        {
//            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
//        }
//        else
//        {
//            $this->db->order_by('id', 'DESC');
//        }
    }

    function make_datatables(){
//        $this->make_query();
        if(isset($POST["length"]) && $_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->make_query();
        return $query->result();
    }

    function get_filtered_data(){
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $query = $this->make_query();
        $this->db->get();
        return $this->db->count_all_results();
    }
}
