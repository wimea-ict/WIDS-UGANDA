<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Season_names extends CI_Controller
{
	
	  function __construct()
    {
        parent::__construct();
	    $this->config->set_item('theme','Ghana');
        $this->load->model('Season_names_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }


   public function index()
    { 
	  $seasons = $this->Season_names_model->get_all();
	  $data = array(
            'seasons_data' => $seasons,
			'change' => 67
        );

        $this->load->view('template', $data);
	
	}
	
	//display season form
	public function displaySeasonNameForm(){
		
	$data['change'] = 68;
	$this->load->view('template', $data);	
   }
public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=season_name.doc");

        $data = array(
          'seasons_data'=> $this->Season_names_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('season_name_doc',$data);
    }
   
   
public function pdf()
{
	$seasons = $this->Season_names_model->get_all();

	$data = array(
		'seasons_data' => $seasons,
		'start' => 0
	);
	
	ini_set('memory_limit', '10G');
	$html = $this->load->view('season_name_doc', $data, true);
	$this->load->library('pdf');
	$pdf = $this->pdf->load();
	$pdf->WriteHTML($html);
	$pdf->Output('season.pdf', 'D'); 
}
   
   
   public function saveSeasonName(){
   	    $id = $this->input->post('id');
	    $datatoinsert = array(
       		 'season_name' => $this->input->post('season_name',TRUE),
       		 'month_from' => $this->input->post('month_from',TRUE),
       		 'month_to' => $this->input->post('month_to',TRUE),
       		 'abbreviation' => $this->input->post('abbreviation',TRUE)
       		 );
	        //====== checking the presence of $id==========
		if (!is_null($id) && $this->Season_names_model->get_by_id($id)) {
            $this->Season_names_model->update($id,$datatoinsert);
             $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Season record updated Successfully!.</div>');
        } else {
         $datatoinsert1 = array(
       		 'season_name' => $this->input->post('season_name',TRUE),
       		 'month_from' => $this->input->post('month_from',TRUE),
       		 'month_to' => $this->input->post('month_to',TRUE),
       		 'abbreviation' => $this->input->post('abbreviation',TRUE)
	    );
           $this->Season_names_model->insert($datatoinsert1);
            $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Season record added Successfully!.</div>');
        }
	      

        // $this->load->view('template',$data);  
        redirect('index.php/Season_names');
	   
	 }
	 //--------- Updating  and deleting a given row---------------------
	 public function update($id=NULL)

     { 
	    $row = $this->Season_names_model->get_by_id($id);
	 
	    if ($row) { //if there is some data
            $data['change'] = 68;
			$data['seasons_data']= $row;

			$data['row_data'] =$this->Season_names_model->get_by_id($id);
            $this->load->view('template', $data);			
			
        } else {
		      redirect('index.php/Season_names');
        }
    }

     public function delete($id=NULL){
     	    $this->Season_names_model->delete($id);
     	 //if there is some data
     	    $minor_sector = $this->Season_names_model->get_all();
            $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'.$this->session->userdata('deleted').'</strong> Season deleted Successfully!.</div>');

            redirect('index.php/Season_names');		
		
	}
	//----------------------the end--------------------------------
	
}//end of the class 