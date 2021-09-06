<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Forgot_password extends CI_Controller {
    function __construct(){
        parent::__construct();

            $this->load->library('session');

        $this->load->model('Forgot_password_model');
        // $this->load->model('Minor_model','minor_model');
        // $this->load->model('Decadal_forecast_model');
    }
 
    function index(){
     //   $data['category'] = '';
        $this->load->view('auth/forgot_password.php');
    }


    public function reset()
    {
       //echo $this->input->post('email');exit();
        if($this->input->post('email'))
        {
            $email=$this->input->post('email');

            $user=$this->Forgot_password_model->get_user($email);
           
            if (sizeof($user) >0) {

                 foreach ($$user as $row) {
                     $db_email = $row['email'];
                     $db_username = $row['username'];
                     $first_name = $row['first_name'];
                     $last_name = $row['last_name'];
                      $password = $row['password'];
            }

                $data = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name
                );
            }
            

            //$row=$que->row('email');
            //$user_email=$row;
           // print_r($user_email);exit();
            if((!strcmp($email, $db_email))){

          
                $to = $user_email;
                $subject = "WIDS PASSWORD RECOVERY";
                $txt = $this->load->view('Email_templates/mytemplate.php',$data, true);
                 // $txt = "Hello ".$first_name." ".$last_name.", Your password is $decrypt_password .";

                $this-> mail($to, $subject, $txt);

                $this->session->set_flashdata('email',$to);


                $this->session->set_flashdata('success_message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Hello <b>'.$this->session->userdata($first_name).'</b>Please check your email .</div>');

                redirect('index.php/Forgot_password/index');

            }else{
                $this->session->set_flashdata('message','<center><b style="color:red">Email Not found!, Please try again!</b></center>');

                redirect('index.php/Forgot_password/index');
                

            }

        }
    }
 
}
