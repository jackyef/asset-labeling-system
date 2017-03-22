<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/13/2017
 * Time: 8:56 AM
 */
class Barcode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url'); //for base_url()
        $this->load->helper('security'); // for xss_clean()
        $this->load->helper('date'); // for
        // now() returns an unix timestamp, and
        // mdate() take an unix timestamp or a date string, convert to mysql formatted date

        $this->load->library('parser');
        $this->load->library('session');
        $this->load->database();
        $this->output->enable_profiler(FALSE);

        $data = $this->get_session_data();
        if ($data['is_logged_in'] != 1){
//            $this->session->set_flashdata('login_error', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg', 'You don\'t have access to that page');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url());
        }

    }

    public function get_session_data(){
        // remember use xss_clean
//        echo json_encode($this->session->userdata());
        if($this->session->userdata('is_logged_in') == 1){
            // if a session already exist
            // pass the session data to $data, this will be passed when rendering views
            $data['session_username'] = xss_clean($this->session->userdata('session_username'));
            $data['session_user_id'] = xss_clean($this->session->userdata('session_user_id'));
            $data['session_is_admin'] = xss_clean($this->session->userdata('session_is_admin'));
            $data['is_logged_in'] = 1;
        } else {
            // else set is_logged_in = 0
            $data['is_logged_in'] = 0;
        }

        //get site_wide_msg, if exists
        $data['site_wide_msg'] = $this->session->flashdata('site_wide_msg');
        $data['site_wide_msg_type'] = $this->session->flashdata('site_wide_msg_type');

        return $data;
    }

    public function index(){
        $data = $this->get_session_data();
//        echo json_encode($data);
        $data['title'] = 'ALS - Barcode';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('barcode/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);

    }

    public function find(){
        $data = $this->get_session_data();
        // check if this is a POST request
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'barcode');
        }
//        echo json_encode($data);
        $item_code = $this->input->post('item_code', TRUE);
        $item_code = html_escape($item_code);
        $item_type_id = substr($item_code, 0, 2);
        while($item_type_id[0] == '0'){
            //remove leading zeroes
            $item_type_id = substr($item_type_id, 1);
        }

        $this->db->reset_query();
        $this->db->select('it.* ');
        $query = $this->db->get_where('item_types it', array('it.id' => $item_type_id));
        if(isset($query->result()[0])){
            $item_type = $query->result()[0];
        } else {
            $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Item type does not exist!');
            $this->session->set_flashdata('site_wide_msg_type', 'danger');
            redirect(base_url().'barcode');
        }

        $is_assembled = ($item_type->is_assembled == 1) ? true : false;

        $item_id = substr($item_code, 2); // start taking item id from the 3rd character
        while($item_id[0] == '0'){
            $item_id = substr($item_id, 1); // remove leading zeroes
        }

        if($is_assembled){
            $this->db->reset_query();
            $this->db->select('ai.* ');
            $query = $this->db->get_where('assembled_items ai', array('ai.id' => $item_id));
            if(isset($query->result()[0])){
                $item = $query->result()[0];
            } else {
                $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Item does not exist!');
                $this->session->set_flashdata('site_wide_msg_type', 'danger');
                redirect(base_url().'barcode');
            }
        } else {
            $this->db->reset_query();
            $this->db->select('i.* ');
            $query = $this->db->get_where('items i', array('i.id' => $item_id));
            if(isset($query->result()[0])){
                $item = $query->result()[0];
            } else {
                $this->session->set_flashdata('site_wide_msg', '<span class="fa fa-info-circle"></span> Item does not exist!');
                $this->session->set_flashdata('site_wide_msg_type', 'danger');
                redirect(base_url().'barcode');
            }
        }

//        echo $is_assembled;
//        echo '<br/>';
//        echo $item_type_id;
//        echo '<br/>';
//        echo $item_id;

        if($is_assembled){
            redirect(base_url().'assembled-item/detail/'.$item_id);
        } else {
            redirect(base_url().'item/detail/'.$item_id);
        }

    }
}