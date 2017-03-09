<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function index()
    {
//		$this->load->view('welcome_message');
        echo 'This is the index of the controller \'Test\' ';
        echo '<br/>';
        echo 'Below is a view rendered from the view \'Test.php\'';
        echo '<br/><br/>';
        $this->load->model('User_model');
        $this->load->helper('url');

        $this->load->view('test');
    }

    public function hello()
    {
//		$this->load->view('welcome_message');
        echo 'This is the method \'hello\' of the controller \'Test\' ';
    }

    public function insert_user_view(){

    }
    public function insert_user()
    {
        $data = array(
            'username' => 'Jacky'.rand(0,9999),
            'password' => md5('password'),
            'email'    => 'asdasd@asdsad.com'
        );
        $this->load->database();

        $result = $this->db->insert("users", $data);

        if($result){
            echo 'successfully inserted '. http_build_query($data). ' to the database';
        } else {
            echo 'insert failed!';
        }
    }

    public function updateUser()
    {
        $data = array(
            'username' => 'Jacky'.rand(0,9999),
            'password' => md5('password'),
            'email'    => 'asdasd@asdsad.com'
        );
        $this->load->database();

        $this->db->set($data);
        $this->db->where('username', 'jacky');
        $result = $this->db->update('users', $data);

        if($result){
            echo 'successfully updated '. http_build_query($data). ' to the database';
        } else {
            echo 'update failed!';
        }
    }

    public function deleteUser(){
        $this->load->database();
        $result = $this->db->delete('users', 'username = \'Jacky123\'');

        if($result){
            echo 'success';
        } else {
            echo 'failed';
        }
    }

    public function selectUser(){
        $this->load->database();
        $query = $this->db->get('users');
        $result_set = $query->result();
        if ( sizeof($result_set) > 0 ){
            echo '<table>';
            echo '<tr>';
            foreach(array_keys($result_set[0]) as $heading){
                echo '<th>';
                echo $heading;
                echo '</th';
            }
            echo '</tr>';
            foreach($result_set as $entry){
                echo '<tr>';
                echo http_build_query($entry).'<br/>';
            }
        }
    }
}
