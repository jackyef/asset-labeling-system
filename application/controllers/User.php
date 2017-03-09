<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 3:02 PM
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->output->enable_profiler(FALSE);

    }

    public function index(){
        $this->benchmark->mark('start');
        $query = $this->db->get('users');

        $data['users'] = $query->result();
        $data['navs'] = array(
            '',
            ''
        );
        $data['title'] = "Users List";

        $this->load->helper('url');
        $this->load->library('parser');

        $this->parser->parse('templates/header.php', $data);
        $this->load->view('user/index.php', $data);
        $this->load->view('templates/footer.php', $data);

        $this->benchmark->mark('end');
//        echo 'This page is rendered in '.$this->benchmark->elapsed_time('start', 'end').' seconds.<br/>';
    }

    public function insert_view(){
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('user/insert_view.php');
    }

    public function insert(){
        $this->load->model('User_model');

        $data = [
          'user_id' => $this->input->post('user_id'),
          'username' => $this->input->post('username'),
          'password' => md5($this->input->post('password')),
          'email' => $this->input->post('email')
        ];

        //insert to db
        $this->User_model->insert($data);

        //redirect to index
        $this->load->helper('url');
        redirect(base_url().'index.php/user');
    }

    public function update_view(){
        $this->load->helper('url');
        $this->load->helper('form');
        $user_id = $this->uri->segment('3');

        $query = $this->db->get_where('users', array('user_id' => $user_id));
        $data['users'] = $query->result();
        $data['old_user_id'] = $user_id;

        $this->load->view('user/update_view.php', $data);
    }

    public function update(){
        $this->load->model('User_model');

        $old_user_id = $this->input->post('old_user_id');

        $data = [
            'user_id' => $this->input->post('user_id'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'email' => $this->input->post('email')
        ];

        $this->User_model->update($data, $old_user_id);

        echo '<br> old id: '.$old_user_id;
        $this->load->helper('url');
        redirect(base_url().'index.php/user');
    }

    public function delete(){
        $this->load->model('User_model');

        $user_id = $this->uri->segment('3');
        $this->User_model->delete($user_id);

        $this->load->helper('url');
        redirect(base_url().'index.php/user');
    }

    public function index_parse(){
        $this->load->library('parser');
        $query = $this->db->get('users');
        $data = [
            'title' => 'Example of using codeigniter template parser',
            'add_url' => base_url().'index.php/user/add',
            'edit_url' => base_url().'index.php/user/edit',
            'delete_url' => base_url().'index.php/user/delete',
            'records' => $query->result()
        ];

        $this->parser->parse('user/index_parse.php', $data);
    }
}