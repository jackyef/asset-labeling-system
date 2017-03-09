<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 9:29 PM
 */
class Upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index(){
        $data['error'] = '';
        $this->load->view('upload/upload_form', $data);
    }

    public function do_uploading(){
        $config['upload_path'] = './uploaded_images/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 500;
        $config['max_width'] = 1920;
        $config['max_height'] = 1080;

        $this->load->library('upload', $config);


        if ( ! $this->upload->do_upload('uploaded_file')){
            $error = array('error' => $this->upload->display_errors());
            $this->load->helper('url');
            $this->load->view('upload/upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload/upload_success', $data);
        }

    }
}