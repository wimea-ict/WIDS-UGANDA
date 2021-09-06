<?php
class Send_email extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->config('email');
        //$this->load->library('email');
    }
    public function index() {
    //     $this->email->to('getjohnnasasira@gmail.com');
    // $this->email->from('eagerbeaverdevelopers@gmail.com', 'Identification');
    // $this->email->subject('The beavers');
    // $this->email->message('Hi, John');


     $from = $this->config->item('smtp_user');
        $to = "lwangaaksam@gmail.com";
        $subject = 'HELLO';
        $message = "YOOOOOO";

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }



        
       



















    // public function send_mail() {
    //     $from_email = "email@example.com";
    //     $to_email = $this->input->post('email');
    //     //Load email library
    //     $this->load->library('email');
    //     $this->email->from($from_email, 'Identification');
    //     $this->email->to($to_email);
    //     $this->email->subject('Send Email Codeigniter');
    //     $this->email->message('The email send using codeigniter library');
    //     //Send mail
    //     if($this->email->send())
    //         $this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
    //     else
    //         $this->session->set_flashdata("email_sent","You have encountered an error");
    //     $this->load->view('contact_email_form');
    // }
}
?>