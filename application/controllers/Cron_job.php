<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron_job extends CI_Controller
{
	
	  function __construct()
    {
        parent::__construct();
		$this->config->set_item('theme','Ghana');
        $this->load->model('City_model');
        //$this->load->model('Division_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }


   public function index()
    { 
	 echo "string";
     $this->db->insert("cron_job",array("label"=>"amoko"));
	}
 
  } 