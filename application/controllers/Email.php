<?php

/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/7/2017
 * Time: 8:01 AM
 */
class Email extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    }

    public function index(){
        //show send email form
        $this->load->helper(array('form', 'url'));
        $this->load->view('email/email_form');
    }

    public function send_email(){
        $email_from = "jacky@codeigniter.example.com";
        $email_to = $this->input->post('email_to');
        $email_cc = $this->input->post('email_cc');
        $email_bcc = $this->input->post('email_bcc');

        $this->load->library('email');
        $this->email->from($email_from, "Jacky");
        $this->email->to($email_to);
        $this->email->cc($email_cc);
        $this->email->bcc($email_bcc);

        $this->email->subject($this->input->post('email_subject'));
        $this->email->message($this->input->post('email_content'));

        $result = $this->email->send();

        if($result) {
            $this->session->set_flashdata('email_sent', "Successfully sent email!");
        } else {
            $this->session->set_flashdata('email_sent', "Failed to send email!");
        }
        $this->load->view('email/email_form');
    }
}