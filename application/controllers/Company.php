<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:18 AM
 */
class Company extends CI_Controller
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
            $this->session->set_flashdata('login_error', 'You don\'t have access to that page');
            redirect(base_url());
        }

    }

    public function get_session_data(){
        // remember use xss_clean
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

        return $data;
    }

    public function index(){
        // this shows the list of the companies in the master database

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Company';
        $this->parser->parse('templates/header.php', $data);

        $this->load->model('Company_model');
        $data['records'] = $this->Company_model->select_all();
        $this->parser->parse('companies/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);
    }

    public function company_update_form(){
        // this shows the form for updating an company

        $data = $this->get_session_data();

        $data['title'] = 'ALS - Company';
        $this->parser->parse('templates/header.php', $data);

        $id = $this->uri->segment('3');

        $query = $this->db->get_where('companies', array('id' => $id));
        $data['record'] = $query->result()[0];
        $data['id'] = $id;
        $this->load->view('companies/update_form.php', $data);

        $this->load->view('templates/footer.php');
    }

    public function company_update(){
        // this updates a company in the database

        // check if this is a POST request
        if ($this->input->method(TRUE) != 'POST'){
            // if not, just redirect
            redirect(base_url() . 'company');
        }

        $this->load->model('Company_model');
        $data = [
            'name' => $this->input->post('name', TRUE)
        ];
        $id = $this->uri->segment('4');

        if ($this->Company_model->update($data, $id)) {
            //success inserting data
            redirect(base_url() . 'company');
        } else {
            //show errors
        }
    }
}