<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Updates extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
		$this->config->set_item('theme',$this->config->item('country'));
        $this->load->model('Updates_model');
        $this->load->library('form_validation');
		$this->load->library('session');
    }

    public function index()
    { 
    $id = $this->uri->segment(3);
	$updates = $this->Updates_model->get_all($id);
	//print_r($season); exit;
	$data = array(
            'updates_data' => $updates,
			'change' => 113
        );

        $this->load->view('template', $data);
    }
	
 

	
    //create a new season
    public function create() 
    {
        $data['id'] = $this->uri->segment(3);
	    $data['change'] = 114;	
	  //  $data['region_data'] = $this->Season_model->get_all();
		$data['updates_data'] = $this->Updates_model->get_all($id);
		 
        $this->load->view('template', $data);
    }
    
    
     
    // New method
    public function save_update(){
        $id = $this->uri->segment(3);
        $datatoupdate = array(
             'overview' => $this->input->post('overview',TRUE),
             'general_forecast'=>$this->input->post('general_forecast',TRUE)
             );
        $this->Season_model->update_data($datatoupdate,$id);
        $data['season_data'] = $this->Season_model->get_all();
        $data['change'] = 15;
        $this->load->view("template", $data);
    }

    //////////////////////////////  /////////////////////////////
    
    
	
	
    //-------------------------adding data to the database------------------------------
    public function  SaveUpdates(){
        $id = $this->uri->segment(3);
         $datatoinsert = array(
             'month' => $this->input->post('month',TRUE),
			 'season_id'=>$this->input->post('forecast_id',TRUE),			
             'issue_time' => $this->input->post('issue_time',TRUE),
			 'rainfall_outlook' => $this->input->post('rainfall_outlook',TRUE),
             'further_outlook' => $this->input->post('further_outlook',TRUE),
             'impacts' => $this->input->post('impacts',TRUE),
			 'advisories' => $this->input->post('advisories',TRUE),
			 'conclusion' => $this->input->post('conclusion',TRUE)
             );
         $this->Updates_model->insert($datatoinsert);
    $data = array(
           'updates_data'=> $this->Updates_model->get_all($id),
           'change' => 113
            );
    $this->load->view('template',$data); 
    }
	//display specific area forecasts
	public function showareaforecast(){
		$id = $this->uri->segment(3);
		$data = array(
           'forecast_area_data'=> $this->Season_model->get_forecast_area($id),
           'change' => 73
            );
   		 $this->load->view('template',$data);
	
	}
	
    //------------------------------------------------------------------------------------------
    
    
	function saveforecast(){
        $date = strtotime($this->input->post('date',TRUE));
        $date_time = date('Y',$date).'-'.date('m',$date).'-'.date('d',$date);
        $filename = $_FILES['img']['name'];
        $dir = 'assets/frameworks/adminlte/img/'.$filename;
        move_uploaded_file($_FILES['img']['tmp_name'], $dir);

    $datatoinsert = array(
       		 'year' => $this->input->post('year',TRUE),
			 'general_forecast' => $this->input->post('general_forecast',TRUE),
			 'season_id' => $this->input->post('season_id',TRUE),
			 'overview' => $this->input->post('overview',TRUE),
             'issuetime' => $date_time,
             'map' => $filename
			 		    
	    );
		$this->Season_model->insert($datatoinsert);
		$data = array(
			   'season_data'=> $this->Season_model->get_all(),
			   'change' => 15,
			);
			
		//pick the seasons 
		//$data[] = 
        $this->load->view('template',$data);  	
	
}
    
 
   

    public function _rules() 
    {
	$this->form_validation->set_rules('descrip', 'Description', 'trim|required');
    $this->form_validation->set_rules('impact', 'Impact', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    

    
   


    
    //TODO: change the table primary key to autoincrement
}

/* End of file Season.php */