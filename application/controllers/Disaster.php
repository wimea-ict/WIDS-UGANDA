<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disaster extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
	$this->config->set_item('theme',$this->config->item('country'));
        $this->load->model('Disaster_model');
        $this->load->library('form_validation');
        $this->load->library('session');//Major_model		
    }

    
    public function index()
    {
    $id= $this->uri->segment(3);
    $disaster = $this->Disaster_model->get_all($id);
    $data = array(
            'change' => 109,
            'forecast_id' => $id,
            'disaster_data' => $disaster
        );

        $this->load->view('template', $data);
    }
 
    public function create()
    {
    $id= $this->uri->segment(3);
    $disaster = $this->Disaster_model->get_all($id);
    
    $data = array(
            'change' => 110,
            'disaster_data' => $disaster,
        );
    $this->load->view('template', $data);
    }
    
    public  function save()

    {
            
            $datatoinsert1 = array(
                'region_id' => $this->input->post('region_id',TRUE) ,
                'forecast_id' => $this->uri->segment(3),
             'disaster_desc' => $this->input->post('disaster_desc',TRUE)            
           );

           $this->Disaster_model->insert($datatoinsert1);
        
        //=====================================================
        $data = array(
                 'id'=> $this->uri->segment(3),
               'disaster_data'=> $this->Disaster_model->get_all($id),
               'change' => 109,
            );
        $this->load->view('template',$data);  
    }  

	
    public  function update()

    {
        $data = array(
                 'id'=> $this->uri->segment(3),
               'disaster_data'=> $this->Disaster_model->get_all($id),
               'change' => 109,
            );
        $this->load->view('template',$data);  
    }  


    

    

    

}

/* End of file Ward.php */
