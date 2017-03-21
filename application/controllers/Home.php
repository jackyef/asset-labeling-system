<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/13/2017
 * Time: 8:56 AM
 */
class Home extends CI_Controller
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
        $data['title'] = 'ALS - Home';
        $this->parser->parse('templates/header.php', $data);

        // get login error message (if any)
        $data['login_error'] = $this->session->flashdata('login_error');

//        echo '<br/>';
//        echo json_encode($data);
//        echo '<br/>';

        $this->parser->parse('home/index.php', $data);

        $this->parser->parse('templates/footer.php', $data);

    }

    public function login(){
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $this->load->model('User_model');

        $login = $this->User_model->login($username, $password);

        if ($login != false) {
            // login succeeded
            // unset previous session data
            // set session data
            $this->session->set_userdata(array(
                'session_user_id' => $login[0]->id,
                'session_username' => $login[0]->username,
                'session_is_admin' => $login[0]->is_admin,
                'is_logged_in' => 1));

            // redirect to home
//            echo json_encode($this->session->userdata());
            $this->session->set_flashdata('site_wide_msg', 'Login success, welcome back '.$username.'!');
            $this->session->set_flashdata('site_wide_msg_type', 'success');
            redirect(base_url());
        } else {
            // login failed
            // pass an error message as a flashdata
            // redirect to home
            $this->session->set_flashdata('login_error', 'Username/password incorrect.');
            redirect(base_url());
        }

    }
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function chpass(){
        if ($this->input->method(TRUE) == 'GET'){
            // check if id == the currently logged_in id
            $data = $this->get_session_data();
            $id = $this->uri->segment('3');
            if($data['is_logged_in'] != 1){
                //not logged in
                $this->session->set_flashdata('site_wide_msg', 'You don\'t have access to that page');
                $this->session->set_flashdata('site_wide_msg_type', 'danger');
                redirect(base_url());
            }
            if($data['session_user_id'] != $id){
                //if they're not the same, just redirect to correct id
                redirect(base_url().'home/chpass/'.$data['session_user_id']);
            }
            // if we reached here, we can show the form
            $data['id'] = $id;
            // check if there's any previous error messages to parse
            $errors = $this->session->flashdata('errors');
            $data['errors'] = $errors;
            // check if there's any previous messages to parse
            $msg = $this->session->flashdata('msg');
            $data['msg'] = $msg;

            // show change password form

            $data['title'] = 'ALS - Change Password';
            $this->parser->parse('templates/header.php', $data);

            $this->parser->parse('home/chpass.php', $data);

            $this->parser->parse('templates/footer.php', $data);

        } else if (($this->input->method(TRUE) == 'POST')){
            // a new change password request is submitted,
            // first, check if session_user_id is valid
            $data = $this->get_session_data();
            $id = $this->uri->segment('3');
            if($data['session_user_id'] != $id){
                //if they're not the same, just redirect to correct id
                redirect(base_url().'home/chpass/'.$data['session_user_id']);
            }

            // now we do data validations here
            //check for errors
            $errors = [];

            $password = $this->input->post('password', TRUE);
            $new_password = $this->input->post('new_password', TRUE);

            $this->db->select('u.password, u.id');
            $this->db->from('users u');
            $this->db->where('id', $id);
            $this->db->where('password', md5($password));
            $user = $this->db->get()->result();

            if(sizeof($user) != 1){
                array_push($errors, 'You typed your current password incorrectly.');
            }
            if (!ctype_alnum($new_password)){
                array_push($errors, 'Your new password can only contains alphanumeric characters!');
            }
            if (strlen($new_password) < 8 || strlen($new_password) > 32){
                array_push($errors, 'Your new password must be between 8 to 32 characters!');
            }

            if (sizeof($errors) == 0){
                //if there are still no errors at this point, try updating database
                $data = [
                    'password' => md5($new_password)
                ];
                $this->load->model('User_model');
                if ($this->User_model->update($data, $id)) {
                    //success updating data
                    $this->session->set_flashdata('msg', 'Your password is changed successfully!');
                    redirect(base_url() . 'home/chpass/'.$id);
                } else {
                    //errors!
                    $db_error = $this->db->error();
                    array_push($errors, 'A database error occured. Code: '.$db_error['code']);
                }
            }

            //if we reach this point, this means that there were still errors
            //so we show the input form again, while passing the error messages as flashdata.
            $data = $this->get_session_data();

            $this->session->set_flashdata('errors', $errors);
            redirect(base_url().'home/chpass/'.$id);

        } else {
            redirect(base_url());
        }
    }

    public function help(){
        $data = $this->get_session_data();

        $data['title'] = 'ALS - Help';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('home/help.php', $data);
        $this->parser->parse('templates/footer.php', $data);

    }

    public function about(){
        $data = $this->get_session_data();

        $data['title'] = 'ALS - About';
        $this->parser->parse('templates/header.php', $data);

        $this->parser->parse('home/about.php', $data);
        $this->parser->parse('templates/footer.php', $data);

    }
}