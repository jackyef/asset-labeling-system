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
        // TODO: use real session data
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

        return $data;
    }

    public function index(){
        $data = $this->get_session_data();
//        echo json_encode($data);
        $data['title'] = 'ALS - Home';
        $this->parser->parse('templates/header.php', $data);

        // TODO: parse the content of this route here!
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

    public function inside(){

    }

    public function help(){
        $data = $this->get_session_data();

        $data['title'] = 'ALS - Home';
        $this->parser->parse('templates/header.php', $data);

        // TODO: parse the content of this route here!
        $this->parser->parse('home/index.php', $data);
        $this->parser->parse('templates/footer.php', $data);

    }

    public function about(){
        $data = $this->get_session_data();

        $data['title'] = 'ALS - Home';
        $this->parser->parse('templates/header.php', $data);

        // TODO: parse the content of this route here!
        $this->parser->parse('home/index.php', $data);
        $this->parser->parse('templates/footer.php', $data);

    }
}